<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class SiswaController extends Controller
{
    public function showQR() {
        $siswa = Auth::user();
        return view('siswa.qrcode', compact('siswa'));
    }
}
