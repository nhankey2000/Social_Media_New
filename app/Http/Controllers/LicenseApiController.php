<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\License;
use Carbon\Carbon;

class LicenseApiController extends Controller
{
    public function check(Request $request)
    {
        $machineId = $request->query('id');

        $license = License::where('machine_id', $machineId)->first();

        if (!$license) {
            return response()->json([
                'name' => null,
                'expire_in_days' => 0
            ]);
        }

        $now = Carbon::now();
        $expireAt = Carbon::parse($license->expire_at);
        $daysLeft = $expireAt->greaterThanOrEqualTo($now) ? $now->diffInDays($expireAt) : 0;

        return response()->json([
            'name' => $license->name,
            'expire_in_days' => $daysLeft
        ]);
    }
}
