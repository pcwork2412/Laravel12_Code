<h2>Admin Register</h2>
@if ($errors->any())
    <ul>
        @foreach ($errors->all() as $error)
            <li style="color:red;">{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form method="POST" action="{{ route('admin.register') }}">
    @csrf
    <input type="text" name="name" placeholder="Name" value="{{ old('name') }}" required><br>
    <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <input type="password" name="password_confirmation" placeholder="Confirm Password" required><br>
    <button type="submit">Register</button>
</form>

<a href="{{ route('admin.login') }}">Already have an account? Login</a>
