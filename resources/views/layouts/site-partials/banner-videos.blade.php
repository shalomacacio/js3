<!-- Start Small Banner  -->
<section class="small-banner section">
  <div class="container-fluid">
    <div class="row">
      @foreach ($videos as $video)
      <!-- Single Banner  -->
      <div class="col-lg-4 col-md-6 col-12">
        <div class="single-banner">
            <div class="embed-responsive embed-responsive-16by9">
              <iframe class="embed-responsive-item" src="{{ $video->url_video }}" allowfullscreen></iframe>
           </div>
        </div>
      </div>
      <!-- /End Single Banner  -->
      @endforeach
    </div>
  </div>
</section>
<!-- End Small Banner -->
