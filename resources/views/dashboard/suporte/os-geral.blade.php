<section class="col-lg-12 connectedSortable">

            <div class="card">
              <div class="card-header">
                <h5 class="card-title">Ordens de Serviço Agendadas: <b> {{ $os_total }} </b></h5>

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
              <div class="card-body">
                <div class="row">
                  <div class="col-md-8">
                    <p class="text-center">
                      <strong>O.S POR TIPOS</strong>
                    </p>

                    <div class="chart">
                      <!-- Sales Chart Canvas -->
                      {!! $chartTipo->container() !!}
                    </div>
                    <!-- /.chart-responsive -->
                  </div>
                  <!-- /.col -->
                  <div class="col-md-4">
                    <p class="text-center">
                      <strong>O.S POR TÉCNICO</strong>
                    </p>

                    @foreach ($por_tecnico as $tecnico => $os)
                    <div class="progress-group">
                        {{ $tecnico }}
                        <span class="float-right"><b>{{ $os->where('fechamento_tecnico','S')->count() }}</b>/{{ $os->count() }}</span>
                        <div class="progress progress-sm">
                          <div id="progress-bar" class="progress-bar bg-primary" style="width:{{ ($os->where('fechamento_tecnico','S')->count())/($os->count())*100 }}%"></div>
                        </div>
                      </div>
                        
                    @endforeach
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
              </div>
              <!-- ./card-body -->
              {{-- <div class="card-footer">
                <div class="row">
                  <div class="col-sm-3 col-6">
                    <div class="description-block border-right">
                      <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 17%</span>
                      <h5 class="description-header">$35,210.43</h5>
                      <span class="description-text">TOTAL REVENUE</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-3 col-6">
                    <div class="description-block border-right">
                      <span class="description-percentage text-warning"><i class="fas fa-caret-left"></i> 0%</span>
                      <h5 class="description-header">$10,390.90</h5>
                      <span class="description-text">TOTAL COST</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-3 col-6">
                    <div class="description-block border-right">
                      <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 20%</span>
                      <h5 class="description-header">$24,813.53</h5>
                      <span class="description-text">TOTAL PROFIT</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-3 col-6">
                    <div class="description-block">
                      <span class="description-percentage text-danger"><i class="fas fa-caret-down"></i> 18%</span>
                      <h5 class="description-header">1200</h5>
                      <span class="description-text">GOAL COMPLETIONS</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                </div>
                <!-- /.row -->
              </div> --}}
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->
          

</section>

