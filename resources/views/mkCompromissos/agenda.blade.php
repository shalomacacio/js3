@extends('layouts.relat-layout')

@section('css')
<link rel="stylesheet" href="{{ asset('/vendor/plugins/daterangepicker/daterangepicker.css') }}">
<link rel="stylesheet" href="{{ asset('/vendor/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('/vendor/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

<style>
    td {
      font-size: 9px;
    }
    th {
      font-size: 11px;
    }
    .card-header {
      padding: .4rem 1.25rem;
    }

    .compensacao {
      margin-top: 15px;
    }
  </style>
@endsection

@section('content')

@include('mkCompromissos.filtro')

<!-- Main content -->
<section class="content">
  <div class="container-fluid">
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
                  <th>CLIENTE</th>
                  <th>BAIRRO</th>
                  <th>SERVIÇO</th>
                  <th>APP</th>
                  <th>STATUS</th>
                  <th>ONLINE</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($compromissos as $compromisso)
                <tr id="{{ $compromisso->codcompromisso }}">
                  <td style="font-size: 9px" title="O.S:{{ $compromisso->os->codos}} Cli:{{ $compromisso->os->cliente}} ">
                    {!! \Illuminate\Support\Str::before($compromisso->com_titulo, 'Aberta')  !!}
                  </td>
                  <td style="font-size: 9px"
                    @isset( $compromisso->os->logradouro)  title="{{ $compromisso->os->logradouro->logradouro }} {{ $compromisso->os->num_endereco }}" @endisset >
                    @isset( $compromisso->os->logradouro) {{ $compromisso->os->logradouro->bairro->bairro }} @endisset
                  </td>
                  <td style="font-size: 9px"> {!! \Illuminate\Support\Str::after($compromisso->os->osTipo->descricao , ')')  !!} </td>
                  <td style="font-size: 9px" > @isset($compromisso->os->ultimo_status_app_mk_tx)<span class="badge {{ $compromisso->os->ultimo_status_app_mk }}"> {{ $compromisso->os->ultimo_status_app_mk_tx }}</span>@endisset</td>
                  <td style="font-size: 9px" > @isset($compromisso->os->classEncerramento->classificacao) {{ $compromisso->os->classEncerramento->classificacao }}@endisset  </td>
                  <td style="font-size: 9px" > 
                    @isset($compromisso->os->conexao) <span style="color: rgb(102, 255, 0);"><span class="fa fa-user "></span></span> @endisset
                    @empty($compromisso->os->conexao) <span style="color: Tomato;"><span class="fa fa-user "></span></span> @endempty
                  </td>
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


@endsection

@section('javascript')
<!-- DataTables -->
<script src="{{ asset('/vendor/plugins/jquery/jquery.min.js') }}"></script>

<script src="{{ asset('/vendor/plugins/datatables-bs4/js/dataTables.bootstrap4.js') }}"></script>
<script src="{{ asset('/vendor/plugins/select2/js/select2.full.min.js') }}"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment-with-locales.min.js"></script>

<script>
  //Initialize Select2 Elements
  $('.select2').select2()

  //Initialize Select2 Elements
  $('.select2bs4').select2({
    theme: 'bootstrap4'
  })

</script>

@stop
