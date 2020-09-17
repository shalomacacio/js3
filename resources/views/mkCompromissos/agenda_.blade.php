@extends('layouts.top-nav')

@section('content')
    <!-- Main content -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <div class="content">
      <div class="container">

        <!-- Content Header (Page header) -->
        <div class="content-header">
          <div class="container">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1 class="m-0 text-dark"> AGENDA <small>3.0</small></h1>
              </div><!-- /.col -->
            </div><!-- /.row -->
          </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
          <div class="container-fluid">
            <!-- /.row -->
            <div class="row">
              @foreach ($mkCompromissos as $comps => $compromissos)
              <div class="col-6">
                <div class="card card-info">
                  <div class="card-header border-transparent">
                  <h3 class="card-title">{{ $comps  }}</h3>

                    <div class="card-tools">
                      <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                      </button>
                      <button type="button" class="btn btn-tool" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                      </button>
                    </div>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body p-0">
                    <div class="table-responsive" style="height: 200px;">
                      <table class="table m-0 table-sm table-head-fixed" >
                        <thead>
                        <tr>
                          <th>Client</th>
                          <th>Bairro</th>
                          <th>Serviço</th>
                          <th>APP</th>
                          <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($compromissos as $compromisso)
                          <tr class="{{  $compromisso->bgColor($compromisso->status) }}">
                            <td title="O.S:{{ $compromisso->os->codos}} Cli: {{ $compromisso->os->usuario->nome_razaosocial}}">
                              <a href="#">{!! \Illuminate\Support\Str::before($compromisso->com_titulo, 'Aberta')  !!}</a>
                            </td>
                            <td title="{{ $compromisso->os->logradouro->logradouro }} {{ $compromisso->os->num_endereco }}">
                              {{ $compromisso->os->logradouro->bairro->bairro }}
                            </td>
                            <td> {!! \Illuminate\Support\Str::after($compromisso->os->osTipo->descricao , ')')  !!} </td>
                            <td><span class="badge badge-success">Shipped</span></td>
                            <td>
                              <div class="sparkbar" data-color="#00a65a" data-height="20">{{ $compromisso->os->status}}</div>
                            </td>
                          </tr>
                        @endforeach
                        </tbody>
                      </table>
                    </div>
                    <!-- /.table-responsive -->
                  </div>
                  <!-- /.card-body -->
                  <div class="card-footer clearfix">
                    <a href="javascript:void(0)" class="btn btn-sm btn-info float-left">Place New Order</a>
                    <a href="javascript:void(0)" class="btn btn-sm btn-secondary float-right">View All Orders</a>
                  </div>
                  <!-- /.card-footer -->
                </div>



              </div>
              @endforeach
            </div>
            <!-- /.row -->
          </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
      </div>
    </div>
  </div>
@endsection
@section('javascript')
<script src="{{ asset('/vendor/adminlte/dist/js/pages/dashboard.js') }}"></script>
@endsection
