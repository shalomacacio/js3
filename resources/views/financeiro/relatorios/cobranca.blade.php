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
        .input-cuida{
          margin: 0px 5px 0px 5px
        }
        .card-header {
          padding: .4rem 1.25rem;
        }

    </style>
@endsection

@section('content')
 @include('layouts.admin-partials.alerts')
 <section class="content-header">
    <div class="container-fluid">
      <div class="row ">
        <div class="col-sm-1">
          <h1>Filtros</h1>
        </div>
  
        <div class="col-sm-10">
          <form class="form-inline"  action="{{ route('financeiro.cobranca') }}"   method="GET">
            @csrf

              {{-- 
                <div class="form-group">
                <div class="input-group input-group-md mb-3">
                  <input type="text" class="form-control float-right input-cuida" name="dia" >
                </div>
              </div> 
              --}}

              <div class="col-12 col-sm-12 col-md-4" >
                <div class="compensacao"> </div>
                <div class="form-group">
                  <div class="input-group input-group-md mb-3">
                    <div class="input-group-prepend">
                      <label> Tipo </label>
                    </div>
                    <!-- /btn-group -->
                    <select class="form-group input-cuida"  name="tipo_cobranca">
                      <option value="1" @if( $request->tipo_cobranca == "1" ) selected @endif> Lembrete 48h </option>
                      <option value="2" @if( $request->tipo_cobranca == "2" ) selected @endif> Lembrete diário </option>
                      <option value="3" @if( $request->tipo_cobranca == "3" ) selected @endif> Atraso 5d </option>
                    </select>
                    <span class="input-group-append input-cuida">
                      <button type="submit"  class="btn btn-info btn-flat">Cuida!</button>
                    </span>
                  </div>
                </div>  
              </div>

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

        <center><h4> COBRANÇA  </h4></center>
        
        <div class="row">
            <div class="col-12 table-responsive">
                <div class="col-12">
                    <br>
                    <br>
                    <br>
                    <form action="{{ route('financeiro.cobrancaSMS')}}" method="POST">
                      @csrf
                    <table id="example" class="table table-striped table-sm  display nowrap" style="width:100%">
                        <thead>
                            <tr>
                              <th>TELEFONE</th>
                              <th>CLIENTE</th>
                              <th>VENCIMENTO</th>
                              <th>VALOR</th>
                              <td>SMS</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cobrancas as $cob)
                            <tr>
                              <td> {{ $cob->fone01 }}</td>
                              <td> {{ $cob->nome_razaosocial }}</td>
                              <td> {{  \Carbon\Carbon::parse($cob->data_vencimento)->format('d-m-y') }}</td>
                              <td> {{ $cob->valor_total }}</td>
                              <td><input type="checkbox" name="faturas[]" value="{{ $cob->codfatura }}" checked /></td>
                            </tr>
                            @endforeach
                          
                        </tbody>
                        <tfoot>
                            <tr>
                              <th>TELEFONE</th>
                              <th>CLIENTE</th>
                              <th>VENCIMENTO</th>
                              <th>VALOR</th>
                              <td>SMS</td>_
                            </tr>
                        </tfoot>
                    </table>
                    <input type="hidden" name="tipo" value="{{ $request->tipo_cobranca}}" />
                    <button  class="btn btn-danger btn-flat" onclick="return confirm('Enviar SMS?')">  Enviar SMS!</button> 
                  </form>
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
    $(document).ready(function() {
        // Setup - add a text input to each footer cell
        $('#example tfoot tr').clone(true).appendTo( '#example tfoot' );
        $('#example tfoot tr:eq(1) th').each( function (i) {
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
            buttons: 
                    [ 
                      'excel', 
                      'csvHtml5',
                      {
                        extend: 'pdfHtml5',
                        orientation: 'landscape',
                        pageSize: 'LEGAL'
                      }
                    ],
            paging:   true, //paginação
            info:     true, //mostrando 1 de x paginas 
            bFilter: true, //campo pesquisa 
            ordering: true, // ordenação
            pageLength: 1000, //por pagina 
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

    $('#abertura').click(function(e) {
      $('#btn_filter').text("Abertura");
      $('#dt_filtro').val(0);
    });

    $('#fechamento').click(function(e) {
      $('#btn_filter').text("Fechamento");
      $('#dt_filtro').val(1);
    });

</script>
@endsection