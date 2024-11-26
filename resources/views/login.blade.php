<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    @vite(['resources/js/app.js'])
</head>
<body>
    <h1>Login</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ url('login') }}" method="POST">
        @csrf
        <label for="email">Email</label>
        <input type="text" id="email" name="email" maxlength="30" required>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" maxlength="30" required>

        <input type="Submit" value="Login">
    </form>

    <a href="{{ route('register') }}">Create an account</a>
</body>
</html>
