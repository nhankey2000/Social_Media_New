<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BanhXeoCoTuController extends Controller
{
    /**
     * Hiển thị trang khu vườn ma quái
     */
    public function index()
    {
        return view('banhxeocotu'); // Bỏ 'licenses.'
    }
}
