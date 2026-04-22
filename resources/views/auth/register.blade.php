<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Daftar - SIPEL PLN</title>
    
    {{-- Font Inter --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        :root {
            --pln-primary: #008080;
            --pln-primary-dark: #006666;
            --pln-primary-light: #E0F2F2;
            --pln-danger: #EF4444;
            --pln-gray-bg: #F5F7FA;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: linear-gradient(135deg, var(--pln-primary-light) 0%, #E8F5F5 50%, var(--pln-primary-light) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 16px;
        }
        
        .register-container {
            max-width: 440px;
            width: 100%;
            background: white;
            border-radius: 24px;
            padding: 28px 24px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        }
        
        .logo-section {
            text-align: center;
            margin-bottom: 24px;
        }
        
        .logo-section h1 {
            font-size: 24px;
            font-weight: 700;
            color: var(--pln-primary);
            margin-bottom: 4px;
        }
        
        .logo-section p {
            font-size: 13px;
            color: #6B7280;
        }
        
        .welcome-text {
            margin-bottom: 24px;
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
        
        .form-label .required {
            color: var(--pln-danger);
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
            box-shadow: 0 0 0 3px rgba(0,128,128,0.15);
        }
        
        .btn-register {
            width: 100%;
            padding: 14px;
            background: var(--pln-primary);
            border: none;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 600;
            color: white;
            cursor: pointer;
            transition: all 0.2s;
            margin-top: 8px;
        }
        
        .btn-register:hover {
            background: var(--pln-primary-dark);
        }
        
        .btn-register:active {
            transform: scale(0.98);
        }
        
        .login-link {
            text-align: center;
            margin-top: 20px;
            padding-top: 16px;
            border-top: 1px solid #F0F0F0;
        }
        
        .login-link a {
            color: var(--pln-primary);
            text-decoration: none;
            font-weight: 500;
            font-size: 14px;
        }
        
        .error-message {
            background: #FEE2E2;
            color: #991B1B;
            padding: 10px;
            border-radius: 8px;
            font-size: 13px;
            margin-bottom: 16px;
        }
        
        .input-error {
            border-color: var(--pln-danger) !important;
        }
        
        .error-text {
            color: var(--pln-danger);
            font-size: 12px;
            margin-top: 4px;
        }
    </style>
</head>
<body>
    <div class="register-container">
        
        {{-- Logo --}}
        <div class="logo-section">
            <h1>⚡ SIPEL PLN</h1>
            <p>Sistem Informasi Permohonan Pelanggan PLN</p>
        </div>
        
        {{-- Welcome --}}
        <div class="welcome-text">
            <h2>Daftar Akun</h2>
            <p>Isi data diri Anda dengan lengkap</p>
        </div>
        
        {{-- Error Message --}}
        @if($errors->any())
        <div class="error-message">
            @foreach($errors->all() as $error)
            <p>{{ $error }}</p>
            @endforeach
        </div>
        @endif
        
        {{-- Register Form --}}
        <form method="POST" action="{{ route('register') }}">
            @csrf
            
            {{-- Nama Lengkap --}}
            <div class="form-group">
                <label class="form-label">Nama Lengkap <span class="required">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" 
                       class="form-input @error('name') input-error @enderror" 
                       placeholder="Sesuai KTP" required>
                @error('name')
                <p class="error-text">{{ $message }}</p>
                @enderror
            </div>
            
            {{-- No KTP (NIK) --}}
            <div class="form-group">
                <label class="form-label">Nomor KTP (NIK) <span class="required">*</span></label>
                <input type="text" name="no_ktp" value="{{ old('no_ktp') }}" 
                       class="form-input @error('no_ktp') input-error @enderror" 
                       placeholder="16 digit" maxlength="16" required>
                @error('no_ktp')
                <p class="error-text">{{ $message }}</p>
                @enderror
            </div>
            
            {{-- Email --}}
            <div class="form-group">
                <label class="form-label">Email <span class="required">*</span></label>
                <input type="email" name="email" value="{{ old('email') }}" 
                       class="form-input @error('email') input-error @enderror" 
                       placeholder="contoh@email.com" required>
                @error('email')
                <p class="error-text">{{ $message }}</p>
                @enderror
            </div>
            
            {{-- Nomor Telepon --}}
            <div class="form-group">
                <label class="form-label">Nomor Telepon <span class="required">*</span></label>
                <input type="tel" name="no_telepon" value="{{ old('no_telepon') }}" 
                       class="form-input @error('no_telepon') input-error @enderror" 
                       placeholder="081234567890" required>
                @error('no_telepon')
                <p class="error-text">{{ $message }}</p>
                @enderror
            </div>
            
            {{-- Password --}}
            <div class="form-group">
                <label class="form-label">Password <span class="required">*</span></label>
                <input type="password" name="password" 
                       class="form-input @error('password') input-error @enderror" 
                       placeholder="Minimal 8 karakter" required>
                @error('password')
                <p class="error-text">{{ $message }}</p>
                @enderror
            </div>
            
            {{-- Konfirmasi Password --}}
            <div class="form-group">
                <label class="form-label">Konfirmasi Password <span class="required">*</span></label>
                <input type="password" name="password_confirmation" 
                       class="form-input" 
                       placeholder="Ulangi password" required>
            </div>
            
            {{-- Register Button --}}
            <button type="submit" class="btn-register">
                Daftar Sekarang
            </button>
        </form>
        
        {{-- Login Link --}}
        <div class="login-link">
            <a href="{{ route('login') }}">← Sudah punya akun? Login</a>
        </div>
        
    </div>
</body>
</html>