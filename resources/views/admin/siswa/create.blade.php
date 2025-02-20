@extends('layouts.app')

@section('title', 'Tambah Siswa')

@section('content')
<div class="container">
    <h1 class="mb-4">Tambah Siswa</h1>

    <!-- Menampilkan error validasi -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ url('/admin/siswa') }}" method="POST" class="card p-4 shadow-sm">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Nama</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
        </div>

        <div class="mb-3">
            <label for="nis" class="form-label">NIS</label>
            <input type="text" name="nis" id="nis" class="form-control" value="{{ old('nis') }}" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ url('/admin/siswa') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
