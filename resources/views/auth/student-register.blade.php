{{-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration | EduManage Pro</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Lottie Player -->
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>

    <style>
        :root {
            --primary: #4e54c8;
            --secondary: #8f94fb;
            --accent: #ff7e5f;
            --light: #f8f9fa;
            --dark: #343a40;
            --success: #28a745;
            --danger: #dc3545;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: linear-gradient(to right, var(--primary), var(--secondary));
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            overflow-x: hidden;
        }

        .background-shapes {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            overflow: hidden;
        }

        .background-shapes div {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
        }

        .background-shapes div:nth-child(1) {
            width: 80px;
            height: 80px;
            top: 20%;
            left: 10%;
            animation: float 15s infinite ease-in-out;
        }

        .background-shapes div:nth-child(2) {
            width: 120px;
            height: 120px;
            top: 60%;
            left: 80%;
            animation: float 18s infinite ease-in-out;
        }

        .background-shapes div:nth-child(3) {
            width: 60px;
            height: 60px;
            top: 80%;
            left: 15%;
            animation: float 12s infinite ease-in-out;
        }

        .background-shapes div:nth-child(4) {
            width: 100px;
            height: 100px;
            top: 10%;
            left: 75%;
            animation: float 20s infinite ease-in-out;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0) translateX(0);
            }

            25% {
                transform: translateY(-20px) translateX(10px);
            }

            50% {
                transform: translateY(10px) translateX(20px);
            }

            75% {
                transform: translateY(20px) translateX(-10px);
            }
        }

        .registration-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            width: 100%;
            max-width: 1000px;
            min-height: 600px;
            display: flex;
            z-index: 1;
        }

        .registration-left {
            flex: 1;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            position: relative;
        }

        .registration-right {
            flex: 1;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .system-name {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 10px;
            color: white;
            text-align: center;
        }

        .system-tagline {
            font-size: 16px;
            margin-bottom: 30px;
            text-align: center;
            opacity: 0.9;
        }

        .lottie-container {
            width: 100%;
            max-width: 350px;
            margin: 0 auto;
        }

        .welcome-text {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 30px;
            color: var(--dark);
            text-align: center;
        }

        .form-control {
            border-radius: 10px;
            padding: 12px 20px;
            border: 2px solid #e1e1e1;
            transition: all 0.3s;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.25rem rgba(78, 84, 200, 0.25);
        }

        .input-group-text {
            background: transparent;
            border-radius: 10px 0 0 10px;
            border: 2px solid #e1e1e1;
            border-right: none;
        }

        .form-floating>.form-control:focus~label,
        .form-floating>.form-control:not(:placeholder-shown)~label {
            transform: scale(0.85) translateY(-0.5rem) translateX(0.15rem);
            color: var(--primary);
        }

        .btn-register {
            background: linear-gradient(to right, var(--primary), var(--secondary));
            border: none;
            color: white;
            padding: 12px;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(78, 84, 200, 0.3);
        }

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(78, 84, 200, 0.4);
        }

        .registration-footer {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #6c757d;
        }

        .alert {
            border-radius: 10px;
            border: none;
            padding: 12px 15px;
        }

        .alert-success {
            background-color: rgba(40, 167, 69, 0.15);
            color: #28a745;
        }

        .alert-danger {
            background-color: rgba(220, 53, 69, 0.15);
            color: #dc3545;
        }

        .form-check-input:checked {
            background-color: var(--primary);
            border-color: var(--primary);
        }

        .error-message {
            color: var(--danger);
            font-size: 14px;
            margin-top: 5px;
            display: none;
        }

        .form-control.error {
            border-color: var(--danger);
        }

        .form-control.success {
            border-color: var(--success);
        }

        @media (max-width: 992px) {
            .registration-container {
                flex-direction: column;
                max-width: 500px;
            }

            .registration-left {
                padding: 30px;
            }

            .lottie-container {
                max-width: 250px;
            }
        }
    </style>
</head>

