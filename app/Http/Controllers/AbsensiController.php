<?php

namespace App\Http\Controllers;

use App\Models\Absen;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth; // Tambahin ini di atas

class AbsensiController extends Controller
{

    public function scanQR(Request $request)
    {
        $siswa = User::where('nis', $request->siswa_nis)->first();
    
        if (!$siswa) {
            return redirect()->route('admin.scan')->with('error', 'Siswa tidak ditemukan!');
        }
    
        // Cek apakah sudah absen hari ini
        $existingAbsensi = Absen::where('siswa_id', $siswa->id)
            ->whereDate('tanggal', Carbon::today())
            ->first();
    
        if ($existingAbsensi) {
            return redirect()->route('admin.scan')->with('error', 'Siswa sudah absen hari ini.');
        }
    
        // Simpan absensi baru
        Absen::create([
            'siswa_id' => $siswa->id,
            'tanggal' => Carbon::now(),
        ]);
    
        $siswa->update(['status_absen' => true]);
        return redirect()->route('admin.scan')->with('success', 'Absensi berhasil!');
    }
    // {
    //     // Ambil user yang lagi login
    //     $siswa = Auth::user(); 
    
    //     // Pastikan QR Code yang discan sesuai dengan NIS dari user yang login
    //     if ($siswa->nis !== $request->siswa_nis) {
    //         return redirect()->route('siswa.qrode')->with('error', 'QR Code tidak sesuai dengan akun Anda!');
    //     }
    
    //     // Cek apakah sudah absen hari ini
    //     $existingAbsensi = Absen::where('siswa_id', $siswa->id)
    //         ->whereDate('tanggal', Carbon::today())
    //         ->first();
    
    //     if ($existingAbsensi) {
    //         return redirect()->route('siswa.qrode')->with('error', 'Absensi sudah tercatat hari ini.');
    //     }
    
    //     // Simpan absensi baru
    //     Absen::create([
    //         'siswa_id' => $siswa->id,
    //         'tanggal' => Carbon::now(),
    //     ]);
    
    //     return redirect()->route('siswa.qrode')->with('success', 'Absensi berhasil!');
    // }
    
    
    // public function scanQR(Request $request)
    // {
    //     $siswa = User::where('nis', $request->siswa_nis)->first();
    //     if ($siswa) {
    //         // Periksa apakah sudah ada absensi untuk hari yang sama
    //         $existingAbsensi = Absen::where('siswa_id', $siswa->id) // Pake id, bukan nis
    //         ->whereDate('tanggal', Carbon::today())
    //         ->first();
    
    //         if ($existingAbsensi) {
    //             // Jika sudah ada, kirim pesan error atau hanya redirect
    //             return redirect()->route('siswa.qrode')->with('error', 'Absensi sudah tercatat hari ini.');
    //         }
    
    //         // Jika belum ada, simpan absensi baru
    //         Absen::create([
    //             'siswa_id' => $siswa->id,
    //             'tanggal' => Carbon::now(),
    //         ]);
            
    //         return redirect()->route('siswa.qrode')->with('success', 'Absensi berhasil!');
    //     }
    
    //     return redirect()->route('siswa.qrode')->with('error', 'Siswa tidak ditemukan.');
    // }
    

}
