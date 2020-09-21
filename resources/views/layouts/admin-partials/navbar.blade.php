
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
    <div class="container">
        <a href="{{ route('mkOs.index') }}" class="navbar-brand">
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
        <form class="form-inline ml-0 ml-md-3" action="{{ route('mkCompromissos.agenda') }}" method="GET">
          @csrf
          <div class="input-group input-group-sm">

          <input class="form-control form-control-navbar" type="date" name="dt_agenda" value="{{\Carbon\Carbon::parse($inicio)->format('Y-m-d')}}">

            <div class="input-group-append">
              <button class="btn btn-navbar" type="submit">
                <i class="fas fa-search"></i>
              </button>
            </div>

          </div>
        </form>
      </ul>

    </div>
  </nav>
  <!-- /.navbar -->

