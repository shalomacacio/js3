<!-- Small boxes (Stat box) -->
<section class="col-lg-6 connectedSortable">

  <!-- Widget: user widget style 1 -->
  <div class="card card-widget widget-user">
    <!-- Add the bg color to the header using any of the bg-* classes -->
    <div class="widget-user-header bg-info">
      <h1 class="widget-user-username "><b> {{ $atend_total }} </b></h1>
      <h6 class="widget-user-desc">ATENDIMENTOS ABERTOS  </h6>
    </div>
    <div class="widget-user-image">
      <img class="img-circle elevation-2" src="{{ asset('vendor/adminlte/dist/img/sup_logo.png') }}" alt="User Avatar">
    </div>
    <div class="card-footer">
      <div class="row">
        <div class="col-sm-6 border-right">
          <div class="description-block">
            <h5 class="description-header">{{ $nv1_total }}</h5>
            <span class="description-text">Suporte NV1 </span>
          </div>
          <!-- /.description-block -->
        </div>
        <!-- /.col -->
        <div class="col-sm-6 border-right">
          <div class="description-block">
            <h5 class="description-header">{{ $nv2_total }}</h5>
            <span class="description-text">Suporte NV2 </span>
          </div>
          <!-- /.description-block -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
  </div>
  <!-- /.widget-user -->


</section>