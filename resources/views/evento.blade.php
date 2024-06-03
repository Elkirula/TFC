<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Evento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<style>
        /* Estilo para mantener fijo el div */
        .sticky-top {
            position: -webkit-sticky; /* Para navegadores webkit */
            position: sticky;
            top: 0; /* Lo fija en la parte superior */
            z-index: 1000; /* Ajusta el z-index según sea necesario */
        }
    </style>
    @vite(['resources/css/evento.css', 'resources/js/evento.js'])
    @vite(['resources/css/app.css', 'resources/js/app.js'])
<script>
    function mostrarAlerta() {
        alert('Debes iniciar sesión para comentar.');
    }
</script>
</head>

<body>
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
                    <a class="nav-link active" href="#">Cuenta</a>
                    </div>
                </div>
                </div>
        </nav>
        </header>
@extends('layouts.app')

@section('title', 'Detalle del Evento')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-12 col-lg-12 col-md-6 col-12">
            <div class="banner" data-testid="event-hero">
                <div class="event-hero">
                    <div class="event-hero__background" style="background-image: url('data:image/jpeg;base64,{{ base64_encode($evento->multimedia->archivo) }}');"></div>
                    <div tabindex="-1" data-testid="hero-carousel" class="css-1vu2yqv e1kx2rja0">
                        <div class="css-1tue3c7 e1kx2rja1">
                            <div data-testid="slide-list" class="css-1xzpfoj e1kx2rja2" style="transform: translateX(0%);">
                                <div data-testid="slide" aria-hidden="false" class="css-6dsmqv e1kx2rja3">
                                    <picture data-testid="hero-image">
                                        @if($evento->multimedia)
                                            <img src="data:image/jpeg;base64,{{ base64_encode($evento->multimedia->archivo) }}" alt="Imagen del Evento">
                                        @else
                                            <img src="https://via.placeholder.com/300" alt="placeholder-image" />
                                        @endif
                                    </picture>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-8 col-lg-8 col-md-12 col-12">
            <div >
                <div class="card-body p-4 py-3">
                    <h1 class="mb-2">{{ $evento->titulo }}</h1>
                    <h5 class="mb-3 fs-8">{{ $evento->encabezado }}</h5>
                 <!-- Facebook -->
                    <a data-mdb-ripple-init class="btn btn-primary"  href="#!" role="button">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <!-- Instagram -->
                    <a data-mdb-ripple-init class="btn btn-primary" href="#!" role="button">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <!-- Twitter -->
                    <a data-mdb-ripple-init class="btn btn-primary"  href="#!" role="button">
                        <i class="fab fa-twitter"></i>
                    </a>
                </div>
             
            </div>
        </div>
          <div class=" col-xl-1 col-lg-1 col-md-1 col-1 sticky-top" > </div>
        <div class=" col-xl-3 col-lg-3 col-md-12 col-12 sticky-top" > 
            <div>
                <div class="card-body p-4 py-3">
                    <div class="ticket-selection">
                        <div class="ticket">
                            <div class="ticket-info">
                                <div class="ticket-name">General Admission</div>
                                <div class="ticket-price">€40.00</div>
                            </div>
                            <div class="ticket-controls">
                                <button class="quantity-button" disabled>-</button>
                                <span class="quantity">1</span>
                                <button class="quantity-button">+</button>
                            </div>
                        </div>
                        <div class="checkout">
                            <button class="checkout-button">Check out for €43.43</button>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
        <div class="col-xl-9 col-lg-9 col-md-12 col-12"> 
            <div class="card mb-4">
                <div class="card-body p-4">
                    <h4>Descripcion</h4>
                    <p>{{ $evento->descripcion }}</p>
            </div> 
            <div class="card mb-4">
                <div class="card-body p-4">
                    <h4 class="text-left">Event Info</h4>
                    <p>{{ $evento->informacion }}</p>
                </div>
            </div> 
            <div class="card mb-4">
                <div class="card-body p-4">
                    @if($evento->categoria_id == 2 || $evento->categoria_id == 1)
                        <h4 class="mb-3">DJS</h4>
                    @else
                        <h4 class="mb-3">Participantes</h4>
                    @endif    
                    <div class="row">
                        @foreach($evento->artistas as $artista)
                            @php
                                $img = $artista->foto ? 'data:image/jpeg;base64,' . base64_encode($artista->foto) : 'https://via.placeholder.com/300';
                            @endphp
                            <div class="col-lg-4 col-md-6 col-12 text-center">
                                <div class="cardA card0" style="background: url('{{ $img }}');     background-repeat: no-repeat;">
                                    <div class="border">
                                        <h2>{{ $artista->nombre }}</h2>
                                        <div class="icons">
                                            <i class="fab fa-instagram"></i>
                                            <i class="fab fa-twitter"></i>
                                            <i class="fab fa-facebook"></i>
                                            <div class="audio-player">
                                                <i  class="fa-solid fa-play" id="playPauseButton{{ $artista->id }}"></i>
                                                <audio id="audio{{ $artista->id }}">
                                                    <source src="{{ $artista->audio }}" type="audio/mpeg">
                                                    Your browser does not support the audio element.
                                                </audio>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div> 
            <div class="card mb-4 bg-light">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12 text-center">
            @if($evento->ubicacion)
                <h4 class="mb-3">DJS</h4>
            @else
                <h4 class="mb-3">Participantes</h4>
            @endif
        </div>
    </div>
