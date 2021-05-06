@extends('layouts.relat-layout')

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.1.8/css/fixedHeader.bootstrap4.min.css">
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

        <center><h4>CONTRATOS X RENOVAÇÕES </h4></center>
        
        <div class="row">
            <div class="col-12 table-responsive">
                <div class="col-12">
                    <br>
                    <br>
                    <br>
                    <table id="example" class="table table-striped table-sm  display nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>COD RENOVACAO </th>
                                <th>CONTRATO</th>
                                <th>CLIENTE</th>
                                <th>TELEFONE</th>
                                <th> VCTO_INI </th> 
                                {{-- <th> VCTO_FINAL </th> --}}
                                {{-- <th> VCTO_FATURA </th> --}}
                                <th> VALOR </th>
                                <th> LIQ </th>
                                <th> STATUS COB </th>
                            </tr>
                        </thead>
                        <tbody>
                          @foreach($renovacoes as $r)
                          <tr>
                            <td>{{ $r->cd_renvoacao_auto }}</td>
                            <td>{{ $r->cd_contrato }}</td>
                            <td>{{ $r->nome_razaosocial }}</td>
                            <td>{{ $r->fone01 }}@isset($r->fone02)|{{ $r->fone02 }}@endisset</td>
                            <td>{{ \Carbon\Carbon::parse($r->inicio)->format('d-m-Y') }}</td>
                            {{-- <td>{{ \Carbon\Carbon::parse($r->vcto_final )->format('d-m-Y') }}</td> --}}
                            {{-- <td>{{ \Carbon\Carbon::parse($r->data_vencimento )->format('d-m-Y') }}</td> --}}
                            <td>{{ $r->vlr_renovacao }}</td>
                            <td>{{ $r->liquidado }}</td>
                            <td title="{{ $r->info_cliente }}">{{ $r->descricao }}</td>
                          </tr>
                          @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>COD RENOVACAO </th>
                                <th>CONTRATO</th>
                                <th>CLIENTE</th>
                                <th>TELEFONE</th>
                                <th> VCTO_INI </th> 
                                {{-- <th> VCTO_FINAL </th> --}}
                                {{-- <th> VCTO_FATURA </th> --}}
                                <th> VALOR </th>
                                <th> LIQ </th>
                                <th> STATUS COB </th>
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
        
    $(document).ready(function() {

        // Setup - add a text input to each footer cell
        $('#example thead tr').clone(true).appendTo( '#example thead' );
        $('#example thead tr:eq(1) th').each( function (i) {
            var title = $(this).text();
            $(this).html( '<input type="text" placeholder="'+title+'" style="width: 100%" />' );
    
            $( 'input', this ).on( 'keyup change', function () {
                if ( table.column(i).search() !== this.value ) {
                    table
                        .column(i)
                        .search( this.value )
                        .draw();
                }
            } );
        });
    
        var table = $('#example').DataTable({
            processing: true,
            lengthChange: false,
            buttons: [ 
                        'excel', 
                        'csvHtml5',
                        {
                            extend: 'pdfHtml5',
                            orientation: 'landscape',
                            pageSize: 'LEGAL'
                        }
                    ],
            paging:   false, //paginação
            info:     true, //mostrando 1 de x paginas 
            bFilter: true, //campo pesquisa 
            ordering: true, // ordenação
            pageLength: 100, //por pagina 
            language: {
                search: "Pesquisar",
                info: "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                paginate: {
                "next": "Próximo",
                "previous": "Anterior",
                "first": "Primeiro",
                "last": "Último"
                },
            }
        });

        table.buttons().container()
        .appendTo( '#example_wrapper .col-md-6:eq(0)' );

    } );
</script>
@endsection