<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            background-color: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .content {
            padding: 40px;
            text-align: center;
        }
        .otp-code {
            display: inline-block;
            background-color: #f8f9fa;
            border: 2px dashed #667eea;
            padding: 20px 40px;
            font-size: 32px;
            font-weight: bold;
            letter-spacing: 10px;
            color: #667eea;
            border-radius: 10px;
            margin: 20px 0;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #6c757d;
        }
        .warning {
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin: 20px 0;
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🏠 KostKon</h1>
            <p>Verifikasi Akun Anda</p>
        </div>
        
        <div class="content">
            <h2>Halo, {{ $userName }}!</h2>
            <p>Terima kasih telah mendaftar di KostKon. Gunakan kode OTP di bawah ini untuk memverifikasi akun Anda:</p>
            
            <div class="otp-code">
                {{ $otpCode }}
            </div>
            
            <p>Kode ini akan kadaluarsa dalam <strong>10 menit</strong>.</p>
            
            <div class="warning">
                <strong>⚠️ Peringatan Keamanan:</strong><br>
                Jangan bagikan kode ini kepada siapa pun, termasuk staff KostKon. Kami tidak akan pernah meminta kode OTP Anda.
            </div>
            
            <p>Jika Anda tidak melakukan registrasi, abaikan email ini.</p>
        </div>
        
        <div class="footer">
            <p>&copy; {{ date('Y') }} KostKon. All rights reserved.</p>
            <p>Email ini dikirim secara otomatis, mohon tidak membalas.</p>
        </div>
    </div>
</body>
</html>