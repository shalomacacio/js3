@extends('layouts.relat-layout')

@section('content')

<section class="content-header">

  <div class="container-fluid">

    <div class="row ">

      <div class="col-sm-1">
        <h1>Filtros</h1>
      </div>

      <div class="col-sm-10">
        <form class="form-inline"  action="{{ route('relatorio.slagarantia') }}"   method="GET">
          @csrf
            <div class="col-12 col-sm-12 col-md-4" >
              <div class="compensacao"> </div>
              <div class="form-group">
                <div class="input-group input-group-md mb-3">
                  <label>Período:  </label>
                  <!-- /btn-group -->
                  <input type="date" class="form-control float-right" name="dt_inicio" value="{{ \Carbon\Carbon::parse($request->dt_inicio)->format('Y-m-d') }}">
                  <span class="input-group-append">
                    <button type="submit" class="btn btn-info btn-flat">Cuida!</button>
                  </span>
                </div>
              </div>
            </div>

            {{-- <input type="hidden" name="dt_inicio" id="dt_inicio"> --}}
            <input type="hidden" name="dt_fim" id="dt_fim"> 
        </form>
      </div>

    </div>
  </div><!-- /.container-fluid -->
</section>



  <div class="card">

    <div class="card-header">
      <h3 class="card-title">SLA</h3>
    </div>

    <!-- /.card-header -->
    <div class="card-body p-0">
      <table class="table table-striped">
        <thead>

          <tr>
            <th>COD</th>
            <th>CLIENTE</th>
            <th style="width: 20px">TICKETS</th>
            <th style="width: 15px">VER</th>
            <th style="width: 20px">O.S</th>
            <th style="width: 15px">VER</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($atendimentos as $a )
          <tr>
              <td>{{ $a->codpessoa }}</td>
              <td>{{ Str::limit($a->nome_razaosocial, 40) }}</td>   
              <td><center>{{ $a->tickets }}</center></td>
              <td style="text-align: center; !important"><a href="javascript:void(0)" onClick="getClientAte( '{{ $a->codpessoa}}', '{{ $inicio}}' )"  data-toggle="modal" data-target="#modal" class="btn btn-xs btn-default float-right"><i class="fas fa-list"></i> </a> </td>
              {{-- <td> # </td> --}}
              <td><center>{{ $a->os }}</center></td>       
              <td><a href="javascript:void(0)" onClick="getClientOs( '{{ $a->codpessoa}}', '{{ $inicio}}' )"  data-toggle="modal" data-target="#modal" class="btn btn-xs btn-default float-right"><i class="fas fa-list"></i> </a> </td>
          </tr>
      @endforeach
        </tbody>
      </table>
    </div>
    <!-- /.card-body -->
  </div>
@endsection
@include('relatorios.modal')



<script>
  //
  function showModal(){
    $('#modal-cliente').modal('focus')
  }

  
    //CONFIGURANÇÃO TOKEN PARA USO DO AJAX 
    $.ajaxSetup({
          headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

  // POPUP OS POR CLIENTE
    function getClientOs(cliente){
      $.ajax({
        url: "{{ route('relatorio.ajaxClientOs') }}",
        type: "GET",
        dataType: 'json',
        data: { 
          cliente: cliente , 
          inicio: "{{ $inicio }}",
          fim: "{{ $fim }}"
        },
        success: function(data) {
          // console.log(result.result[0]);
          $("#ostable tr").remove();
          $('#ostable').append('<tr><th>COD</th><th>ABERTURA</th><th>TIPO</th><th>FECHAMENTO</th><th>CLASS_ENC</th></tr>');
        for(var i=0; i < data.result.length ; i++)
          {
          $('#ostable').append(
          '<tr>'+
            '<td>'+data.result[i]['codos']+'</td>'+
            '<td>'+data.result[i]['abertura']+'</td>'+
            '<td>'+data.result[i]['tipo']+'</td>'+
            '<td>'+data.result[i]['data_fechamento']+'</td>'+
            '<td>'+data.result[i]['class_enc']+'</td>'+
          '</tr>');
          }
          }
      });
    }

    // POPUP OS POR CLIENTE
    function getClientAte(cliente){
      $.ajax({
          url: "{{ route('relatorio.ajaxClientAte') }}",
          type: "GET",
          dataType: 'json',
          data: { 
            cliente: cliente , 
            inicio: "{{ $inicio }}",
            fim: "{{ $fim }}"
          },
          success: function(data) {
            // console.log(result.result[0]);
            $("#ostable tr").remove();
            $('#ostable').append('<tr><th>COD</th><th>ABERTURA</th><th>CLASSIFICACAOS</th><th>PROCESSO</th><th>FECHAMENTO</th><th>CLASS_ENC</th></tr>');
          for(var i=0; i < data.result.length ; i++)
            {
            $('#ostable').append(
            '<tr>'+
              '<td>'+data.result[i]['codatendimento']+'</td>'+
              '<td>'+data.result[i]['dt_abertura']+'</td>'+
              '<td>'+data.result[i]['descricao']+'</td>'+
              '<td>'+data.result[i]['nome_processo']+'</td>'+
              '<td>'+data.result[i]['dt_finaliza']+'</td>'+
              '<td>'+data.result[i]['classifenc']+'</td>'+
            '</tr>');
            }
          }
      });
    }
</script>