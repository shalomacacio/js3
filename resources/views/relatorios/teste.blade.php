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
                                <th>Cod</th>
                                <th>Cliente</th>
                                <th>Sexo</th>
                                <th>Idade</th>
                                <th>Endereço</th>
                                <th>Telefone</th>
                                <th>CPF</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>04</td>
                                <td>Fulano</td>
                                <td>M</td>
                                <td>24</td>
                                <td>Rua Juvenilia Mavignier Virgem</td>
                                <td>55 85 987047679</td>
                                <td> 256.256.256.87</td>
                            </tr>
                            <tr>
                                <td>05</td>
                                <td>Fulano</td>
                                <td>M</td>
                                <td>22</td>
                                <td>Rua Juvenilia Mavignier Virgem</td>
                                <td>55 85 987047679</td>
                                <td> 256.256.256.87</td>
                            </tr>
                            <tr>
                                <td>01</td>
                                <td>Fulano</td>
                                <td>M</td>
                                <td>21</td>
                                <td>Rua Juvenilia Mavignier Virgem</td>
                                <td>55 85 987047679</td>
                                <td> 256.256.256.87</td>
                            </tr>
                            <tr>
                                <td>03</td>
                                <td>Fulano</td>
                                <td>M</td>
                                <td>27</td>
                                <td>Rua Juvenilia Mavignier Virgem</td>
                                <td>55 85 987047679</td>
                                <td> 256.256.256.87</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Cod</th>
                                <th>Cliente</th>
                                <th>Sexo</th>
                                <th>Idade</th>
                                <th>Endereço</th>
                                <th>Telefone</th>
                                <th>CPF</th>
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