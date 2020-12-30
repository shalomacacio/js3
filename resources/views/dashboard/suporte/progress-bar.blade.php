<div class="col-md-6">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">OS. POR TÉCNICO </h3>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        @foreach ($por_tecnico as $tecnico => $os)
        <div class="progress progress-sm active">
          <div class="progress-bar bg-info progress-bar-striped" role="progressbar"
               aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: {{ ($os->where('fechamento_tecnico','S')->count())/($os->count())*100 }}%">
            <span class="sr-only">20% Complete</span>
          </div>
        </div>
        <p><code>{{ $tecnico }}</code></p>
        @endforeach
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>