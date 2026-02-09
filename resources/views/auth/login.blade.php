<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('sidebar/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('sidebar/css/login.css') }}">
    <script src="{{ asset('sidebar/css/bootstrap.bundle.min.js') }}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Madimi+One&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <title>Login</title>
</head>

<body>

    </div>
    <div class="main">
        <div class="container">

            <div class="row">
                <div class="col login-text">
                    Login
                </div>
                <div class="col login-form">
                    <form action="{{ Route('login') }}" class="signin-form" method="post">
                        @csrf
                        <div class="">
                            <input type="email" name="email" class="" placeholder="Email" required>
                        </div>
                        <div class="">
                            <input id="password-field" name="password" type="password" class=""
                                placeholder="Password" required>

                        </div>
                        <div class="">
                            <button type="submit" class="float-center">LOGIN</button>
                        </div>
                    </form>
                    @if ($errors->any())
                        <div class="row mt-2">

                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li class="text-danger">{{ $error }}</li>
                                @endforeach
                            </ul>

                        </div>
                    @endif

                    <div class="mt-2"><a href="{{ route('passwordReset') }}"
                            class="text-light text-decoration-none">Forgot Password?</a></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row nav-row p-2">
        <div class="col">
            <a href="/"><i class="fa-solid fa-arrow-left text-light"></i></a>
        </div>
        <div class="col text-end">
            <i class="fa-solid fa-bars text-light"></i>
        </div>
        <div class="version text-light text-muted" style="position: absolute; top: 100%; left: 2%;">
            0.0.20
        </div>
    </div>
</body>

</html>
