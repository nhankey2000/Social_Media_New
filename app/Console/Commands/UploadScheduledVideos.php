<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\YouTubeVideo;
use App\Jobs\UploadYouTubeVideoJob;
use Illuminate\Support\Facades\Log;

class UploadScheduledVideos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'youtube:upload-scheduled
                            {--limit=5 : Số lượng video tối đa upload mỗi lần chạy}
                            {--dry-run : Chỉ hiển thị video sẽ được upload, không thực hiện upload}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Upload scheduled YouTube videos automatically';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $limit = (int) $this->option('limit');
        $dryRun = $this->option('dry-run');

        $this->info('🔍 Tìm kiếm video cần upload...');

        // Lấy danh sách video cần upload
        $videos = YouTubeVideo::pendingUpload()
            ->with('platformAccount')
            ->orderBy('scheduled_at')
            ->limit($limit)
            ->get();

        if ($videos->isEmpty()) {
            $this->info('✅ Không có video nào cần upload vào thời điểm này.');
            return 0;
        }

        $this->info("📹 Tìm thấy {$videos->count()} video cần upload:");
        $this->newLine();

        // Hiển thị danh sách video
        $headers = ['ID', 'Tiêu đề', 'Kênh', 'Lịch đăng', 'Trạng thái'];
        $rows = [];

        foreach ($videos as $video) {
            $rows[] = [
                $video->id,
                $this->truncate($video->title, 40),
                $video->platformAccount->name ?? 'N/A',
                $video->scheduled_at->format('d/m/Y H:i'),
                $video->upload_status ?? 'pending'
            ];
        }

        $this->table($headers, $rows);

        if ($dryRun) {
            $this->warn('🧪 Chế độ dry-run: Không thực hiện upload thực tế.');
            return 0;
        }

        // Xác nhận trước khi upload
        if (!$this->confirm('Bạn có muốn tiếp tục upload các video này?')) {
            $this->info('❌ Đã hủy upload.');
            return 0;
        }

        $this->info('🚀 Bắt đầu upload...');
        $this->newLine();

        $successCount = 0;
        $failCount = 0;

        foreach ($videos as $video) {
            $this->info("📤 Đang xử lý: {$video->title}");

            try {
                // Kiểm tra file tồn tại
                if (!$video->video_file || !\Illuminate\Support\Facades\Storage::disk('local')->exists($video->video_file)) {
                    throw new \Exception('File video không tồn tại');
                }

                // Dispatch job để upload
                UploadYouTubeVideoJob::dispatch($video);

                // Cập nhật trạng thái ngay lập tức
                $video->update(['upload_status' => 'uploading']);

                $successCount++;
                $this->info("   ✅ Đã thêm vào queue");

                Log::info('Video added to upload queue', [
                    'video_id' => $video->id,
                    'title' => $video->title,
                    'scheduled_at' => $video->scheduled_at
                ]);

            } catch (\Exception $e) {
                $failCount++;
                $this->error("   ❌ Lỗi: {$e->getMessage()}");

                // Cập nhật trạng thái lỗi
                $video->update([
                    'upload_status' => 'failed',
                    'upload_error' => $e->getMessage()
                ]);

                Log::error('Failed to queue video for upload', [
                    'video_id' => $video->id,
                    'title' => $video->title,
                    'error' => $e->getMessage()
                ]);
            }
        }

        $this->newLine();
        $this->info("🎯 Kết quả:");
        $this->info("   ✅ Thành công: {$successCount}");
        if ($failCount > 0) {
            $this->error("   ❌ Thất bại: {$failCount}");
        }

        if ($successCount > 0) {
            $this->info("📋 Video đã được thêm vào queue. Chạy 'php artisan queue:work' để xử lý.");
        }

        return $failCount > 0 ? 1 : 0;
    }

    /**
     * Truncate text to specified length
     */
    private function truncate(string $text, int $length): string
    {
        if (strlen($text) <= $length) {
            return $text;
        }

        return substr($text, 0, $length - 3) . '...';
    }
}
