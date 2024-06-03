<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Laravel')</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
    
@section('header')
        <header>
            <nav class="navbar navbar-expand-lg bg-body-tertiary">
                <div class="container-fluid">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Buscar">
                        <button class="btn btn-primary" type="button">Buscar</button>
                    </div>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-end" id="navbarNavAltMarkup">
                        <div class="navbar-nav">
                            <a class="nav-link active" aria-current="page" href="#">Home</a>
                            <a class="nav-link active" href="#">Lugares</a>
                            <a class="nav-link active" href="#">Categoria</a>
                            <a class="nav-link active open-login-modal" href="#">Cuenta</a> <!-- Ajustado para abrir el modal -->
                        </div>
                    </div>
                </div>
            </nav>
        </header>
@endsection

    <div class="container">
        @yield('content')
    </div>

    <footer>
        <!-- Aquí iría el pie de página -->
    </footer>

    <!-- Modal de Login -->
    <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginModalLabel">Login</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="loginForm"  method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="email">Correo Electrónico</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Contraseña</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Ingresar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Función para abrir el modal
        function openLoginModal() {
            $('#loginModal').modal('show');
        }

        // Ejemplo de cómo llamar al modal desde cualquier parte
        $(document).ready(function(){
            $('.open-login-modal').click(function(e){
                e.preventDefault(); // Prevenir el comportamiento predeterminado del enlace
                openLoginModal();
            });
        });
    </script>
</body>
</html>
