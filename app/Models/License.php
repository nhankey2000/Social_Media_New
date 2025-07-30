<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class License extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'machine_id',
        'expires_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    public function isValid()
    {
        return $this->expires_at > Carbon::now();
    }

    public function daysLeft()
    {
        $now = Carbon::now();
        $expire = $this->expires_at;

        if ($expire->lt($now)) {
            return 0;
        }

        return $now->diffInDays($expire);
    }

    public function getStatusAttribute()
    {
        $daysLeft = $this->daysLeft();

        if ($daysLeft <= 0) {
            return ['text' => 'Hết hạn', 'class' => 'danger'];
        } elseif ($daysLeft <= 7) {
            return ['text' => "Còn {$daysLeft} ngày", 'class' => 'warning'];
        } else {
            return ['text' => "Còn {$daysLeft} ngày", 'class' => 'success'];
        }
    }
}
