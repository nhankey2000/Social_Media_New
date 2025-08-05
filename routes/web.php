<?php

use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\FacebookController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\YouTubeOAuthController;
use App\Http\Controllers\ActivationKeyController;
use App\Http\Controllers\ZooController;
use App\Http\Controllers\LicenseController;
use App\Models\YouTubeVideo;
use App\Models\License;
use App\Http\Controllers\KhuVuonMaQuaiController;
use App\Http\Controllers\SoTayChanNuoiController;
use App\Http\Controllers\BanhXeoCoTuController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Redirect root to licenses management
Route::get('/', function () {
    return redirect()->route('licenses.index');
});

// Analytics routes
Route::get('/analytics/growth-chart-data', [AnalyticsController::class, 'getGrowthChartData'])->name('analytics.growth-chart-data');
Route::get('/admin/analytics/growth', function () {
    return view('admin.analytics.growth');
})->name('admin.analytics.growth');

// Social media routes
Route::post('/chatbot', [ChatbotController::class, 'handleMessage']);
Route::get('/facebook/redirect', [FacebookController::class, 'redirectToFacebook'])->name('facebook.redirect');
Route::get('/facebook/callback', [FacebookController::class, 'handleFacebookCallback'])->name('facebook.callback');
Route::get('/youtube/auth', [YouTubeOAuthController::class, 'redirectToGoogle']);
Route::get('/youtube/callback', [YouTubeOAuthController::class, 'handleGoogleCallback']);

// Legacy activation keys (for backward compatibility)
Route::get('/keys', [ActivationKeyController::class, 'index']);
Route::post('/keys', [ActivationKeyController::class, 'store']);
Route::delete('/keys/{id}', [ActivationKeyController::class, 'destroy']);

// Profile and Zoo
Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'show']);
Route::get('/zoo', [App\Http\Controllers\ZooController::class, 'show']);
// Night Hunters - Khu Vườn Ma Quái

Route::get('/khu-vuon-ma-quai', [KhuVuonMaQuaiController::class, 'index'])->name('khuvuonmaquai');

Route::get('/so-tay-chan-nuoi', [SoTayChanNuoiController::class, 'index'])->name('sotaychannuoi');

Route::get('/banh-xeo-co-tu', [BanhXeoCoTuController::class, 'index'])->name('banhxeocotu');
/*
|--------------------------------------------------------------------------
| License Management Routes (New System)
|--------------------------------------------------------------------------
*/

// API kiểm tra bản quyền - cho Python client
Route::get('/check-key', function (Request $request) {
    $machineId = $request->query('machine_id');
    $id = $request->query('id'); // Backward compatibility

    // Use machine_id if available, otherwise fall back to id
    $lookupId = $machineId ?: $id;

    if (!$lookupId) {
        return response()->json(['error' => 'missing_machine_id'], 400);
    }

    // First check new licenses table
    $license = License::where('machine_id', $lookupId)->first();

    if ($license) {
        $now = Carbon::now();
        $expire = Carbon::parse($license->expires_at);

        if ($expire->lt($now)) {
            return response()->json(['error' => 'expired'], 403);
        }

        return response()->json([
            'name' => $license->name,
            'expire_in_days' => $now->diffInDays($expire),
        ]);
    }

    // Fallback to old activation_keys table for backward compatibility
    $exists = DB::table('activation_keys')->where('hardware_id', $lookupId)->exists();

    if ($exists) {
        // Return legacy format for old clients
        if ($request->expectsJson() || $request->query('format') === 'json') {
            return response()->json([
                'name' => 'Legacy User',
                'expire_in_days' => 999, // Legacy keys don't expire
            ]);
        } else {
            return response('OK', 200)->header('Content-Type', 'text/plain');
        }
    }

    return response()->json(['error' => 'not_found'], 404);
});

// License management web interface
Route::get('/licenses', [LicenseController::class, 'index'])->name('licenses.index');
Route::post('/licenses', [LicenseController::class, 'store'])->name('licenses.store');
Route::delete('/licenses/{id}', [LicenseController::class, 'destroy'])->name('licenses.destroy');
Route::post('/licenses/{id}/extend', [LicenseController::class, 'extend'])->name('licenses.extend');

/*
|--------------------------------------------------------------------------
| Storage Routes
|--------------------------------------------------------------------------
*/

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
