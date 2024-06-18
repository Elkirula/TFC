<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <title>Usuario</title>
    @vite(['resources/css/panel_usuario.css', 'resources/js/panel_usuario.js'])

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
@extends('layouts.app')
    <div class="d-flex" id="wrapper">
        <div class="content">
            <div class="row">
                <!-- Sidebar -->
                <div class="col-12 col-lg-12">
                    <div class="bg-dark border-right" id="sidebar-wrapper">
                        <div class="sidebar-heading text-white p-3">
                            {{-- <img src="data:image/jpeg;base64,{{ base64_encode($user->foto) }}" alt="profile one"> --}}
                        </div>
                        <div class="list-group list-group-flush">
                            <a id="btn_cuenta" class="list-group-item list-group-item-action bg-dark text-white">Cuenta</a>
                            <a id="btn_amigos" class="list-group-item list-group-item-action bg-dark text-white">Amigos</a>
                            <a id="btn_compra" class="list-group-item list-group-item-action bg-dark text-white">Compras</a>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-secondary">Cerrar Sesión</button>
                            </form>
                            <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar tu cuenta?')">Eliminar Cuenta</button>
                        </div>
                    </div>
                </div>
                <!-- /#sidebar-wrapper -->

                <!-- Main Content -->
                <div class="col">
                    <!-- Toggle Button Visible on Small Screens -->
                    <a href="#" class="btn btn-dark btn-sm d-inline-block d-lg-none mt-3 ml-3" id="menu-toggle">Toggle Sidebar</a>

                </div>
            </div>-
        </div>
<div id="amigos" class="oculto">
    <div class="container">
        <div class="row">
            <div class="col">
                <!-- Section for displaying friends -->
                <h2>Amigos</h2>
                <ul id="listaAmigos">
                    @foreach($amigos as $amigo)
                    <li>{{ $amigo->name }}
                        <!-- Form to remove a friend -->
                        <form id="eliminarAmigoForm-{{ $amigo->id }}" action="{{ route('eliminarAmigo', $amigo->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="button" onclick="eliminarAmigo({{ $amigo->id }})" class="btn btn-danger btn-sm">Eliminar amigo</button>
                        </form>
                    </li>
                    @endforeach
                </ul>       

                <!-- Section for displaying pending friend requests -->
                <h2>Solicitudes pendientes</h2>
                <ul id="solicitudesPendientes">
                    @foreach($solicitudesPendientes as $solicitud)
                    <li>{{ $solicitud->sender->name }}
                        <!-- Form to accept a friend request -->
                        <form id="aceptarSolicitudForm-{{ $solicitud->sender->id }}" action="{{ route('aceptarSolicitud', $solicitud->sender->id) }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="button" onclick="aceptarSolicitud({{ $solicitud->sender->id }})" class="btn btn-primary btn-sm">Aceptar solicitud</button>
                        </form>
                    </li>
                    @endforeach
                </ul>       

                <!-- Section to send a new friend request -->
                <h2>Enviar solicitud de amistad</h2>
                <form id="searchForm">
                    <div class="form-group">
                        <input type="text" name="query" class="form-control" placeholder="Search by name or email">
                    </div>
                    <button type="submit" class="btn btn-primary">Buscar</button>
                </form>    

                <!-- Display search results for sending friend requests -->
                <div id="searchResults"></div>

            </div>
        </div>
    </div>      

    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <!-- Section to list friends for chat -->
                <h3>Chat Amigos</h3>
                <ul class="list-group">
                    @foreach ($amigos as $amigo)
                    <li class="list-group-item">
                        <a href="#" onclick="loadChat({{ $amigo->id }})">{{ $amigo->name }}</a>
                    </li>
                    @endforeach
                </ul>
            </div>
            <div class="col-md-8">
                <div id="chat" style="height: 400px; overflow-y: scroll;">
                    @if (isset($friend))
                    <!-- Section to display chat with a specific friend -->
                    <h3>Chat with {{ $friend->name }}</h3>
                    <div id="messages">
                        @foreach ($messages as $message)
                        <div class="message">
                            <strong>{{ $message->fromUser->name }}:</strong> {{ $message->content }}
                        </div>
                        @endforeach
                    </div>
                    <!-- Form to send a new message -->
                    <form id="sendMessageForm" onsubmit="sendMessage(event)">
                        @csrf
                        <div class="form-group">
                            <textarea name="message" class="form-control" rows="3" placeholder="Write your message..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Send</button>
                    </form>
                    @else
                    <!-- Placeholder message when no friend is selected for chat -->
                    <p>Select a friend to start chatting.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>      
