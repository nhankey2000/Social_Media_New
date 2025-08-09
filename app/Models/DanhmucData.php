<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DanhmucData extends Model
{
    use HasFactory;

    protected $table = 'danhmuc_data';

    protected $primaryKey = 'id';

    protected $fillable = [
        'ten_danh_muc', // Các trường bạn muốn thêm vào bảng
    ];

    // Mối quan hệ hasMany với DataPost
    public function dataPosts()
    {
        return $this->hasMany(DataPost::class, 'id_danhmuc_data', 'id');
    }

    // Mối quan hệ hasMany với ImagesData
    public function imagesData()
    {
        return $this->hasMany(ImagesData::class, 'id_danhmuc_data', 'id');
    }
}
