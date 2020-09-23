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
              <li class="breadcrumb-item"><a href='#">Home'></a></li>
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
                <h3 class="card-title"> INCIDENTES POR REGIÃO</h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                </div>
              </div>

              <div class="card-body">
                <canvas id="donutChartRegion" style="height:160px; min-height:360px"></canvas>
              </div>

            </div>
          </section>
          <!-- /.Left col -->
          <!-- Left col -->
          <section class="col-lg-6 connectedSortable">
            <div class="card card-info">

              <div class="card-header">
                <h3 class="card-title"> INCIDENTES POR TÉCNICO </h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                </div>
              </div>

              <div class="card-body" id="cardProgress">

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
  <script src="{{ asset('/vendor/plugins/chart.js/DadosChart.js') }}"></script>
  <script type="text/javascript">

    bgColor();
    setInterval(function(){ bgColor() }, 60000);

    //-------------
    //- DONUT CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var donutChartCanvas = $('#donutChartRegion').get(0).getContext('2d')

    function bgColor(){

      var bairros = [];
      var dados   = [];

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
          // console.log('Ok:', data);
          // console.log(Object.keys(data.bairros));
          $('#pendentes').text(data.pendentes);
          $('#agendados').text(data.agendados);
          $('#concluidos').text(data.concluidos);
          bairros = Object.keys(data.bairros);
          dados = Object.values(data.bairros);

          $('#cardProgress').empty();
          $.each(data.tecnicos, function(index, value) {
            $('#cardProgress').append(
              "<div class='progress-group'>"
                +index
                +"<span class='float-right'>"+value+"</span>"
                +"<div class='progress progress-sm'>"
                +"<div class='progress-bar bg-primary' style='width: 100%'></div>"
                +"</div>"
                +"</div>"
            )
          });

          cores = ['#32B990','#f56954','#00a65a','#f39c12', '#3276B5','#373435','#A9ABAE','#96C35C','#33A7D8','#F9AC27',
          '#8869AD','#D94A59','#E966AC','#5da8ae','#e7c602','#e7b40d','#89a3dc','#da7c0a','#693f29','#ab9b46'];

          var donutOptions = {
            maintainAspectRatio : false,
            responsive : true,
            }

          var donutData =  {
            labels: bairros,
            datasets: [
              {
                data:dados ,
                backgroundColor : cores,
              }
            ]
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
    }
  </script>
@stop


