<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

     public function showQR() {
        $siswa = Auth::user();

        return response()->json([
            'success' => true,
            'message' => 'Data QR Code Siswa',
            'data' => [
                'id' => $siswa->id,
                'name' => $siswa->name,
                'email' => $siswa->email,
                'nis' => $siswa->nis,
                'qr_code' => $siswa->qr_code
            ]
        ]);
    }
}
