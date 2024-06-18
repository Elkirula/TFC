  <html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
        <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <link rel="icon" href="{{ asset('favicon.png') }}">

     @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Home</title>
     {{-- @vite(['resources/css/home.css', 'resources/js/home.js']) --}}
    @vite(['resources/css/busca_evento.css', 'resources/js/app.js']) <title>Eventos</title>
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
    <div class="py-5">
        <div class="container">
            @if($eventos->isEmpty())
                <p>No hay eventos disponibles.</p>
            @else
                <div class="row">
                    <div class="col-8">
                        <h3>Eventos filtrados</h3>
                    </div>
                </div>
                <div class="row justify-content-center">
                    @foreach($eventos as $key => $evento)
                        <div class="col-xl-4 col-lg-4 col-md-4 mb-4">
                            <div class="p-4" style="width: 100%;">
                                <div class="article-card">
                                    <div class="content">
                                        <p class="date">{{ $evento->fecha }}</p>
                                    </div>
                                    @if($evento->multimedia)
                                        <img src="data:image/jpeg;base64,{{ base64_encode($evento->multimedia->archivo) }}" alt="Imagen del Evento" style="width: 100%;">
                                    @else
                                        <img src="https://via.placeholder.com/300" alt="placeholder-image" style="width: 100%;" />
                                    @endif
                                </div>
                                <h5>
                                    <a href="{{ route('evento.show', ['id' => $evento->id]) }}" class="text-dark">{{ $evento->titulo }}</a>
                                </h5>
                                <p class="small text-muted mb-0">Valoración de evento: {{ number_format($evento->valoracion_media, 1) }} / 5</p>
                                <div class="d-flex align-items-center justify-content-between rounded-pill bg-light px-3 py-2 mt-4">
                                    <p class="small mb-0"><i class="fa fa-picture-o mr-2"></i><span class="font-weight-bold"></span></p>
                                    <div class="badge badge-danger px-3 rounded-pill font-weight-normal">{{ $evento->precio }}€</div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="row justify-content-center">
                  <div class="col-12">
                    {{ $eventos->links() }}
                  </div>
                </div>
            @endif
        </div>  
    </div>
    <footer class="bg-dark text-white pt-5 pb-4">
        <div class="container text-md-left">
            <div class="row text-md-left">
                <div class="col-md-3 col-lg-3 col-xl-3 mx-auto mt-3">
                    <h5 class="text-uppercase mb-4 font-weight-bold">Eventos</h5>
                    <p>La mejor web para disfrutar de eventos como de crealos y conocer gente nueva.</p>
                </div>

                <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mt-3">
                    <h5 class="text-uppercase mb-4 font-weight-bold">Contact</h5>
                    <p><i class="fas fa-envelope mr-3"></i> adminEventos@gmail.com</p>
                    <p><i class="fas fa-phone mr-3"></i> + 36 234 567 88</p>
                </div>
            </div>
            <hr class="mb-4">
            <div class="row align-items-center">
                <div class="col-md-12 col-lg-12">
                    <p class="text-center text-md-left">© 2024 Copyright:
                        <a href="#" style="text-decoration: none;">
                            <strong class="text-white"> kirutfc.xyz</strong>
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </footer>


  </body>

  </html>