@section('form-searc')

<form class="form-inline ml-0 ml-md-3" action="{{ route('mkCompromissos.agenda') }}" method="GET">
  @csrf
  <div class="input-group input-group-sm">
  <input class="form-control form-control-navbar" type="date" name="dt_agenda" value="{{\Carbon\Carbon::parse($inicio)->format('Y-m-d')}}">
    <div class="input-group-append">
      <button class="btn btn-navbar" type="submit">
        <i class="fas fa-search"></i>
      </button>
    </div>
  </div>
</form>

@endsection
