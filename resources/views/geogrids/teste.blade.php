@extends('layouts.relat-layout')

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.1.8/css/fixedHeader.bootstrap4.min.css">
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
                    <table id="example" class="table table-striped table-sm  display nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <td>codigo</td>
                                <td>sigla</td>
                                <td>descricao</td>
                                <td>tipo</td>
                                <td>id_tipo</td>
                                <td>valor</td>
                                <td>local_de_uso</td>
                                <td>ip</td>
                                <td>obs</td>
                                <td>label</td>
                                <td>hash_qrcode</td>
                                <td>data_editado</td>
                                <td>tipo_atendimento</td>
                                <td>divisor</td>
                                <td>saidas</td>
                                <td>entradas</td>
                                <td>id_integracao</td>
                                <td>agrupar_portas_tipo</td>
                                <td>modo_projeto</td>
                                <td>instalado_em</td>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- {{ $equipamentos }} --}}
                            @foreach ($equipamentos as $equip )
                                <tr>
                                    <td>{{ $equip->codigo }}</td>
                                    <td>{{ $equip->sigla }}</td>
                                    <td>{{ $equip->descricao }}</td>
                                    <td>@foreach ($equip->tipo as $tipo) {{$tipo }}  @endforeach</td>
                                    <td>{{ $equip->id_tipo }}</td>
                                    <td>{{ $equip->valor }}</td>
                                    <td>{{ $equip->local_de_uso}}</td>
                                    <td>{{ $equip->ip}}</td>
                                    <td>{{ $equip->obs}}</td>
                                    <td>{{ $equip->label}}</td>
                                    <td>{{ $equip->hash_qrcode}}</td>
                                    <td>{{ $equip->data_editado}}</td>
                                    <td>{{ $equip->tipo_atendimento}}</td>
                                    <td>{{ $equip->divisor}}</td>
                                    <td>{{ $equip->saidas}}</td>
                                    <td>{{ $equip->entradas}}</td>
                                    <td>{{ $equip->id_integracao}}</td>
                                    <td>{{ $equip->agrupar_portas_tipo}}</td>
                                    <td>{{ $equip->modo_projeto}}</td>
                                    <td>@foreach ($equip->instalado_em as $dt_inst) {{$dt_inst }}  @endforeach</td>
                                    
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td>codigo</td>
                                <td>sigla</td>
                                <td>descricao</td>
                                <td>tipo</td>
                                <td>id_tipo</td>
                                <td>valor</td>
                                <td>local_de_uso</td>
                                <td>ip</td>
                                <td>obs</td>
                                <td>label</td>
                                <td>hash_qrcode</td>
                                <td>data_editado</td>
                                <td>tipo_atendimento</td>
                                <td>divisor</td>
                                <td>saidas</td>
                                <td>entradas</td>
                                <td>id_integracao</td>
                                <td>agrupar_portas_tipo</td>
                                <td>modo_projeto</td>
                                <td>instalado_em</td>
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
            $(this).html( '<input type="text" style="width: 100%"/>' );
    
            $( 'input', this ).on( 'keyup change', function () {
                if ( table.column(i).search() !== this.value ) {
                    table
                        .column(i)
                        .search( this.value )
                        .draw();
                }
            } );
        });
    
        var table = $('#example').DataTable( {
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
                "next</td>": "Próximo",
                "previous</td>": "Anterior",
                "first</td>": "Primeiro",
                "last</td>": "Último"
                },
            }
        });

        table.buttons().container()
        .appendTo( '#example_wrapper .col-md-6:eq(0)' );
    } );
</script>
@endsection