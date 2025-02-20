@extends('layouts.app')

@section('title', 'Edit Siswa')

@section('content')
<div class="container">
    <h1 class="mb-4">Edit Siswa</h1>

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

    <form action="{{ url('/admin/siswa/'.$siswa->id) }}" method="POST" class="card p-4 shadow-sm">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Nama</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $siswa->name) }}" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $siswa->email) }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Perbarui</button>
        <a href="{{ url('/admin/siswa') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
