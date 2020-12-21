<div class="row p-3">
        
  <div class="col-md-4">
      <label for="localita" class="col-form-label"><b>Per accedere alle evidenze selezionare la località del cliente</b></label>
  </div>
  <div class="col-md-3">
      <select class="form-control" id="localita_select" name="localita">
          @foreach (['0' => 'Seleziona'] + $localita_cliente_select as $id => $nome)
              <option value="{{$id}}">{{$nome}}</option>
          @endforeach
      </select>
  </div>

</div>