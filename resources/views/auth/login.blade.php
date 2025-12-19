<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkpoint Tracker - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), 
                        url('https://images.unsplash.com/photo-1494412651409-8963ce7935a7?w=1920') center/cover no-repeat fixed;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-container {
            width: 100%;
            max-width: 450px;
            padding: 20px;
        }

        .logo-section {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo-icon {
            width: 60px;
            height: 60px;
            background: #D4AF37;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
        }

        .logo-icon svg {
            width: 35px;
            height: 35px;
            fill: #000;
        }

        .app-title {
            color: #fff;
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 5px;
            letter-spacing: 1px;
        }

        .app-subtitle {
            color: #D4AF37;
            font-size: 13px;
            letter-spacing: 0.5px;
        }

        .login-card {
            background: rgba(30, 30, 30, 0.95);
            border: 1px solid #D4AF37;
            border-radius: 12px;
            padding: 35px 40px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4);
        }

        .login-header {
            text-align: center;
            margin-bottom: 25px;
        }

        .login-header h2 {
            color: #fff;
            font-size: 22px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .login-header p {
            color: #999;
            font-size: 13px;
        }

        .form-label {
            color: #D4AF37;
            font-size: 12px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }

        .form-control {
            background: rgba(50, 50, 50, 0.8);
            border: 1px solid #555;
            color: #fff;
            padding: 12px 15px;
            font-size: 14px;
            border-radius: 6px;
            transition: all 0.3s;
        }

        .form-control:focus {
            background: rgba(60, 60, 60, 0.9);
            border-color: #D4AF37;
            color: #fff;
            box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.1);
        }

        .form-control::placeholder {
            color: #777;
        }

        .btn-login {
            width: 100%;
            background: #D4AF37;
            color: #000;
            border: none;
            padding: 13px;
            font-size: 15px;
            font-weight: 600;
            border-radius: 6px;
            margin-top: 20px;
            transition: all 0.3s;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn-login:hover {
            background: #C19B2C;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(212, 175, 55, 0.4);
        }

        .alert {
            background: rgba(220, 53, 69, 0.15);
            border: 1px solid #dc3545;
            color: #ff6b6b;
            border-radius: 6px;
            padding: 12px;
            margin-bottom: 20px;
            font-size: 13px;
        }

        .text-danger {
            color: #ff6b6b !important;
            font-size: 12px;
            margin-top: 5px;
        }

        .footer-text {
            text-align: center;
            color: #999;
            font-size: 12px;
            margin-top: 25px;
        }

        .is-invalid {
            border-color: #dc3545 !important;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="logo-section">
            <div class="logo-icon">
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M20 8h-3V4H3c-1.1 0-2 .9-2 2v11h2c0 1.66 1.34 3 3 3s3-1.34 3-3h6c0 1.66 1.34 3 3 3s3-1.34 3-3h2v-5l-3-4zM6 18.5c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zm13.5-9l1.96 2.5H17V9.5h2.5zm-1.5 9c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5z"/>
                </svg>
            </div>
            <h1 class="app-title">CHECKPOINT TRACKER</h1>
            <p class="app-subtitle">Unit Tracking & Monitoring System</p>
        </div>

        <div class="login-card">
            <div class="login-header">
                <h2>LOGIN</h2>
                <p>Pilih role dan masukkan kredensial Anda</p>
            </div>

            @if ($message = Session::get('success'))
                <div class="alert">
                    {{ $message }}
                </div>     
            @endif

            <form action="{{ route('authenticate') }}" method="post">
                @csrf
                
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" 
                           class="form-control @error('email') is-invalid @enderror" 
                           id="email" 
                           name="email" 
                           value="{{ old('email') }}"
                           placeholder="email@example.com">
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" 
                           class="form-control @error('password') is-invalid @enderror" 
                           id="password" 
                           name="password"
                           placeholder="••••••••">
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn-login">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" style="margin-right: 8px; vertical-align: middle;">
                        <path d="M10 17l5-5-5-5v10z"/>
                    </svg>
                    Masuk
                </button>
            </form>

            <div class="footer-text">
                © 2024 Checkpoint Tracker System
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>