@extends('layouts.app')

@section('title', 'Profil Siswa')

@section('content')
<div class="container d-flex justify-content-center mt-5">
    <div class="card shadow-lg p-4" style="width: 400px;">
        <div class="text-center">
            <h3 class="mb-3">Profil Siswa</h3>
            <hr>
            <h4 class="fw-bold">Haii {{ Auth::user()->name }} !</h4>
            <p class="text-muted mb-1"><strong>Email:</strong> {{ Auth::user()->email }}</p>
            <p class="text-muted mb-3"><strong>NIS:</strong> {{ Auth::user()->nis }}</p>

            @if(Auth::user()->status_absen)
                <div class="alert alert-success">
                    ✅ Anda sudah absen hari ini.
                </div>
            @else
                <div class="d-flex justify-content-center">
                    {!! QrCode::size(200)->generate(Auth::user()->nis) !!}
                </div>
                <p class="mt-3 text-muted">Scan QR ini untuk melakukan absensi.</p>
            @endif
        </div>
    </div>
</div>
@endsection
