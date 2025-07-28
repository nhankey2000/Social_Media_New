<?php
use Illuminate\Support\Facades\Response;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\FacebookController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\YouTubeOAuthController;
use App\Http\Controllers\ActivationKeyController;
use App\Http\Controllers\ZooController;
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
Route::get('/keys', [ActivationKeyController::class, 'index']);
Route::post('/keys', [ActivationKeyController::class, 'store']);
Route::delete('/keys/{id}', [ActivationKeyController::class, 'destroy']);
Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'show']);
Route::get('/zoo', [App\Http\Controllers\ZooController::class, 'show']);
Route::get('/check-key', function () {
    $id = request('id');
    $exists = DB::table('activation_keys')->where('hardware_id', $id)->exists();
    return response($exists ? 'OK' : 'NO', 200)
        ->header('Content-Type', 'text/plain');
});
Route::get('/storage/youtube-videos/{filename}', function ($filename) {
    $path = 'youtube-videos/' . $filename;

    if (!Storage::disk('local')->exists($path)) {
        abort(404, 'Video file not found');
    }

    $file = Storage::disk('local')->get($path);
    $mimeType = Storage::disk('local')->mimeType($path);

    return Response::make($file, 200, [
        'Content-Type' => $mimeType,
        'Content-Disposition' => 'inline; filename="' . $filename . '"',
        'Accept-Ranges' => 'bytes',
        'Cache-Control' => 'public, max-age=3600',
    ]);
})->name('storage.youtube-videos');
