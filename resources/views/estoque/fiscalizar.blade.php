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

<section class="content-header">
  <div class="container-fluid">
    <div class="row ">

      <div class="col-sm-1">
        <h1>Filtros</h1>
      </div>

      <div class="col-sm-10">
        <form class="form-inline"  action="{{ route('estoque.fiscalizar') }}"   method="GET">
          @csrf

          <div class="col-12 col-sm-12 col-md-2" >
            <!-- select -->
            <div class="form-group">
              <select class="select2bs4"  name="grupos[]" multiple="multiple" data-placeholder="-- GRUPO --" style="width: 100%;">
                @foreach($grupos as $grupo)
                  <option value="{{ $grupo->codagenda_grupo }}"> {{ $grupo->nome }} </option>
                @endforeach
              </select>
            </div>
          </div>

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
                <select class="select2bs4"  name="classificacoes[]" multiple="multiple" data-placeholder="-- CLASSIFICAÇÃO --" style="width: 100%;">
                  @foreach($classificacoes as $classificacao)
                    <option value="{{ $classificacao->codclassifenc }}"> {{ $classificacao->classificacao }} </option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="col-12 col-sm-12 col-md-4" >
              <div class="compensacao"> </div>
              <div class="form-group">
                <div class="input-group input-group-md mb-3">
                  <div class="input-group-prepend">
                    <button id="btn_filter" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                      Selecione
                    </button>
                    <ul class="dropdown-menu">
                      <li class="dropdown-item" id="abertura">Abertura</li>
                      <li class="dropdown-item" id="fechamento">Fechamento</li>
                    </ul>
                  </div>
                  <!-- /btn-group -->
                  <input type="text" class="form-control float-right" id="reservation">
                  <span class="input-group-append">
                    <button type="submit" class="btn btn-info btn-flat">Cuida!</button>
                  </span>
                </div>
              </div>
            </div>

            <input type="hidden" name="dt_inicio" id="dt_inicio">
            <input type="hidden" name="dt_fim" id="dt_fim">
            <input type="hidden" name="dt_filtro" id="dt_filtro">

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
          <center><h4>ORDENS DE SERVIÇO  X ÍTENS </h4></center>
          <br/>
          <!-- Table row -->


        <div class="col-12">
        <p class="lead"><b>Serviços: {{ $servicos->count() }} </b></p>
        </div>

          <div class="row">
            <div class="col-12 table-responsive">
              <table class="table table-striped table-sm " id="tblData" >
                <thead>
                <tr>
                  <th>Fechamento</th>
                  <th>O.S</th>
                  <th>Cliente</th>
                  <th>Serviço</th>
                  <th>Técnico</th>
                  <th>Plano</th>
                  <th>Taxa</th>
                  <th>Status</th>
                  <th>Inativo</th>
                  <th>Aceito</th>
                  <th>Mac</th>
                  <th align="center">Ações</th>
                </tr>
                </thead>
                <tbody>
                @foreach($servicos as $servico)
                <tr>
                  <td style=" width: 60px ">
                    @isset($servico->data_fechamento)
                      {{ \Carbon\Carbon::parse($servico->data_fechamento)->format('d-m-Y') }}
                    @endisset
                  </td>
                  <td>{{ $servico->codos}}</td>
                  <td> 
                    @isset($servico->cliente)
                      {{ $servico->cliente}}
                    @endisset
                  </td>
                  <td>{{ $servico->servico }}</td>
                  <td>{{ $servico->tecnico }}</td>
                  <td>
                    @isset($servico->plano)
                      {{ $servico->plano }} 
                    @endisset
                  </td>
                  <td>{{ $servico->taxa  }}</td>
                  <td>{{ $servico->classificacao }}</td>
                  <td>{{ $servico->inativo }}</td>
                  <td>{{ $servico->aceito  }}</td>
                  <td>{{ $servico->mac  }}</td>
                  <td>
                    @isset($servico->qnt)
                      <a href="javascript:void(0)" onClick="getEstoque({{ $servico->codos }})"  data-toggle="modal" data-target="#modal-estoque" class="btn btn-xs btn-default float-right"><i class="fas fa-warehouse"></i> </a>
                    @endisset
                      <a href="javascript:void(0)" onClick="getCliente({{ $servico->codos }})"  data-toggle="modal" data-target="#modal-cliente" class="btn btn-xs btn-default float-right"><i class="fas fa-user"></i> </a>
                    @if($servico->complementoendereco != null)
                      <a title="{{ $servico->complementoendereco }}" href="https://www.google.com/search?q={{ Str::before( $servico->complementoendereco, '/') }}" target="_blank"  class="btn btn-xs btn-default float-right"><i class="fas fa-map-marker"></i> </a>
                    @endif 
                  </td>
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
@include('estoque.modal-estoque')
@include('estoque.modal-cliente')
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

  // $(document).ready(function() {
  //     var table = $('#tblData').DataTable({
  //       "language": {"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Portuguese-Brasil.json" },
  //       "dom": 'Bfrtip',
  //       "buttons": [ 'copy', 'csv', 'excel', 'pdf', 'print'],
  //       "paging":   false,
  //       "info":     false,
  //       "bFilter": false,
  //       "ordering": true,
  //       "lengthChange": false,
  //     });
  // } );

  $(document).ready(function() {
    $('#tblData').DataTable( {
        dom: 'Bfrtip',
        language: {"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Portuguese-Brasil.json" },
        buttons: ['csv', 'excel', 'pdf', 'print'],
        paging:   false,
        info:     false,
        bFilter: false,
        ordering: false,
        lengthChange: false,
    } );
} );

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

    $('#abertura').click(function(e) {
      $('#btn_filter').text("Abertura");
      $('#dt_filtro').val(0);
    });

    $('#fechamento').click(function(e) {
      $('#btn_filter').text("Fechamento");
      $('#dt_filtro').val(1);
    });

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

  function getEstoque(codigo){

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    function showModal(){
      $('#modal-default').modal('focus')
    }

    function status(tipo){
      var tipo_saida;

      switch (tipo) {
        case 1:
          tipo_saida = "venda"
          break;
        case 2:
          tipo_saida = "comodato"
          break;
        case 3:
          tipo_saida = "emprestimo"
          break;
        case 4:
          tipo_saida = "demo"
          break;
        case 5:
          tipo_saida = "locacao"
          break;
        case 9:
          tipo_saida = "servico"
          break;
        case 101:
          tipo_saida = "imobilizado"
          break;
        case 999:
          tipo_saida = "retirada"
          break;      
        default:
          break;
      }

      return tipo_saida;

    }

    $.ajax({
      url: "{{ route('estoque.ajaxEstoque') }}",
      type: "GET",
      dataType: 'json',
      data: { codos: codigo },
      success: function(data) {
        // console.log(data.result);
        $("#produtos tr").remove();
        for(var i=0; i < data.result.length ; i++)
          {
          $('#produtos').append(
          '<tr>'+
            '<td>'+data.result[i]['descricao_produto']+'</td>'+
            '<td>'+data.result[i]['qnt']+'</td>'+
            '<td>'+data.result[i]['retirada']+'</td>'+
            '<td>'+status(data.result[i]['tipo_saida'])+'</td>'+
          '</tr>');
          }
        }
    });
    
  }

function getCliente(codos){

  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  function showModal(){
    $('#modal-cliente').modal('focus')
  }

  $.ajax({
    url: "{{ route('estoque.ajaxCliente') }}",
    type: "GET",
    dataType: 'json',
    data: { codos: codos },
    success: function(data) {
      console.log(data);
      $("#cliente tr").remove();
      $('#cliente').append('<tr>'+'<td> ENDEREÇO: '+data.endereco.toUpperCase()+'</td>'+'</tr>');
      $('#cliente').append('<tr>'+'<td> STATUS: '+data.status.reply.toUpperCase()+'</td>'+'</tr>');
      }
  });
}

</script>

@stop
