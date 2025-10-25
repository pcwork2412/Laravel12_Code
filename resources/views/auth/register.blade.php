<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register - Admin Panel</title>
    <style>
        :root {
            --primary-color: #4361ee;
            --primary-dark: #3a56d4;
            --success-color: #4cc9f0;
            --danger-color: #f72585;
            --light-color: #f8f9fa;
            --dark-color: #212529;
            --gray-color: #6c757d;
            --border-color: #dee2e6;
            --shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .container {
            width: 100%;
            max-width: 450px;
            margin: 0 auto;
        }
        
        .card {
            background-color: white;
            border-radius: 12px;
            box-shadow: var(--shadow);
            overflow: hidden;
            transition: var(--transition);
        }
        
        .card:hover {
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }
        
        .card-header {
            background-color: var(--primary-color);
            color: white;
            padding: 20px;
            text-align: center;
            font-size: 1.5rem;
            font-weight: 600;
        }
        
        .card-body {
            padding: 30px;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
            position: relative;
        }
        
        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--dark-color);
            transition: var(--transition);
        }
        
        .form-control {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 1rem;
            transition: var(--transition);
            background-color: var(--light-color);
        }
        
        .form-control:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.2);
            background-color: white;
        }
        
        .form-control.is-invalid {
            border-color: var(--danger-color);
        }
        
        .invalid-feedback {
            display: block;
            color: var(--danger-color);
            font-size: 0.875rem;
            margin-top: 5px;
        }
        
        .password-toggle {
            position: absolute;
            right: 12px;
            top: 38px;
            background: none;
            border: none;
            color: var(--gray-color);
            cursor: pointer;
            font-size: 0.9rem;
        }
        
        .password-toggle:hover {
            color: var(--primary-color);
        }
        
        .btn {
            display: block;
            width: 100%;
            padding: 14px;
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
        }
        
        .btn:hover {
            background-color: var(--primary-dark);
            transform: translateY(-2px);
        }
        
        .form-footer {
            text-align: center;
            margin-top: 20px;
            color: var(--gray-color);
            font-size: 0.9rem;
        }
        
        .form-footer a {
            color: var(--primary-color);
            text-decoration: none;
        }
        
        .form-footer a:hover {
            text-decoration: underline;
        }
        
        .input-icon {
            position: relative;
        }
        
        .input-icon i {
            position: absolute;
            left: 15px;
            top: 42px;
            color: var(--gray-color);
        }
        
        .input-icon .form-control {
            padding-left: 40px;
        }
        
        @media (max-width: 576px) {
            .card-body {
                padding: 20px;
            }
            
            .card-header {
                padding: 15px;
                font-size: 1.3rem;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <div class="container">
        <div class="card">
            <div class="card-header">{{ __('Create Account') }}</div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.register.store') }}">
                    @csrf
                    
                    <!-- Name -->
                    <div class="form-group input-icon">
                        <label for="name" class="form-label">{{ __('Full Name') }}</label>
                        <i class="fas fa-user"></i>
                        <input id="name" type="text"
                            class="form-control @error('name') is-invalid @enderror" name="name"
                            value="{{ old('name') }}" required autofocus placeholder="Enter your full name">
                        @error('name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="form-group input-icon">
                        <label for="email" class="form-label">{{ __('Email Address') }}</label>
                        <i class="fas fa-envelope"></i>
                        <input id="email" type="email"
                            class="form-control @error('email') is-invalid @enderror" name="email"
                            value="{{ old('email') }}" required placeholder="Enter your email">
                        @error('email')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="form-group input-icon">
                        <label for="password" class="form-label">{{ __('Password') }}</label>
                        <i class="fas fa-lock"></i>
                        <input value="" id="password" type="password"
                            class="form-control @error('password') is-invalid @enderror" name="password" required placeholder="Create a password">
                        <button type="button" class="password-toggle" id="togglePassword">
                            <i class="fas fa-eye"></i>
                        </button>
                        @error('password')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="form-group input-icon">
                        <label for="password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>
                        <i class="fas fa-lock"></i>
                        <input value="" id="password_confirmation" type="password" class="form-control"
                            name="password_confirmation" required placeholder="Confirm your password">
                        <button type="button" class="password-toggle" id="togglePasswordConfirmation">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn">
                            {{ __('Create Account') }}
                        </button>
                    </div>
                    
                    <div class="form-footer">
                        Already have an account? <a href="{{ route('admin.login') }}">Sign In</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Password visibility toggle
        document.addEventListener('DOMContentLoaded', function() {
            const togglePassword = document.getElementById('togglePassword');
            const togglePasswordConfirmation = document.getElementById('togglePasswordConfirmation');
            const password = document.getElementById('password');
            const passwordConfirmation = document.getElementById('password_confirmation');
            
            togglePassword.addEventListener('click', function() {
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);
                this.querySelector('i').classList.toggle('fa-eye');
                this.querySelector('i').classList.toggle('fa-eye-slash');
            });
            
            togglePasswordConfirmation.addEventListener('click', function() {
                const type = passwordConfirmation.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordConfirmation.setAttribute('type', type);
                this.querySelector('i').classList.toggle('fa-eye');
                this.querySelector('i').classList.toggle('fa-eye-slash');
            });
            
            // Add focus effects to form controls
            const formControls = document.querySelectorAll('.form-control');
            formControls.forEach(control => {
                control.addEventListener('focus', function() {
                    this.parentElement.querySelector('.form-label').style.color = 'var(--primary-color)';
                });
                
                control.addEventListener('blur', function() {
                    this.parentElement.querySelector('.form-label').style.color = 'var(--dark-color)';
                });
            });
        });
    </script>
</body>
</html>