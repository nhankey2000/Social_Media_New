<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\License;
use Illuminate\Support\Carbon;

// Route kiểm tra bản quyền
Route::get('/check-key', function (Request $request) {
    $machineId = $request->query('machine_id');

    if (!$machineId) {
        return response()->json(['error' => 'missing_machine_id'], 400);
    }

    $license = License::where('machine_id', $machineId)->first();

    if (!$license) {
        return response()->json(['error' => 'not_found'], 404);
    }

    $now = Carbon::now();
    $expire = Carbon::parse($license->expires_at);

    if ($expire->lt($now)) {
        return response()->json(['error' => 'expired'], 403);
    }

    return response()->json([
        'name' => $license->name,
        'expire_in_days' => $now->diffInDays($expire),
    ]);
});

// Route hiển thị danh sách bản quyền
Route::get('/licenses', function () {
    $licenses = License::all();
    return view('licenses.index', compact('licenses'));
})->name('licenses.index');

// Route thêm bản quyền mới
Route::post('/licenses', function (Request $request) {
    $request->validate([
        'name' => 'required|string|max:255',
        'machine_id' => 'required|string|max:255|unique:licenses',
        'expires_at' => 'required|date|after:today',
    ]);

    License::create([
        'name' => $request->name,
        'machine_id' => $request->machine_id,
        'expires_at' => $request->expires_at,
    ]);

    return redirect()->route('licenses.index')->with('success', 'Đã thêm bản quyền thành công!');
})->name('licenses.store');
