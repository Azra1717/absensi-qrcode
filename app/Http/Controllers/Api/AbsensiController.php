<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Absen;
use Carbon\Carbon;

class AbsensiController extends Controller
{
    public function scanQR(Request $request)
    {
        
        $request->validate([
            'siswa_nis' => 'required|string',
        ]);

        
        $siswa = User::where('nis', $request->siswa_nis)->first();

        if (!$siswa) {
            return response()->json([
                'statusCode' => 404,
                'status' => 'error',
                'message' => 'Siswa tidak ditemukan!',
            ], 404);
        }
        
        $existingAbsensi = Absen::where('siswa_id', $siswa->id)
            ->whereDate('tanggal', Carbon::today())
            ->first();

        if ($existingAbsensi) {
            return response()->json([
                'statusCode' => 400,
                'status' => 'error',
                'message' => 'Siswa sudah absen hari ini.',
            ], 400);
        }

        $absen = Absen::create([
            'siswa_id' => $siswa->id,
            'tanggal' => Carbon::now(),
        ]);

        $siswa->update(['status_absen' => true]);

        return response()->json([
            'statusCode' => 200,
            'status' => 'success',
            'message' => 'Absensi berhasil!',
            'data' => $absen,
        ], 200);
    }
}
