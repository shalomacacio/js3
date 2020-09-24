@extends('layouts.agenda-layout')

@section('content')
    <!-- Main content -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <div class="content">
      <div class="container">

        <!-- Content Header (Page header) -->
        <div class="content-header">
          <div class="container">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1 class="m-0 text-dark"> AGENDA <small>3.0</small></h1>
              </div><!-- /.col -->
            </div><!-- /.row -->
          </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
          <div class="container-fluid">
          <section class="col-lg-12 connectedSortable">
            
          </section>
            <!-- /.row -->
            <div class="row">
              @foreach ($mkCompromissos as $comps => $compromissos)

              <section class="col-lg-6 connectedSortable">
                <div class="card card-info">

                  <div class="card-header">
                    <h3 class="card-title">{{ $comps }}</h3>
                    <div class="card-tools">
                      <span data-toggle="tooltip" title="3 New Messages" class="badge bg-primary">{{ $compromissos->count() }}</span>
                      <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                      </button>
                      <button type="button" class="btn btn-tool" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                      </button>
                    </div>
                  </div>

                  <!-- /.card-header -->
                  <div class="card-body table-responsive p-0" style="height: 200px;">
                    <table class="table table-sm  table-head-fixed  ">
                      <thead>
                        <tr>
                          <th  style="width: 200px">CLIENTE</th>
                          <th style="width: 100px">BAIRRO</th>
                          <th >SERVIÇO</th>
                          <th>APP</th>
                          <th>STATUS</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($compromissos as $compromisso)
                        <tr id="{{ $compromisso->codcompromisso }}" >
                          <td title="O.S:{{ $compromisso->os->codos}} Cli: ">
                            <a href="#">{!! \Illuminate\Support\Str::before($compromisso->com_titulo, 'Aberta')  !!}</a>
                          </td>
                          <td title="{{ $compromisso->os->logradouro->logradouro }} {{ $compromisso->os->num_endereco }}">
                            {{ $compromisso->os->logradouro->bairro->bairro }}
                          </td>
                          <td> {!! \Illuminate\Support\Str::after($compromisso->os->osTipo->descricao , ')')  !!} </td>
                          <td> @isset($compromisso->os->ultimo_status_app_mk_tx)<span class="badge {{ $compromisso->os->ultimo_status_app_mk }}"> {{ $compromisso->os->ultimo_status_app_mk_tx }}</span>@endisset</td>
                          <td> @isset($compromisso->os->classEncerramento->classificacao) {{ $compromisso->os->classEncerramento->classificacao }}@endisset  </td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                  <!-- /.card-body -->
                </div>
                <!-- /.card -->
              </section>
              @endforeach
            </div>
            <!-- /.row -->
          </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
      </div>
    </div>
  </div>
@endsection
@section('javascript')
<script src="{{ asset('/vendor/adminlte/dist/js/pages/dashboard.js') }}"></script>
@endsection
