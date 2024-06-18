<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="icon" href="{{ asset('favicon.png') }}">
    @vite(['resources/css/login.css', 'resources/js/login.js'])

    <title>Login</title>
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <form action="{{ route('busca') }}" method="GET" class="d-flex w-100">
                    <div class="input-group mb-3 w-100">
                        <input type="text" name="query" class="form-control" placeholder="Buscar eventos..." value="{{ request('query') }}">
                        <select name="categoria_id" class="form-select">
                            <option value="">Todas las Categorías</option>
                            @foreach($categorias as $categoria)
                                <option value="{{ $categoria->id }}" name="categoria" {{ request('categoria_id') == $categoria->id ? 'selected' : '' }}>
                                    {{ $categoria->nombre }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-primary">Buscar</button>
                    </div>
                </form>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="navbarNavAltMarkup">
                    <div class="navbar-nav">
                        <a class="nav-link active" aria-current="page" href="{{ route('home') }}">Home</a>
                        @auth
                            @if(Auth::user()->role == 'admin' || Auth::user()->role == 'organizador')
                                <a class="nav-link active" href="{{ route('crear_evento') }}">Cuenta</a>
                            @else
                                <a class="nav-link active" href="{{ route('panel_usuario') }}">Cuenta</a>
                            @endif
                        @else
                            <a class="nav-link active" href="{{ route('login') }}">Login</a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>
    </header>


<div class="container" id="container">
    <div class="form-container sign-up-container">
        <form action="{{ route('registro') }}" method="POST">
    @csrf
    <h1>Crear cuenta</h1>
    <input type="text" placeholder="Name" name="name" required />
    <input type="email" placeholder="Email" name="email" required />
    <input type="password" placeholder="Password" name="password" required />
    <input type="password" placeholder="Confirm Password" name="password_confirmation" required />
    <label for="rol">Que tipo de cuenta quiere:</label>
    <div class="custom-select">
        <select id="rol" name="rol" required>
            <option value="normal">Normal</option>
            <option value="organizador">Organizador</option>
        </select>
    </div>
    <button type="submit">Crear</button>
</form>

    </div>

    <div class="form-container sign-in-container">
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <h1>Iniciar sesión</h1>
            <div class="social-container">
                <a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="social"><i class="fab fa-google-plus-g"></i></a>
                <a href="#" class="social"><i class="fab fa-linkedin-in"></i></a>
            </div>
            <span>Proximamente</span>
            <input type="email" name="email" placeholder="Email" required />
            <input type="password" name="password" placeholder="Password" required />
            <a href="#">Has olvidado tu contraseña?</a>
            <label for="remember">Recuérdame <input type="checkbox" name="remember"></label>
            <button type="submit">Iniciar</button>

            @if(session('error'))
                <div class="alert alert-danger mt-3">Credenciales incorrectas</div>
            @endif
            @if (session('success'))
                <div class="alert alert-success mt-3">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('status'))
                <div class="alert alert-success mt-3">
                    {{ session('status') }}
                </div>
            @endif
            @if (Auth::check() && !Auth::user()->hasVerifiedEmail())
                <div class="alert alert-warning mt-3">
                    Por favor verifica tu correo electrónico. <a href="{{ route('verification.resend') }}">Reenviar correo de verificación</a>.
                </div>
            @endif
        </form>
    </div>

    <div class="overlay-container">
        <div class="overlay">
            <div class="overlay-panel overlay-left">
                <h1>Welcome Back!</h1>
                <p>To keep connected with us please login with your personal info</p>
                <button class="ghost" id="signIn">Sign In</button>
            </div>
            <div class="overlay-panel overlay-right">
                <h1>Hello, Friend!</h1>
                <p>Enter your personal details and start journey with us</p>
                <button class="ghost" id="signUp">Sign Up</button>
            </div>
        </div>
    </div>
</div>

</body>
</html>
