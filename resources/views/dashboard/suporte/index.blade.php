@extends('layouts.dash-layout')

@section('content')

<div class="content-wrapper">
    <br/>
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
            @include('dashboard.suporte.boxes-mini')
          <div class="col-3">
            teste
          </div>
          <div class="col-9">  
            @include('dashboard.suporte.progress-bar')
            {{-- @include('dashboard.suporte.card-user') --}}
          </div>
        </div>
        <div class="row">
          @include('dashboard.suporte.os-geral')
        </div>
      </div>
    </section>
  </div>
  @endsection

  @section('javascript')
  <script src="{{ asset('/vendor/adminlte/dist/js/pages/dashboard.js') }}"></script>
  <script src="{{ asset('/vendor/plugins/treefy/js/bootstrap-treefy.js') }}"></script>
  <!-- Charting library -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>
  <script src=https://cdnjs.cloudflare.com/ajax/libs/echarts/4.0.2/echarts-en.min.js charset=utf-8></script>
  {!! $chartTipo->script() !!}

@stop


