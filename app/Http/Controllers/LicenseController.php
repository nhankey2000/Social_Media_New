<?php

namespace App\Http\Controllers;

use App\Models\License;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class LicenseController extends Controller
{
    public function index()
    {
        $licenses = License::orderBy('created_at', 'desc')->get();

        // Statistics
        $totalLicenses = $licenses->count();
        $activeLicenses = $licenses->filter(fn($license) => $license->isValid())->count();
        $expiredLicenses = $totalLicenses - $activeLicenses;
        $expiringNext7Days = $licenses->filter(function($license) {
            $daysLeft = $license->daysLeft();
            return $daysLeft > 0 && $daysLeft <= 7;
        })->count();

        return view('licenses.index', compact(
            'licenses',
            'totalLicenses',
            'activeLicenses',
            'expiredLicenses',
            'expiringNext7Days'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'machine_id' => 'required|string|max:255|unique:licenses,machine_id',
            'expires_at' => 'required|date|after:today',
        ]);

        License::create([
            'name' => $request->name,
            'machine_id' => $request->machine_id,
            'expires_at' => $request->expires_at,
        ]);

        return redirect()->route('licenses.index')
            ->with('success', "Đã thêm bản quyền cho {$request->name} thành công!");
    }

    public function destroy($id)
    {
        $license = License::findOrFail($id);
        $name = $license->name;
        $license->delete();

        return redirect()->route('licenses.index')
            ->with('success', "Đã xóa bản quyền của {$name} thành công!");
    }

    public function extend(Request $request, $id)
    {
        $request->validate([
            'days' => 'required|integer|min:1|max:365',
        ]);

        $license = License::findOrFail($id);
        $currentExpire = Carbon::parse($license->expires_at);

        if ($currentExpire->lt(Carbon::now())) {
            $newExpire = Carbon::now()->addDays((int) $request->days);
        } else {
            $newExpire = $currentExpire->addDays((int) $request->days);
        }

        $license->update(['expires_at' => $newExpire]);

        return redirect()->route('licenses.index')
            ->with('success', "Đã gia hạn {$request->days} ngày cho {$license->name}!");
    }
}
