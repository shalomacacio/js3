@extends('layouts.relat-layout')

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.1.8/css/fixedHeader.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('/vendor/plugins/daterangepicker/daterangepicker.css') }}">
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
  
        <div class="col-sm-1">
          <h1>Filtros</h1>
        </div>
  
        <div class="col-sm-10">
          <form class="form-inline"  action="{{ route('relatorio.sla') }}"   method="GET">
            @csrf
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
          </form>
        </div>
  
      </div>
    </div><!-- /.container-fluid -->
</section>

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

        <center><h4>RELATÓRIO DE SLA </h4></center>
          
        <div class="row">
            <div class="col-12 table-responsive">
                <div class="col-12">
                    <br>
                    <br>
                    <br>
                    <table id="example" class="table table-striped table-sm  display nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>ATEND</th>
                                <th>CLIENTE</th>
                                <th>INI_ATEND</th>
                                <th>FIM_ATEND</th>
                                <th>TMP_ATEND</th>
                                <th>ATE_ENC</th>
                                <th>OS</th>
                                <th>OS TIPO</th>
                                <th>TECNICO</th>
                                <th>INI_OS</th>
                                <th>OS_FECH_TEC</th>
                                <th>TEMP_FECH_TEC</th>
                                <th>OS_ENC</th>
                                <th>+24</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($atendimentos as $a )
                                <tr>
                                    <td>{{$a->codatendimento}}</td>
                                    <td>{{ Str::limit($a->nome_razaosocial, 40)  }}</td>                                    
                                    <td>{{ \Carbon\Carbon::parse($a->dt_hr_insert)->format('d/m/Y H:i:s') }}</td>
                                    <td> 
                                      @isset($a->dh_fim)
                                        {{ \Carbon\Carbon::parse($a->dh_fim)->format('d/m/Y H:i:s') }}
                                      @endisset 
                                    </td>
                                    <td> {{ \Carbon\Carbon::parse($a->dt_hr_insert)->diffInHours($a->dh_fim )}} </td>
                                    <td>{{$a->finalizado}}</td>
                                    <td>{{$a->codos}}</td>
                                    <td>{{$a->descricao}}</td>
                                    <td>{{$a->usr_nome}}</td>
                                    <td>
                                      @isset($a->abertura)
                                        {{ \Carbon\Carbon::parse($a->abertura)->format('d/m/Y H:i:s') }}</td>
                                      @endisset 
                                    <td>
                                        
                                         {{ $a->fechamento}}
                                       
                                    </td>
                                    <td> {{ \Carbon\Carbon::parse($a->abertura)->diffInHours($a->fechamento)}} </td>
                                    <td>{{$a->encerrado}}</td>
                                    <td>
                                        @if ( \Carbon\Carbon::parse($a->abertura)->diffInHours($a->fechamento ) > 24)
                                            SIM
                                        @else
                                            NÃO
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>ATEND</th>
                                <th>CLIENTE</th>
                                <th>INI_ATEND</th>
                                <th>FIM_ATEND</th>
                                <th>TMP_ATEND</th>
                                <th>ATE_ENC</th>
                                <th>OS</th>
                                <th>OS TIPO</th>
                                <th>TECNICO</th>
                                <th>INI_OS</th>
                                <th>OS_FECH_TEC</th>
                                <th>TEMP_FECH_TEC</th>
                                <th>OS_ENC</th>
                                <th>+24</th>
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
<script src="{{ asset('/vendor/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('/vendor/plugins/daterangepicker/daterangepicker.js') }}"></script>

<script>
    // DATA TABLES FILTERS ETC ...
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

    // DATE RANGER

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

</script>

@endsection