<form action="{{ url('servizi') }}" method="get" id="searchForm" accept-charset="utf-8">
    <input type="hidden" name="orderby" id="orderby" value="">
    <input type="hidden" name="order" id="order" value="">
    
    <div class="row p-3">
        
      <label class="col-md-1 text-change" for="prodotti">Prodotti:</label>
      
      <div class="col-md-3">
        <select class="form-control m-select2" id="prodotti" multiple name="prodotti[]">
          <option></option>
          <optgroup label="Seleziona i prodotti">
          @foreach ($prodotti as $id => $nome)
            <option value="{{$id}}">{{$nome}}</option>
          @endforeach
          </optgroup>
        </select>
      </div>
      
      <div class="col-md-2">
          
      </div>

      <div class="col-md-1">
          <button type="button" class="btn btn-pill btn-success searching">Cerca</button>      
      </div>

    
    </div>

    
</form>