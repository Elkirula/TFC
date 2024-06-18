<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/css/home.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <link rel="icon" href="{{ asset('favicon.png') }}">


    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Home</title>

</head>
<body>

  <div class="db-wrapper">
 
    <header>
      @extends('layouts.app')
      
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
                        <button type="submit" class="btn">Buscar</button>
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

{{-- 
      <div class="containerB">
        <div class="row justify-content-center">
            <div class="col-xl-12 col-lg-12 col-md-6 col-12">
                <div class="banner" data-testid="event-hero">
                    <div class="event-hero">
                        <div class="swiper bannerSwiper">
                            <div class="swiper-wrapper">
                                <!-- Iteración de Eventos -->
                                @foreach($eventos as $key => $evento)
                                    <div class="swiper-slide" style="background-image: url(data:image/jpeg;base64,{{ base64_encode($evento->multimedia->archivo ?? 'default-image') }});">
                                        <!-- Contenido del banner -->
                                        <div class="evento">
                                            @if($evento->multimedia)
                                                <img src="data:image/jpeg;base64,{{ base64_encode($evento->multimedia->archivo) }}" alt="Imagen del Evento">
                                            @else
                                                <img src="https://via.placeholder.com/300" alt="placeholder-image" />
                                            @endif
                                            <!-- Título del evento -->
                                            <h3>{{ $evento->titulo }}</h3>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <!-- Botones de navegación -->
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>
                            <!-- Paginación -->
                            <div class="swiper-pagination"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    </header>

    <div class="py5">
        <div class="container swiper mySwiper">
            @if($eventos->isEmpty())
                <p>No hay eventos disponibles.</p>
            @else
                <div class="row">
                    <div class="col-8">
                    <h3>Eventos populares</h3>
                    </div>
                </div>
                <div class="swiper-wrapper">
                    @foreach($eventos_top as $key => $evento)
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
                              <p class="small text-muted mb-0">Valoración de evento: {{ number_format($evento->valoracion_media, 1) }} / 5</p>
                              <div class="d-flex align-items-center justify-content-between rounded-pill bg-light px-3 py-2 mt-4">
                                <p class="small mb-0"><i class="fa fa-picture-o mr-2"></i><span class="font-weight-bold"></span></p>
                                <div class="badge badge-danger px-3 rounded-pill font-weight-normal">{{ $evento->precio }}€</div>
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

    <div class="py5">
        <div class="container swiper mySwiper">
            @if($eventos_musica->isEmpty())
                <p>No hay eventos disponibles.</p>
            @else
                <div class="row">
                    <div class="col-8">
                        <h3>Conciertos</h3>
                    </div>
                </div>
                <div class="swiper-wrapper">
                    @foreach($eventos_musica as $key => $evento)
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
                              <p class="small text-muted mb-0">Valoración de evento: {{ number_format($evento->valoracion_media, 1) }} / 5</p>
                                <div class="d-flex align-items-center justify-content-between rounded-pill bg-light px-3 py-2 mt-4">
                                <p class="small mb-0"><i class="fa fa-picture-o mr-2"></i><span class="font-weight-bold"></span></p>
                                <div class="badge badge-danger px-3 rounded-pill font-weight-normal">{{ $evento->precio }}€</div>
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

    <div class="py5">
        <div class="container swiper mySwiper">
            @if($eventos->isEmpty())
                <p>No hay eventos disponibles.</p>
            @else
                <div class="row">
                    <div class="col-8">
                        <h3>Todos los eventos</h3>
                    </div>
                </div>
                <div class="swiper-wrapper">
                    @foreach($eventos as $key => $evento)
                        <div class="swiper-slide"  class="col-xl-3 col-lg-4 col-md-6 mb-4">
                            <div class="p-4 event-card">
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
                              <p class="small text-muted mb-0">Valoración de evento: {{ number_format($evento->valoracion_media, 1) }} / 5</p>
                              <div class="d-flex align-items-center justify-content-between rounded-pill bg-light px-3 py-2 mt-4">
                                <p class="small mb-0"><i class="fa fa-picture-o mr-2"></i><span class="font-weight-bold"></span></p>
                                <div class="badge badge-danger px-3 rounded-pill font-weight-normal">{{ $evento->precio }}€</div>
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

    <div class="py-5 bg-gradient-categorias">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <h3 class="text-black">Categorias</h3>
          </div>
        </div> 
        <div class="row">
          <div class="d-flex align-items-lg-stretch col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
              <div class="card w-100 border-0 overlay-bg img-hover mb-3" style="background-image: url('https://assets-global.website-files.com/653116faea1efcd842fd9ace/65377d6ce37aaed8664a7a94_w.jpg'); background-size: cover;">
                  <span class="single-name"></span> 
                  <div class="pt-4 ps-4 pb-18 z-1">
                      <h3 class="text-white mb-0">Conciertos</h3>
                  </div> 
                  <a href="{{ route('busca', ['categoria_id' => 11]) }}" class="stretched-link"></a>
              </div>
          </div>
          <div class="d-flex align-items-lg-stretch col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
              <div class="card w-100 border-0 overlay-bg img-hover mb-3" style="background-image: url('https://muzikalia.com/wp-content/uploads/2023/07/Mad-Cool.jpg'); background-size: cover;">
                  <span class="single-name"></span> 
                  <div class="pt-4 ps-4 pb-18 z-1">
                      <h3 class="text-white mb-0">Festivales</h3>
                  </div> 
                  <a href="{{ route('busca', ['categoria_id' => 10]) }}" class="stretched-link"></a>
              </div>
          </div>
          <div class="d-flex align-items-lg-stretch col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
              <div class="card w-100 border-0 overlay-bg img-hover mb-3" style="background-image: url('https://www.elindependiente.com/wp-content/uploads/2020/06/201610214879b419a62977ea10ec89129e6487b1.jpg'); background-size: cover;">
                  <span class="single-name"></span> 
                  <div class="pt-4 ps-4 pb-18 z-1">
                      <h3 class="text-white mb-0">Discotecas</h3>
                  </div> 
                  <a href="{{ route('busca', ['categoria_id' => 6]) }}" class="stretched-link"></a>
              </div>
          </div>
        </div>
        <div class="row">
          <div class="d-flex align-items-lg-stretch col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
              <div class="card w-100 border-0 overlay-bg img-hover mb-3" style="background-image: url('https://www.guiarepsol.com/content/dam/repsol-guia/contenidos-imagenes/comer/top-de-gastronomia/los-restaurantes-mas-antiguos-de-espana/gr-cms-media-featured_images-none-759f762b-7965-41cd-a979-da49509e205d-1.jpg'); background-size: cover;">
                  <span class="single-name"></span> 
                  <div class="pt-4 ps-4 pb-18 z-1">
                      <h3 class="text-white mb-0">Comida</h3>
                  </div> 
                  <a href="{{ route('busca', ['categoria_id' => 7]) }}" class="stretched-link"></a>
              </div>
          </div>
          <div class="d-flex align-items-lg-stretch col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
              <div class="card w-100 border-0 overlay-bg img-hover mb-3" style="background-image: url('https://pre-webunwto.s3.eu-west-1.amazonaws.com/2023-09/international-tourism-swiftly-overcoming-pandemic-downturn.jpg?VersionId=4fzbgc78JHvwOKuqn0VyS1IRwIxhUjWi'); background-size: cover;">
                  <span class="single-name"></span> 
                  <div class="pt-4 ps-4 pb-18 z-1">
                      <h3 class="text-white mb-0">Turismo</h3>
                  </div> 
                  <a href="{{ route('busca', ['categoria_id' => 8]) }}" class="stretched-link"></a>
              </div>
          </div>
          <div class="d-flex align-items-lg-stretch col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
              <div class="card w-100 border-0 overlay-bg img-hover mb-3" style="background-image: url('https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEirqFAw-J6wyzqlow1SqgB5HCu6KnHzNAVq1vYz0A0TXzZ50LyY4oPiDmmooZgglSYE8sO1jR51gfmFK2qdCUZ-sOOwyNKA8gSVmE70gIp9QF2YUPkl1gpJRfmU2mpA5932tugBP8JZzbQv/s1600/Tecnologia+%25281%2529.jpg'); background-size: cover;">
                  <span class="single-name"></span> 
                  <div class="pt-4 ps-4 pb-18 z-1">
                      <h3 class="text-white mb-0">Tecnologia</h3>
                  </div> 
                  <a href="{{ route('busca', ['categoria_id' => 9]) }}" class="stretched-link"></a>
              </div>
          </div>
        </div>
      </div>
    </div>

    <div class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h3 class="text-black">Organizadores populares</h3>
                </div>
            </div> 
            <div class="row">
                @foreach($organizadores as $usuario)
                    @if($usuario->foto)
                        <div class="col-4 col-md-4 col-lg-4">
                            <div class="card-wrapper mx-auto">
                                <div class="card-organizador">
                                    <div class="card-image">
                                        <img src="data:image/jpeg;base64,{{ base64_encode($usuario->foto) }}" alt="profile one">
                                    </div>
                                    <ul class="social-icons">
                                        <li>
                                            <a href="#">
                                                <i class="fab fa-facebook-f"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="fab fa-instagram"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="fab fa-twitter"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="fab fa-dribbble"></i>
                                            </a>
                                        </li>
                                    </ul>
                                    <div class="details">
                                        <h2>{{ $usuario->name }}</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach   
            </div>
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


    @vite(['resources/js/home.js'])

</body>
</html>