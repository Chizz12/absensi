<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Absensi</title>
    <link rel="stylesheet" href="/assets/css/login.css"> <!-- Ini adalah link ke CSS -->
</head>

<body>
    <section class="container">
        @if (Route::has('login'))
            @auth
                <div class="login-container">
                    <div class="circle circle-one"></div>
                    <div class="form-container">
                        <img src="https://raw.githubusercontent.com/hicodersofficial/glassmorphism-login-form/master/assets/illustration.png"
                            alt="illustration" class="illustration" />
                        <h1 class="opacity">LOGIN</h1>
                        <form>
                            <button class="opacity" type="button" id="backHome">Kembali</button>
                        </form>

                    </div>
                    <div class="circle circle-two"></div>
                </div>
            @else
                <div class="login-container">
                    <div class="circle circle-one"></div>
                    <div class="form-container">
                        <img src="https://raw.githubusercontent.com/hicodersofficial/glassmorphism-login-form/master/assets/illustration.png"
                            alt="illustration" class="illustration" />
                        <h1 class="opacity">LOGIN</h1>
                        <form action="{{ route('login') }}" method="post">
                            @csrf
                            <input type="number" placeholder="ID MEMBER" name="member_id" />
                            <input type="password" placeholder="PASSWORD" name="password" />
                            <button class="opacity" type="submit">MASUK</button>
                        </form>
                        <div class="register-forget opacity">
                            <a href="#">LUPA PASSWORD</a>
                        </div>
                    </div>
                    <div class="circle circle-two"></div>
                </div>
            @endauth
        @endif
        <div class="theme-btn-container"></div>
    </section>

    <!-- Hubungkan file JavaScript eksternal -->
    <script src="/assets/js/login.js"></script>
    <script>
        document.getElementById('backHome').addEventListener('click', function() {
            window.location.href = '/home';
        });
    </script>
</body>

</html>
