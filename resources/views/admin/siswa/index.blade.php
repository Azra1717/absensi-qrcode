@extends('layouts.app')

@section('title', 'Daftar Siswa')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="mb-0">Daftar Siswa</h1>
        <a href="{{ url('/admin/siswa/create') }}" class="btn btn-primary">Tambah Siswa</a>
    </div>

    <!-- Form Search dan Filter -->
    <div class="card mb-3">
        <div class="card-body">
            <form action="{{ url('/admin/siswa') }}" method="GET">
                <div class="row g-2">
                    <!-- Input Pencarian -->
                    <div class="col-md-4">
                        <input type="text" name="search" class="form-control" 
                            placeholder="Cari nama atau email" value="{{ request('search') }}">
                    </div>

                    <!-- Filter Tanggal Pendaftaran -->
                    <div class="col-md-3">
                        <input type="date" name="tanggal" class="form-control" value="{{ request('tanggal') }}">
                    </div>

                    <!-- Tombol Submit -->
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">Cari</button>
                    </div>

                    <!-- Tombol Reset -->
                    <div class="col-md-2">
                        <a href="{{ url('/admin/siswa') }}" class="btn btn-secondary w-100">Reset</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabel Daftar Siswa -->
    <div class="card">
        <div class="card-body">
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>QR Code</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($siswa as $s)
                        <tr>
                            <td>{{ $s->name }}</td>
                            <td>{{ $s->email }}</td>
                            <td class="text-center">{!! QrCode::size(100)->generate($s->nis) !!}</td>
                            <td>
                                <a href="{{ url('/admin/siswa/'.$s->id.'/edit') }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ url('/admin/siswa/'.$s->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus siswa ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">Tidak ada data siswa.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Menampilkan pagination -->
            <div class="d-flex justify-content-center">
                {{ $siswa->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
