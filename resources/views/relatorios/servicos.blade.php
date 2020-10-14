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
  </style>
@endsection

@section('content')

@include('relatorios.filtros')

<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
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
        <p class="lead"><b>Serviços: {{ $servicos->count() }} </b></p>
        </div>

          <div class="row">
            <div class="col-12 table-responsive">
              <table class="table table-striped table-sm" >
                <thead>
                <tr>
                  <th>O.S</th>
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
                  <td>{{ $servico->codos}}</td>
                  <td style=" width: 60px ">{{ \Carbon\Carbon::parse($servico->data_fechamento)->format('d-m-Y') }}</td>
                  <td>{{ $servico->cliente }}</td>
                  <td>{{ $servico->servico }}</td>
                  <td>{{ $servico->tecnico }}</td>
                  <td>{{ $servico->consultor }}</td>
                  <td>{{ $servico->plano }}</td>
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
<script src="{{ asset('/vendor/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('/vendor/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('/vendor/plugins/datatables/jquery.dataTables.js') }}"></script>
<script src="{{ asset('/vendor/plugins/datatables-bs4/js/dataTables.bootstrap4.js') }}"></script>
<script src="{{ asset('/vendor/plugins/daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('/vendor/plugins/select2/js/select2.full.min.js') }}"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment-with-locales.min.js"></script>

<script>

  $(function() {
  moment.locale('pt-br');
  $('#reservation').daterangepicker({
    opens: 'right',
    locale: {
      "applyLabel": "Aplicar",
      "daysOfWeek": [
        "Dom",
        "Seg",
        "Ter",
        "Qua",
        "Jue",
        "Vie",
        "Sáb"
    ],
    "monthNames": [
        "Janeiro",
        "Fevereiro",
        "Março",
        "Abril",
        "Maio",
        "Junho",
        "Julho",
        "Agosto",
        "Setembro",
        "Outubro",
        "Novembro",
        "Decembro"
    ],
    },
  },
   function(start, end, label) {
    // console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
    $('#dt_inicio').val( start.format('YYYY-MM-DD'));
    $('#dt_fim').val( end.format('YYYY-MM-DD'));
  });
});


    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })

</script>

@stop
