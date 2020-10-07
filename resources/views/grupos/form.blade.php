<div class="form-group">
  <label>Nome do Grupo</label>
  <input type="text" class="form-control" name="nome_grupo" >
</div>

<div class="col-12">
  <div class="form-group">
    <label>Serviços</label>
    <select class="duallistbox" multiple="multiple" name="servico_id[]">
      @foreach ($tipos as $tipo)
      <option value="{{$tipo->codostipo}}"> {{$tipo->descricao}}</option>
      @endforeach
    </select>
  </div>
  <!-- /.form-group -->
</div>
