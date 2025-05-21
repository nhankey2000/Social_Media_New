<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AiPostPrompt extends Model
{
    protected $fillable = [
        'prompt',
        'platform_id', 
        'image_category',
        'image',
        'image_count',
        'scheduled_at',
       'user_id',
        'status',
        'generated_content',
        'post_option', 
        'selected_pages', 
        'title',
        'hashtags', 
        'posted_at',
        'image_settings', // Đã có
    ];

    protected $casts = [
        'image' => 'array',
        'scheduled_at' => 'datetime',
        'posted_at' => 'datetime',
      'image_settings' => 'array', // Đã có
        'selected_pages' => 'array', // Chuyển đổi JSON thành mảng
        'hashtags' => 'array', // Cast hashtags thành array
    ];

    public function platform()
    {
        return $this->belongsTo(Platform::class, 'platform_id');
    }
    public function category()
    {
        return $this->belongsTo(Category::class, 'image_category');
    }
    public function repeatSchedules()
    {
        return $this->hasMany(RepeatScheduled::class, 'ai_post_prompts_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}