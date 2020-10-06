@extends('layouts.relat-layout')


@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Autorizar Comissões</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Comissão</a></li>
              <li class="breadcrumb-item active">Minhas Comissões</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
      {{-- @include('comissaos.search_form') --}}
      {{-- @include('comissaos.widget') --}}
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
            <div class="row">
                    <div class="col-md-12">
                      <div class="card card-info">
                        <div class="card-header">
                            <div class="d-flex justify-content-between">
                                <h3 class="card-title">{{ \Carbon\Carbon::now('America/Fortaleza')->format('d-M-y') }}</h3>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                          <div class="table-responsive">
                          <table class="table table-bordered" id="ordenacao">
                            <thead>
                              <tr>
                                <th>Data</th>
                                <th>O.S</th>
                                <th>Cliente</th>
                                <th>Serviço </th>
                                <th>Técnico</th>
                                <th>Consultor</th>
                                <th>Plano</th>
                                <th>Taxa</th>
                                <th>Status</th>
                              </tr>
                            </thead>
                            <tbody>
                                @foreach ($servicos as $servico)
                                    <tr>
                                      <td>{{ \Carbon\Carbon::parse($servico->data_fechamento)->format('d/m') }}</td>
                                      <td>{{ $servico->codos }}</td>
                                      <td>@isset($servico->nome_razaosocial) {{ $servico->nome_razaosocial }} @endisset</td>
                                      <td>{{ $servico->descricao }}</td>
                                      <td>{{ $servico->tecnico }}</td>
                                      <td> @isset($servico->consultor) {{ $servico->consultor }} @endisset </td>
                                      <td>
                                        {{-- @isset($servico->usuario->contratos)
                                          @foreach ($servico->usuario->contratos as $contrato)
                                            {{ $contrato }}
                                          @endforeach
                                        @endisset --}}
                                      </td>
                                      <td>{{ $servico->indicacoes }}</td>
                                      <td>{{ $servico->classificacao }} </td>
                                    </tr>
                                @endforeach
                            </tbody>
                          </table>
                        </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer clearfix">
                          <ul class="pagination pagination-sm m-0 float-right">
                                {{-- {{ $ordens->render() }} --}}
                          </ul>
                        </div>
                      </div>
                      <!-- /.card -->
                    </div>
                  </div>
                </div>
        </section>
    </div>


@endsection



@section('javascript')
<!-- DataTables -->
<script src="{{ asset('/vendor/plugins/datatables/jquery.dataTables.js') }}"></script>
<script src="{{ asset('/vendor/plugins/datatables-bs4/js/dataTables.bootstrap4.js') }}"></script>

<script>
  $(function () {
    $("#ordenacao").DataTable({
      "paging": false,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": true,
      "language": {
        search: "Pesquisar" ,
        show: "Mostrar",
        info: "Mostrando pag _PAGE_ de _PAGES_",
        lengthMenu:    "Mostrar _MENU_ ",
        paginate: {
            first:      "Primeiro",
            previous:   "Anterior",
            next:       "Próximo",
            last:       "Último",
        },
      }
    });
  });

</script>

@stop
