<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataPost extends Model
{
    use HasFactory;

    protected $table = 'data_post';

    protected $primaryKey = 'id';

    protected $fillable = [
        'title',
        'content',
        'type',
    ];

    public function imagesData()
    {
        return $this->hasMany(ImagesData::class, 'post_id', 'id');
    }
}
