  <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="icon" href="{{ asset('favicon.png') }}">

    @vite(['resources/css/panel_rol_especial.css', 'resources/js/panel_rol_especial.js'])

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
    <div class="d-flex " id="wrapper">
<div class="content">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-12 col-lg-12">
            <div class="bg-dark border-right" id="sidebar-wrapper">
                <div class="sidebar-heading text-white p-3">                                
                    <img src="data:image/jpeg;base64,{{ base64_encode($user->foto) }}" alt="profile one">
                </div>
                <div class="list-group list-group-flush">
                    <a id="btn_home" class="list-group-item list-group-item-action bg-dark text-white">Home</a>
                    <a id="btn_nevo" class="list-group-item list-group-item-action bg-dark text-white">Nuevo evento</a>
                    <a id="btn_cuenta" class="list-group-item list-group-item-action bg-dark text-white">Cuenta</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    <a id="btn_logout" class="list-group-item list-group-item-action bg-dark text-white" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Cerrar sesión</a>
                    <a id="btn_borrar"  class="list-group-item list-group-item-action bg-dark text-white">Eliminar cuenta</a>
                
                                      
                </div>
            </div>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Main Content -->
        <div class="col">
            <!-- Toggle Button Visible on Small Screens -->
            <a href="#" class="btn btn-dark btn-sm d-inline-block d-lg-none mt-3 ml-3" id="menu-toggle">Toggle Sidebar</a>
            <!-- Main Content Goes Here -->
        </div>
    </div>
