<section class="content-header">

  <div class="container-fluid">

    <div class="row ">

      <div class="col-sm-2">
        <h1>Filtros</h1>
      </div>

      <div class="col-sm-10">
        <form class="form-inline"  action="{{ route('relatorio.servicos') }}"   method="GET">
          @csrf


          <div class="col-12 col-sm-12 col-md-2" >
            <!-- select -->
            <div class="form-group">
              <select class="select2bs4"  name="tipos[]" multiple="multiple" data-placeholder="-- SERVIÇOS --" style="width: 100%;">
                @foreach($tipos as $tipo)
                  <option value="{{ $tipo->codostipo }}"> {{ $tipo->descricao }} </option>
                @endforeach
              </select>
            </div>
          </div>

            <div class="col-12 col-sm-12 col-md-2" >
              <!-- select -->
              <div class="form-group">
                <select class="select2bs4"  name="tecnicos[]" multiple="multiple" data-placeholder="-- TECNICOS --" style="width: 100%;">
                  @foreach($tecnicos as $tecnico)
                    <option value="{{ $tecnico->usr_codigo }}"> {{ $tecnico->usr_nome }} </option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="col-12 col-sm-12 col-md-2" >
              <!-- select -->
              <div class="form-group">
                <select class="select2bs4"  name="consultores[]" multiple="multiple" data-placeholder="-- CONSULTORES --" style="width: 100%;">
                  @foreach($consultores as $consultor)
                    <option value="{{ $consultor->usr_codigo }}"> {{ $consultor->usr_nome }} </option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="col-12 col-sm-12 col-md-2" >
              <!-- select -->
              <div class="form-group">
                <select class="select2bs4"  name="classificacoes[]" multiple="multiple" data-placeholder="-- CLASSIFICAÇÃO --" style="width: 100%;">
                  @foreach($classificacoes as $classificacao)
                    <option value="{{ $classificacao->codclassifenc }}"> {{ $classificacao->classificacao }} </option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="col-12 col-sm-12 col-md-3" >
              <div class="form-group">
                <div class="input-group input-group-sm">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="far fa-calendar-alt"></i>
                    </span>
                  </div>
                  <input type="text" class="form-control float-right" id="reservation">
                  <span class="input-group-append">
                    <button type="submit" class="btn btn-info btn-flat">Cuida!</button>
                  </span>
                </div>
              </div>
            </div>

            <input type="hidden" name="dt_inicio" id="dt_inicio">
            <input type="hidden" name="dt_fim" id="dt_fim">

        </form>
      </div>

    </div>
  </div><!-- /.container-fluid -->
</section>
