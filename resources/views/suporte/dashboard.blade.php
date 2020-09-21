@extends('layouts.admin')

@section('content')



<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">SUPORTE DASHBOARD</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard v1</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">

        @include('suporte.boxes')

        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
          <section class="col-lg-6 connectedSortable">
            <div class="card card-danger">

              <div class="card-header">
                <h3 class="card-title"> INCIDENTES POR TIPO</h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                </div>
              </div>

              <div class="card-body">
                <canvas id="donutChartType" style="height:160px; min-height:160px"></canvas>
              </div>

            </div>
          </section>
          <!-- /.Left col -->
                    <!-- Left col -->
          <section class="col-lg-6 connectedSortable">
            <div class="card card-danger">

              <div class="card-header">
                <h3 class="card-title"> INCIDENTES POR REGIÃO </h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                </div>
              </div>

              <div class="card-body">
                <canvas id="donutChartRegion" style="height:160px; min-height:160px"></canvas>
              </div>

            </div>
          </section>
          <!-- /.Left col -->
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
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
    var donutChartCanvas = $('#donutChartRegion').get(0).getContext('2d')
    var donutChartCanvas = $('#donutChartType').get(0).getContext('2d')

    setInterval(function(){ bgColor() }, 5000);

    function bgColor(){

      $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });

      $.ajax({
          url: "{{ route('suporte.ajaxDashSuporte') }}",
          type: "GET",
          dataType: 'json',
          success: function (data) {
            console.log('Ok:', data);
          },
          error: function (data) {
              console.log('Error:', data);
          }
      });


      var donutOptions = {
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

      var donutData =  {
          labels: ['teste','teste'],
          datasets: [
            {
              data: [700,500,400],
              backgroundColor : ['#f56954', '#00a65a', '#f39c12'],
            }
          ]
        }

    }

  </script>
@stop
