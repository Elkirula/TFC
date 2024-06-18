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
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://js.stripe.com/v3/"></script>
<script src="https://w.soundcloud.com/player/api.js"></script>
    <link rel="icon" href="{{ asset('favicon.png') }}">

<script>
    function mostrarAlerta() {
        alert('Debes iniciar sesión para comentar.');
    }
</script>
</head>

<body>

      @extends('layouts.app')
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
                        <button type="submit" id="buscar" class="btn btn-primary">Buscar</button>
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



    <div class="pay5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-12 col-lg-12 col-md-12 col-12">
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
        </div>
    </div>
    <div class="pay5">
        <div class="container">
            <div class="row">
                <div class="col-xl-8 col-lg-8 col-md-12 col-12">
                    <div >
                        <div class="card-body p-4 py-3">
                            <p class=" text-muted mb-0">Valoración Media: {{ number_format($valoracion_media, 1) }} / 5</p>
                             <p class=" text-muted mb-0">Fecha: {{$evento->fecha }} Duracion de evento: {{ $evento->hora_inicio }}/{{ $evento->hora_inicio }}</p>
                            <h1 class="mb-2">{{ $evento->titulo }}</h1>
                            <h5 class="mb-3 fs-8">{{ $evento->encabezado }}</h5>
                         <!-- Facebook -->
                            <a data-mdb-ripple-init class="btn facebook "  href="#!" role="button">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a data-mdb-ripple-init class="btn  instagram-color" href="#!" role="button">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <!-- Twitter -->
                            <a data-mdb-ripple-init class="btn btn-primary"  href="#!" role="button">
                                <i class="fab fa-twitter"></i>
                            </a>
                        </div>
                        @auth
                            @if (auth()->user()->id !== $evento->organizador->id && !auth()->user()->isFollowing($evento->organizador))
                                <form action="{{ route('seguirOrganizador', ['organizadorId' => $evento->organizador->id]) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-primary">Seguir Organizador</button>
                                </form>
                            @endif
                        @endauth
                        
                    </div>
                </div>
                <div class=" col-xl-1 col-lg-1 col-md-1 col-1 sticky-top" > </div>
                <div class=" col-xl-3 col-lg-3 col-md-12 col-12 sticky-top" > 
                    <div class="ticket-selection">
                        <div class="ticket">
                            <div class="ticket-info">
                                <div class="ticket-name">Entrada</div>
                                <div class="ticket-price">{{ $evento->precio }}€</div>
                            </div>
                            <div class="ticket-controls">
                                <button class="quantity-button" id="decrease" disabled>-</button>
                                <span class="quantity" id="quantity">1</span>
                                <button class="quantity-button" id="increase">+</button>
                            </div>
                        </div>

                        <div class="checkout">
                            <button class="checkout-button" id="pagar" data-precio="{{ $evento->precio }}">Pagar: {{ $evento->precio }}€</button>
                        </div>                      

                        <!-- Modal -->
                        <div id="paymentModal" class="modal">
                            <div class="modal-content">
                                <span class="close">&times;</span>
                                <h2>Formulario de Pago</h2>
                                <form action="{{ route('comprar') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="precio" id="precio" value="{{ $evento->precio }}">
                                    <input type="hidden" name="producto" id="producto" value="{{ $evento->titulo }}">
                                    <div class="form-group">
                                        <label for="cardNumber">Número de Tarjeta</label>
                                        <input type="text" id="cardNumber" name="cardNumber" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="expiryDate">Fecha de Expiración</label>
                                        <input type="text" id="expiryDate" name="expiryDate" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="cvv">CVV</label>
                                        <input type="text" id="cvv" name="cvv" class="form-control" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Pagar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                
                    {{-- <div>
                        <script async src="https://js.stripe.com/v3/pricing-table.js"></script>
                        <stripe-pricing-table pricing-table-id="prctbl_1PQUA1LDBgcsEFMi6urqze2L"
                        publishable-key="pk_test_51PQ6aQLDBgcsEFMiQYBnEs7M0EArNiudZxQPUE2Tpn6vfEWI5tEWMoM5Lv83hWARUzRam9QkXdGZpo34JbSM7Ni600UtyCfy1m">
                        </stripe-pricing-table>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
    <div class="pay5">
        <div class="container">
            <div class="row">
                <div class="col-xl-9 col-lg-9 col-md-12 col-12"> 
                    <div class="card mb-4">
                        <div class="card-body p-4">
                            <h4>Descripcion</h4>
                            <p>{{ $evento->descripcion }}</p>
                        </div> 
                    </div> 
                </div> 
            </div>
        </div>
    </div>
    <div class="pay5">
        <div class="container">
            <div class="row">
                <div class="col-xl-9 col-lg-9 col-md-12 col-12"> 
                    @if( $evento->informacion == "")
                        <p></p>
                    @else
                        <div class="card mb-4">
                            <div class="card-body p-4">
                                <h4 class="text-left">Event Info</h4>
                                <p>{{ $evento->informacion }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @if($evento->artistas->whereNotNull('nombre')->isNotEmpty())
        <div class="pay5">
            <div class="container">
                <div class="row">
                    <div class="col-xl-9 col-lg-9 col-md-12 col-12"> 
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
                                                <div class="cardA card0" style="background: url('{{ $img }}'); background-repeat: no-repeat;">
                                                    <div class="border">
                                                        <h2>{{ $artista->nombre }}</h2>
                                                        <div class="icons">
                                                            <i class="fab fa-instagram"></i>
                                                            <i class="fab fa-twitter"></i>
                                                            <i class="fab fa-facebook"></i>
                                                            <div class="audio-player">
                                                                <i class="fa-solid fa-play" id="playPauseButton{{ $artista->id }}" onclick="togglePlayPause({{ $artista->id }})"></i>
                                                                <iframe id="sc-player{{ $artista->id }}" width="100%" height="166" scrolling="no" frameborder="no" allow="autoplay" src="https://w.soundcloud.com/player/?url={{ urlencode($artista->audio) }}&color=%23ff5500&inverse=false&auto_play=false&show_user=true"></iframe>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    @endforeach
                                </div>
                            </div>
                        </div> 
                    </div>
                </div>
            </div> 
        </div> 
    @endif
    <div class="pay5">
        <div class="container">
            <div class="row">
                <div class="col-xl-9 col-lg-9 col-md-9 col-9"> 
                    <div class="card mb-4 bg-light">
                        @if($evento->ubicaciones->link)
                            <!-- Display link for online event if available -->
                            <h4 class="mb-3">Link for online event</h4>
                            <a href="{{ $evento->ubicaciones->link }}">{{ $evento->ubicaciones->nombre }}</a>
                        @else
                            <!-- Display map if physical location is available -->
                            <h4 class="mb-3">Location</h4>
                            <div id="map"></div>
                        @endif
                    </div>
                    <!-- Include Leaflet library for interactive maps -->
                    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            // Check if event location is defined and not null
                            const ubicaciones = {!! json_encode($evento->ubicaciones) !!};
                            if (ubicaciones) {
                                // Latitude, longitude, and location name of the event
                                const latitud = ubicaciones.latitud;
                                const longitud = ubicaciones.longitud;
                                const nombreubicaciones = ubicaciones.nombre;
                            
                                // Create the map
                                const map = L.map('map').setView([latitud, longitud], 13);
                            
                                // Add a map layer
                                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                    maxZoom: 18
                                }).addTo(map);
                            
                                // Add a marker to the map
                                L.marker([latitud, longitud]).addTo(map)
                                    .bindPopup(nombreubicaciones)
                                    .openPopup();
                            } else {
                                console.error('Event location is not defined or is null.');
                            }
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
    <div class="pay5">
        <div class="container">
            <div class="row">
                <div class="col-xl-9 col-lg-9 col-md-9 col-9"> 
                    <div class="card mb-4">
                        <div class="card-body p-4">
                            <h4 class="mb-3">{{ $evento->multimedia->nombre }}</h4>
                            <div class="ratio ratio-16x9">
                                <iframe src="https://www.youtube.com/embed/{{ $youtubeVideoId }}" allowfullscreen="allowfullscreen" class="rounded-4 img-hover"></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="pay5">
        <div class="container">
            <div class="row">
                <div class="col-xl-9 col-lg-9 col-md-9 col-9"> 
                    <h3>Puntuar evento</h3>
                    <div class="row">
                        <div class="col-12">
                            <div class="stars">
                                <form action="{{ route('puntuacion.evento') }}" method="POST">
                                    @csrf
                                    <input class="star star-1" id="star-1" type="radio" name="star" value="5" {{ (isset($puntuacion) && $puntuacion == 5) ? 'checked' : '' }}/>
                                    <label class="star star-1" for="star-1"></label>
                                    <input class="star star-2" id="star-2" type="radio" name="star" value="4" {{ (isset($puntuacion) && $puntuacion == 4) ? 'checked' : '' }}/>
                                    <label class="star star-2" for="star-2"></label>
                                    <input class="star star-3" id="star-3" type="radio" name="star" value="3" {{ (isset($puntuacion) && $puntuacion == 3) ? 'checked' : '' }}/>
                                    <label class="star star-3" for="star-3"></label>
                                    <input class="star star-4" id="star-4" type="radio" name="star" value="2" {{ (isset($puntuacion) && $puntuacion == 2) ? 'checked' : '' }}/>
                                    <label class="star star-4" for="star-4"></label>
                                    <input class="star star-5" id="star-5" type="radio" name="star" value="1" {{ (isset($puntuacion) && $puntuacion == 1) ? 'checked' : '' }}/>
                                    <label class="star star-5" for="star-5"></label>
                                    <input type="hidden" name="evento_id" value="{{ $evento->id }}">
                                    <button type="submit" id="puntuacion" class="btn btn-primary mt-3">Enviar Puntuación</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="pay5">
        <div class="container">
            <div class="row">
                <div class="col-xl-9 col-lg-9 col-md-9 col-12"> 
                    <!-- Sección de comentarios -->
                    <div class="comentarios">
                        <h3>Comentarios</h3>
                        <!-- Mostrar comentarios -->
                        @foreach ($evento->comments as $comment)
                            <div class="comment">
                                <div class="d-flex justify-content-between align-items-center">
                                    <p class="mb-1"><strong>{{ $comment->user ? $comment->user->name : 'Anónimo' }}:</strong></p>
                                    <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                                </div>
                                <p>{{ $comment->content }}</p>
                                <button class="btn btn-sm btn-link p-0" onclick="toggleReplyForm({{ $comment->id }})">Responder</button>
                            
                                <!-- Formulario de respuesta -->
                                <form action="{{ route('comments.store', $evento) }}" method="POST" id="reply-form-{{ $comment->id }}" class="reply-form" style="display:none;">
                                    @csrf
                                    <div class="mb-3">
                                        <textarea name="comment" class="form-control" rows="2" placeholder="Escribe tu respuesta aquí..." required></textarea>
                                        <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-sm">Enviar</button>
                                </form>
                            
                                <!-- Mostrar respuestas -->
                                @foreach ($comment->children as $child)
                                    <div class="comment ml-4 bg-white rounded">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <p class="mb-1"><strong>{{ $child->user ? $child->user->name : 'Anónimo' }}:</strong></p>
                                            <small class="text-muted">{{ $child->created_at->diffForHumans() }}</small>
                                        </div>
                                        <p>{{ $child->content }}</p>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                        
                       
                    </div>
                     <!-- Añadir un comentario -->
                        @auth
                            <form action="{{ route('comments.store', $evento) }}" method="POST" class="mt-4">
                                @csrf
                                <div class="mb-3">
                                    <label for="comment" class="form-label">Añadir un comentario</label>
                                    <textarea name="comment" class="form-control" rows="3" placeholder="Escribe tu comentario aquí..." required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Enviar</button>
                            </form>
                        @else
                            <p class="mt-3">Por favor <a href="{{ route('login') }}">inicia sesión</a> para comentar.</p>
                        @endauth
                    <script>
                        function toggleReplyForm(commentId) {
                            const form = document.getElementById(`reply-form-${commentId}`);
                            if (form.style.display === 'none') {
                                form.style.display = 'block';
                            } else {
                                form.style.display = 'none';
                            }
                        }
                    </script>
                </div>
            </div>
        </div>
    </div>
    <div class="py5 eventos_relacionados">
        <div class="container swiper mySwiper">
            @if($eventosRelacionados->isEmpty())
                <p>No hay eventos disponibles.</p>
            @else
                <div class="row">
                    <div class="col-8">
                        <h3>Eventos relacionados</h3>
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
                              <p class="small text-muted mb-0"{{ $evento->precio }}></p>
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
    @vite(['resources/js/home.js'])
    @vite(['resources/css/evento.css', 'resources/js/evento.js'])

    
</body>

</html>