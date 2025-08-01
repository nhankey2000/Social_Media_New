<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KhuVuonMaQuaiController extends Controller
{
    /**
     * Hiển thị trang khu vườn ma quái
     */
    public function index()
    {
        return view('khuvuonmaquai'); // Bỏ 'licenses.'
    }
}
