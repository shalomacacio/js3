@extends('layouts.relat-layout')

@section('css')
<link rel="stylesheet" href="{{ asset('/vendor/plugins/daterangepicker/daterangepicker.css') }}">
<link rel="stylesheet" href="{{ asset('/vendor/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('/vendor/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

{{-- 
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
--}}
@endsection

@section('content')

<section class="content-header">

  <div class="container-fluid">

    <div class="row ">

      <div class="col-sm-2">
        <h1>Filtros</h1>
      </div>

      <div class="col-sm-10">
        <form class="form-inline"  action="{{ route('relatorio.inadimplencias') }}"   method="GET">
          @csrf

          {{-- <div class="col-12 col-sm-12 col-md-2" >
            <!-- select -->
            <div class="form-group">
              <select class="select2bs4"  name="processos[]" multiple="multiple" data-placeholder="-- PROCESSOS --" style="width: 100%;">

              </select>
            </div>
          </div> --}}

          {{-- <div class="col-12 col-sm-12 col-md-2" >
            <!-- select -->
            <div class="form-group">
              <select class="select2bs4"  name="subprocessos[]" multiple="multiple" data-placeholder="-- SUBPROCESSOS --" style="width: 100%;">

              </select>
            </div>
          </div> --}}

            {{-- <div class="col-12 col-sm-12 col-md-2" >
              <!-- select -->
              <div class="form-group">
                <select class="select2bs4"  name="classificacaos[]" multiple="multiple" data-placeholder="-- CLASSIFICAÇÃO --" style="width: 100%;">

                </select>
              </div>
            </div> --}}

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

            <div class="col-12 col-sm-12 col-md-3" >
              <div class="form-group">
                <div class="input-group input-group-sm">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="far fa-calendar-alt"></i>
                    </span>
                  </div>
                  {{-- <input type="text" class="form-control float-right" id="reservation"> --}}
                  <input type="number" name="dia">
                  <span class="input-group-append">
                    <button type="submit" class="btn btn-info btn-flat">Cuida!</button>
                  </span>
                </div>
              </div>
            </div>

            {{-- <input type="hidden" name="dt_inicio" id="dt_inicio">
            <input type="hidden" name="dt_fim" id="dt_fim"> --}}

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
                <strong>{{ \Carbon\Carbon::now()->format('d/m/Y')}}</strong><br>
              </address>
            </div>
            <!-- /.col -->
            <div class="col-sm-4 invoice-col">
              Data Final
              <address>
                <strong>{{ \Carbon\Carbon::now()->format('d/m/Y')}}</strong><br>
              </address>
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
          <center><h4>RELATÓRIO DE INADIMPLÊNCIAS </h4></center>
          <br/>
          <!-- Table row -->


        <div class="col-12">
        <p class="lead"><b>Faturas <div id="total"> </div> </b></p>
        </div>

          <div class="row">
            <div class="col-12 table-responsive">
              <table class="table table-striped table-sm" >
                <thead>
                  <tr>
                    <th style="width: 300px">TELEFONE</th>
                    <th style="width: 1000px">CLIENTE</th>
                    <th>VENCIMENTO</th>
                    <th>DIAS</th>
                    <th>VALOR</th>
                  </tr>
                  </thead>
              </table>
              <table class="table table-striped table-sm " id="tblData" >
                <tbody>
                @foreach($inadimplencias as $inad)
                <tr>
                  @if ( \Carbon\Carbon::parse($inad->data_vencimento)->diffInDays(\Carbon\Carbon::now()->format('d-m-Y')) >= $dia)
                  <td>{{ $inad->fone01 }}@isset ($inad->fone02) ;{{ $inad->fone02 }} @endisset</td>
                  <td>{{ $inad->nome_razaosocial }}</td>
                  <td>{{ \Carbon\Carbon::parse($inad->data_vencimento)->format('d/m/Y') }}</td>
                  <td>{{ \Carbon\Carbon::parse($inad->data_vencimento)->diffInDays(\Carbon\Carbon::now()->format('d-m-Y')) }}</td>
                  <td> {{  number_format($inad->valor_total , 2, ',', '.') }}</td>
                  @endif
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

    // A $( document ).ready() block.
    $( document ).ready(function() {
      var rowCount = $('#tblData >tbody >tr').length;
      alert("Total :" + rowCount);
    });

</script>

@stop
