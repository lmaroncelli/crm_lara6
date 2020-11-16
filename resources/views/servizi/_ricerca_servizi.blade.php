<form action="{{ url('servizi/'.$tipo) }}" method="get" id="searchForm" accept-charset="utf-8">
    <input type="hidden" name="orderby" id="orderby" value="">
    <input type="hidden" name="order" id="order" value="">
    
    <div class="row p-3">
       <div class="col-md-3">
          <div class="custom-control custom-switch">
            <input type="checkbox" class="custom-control-input archiviato_check" name="archiviato" id="archiviato" @if ( \Request::get('archiviato') ) checked="checked" @endif>
            <label class="custom-control-label" for="archiviato">Anche archiviati</label>
          </div>
        </div>
    </div>

    <div class="row p-3">
              
      <div class="col-md-3">
        <select class="form-control m-select2" id="prodotti" multiple name="prodotti[]">
          <option></option>
          <optgroup label="Seleziona i prodotti">
          @foreach ($prodotti as $id => $nome)
            @if (\Request::has('prodotti'))
              <option value="{{$id}}" @if ( in_array($id, \Request::get('prodotti')) ) selected="selected" @endif>{{$nome}}</option>
            @else
              <option value="{{$id}}">{{$nome}}</option>
            @endif
          @endforeach
          </optgroup>
        </select>
      </div>
      
      <div class="col-md-1">
          <input class="form-control" id="inizio" type="text" name="inizio" placeholder="Inizio" value="{{\Request::get('inizio')}}">
      </div>

      <div class="col-md-1">
           <input class="form-control" id="scadenza" type="text" name="scadenza" placeholder="Scadenza" value="{{\Request::get('scadenza')}}">
      </div>

      <div class="col-md-1">
          <button type="button" class="btn btn-pill btn-success searching">Cerca</button>      
      </div>

    
    </div>

    <div class="row p-3">
        
      <div class="col-md-3">
          <input type="text" name="qf" value="{{\Request::get('qf')}}" class="form-control" placeholder="Cerca nel campo">
      </div>
      <div class="col-md-2">
          <select class="form-control m-input" id="field" name="field">
              @foreach ($campi_servizi_search as $key => $value)
                  <option value="{{$key}}" @if (\Request::get('field') == $key || old('key') == $key ) selected="selected" @endif>{{$value}}</option>
              @endforeach
          </select>
      </div>
      <div class="col-md-1">
          <button type="button" class="btn btn-pill btn-success searching">Cerca</button>      
      </div>

    
    </div>

    
</form>