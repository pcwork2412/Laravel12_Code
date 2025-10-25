<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>EcoReset - Password Recovery</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
    {{-- font awesome cdn links --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <style>
        :root {
            --primary-green: #4e54c8;
            --light-green: #8f94fb;
            --dark-green: #343a40;
            --earth-brown: #8b4513;
            --sky-blue: #87ceeb;
            --leaf-green: #00b5fc;
            --forest-green: #0b2c5c;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, var(--sky-blue) 0%, var(--light-green) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            margin: 0;
        }

        .eco-container {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 20px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            max-width: 1000px;
            width: 100%;
            display: flex;
            flex-direction: row;
        }

        .eco-left {
            flex: 1;
            background: linear-gradient(135deg, var(--forest-green) 0%, var(--primary-green) 100%);
            color: white;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .eco-right {
            flex: 1;
            padding: 40px;
        }

        .eco-header {
            margin-bottom: 30px;
            text-align: center;
        }

        .eco-header h2 {
            color: var(--dark-green);
            font-weight: 700;
            margin-bottom: 10px;
        }

        .eco-header p {
            color: #666;
        }

        .eco-leaf-decoration {
            position: absolute;
            width: 150px;
            height: 150px;
            opacity: 0.1;
            /* background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%23228B22'%3E%3Cpath d='M17 8C8 10 5.9 16.17 3.82 21.34l1.89.66.95-2.3c.48.17.98.3 1.34.3C19 20 22 3 22 3c-1 2-8 2.25-13 3.25S2 11.5 2 13.5s1.75 3.75 1.75 3.75C7 8 17 8 17 8z'/%3E%3C/svg%3E"); */
            background-repeat: no-repeat;
            background-size: contain;
        }

        .leaf-1 {
            top: 10%;
            left: 5%;
            transform: rotate(15deg);
        }

        .leaf-2 {
            bottom: 10%;
            right: 5%;
            transform: rotate(-15deg);
        }

        .form-control {
            border-radius: 10px;
            padding: 12px 15px;
            border: 2px solid #e1e8ed;
            transition: all 0.3s;
        }

        .form-control:focus {
            border-color: var(--primary-green);
            box-shadow: 0 0 0 0.25rem rgba(46, 139, 87, 0.25);
        }

        .form-label {
            font-weight: 600;
            color: var(--dark-green);
            margin-bottom: 8px;
        }

        .btn-eco {
            background: linear-gradient(to right, var(--primary-green), var(--forest-green));
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            color: white;
            transition: all 0.3s;
            width: 100%;
        }

        .btn-eco:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(46, 139, 87, 0.4);
        }

        .password-strength {
            height: 5px;
            border-radius: 5px;
            margin-top: 5px;
            background: #e0e0e0;
            overflow: hidden;
        }

        .password-strength-bar {
            height: 100%;
            width: 0%;
            transition: width 0.3s, background 0.3s;
        }

        .validation-message {
            font-size: 0.85rem;
            margin-top: 5px;
            display: none;
        }

        .valid-feedback {
            color: var(--primary-green);
            display: block;
        }

        .invalid-feedback {
            color: #dc3545;
            display: block;
        }

        .eco-features {
            margin-top: 30px;
        }

        .eco-feature {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        .eco-feature-icon {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
        }

        @media (max-width: 768px) {
            .eco-container {
                flex-direction: column;
            }

            .eco-left {
                padding: 30px 20px;
            }

            .eco-right {
                padding: 30px 20px;
            }
        }
    </style>
</head>

<body>
    <div class="eco-leaf-decoration leaf-1"></div>
    <div class="eco-leaf-decoration leaf-2"></div>

    <div class="eco-container">
        <div class="eco-left">
            <lottie-player src="https://assets1.lottiefiles.com/packages/lf20_sk5h1kfn.json" background="transparent"
                speed="1" style="width: 100%; max-width: 300px;" loop autoplay>
            </lottie-player>
            <h3>Reset Your Password Securely</h3>
            <p>Protect your account with a strong, eco-friendly password. Remember, every secure password helps protect
                our digital environment!</p>

            <div class="eco-features">
                <div class="eco-feature">
                    <div class="eco-feature-icon">
                        {{-- <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                            viewBox="0 0 16 16">
                            <path
                                d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zm2.121 8.475-3.596 3.596a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 0-.707l.707-.707a.5.5 0 0 1 .707 0l.707.707 2.828-2.828a.5.5 0 0 1 .707 0l.707.707a.5.5 0 0 1 0 .707z" />
                        </svg> --}}
                        <i class="fa-solid fa-shield-alt fa-1x"></i>
                    </div>
                    <span>Strong encryption standards</span>
                </div>
                <div class="eco-feature">
                    <div class="eco-feature-icon">
                        {{-- <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                            viewBox="0 0 16 16">
                            <path
                                d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zM7 11.5a.5.5 0 0 1-1 0V6.707L5.354 7.854a.5.5 0 1 1-.708-.708l2-2a.5.5 0 0 1 .708 0l2 2a.5.5 0 0 1-.708.708L7 6.707V11.5z" />
                        </svg> --}}
                        <i class="fa-solid fa-lock fa-1x"></i>
                    </div>
                    <span>Environmentally conscious design</span>
                </div>
                <div class="eco-feature">
                    <div class="eco-feature-icon">
                        {{-- <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                            viewBox="0 0 16 16">
                            <path
                                d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zM5.5 8a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1H6a.5.5 0 0 1-.5-.5z" />
                        </svg> --}}
                        <i class="fa-solid fa-recycle fa-1x"></i>
                    </div>
                    <span>Simple and intuitive process</span>
                </div>
            </div>
        </div>

        <div class="eco-right">
            <div class="eco-header">
                <h2>Reset Your Password</h2>
                <p>Create a new secure password for your account</p>
            </div>

            <form method="POST" action="{{ route('password.store') }}" id="passwordResetForm">
                @csrf
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Email -->
                <div class="mb-4">
                    <label for="email" class="form-label">{{ __('Email Address') }}</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                        name="email" value="{{ old('email', $request->email) }}" required autofocus
                        placeholder="Enter your email address">
                    <div class="validation-message" id="email-validation">
                        @error('email')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label for="password" class="form-label">{{ __('Password') }}</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                        name="password" required placeholder="Create a new password">
                    <div class="password-strength">
                        <div class="password-strength-bar" id="password-strength-bar"></div>
                    </div>
                    <div class="validation-message" id="password-validation">
                        @error('password')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <small class="form-text text-muted">Use at least 8 characters with a mix of letters, numbers &
                        symbols</small>
                </div>

                <!-- Confirm Password -->
                <div class="mb-4">
                    <label for="password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>
                    <input id="password_confirmation" type="password" class="form-control" name="password_confirmation"
                        required placeholder="Confirm your new password">
                    <div class="validation-message" id="confirm-validation"></div>
                </div>

                <div class="mb-0">
                    <button type="submit" class="btn btn-eco">
                        {{ __('Reset Password') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');
            const confirmInput = document.getElementById('password_confirmation');
            const form = document.getElementById('passwordResetForm');
            const strengthBar = document.getElementById('password-strength-bar');

            // Email validation
            emailInput.addEventListener('blur', function() {
                const email = emailInput.value;
                const emailValidation = document.getElementById('email-validation');

                if (!email) {
                    emailValidation.innerHTML = '<span class="invalid-feedback">Email is required</span>';
                    emailValidation.style.display = 'block';
                    emailInput.classList.add('is-invalid');
                } else if (!isValidEmail(email)) {
                    emailValidation.innerHTML =
                        '<span class="invalid-feedback">Please enter a valid email address</span>';
                    emailValidation.style.display = 'block';
                    emailInput.classList.add('is-invalid');
                } else {
                    emailValidation.innerHTML = '<span class="valid-feedback">Email looks good!</span>';
                    emailValidation.style.display = 'block';
                    emailInput.classList.remove('is-invalid');
                    emailInput.classList.add('is-valid');
                }
            });

            // Password strength indicator
            passwordInput.addEventListener('input', function() {
                const password = passwordInput.value;
                const strength = checkPasswordStrength(password);
                const passwordValidation = document.getElementById('password-validation');

                // Update strength bar
                strengthBar.style.width = strength.percentage + '%';
                strengthBar.style.background = strength.color;

                // Validation message
                if (!password) {
                    passwordValidation.innerHTML =
                        '<span class="invalid-feedback">Password is required</span>';
                    passwordValidation.style.display = 'block';
                    passwordInput.classList.add('is-invalid');
                } else if (password.length < 8) {
                    passwordValidation.innerHTML =
                        '<span class="invalid-feedback">Password must be at least 8 characters</span>';
                    passwordValidation.style.display = 'block';
                    passwordInput.classList.add('is-invalid');
                } else {
                    passwordValidation.innerHTML =
                    `<span class="valid-feedback">${strength.message}</span>`;
                    passwordValidation.style.display = 'block';
                    passwordInput.classList.remove('is-invalid');
                    passwordInput.classList.add('is-valid');
                }

                // Check password confirmation if it has value
                if (confirmInput.value) {
                    validatePasswordMatch();
                }
            });

            // Confirm password validation
            confirmInput.addEventListener('blur', validatePasswordMatch);

            function validatePasswordMatch() {
                const password = passwordInput.value;
                const confirm = confirmInput.value;
                const confirmValidation = document.getElementById('confirm-validation');

                if (!confirm) {
                    confirmValidation.innerHTML =
                        '<span class="invalid-feedback">Please confirm your password</span>';
                    confirmValidation.style.display = 'block';
                    confirmInput.classList.add('is-invalid');
                } else if (password !== confirm) {
                    confirmValidation.innerHTML = '<span class="invalid-feedback">Passwords do not match</span>';
                    confirmValidation.style.display = 'block';
                    confirmInput.classList.add('is-invalid');
                } else {
                    confirmValidation.innerHTML = '<span class="valid-feedback">Passwords match!</span>';
                    confirmValidation.style.display = 'block';
                    confirmInput.classList.remove('is-invalid');
                    confirmInput.classList.add('is-valid');
                }
            }

            // Form submission validation
            form.addEventListener('submit', function(e) {
                let isValid = true;

                // Trigger validation for all fields
                emailInput.dispatchEvent(new Event('blur'));
                passwordInput.dispatchEvent(new Event('input'));
                confirmInput.dispatchEvent(new Event('blur'));

                // Check if any field is invalid
                if (emailInput.classList.contains('is-invalid') ||
                    passwordInput.classList.contains('is-invalid') ||
                    confirmInput.classList.contains('is-invalid')) {
                    isValid = false;
                    e.preventDefault();

                    // Show error message
                    alert('Please fix the errors before submitting the form.');
                }

                return isValid;
            });

            // Helper functions
            function isValidEmail(email) {
                const re =
                    /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                return re.test(String(email).toLowerCase());
            }

            function checkPasswordStrength(password) {
                let strength = 0;
                let messages = [];

                // Length check
                if (password.length >= 8) strength += 25;

                // Lowercase check
                if (/[a-z]/.test(password)) strength += 25;

                // Uppercase check
                if (/[A-Z]/.test(password)) strength += 25;

                // Number/Symbol check
                if (/[0-9]/.test(password) || /[^A-Za-z0-9]/.test(password)) strength += 25;

                // Determine message and color
                let message, color;
                if (strength < 50) {
                    message = "Weak password";
                    color = "#dc3545"; // Red
                } else if (strength < 75) {
                    message = "Medium strength password";
                    color = "#ffc107"; // Yellow
                } else {
                    message = "Strong password";
                    color = "#28a745"; // Green
                }

                return {
                    percentage: strength,
                    message: message,
                    color: color
                };
            }
        });
    </script>
</body>

</html>