</div>

<script>
    $(document).ready(function() {
        // Ajax search for sending friend requests
        $('#searchForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: '{{ route("buscarAmigos") }}',
                method: 'GET',
                data: $(this).serialize(),
                success: function(response) {
                    $('#searchResults').html(response);
                }
            });
        }); 

        // Ajax request to send friend request
        $(document).on('submit', '.sendRequestForm', function(e) {
            e.preventDefault();
            const form = $(this);
            $.ajax({
                url: form.attr('action'),
                method: 'POST',
                data: form.serialize(),
                success: function(response) {
                    alert('Friend request sent successfully.');
                    // Optionally, you can update the list of pending requests here
                    // Or reload the entire friends section
                }
            });
        });

        // Function to remove a friend via Ajax
        window.eliminarAmigo = function(userId) {
            if (confirm('Are you sure you want to remove this friend?')) {
                $.ajax({
                    url: '/panel_usuario/eliminar-amigo/' + userId,
                    method: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        alert('Friend removed successfully.');
                        // Optionally, update the list of friends here
                        // Or reload the entire friends section
                    }
                });
            }
        };

        // Function to accept a friend request via Ajax
        window.aceptarSolicitud = function(senderId) {
            $.ajax({
                url: '/panel_usuario/aceptar-solicitud/' + senderId,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    alert('Friend request accepted.');
                    // Optionally, update the list of pending requests here
                    // Or reload the entire friends section
                }
            });
        };

        // Function to load the chat with a specific user
        window.loadChat = function(userId) {
            fetch(`/chat/${userId}`)
                .then(response => response.text())
                .then(data => {
                    document.getElementById('chat').innerHTML = data;
                });
        };

        // Function to send a message via the chat form
        window.sendMessage = function(event) {
            event.preventDefault();
            const formData = new FormData(event.target);
            fetch(event.target.action, {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(data => {
                    document.getElementById('chat').innerHTML = data;
                });
        };
    });
</script>




<div class="oculto" id="compra">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3>Listado de Compras</h3>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            @forelse ($compras as $compra)
                                <li class="list-group-item">
                                    {{ $compra->producto }} - {{ $compra->precio }}€
                                </li>
                            @empty
                                <li class="list-group-item">No tienes compras.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


        <div class="oculto" id="cuenta">
            <div class="container">
                <div class="row">                  
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3>Actualizar Datos de Perfil</h3>
                            </div>
                            <div class="card-body">
                                <!-- Formulario para actualizar perfil -->
                                <form action="{{ route('panel_usuario') }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Nombre</label>
                                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', auth()->user()->name) }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Correo Electrónico</label>
                                        <input type="email" class="form-control" id="inemail" name="email" value="{{ old('email', auth()->user()->email) }}" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Actualizar</button>
                                </form>
                            
                                <!-- Formulario para cambiar contraseña -->
                                @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                                @endif
                            
                                @if (session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                                @endif
                            
                                <form action="{{ route('cambiar_contra') }}" method="POST" class="mt-4">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="current_password" class="form-label">Contraseña Actual</label>
                                        <input type="password" class="form-control" id="current_password" name="current_password" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="new_password" class="form-label">Nueva Contraseña</label>
                                        <input type="password" class="form-control" id="new_password" name="new_password" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="new_password_confirmation" class="form-label">Confirmar Nueva Contraseña</label>
                                        <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Cambiar Contraseña</button>
                                </form>
                            
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <footer class="bg-dark text-white pt-5 pb-4">
        <div class="container text-md-left">
            <div class="row text-md-left">
                <div class="col-md-3 col-lg-3 col-xl-3 mx-auto mt-3">
                    <h5 class="text-uppercase mb-4 font-weight-bold">Company Name</h5>
                    <p>Here you can use rows and columns to organize your footer content. Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                </div>

                <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mt-3">
                    <h5 class="text-uppercase mb-4 font-weight-bold">Contact</h5>
                    <p><i class="fas fa-home mr-3"></i> New York, NY 2333, US</p>
                    <p><i class="fas fa-envelope mr-3"></i> info@gmail.com</p>
                    <p><i class="fas fa-phone mr-3"></i> + 01 234 567 88</p>
                    <p><i class="fas fa-print mr-3"></i> + 01 234 567 89</p>
                </div>
            </div>
            <hr class="mb-4">
            <div class="row align-items-center">
                <div class="col-md-12 col-lg-12">
                    <p class="text-center text-md-left">© 2024 Copyright:
                        <a href="#" style="text-decoration: none;">
                            <strong class="text-white"> TheProviders.com</strong>
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>