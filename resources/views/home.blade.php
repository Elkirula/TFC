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
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Home</title>
 <script>
        // Función para abrir el modal
        function openLoginModal() {
            $('#loginModal').modal('show');
        }

        // Ejemplo de cómo llamar al modal desde cualquier parte
        $(document).ready(function(){
            $('.open-login-modal').click(function(){
                openLoginModal();
            });
        });
    </script>

</head>
<body>

  <div class="db-wrapper">
 
    <header>
      @extends('layouts.app')
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
                    @auth
                      <a class="nav-link active" href="{{ route('panel_usuario') }}">Cuenta</a>
                    @else
                      {{-- open-login-modal--}}<a class="nav-link active" href="{{ route('login') }}">Login</a>
                    @endauth
                    </div>
                </div>
                </div>
        </nav>
        <div class="text-center">
            <img src="https://eventmie-pro-fullyloaded-demo.classiebit.com/storage/banners/November2023/l6KOsWwDM8fwGBnY83NG.webp" class="rounded mx-auto d-block" width="80%" >
        </div>
      
    </header>
    
    <div class="container">
      <div class="row">
          <div class="col-12">
              <div class="card border-0 p-2 search-form rounded-md-pill smooth-shadow-md mt-n5">
                  <form type="GET" action="https://eventmie-pro-fullyloaded-demo.classiebit.com/events">
                      <div class="row align-items-center">
                          <div class="col-sm">
                              <div class="form-floating">
                                  <input type="text" name="search" placeholder="Search Event" class="form-control border-bottom border-bottom-md-0 rounded-0 border-0 form-focus-none bg-transparent">
                                  <label for="search">Search Event</label>
                              </div>
                          </div>
                          <div class="col-sm">
                              <div class="form-floating">
                                  <select id="city" name="city" class="form-select border-bottom border-bottom-md-0 rounded-0 border-0 form-focus-none bg-transparent">
                                      <option value="All">All</option>
                                      <option value="New York">New York, NY</option>
                                      <option value="Lanzhou">Lanzhou, Gansu</option>
                                      <option value="Coomalbidgup">Coomalbidgup, WA 6450</option>
                                      <option value="Telford">Telford, London</option>
                                      <option value="Wolverhampton">Wolverhampton, West Midlands</option>
                                      <option value="Riverview">Riverview, NB</option>
                                      <option value="Amsterdam">Amsterdam, NH</option>
                                  </select>
                                  <label for="city_select">City</label>
                              </div>
                          </div>
                          <div class="col-sm">
                              <div class="form-floating">
                                  <select id="category" name="category" class="form-select border-bottom border-bottom-md-0 rounded-0 border-0 form-focus-none bg-transparent">
                                      <option value="All">All</option>
                                      <option value="Business &amp; Seminars">Business &amp; Seminars</option>
                                      <option value="Yoga &amp; Health">Yoga &amp; Health</option>
                                      <option value="Education &amp; Classes">Education &amp; Classes</option>
                                      <option value="Sports &amp; Fitness">Sports &amp; Fitness</option>
                                      <option value="Music &amp; Concerts">Music &amp; Concerts</option>
                                      <option value="Charity &amp; Non-profit">Charity &amp; Non-profit</option>
                                      <option value="Food &amp; Drink">Food &amp; Drink</option>
                                      <option value="Travel &amp; Trekking">Travel &amp; Trekking</option>
                                      <option value="Science &amp; Tech">Science &amp; Tech</option>
                                  </select>
                                  <label for="category">Category</label>
                              </div>
                          </div>
                          <div class="col-sm">
                              <div class="form-floating">
                                  <select id="price" name="price" class="form-select border-0 form-focus-none">
                                      <option value="">Any Price</option>
                                      <option value="free">Free</option>
                                      <option value="paid">Paid</option>
                                  </select>
                                  <label for="price">Price</label>
                              </div>
                          </div>
                          <div class="col-sm-1">
                              <div class="d-md-flex justify-content-end ms-md-n3 ms-lg-0 text-end d-none d-md-block">
                                  <button type="submit" class="btn btn-primary rounded-circle btn-icon btn-icon-lg">
                                      <i class="fas fa-search"></i>
                                  </button>
                              </div>
                              <div class="d-md-flex justify-content-end ms-md-n3 ms-lg-0 d-block d-md-none">
                                  <button type="submit" class="btn btn-primary d-grid gap-2 col-12 mx-auto">
                                      Search
                                  </button>
                              </div>
                          </div>
                      </div>
                  </form>
              </div>
          </div>
      </div>
  </div>

  <div class="py5">
        <div class="container swiper mySwiper">
            @if($eventos->isEmpty())
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
                    @foreach($eventos as $key => $evento)
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

  <div class="py5">
        <div class="container swiper mySwiper">
            @if($eventos->isEmpty())
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
                    @foreach($eventos as $key => $evento)
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

 <div class="py5">
        <div class="container swiper mySwiper">
            @if($eventos->isEmpty())
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
                    @foreach($eventos as $key => $evento)
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

    <div class="py-5 bg-gradient">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <h3 class="text-white">Event Categories</h3>
          </div>
        </div> 
        <div class="row">
          <div class="d-flex align-items-lg-stretch col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12' }}">
            <div class="card w-100 border-0 overlay-bg img-hover mb-3" style="background-image: url(&quot;https://eventmie-pro-fullyloaded-demo.classiebit.com/storage/categories/November2023/4TJEOlcCB1z27iCYZqvW.webp&quot;); background-size: cover;">
              <span class="single-name"></span> 
              <div class="pt-4 ps-4 pb-18 z-1">
                <h3 class="text-white mb-0">Business &amp; Seminars</h3>
              </div> 
              <a href="https://eventmie-pro-fullyloaded-demo.classiebit.com/events?category=Business%2B%2526%2BSeminars" class="stretched-link"></a>
            </div>
          </div> 
            <div class="d-flex align-items-lg-stretch col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12' }}">
              <div class="card w-100 border-0 overlay-bg img-hover mb-3" style="background-image: url(&quot;https://eventmie-pro-fullyloaded-demo.classiebit.com/storage/categories/November2023/5e25dBRZOUVnbhedF2MH.webp&quot;); background-size: cover;">
                <span class="single-name"></span>
                <div class="pt-4 ps-4 pb-18 z-1">
                  <h3 class="text-white mb-0">Yoga &amp; Health</h3>
                </div> 
                <a href="https://eventmie-pro-fullyloaded-demo.classiebit.com/events?category=Yoga%2B%2526%2BHealth" class="stretched-link"></a>
              </div>
            </div> 
            <div class="d-flex align-items-lg-stretch col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12' }}">
              <div class="card w-100 border-0 overlay-bg img-hover mb-3" style="background-image: url(&quot;https://eventmie-pro-fullyloaded-demo.classiebit.com/storage&quot;); background-size: cover;">
                <span class="single-name"></span> 
                <div class="pt-4 ps-4 pb-18 z-1">
                  <h3 class="text-white mb-0">Education &amp; Classes</h3>
                </div>
                <a href="https://eventmie-pro-fullyloaded-demo.classiebit.com/events?category=Education%2B%2526%2BClasses" class="stretched-link"></a>
              </div></div> <div class="d-flex align-items-lg-stretch col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12' }}">
                <div class="card w-100 border-0 overlay-bg img-hover mb-3" style="background-image: url(&quot;https://eventmie-pro-fullyloaded-demo.classiebit.com/storage/categories/November2023/K2P90dCE7Fuw8zvxnkgg.webp&quot;); background-size: cover;">
                  <span class="single-name"></span> 
                <div class="pt-4 ps-4 pb-18 z-1">
                  <h3 class="text-white mb-0">Sports &amp; Fitness</h3>
                </div> 
              <a href="https://eventmie-pro-fullyloaded-demo.classiebit.com/events?category=Sports%2B%2526%2BFitness" class="stretched-link"></a>
            </div>
          </div> 
          <div class="d-flex align-items-lg-stretch col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12' }}">
            <div class="card w-100 border-0 overlay-bg img-hover mb-3" style="background-image: url(&quot;https://eventmie-pro-fullyloaded-demo.classiebit.com/storage/categories/November2023/bz7BbxKoJv8U5aW1ZOZu.webp&quot;); background-size: cover;">
              <span class="single-name"></span>
              <div class="pt-4 ps-4 pb-18 z-1">
                <h3 class="text-white mb-0">Music &amp; Concerts</h3>
              </div> 
              <a href="https://eventmie-pro-fullyloaded-demo.classiebit.com/events?category=Music%2B%2526%2BConcerts" class="stretched-link"></a>
            </div>
          </div> 
          <div class="d-flex align-items-lg-stretch col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12' }}">
            <div class="card w-100 border-0 overlay-bg img-hover mb-3" style="background-image: url(&quot;https://eventmie-pro-fullyloaded-demo.classiebit.com/storage/categories/November2023/MxawA6op8tqC3A0Sqeo1.webp&quot;); background-size: cover;">
              <span class="single-name"></span> 
              <div class="pt-4 ps-4 pb-18 z-1">
                <h3 class="text-white mb-0">Charity &amp; Non-profit</h3>
              </div> 
              <a href="https://eventmie-pro-fullyloaded-demo.classiebit.com/events?category=Charity%2B%2526%2BNon-profit" class="stretched-link"></a>
            </div>
          </div> 
          <div class="d-flex align-items-lg-stretch col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12' }}">
            <div class="card w-100 border-0 overlay-bg img-hover mb-3" style="background-image: url(&quot;https://eventmie-pro-fullyloaded-demo.classiebit.com/storage/categories/November2023/ATaXt6ikG7G78ZFHNP27.webp&quot;); background-size: cover;">
              <span class="single-name"></span> 
              <div class="pt-4 ps-4 pb-18 z-1">
                <h3 class="text-white mb-0">Food &amp; Drink</h3>
              </div> 
              <a href="https://eventmie-pro-fullyloaded-demo.classiebit.com/events?category=Food%2B%2526%2BDrink" class="stretched-link"></a>
            </div>
          </div> 
          <div class="d-flex align-items-lg-stretch col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12' }}">
            <div class="card w-100 border-0 overlay-bg img-hover mb-3" style="background-image: url(&quot;https://eventmie-pro-fullyloaded-demo.classiebit.com/storage/categories/November2023/Y1woPLjWyIXMwEQahP0q.webp&quot;); background-size: cover;">
              <span class="single-name"></span> 
              <div class="pt-4 ps-4 pb-18 z-1">
                <h3 class="text-white mb-0">Travel &amp; Trekking</h3>
              </div> 
              <a href="https://eventmie-pro-fullyloaded-demo.classiebit.com/events?category=Travel%2B%2526%2BTrekking" class="stretched-link">
              </a>
            </div>
          </div> 
          <div class="d-flex align-items-lg-stretch col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12' }}">
            <div class="card w-100 border-0 overlay-bg img-hover mb-3" style="background-image: url(&quot;https://eventmie-pro-fullyloaded-demo.classiebit.com/storage/categories/November2023/1AZg61UWUVRE2fjy7z7b.webp&quot;); background-size: cover;">
              <span class="single-name"></span> 
              <div class="pt-4 ps-4 pb-18 z-1">
                <h3 class="text-white mb-0">Science &amp; Tech</h3>
              </div> 
              <a href="https://eventmie-pro-fullyloaded-demo.classiebit.com/events?category=Science%2B%2526%2BTech" class="stretched-link"></a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="py-5 bg-gradient2">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <h3 class="text-white">Event Categories</h3>
          </div>
        </div> 
        <div class="row">
          <div class="d-flex align-items-lg-stretch col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12' }}">
            <div class="card w-100 border-0 overlay-bg img-hover mb-3" style="background-image: url(&quot;https://eventmie-pro-fullyloaded-demo.classiebit.com/storage/categories/November2023/4TJEOlcCB1z27iCYZqvW.webp&quot;); background-size: cover;">
              <span class="single-name"></span> 
              <div class="pt-4 ps-4 pb-18 z-1">
                <h3 class="text-white mb-0">Business &amp; Seminars</h3>
              </div> 
              <a href="https://eventmie-pro-fullyloaded-demo.classiebit.com/events?category=Business%2B%2526%2BSeminars" class="stretched-link"></a>
            </div>
          </div> 
            <div class="d-flex align-items-lg-stretch col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12' }}">
              <div class="card w-100 border-0 overlay-bg img-hover mb-3" style="background-image: url(&quot;https://eventmie-pro-fullyloaded-demo.classiebit.com/storage/categories/November2023/5e25dBRZOUVnbhedF2MH.webp&quot;); background-size: cover;">
                <span class="single-name"></span>
                <div class="pt-4 ps-4 pb-18 z-1">
                  <h3 class="text-white mb-0">Yoga &amp; Health</h3>
                </div> 
                <a href="https://eventmie-pro-fullyloaded-demo.classiebit.com/events?category=Yoga%2B%2526%2BHealth" class="stretched-link"></a>
              </div>
            </div> 
            <div class="d-flex align-items-lg-stretch col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12' }}">
              <div class="card w-100 border-0 overlay-bg img-hover mb-3" style="background-image: url(&quot;https://eventmie-pro-fullyloaded-demo.classiebit.com/storage&quot;); background-size: cover;">
                <span class="single-name"></span> 
                <div class="pt-4 ps-4 pb-18 z-1">
                  <h3 class="text-white mb-0">Education &amp; Classes</h3>
                </div>
                <a href="https://eventmie-pro-fullyloaded-demo.classiebit.com/events?category=Education%2B%2526%2BClasses" class="stretched-link"></a>
              </div></div> <div class="d-flex align-items-lg-stretch col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12' }}">
                <div class="card w-100 border-0 overlay-bg img-hover mb-3" style="background-image: url(&quot;https://eventmie-pro-fullyloaded-demo.classiebit.com/storage/categories/November2023/K2P90dCE7Fuw8zvxnkgg.webp&quot;); background-size: cover;">
                  <span class="single-name"></span> 
                <div class="pt-4 ps-4 pb-18 z-1">
                  <h3 class="text-white mb-0">Sports &amp; Fitness</h3>
                </div> 
              <a href="https://eventmie-pro-fullyloaded-demo.classiebit.com/events?category=Sports%2B%2526%2BFitness" class="stretched-link"></a>
            </div>
          </div> 
          <div class="d-flex align-items-lg-stretch col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12' }}">
            <div class="card w-100 border-0 overlay-bg img-hover mb-3" style="background-image: url(&quot;https://eventmie-pro-fullyloaded-demo.classiebit.com/storage/categories/November2023/bz7BbxKoJv8U5aW1ZOZu.webp&quot;); background-size: cover;">
              <span class="single-name"></span>
              <div class="pt-4 ps-4 pb-18 z-1">
                <h3 class="text-white mb-0">Music &amp; Concerts</h3>
              </div> 
              <a href="https://eventmie-pro-fullyloaded-demo.classiebit.com/events?category=Music%2B%2526%2BConcerts" class="stretched-link"></a>
            </div>
          </div> 
          <div class="d-flex align-items-lg-stretch col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12' }}">
            <div class="card w-100 border-0 overlay-bg img-hover mb-3" style="background-image: url(&quot;https://eventmie-pro-fullyloaded-demo.classiebit.com/storage/categories/November2023/MxawA6op8tqC3A0Sqeo1.webp&quot;); background-size: cover;">
              <span class="single-name"></span> 
              <div class="pt-4 ps-4 pb-18 z-1">
                <h3 class="text-white mb-0">Charity &amp; Non-profit</h3>
              </div> 
              <a href="https://eventmie-pro-fullyloaded-demo.classiebit.com/events?category=Charity%2B%2526%2BNon-profit" class="stretched-link"></a>
            </div>
          </div> 
          <div class="d-flex align-items-lg-stretch col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12' }}">
            <div class="card w-100 border-0 overlay-bg img-hover mb-3" style="background-image: url(&quot;https://eventmie-pro-fullyloaded-demo.classiebit.com/storage/categories/November2023/ATaXt6ikG7G78ZFHNP27.webp&quot;); background-size: cover;">
              <span class="single-name"></span> 
              <div class="pt-4 ps-4 pb-18 z-1">
                <h3 class="text-white mb-0">Food &amp; Drink</h3>
              </div> 
              <a href="https://eventmie-pro-fullyloaded-demo.classiebit.com/events?category=Food%2B%2526%2BDrink" class="stretched-link"></a>
            </div>
          </div> 
          <div class="d-flex align-items-lg-stretch col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12' }}">
            <div class="card w-100 border-0 overlay-bg img-hover mb-3" style="background-image: url(&quot;https://eventmie-pro-fullyloaded-demo.classiebit.com/storage/categories/November2023/Y1woPLjWyIXMwEQahP0q.webp&quot;); background-size: cover;">
              <span class="single-name"></span> 
              <div class="pt-4 ps-4 pb-18 z-1">
                <h3 class="text-white mb-0">Travel &amp; Trekking</h3>
              </div> 
              <a href="https://eventmie-pro-fullyloaded-demo.classiebit.com/events?category=Travel%2B%2526%2BTrekking" class="stretched-link">
              </a>
            </div>
          </div> 
          <div class="d-flex align-items-lg-stretch col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12' }}">
            <div class="card w-100 border-0 overlay-bg img-hover mb-3" style="background-image: url(&quot;https://eventmie-pro-fullyloaded-demo.classiebit.com/storage/categories/November2023/1AZg61UWUVRE2fjy7z7b.webp&quot;); background-size: cover;">
              <span class="single-name"></span> 
              <div class="pt-4 ps-4 pb-18 z-1">
                <h3 class="text-white mb-0">Science &amp; Tech</h3>
              </div> 
              <a href="https://eventmie-pro-fullyloaded-demo.classiebit.com/events?category=Science%2B%2526%2BTech" class="stretched-link"></a>
            </div>
          </div>
        </div>
      </div>
    </div>

   </div>
    @vite(['resources/js/home.js'])

</body>
</html>