</div>




        <!-- Page Content -->
        <div id="page-content-wrapper" class="oculto">
            <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
                <span class="navbar-brand mb-0 h1">Admin Panel</span>
            </nav>

            <div class="container-fluid">
                <h1 class="mt-4">Información General</h1>
                <div class="row">
                    <!-- Card para Ganancias -->
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="card bg-success text-white shadow">
                            <div class="card-body">
                                Ganancias
                                <div class="text-white-50 small">Total: {{ $gananciasTotales }}</div>
                            </div>
                        </div>
                    </div>
                               
                    <!-- Card para Seguidores -->
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="card bg-warning text-white shadow">
                            <div class="card-body">
                                Seguidores
                                <div class="text-white-50 small">Total: {{ $seguidores }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container-fluid">
                    <h1 class="mt-4">Mis Eventos</h1>
                    <div class="row">
                        <div class="col-lg-12 mb-4">
                            <div class="card shadow">
                                <div class="card-header">
                                    <h6 class="m-0 font-weight-bold text-primary">Lista de eventos</h6>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>Nombre</th>
                                                    <th>Lugar</th>
                                                    <th>Fecha</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($eventos as $evento)
                                                     <tr>
                                                         <td>{{ $evento->titulo }}</td>
                                                         <td>@if ($evento->ubicaciones)
                                                                {{ $evento->ubicaciones->nombre }}
                                                            @else
                                                                No disponible
                                                            @endif
                                                        </td>
                                                         <td>{{ $evento->fecha }}</td>
                                                         <td>
                                                            <form action="{{ route('eliminar_evento', ['id' => $evento->id]) }}" method="POST"> 
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de que quieres eliminar este evento?')">Eliminar</button>
                                                            </form>                                                          
                                                        </td>
                                                     </tr>
                                                 @endforeach
                                                 @if($eventos->isEmpty())
                                                     <tr>
                                                         <td colspan="4" class="text-center">No tienes eventos creados.</td>
                                                     </tr>
                                                 @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div id="nuevo" class="oculto">
            <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
                <span class="navbar-brand mb-0 h1">Admin Panel</span>
            </nav>
            <div class="container justify-content-center">
                <!-- Main container for centering the content -->
                <div class="container-fluid">
                    <!-- Fluid container for responsive design -->
                    <h1 class="mt-4">Crear Evento</h1>
                    <!-- Title of the page -->
                    <form action="{{ route('crear_evento.store') }}" method="POST" enctype="multipart/form-data">
                        <!-- Form for creating an event, with POST method and file upload capability -->
                        @csrf
                        <!-- CSRF token for security -->
                        <div class="row">
                            <!-- Row for form inputs -->
                            <div class="col-lg-3 mb-4">
                                <!-- Column for event name input -->
                                <div class="card shadow">
                                    <!-- Card styling for input -->
                                    <input type="text" name="titulo" maxlength="40" min="3"
                                        placeholder="Nombre del evento" required>
                                    <!-- Input for event name, required field -->
                                </div>
                            </div>
                            <div class="col-lg-3 mb-4">
                                <!-- Column for event date input -->
                                <div class="card shadow">
                                    <!-- Card styling for input -->
                                    <input type="date" name="fecha" maxlength="40" min="3" placeholder="Fecha" required>
                                    <!-- Input for event date, required field -->
                                </div>
                            </div>
                            <div class="col-lg-3 mb-4">
                                <!-- Column for event start time input -->
                                <div class="card shadow">
                                    <!-- Card styling for input -->
                                    <input type="time" name="hora_inicio" maxlength="40" min="3"
                                        placeholder="Hora inicio" required>
                                    <!-- Input for event start time, required field -->
                                </div>
                            </div>
                            <div class="col-lg-3 mb-4">
                                <!-- Column for event end time input -->
                                <div class="card shadow">
                                    <!-- Card styling for input -->
                                    <input type="time" name="hora_fin" maxlength="40" min="3" placeholder="Hora fin"
                                        required>
                                    <!-- Input for event end time, required field -->
                                </div>
                            </div>
                            <div class="col-lg-3 mb-4">
                                <!-- Column for event end time input -->
                                <div class="card shadow">
                                    <!-- Card styling for input -->
                                    <input type="number" name="precio" placeholder="precio" required>
                                    <!-- Input for event end time, required field -->
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="card shadow">
                            <div class="col-lg-12 mb-12">
                                <textarea name="encabezado"  maxlength="355" minlength="20"
                                    placeholder="Encabezado del evento" required></textarea>
                            </div>
                            </div>
                             <div class="card shadow">
                            <div class="col-lg-12 mb-12">
                                <textarea name="descripcion" maxlength="955" minlength="3"
                                    placeholder="Descripción del evento" required></textarea>
                            </div>
                            </div>
                             <div class="card shadow">
                            <div class="col-lg-12 mb-12">
                                <textarea name="informacion" maxlength="355" minlength="3"
                                    placeholder="Información del evento" required></textarea>
                            </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Second row for additional inputs -->
                            <div class="col-lg-3 mb-4">
                                <!-- Column for category selection -->
                                <select name="categoria" class="form-select">
                                    <!-- Dropdown for selecting category -->
                                    <option value="">Todas las Categorías</option>
                                    <!-- Default option -->
                                    @foreach($categorias as $categoria)
                                    <!-- Loop through categories -->
                                    <option value="{{ $categoria->id }}"
                                        {{ request('categoria_id') == $categoria->id ? 'selected' : '' }}>
                                        {{ $categoria->nombre }}
                                        <!-- Display category name -->
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <h3>Multimedia</h3>
                                <div class="borde">
                                    <div class="mb-3">
                                        <label for="artistImage" class="form-label">Subir Imagen de portada
                                            evento</label>
                                        <input type="text" name="tituloVideo" required>
                                        <input type="file" class="form-control" name="archivo" accept="image/*"
                                            required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div id="container_multimedia">
                                    <i class="fa-solid fa-plus" id="mas"></i> <i class="fa-solid fa-minus"
                                        id="menos"></i>
                                    <div class="borde">
                                        <div class="mb-3">
                                            <label for="artistName" class="form-label">Nombre del Artista</label>
                                            <input type="text" class="form-control" name="artistNombre[]" >
                                        </div>
                                        <div class="mb-3">
                                            <label for="artistName" class="form-label">Descripcion del artista</label>
                                            <input type="text" class="form-control" name="descripcion[]" >
                                        </div>
                                        <div class="mb-3">
                                            <label for="artistMusica" class="form-label">Musica del Artista</label>
                                            <input type="text" class="form-control" name="artistMusica[]" >
                                        </div>
                                        <div class="mb-3">
                                            <label for="artistImage" class="form-label">Subir Imagen</label>
                                            <input type="file" class="form-control" name="artistImg[]" accept="image/*"
                                                >
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <h4>Video</h4>
                                <input type="text" name="video" placeholder="introduce link de video" required>
                            </div>
                        </div>
                        <div class="row">
                            <h3>Localización</h3>
                            <div class="col-lg-12 mb-4">
                                <div class="d-flex flex-row align-items-center">
                                    <label id="location_presencial"
                                        class="css-1ie7kx e1pyrd530 d-flex flex-column align-items-center mr-3"
                                        style="cursor: pointer;">
                                        <i class="Icon_root__1kdkz Icon_icon-small__1kdkz" aria-hidden="true">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                fill="#3A3247" viewBox="0 0 24 24" color="">
                                                <path
                                                    d="M12.067 4C8.934 4 6.4 6.504 6.4 9.6c0 4.2 5.667 10.4 5.667 10.4s5.667-6.2 5.667-10.4c0-3.096-2.534-5.6-5.667-5.6m0 7.6c-1.117 0-2.024-.896-2.024-2s.907-2 2.024-2 2.024.896 2.024 2-.907 2-2.024 2"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                        </i>
                                        <p class="Typography_root__487rx #3a3247 Typography_body-sm__487rx Typography_align-match-parent__487rx"
                                            style="--TypographyColor: #3a3247;">Presencial</p>
                                    </label>
                                    <span style="width: 30px"></span>
                                    <label id="location_online"
                                        class="css-jsly0z e1pyrd530 d-flex flex-column align-items-center">
                                        <i class="Icon_root__1kdkz Icon_icon-small__1kdkz" aria-hidden="true">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                fill="#3A3247" viewBox="0 0 24 24" color="#fff">
                                                <path d="M19 4h2v16h-2v-1H5v1H3V4h2v1h14zM5 17h14V7H5zm10-5-5 3V9z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                            </svg>
                                            <p class="Typography_root__487rx #fff Typography_body-sm__487rx Typography_align-match-parent__487rx"
                                                style="--TypographyColor: #fff;">Online event</p>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div id="presencialContent" class="oculto">
                            <div class="row">
                                <div class="col-lg-12 mb-4">
                                    <div class="card shadow">
                                        <div id="map" style="height: 400px;"></div>
                                        <input type="hidden" id="latitud" name="latitud">
                                        <input type="hidden" id="longitud" name="longitud">
                                        <input type="text" id="nombre_lugar" name="nombre_lugar"
                                            placeholder="Selecciona el lugar"
                                            style="width: 100%; padding: 10px; margin-top: 10px;">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="onlineContent" class="oculto">
                            <div class="row">
                                <div class="col-lg-12 mb-4">
                                    <div class="card shadow">
                                        <input type="text" name="link_online" placeholder="Introduce el enlace online">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Crear Evento</button>
                    </form>
                </div>
            </div>
        </div>
        
        <div id="cuenta" class="oculto">
            <div class="container justify-content-center">
                <div class="container-fluid">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <form action="{{ route('update-profile-especial') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ Auth::user()->name }}">
                        </div>
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ Auth::user()->email }}">
                        </div>
                        <div class="form-group">
                            <label for="password">New Password</label>
                            <input type="password" class="form-control" id="password" name="password">
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">Confirm New Password</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                        </div>
                        <div class="form-group">
                            <label for="profile_picture">Profile Picture</label>
                            <input type="file" class="form-control-file" id="profile_picture" name="profile_picture">
                        </div>
                        <button type="submit" class="btn btn-primary">Actualizar perfil</button>
                    </form>
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
    <!-- /#wrapper -->

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
 


</body>
</html>