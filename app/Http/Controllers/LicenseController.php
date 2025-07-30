<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\License;
use Carbon\Carbon;

class LicenseController extends Controller
{
    public function index()
    {
        $licenses = License::all();
        return view('licenses.index', compact('licenses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'machine_id' => 'required|string|unique:licenses,machine_id',
            'expires_at' => 'required|date',
        ]);

        License::create([
            'name' => $request->name,
            'machine_id' => $request->machine_id,
            'expires_at' => $request->expires_at,
        ]);

        return redirect()->route('licenses.index')->with('success', 'Đã thêm bản quyền mới!');
    }
}
