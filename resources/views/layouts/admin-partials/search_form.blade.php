<div class="row">
  <div class="col-md-12 col-sm-12 col-12">
    <div class="callout callout-info">

        <form>
          <div class="row">
            <div class="col-6">
              <div class="pull-right input-group-sm" style="width: 200px;">
                <select class="form-control" name="grupo[]" >
                <option value="">--Selecione--</option>
              </select>
            </div>
            </div>
            <div class="col-6">
              <div class="input-group input-group-sm" style="width: 200px;">
                <input type="date" name="dt_escala" class="form-control" placeholder="Search" @isset($request) value="{{\Carbon\Carbon::parse($request->dt_escala)->format('Y-m-d')}}" @endisset required>
                <div class="input-group-append">
                  <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                </div>
              </div>
            </div>
          </div>
        </form>

    </div>
  </div>
</div>
