<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - KostKon</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        /* 🎨 Custom Styles for Modern & Elegant UI */
        
        :root {
            --primary-color: #5B4EAE; /* Ungu Utama */
            --secondary-color: #667eea;
            --gradient-start: #5B4EAE;
            --gradient-end: #8C6CEF;
            --text-dark: #343a40;
            --text-muted: #6c757d;
            --bg-light: #f8f9fa;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            height: 100vh;
            overflow: hidden;
            background-color: var(--bg-light);
        }

        .login-container {
            display: flex;
            height: 100vh;
        }

        /* --- Left Panel (Visual Appeal) --- */
        .login-left {
            flex: 1;
            background: linear-gradient(135deg, var(--gradient-start) 0%, var(--gradient-end) 100%),
                        url('https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?q=80&w=1974&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D') center/cover;
            background-blend-mode: multiply;
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
            background: rgba(0, 0, 0, 0.4);
            z-index: 1;
        }

        .login-left-content {
            position: relative;
            z-index: 2;
            text-align: center;
        }

        .login-left h1 {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 20px;
            text-shadow: 2px 2px 10px rgba(0,0,0,0.5);
            letter-spacing: 1px;
        }

        .login-left p {
            font-size: 1.2rem;
            font-weight: 300;
            opacity: 0.95;
            text-shadow: 1px 1px 5px rgba(0,0,0,0.3);
        }

        /* --- Right Panel (Login Form) --- */
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
            padding: 40px;
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease;
        }

        .login-box:hover {
             box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12);
        }

        .login-box h2 {
            color: var(--primary-color);
            margin-bottom: 5px;
            font-weight: 700;
        }

        .login-box p {
            color: var(--text-muted);
            margin-bottom: 30px;
            font-size: 1rem;
        }

        /* --- Form Elements --- */
        .form-control {
            padding: 12px 15px;
            border-radius: 10px;
            border: 1px solid #e0e0e0;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            font-size: 1rem;
        }

        .form-control:focus {
            border-color: var(--gradient-start);
            box-shadow: 0 0 0 0.25rem rgba(91, 78, 174, 0.15);
            background-color: #f9f9ff;
        }

        /* Input Group Adjustments */
        .input-group-text {
            background: var(--bg-light);
            color: var(--primary-color);
            border: 1px solid #e0e0e0;
            padding: 12px 15px; /* Sesuaikan padding agar sama dengan input */
        }
        
        .input-group-text.pre-pend { /* Icon Email/Lock */
            border-right: none;
            border-radius: 10px 0 0 10px;
        }
        
        .input-group-text.append { /* Icon Mata */
            border-left: none;
            border-radius: 0 10px 10px 0;
            cursor: pointer; /* Menandakan bisa diklik */
        }

        .input-group-text .bi {
            font-size: 1.1rem;
        }

        .input-group .form-control {
            border-left: none; /* Aturan default untuk form-control di tengah/akhir input group */
            border-right: none;
            border-radius: 0;
        }
        
        /* Jika form-control di akhir (seperti email) */
        .input-group:not(.password-group) .form-control {
            border-radius: 0 10px 10px 0;
            border-left: none;
        }
        
        /* Jika form-control di tengah (seperti password) */
        .input-group.password-group .form-control {
            border-radius: 0; /* Hilangkan border radius agar menyatu dengan icon mata */
            border-left: none;
        }
        
        /* Atur border pada container utama */
        .input-group {
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            transition: all 0.3s;
        }
        
        .input-group:focus-within {
             box-shadow: 0 0 0 0.25rem rgba(91, 78, 174, 0.15);
             border-color: var(--gradient-start);
        }
        
        /* Hilangkan border pada children form-control dan input-group-text agar border utama terlihat */
        .input-group .form-control, .input-group-text {
            border: none;
        }
        
        /* Khusus untuk input-group-text.append agar terlihat sebagai tombol klik */
        .input-group-text.append:hover {
            background-color: #e9ecef;
        }


        /* --- Button --- */
        .btn-login {
            background: linear-gradient(135deg, var(--gradient-start) 0%, var(--gradient-end) 100%);
            border: none;
            padding: 14px;
            border-radius: 12px;
            color: white;
            font-weight: 600;
            font-size: 1.1rem;
            letter-spacing: 0.5px;
            box-shadow: 0 5px 15px rgba(91, 78, 174, 0.3);
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(91, 78, 174, 0.5);
            opacity: 0.95;
        }
        
        .btn-login:active {
            transform: translateY(-1px);
            box-shadow: 0 5px 15px rgba(91, 78, 174, 0.4);
        }

        /* --- Links and Alerts --- */
        .alert {
            border-radius: 10px;
            font-size: 0.95rem;
        }
        
        .alert-success {
            background-color: #e6ffed;
            color: #1a7837;
            border-color: #c7eed5;
        }
        
        .alert-danger {
            background-color: #ffe6e6;
            color: #b00000;
            border-color: #ffc7c7;
        }
        
        .alert-info {
            background-color: #e6f7ff;
            color: #0d6efd;
            border-color: #c7e8ff;
        }

        .forgot-password-link {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 400;
            transition: color 0.3s;
            font-size: 0.9rem;
        }

        .forgot-password-link:hover {
            color: var(--gradient-end);
            text-decoration: underline;
        }
        
        .login-box .text-center a {
            color: var(--primary-color) !important;
            transition: color 0.3s;
        }
        
        .login-box .text-center a:hover {
            color: var(--gradient-end) !important;
        }

        /* --- Responsive Design --- */
        @media (max-width: 992px) {
            .login-left {
                display: none;
            }

            .login-right {
                flex: 0 0 100%;
                padding: 30px;
            }
            
            .login-box {
                max-width: 400px;
                padding: 30px;
                box-shadow: none;
                border: 1px solid #f0f0f0;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-left">
            <div class="login-left-content">
                <i class="bi bi-building" style="font-size: 5.5rem; margin-bottom: 25px;"></i>
                <h1>🏠 KostKon</h1>
                <p class="mb-5">Sistem Manajemen Kos & Kontrakan Modern</p>
                <p class="mt-4" style="font-size: 1.1rem; font-weight: 400;">
                    <i class="bi bi-patch-check-fill me-2"></i>Kelola, Cari, dan Booking Hunian Anda dengan *Efisien* dan *Mewah*.
                </p>
            </div>
        </div>
        
        <div class="login-right">
            <div class="login-box">
                <h2>Selamat Datang Kembali! 👋</h2>
                <p>Silakan masukkan detail akun Anda untuk melanjutkan sesi.</p>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('status'))
                    <div class="alert alert-info alert-dismissible fade show">
                        <i class="bi bi-info-circle-fill me-2"></i>{{ session('status') }}
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
                        <label class="form-label fw-bold" for="emailInput">Email</label>
                        <div class="input-group">
                            <span class="input-group-text pre-pend"><i class="bi bi-envelope"></i></span>
                            <input type="email" 
                                   name="email" 
                                   class="form-control" 
                                   id="emailInput"
                                   placeholder="misalnya: nama@email.com"
                                   value="{{ old('email') }}" 
                                   required 
                                   autofocus>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold d-block mb-1" for="passwordInput">Password</label>
                        <div class="input-group password-group">
                            <span class="input-group-text pre-pend"><i class="bi bi-lock"></i></span>
                            <input type="password" 
                                   name="password" 
                                   class="form-control" 
                                   id="passwordInput"
                                   placeholder="Minimal 8 Karakter"
                                   required>
                            <span class="input-group-text append" id="togglePassword">
                                <i class="bi bi-eye-slash" id="eyeIcon"></i>
                            </span>
                        </div>
                        
                        <div class="text-end mt-2">
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="forgot-password-link">
                                    <i class="bi bi-question-circle me-1"></i>Lupa Password?
                                </a>
                            @endif
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">
                                Ingat saya
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-login w-100 mb-4">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Masuk
                    </button>

                    <div class="text-center">
                        <p class="text-muted mb-0">
                            Belum punya akun? 
                            <a href="{{ route('register') }}" class="text-decoration-none fw-bold">
                                Daftar di sini
                            </a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('passwordInput');
            const eyeIcon = document.getElementById('eyeIcon');

            if (togglePassword && passwordInput && eyeIcon) {
                togglePassword.addEventListener('click', function (e) {
                    // Toggle the type attribute
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);
                    
                    // Toggle the eye icon
                    if (eyeIcon.classList.contains('bi-eye-slash')) {
                        eyeIcon.classList.remove('bi-eye-slash');
                        eyeIcon.classList.add('bi-eye');
                    } else {
                        eyeIcon.classList.remove('bi-eye');
                        eyeIcon.classList.add('bi-eye-slash');
                    }
                });
            }
        });
    </script>
</body>
</html>