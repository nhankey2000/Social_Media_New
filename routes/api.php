<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\License;
use Illuminate\Support\Carbon;


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
