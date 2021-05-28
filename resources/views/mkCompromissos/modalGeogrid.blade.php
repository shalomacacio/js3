
      <div class="modal fade" id="myModal">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Geogrid</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">

              <form action="{{ route('geogrid.reservar')}}" method="POST">
                @csrf
              
                <select class="select2bs4"  name="codigo" multiple="multiple" data-placeholder="-- PROJETOS --" style="width: 100%;">
                  @foreach($equipamentos as $e)
                    <option value="{{ $e->codigo }}"> {{ $e->sigla }} </option>
                  @endforeach
                </select>

                <input type="text"  class="form-control" name="cliente" style="width: 100%;" />
                
                <select class="select2bs4"  name="porta"  style="width: 100%;">
                  @for ($i=1; $i<=16; $i++ )
                  <option value={{$i}}> {{$i}} </option>
                  @endfor
                </select>

                
                  <button type="submit" class="btn btn-info btn-flat">Cuida!</button>
                
              </form>

            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->