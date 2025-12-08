@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3>Lupa Password</h3>
    <p>Masukkan email Anda untuk menerima link reset password.</p>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="mb-3">
            <label>Email</label>
            <input type="email" class="form-control" name="email" required>
            @error('email') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="btn btn-primary">Kirim Link Reset</button>
    </form>
</div>
@endsection
