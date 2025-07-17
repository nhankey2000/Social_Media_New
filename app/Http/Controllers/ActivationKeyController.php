<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ActivationKey;

class ActivationKeyController extends Controller
{
    public function index()
    {
        $keys = ActivationKey::all();
        return view('keys', compact('keys'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'hardware_id' => 'required|unique:activation_keys'
        ]);

        ActivationKey::create([
            'hardware_id' => $request->hardware_id
        ]);

        return redirect('/keys');
    }

    public function destroy($id)
    {
        ActivationKey::destroy($id);
        return redirect('/keys');
    }
}
