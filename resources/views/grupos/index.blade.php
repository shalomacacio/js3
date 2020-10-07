@extends('layouts.admin')

@section('css')
<link rel="stylesheet" href="{{ asset('/vendor/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css') }}">
@endsection

@section('content')
<div class="content-wrapper">

  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Grupo Serviços</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Configuracoes</a></li>
            <li class="breadcrumb-item active">Grupo Servicos</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

   <!-- Main content -->
   <section class="content">
    <div class="container-fluid">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="card card-primary">
            <div class="card-header">
              <h4 class="card-title">Grupo Serviços</h4>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form  action="{{ route('grupo-servicos.store') }}" method="POST">
              @csrf
              <div class="card-body">
                @include('grupoServicos.form')
              </div>
              <div class="card-footer">
                <button type="submit" class="btn btn-primary">Salvar</button>
              </div>
            </form>
          </div>
          <!-- /.card -->
        </div>
      </div>
    </div>
  </section>
</div>
@endsection

@section('javascript')
<!-- DataTables -->
<script src="{{ asset('/vendor/plugins/datatables/jquery.dataTables.js') }}"></script>
<script src="{{ asset('/vendor/plugins/datatables-bs4/js/dataTables.bootstrap4.js') }}"></script>
<script src="{{ asset('/vendor/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js') }}"></script>

<script>
  $(function () {
    $('.duallistbox').bootstrapDualListbox()
  });
</script>

@stop
