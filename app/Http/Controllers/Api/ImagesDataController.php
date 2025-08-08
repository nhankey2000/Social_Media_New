<?php
// app/Http/Controllers/Api/ImagesDataController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ImagesData;
use Illuminate\Http\Request;

class ImagesDataController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = ImagesData::query();

            // Filter by type if provided
            if ($request->has('type')) {
                $query->where('type', $request->type);
            }

            $images = $query->orderBy('created_at', 'desc')->get();

            return response()->json([
                'success' => true,
                'data' => $images
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
            $image = ImagesData::with('dataPost')->findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => $image
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy media'
            ], 404);
        }
    }
}
