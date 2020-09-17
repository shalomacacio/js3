<!-- Start Midium Banner  -->
<section class="midium-banner">
    <div class="container">
        <div class="row">
          @foreach ($bannerPromocionals as $banner)
            <!-- Single Banner  -->
            <div class="col-lg-6 col-md-6 col-12">
                <div class="single-banner">
                    <img src="{{ url("storage/{$banner->img}") }}"  alt="#">
                    <div class="content">
                        <p>@isset($banner->subtitulo){{ $banner->subtitulo}} @endisset</p>
                        <h3>@isset($banner->titulo){{ $banner->titulo}} @endisset</p> <span> @isset($banner->span){{ $banner->span}} @endisset</p></span></h3>
                        @isset($banner->txt_button)
                        <a href="{{ $banner->link_button}}" target="_blank" >{{ $banner->txt_button}}</a>
                        @endisset
                    </div>
                </div>
            </div>
            <!-- /End Single Banner  -->
            @endforeach
        </div>
    </div>
</section>
<!-- End Midium Banner -->
