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

@include('mkAtendimentos.filtro')

<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <br>

    <!-- /.row -->
    <div class="row">
      <section class="col-lg-12 connectedSortable">
        <div class="card card-info">


          <!-- /.card-header -->
          <div class="card-body table-responsive p-0" style="height: 500px;">
            <table class="table table-sm  table-head-fixed">
              <thead>
                <tr>
                  <th>COD </th>
                  <th>ABERTURA </th>
                  <th>CLIENTE</th>
                  <th>CIDADE</th>
                  <th>BAIRRO</th>
                  <th>LOGRADOURO</th>
                  <th>CONTATO</th>
                  <th>CELULAR</th>
                  <th>TELEFONE</th>
                  <th>TEL COM</th>
                  <th>PRCESSO</th>
                  <th>SUBPRCESSO</th>
                  <th>CLASSIF</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($atendimentos as $atendimento)
                
                <tr>
                  <td>{{ $atendimento->codatendimento }} </td>
                  <td>{{ \Carbon\Carbon::parse($atendimento->dt_abertura)->format('d-m-Y') }} </td>
                  <td>{{ $atendimento->cliente }} </td>
                  <td>{{ $atendimento->cidade }} </td>
                  <td>{{ $atendimento->bairro }} </td>
                  <td>{{ $atendimento->logradouro }}, {{ $atendimento->numero }}  </td>
                  <td>{{ $atendimento->contato }} </td>
                  <td>{{ $atendimento->fone01 }} </td>
                  <td>{{ $atendimento->fone02 }} </td>
                  <td>{{ $atendimento->fax }} </td>
                  <td>{{ $atendimento->nome_processo }} </td>
                  <td>{{ $atendimento->nome_subprocesso }} </td>
                  <td>{{ $atendimento->classificacao }} </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </section>
    
    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
  {{-- @include('mkCompromissos.modal') --}}
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
