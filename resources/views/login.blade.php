<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    @vite(['resources/js/app.js'])
</head>
<body class="login">
    @include('navbar')
    <div class="page-container">
        <div class="loginBox">
            <h1>Login</h1>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="ul">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ url('login') }}" method="POST" class="form">
                @csrf
                <div class="form--box">
                    <label for="email">Email</label>
                    <input type="text" id="email" name="email" maxlength="254" required>
                </div>
                
                <div class="form--box">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" maxlength="255" required>
                </div>
                

                <input type="Submit" value="Login" class="submit">
            </form>

        </div>
        <p>New to Shire Homes? <a href="{{ route('register') }}" class="a">Create an account</a></p>

        <br>
        <br>
        <br>
        <br>
        <br>
        
    </div>
    @include('footer')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const images = [
                'url("{{ asset('images/image1.png') }}")',
                'url("{{ asset('images/image2.png') }}")',
                'url("{{ asset('images/image3.png') }}")'
            ];

            let currentImageIndex = 0;

            document.body.style.backgroundImage = images[currentImageIndex];

            setInterval(function() {
                currentImageIndex = (currentImageIndex + 1) % images.length;
                document.body.style.backgroundImage = images[currentImageIndex];
            }, 6000);
        });
    </script>
</body>
</html>