<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - KostKon</title>
    
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
            height: 100vh;
            overflow: hidden;
        }

        .login-container {
            display: flex;
            height: 100vh;
        }

        .login-left {
            flex: 1;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.9) 0%, rgba(118, 75, 162, 0.9) 100%),
                        url('https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?w=1200') center/cover;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            padding: 60px;
            position: relative;
        }

        .login-left::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.3);
            z-index: 1;
        }

        .login-left-content {
            position: relative;
            z-index: 2;
            text-align: center;
        }

        .login-left h1 {
            font-size: 3.5rem;
            font-weight: bold;
            margin-bottom: 20px;
            text-shadow: 2px 2px 10px rgba(0,0,0,0.3);
        }

        .login-left p {
            font-size: 1.3rem;
            opacity: 0.95;
            text-shadow: 1px 1px 5px rgba(0,0,0,0.3);
        }

        .login-right {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            background: white;
            padding: 40px;
        }

        .login-box {
            width: 100%;
            max-width: 450px;
        }

        .login-box h2 {
            color: #667eea;
            margin-bottom: 10px;
            font-weight: bold;
        }

        .login-box p {
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
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
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

        .btn-login {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 12px;
            border-radius: 10px;
            color: white;
            font-weight: bold;
            transition: all 0.3s;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .alert {
            border-radius: 10px;
        }

        .demo-accounts {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 15px;
            margin-top: 20px;
        }

        @media (max-width: 768px) {
            .login-left {
                display: none;
            }

            .login-right {
                padding: 20px;
            }

            .login-left h1 {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <!-- Left Side - Background Image -->
        <div class="login-left">
            <div class="login-left-content">
                <i class="bi bi-building" style="font-size: 5rem; margin-bottom: 20px;"></i>
                <h1>🏠 KostKon</h1>
                <p>Sistem Manajemen Kos & Kontrakan Modern</p>
                <p class="mt-4"><small>Cari, booking, dan kelola hunian Anda dengan mudah</small></p>
            </div>
        </div>

        <!-- Right Side - Login Form -->
        <div class="login-right">
            <div class="login-box">
                <h2>Selamat Datang! 👋</h2>
                <p>Masuk ke akun Anda untuk melanjutkan</p>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show">
                        @foreach($errors->all() as $error)
                            <div><i class="bi bi-exclamation-triangle-fill me-2"></i>{{ $error }}</div>
                        @endforeach
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Email</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                            <input type="email" 
                                   name="email" 
                                   class="form-control" 
                                   placeholder="Masukkan email Anda"
                                   value="{{ old('email') }}" 
                                   required 
                                   autofocus>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock"></i></span>
                            <input type="password" 
                                   name="password" 
                                   class="form-control" 
                                   placeholder="Masukkan password Anda"
                                   required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-login w-100 mb-3">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Masuk
                    </button>

                    <div class="text-center">
                        <p class="text-muted mb-0">
                            Belum punya akun? 
                            <a href="{{ route('register') }}" class="text-decoration-none fw-bold" style="color: #667eea;">
                                Daftar di sini
                            </a>
                        </p>
                    </div>
                </form>

                <hr class="my-4">

                <div class="demo-accounts">
                    <strong class="d-block mb-2"><i class="bi bi-info-circle me-2"></i>Akun Demo:</strong>
                    <small class="d-block mb-1"><strong>Admin:</strong> admin@kostkon.com / admin123</small>
                    <small class="d-block"><strong>Penyewa:</strong> budi@gmail.com / budi123</small>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>