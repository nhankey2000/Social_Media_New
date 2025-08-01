<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SoTayChanNuoiController extends Controller
{
    /**
     * Hiển thị trang khu vườn ma quái
     */
    public function index()
    {
        return view('sotaychannuoi'); // Bỏ 'licenses.'
    }
}
