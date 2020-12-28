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
          <center><h4>FISCALIZAR ESTOQUE </h4></center>
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
                  <th>Abertura</th>
                  <th>Fechamento</th>
                  <th>O.S</th>
                  <th>Cliente</th>
                  <th>Serviço</th>
                  <th>Técnico</th>
                  <th>Consultor</th>
                  <th>Plano</th>
                  <th>Taxa</th>
                  <th>Status</th>
                  <th>Inativo</th>
                  <th><center>Estoque</center></th>
                </tr>
                </thead>
                <tbody>
                @foreach($servicos as $servico)
                <tr>
                  <td style=" width: 60px ">{{ \Carbon\Carbon::parse($servico->data_abertura)->format('d-m-Y') }}</td>
                  <td style=" width: 60px ">
                    @isset($servico->data_fechamento)
                      {{ \Carbon\Carbon::parse($servico->data_fechamento)->format('d-m-Y') }}
                    @endisset
                  </td>
                  <td>{{ $servico->codos}}</td>
                  <td>{{ $servico->cliente }}</td>
                  <td>{{ $servico->servico }}</td>
                  <td>{{ $servico->tecnico }}</td>
                  <td>{{ $servico->consultor }}</td>
                  <td>{{ $servico->plano }}</td>
                  <td>{{ $servico->taxa }}</td>
                  <td>{{ $servico->classificacao }}</td>
                  <td>{{ $servico->inativo }}</td>
                  <td align="center">
                    @isset($servico->qnt)
                    <a href="javascript:void(0)" onClick="getEstoque({{ $servico->codos }})"  data-toggle="modal" data-target="#modal-default" class="btn btn-xs btn-default float-right"><i class="fas fa-warehouse"></i> </a>
                    @endisset
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
@include('estoque.modal')
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

$(document).ready(function() {
    $('#tblData').DataTable({
      "language": {
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Portuguese-Brasil.json"
        }
    });
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
          '</tr>');
          }
        }
    });
    
  }

</script>

@stop
