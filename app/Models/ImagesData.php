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
        'id_danhmuc_data', // Thêm cột mới
    ];

    // Mối quan hệ belongsTo với DataPost
    public function dataPost()
    {
        return $this->belongsTo(DataPost::class, 'post_id', 'id');
    }

    // Mối quan hệ belongsTo với DanhmucData
    public function danhmucData()
    {
        return $this->belongsTo(DanhmucData::class, 'id_danhmuc_data', 'id');
    }
}
