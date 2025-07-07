<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Carbon\Carbon;

class YouTubeVideo extends Model
{
    protected $table = 'youtube_videos';

    protected $fillable = [
        'platform_account_id',
        'video_id',
        'title',
        'video_file',
        'description',
        'category_id',
        'status',
        'video_type',
        'scheduled_at',
        'upload_status',
        'upload_error',
        'uploaded_at',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'uploaded_at' => 'datetime',
    ];

    public function platformAccount(): BelongsTo
    {
        return $this->belongsTo(PlatformAccount::class);
    }

    // ========== CÁC METHOD HIỆN TẠI ==========

    // Scope để lấy video cần đăng
    public function scopePendingUpload($query)
    {
        return $query->whereNull('video_id')
            ->where('upload_status', 'pending')
            ->whereNotNull('scheduled_at')
            ->where('scheduled_at', '<=', now());
    }

    // Scope để lấy video đã lên lịch
    public function scopeScheduled($query)
    {
        return $query->whereNotNull('scheduled_at')
            ->whereNull('video_id');
    }

    // Kiểm tra video có đã được đăng chưa
    public function isUploaded(): bool
    {
        return !is_null($this->video_id);
    }

    // Kiểm tra video có đang chờ đăng không
    public function isPending(): bool
    {
        return $this->upload_status === 'pending' && is_null($this->video_id);
    }

    // Kiểm tra video có sẵn sàng đăng không
    public function isReadyToUpload(): bool
    {
        return $this->isPending()
            && !is_null($this->scheduled_at)
            && $this->scheduled_at <= now();
    }

    // Attribute để hiển thị trạng thái upload
    protected function uploadStatusText(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->isUploaded()) {
                    return 'Đã đăng';
                }

                if (is_null($this->scheduled_at)) {
                    return 'Chưa lên lịch';
                }

                if ($this->scheduled_at > now()) {
                    return 'Đã lên lịch';
                }

                if ($this->upload_status === 'uploading') {
                    return 'Đang đăng';
                }

                if ($this->upload_status === 'failed') {
                    return 'Lỗi đăng';
                }

                return 'Chờ đăng';
            }
        );
    }

    // Attribute để hiển thị màu trạng thái
    protected function uploadStatusColor(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->isUploaded()) {
                    return 'success';
                }

                if (is_null($this->scheduled_at)) {
                    return 'gray';
                }

                if ($this->scheduled_at > now()) {
                    return 'info';
                }

                if ($this->upload_status === 'uploading') {
                    return 'warning';
                }

                if ($this->upload_status === 'failed') {
                    return 'danger';
                }

                return 'primary';
            }
        );
    }

    // ========== THÊM CÁC METHOD MỚI CHO VIDEO TYPE ==========

    // Kiểm tra video có phải Shorts không
    public function isShort(): bool
    {
        return $this->video_type === 'short';
    }

    // Kiểm tra video có phải video dài không
    public function isLong(): bool
    {
        return $this->video_type === 'long' || is_null($this->video_type);
    }

    // Scope để lấy video Shorts
    public function scopeShorts($query)
    {
        return $query->where('video_type', 'short');
    }

    // Scope để lấy video dài
    public function scopeLongVideos($query)
    {
        return $query->where('video_type', 'long');
    }

    // Attribute để hiển thị text loại video
    protected function videoTypeText(): Attribute
    {
        return Attribute::make(
            get: function () {
                return match($this->video_type) {
                    'short' => 'YouTube Shorts',
                    'long' => 'Video Dài',
                    default => 'Video Dài',
                };
            }
        );
    }

    // Attribute để hiển thị icon loại video
    protected function videoTypeIcon(): Attribute
    {
        return Attribute::make(
            get: function () {
                return match($this->video_type) {
                    'short' => 'heroicon-o-bolt',
                    'long' => 'heroicon-o-video-camera',
                    default => 'heroicon-o-video-camera',
                };
            }
        );
    }

    // Attribute để hiển thị màu loại video
    protected function videoTypeColor(): Attribute
    {
        return Attribute::make(
            get: function () {
                return match($this->video_type) {
                    'short' => 'warning',
                    'long' => 'info',
                    default => 'info',
                };
            }
        );
    }

    // Method để get description được format cho Shorts
    public function getFormattedDescription(): string
    {
        $description = $this->description;

        if ($this->isShort() && !str_contains(strtolower($description), '#shorts')) {
            $description = "#Shorts\n\n" . $description;
        }

        return $description;
    }

    // Method để tự động tạo tags cho Shorts
    public function getAutoTags(): array
    {
        $tags = [];

        if ($this->isShort()) {
            $tags = ['Shorts', 'YouTubeShorts', 'Short', 'Viral', 'Trending'];
        }

        // Extract hashtags từ description
        if ($this->description) {
            preg_match_all('/#(\w+)/', $this->description, $matches);
            if (!empty($matches[1])) {
                foreach ($matches[1] as $tag) {
                    if (!in_array(strtolower($tag), array_map('strtolower', $tags)) && count($tags) < 10) {
                        $tags[] = ucfirst(strtolower($tag));
                    }
                }
            }
        }

        return array_unique($tags);
    }

    // Method để get category tối ưu
    public function getOptimizedCategoryId(): string
    {
        if ($this->isShort()) {
            return '24'; // Entertainment - tốt nhất cho Shorts
        }

        return $this->category_id;
    }

    // Method để get thời lượng khuyến nghị
    public function getRecommendedDuration(): string
    {
        return match($this->video_type) {
            'short' => 'Tối đa 60 giây',
            'long' => 'Không giới hạn',
            default => 'Không giới hạn',
        };
    }

    // Method để get định dạng khuyến nghị
    public function getRecommendedFormat(): string
    {
        return match($this->video_type) {
            'short' => 'Video dọc (9:16), MP4 khuyến nghị',
            'long' => 'Video ngang (16:9), MP4/WebM',
            default => 'MP4, MPEG hoặc WebM',
        };
    }
}
