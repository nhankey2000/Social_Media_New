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

    // ========== THÊM CÁC METHOD SAU ĐÂY ==========

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
}
