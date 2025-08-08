<?php
// app/Http/Controllers/Api/DataPostController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DataPost;
use Illuminate\Http\Request;

class DataPostController extends Controller
{
    public function index()
    {
        try {
            $posts = DataPost::with('imagesData')
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $posts
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi tải dữ liệu: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $post = DataPost::with('imagesData')->findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => $post
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy bài viết'
            ], 404);
        }
    }
}
