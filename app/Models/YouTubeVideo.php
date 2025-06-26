<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class YouTubeVideo extends Model
{
    protected $table = 'youtube_videos'; // Chỉ định tên bảng đúng

    protected $fillable = [
        'platform_account_id',
        'video_id',
        'title',
        'description',
        'category_id',
        'status',
    ];

    public function platformAccount(): BelongsTo
    {
        return $this->belongsTo(PlatformAccount::class);
    }
}
