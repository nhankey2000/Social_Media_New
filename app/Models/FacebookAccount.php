<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FacebookAccount extends Model
{
    protected $fillable = [
        'app_id',
        'app_secret',
        'access_token',
    ];
}