@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="min-vh-100 d-flex align-items-center justify-content-center">
    <div class="card" style="width: 450px;">
        <div class="card-body p-5">
            <div class="text-center mb-4">
                <i class="bi bi-building text-primary" style="font-size: 3rem;"></i>
                <h3 class="mt-3">Login KostKon</h3>
                <p class="text-muted">Masuk ke akun Anda</p>
            </div>

            @if(session('success'))
                <div class="alert alert-success">
                    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    @foreach($errors->all() as $error)
                        <div><i class="bi bi-exclamation-triangle-fill me-2"></i>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf
                
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100 py-2 mb-3">
                    <i class="bi bi-box-arrow-in-right me-2"></i>Login
                </button>

                <div class="text-center">
                    <p class="text-muted">Belum punya akun? <a href="{{ route('register') }}" class="text-primary">Daftar di sini</a></p>
                </div>
            </form>

            <hr class="my-4">

            <div class="alert alert-warning">
                <small>
                    <i class="bi bi-info-circle"></i> 
                    <strong>Perhatian:</strong> User baru harus menunggu persetujuan admin sebelum bisa login.
                </small>
            </div>
        </div>
    </div>
</div>
@endsection