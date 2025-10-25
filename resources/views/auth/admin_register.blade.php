<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">

    <div class="bg-white shadow-lg rounded-2xl w-4/5 max-w-4xl flex overflow-hidden">

        <!-- Left Part: Fixed Content -->
        <div class="w-1/2 bg-blue-600 text-white p-10 flex flex-col justify-center">
            <h2 class="text-4xl font-bold mb-4">Welcome Admin!</h2>
            <p class="mb-6">Join our admin panel to manage all users and content easily.</p>
            <img src="https://img.icons8.com/clouds/100/admin-settings-male.png" alt="Admin" width="80%" class=" mx-auto">
        </div>

        <!-- Right Part: Form -->
        <div class="w-1/2 p-10">
            <h2 class="text-3xl font-bold mb-6 text-gray-700">Admin Registration</h2>

            @if ($errors->any())
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.register') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-gray-600 mb-1">Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>

                <div>
                    <label class="block text-gray-600 mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>

                <div>
                    <label class="block text-gray-600 mb-1">Password</label>
                    <input type="password" name="password" required
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>

                <div>
                    <label class="block text-gray-600 mb-1">Confirm Password</label>
                    <input type="password" name="password_confirmation" required
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>

                <button type="submit"
                    class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition duration-200">
                    Register
                </button>
            </form>

            <p class="mt-4 text-gray-500 text-sm">
                Already have an account? 
                <a href="{{ route('admin.login') }}" class="text-blue-600 hover:underline">Login</a>
            </p>
        </div>

    </div>

</body>
</html>
