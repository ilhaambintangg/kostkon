<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi OTP - KostKon</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .verify-container {
            max-width: 500px;
            width: 100%;
        }

        .verify-card {
            background: white;
            border-radius: 20px;
            padding: 50px 40px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            text-align: center;
        }

        .verify-icon {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 30px;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .verify-icon i {
            font-size: 3rem;
            color: white;
        }

        h2 {
            color: #667eea;
            margin-bottom: 15px;
            font-weight: bold;
        }

        .otp-input {
            width: 100%;
            padding: 20px;
            font-size: 28px;
            text-align: center;
            letter-spacing: 15px;
            border: 3px solid #e9ecef;
            border-radius: 15px;
            transition: all 0.3s;
            font-weight: bold;
        }

        .otp-input:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
            outline: none;
        }

        .btn-verify {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 15px;
            border-radius: 15px;
            color: white;
            font-weight: bold;
            font-size: 1.1rem;
            transition: all 0.3s;
            width: 100%;
        }

        .btn-verify:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
        }

        .btn-resend {
            background: transparent;
            border: 2px solid #667eea;
            color: #667eea;
            padding: 12px;
            border-radius: 15px;
            font-weight: bold;
            transition: all 0.3s;
            width: 100%;
        }

        .btn-resend:hover {
            background: #667eea;
            color: white;
        }

        .alert {
            border-radius: 15px;
            border: none;
        }

        .info-box {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 20px;
            margin-top: 20px;
        }

        .timer {
            font-size: 1.2rem;
            color: #667eea;
            font-weight: bold;
            margin: 15px 0;
        }

        @media (max-width: 576px) {
            .verify-card {
                padding: 40px 25px;
            }
            
            .otp-input {
                font-size: 24px;
                letter-spacing: 10px;
                padding: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="verify-container">
        <div class="verify-card">
            <div class="verify-icon">
                <i class="bi bi-shield-check"></i>
            </div>

            <h2>Verifikasi OTP</h2>
            <p class="text-muted mb-4">
                Masukkan kode verifikasi 6 digit yang telah dikirim ke email Anda
            </p>

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

            <form action="{{ route('verify') }}" method="POST" id="verifyForm">
                @csrf
                
                <div class="mb-4">
                    <input type="text" 
                           name="otp_code" 
                           class="otp-input" 
                           placeholder="000000" 
                           maxlength="6" 
                           pattern="\d{6}" 
                           required 
                           autofocus
                           autocomplete="off">
                    <small class="text-muted d-block mt-2">
                        <i class="bi bi-info-circle"></i> Cek folder inbox atau spam email Anda
                    </small>
                </div>

                <div class="timer" id="timer">
                    Kode akan kadaluarsa dalam: <span id="countdown">10:00</span>
                </div>

                <button type="submit" class="btn btn-verify mb-3">
                    <i class="bi bi-check-circle me-2"></i>Verifikasi
                </button>
            </form>

            <form action="{{ route('resend.otp') }}" method="POST" id="resendForm">
                @csrf
                <button type="submit" class="btn btn-resend" id="resendBtn">
                    <i class="bi bi-arrow-repeat me-2"></i>Kirim Ulang OTP
                </button>
            </form>

            <div class="info-box">
                <small class="text-muted">
                    <strong><i class="bi bi-shield-lock me-2"></i>Tips Keamanan:</strong><br>
                    • Jangan bagikan kode OTP kepada siapa pun<br>
                    • Pastikan email yang Anda gunakan valid<br>
                    • Kode hanya valid selama 10 menit
                </small>
            </div>

            <div class="mt-4">
                <a href="{{ route('register') }}" class="text-decoration-none" style="color: #667eea;">
                    <i class="bi bi-arrow-left me-2"></i>Kembali ke Registrasi
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Countdown Timer (10 minutes)
        let timeLeft = 600; // 10 menit = 600 detik

        function updateTimer() {
            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;
            document.getElementById('countdown').textContent = 
                `${minutes}:${seconds.toString().padStart(2, '0')}`;
            
            if (timeLeft > 0) {
                timeLeft--;
                setTimeout(updateTimer, 1000);
            } else {
                document.getElementById('timer').innerHTML = 
                    '<span class="text-danger">Kode OTP telah kadaluarsa! Silakan kirim ulang.</span>';
                document.getElementById('resendBtn').classList.add('btn-danger');
                document.getElementById('resendBtn').classList.remove('btn-resend');
            }
        }

        updateTimer();

        // Auto-submit when 6 digits entered
        document.querySelector('.otp-input').addEventListener('input', function(e) {
            if (e.target.value.length === 6) {
                // Optional: auto-submit
                // document.getElementById('verifyForm').submit();
            }
        });

        // Prevent paste non-numeric
        document.querySelector('.otp-input').addEventListener('paste', function(e) {
            e.preventDefault();
            const pastedText = (e.clipboardData || window.clipboardData).getData('text');
            const numericText = pastedText.replace(/\D/g, '').slice(0, 6);
            e.target.value = numericText;
        });

        // Only allow numbers
        document.querySelector('.otp-input').addEventListener('keypress', function(e) {
            if (!/\d/.test(e.key) && e.key !== 'Backspace' && e.key !== 'Delete') {
                e.preventDefault();
            }
        });
    </script>
</body>
</html>