</div>

 
        
{{-- <div id="lgx-photo-gallery" class="card mb-4">
    <div class="card-body p-4 pb-0">
        <h4 class="mb-3">Event Gallery</h4>
        <div>
            <div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls">
                <div class="slides"></div>
                <h3 class="title"></h3>
                <p class="description"></p>
                <a class="prev"></a>
                <a class="next"></a>
                <a class="close"></a>
                <ol class="indicator"></ol>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="mb-5">
                        <img src="/storage/events/August2023/1691737813426.webp" class="w-100 rounded-3 img-hover">
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="mb-5">
                        <img src="/storage/events/August2023/169173781456.webp" class="w-100 rounded-3 img-hover">
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="mb-5">
                        <img src="/storage/events/August2023/169173781454.webp" class="w-100 rounded-3 img-hover">
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="mb-5">
                        <img src="/storage/events/August2023/1691737814543.webp" class="w-100 rounded-3 img-hover">
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="mb-5">
                        <img src="/storage/events/August2023/1691737815230.webp" class="w-100 rounded-3 img-hover">
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="mb-5">
                        <img src="/storage/events/August2023/1691737815753.webp" class="w-100 rounded-3 img-hover">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> --}}

<div class="card mb-4">
    <div class="card-body p-4">
        <h4 class="mb-3">Watch Trailer</h4>
        <div class="ratio ratio-16x9">
            <iframe src="https://www.youtube.com/embed/{{ $youtubeVideoId }}" allowfullscreen="allowfullscreen" class="rounded-4 img-hover"></iframe>
        </div>
    </div>
</div>


<div class="card mb-4">
    <div class="card-body p-4 pb-0">
        <h4 class="mb-3">Ratings &amp; Reviews</h4>
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-6">
                        <!-- Mostrar comentarios -->
                        @foreach ($evento->comentarios as $comentario)
                            <div class="comentario" id="comentario-{{ $comentario->id }}">
                                <p>{{ $comentario->contenido }}</p>
                                <!-- Mostrar respuestas -->
                                <div class="respuestas">
                                    @foreach ($comentario->respuestas as $respuesta)
                                        <div class="respuesta">
                                            <p>{{ $respuesta->contenido }}</p>
                                        </div>
                                    @endforeach
                                </div>
                                <!-- Formulario para responder -->
                                @if ($comentario->id)
                                    <form class="responder-form" action="{{ route('evento.responder', ['id' => $evento->id, 'comentarioId' => $comentario->id]) }}" method="POST">
                                        @csrf
                                        <!-- Campo oculto para enviar el ID del comentario padre -->
                                        <input type="hidden" name="parent_id" value="{{ $comentario->id }}">
                                        <input type="text" name="contenido" placeholder="Responder...">
                                        <button type="submit">Responder</button>
                                    </form>
                                @endif
                            </div>
                        @endforeach
                        
                        <!-- Formulario para agregar comentario -->
                        @auth
                            <form action="{{ route('evento.comentar', $evento->id) }}" method="POST">
                                @csrf
                                <input type="text" name="contenido" placeholder="Comentar...">
                                <button type="submit">Comentar</button>
                            </form>
                        @else
                            <form onsubmit="mostrarAlerta();">
                                @csrf
                                <input type="text" name="contenido" placeholder="Comentar..." disabled>
                                <button type="submit" disabled>Comentar</button>
                            </form>
                        @endauth
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-xl-4 col-lg-4 col-md-12 col-12">

        <div class="container swiper mySwiper">
            @if($eventosRelacionados->isEmpty())
                <p>No hay eventos disponibles.</p>
            @else
                <div class="row">
                    <div class="col-8">
                        <h3>Featured Events</h3>
                    </div>
                    <div class="col-4 ">
                        <a href="#" class="btn btn-sm text-primary mt-lg-2 float-end">View All <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
                <div class="swiper-wrapper">
                    @foreach($eventosRelacionados as $key => $evento)
                        <div class="swiper-slide"  class="col-xl-3 col-lg-4 col-md-6 mb-4">
                            <div class="p-4" style="width: 430px;">
                              <div class="article-card">
                                <div class="content">
                                  <p class="date">{{ $evento->fecha }}</p>
                                </div>
                                @if($evento->multimedia)
                                  <img src="data:image/jpeg;base64,{{ base64_encode($evento->multimedia->archivo) }}" alt="Imagen del Evento">
                                @else
                                  <img src="https://via.placeholder.com/300" alt="placeholder-image" />
                                @endif                    
                              </div>
                              <h5>
                                <a href="{{ route('evento.show', ['id' => $evento->id]) }}" class="text-dark">{{ $evento->titulo }}</a>
                              </h5>
                              <p class="small text-muted mb-0"></p>
                              <div class="d-flex align-items-center justify-content-between rounded-pill bg-light px-3 py-2 mt-4">
                                <p class="small mb-0"><i class="fa fa-picture-o mr-2"></i><span class="font-weight-bold">JPG</span></p>
                                <div class="badge badge-danger px-3 rounded-pill font-weight-normal">New</div>
                              </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-pagination"></div>
            @endif
        </div>
  </div>
</div>
    @vite(['resources/js/home.js'])

@endsection

</body>

</html>