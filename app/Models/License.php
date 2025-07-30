<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class License extends Model
{
    use HasFactory;

    protected $fillable = [
        'machine_id',
        'name',
        'expires_at',
    ];
}
