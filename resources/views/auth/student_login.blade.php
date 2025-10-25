<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Login</title>
    <style>
        :root {
            --primary-color: #4361ee;
            --primary-dark: #3a56d4;
            --danger-color: #f72585;
            --danger-light: #ffe6ef;
            --success-color: #4cc9f0;
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
            padding: 25px;
            text-align: center;
        }
        
        .card-header h1 {
            font-size: 1.8rem;
            font-weight: 600;
            margin-bottom: 5px;
        }
        
        .card-header p {
            opacity: 0.9;
            font-size: 0.95rem;
        }
        
        .card-body {
            padding: 30px;
        }
        
        .alert {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 0.95rem;
        }
        
        .alert-danger {
            background-color: var(--danger-light);
            color: var(--danger-color);
            border-left: 4px solid var(--danger-color);
        }
        
        .alert-danger ul {
            margin-left: 15px;
            margin-top: 8px;
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
            padding: 14px 16px;
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
            padding-left: 45px;
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
            margin-top: 10px;
        }
        
        .btn:hover {
            background-color: var(--primary-dark);
            transform: translateY(-2px);
        }
        
        .form-footer {
            text-align: center;
            margin-top: 25px;
            color: var(--gray-color);
            font-size: 0.9rem;
        }
        
        .form-footer a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
        }
        
        .form-footer a:hover {
            text-decoration: underline;
        }
        
        @media (max-width: 576px) {
            .card-body {
                padding: 20px;
            }
            
            .card-header {
                padding: 20px;
            }
            
            .card-header h1 {
                font-size: 1.5rem;
            }
        }
        .field-error {
    display: flex;
    gap: 8px;
    align-items: center;
    margin-top: 6px;
    font-size: 0.9rem;
    color: #b02a37;
    background: rgba(176, 42, 55, 0.06);
    padding: 6px 10px;
    border-radius: 6px;
    border: 1px solid rgba(176, 42, 55, 0.12);
}

.field-error .err-icon {
    width: 16px;
    height: 16px;
    fill: #b02a37;
    flex-shrink: 0;
}

    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h1>Student Portal</h1>
                <p>Sign in to access your account</p>
            </div>
            <div class="card-body">
                <!-- Validation errors -->
                {{-- @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Please fix the following errors:</strong>
                        <ul>
                            @foreach ($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Custom error from controller -->
                @if (session('error'))
                    <div class="alert alert-danger">
                        <strong>Error:</strong> {{ session('error') }}
                    </div>
                @endif --}}

               <form action="{{ route('student.login.submit') }}" method="POST">
    @csrf

    <!-- ✅ Student ID -->
    <div class="form-group input-icon mb-3">
        <label for="student_uid" class="form-label">Student ID</label>
        <i class="fas fa-id-card"></i>
        <input type="text" name="student_uid" id="student_uid"
               class="form-control @error('student_uid') is-invalid @enderror"
               value="{{ old('student_uid') }}" placeholder="Enter your student ID" required>

        @error('student_uid')
            <div class="field-error" role="alert">
                <svg class="err-icon" viewBox="0 0 24 24"><path d="M12 2L1 21h22L12 2z"/></svg>
                <span class="err-text">{{ $message }}</span>
            </div>
        @enderror
    </div>

    <!-- ✅ Student Name -->
    <div class="form-group input-icon mb-3">
        <label for="student_name" class="form-label">Full Name</label>
        <i class="fas fa-user"></i>
        <input type="text" name="student_name" id="student_name"
               class="form-control @error('student_name') is-invalid @enderror"
               value="{{ old('student_name') }}" placeholder="Enter your full name" required>

        @error('student_name')
            <div class="field-error" role="alert">
                <svg class="err-icon" viewBox="0 0 24 24"><path d="M12 2L1 21h22L12 2z"/></svg>
                <span class="err-text">{{ $message }}</span>
            </div>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary w-100">
        <i class="fas fa-sign-in-alt me-2"></i>Login to Student Portal
    </button>

    <div class="form-footer mt-3">
        Need help? <a href="#">Contact Support</a>
    </div>
</form>

            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
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
            
            // Auto-focus first input field with error or first field
            const firstErrorField = document.querySelector('.is-invalid');
            if (firstErrorField) {
                firstErrorField.focus();
            } else {
                const firstInput = document.querySelector('input[type="text"]');
                if (firstInput) firstInput.focus();
            }
        });
    </script>
</body>
</html>