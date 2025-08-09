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
        'id_danhmuc_data', // Thêm cột mới
    ];

    // Mối quan hệ hasMany với ImagesData
    public function imagesData()
    {
        return $this->hasMany(ImagesData::class, 'post_id', 'id');
    }

    // Mối quan hệ belongsTo với DanhmucData
    public function danhmucData()
    {
        return $this->belongsTo(DanhmucData::class, 'id_danhmuc_data', 'id');
    }

}
