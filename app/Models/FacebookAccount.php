<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FacebookAccount extends Model
{
    protected $fillable = [
        'platform_id',
        'app_id',
        'app_secret',
        'access_token',
        'redirect_url'
    ];
    public function platform()
    {
        return $this->belongsTo(Platform::class);
    }
}
