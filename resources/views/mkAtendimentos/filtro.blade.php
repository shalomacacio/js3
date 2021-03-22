<section class="content-header">

  <div class="container-fluid">

    <div class="row ">

      <div class="col-sm-1">
        <h1>Filtros</h1>
      </div>

      <div class="col-sm-10">
        <form class="form-inline"  action="{{ route('atendimentos.abertos') }}"   method="GET">
          @csrf


          <div class="col-12 col-sm-12 col-md-2" >
            <!-- select -->
            <div class="form-group">
              <select class="select2bs4"  name="processos[]" multiple="multiple" data-placeholder="-- PROCESSOS --" style="width: 100%;">
                @foreach($processos as $processo)
                  <option value="{{ $processo->codprocesso }}"> {{ $processo->nome_processo }} </option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="col-12 col-sm-12 col-md-2" >
            <!-- select -->
            <div class="form-group">
              <select class="select2bs4"  name="subprocessos[]" multiple="multiple" data-placeholder="-- SUBPROCESSOS --" style="width: 100%;">
                @foreach($subprocessos as $subprocesso)
                  <option value="{{ $subprocesso->codsubprocesso }}"> {{ $subprocesso->nome_subprocesso }} </option>
                @endforeach
              </select>
            </div>
          </div>

            <div class="col-12 col-sm-12 col-md-2" >
              <!-- select -->
              <div class="form-group">
                <select class="select2bs4"  name="classificacaos[]" multiple="multiple" data-placeholder="-- CLASSIFICAÇÃO --" style="width: 100%;">
                  @foreach($classificacaos as $classificacao)
                    <option value="{{ $classificacao->codatclass }}"> {{ $classificacao->descricao }} </option>
                  @endforeach
                </select>
              </div>
            </div>

            {{-- <div class="col-12 col-sm-12 col-md-2" >
              <!-- select -->
              <div class="form-group">
                <select class="select2bs4"  name="consultores[]" multiple="multiple" data-placeholder="-- CONSULTORES --" style="width: 100%;">
                  @foreach($consultores as $consultor)
                    <option value="{{ $consultor->usr_codigo }}"> {{ $consultor->usr_nome }} </option>
                  @endforeach
                </select>
              </div>
            </div> --}}
{{-- 
            <div class="col-12 col-sm-12 col-md-2" >
              <!-- select -->
              <div class="form-group">
                <select class="select2bs4"  name="classificacoes[]" multiple="multiple" data-placeholder="-- CLASSIFICAÇÃO --" style="width: 100%;">
                  @foreach($classificacoes as $classificacao)
                    <option value="{{ $classificacao->codclassifenc }}"> {{ $classificacao->classificacao }} </option>
                  @endforeach
                </select>
              </div>
            </div> --}}

            {{-- <div class="col-12 col-sm-12 col-md-3" >
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
            </div> --}}

            <div class="col-12 col-sm-12 col-md-2" >
              <!-- select -->
              <div class="form-group">
                <button type="submit" class="btn btn-info btn-flat">Cuida!</button>
              </div>
            </div>

          
        </form>
      </div>

      <div class="col-sm-1">
        <h1> {{ $atendimentos->count() }} </h1>
      </div>

    </div>
  </div><!-- /.container-fluid -->
</section>
