<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\YouTubeVideo;
use Google_Client;
use Google_Service_YouTube;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UploadYouTubeVideoJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 1800; // 30 phút timeout cho video lớn
    public $tries = 3; // Thử lại tối đa 3 lần

    /**
     * Create a new job instance.
     */
    public function __construct(
        public YouTubeVideo $video
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            Log::info('Starting YouTube upload job', [
                'video_id' => $this->video->id,
                'title' => $this->video->title
            ]);

            // Cập nhật trạng thái đang upload
            $this->video->update(['upload_status' => 'uploading']);

            $platformAccount = $this->video->platformAccount;
            if (!$platformAccount) {
                throw new \Exception('Không tìm thấy kênh YouTube.');
            }

            // Kiểm tra file video
            if (!$this->video->video_file || !Storage::disk('local')->exists($this->video->video_file)) {
                throw new \Exception('File video không tồn tại.');
            }

            $client = new Google_Client();
            $client->setAccessToken(json_decode($platformAccount->access_token, true));

            // Kiểm tra và refresh token nếu hết hạn
            if ($client->isAccessTokenExpired()) {
                $facebookAccount = DB::table('facebook_accounts')
                    ->where('platform_id', 3)
                    ->first();

                if (!$facebookAccount) {
                    throw new \Exception('Không tìm thấy thông tin ứng dụng YouTube.');
                }

                $client->setClientId($facebookAccount->app_id);
                $client->setClientSecret($facebookAccount->app_secret);
                $client->setRedirectUri($facebookAccount->redirect_url);
                $client->refreshToken($client->getRefreshToken());

                $newToken = $client->getAccessToken();
                $platformAccount->update(['access_token' => json_encode($newToken)]);
            }

            $youtube = new Google_Service_YouTube($client);

            // Tạo video object
            $videoObj = new \Google_Service_YouTube_Video();
            $snippet = new \Google_Service_YouTube_VideoSnippet();
            $snippet->setTitle($this->video->title);
            $snippet->setDescription($this->video->description);
            $snippet->setCategoryId($this->video->category_id);
            $videoObj->setSnippet($snippet);

            $status = new \Google_Service_YouTube_VideoStatus();
            $status->setPrivacyStatus($this->video->status);
            $videoObj->setStatus($status);

            // Upload file
            $videoPath = Storage::disk('local')->path($this->video->video_file);
            $chunkSizeBytes = 1 * 1024 * 1024; // 1MB

            Log::info('Starting video upload to YouTube', [
                'video_id' => $this->video->id,
                'file_size' => filesize($videoPath)
            ]);

            $client->setDefer(true);
            $insertRequest = $youtube->videos->insert('snippet,status', $videoObj);

            $media = new \Google_Http_MediaFileUpload(
                $client,
                $insertRequest,
                'video/*',
                null,
                true,
                $chunkSizeBytes
            );
            $media->setFileSize(filesize($videoPath));

            $uploadStatus = false;
            $handle = fopen($videoPath, 'rb');
            while (!$uploadStatus && !feof($handle)) {
                $chunk = fread($handle, $chunkSizeBytes);
                $uploadStatus = $media->nextChunk($chunk);
            }
            fclose($handle);

            $client->setDefer(false);

            // Cập nhật thông tin video sau khi upload thành công
            $this->video->update([
                'video_id' => $uploadStatus['id'],
                'upload_status' => 'uploaded',
                'uploaded_at' => now(),
                'upload_error' => null
            ]);

            // Xóa file sau khi upload thành công
            Storage::disk('local')->delete($this->video->video_file);

            Log::info('YouTube video uploaded successfully via job', [
                'video_id' => $this->video->id,
                'youtube_id' => $uploadStatus['id'],
                'title' => $this->video->title
            ]);

        } catch (\Exception $e) {
            // Cập nhật trạng thái lỗi
            $this->video->update([
                'upload_status' => 'failed',
                'upload_error' => $e->getMessage()
            ]);

            Log::error('YouTube upload job failed', [
                'video_id' => $this->video->id,
                'title' => $this->video->title,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            // Ném lại exception để job biết là failed
            throw $e;
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error('YouTube upload job failed permanently', [
            'video_id' => $this->video->id,
            'title' => $this->video->title,
            'error' => $exception->getMessage()
        ]);

        $this->video->update([
            'upload_status' => 'failed',
            'upload_error' => 'Job failed after ' . $this->tries . ' attempts: ' . $exception->getMessage()
        ]);
    }
}
