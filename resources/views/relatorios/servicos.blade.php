@extends('layouts.relat-layout')

@section('css')
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
  </style>
@endsection

@section('content')
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        {{-- <div class="callout callout-info">
          <h5><i class="fas fa-info"></i> Note:</h5>
          This page has been enhanced for printing. Click the print button at the bottom of the invoice to test.
        </div> --}}


        <!-- Main content -->
        <div class="invoice p-3 mb-3">
          <!-- title row -->
          <div class="row">
            <div class="col-12">
              <h4>
                <i class="fas fa-globe"></i> JNET - Telecom
              <small class="float-right">Date: {{ \Carbon\Carbon::now()}}</small>
              </h4>
            </div>
            <!-- /.col -->
          </div>
          <!-- info row -->
          <div class="row invoice-info">
            <div class="col-sm-4 invoice-col">
              Data Inicial
              <address>
                <strong>{{ \Carbon\Carbon::parse($inicio)->format('d/m/Y')}}</strong><br>
              </address>
            </div>
            <!-- /.col -->
            <div class="col-sm-4 invoice-col">
              Data Final
              <address>
                <strong>{{ \Carbon\Carbon::parse($fim)->format('d/m/Y')}}</strong><br>
              </address>
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
          <center><h4>RELATÓRIO DE SERVIÇOS </h4></center>
          <br/>
          <!-- Table row -->


        <div class="col-12">
        <p class="lead"><b>Serviços: </b></p>
        </div>

          <div class="row">
            <div class="col-12 table-responsive">
              <table class="table table-striped table-sm" >
                <thead>
                <tr>
                  <th>Data</th>
                  <th>Cliente</th>
                  <th>Serviço</th>
                  <th>Técnico</th>
                  <th>Consultor</th>
                  <th>Plano</th>
                  <th>Taxa</th>
                  <th>Status</th>
                </tr>
                </thead>
                <tbody>
                @foreach($servicos as $servico)
                <tr>
                <td>{{ $servico->data_fechamento }}</td>
                <td>{{ $servico->cliente }}</td>
                <td>{{ $servico->servico }}</td>
                <td>{{ $servico->tecnico }}</td>
                <td>{{ $servico->consultor }}</td>
                <td>#</td>
                <td>{{ $servico->taxa }}</td>
                <td>{{ $servico->classificacao }}</td>
                </tr>
                @endforeach
                </tbody>
              </table>
            </div>
            <!-- /.col -->
          </div>
          <!-- this row will not appear when printing -->
          <div class="row no-print">
            <div class="col-12">
              <a href="javascript:void(0)" onClick="window.print()" class="btn btn-default float-right"><i class="fas fa-print"></i> Imprimir</a>
              {{-- <button type="button" class="btn btn-success float-right"><i class="far fa-credit-card" disabled></i> Submit
                Payment
              </button>
              <button type="button" class="btn btn-primary float-right" style="margin-right: 5px;">
                <i class="fas fa-download"></i> Generate PDF
              </button> --}}
            </div>
          </div>
        </div>
        <!-- /.invoice -->
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</section>
@endsection

@section('javascript')
<!-- DataTables -->
<script src="{{ asset('/vendor/plugins/datatables/jquery.dataTables.js') }}"></script>
<script src="{{ asset('/vendor/plugins/datatables-bs4/js/dataTables.bootstrap4.js') }}"></script>

<script>
  $(function () {


    // $('#ajaxTable').DataTable( {
    // ajax: {
    //     url: "{{ route('relatorio.servicos') }}",
    //     dataSrc: ''
    // },
    //     columns: [ ... ]
    // });


    // url: "{{ route('suporte.ajaxDashSuporte') }}",
    //     type: "GET",
    //     dataType: 'json',
    //     success: function (data) {


    $(document).ready(function(){
        $('#ajaxTable').DataTable({
            "ajax": '../ajax/data/arrays.txt'
        });
    } );

    // $("#ajaxTable").DataTable({
    //   "paging": false,
    //   "lengthChange": false,
    //   "searching": false,
    //   "ordering": true,
    //   "info": true,
    //   "autoWidth": true,
    //   "language": {
    //     search: "Pesquisar" ,
    //     show: "Mostrar",
    //     info: "Mostrando pag _PAGE_ de _PAGES_",
    //     lengthMenu:    "Mostrar _MENU_ ",
    //     paginate: {
    //         first:      "Primeiro",
    //         previous:   "Anterior",
    //         next:       "Próximo",
    //         last:       "Último",
    //     },
    //   }
    // });

  });

</script>

@stop
