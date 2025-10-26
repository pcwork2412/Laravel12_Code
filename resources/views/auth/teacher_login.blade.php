{{-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Login</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary-color: #669bbc;
            --primary-dark: #003049;
            --shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
        }

        body {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 15px;
        }

        .card {
            border-radius: 16px;
            box-shadow: var(--shadow);
            overflow: hidden;
            width: 100%;
            max-width: 500px; /* ✅ Compact width for large screens */
            transition: all 0.3s ease;
        }
        .card-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            color: white;
            text-align: center;
            padding: 2rem 1rem;
        }

        .card-header h1 {
            font-size: 1.8rem;
            font-weight: 700;
        }
        .input-icon i {
            color: var(--primary-dark)
        }


        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            border: none;
            font-weight: 600;
        }

        .btn-primary:hover {
            box-shadow: 0 6px 15px rgba(58, 86, 212, 0.4);
        }

        .form-footer {
            text-align: center;
            margin-top: 1.5rem;
            color: white;
        }

        .form-footer a {
            color: white;
            font-weight: 600;
            text-decoration: underline;
        }

        .input-bubble {
            margin-top: 6px;
            font-size: 0.85rem;
            color: #721c24;
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            padding: 6px 10px;
            border-radius: 8px;
            max-width: 100%;
        }
    </style>
</head>

<body>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card shadow-sm">
            <div class="card-header">
                <h1>Teacher Login</h1>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('teacher.login.submit') }}" method="POST">
                    @csrf

                    <!-- Teacher ID -->
                    <div class="mb-3 input-icon">
                        <i class="fas fa-id-badge"></i>
                        <label for="teacher_id" class="form-label">Teacher ID</label>
                        <input type="text" name="teacher_id" id="teacher_id"
                            class="form-control @error('teacher_id') is-invalid @enderror"
                            value="{{ old('teacher_id') }}" placeholder="Enter your teacher ID" required>
                        @error('teacher_id')
                            <div class="input-bubble">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Full Name -->
                    <div class="mb-3 input-icon">
                        <i class="fas fa-user-graduate"></i>
                        <label for="teacher_name" class="form-label">Full Name</label>
                        <input type="text" name="teacher_name" id="teacher_name"
                            class="form-control @error('teacher_name') is-invalid @enderror"
                            value="{{ old('teacher_name') }}" placeholder="Enter your full name" required>
                        @error('teacher_name')
                            <div class="input-bubble">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-3 input-icon">
                        <i class="fas fa-lock"></i>
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" id="password"
                            class="form-control @error('password') is-invalid @enderror"
                            placeholder="Enter your password" required>
                        @error('password')
                            <div class="input-bubble">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-sign-in-alt me-2"></i> Login
                    </button>

                    <div class="form-footer mt-3">
                        Having trouble? <a href="#">Contact Administrator</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html> --}}
