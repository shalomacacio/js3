<section class="content-header">

  <div class="container-fluid">

    <div class="row ">

      <div class="col-sm-1">
        <h1>Filtros</h1>
      </div>

      <div class="col-sm-10">
        <form class="form-inline"  action="{{ route('mkCompromissos.agenda') }}"   method="GET">
          @csrf

          <div class="col-12 col-sm-12 col-md-4" >
            <!-- select -->
            <div class="form-group">
              <select class="select2bs4"  name="grupos[]" multiple="multiple" data-placeholder="-- EQUIPE --" style="width: 100%;">
                @foreach($grupos as $grupo)
                  <option value="{{ $grupo->codagenda_grupo }}"> {{ $grupo->nome }} </option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="col-12 col-sm-12 col-md-4" >
            <div class="compensacao"> </div>
            <div class="form-group">
              <div class="input-group input-group-md mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                </div>
                <!-- /btn-group -->
                {{-- <input type="text" class="form-control float-right" id="reservation"> --}}
                <input type="date" class="form-control" name="dt_filtro" value="
                @isset($request->dt_filtro)
                  {{ \Carbon\Carbon::parse($request->dt_filtro)->format('Y-m-d') }}
                @endisset">
                <span class="input-group-append">
                  <button type="submit" class="btn btn-info btn-flat">Cuida!</button>
                </span>
              </div>
            </div>
          </div>

        </form>
      </div>

      <div class="col-sm-1">
        <h1> {{ $concluidos }}  / {{ $total }}</h1>
      </div>

    </div>
  </div><!-- /.container-fluid -->
</section>