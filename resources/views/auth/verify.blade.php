@extends('layouts.app')

@section('title', 'Verifikasi Akun')

@section('content')
<div class="min-vh-100 d-flex align-items-center justify-content-center">
    <div class="card" style="width: 450px;">
        <div class="card-body p-5">
            <div class="text-center mb-4">
                <i class="bi bi-shield-check text-success" style="font-size: 3rem;"></i>
                <h3 class="mt-3">Verifikasi Akun</h3>
                <p class="text-muted">Masukkan kode verifikasi 6 digit</p>
            </div>

            @if(session('success'))
                <div class="alert alert-success">
                    <i class="bi bi-info-circle-fill me-2"></i>{{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    @foreach($errors->all() as $error)
                        <div><i class="bi bi-exclamation-triangle-fill me-2"></i>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('verify') }}" method="POST">
                @csrf
                
                <div class="mb-4">
                    <label class="form-label">Kode Verifikasi</label>
                    <input type="text" name="verification_code" class="form-control form-control-lg text-center" 
                           placeholder="000000" maxlength="6" pattern="\d{6}" required autofocus
                           style="letter-spacing: 10px; font-size: 24px;">
                    <small class="text-muted">Kode verifikasi ditampilkan setelah registrasi</small>
                </div>

                <button type="submit" class="btn btn-success w-100 py-2 mb-3">
                    <i class="bi bi-check-circle me-2"></i>Verifikasi
                </button>

                <div class="text-center">
                    <p class="text-muted">Belum menerima kode? <a href="{{ route('register') }}" class="text-primary">Daftar ulang</a></p>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection