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

<section class="content-header">

  <div class="container-fluid">

    <div class="row ">

      <div class="col-sm-2">
        <h1>Filtros</h1>
      </div>

      <div class="col-sm-10">
        <form class="form-inline"  action="{{ route('relatorio.contratos_faturas') }}"   method="GET">
          @csrf

          <div class="col-12 col-sm-12 col-md-2" >
            <!-- select -->
            <div class="form-group">
              <select class="select2bs4"  name="situacao" data-placeholder="-- SITUACAO --" style="width: 100%;">               
                <option disabled selected value=""> -- Situacao -- </option>
                <option value="N"> Ativo </option>
                <option value="S"> Inativo </option>
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
          <center><h4>RELATÓRIO DE CONTRATOS x FATURAS </h4></center>
          <br/>
          <!-- Table row -->


        <div class="col-12">
        <p class="lead"><b>Serviços: {{ $contratos->count() }} </b></p>
        </div>

          <div class="row">
            <div class="col-12 table-responsive">
              <table class="table table-striped table-sm " id="tblData" >
                <thead>
                <tr>
                  <th>Contrato</th>
                  <th>Adesao</th>
                  <th>Ativacao</th>
                  <th>Cliente</th>
                  <th>Vencimento</th>
                  <th>Taxa</th>
                  <th>Parc 1</th>
                  <th>Cancelado</th>
                  <th>Suspenso</th>
                  <th>Dt Cancel</th>
                </tr>
                </thead>
                <tbody>
                @foreach($contratos as $contrato)
                <tr>
                  
                  <td>{{ $contrato->codcontrato }}</td>
                  <td style=" width: 60px ">{{ \Carbon\Carbon::parse($contrato->adesao)->format('d-m-Y') }}</td>
                  <td style=" width: 60px ">{{ \Carbon\Carbon::parse($contrato->data_hora_ativacao)->format('d-m-Y') }}</td>
                  <td>{{ $contrato->cliente }}</td>
                  <td>{{ \Carbon\Carbon::parse($contrato->data_vencimento)->format('d-m-Y') }}</td>
                  <td>
                    @foreach ($contrato->planoContas as $plano)
                     @if ($plano->unidade_financeira === '01.05.06' || $plano->unidade_financeira === '01.05.07' )
                      {{ $plano->valor_lancamento }} 
                     @endif
                    @endforeach
                  </td> 
                  <td>
                    @foreach ($contrato->planoContas as $plano)
                     @if ($plano->parcela_atual === 1 || $plano->unidade_financeira === '01.01.01'   )
                      {{ $plano->valor_lancamento }} / {{ $plano->liquidado }} 
                     @endif
                    @endforeach
                  </td> 
                  
                  <td>{{ $contrato->cancelado }}</td>
                  <td>{{ $contrato->suspenso }}</td>
                  <td>{{ $contrato->dt_cancelamento }}</td>
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
              <a href="javascript:void(0)" onClick="window.print()" class="btn btn-sm btn-default float-right"><i class="fas fa-print"></i> Imprimir</a>
              {{-- <button type="button" class="btn btn-success float-right"><i class="far fa-credit-card" disabled></i> Submit
                Payment
              </button>--}}
              <button type="button" class="btn btn-sm btn-success float-right" style="margin-right: 5px;" onclick = "exportTableToExcel('tblData')">
                <i class="fas fa-download"></i> Exportar XLS
              </button>
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

    function exportTableToExcel(tableID, filename = ''){
    var downloadLink;
    var dataType = 'application/vnd.ms-excel';
    var tableSelect = document.getElementById(tableID);
    var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');

    // Specify file name
    filename = filename?filename+'.xls':'excel_data.xls';
    // Create download link element
    downloadLink = document.createElement("a");

    document.body.appendChild(downloadLink);

    if(navigator.msSaveOrOpenBlob){
        var blob = new Blob(['\ufeff', tableHTML], {
            type: dataType
        });
        navigator.msSaveOrOpenBlob( blob, filename);
    }else{
        // Create a link to the file
        downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
        // Setting the file name
        downloadLink.download = filename;
        //triggering the function
        downloadLink.click();
    }
}

</script>

@stop
