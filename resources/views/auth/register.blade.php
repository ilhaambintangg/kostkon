<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi - KostKon</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        /* 🎨 Custom Styles for Modern & Elegant UI (Orange-Red Theme) */
        
        :root {
            --primary-color: #F4932B; 
            --secondary-color: #EF5350; 
            --gradient-start: #FF7043; 
            --gradient-end: #E53935; 
            --text-dark: #343a40;
            --text-muted: #6c757d;
            --bg-light: #fdfdfd;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            overflow-x: hidden;
            background-color: var(--bg-light);
        }

        .register-container {
            display: flex;
            min-height: 100vh;
        }

        /* --- Left Panel (Visual Appeal) --- */
        .register-left {
            flex: 1;
            background: linear-gradient(135deg, var(--gradient-start) 0%, var(--gradient-end) 100%),
                        url('https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?q=80&w=1974&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D') center/cover;
            background-blend-mode: multiply;
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
            background: rgba(0, 0, 0, 0.4); 
            z-index: 1;
        }

        .register-left-content {
            position: relative;
            z-index: 2;
            text-align: left; 
            max-width: 400px;
        }

        .register-left h1 {
            font-size: 3.2rem;
            font-weight: 700;
            margin-bottom: 10px;
            text-shadow: 2px 2px 10px rgba(0,0,0,0.5);
            letter-spacing: 0.5px;
        }

        .register-left p {
            font-size: 1.1rem;
            font-weight: 300;
            opacity: 0.95;
            text-shadow: 1px 1px 5px rgba(0,0,0,0.3);
            margin-bottom: 40px;
        }

        .feature-item {
            display: flex;
            align-items: center;
            margin: 18px 0;
            font-size: 1.1rem;
            font-weight: 400;
        }

        .feature-item i {
            font-size: 1.6rem;
            margin-right: 20px;
            color: #fff; 
            text-shadow: 1px 1px 3px rgba(0,0,0,0.2);
        }

        /* --- Right Panel (Register Form) --- */
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
            max-width: 480px;
            padding: 40px;
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08); 
            transition: transform 0.3s ease;
        }

        .register-box:hover {
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12);
        }

        .register-box h2 {
            color: var(--gradient-start); 
            margin-bottom: 5px;
            font-weight: 700;
        }

        .register-box p {
            color: var(--text-muted);
            margin-bottom: 30px;
            font-size: 1rem;
        }

        /* ------------------------------------------- */
        /* --- Form Elements - FIX UNTUK TAMPILAN IMAGE --- */
        /* ------------------------------------------- */
        
        .form-control {
            padding: 12px 15px;
            border-radius: 10px;
            border: 1px solid #e0e0e0; 
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            font-size: 1rem;
            border-left: 1px solid #e0e0e0; 
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(244, 147, 43, 0.15); 
            background-color: #fffaf7; 
        }

        /* Input Group Styling */
        
        .input-group {
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            transition: all 0.3s;
        }

        .input-group:focus-within {
             box-shadow: 0 0 0 0.25rem rgba(244, 147, 43, 0.15);
             border-color: var(--primary-color);
        }
        
        /* Hapus border pada children agar border utama input group terlihat */
        .input-group .form-control, .input-group-text {
            border: none;
        }

        .input-group-text {
            background: var(--bg-light); 
            color: var(--primary-color);
            padding: 12px 15px; 
        }
        
        .input-group-text.pre-pend { /* Icon Lock/Envelope */
            border-radius: 10px 0 0 10px;
        }
        
        .input-group-text.append { /* Icon Mata */
            border-radius: 0 10px 10px 0;
            cursor: pointer;
        }

        .input-group-text .bi {
            font-size: 1.1rem;
        }
        
        /* Form control di dalam input group */
        .input-group .form-control {
            border-radius: 0;
        }
        
        /* Jika input group hanya 2 elemen (Email) */
        .input-group:not(.password-group) .form-control {
            border-radius: 0 10px 10px 0;
        }

        /* Kasus khusus untuk input Nama Lengkap (yang tidak menggunakan input-group) */
        .input-field-standalone .form-control {
            border-radius: 10px;
            padding-left: 45px; 
            border: 1px solid #e0e0e0;
        }
        
        /* Ikon untuk input standalone */
        .input-field-standalone {
            position: relative;
        }
        
        .input-field-standalone i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary-color);
            font-size: 1.1rem;
            z-index: 2;
        }

        /* Perbaikan untuk input email yang menggunakan background biru (old value/session) */
        .input-group-email {
            border-color: #d1e7ff !important;
            box-shadow: 0 0 0 0.25rem rgba(173, 216, 230, 0.15) !important;
        }
        .input-group-email .form-control, 
        .input-group-email .input-group-text {
            background-color: #f0f8ff !important;
        }
        
        /* --- Button --- */
        .btn-register {
            background: linear-gradient(135deg, var(--gradient-start) 0%, var(--gradient-end) 100%);
            border: none;
            padding: 14px;
            border-radius: 12px;
            color: white;
            font-weight: 600;
            font-size: 1.1rem;
            letter-spacing: 0.5px;
            box-shadow: 0 5px 15px rgba(229, 57, 53, 0.3);
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        .btn-register:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(229, 57, 53, 0.5);
            opacity: 0.95;
        }
        
        .btn-register:active {
            transform: translateY(-1px);
            box-shadow: 0 5px 15px rgba(229, 57, 53, 0.4);
        }

        /* --- Alerts and Requirements --- */
        .alert {
            border-radius: 10px;
            font-size: 0.95rem;
        }
        
        .alert-danger {
            background-color: #ffe6e6;
            color: #b00000;
            border-color: #ffc7c7;
        }

        .password-requirements {
            background: #fff8f7; 
            border-radius: 10px;
            padding: 15px;
            margin-top: 20px;
            font-size: 0.9rem;
            border: 1px solid #ffefe8;
        }
        
        .register-box .text-center a {
            color: var(--gradient-end) !important;
            transition: color 0.3s;
        }
        
        .register-box .text-center a:hover {
            color: var(--gradient-start) !important;
        }

        /* --- Responsive Design --- */
        @media (max-width: 992px) {
            .register-left {
                display: none;
            }

            .register-right {
                flex: 0 0 100%;
                padding: 30px;
            }
            
            .register-box {
                max-width: 400px;
                padding: 30px;
                box-shadow: none;
                border: 1px solid #f0f0f0;
            }
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-left">
            <div class="register-left-content">
                <i class="bi bi-person-check-fill" style="font-size: 5.5rem; margin-bottom: 20px;"></i>
                <h1>Daftar Akun KostKon</h1>
                <p>Mulai perjalanan Anda dalam mencari atau mengelola properti hunian modern.</p>
                
                <div class="mt-5 text-center">
                    <div class="feature-item">
                        <i class="bi bi-search"></i>
                        <span>Cari & Filter Hunian Cepat</span>
                    </div>
                    <div class="feature-item">
                        <i class="bi bi-calendar-check"></i>
                        <span>Proses Booking Instan</span>
                    </div>
                    <div class="feature-item">
                        <i class="bi bi-shield-lock"></i>
                        <span>Keamanan Data Terjamin</span>
                    </div>
                    <div class="feature-item">
                        <i class="bi bi-headset"></i>
                        <span>Layanan Pelanggan Premium</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="register-right">
            <div class="register-box">
                <h2>Buat Akun Baru 🚀</h2>
                <p>Isi formulir di bawah untuk menyelesaikan pendaftaran Anda</p>

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show">
                        <strong><i class="bi bi-x-octagon-fill me-2"></i>Terdapat kesalahan:</strong>
                        <ul class="mb-0 mt-2 ps-4">
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
                        <label class="form-label fw-bold" for="nameInput">Nama Lengkap</label>
                        <div class="input-field-standalone">
                            <i class="bi bi-person"></i>
                            <input type="text" 
                                   name="name" 
                                   class="form-control" 
                                   id="nameInput"
                                   placeholder="Masukkan nama lengkap Anda"
                                   value="{{ old('name') }}" 
                                   required 
                                   autofocus>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold" for="emailInput">Email</label>
                        <div class="input-group input-group-email">
                            <span class="input-group-text pre-pend"><i class="bi bi-envelope"></i></span>
                            <input type="email" 
                                   name="email" 
                                   class="form-control" 
                                   id="emailInput"
                                   placeholder="contoh@email.com"
                                   value="{{ old('email') }}" 
                                   required>
                        </div>
                        <small class="text-muted d-block mt-1"><i class="bi bi-info-circle me-1"></i> Digunakan untuk verifikasi dan notifikasi</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold" for="passwordInput">Password</label>
                        <div class="input-group password-group">
                            <span class="input-group-text pre-pend"><i class="bi bi-lock"></i></span>
                            <input type="password" 
                                   name="password" 
                                   class="form-control" 
                                   id="passwordInput"
                                   placeholder="Minimal 6 karakter"
                                   required>
                            <span class="input-group-text append" id="togglePassword">
                                <i class="bi bi-eye-slash" id="eyeIcon"></i>
                            </span>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold" for="passwordConfirmInput">Konfirmasi Password</label>
                        <div class="input-group password-group">
                            <span class="input-group-text pre-pend"><i class="bi bi-lock-fill"></i></span>
                            <input type="password" 
                                   name="password_confirmation" 
                                   class="form-control" 
                                   id="passwordConfirmInput"
                                   placeholder="Ketik ulang password Anda"
                                   required>
                            <span class="input-group-text append" id="toggleConfirmPassword">
                                <i class="bi bi-eye-slash" id="eyeConfirmIcon"></i>
                            </span>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-register w-100 mb-4">
                        <i class="bi bi-person-plus-fill me-2"></i>Daftar Sekarang
                    </button>

                    <div class="text-center">
                        <p class="text-muted mb-0">
                            Sudah punya akun? 
                            <a href="{{ route('login') }}" class="text-decoration-none fw-bold">
                                Login di sini
                            </a>
                        </p>
                    </div>
                </form>

                <div class="password-requirements">
                    <strong class="d-block mb-2 text-dark"><i class="bi bi-key-fill me-2"></i>Persyaratan Password</strong>
                    <ul class="mb-0 ps-4">
                        <li>Minimal *6 karakter*</li>
                        <li>Pastikan *Password* dan *Konfirmasi Password* sama persis.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Fungsi untuk mengaktifkan show/hide password pada input tertentu
            function setupPasswordToggle(toggleId, inputId, iconId) {
                const toggle = document.getElementById(toggleId);
                const input = document.getElementById(inputId);
                const icon = document.getElementById(iconId);

                if (toggle && input && icon) {
                    toggle.addEventListener('click', function (e) {
                        // Toggle the type attribute
                        const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
                        input.setAttribute('type', type);
                        
                        // Toggle the eye icon
                        if (icon.classList.contains('bi-eye-slash')) {
                            icon.classList.remove('bi-eye-slash');
                            icon.classList.add('bi-eye');
                        } else {
                            icon.classList.remove('bi-eye');
                            icon.classList.add('bi-eye-slash');
                        }
                    });
                }
            }

            // Setup untuk Password Utama
            setupPasswordToggle('togglePassword', 'passwordInput', 'eyeIcon');
            
            // Setup untuk Konfirmasi Password
            setupPasswordToggle('toggleConfirmPassword', 'passwordConfirmInput', 'eyeConfirmIcon');
        });
    </script>
</body>
</html>