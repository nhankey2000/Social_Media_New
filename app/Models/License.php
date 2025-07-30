<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // ✅ Thêm dòng này
use Illuminate\Database\Eloquent\Model;

class License extends Model
{
    use HasFactory; // ✅ Sử dụng trait

    protected $fillable = [
        'machine_id',
        'name',
        'expires_at',
    ];
}
