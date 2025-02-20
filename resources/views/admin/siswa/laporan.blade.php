@extends('layouts.app')

@section('title', 'Laporan Absensi')

@section('content')
<div class="container mt-4">
    <h3 class="text-center mb-4">Laporan Absensi</h3>

    <!-- Form Search dan Filter -->
    <div class="card mb-3">
        <div class="card-body">
            <form action="{{ url('/admin/siswa/laporan') }}" method="GET">
                <div class="row g-2">
                    <!-- Input Pencarian Nama -->
                    <div class="col-md-4">
                        <input type="text" name="search" class="form-control" 
                            placeholder="Cari nama siswa" value="{{ request('search') }}">
                    </div>

                    <!-- Filter Tanggal -->
                    <div class="col-md-3">
                        <input type="date" name="tanggal" class="form-control" value="{{ request('tanggal') }}">
                    </div>

                    <!-- Tombol Submit -->
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">Cari</button>
                    </div>

                    <!-- Tombol Reset -->
                    <div class="col-md-2">
                        <a href="{{ url('/admin/siswa/laporan') }}" class="btn btn-secondary w-100">Reset</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if($absensi->isEmpty())
        <div class="alert alert-warning text-center">Belum ada data absensi.</div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark text-center">
                    <tr>
                        <th>No</th>
                        <th>Nama Siswa</th>
                        <th>Waktu Absen</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($absensi as $index => $absen)
                    <tr class="text-center">
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $absen->siswa->name }}</td>
                        <td>{{ \Carbon\Carbon::parse($absen->tanggal)->translatedFormat('d F Y - H:i') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <div class="d-flex justify-content-center">
        {{ $absensi->appends(request()->query())->links() }}
    </div>
</div>
@endsection
