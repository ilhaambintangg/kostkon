<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi - KostKon</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            overflow-x: hidden;
        }

        .register-container {
            display: flex;
            min-height: 100vh;
        }

        .register-left {
            flex: 1;
            background: linear-gradient(135deg, rgba(244, 147, 43, 0.9) 0%, rgba(239, 83, 80, 0.9) 100%),
                        url('https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?w=1200') center/cover;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            padding: 60px;
            position: relative;
        }

        .register-left::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.3);
            z-index: 1;
        }

        .register-left-content {
            position: relative;
            z-index: 2;
            text-align: center;
        }

        .register-left h1 {
            font-size: 3.5rem;
            font-weight: bold;
            margin-bottom: 20px;
            text-shadow: 2px 2px 10px rgba(0,0,0,0.3);
        }

        .register-left p {
            font-size: 1.3rem;
            opacity: 0.95;
            text-shadow: 1px 1px 5px rgba(0,0,0,0.3);
        }

        .feature-item {
            display: flex;
            align-items: center;
            margin: 15px 0;
            font-size: 1.1rem;
        }

        .feature-item i {
            font-size: 1.5rem;
            margin-right: 15px;
        }

        .register-right {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            background: white;
            padding: 40px;
        }

        .register-box {
            width: 100%;
            max-width: 500px;
        }

        .register-box h2 {
            color: #f4932b;
            margin-bottom: 10px;
            font-weight: bold;
        }

        .register-box p {
            color: #6c757d;
            margin-bottom: 30px;
        }

        .form-control {
            padding: 12px 15px;
            border-radius: 10px;
            border: 1px solid #dee2e6;
            transition: all 0.3s;
        }

        .form-control:focus {
            border-color: #f4932b;
            box-shadow: 0 0 0 0.2rem rgba(244, 147, 43, 0.25);
        }

        .input-group-text {
            background: white;
            border-right: none;
            border-radius: 10px 0 0 10px;
        }

        .input-group .form-control {
            border-left: none;
            border-radius: 0 10px 10px 0;
        }

        .btn-register {
            background: linear-gradient(135deg, #f4932b 0%, #ef5350 100%);
            border: none;
            padding: 12px;
            border-radius: 10px;
            color: white;
            font-weight: bold;
            transition: all 0.3s;
        }

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(244, 147, 43, 0.4);
        }

        .alert {
            border-radius: 10px;
        }

        .password-requirements {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 15px;
            margin-top: 20px;
            font-size: 0.9rem;
        }

        @media (max-width: 768px) {
            .register-left {
                display: none;
            }

            .register-right {
                padding: 20px;
            }

            .register-left h1 {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <div class="register-container">
        <!-- Left Side - Background Image -->
        <div class="register-left">
            <div class="register-left-content">
                <i class="bi bi-person-plus-fill" style="font-size: 5rem; margin-bottom: 20px;"></i>
                <h1>Bergabung dengan KostKon!</h1>
                <p>Kelola hunian Anda dengan lebih mudah</p>
                
                <div class="mt-5">
                    <div class="feature-item">
                        <i class="bi bi-check-circle-fill"></i>
                        <span>Cari kamar sesuai budget</span>
                    </div>
                    <div class="feature-item">
                        <i class="bi bi-check-circle-fill"></i>
                        <span>Booking online praktis</span>
                    </div>
                    <div class="feature-item">
                        <i class="bi bi-check-circle-fill"></i>
                        <span>Pembayaran aman & terpercaya</span>
                    </div>
                    <div class="feature-item">
                        <i class="bi bi-check-circle-fill"></i>
                        <span>Customer support 24/7</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side - Register Form -->
        <div class="register-right">
            <div class="register-box">
                <h2>Buat Akun Baru 🚀</h2>
                <p>Daftar sekarang dan temukan hunian impian Anda</p>

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show">
                        <strong>Terdapat kesalahan:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form action="{{ route('register') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Lengkap</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                            <input type="text" 
                                   name="name" 
                                   class="form-control" 
                                   placeholder="Masukkan nama lengkap"
                                   value="{{ old('name') }}" 
                                   required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Email</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                            <input type="email" 
                                   name="email" 
                                   class="form-control" 
                                   placeholder="contoh@email.com"
                                   value="{{ old('email') }}" 
                                   required>
                        </div>
                        <small class="text-muted">Kode OTP akan dikirim ke email ini</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock"></i></span>
                            <input type="password" 
                                   name="password" 
                                   class="form-control" 
                                   placeholder="Minimal 6 karakter"
                                   required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Konfirmasi Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                            <input type="password" 
                                   name="password_confirmation" 
                                   class="form-control" 
                                   placeholder="Ketik ulang password"
                                   required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-register w-100 mb-3">
                        <i class="bi bi-check-circle me-2"></i>Daftar Sekarang
                    </button>

                    <div class="text-center">
                        <p class="text-muted mb-0">
                            Sudah punya akun? 
                            <a href="{{ route('login') }}" class="text-decoration-none fw-bold" style="color: #f4932b;">
                                Login di sini
                            </a>
                        </p>
                    </div>
                </form>

                <div class="password-requirements">
                    <strong class="d-block mb-2"><i class="bi bi-info-circle me-2"></i>Persyaratan Password:</strong>
                    <ul class="mb-0 ps-4">
                        <li>Minimal 6 karakter</li>
                        <li>Password dan konfirmasi harus sama</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>