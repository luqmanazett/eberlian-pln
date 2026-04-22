<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - SIPEL PLN</title>
    
    {{-- Font Inter --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        :root {
            --pln-yellow: #FFD100;
            --pln-yellow-dark: #E6BC00;
            --pln-blue: #005B9F;
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
        
        {{-- Background setengah lingkaran (hanya di bagian atas) --}}
        .half-circle-bg {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 280px;
            background-image: url('{{ asset("images/login-bg.png") }}');
            background-size: cover;
            background-position: center top;
            border-bottom-left-radius: 50% 30%;
            border-bottom-right-radius: 50% 30%;
            z-index: 1;
        }
        
        {{-- Overlay kuning transparan --}}
        .half-circle-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 280px;
            background: linear-gradient(135deg, rgba(255,209,0,0.5) 0%, rgba(255,209,0,0.2) 100%);
            border-bottom-left-radius: 50% 30%;
            border-bottom-right-radius: 50% 30%;
            z-index: 2;
        }
        
        {{-- Container Utama --}}
        .page-wrapper {
            position: relative;
            z-index: 10;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 16px 16px 20px;
        }
        
        {{-- Logo & Judul (di atas background setengah lingkaran) --}}
        .header-section {
            text-align: center;
            margin-bottom: 16px;
            margin-top: 20px;
            position: relative;
            z-index: 15;
        }
        
        .header-section img {
            height: 60px;
            width: auto;
            margin-bottom: 12px;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }
        
        .header-section h1 {
            font-size: 26px;
            font-weight: 700;
            color: #1F2937;
            margin-bottom: 4px;
        }
        
        .header-section .tagline {
            font-size: 13px;
            color: #4B5563;
            line-height: 1.4;
        }
        
        {{-- Card Form - PUTIH SOLID --}}
        .login-card {
            max-width: 420px;
            width: 100%;
            background: white;
            border-radius: 20px;
            padding: 24px 20px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            border: 1px solid #F0F0F0;
            position: relative;
            z-index: 20;
        }
        
        {{-- Welcome Text - CENTER --}}
        .welcome-text {
            margin-bottom: 20px;
            text-align: center;
        }
        
        .welcome-text h2 {
            font-size: 20px;
            font-weight: 700;
            color: #1F2937;
            margin-bottom: 4px;
        }
        
        .welcome-text p {
            font-size: 13px;
            color: #6B7280;
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
            border-color: var(--pln-yellow);
            box-shadow: 0 0 0 3px rgba(255,209,0,0.15);
        }
        
        .forgot-link a {
            font-size: 12px;
            color: var(--pln-blue);
            text-decoration: none;
            font-weight: 500;
        }
        
        .btn-login {
            width: 100%;
            padding: 14px;
            background: var(--pln-yellow);
            border: none;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 600;
            color: #1F2937;
            cursor: pointer;
            transition: all 0.2s;
            margin-top: 6px;
        }
        
        .btn-login:hover {
            background: var(--pln-yellow-dark);
        }
        
        .btn-login:active {
            transform: scale(0.98);
        }
        
        .session-info {
            text-align: center;
            margin-top: 16px;
        }
        
        .session-info p {
            font-size: 11px;
            color: #9CA3AF;
        }
        
        .error-message {
            background: #FEE2E2;
            color: #991B1B;
            padding: 10px;
            border-radius: 8px;
            font-size: 13px;
            margin-bottom: 16px;
        }
        
        .remember-me {
            display: flex;
            align-items: center;
            gap: 6px;
        }
        
        .remember-me input {
            width: 16px;
            height: 16px;
            accent-color: var(--pln-yellow);
        }
        
        .remember-me label {
            font-size: 13px;
            color: #6B7280;
        }
        
        .flex {
            display: flex;
        }
        
        .items-center {
            align-items: center;
        }
        
        .justify-between {
            justify-content: space-between;
        }
        
        {{-- Footer - LEBIH BAWAH --}}
        .footer {
            margin-top: 24px;
            margin-bottom: 8px;
            position: relative;
            z-index: 20;
        }
        
        .footer p {
            font-size: 10px;
            color: #9CA3AF;
            text-align: center;
        }
        
        {{-- Fallback logo --}}
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
            color: var(--pln-blue);
            font-size: 28px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    {{-- Background setengah lingkaran --}}
    <div class="half-circle-bg"></div>
    <div class="half-circle-overlay"></div>
    
    {{-- Container Utama --}}
    <div class="page-wrapper">
        
        {{-- Logo & Judul (di atas background) --}}
        <div class="header-section">
            @if(file_exists(public_path('images/pln-logo.png')))
            <img src="{{ asset('images/pln-logo.png') }}" alt="PLN">
            @else
            <div class="fallback-logo">
                <span>PLN</span>
            </div>
            @endif
            
            <h1>SIPEL PLN</h1>
            <div class="tagline">
                Sistem Informasi Permohonan<br>
                Pelanggan PLN
            </div>
        </div>
        
        {{-- Card Form Putih --}}
        <div class="login-card">
            
            {{-- Welcome - CENTER --}}
            <div class="welcome-text">
                <h2>Selamat datang!</h2>
                <p>Silakan login untuk melanjutkan</p>
            </div>
            
            {{-- Error Message --}}
            @if($errors->any())
            <div class="error-message">
                {{ $errors->first() }}
            </div>
            @endif
            
            {{-- Login Form --}}
            <form method="POST" action="{{ route('login') }}">
                @csrf
                
                {{-- Email --}}
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" 
                           class="form-input" placeholder="Masukkan email Anda" required autofocus>
                </div>
                
                {{-- Password --}}
                <div class="form-group">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" 
                           class="form-input" placeholder="Masukkan password Anda" required>
                </div>
                
                {{-- Remember Me & Forgot Password --}}
                <div class="flex items-center justify-between">
                    <div class="remember-me">
                        <input type="checkbox" name="remember" id="remember">
                        <label for="remember">Ingat saya</label>
                    </div>
                    
                    <div class="forgot-link">
                        <a href="{{ route('password.request') }}">Lupa password?</a>
                    </div>
                </div>
                
                {{-- Login Button --}}
                <button type="submit" class="btn-login">
                    Login
                </button>
            </form>
            {{-- Register Link --}}
<div class="text-center mt-4">
    <p class="text-sm text-gray-600">
        Belum punya akun? 
        <a href="{{ route('register') }}" class="text-pln-primary font-medium">Daftar di sini</a>
    </p>
</div>
            
            {{-- Session Info --}}
            <div class="session-info">
                <p>⏱️ Session akan berakhir setelah 10 menit tidak aktif</p>
            </div>
            
        </div>
        
        {{-- Footer - Lebih Bawah --}}
        <div class="footer">
            <p>© 2026 Luqman Azet. All rights reserved.</p>
        </div>
        
    </div>
</body>
</html>