  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
    <div class="container">
        <a href="{{ route('welcome') }}" class="navbar-brand">
        <img src="{{ asset('vendor/adminlte/dist/img/logo.jpg') }}"  alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">JS3</span>
      </a>

      <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      {{-- <div class="collapse navbar-collapse order-3" id="navbarCollapse">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
          <li class="nav-item">
            <a href="index3.html" class="nav-link">Home</a>
          </li>
        </ul>
      </div> --}}

      <!-- Right navbar links -->
      <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
        <!-- SEARCH FORM -->

        <input class="btn btn-primary" type="button" value="Atualizar" onClick="window.location.reload()"> 

      </ul>

    </div>
  </nav>
  <!-- /.navbar -->
  @section('javascript')
  <script>

    function reloadThePage() {
        window.location.reload();
    } 
  </script>
  @endsection

