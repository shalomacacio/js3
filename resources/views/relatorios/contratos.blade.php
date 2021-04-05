@extends('layouts.relat-layout')

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.0/css/buttons.bootstrap4.min.css">
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
              <h4>
                <i class="fas fa-globe"></i> JNET - Telecom
              <small class="float-right">Date: {{ \Carbon\Carbon::now()}}</small>
              </h4>
            </div>
            <!-- /.col -->
        </div>

        <center><h4>NOME DO RELATÓRIO  </h4></center>
          
        <div class="row">
            <div class="col-12 table-responsive">
                <div class="col-12">
                    <br>
                    <br>
                    <br>
                    <table id="tabId" class="table table-striped table-sm  display nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Adesão</th>
                                <th>Cliente</th>
                                <th>Contato</th>
                                <th>Logradouro</th>
                                <th>Bairro</th>
                                <th>Cidade</th>
                                <th>Revenda</th>
                                <th>Unidade</th>
                                <th>Plano</th>
                                <th>Vlr Plano</th>
                                <th>Inativo</th>
                                @if ($request->situacao == "S" )
                                <th>Canc dt</th>
                                <th>Motivo</th> 
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($contratos as $contrato)
                                <tr>
                                <td>{{ $contrato->codcontrato }}</td>
                                <td style=" width: 60px ">{{ \Carbon\Carbon::parse($contrato->adesao)->format('d-m-Y') }}</td>
                                <td>{{ $contrato->nome_razaosocial }}</td>
                                <td>{{ $contrato->fone01 }}  {{ $contrato->fone02 }}</td>
                                <td>{{ $contrato->logradouro }},{{ $contrato->numero }} </td>
                                <td>{{ $contrato->bairro }}</td>
                                <td>{{ $contrato->cidade }}</td>
                                <td>{{ $contrato->revenda }}</td>
                                <td>{{ $contrato->unidade_financeira }}</td>
                                <td>{{ $contrato->plano }}</td>
                                <td align="center">{{ $contrato->vlr_renovacao }}</td>
                                <td align="center">{{ $contrato->inativo }}</td>
                                @if ($request->situacao == "S" )
                                    <td style=" width: 60px ">{{ \Carbon\Carbon::parse( $contrato->dt_cancelamento )->format('d-m-Y') }}</td>
                                    <td>{{ $contrato->motivo }}</td>
                                @endif
                                </tr>
                            @endforeach
        
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Código</th>
                                <th>Adesão</th>
                                <th>Cliente</th>
                                <th>Contato</th>
                                <th>Logradouro</th>
                                <th>Bairro</th>
                                <th>Cidade</th>
                                <th>Revenda</th>
                                <th>Unidade</th>
                                <th>Plano</th>
                                <th>Vlr Plano</th>
                                <th>Inativo</th>
                                @if ($request->situacao == "S" )
                                <th>Canc dt</th>
                                <th>Motivo</th> 
                                @endif
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('javascript')

<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.7.0/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.bootstrap4.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.print.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.colVis.min.js"></script>

<script>
$(document).ready(function(){
    $('#tabId').DataTable({
        dom: 'Bfrtip',
        language: {"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Portuguese-Brasil.json" },
        buttons: ['csv', 'excel', 'pdf', 'print'],
        paging:   false,
        info:     false,
        bFilter: false,
        ordering: true,
        lengthChange: false,

    });
});
</script>
@endsection