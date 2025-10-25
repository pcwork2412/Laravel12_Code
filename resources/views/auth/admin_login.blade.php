<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduManage Pro | School Management System</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Lottie Player --> <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
    <style>
        body {
            background: linear-gradient(to right, #4e54c8, #8f94fb);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-card {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            width: 100%;
            max-width: 900px; /* Compact for large screens */
        }

        .login-left {
            background: linear-gradient(135deg, #4e54c8, #8f94fb);
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 2rem;
        }

        .login-left lottie-player {
            width: 100%;
            max-width: 350px;
        }

        .login-right {
            padding: 2rem;
        }

        .welcome-text {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .btn-login {
            background: linear-gradient(to right, #4e54c8, #8f94fb);
            border: none;
            color: white;
            padding: 12px;
            border-radius: 10px;
            font-weight: 600;
        }

        .btn-login:hover {
            box-shadow: 0 8px 20px rgba(78, 84, 200, 0.4);
        }

        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .forgot-password {
            color: #4e54c8;
            text-decoration: none;
            font-size: 0.9rem;
        }

        .forgot-password:hover {
            color: #8f94fb;
        }

        .login-footer {
            text-align: center;
            font-size: 0.8rem;
            color: #6c757d;
            margin-top: 1.5rem;
        }

        .form-floating>.form-control:focus~label,
        .form-floating>.form-control:not(:placeholder-shown)~label {
            color: #4e54c8;
        }
    </style>
</head>

<body>
    <div class="card login-card shadow-sm">
        <div class="row g-0">
            <!-- Left Lottie Animation -->
            <div class="col-lg-6 d-flex login-left">
                <lottie-player src="https://assets2.lottiefiles.com/packages/lf20_jcikwtux.json"
                    background="transparent" speed="1" loop autoplay></lottie-player>
            </div>
            <!-- Left Lottie Animation (Large screens only) -->
{{-- <div class="col-lg-6 d-none d-lg-flex login-left">
    <lottie-player src="https://assets2.lottiefiles.com/packages/lf20_jcikwtux.json"
        background="transparent" speed="1" loop autoplay style="width:100%; max-width:350px;"></lottie-player>
</div> --}}

            <!-- Right Login Form -->
            <div class="col-lg-6 login-right">
                <h2 class="welcome-text">Welcome Back Admin</h2>

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.login.submit') }}">
                    @csrf

                    <div class="form-floating mb-3">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" placeholder="name@example.com" required autofocus>
                        <label for="email"><i class="fas fa-envelope me-2"></i>Email Address</label>
                        @error('email')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-floating mb-3">
                        <input id="password" type="password"
                            class="form-control @error('password') is-invalid @enderror" name="password"
                            placeholder="Password" required>
                        <label for="password"><i class="fas fa-lock me-2"></i>Password</label>
                        @error('password')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="remember-forgot">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="remember" id="remember"
                                {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">Remember Me</label>
                        </div>

                        @if (Route::has('password.request'))
                            <a class="forgot-password" href="{{ route('password.request') }}">Forgot Password?</a>
                        @endif
                    </div>

                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-login btn-lg">
                            <i class="fas fa-sign-in-alt me-2"></i>Login
                        </button>
                    </div>
                </form>

                <div class="login-footer">
                    <p>Need help? Contact support@edumanage.com</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