<body>
    <div class="background-shapes">
        <div></div>
        <div></div>
        <div></div>
        <div></div>
    </div>


    <div class="registration-container">
        <div class="registration-left">
            <!-- Lottie Animation Only -->
            <div class="lottie-container">
                <lottie-player src="https://assets2.lottiefiles.com/packages/lf20_jcikwtux.json"
                    background="transparent" speed="1" loop autoplay>
                </lottie-player>
            </div>
            <h2 class="system-name">EduManage Pro</h2>
            <p class="system-tagline">Student Registration Portal</p>
        </div>

        <div class="registration-right">
            <h2 class="welcome-text">Student Registration</h2>

            <div class="alert alert-success alert-dismissible fade show" role="alert" style="display: none;"
                id="successAlert">
                <i class="fas fa-check-circle me-2"></i> Registration successful!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif


            <form method="POST" action="{{ route('student.register.store') }}" id="registrationForm">
                @csrf
                <!-- Name -->
                <div class="form-floating mb-3">
                    <input value="{{ old('name') }}" id="name" type="text" name="name" class="form-control"
                        placeholder="Full Name" required>
                    <label for="name"><i class="fas fa-user me-2"></i>Full Name</label>
                    <div class="error-message" id="nameError">Please enter your full name</div>
                </div>

                <!-- Email -->
                <div class="form-floating mb-3">
                    <input value="{{ old('email') }}" id="email" type="email" name="email" class="form-control"
                        placeholder="Email Address" required>
                    <label for="email"><i class="fas fa-envelope me-2"></i>Email Address</label>
                    @error('email')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Password -->
                <div class="form-floating mb-3">
                    <input value="" id="password" type="password" name="password" class="form-control"
                        placeholder="Password" required>
                    <label for="password"><i class="fas fa-lock me-2"></i>Password</label>
                    <div class="error-message" id="passwordError">Password must be at least 8 characters</div>
                </div>

                <!-- Confirm Password -->
                <div class="form-floating mb-3">
                    <input value="" id="confirmPassword" type="password" name="password_confirmation"
                        class="form-control" placeholder="Confirm Password" required>
                    <label for="confirmPassword"><i class="fas fa-lock me-2"></i>Confirm Password</label>
                    <div class="error-message" id="confirmPasswordError">Passwords do not match</div>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-register btn-lg">
                        <i class="fas fa-user-plus me-2"></i>Register as Student
                    </button>
                </div>
            </form>

            <div class="registration-footer">
                <p>Already have an account? <a href="{{ route('student.login') }}" style="color: var(--primary);">Login here</a>
                </p>
                <p class="mt-2">© 2023 EduManage Pro. All rights reserved.</p>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // const form = document.getElementById('registrationForm');
            // const successAlert = document.getElementById('successAlert');

            // Get all input fields
            const nameInput = document.getElementById('name');
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');
            const confirmPasswordInput = document.getElementById('confirmPassword');

            // Get all error messages
            const nameError = document.getElementById('nameError');
            const emailError = document.getElementById('emailError');
            const passwordError = document.getElementById('passwordError');
            const confirmPasswordError = document.getElementById('confirmPasswordError');

            // Validation functions
            function validateName() {
                if (nameInput.value.trim() === '') {
                    nameError.style.display = 'block';
                    nameInput.classList.add('error');
                    nameInput.classList.remove('success');
                    return false;
                } else {
                    nameError.style.display = 'none';
                    nameInput.classList.remove('error');
                    nameInput.classList.add('success');
                    return true;
                }
            }

            function validateEmail() {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(emailInput.value)) {
                    emailError.style.display = 'block';
                    emailInput.classList.add('error');
                    emailInput.classList.remove('success');
                    return false;
                } else {
                    emailError.style.display = 'none';
                    emailInput.classList.remove('error');
                    emailInput.classList.add('success');
                    return true;
                }
            }

            function validatePassword() {
                if (passwordInput.value.length < 8) {
                    passwordError.style.display = 'block';
                    passwordInput.classList.add('error');
                    passwordInput.classList.remove('success');
                    return false;
                } else {
                    passwordError.style.display = 'none';
                    passwordInput.classList.remove('error');
                    passwordInput.classList.add('success');
                    return true;
                }
            }

            function validateConfirmPassword() {
                if (passwordInput.value !== confirmPasswordInput.value) {
                    confirmPasswordError.style.display = 'block';
                    confirmPasswordInput.classList.add('error');
                    confirmPasswordInput.classList.remove('success');
                    return false;
                } else {
                    confirmPasswordError.style.display = 'none';
                    confirmPasswordInput.classList.remove('error');
                    confirmPasswordInput.classList.add('success');
                    return true;
                }
            }

            // Add event listeners for real-time validation
            nameInput.addEventListener('blur', validateName);
            emailInput.addEventListener('blur', validateEmail);
            passwordInput.addEventListener('blur', validatePassword);
            confirmPasswordInput.addEventListener('blur', validateConfirmPassword);

            // Form submission handler
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                // Validate all fields
                const isNameValid = validateName();
                const isEmailValid = validateEmail();
                const isPasswordValid = validatePassword();
                const isConfirmPasswordValid = validateConfirmPassword();

                // If all fields are valid, show success message
                if (isNameValid && isEmailValid && isPasswordValid && isConfirmPasswordValid) {
                    successAlert.style.display = 'block';

                    // Reset form after 2 seconds
                    setTimeout(function() {
                        form.reset();
                        successAlert.style.display = 'none';

                        // Remove success classes
                        nameInput.classList.remove('success');
                        emailInput.classList.remove('success');
                        passwordInput.classList.remove('success');
                        confirmPasswordInput.classList.remove('success');
                    }, 2000);
                }
            });
        });
    </script>
</body>

</html> --}}
