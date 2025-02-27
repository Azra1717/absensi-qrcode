<?php

use App\Http\Controllers\Api\AbsensiController;
use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\SiswaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::get('/admin/siswa', [AdminController::class, 'index']);
    Route::post('/admin/siswa', [AdminController::class, 'store']);
    Route::get('/admin/siswa/{id}', [AdminController::class, 'show']);
    Route::put('/admin/siswa/{id}', [AdminController::class, 'update']);
    Route::delete('/admin/siswa/{id}', [AdminController::class, 'destroy']);
    Route::get('/admin/laporan', [AdminController::class, 'laporan']);
    Route::post('/admin/scanQr', [AbsensiController::class, 'scanQR']);
});



Route::middleware(['auth:sanctum', 'role:siswa'])->group(function () {
    Route::get('/siswa/qrcode', [SiswaController::class, 'showQR']);
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/me', [AuthController::class, 'me']);
Route::post('/logout', [AuthController::class, 'logout']);

// Protected Routes (Harus Login)
// Route::middleware('auth:sanctum')->group(function () {
// });