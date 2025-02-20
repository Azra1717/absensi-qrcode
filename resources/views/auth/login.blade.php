@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center align-items-center">
    <div class="card shadow-lg p-4" style="width: 100%; max-width: 400px; border-radius: 12px;">
        <div class="card-body">
            <h3 class="text-center fw-bold mb-4 text-primary">Welcome Back</h3>
            <form action="{{ route('login.submit') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>
            
            <div class="text-center mt-3">
                <small>Belum punya akun? <a class="text-primary">Daftar</a></small>
            </div>
        </div>
    </div>
</div>
@endsection
