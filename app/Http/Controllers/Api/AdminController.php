<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Resources\AbsenResource;
use App\Models\Absen;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $tanggal = $request->input('tanggal');

        $query = User::where('role', 'siswa');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%$search%")
                  ->orWhere('email', 'LIKE', "%$search%");
            });
        }

        if ($tanggal) {
            $query->whereDate('created_at', $tanggal);
        }

        $siswa = $query->paginate(10);

        return response()->json([
            'status' => 'success',
            'data' => UserResource::collection($siswa),
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'nis' => 'required|string|unique:users',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $siswa = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'nis' => $request->nis,
            'password' => bcrypt($request->password),
            'role' => 'siswa',
        ]);

        $qrCode = QrCode::size(200)->generate($siswa->nis);
        $siswa->qr_code = $qrCode;
        $siswa->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Siswa berhasil ditambahkan!',
            'data' => new UserResource($siswa),
        ], 201);
    }

    public function show($id)
    {
        $siswa = User::where('role', 'siswa')->find($id);
        if (!$siswa) {
            return response()->json(['status' => 'error', 'message' => 'Siswa tidak ditemukan'], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => new UserResource($siswa),
        ]);
    }

    public function update(Request $request, $id)
    {
        $siswa = User::where('role', 'siswa')->find($id);
        if (!$siswa) {
            return response()->json(['status' => 'error', 'message' => 'Siswa tidak ditemukan'], 404);
        }

        $siswa->update($request->only(['name', 'email', 'nis']));
        
        return response()->json([
            'status' => 'success',
            'message' => 'Data siswa diperbarui!',
            'data' => new UserResource($siswa),
        ]);
    }

    public function destroy($id)
    {
        $siswa = User::where('role', 'siswa')->find($id);
        if (!$siswa) {
            return response()->json(['status' => 'error', 'message' => 'Siswa tidak ditemukan'], 404);
        }

        $siswa->delete();
        return response()->json(['status' => 'success', 'message' => 'Siswa berhasil dihapus!']);
    }

    public function laporan(Request $request)
    {
        $query = Absen::with('siswa')->orderBy('tanggal', 'desc');

        if ($request->filled('search')) {
            $query->whereHas('siswa', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }

        $absensi = $query->paginate(15);

        return response()->json([
            'status' => 'success',
            'data' => AbsenResource::collection($absensi),
        ]);
    }
}
