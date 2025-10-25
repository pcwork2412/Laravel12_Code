<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SecureReset - Password Recovery</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
    {{-- font awesome cdn link --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-blue: #1e88e5;
            --light-blue: #64b5f6;
            --dark-blue: #0d47a1;
            --ocean-blue: #0288d1;
            --sky-blue: #87ceeb;
            --ice-blue: #b3e5fc;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, var(--sky-blue) 0%, var(--ice-blue) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            margin: 0;
        }
        
        .blue-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            max-width: 1000px;
            width: 100%;
            display: flex;
            flex-direction: row;
        }
        
        .blue-left {
            flex: 1;
            background: linear-gradient(135deg, var(--dark-blue) 0%, var(--primary-blue) 100%);
            color: white;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            position: relative;
        }
        
        .blue-right {
            flex: 1;
            padding: 40px;
            position: relative;
        }
        
        .blue-header {
            margin-bottom: 30px;
            text-align: center;
        }
        
        .blue-header h2 {
            color: var(--dark-blue);
            font-weight: 700;
            margin-bottom: 10px;
        }
        
        .blue-header p {
            color: #666;
        }
        
        .wave-decoration {
            position: absolute;
            width: 100%;
            height: 100px;
            bottom: 0;
            left: 0;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1200 120' preserveAspectRatio='none'%3E%3Cpath d='M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z' fill='%23ffffff' fill-opacity='0.2'%3E%3C/path%3E%3C/svg%3E");
            background-size: cover;
        }
        
        .bubble {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            animation: float 6s ease-in-out infinite;
        }
        
        .bubble-1 {
            width: 80px;
            height: 80px;
            top: 10%;
            left: 10%;
            animation-delay: 0s;
        }
        
        .bubble-2 {
            width: 40px;
            height: 40px;
            top: 60%;
            left: 80%;
            animation-delay: 2s;
        }
        
        .bubble-3 {
            width: 60px;
            height: 60px;
            top: 80%;
            left: 20%;
            animation-delay: 4s;
        }
        
        @keyframes float {
            0% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(10deg); }
            100% { transform: translateY(0) rotate(0deg); }
        }
        
        .form-control {
            border-radius: 10px;
            padding: 12px 15px;
            border: 2px solid #e1e8ed;
            transition: all 0.3s;
        }
        
        .form-control:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 0.25rem rgba(30, 136, 229, 0.25);
        }
        
        .form-label {
            font-weight: 600;
            color: var(--dark-blue);
            margin-bottom: 8px;
        }
        
        .btn-blue {
            background: linear-gradient(to right, var(--primary-blue), var(--ocean-blue));
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            color: white;
            transition: all 0.3s;
            width: 100%;
        }
        
        .btn-blue:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(30, 136, 229, 0.4);
        }
        
        .validation-message {
            font-size: 0.85rem;
            margin-top: 5px;
            display: none;
        }
        
        .valid-feedback {
            color: var(--primary-blue);
            display: block;
        }
        
        .invalid-feedback {
            color: #dc3545;
            display: block;
        }
        
        .blue-features {
            margin-top: 30px;
        }
        
        .blue-feature {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }
        
        .blue-feature-icon {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
        }
        
        .back-to-login {
            text-align: center;
            margin-top: 20px;
        }
        
        .back-to-login a {
            color: var(--primary-blue);
            text-decoration: none;
            font-weight: 500;
        }
        
        .back-to-login a:hover {
            text-decoration: underline;
        }
        
        .lottie-container {
            width: 100%;
            max-width: 300px;
            margin: 0 auto 20px;
        }
        
        @media (max-width: 768px) {
            .blue-container {
                flex-direction: column;
            }
            
            .blue-left {
                padding: 30px 20px;
            }
            
            .blue-right {
                padding: 30px 20px;
            }
        }
    </style>
</head>

<body>
    <div class="blue-container">
        <div class="blue-left">
            <div class="bubble bubble-1"></div>
            <div class="bubble bubble-2"></div>
            <div class="bubble bubble-3"></div>
            <div class="wave-decoration"></div>
            
            {{-- <div class="lottie-container">
                <lottie-player 
                    src="https://assets5.lottiefiles.com/packages/lf20_6aY4Bc.json" 
                    background="transparent" 
                    speed="1" 
                    style="width: 100%; height: auto;" 
                    loop 
                    autoplay>
                </lottie-player>
            </div> --}}
            <h3>Reset Your Password</h3>
            <p>Enter your email address and we'll send you a link to reset your password securely.</p>
            
            <div class="blue-features">
                <div class="blue-feature">
                    <div class="blue-feature-icon">
                      <i class="fa-solid fa-shield-alt fa-1x"></i>
                    </div>
                    <span>Secure password reset process</span>
                </div>
                <div class="blue-feature">
                    <div class="blue-feature-icon">
                      <i class="fa-solid fa-clock"></i>
                    </div>
                    <span>Quick and easy recovery</span>
                </div>
                <div class="blue-feature">
                    <div class="blue-feature-icon">
                       <i class="fa-solid fa-lock fa-1x"></i>
                    </div>
                    <span>Encrypted communication</span>
                </div>
            </div>
        </div>
        
        <div class="blue-right">
            <div class="blue-header">
                <h2>Reset Your Password</h2>
                <p>Enter your email to receive a password reset link</p>
            </div>
            
            <form method="POST" action="{{ route('password.email') }}" id="passwordResetForm">
                @csrf

                <!-- Email -->
                <div class="mb-4">
                    <label for="email" class="form-label">{{ __('Email Address') }}</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                           name="email" value="{{ old('email') }}" required autofocus
                           placeholder="Enter your email address">
                    <div class="validation-message" id="email-validation">
                        @error('email')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="mb-0">
                    <button type="submit" class="btn btn-blue">
                        {{ __('Send Password Reset Link') }}
                    </button>
                </div>
                
                <div class="back-to-login">
                    <a href="{{ route('admin.login') }}">← Back to Login</a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const emailInput = document.getElementById('email');
            const form = document.getElementById('passwordResetForm');
            
            // Email validation
            emailInput.addEventListener('blur', function() {
                const email = emailInput.value;
                const emailValidation = document.getElementById('email-validation');
                
                if (!email) {
                    emailValidation.innerHTML = '<span class="invalid-feedback">Email is required</span>';
                    emailValidation.style.display = 'block';
                    emailInput.classList.add('is-invalid');
                } else if (!isValidEmail(email)) {
                    emailValidation.innerHTML = '<span class="invalid-feedback">Please enter a valid email address</span>';
                    emailValidation.style.display = 'block';
                    emailInput.classList.add('is-invalid');
                } else {
                    emailValidation.innerHTML = '<span class="valid-feedback">Email looks good!</span>';
                    emailValidation.style.display = 'block';
                    emailInput.classList.remove('is-invalid');
                    emailInput.classList.add('is-valid');
                }
            });
            
            // Form submission validation
            form.addEventListener('submit', function(e) {
                let isValid = true;
                
                // Trigger validation for email field
                emailInput.dispatchEvent(new Event('blur'));
                
                // Check if field is invalid
                if (emailInput.classList.contains('is-invalid')) {
                    isValid = false;
                    e.preventDefault();
                    
                    // Show error message
                    alert('Please fix the errors before submitting the form.');
                } else {
                    // Show success message
                    alert('Password reset link has been sent to your email!');
                }
                
                return isValid;
            });
            
            // Helper function for email validation
            function isValidEmail(email) {
                const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                return re.test(String(email).toLowerCase());
            }
        });
    </script>
</body>

</html>