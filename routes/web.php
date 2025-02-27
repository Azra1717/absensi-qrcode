<?php

use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SiswaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Form login
Route::get('/login', function () {
    return view('auth.login');
});


Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/siswa', [AdminController::class, 'index']);
    Route::get('/admin/siswa/create', [AdminController::class, 'create']);
    Route::post('/admin/siswa', [AdminController::class, 'store']);
    Route::get('/admin/siswa/{id}/edit', [AdminController::class, 'edit']);
    Route::put('/admin/siswa/{id}', [AdminController::class, 'update']);
    Route::delete('/admin/siswa/{id}', [AdminController::class, 'destroy']);
    Route::get('/admin/siswa/qrcode', function () {
        return view('siswa.absen');
    })->name('admin.siswa.qrcode');
    
    Route::post('admin/siswa/absen', [AbsensiController::class, 'scanQR'])->name('admin.siswa.absen');
    Route::get('/admin/siswa/laporan', [AdminController::class, 'laporan'])->name('admin.laporan');

});


Route::middleware(['auth', 'role:siswa'])->group(function () {
    Route::get('/siswa', [SiswaController::class, 'showQR']);
    // Route::get('/siswa/qcode', [AbsensiController::class, 'scanQR']);
    // Route::get('/siswa/qrcode', function () {
    //     return view('siswa.absen');
    // })->name('siswa.qrcode');
    
    // Route::post('/siswa/absen', [AbsensiController::class, 'scanQR'])->name('siswa.absen');
});