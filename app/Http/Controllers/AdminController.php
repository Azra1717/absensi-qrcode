<?php

namespace App\Http\Controllers;

use App\Models\Absen;
use App\Models\User;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;


class AdminController extends Controller
{
    public function index(Request $request)
    {
        // Ambil input dari form pencarian dan filter
        $search = $request->input('search');
        $tanggal = $request->input('tanggal');
    
        // Query dasar
        $query = User::where('role', 'siswa');
    
        // Jika ada pencarian berdasarkan nama atau email
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%$search%")
                  ->orWhere('email', 'LIKE', "%$search%");
            });
        }
    
        // Jika ada filter berdasarkan tanggal pendaftaran
        if ($tanggal) {
            $query->whereDate('created_at', $tanggal);
        }
    
        // Paginate hasil pencarian
        $siswa = $query->paginate(10);
    
        return view('admin.siswa.index', compact('siswa', 'search', 'tanggal'));
    }
    

    public function create()
    {
        return view('admin.siswa.create');
    }
    public function store(Request $request)
    {
        // dd($request->all());
        $siswa = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'nis' => $request->nis,
            'password' => bcrypt($request->password),
            'role' => 'siswa',
        ]);
    
        // Generate QR Code menggunakan nis siswa
        $qrCode = QrCode::size(200)->generate($siswa->email);  // Menggunakan nis untuk QR Code
        
        // Menyimpan QR code ke dalam model siswa
        $siswa->qr_code = $qrCode;
        $siswa->save();
    
        return redirect('/admin/siswa');


        // $siswa = User::create([
        //     'name' => $request->name,
        //     'email' => $request->email,
        //     'nis' => $request->nis,
        //     'password' => bcrypt($request->password),
        //     'role' => 'siswa',
        // ]);
    
        // // Path tempat menyimpan QR Code
        // $filePath = public_path('qr_codes/' . $siswa->nis . '.svg');
    
        // // Generate QR Code dan simpan dalam format SVG
        // file_put_contents($filePath, QrCode::size(200)->generate($siswa->nis));
    
        // // Simpan nama file QR Code di database
        // $siswa->qr_code = 'qr_codes/' . $siswa->nis . '.svg';
        // $siswa->save();
    
    }
    
    

    public function edit($id)
    {
        $siswa = User::findOrFail($id);
        return view('admin.siswa.edit', compact('siswa'));
    }

    public function update(Request $request, $id)
    {
        $siswa = User::findOrFail($id);
        $siswa->update($request->all());
        return redirect('/admin/siswa');
    }

    public function destroy($id)
    {
        User::destroy($id);
        return redirect('/admin/siswa');
    }
    
    public function laporan(Request $request)
    {
        $query = Absen::with('siswa')->orderBy('tanggal', 'desc');
    
        // Filter berdasarkan nama siswa
        if ($request->filled('search')) {
            $query->whereHas('siswa', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }
    
        // Filter berdasarkan tanggal
        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }
    
        $absensi = $query->paginate(15);
    
        return view('admin.siswa.laporan', compact('absensi'));
    }
    

}
