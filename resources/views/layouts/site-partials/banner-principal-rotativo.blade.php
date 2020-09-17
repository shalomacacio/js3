    <!-- Slide Area -->
    <section>
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
              @foreach($bannerRotativos as $banner)
                @if($banner->ativo == 1)
                <div class="carousel-item active">
                  <img class="d-block w-100" src="{{ url("storage/{$banner->img}") }}" alt="First slide">                 <div class="carousel-caption d-none d-md-block">
                    @isset($banner->titulo)<h1> {{$banner->titulo}} </h1> @endisset
                    @isset($banner->subtitulo)<p> {{$banner->subtitulo}} </p> @endisset
                  </div>
                </div>
                @else
                <div class="carousel-item">
                  <img class="d-block w-100" src="{{ url("storage/{$banner->img}") }}" alt="First slide">
                    <div class="carousel-caption d-none d-md-block">
                      @if($banner->titulo_ativo == 1)<h1> {{$banner->titulo}} </h1> @endif
                      @if($banner->subtitulo_ativo == 1)<p> {{$banner->subtitulo}} </p> @endif
                  </div>
                </div>
                @endif
              @endforeach
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="sr-only">Next</span>
            </a>

        </div>
        <!-- End Carousel Slider -->
    </Section>
    <!-- End Slide Area -->
