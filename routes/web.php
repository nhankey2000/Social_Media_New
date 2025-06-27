<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\FacebookController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\YouTubeOAuthController;
use App\Models\YouTubeVideo;
Route::get('/', function () {
    return view('welcome');
});


// Route để lấy dữ liệu biểu đồ
Route::get('/analytics/growth-chart-data', [AnalyticsController::class, 'getGrowthChartData'])->name('analytics.growth-chart-data');

// Route để hiển thị trang chứa biểu đồ
Route::get('/admin/analytics/growth', function () {
    return view('admin.analytics.growth');
})->name('admin.analytics.growth');

Route::post('/chatbot', [ChatbotController::class, 'handleMessage']);
Route::get('/facebook/redirect', [FacebookController::class, 'redirectToFacebook'])->name('facebook.redirect');
Route::get('/facebook/callback', [FacebookController::class, 'handleFacebookCallback'])->name('facebook.callback');
Route::get('/youtube/auth', [YouTubeOAuthController::class, 'redirectToGoogle']);
Route::get('/youtube/callback', [YouTubeOAuthController::class, 'handleGoogleCallback']);


Route::get('/admin/youtube-videos/{record}/video', function (YouTubeVideo $record) {
    if (!$record->video_file || !Storage::disk('local')->exists($record->video_file)) {
        abort(404, 'Video file not found');
    }

    $path = $record->video_file;
    $file = Storage::disk('local')->get($path);
    $mimeType = Storage::disk('local')->mimeType($path);
    $filename = basename($path);

    return Response::make($file, 200, [
        'Content-Type' => $mimeType,
        'Content-Disposition' => 'inline; filename="' . $filename . '"',
        'Accept-Ranges' => 'bytes',
    ]);
})->name('filament.admin.resources.you-tube-videos.video');
