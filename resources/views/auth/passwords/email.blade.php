<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lupa Password | RSHP UNAIR</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        body {
            background: linear-gradient(to right, #60aee1, #97e58a);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .login-container {
            width: 400px;
        }
        .login-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.15);
            overflow: hidden;
        }
        .login-header {
            background: white;
            padding: 30px 30px 20px;
            text-align: center;
        }
        .login-header img {
            width: 80px;
            height: auto;
            margin-bottom: 15px;
        }
        .login-header h1 {
            font-size: 22px;
            font-weight: 700;
            color: #333;
            margin: 0 0 5px 0;
            letter-spacing: 0.5px;
        }
        .login-header p {
            font-size: 13px;
            color: #777;
            margin: 0;
            line-height: 1.5;
        }
        .login-body {
            padding: 25px 30px 30px;
            background: white;
        }
        .login-message {
            text-align: center;
            color: #666;
            font-size: 14px;
            margin-bottom: 20px;
        }
        .form-control {
            height: 45px;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 10px 15px 10px 45px;
            font-size: 14px;
        }
        .form-control:focus {
            border-color: #7c6fd6;
            box-shadow: 0 0 0 0.2rem rgba(124, 111, 214, 0.15);
        }
        .input-wrapper {
            position: relative;
            margin-bottom: 15px;
        }
        .input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
            font-size: 16px;
            z-index: 10;
        }
        .btn-login {
            width: 100%;
            height: 45px;
            background: #7c6fd6;
            border: none;
            border-radius: 8px;
            color: white;
            font-size: 15px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.3s ease;
        }
        .btn-login:hover {
            background: #6b5ec5;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(124, 111, 214, 0.3);
        }
        .login-links {
            margin-top: 20px;
            text-align: center;
        }
        .login-links a {
            color: #7c6fd6;
            text-decoration: none;
            font-size: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
        }
        .login-links a:hover {
            color: #6b5ec5;
            text-decoration: underline;
        }
        .login-footer {
            text-align: center;
            color: white;
            font-size: 13px;
            margin-top: 20px;
        }
        .alert {
            border-radius: 8px;
            font-size: 14px;
            padding: 12px 15px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<div class="login-container">
    <div class="login-card">
        <!-- Header dengan Logo -->
        <div class="login-header">
            <img src="https://rshp.unair.ac.id/wp-content/uploads/2024/06/UNIVERSITAS-AIRLANGGA-scaled.webp" alt="Logo UNAIR">
            <h1>RSHP UNAIR</h1>
            <p>Rumah Sakit Hewan Pendidikan<br>Universitas Airlangga</p>
        </div>
        
        <!-- Body -->
        <div class="login-body">
            <p class="login-message">Masukkan email untuk reset password</p>

            @if (session('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    {{ session('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    @foreach($errors->all() as $error)
                        {{ $error }}<br>
                    @endforeach
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <!-- Email -->
                <div class="input-wrapper">
                    <i class="bi bi-envelope-fill input-icon"></i>
                    <input type="email" 
                           class="form-control @error('email') is-invalid @enderror" 
                           placeholder="Email" 
                           name="email" 
                           value="{{ old('email') }}" 
                           required 
                           autocomplete="email" 
                           autofocus>
                    @error('email')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn-login">
                    <i class="bi bi-send-fill"></i>
                    Kirim Link Reset Password
                </button>
            </form>

            <!-- Links -->
            <div class="login-links">
                <a href="{{ route('login') }}">
                    <i class="bi bi-arrow-left"></i>
                    Kembali ke Login
                </a>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="login-footer">
        &copy; {{ date('Y') }} RSHP UNAIR. All rights reserved.
    </div>
</div>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
