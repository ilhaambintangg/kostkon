@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="min-vh-100 d-flex align-items-center justify-content-center py-5">
    <div class="card" style="width: 500px;">
        <div class="card-body p-5">
            <div class="text-center mb-4">
                <i class="bi bi-person-plus-fill text-primary" style="font-size: 3rem;"></i>
                <h3 class="mt-3">Daftar Akun Baru</h3>
                <p class="text-muted">Lengkapi form di bawah ini</p>
            </div>

            @if($errors->any())
                <div class="alert alert-danger">
                    <strong>Terdapat kesalahan:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST">
                @csrf
                
                <div class="mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required>
                    <small class="text-muted">Minimal 6 karakter</small>
                </div>

                <div class="mb-4">
                    <label class="form-label">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary w-100 py-2 mb-3">
                    <i class="bi bi-check-circle me-2"></i>Daftar Sekarang
                </button>

                <div class="text-center">
                    <p class="text-muted">Sudah punya akun? <a href="{{ route('login') }}" class="text-primary">Login di sini</a></p>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

