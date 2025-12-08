@extends('layouts.app')

@section('content')

<style>
    body {
        background: linear-gradient(135deg, #eef2f7 0%, #dbe4f0 100%);
        font-family: 'Inter', sans-serif;
    }

    .forgot-wrapper {
        max-width: 460px;
        margin: 70px auto;
        background: rgba(255,255,255,0.88);
        padding: 35px 35px;
        border-radius: 20px;
        box-shadow: 0px 20px 40px rgba(0,0,0,0.12);
        backdrop-filter: blur(6px);
        text-align: center;
    }

    .forgot-wrapper h3 {
        font-weight: 700;
        color: #667eea;
        font-size: 1.9rem;
        margin-bottom: 10px;
    }

    .forgot-wrapper p {
        color: #6c757d;
        margin-bottom: 25px;
        font-size: 0.95rem;
    }

    .form-label {
        font-weight: 600;
        color: #495057;
        text-align: left;
        display: block;
    }

    .form-control {
        padding: 12px 14px;
        border-radius: 12px;
        border: 1px solid #d0d7de;
        transition: .3s;
    }

    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 4px rgba(102,126,234,0.18);
    }

    .btn-send {
        width: 100%;
        padding: 12px;
        border-radius: 12px;
        border: none;
        background: linear-gradient(to right, #667eea, #764ba2);
        color: white;
        font-weight: 600;
        font-size: 1rem;
        transition: .3s;
    }

    .btn-send:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(102, 126, 234, 0.35);
    }

    .alert {
        border-radius: 12px;
        font-size: 0.9rem;
    }
</style>

<div class="forgot-wrapper">

    <h3>Lupa Password?</h3>
    <p>Masukkan email Anda dan kami akan mengirim link untuk mereset password Anda.</p>

    @if (session('success'))
        <div class="alert alert-success">
            <i class="bi bi-check-circle-fill me-1"></i>{{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="mb-3 text-start">
            <label class="form-label">Email</label>
            <input type="email" 
                   class="form-control" 
                   name="email" 
                   required>
            @error('email') 
                <small class="text-danger">{{ $message }}</small> 
            @enderror
        </div>

        <button type="submit" class="btn-send">
            <i class="bi bi-envelope-arrow-up me-2"></i>
            Kirim Link Reset
        </button>
    </form>

</div>

@endsection