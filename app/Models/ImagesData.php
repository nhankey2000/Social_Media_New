<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImagesData extends Model
{
    use HasFactory;

    protected $table = 'images_data';

    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'post_id',
        'type',
        'url',
    ];

    public function dataPost()
    {
        return $this->belongsTo(DataPost::class, 'post_id', 'id');
    }
}
