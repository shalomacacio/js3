@extends('layouts.relat-layout')

@section('css')
<link rel="stylesheet" href="{{ asset('/vendor/plugins/daterangepicker/daterangepicker.css') }}">
<link rel="stylesheet" href="{{ asset('/vendor/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('/vendor/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

<style>
    td {
      font-size: 8px;
      padding: .1rem 0.25rem !important;
    }
    th {
      font-size: 11px;
      padding: .1rem 0.25rem !important;
    }
    .card-header {
      padding: .1rem 0.25rem !important;
    }
    .card-title {
      font-size: 12px !important; 
      padding: .3rem .25rem;
    }
    .compensacao {
      margin-top: 15px;
    }
  </style>
@endsection

@section('content')

@include('mkCompromissos.filtro')

<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <!-- /.row -->
    <div class="row">
      @foreach ($mkCompromissos as $comps => $compromissos)

      <section class="col-lg-6 connectedSortable">
        <div class="card card-info">

          <div class="card-header">
            <h3 class="card-title">{{ $comps }}</h3>
            <div class="card-tools">
              <span data-toggle="tooltip" title="3 New Messages" class="badge bg-primary">{{ $compromissos->whereNotNull('dt_hr_fechamento_tec')->count() }}/{{ $compromissos->count() }}</span>
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
              <button type="button" class="btn btn-tool" data-card-widget="remove">
                <i class="fas fa-times"></i>
              </button>
            </div>
          </div>

          <!-- /.card-header -->
          <div class="card-body table-responsive p-0" style="height: 200px;">
            <table class="table table-sm  table-head-fixed">
              <thead>
                <tr>
                  <th>HORA</th>
                  <th>CLIENTE</th>
                  <th>BAIRRO</th>
                  <th>SERVIÇO</th>
                  <th> MOBILE</th>
                  <th>CLASSIF</th>
                  {{-- <th>ONLINE</th> --}}
                  <th>AÇÕES</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($compromissos as $compromisso)
                
                <tr>
                  <td>{{ \Carbon\Carbon::parse($compromisso->com_inicio)->format('H:i')}}-{{ \Carbon\Carbon::parse($compromisso->com_fim)->format('H:i')}}</td>
                  <td>{{ $compromisso->nomeCli}}</td>
                  <td>{{ $compromisso->bairro}}</td>
                  <td>{{ $compromisso->descricao}}</td>
                  <td>{{ $compromisso->status }}</td>
                  <td>{{ $compromisso->classificacao }}</td>
                  <td>{{ $compromisso->codTec }}</td>
                </tr>

                @endforeach
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </section>
      @endforeach
    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
  @include('mkCompromissos.modal')
  @include('mkCompromissos.modalGeogrid')
</section>
<!-- /.content -->

@endsection

@section('javascript')
<!-- DataTables -->
<script src="{{ asset('/vendor/plugins/jquery/jquery.min.js') }}"></script>

<script src="{{ asset('/vendor/plugins/datatables-bs4/js/dataTables.bootstrap4.js') }}"></script>
<script src="{{ asset('/vendor/plugins/select2/js/select2.full.min.js') }}"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment-with-locales.min.js"></script>

<script>
  //atualiza página a cada 1min 
  setInterval(function(){  window.location.reload(); }, 120000);

  //Initialize Select2 Elements
  $('.select2').select2()

  //Initialize Select2 Elements
  $('.select2bs4').select2({
    theme: 'bootstrap4'
  })

function getEstoque(codigo){

  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  function showModal(){
    $('#modal-default').modal('focus')
  }

  function showModal(){
    $('#myModal').modal('focus')
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

</script>

@stop
