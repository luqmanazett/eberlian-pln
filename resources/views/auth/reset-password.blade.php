<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Reset Password - E-Berlian</title>
    
    {{-- Font Inter --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        :root {
            --pln-primary: #46C2B3;
            --pln-primary-dark: #359A8F;
            --pln-primary-light: #D4F5F0;
            --pln-danger: #EF4444;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: white;
            min-height: 100vh;
            position: relative;
        }
        
        .half-circle-bg {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 45vh;
            min-height: 300px;
            background-color: var(--pln-primary-dark);
            background-image: url('{{ asset("images/login-bg.png") }}');
            background-size: cover;
            background-position: center bottom;
            background-repeat: no-repeat;
            z-index: 1;
            border-bottom-left-radius: 40px;
            border-bottom-right-radius: 40px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
        
        .page-wrapper {
            position: relative;
            z-index: 10;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 24px 20px;
        }
        
        .header-section {
            text-align: center;
            margin-bottom: 24px;
            position: relative;
            z-index: 15;
            width: 100%;
        }
        
        .header-section img {
            height: 65px;
            width: auto;
            margin-bottom: 12px;
            display: block;
            margin-left: auto;
            margin-right: auto;
            filter: drop-shadow(0 4px 6px rgba(0,0,0,0.1));
        }
        
        .header-section h1 {
            font-size: 28px;
            font-weight: 700;
            color: white;
            margin-bottom: 6px;
            text-shadow: 0 2px 4px rgba(0,0,0,0.2);
            letter-spacing: -0.5px;
        }
        
        .header-section .tagline {
            font-size: 14px;
            color: rgba(255,255,255,0.95);
            line-height: 1.5;
            text-shadow: 0 1px 2px rgba(0,0,0,0.2);
        }
        
        .login-card {
            max-width: 400px;
            width: 100%;
            background: white;
            border-radius: 24px;
            padding: 32px 24px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.15);
            position: relative;
            z-index: 20;
            margin-bottom: 24px;
        }
        
        .welcome-text {
            margin-bottom: 20px;
            text-align: center;
        }
        
        .welcome-text h2 {
            font-size: 20px;
            font-weight: 700;
            color: #1F2937;
            margin-bottom: 8px;
        }
        
        .welcome-text p {
            font-size: 13px;
            color: #6B7280;
            line-height: 1.5;
        }
        
        .form-group {
            margin-bottom: 16px;
        }
        
        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 500;
            color: #374151;
            margin-bottom: 5px;
        }
        
        .form-input {
            width: 100%;
            padding: 12px 14px;
            border: 1.5px solid #E5E7EB;
            border-radius: 10px;
            font-size: 15px;
            background: white;
            transition: border-color 0.2s;
        }
        
        .form-input:focus {
            outline: none;
            border-color: var(--pln-primary);
            box-shadow: 0 0 0 3px rgba(70,194,179,0.15);
        }
        
        .btn-login {
            width: 100%;
            padding: 14px;
            background: #0F766E;
            border: none;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 600;
            color: white;
            cursor: pointer;
            transition: all 0.2s ease;
            margin-top: 10px;
            box-shadow: 0 4px 12px rgba(15, 118, 110, 0.2);
        }
        
        .btn-login:hover {
            background: #115E59;
            box-shadow: 0 6px 16px rgba(15, 118, 110, 0.3);
            transform: translateY(-1px);
        }
        
        .btn-login:active {
            transform: translateY(1px);
            box-shadow: 0 2px 8px rgba(15, 118, 110, 0.2);
        }
        
        .error-message {
            background: #FEE2E2;
            color: #991B1B;
            padding: 10px;
            border-radius: 8px;
            font-size: 13px;
            margin-bottom: 16px;
        }

        .success-message {
            background: #D1FAE5;
            color: #065F46;
            padding: 12px;
            border-radius: 8px;
            font-size: 13px;
            margin-bottom: 16px;
            text-align: center;
        }
        
        .footer {
            margin-top: 12px;
            position: relative;
            z-index: 20;
        }
        
        .footer p {
            font-size: 10px;
            color: #9CA3AF;
            text-align: center;
        }
        
        .fallback-logo {
            width: 60px;
            height: 60px;
            background: white;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 12px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.08);
        }
        
        .fallback-logo span {
            color: var(--pln-primary);
            font-size: 28px;
            font-weight: bold;
        }
        
        .register-link {
            text-align: center;
            margin-bottom: 24px;
            position: relative;
            z-index: 20;
        }
        
        .register-link a {
            font-size: 13px;
            color: var(--pln-primary);
            text-decoration: none;
            font-weight: 500;
        }
    </style>
</head>
<body>
    <div class="half-circle-bg"></div>
    
    <div class="page-wrapper">
        <div class="header-section">
            @if(file_exists(public_path('images/pln-logo.png')))
            <img src="{{ asset('images/pln-logo.png') }}" alt="PLN">
            @else
            <div class="fallback-logo">
                <span>PLN</span>
            </div>
            @endif
            
            <h1>E-Berlian</h1>
            <div class="tagline">
                Elektronik Berita Acara Lingkungan<br>
                dan Pertanahan
            </div>
        </div>
        
        <div class="login-card">
            <div class="welcome-text">
                <h2>Buat Password Baru</h2>
                <p>Silakan buat password baru yang kuat untuk akun Anda.</p>
            </div>

            @if($errors->any())
            <div class="error-message">
                {{ $errors->first() }}
            </div>
            @endif
            
            <form method="POST" action="{{ route('password.store') }}">
                @csrf
                
                <input type="hidden" name="token" value="{{ $request->route('token') }}">
                
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" value="{{ old('email', $request->email) }}" 
                           class="form-input" placeholder="Masukkan email Anda" required readonly style="background-color: #f3f4f6; color: #6b7280; cursor: not-allowed;">
                </div>

                <div class="form-group">
                    <label class="form-label">Password Baru</label>
                    <input type="password" name="password" class="form-input" placeholder="Minimal 8 karakter" required autofocus>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" class="form-input" placeholder="Ulangi password baru" required>
                </div>
                
                <button type="submit" class="btn-login">
                    Simpan Password Baru
                </button>
            </form>
        </div>
        
        <div class="register-link">
            <a href="{{ route('login') }}">← Kembali ke halaman Login</a>
        </div>
        
        <div class="footer">
            <p>Sistem dibangun oleh Luqmanazet - Tim Magang 2026</p>
        </div>
    </div>
</body>
</html>
