@extends('layouts.agendalayout')

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

          <section class="col-lg-3 connectedSortable">
            <div class="card card-danger">

              <div class="card-header">
                <h3 class="card-title"> SUPORTE</h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                </div>
              </div>

              <div class="card-body">
                <canvas id="donutChart" style="height:160px; min-height:160px"></canvas>
              </div>

            </div>
          </section>

            <!-- /.row -->
            <div class="row">
              @foreach ($mkCompromissos as $comps => $compromissos)

              <section class="col-lg-6 connectedSortable">
                <div class="card card-info">

                  <div class="card-header">
                    <h3 class="card-title">{{ $comps }}</h3>
                    <div class="card-tools">
                      <span data-toggle="tooltip" title="3 New Messages" class="badge bg-primary">{{ $compromissos->count() }}</span>
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
                    <table class="table table-sm  table-head-fixed  ">
                      <thead>
                        <tr>
                          <th  style="width: 200px">CLIENTE</th>
                          <th style="width: 100px">BAIRRO</th>
                          <th >SERVIÇO</th>
                          <th>APP</th>
                          <th>STATUS</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($compromissos as $compromisso)
                        <tr id="{{ $compromisso->codcompromisso }}" >
                          <td title="O.S:{{ $compromisso->os->codos}} Cli: ">
                            <a href="#">{!! \Illuminate\Support\Str::before($compromisso->com_titulo, 'Aberta')  !!}</a>
                          </td>
                          <td title="{{ $compromisso->os->logradouro->logradouro }} {{ $compromisso->os->num_endereco }}">
                            {{ $compromisso->os->logradouro->bairro->bairro }}
                          </td>
                          <td> {!! \Illuminate\Support\Str::after($compromisso->os->osTipo->descricao , ')')  !!} </td>
                          <td> @isset($compromisso->os->ultimo_status_app_mk_tx)<span class="badge {{ $compromisso->os->ultimo_status_app_mk }}"> {{ $compromisso->os->ultimo_status_app_mk_tx }}</span>@endisset</td>
                          <td> @isset($compromisso->os->classEncerramento->classificacao) {{ $compromisso->os->classEncerramento->classificacao }}@endisset  </td>
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
        </section>
        <!-- /.content -->
      </div>
    </div>
  </div>
@endsection
@section('javascript')

<script src="{{ asset('/vendor/adminlte/dist/js/pages/dashboard.js') }}"></script>
<script src="{{ asset('/vendor/plugins/chart.js/Chart.min.js') }}"></script>

<script type="text/javascript">

    //-------------
    //- DONUT CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var donutChartCanvas = $('#donutChart').get(0).getContext('2d')

  setInterval(function(){ bgColor() }, 5000);

  function bgColor(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    $.ajax({
        url: "{{ route('mkCompromissos.agendaStatus') }}",
        type: "GET",
        dataType: 'json',
        success: function (data) {

          donutData = data;
          // console.log('Ok:', donutData);
          console.log('Ok:', data);

          var donutOptions     = {
            maintainAspectRatio : false,
            responsive : true,
          }

          //Create pie or douhnut chart
          // You can switch between pie and douhnut using the method below.
          var donutChart = new Chart(donutChartCanvas, {
            type: 'doughnut',
            data: donutData,
            options: donutOptions
          })
        },
        error: function (data) {
            console.log('Error:', data);
        }
    });

    // var donutData =  {
    //     labels: ['teste','teste'],
    //     datasets: [
    //       {
    //         data: [700,500,400],
    //         backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
    //       }
    //     ]
    //   }




  }







</script>
@endsection
