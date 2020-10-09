<section class="content-header">

  <div class="container-fluid">

    <div class="row ">

      <div class="col-sm-2">
        <h1>Filtros</h1>
      </div>

      <div class="col-sm-10">
        <form class="form-inline"  action="{{ route('relatorio.servicos') }}"   method="GET">
          @csrf

            <div class="form-group">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="far fa-calendar-alt"></i>
                  </span>
                </div>
                <input type="text" class="form-control float-right" id="reservation">
              </div>
            </div>

            <div class="form-group">
              <button type="submit" class="btn btn-info">Sign in</button>
            </div>
            <input type="hidden" name="dt_inicio" id="dt_inicio">
            <input type="hidden" name="dt_fim" id="dt_fim">

        </form>
      </div>

    </div>
  </div><!-- /.container-fluid -->
</section>
