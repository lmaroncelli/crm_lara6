<form action="{{ url('scadenze/') }}" method="get" id="searchForm" accept-charset="utf-8">
    <input type="hidden" name="orderby" id="orderby" value="">
    <input type="hidden" name="order" id="order" value="">
    
    
    <div class="row p-3">
              
      <div class="col-md-3">
        <select class="form-control" id="pagamento" name="pagamento">
          <optgroup label="Seleziona un pagamento">
          <option value="0">Seleziona</option>
          @foreach ($pagamenti_fattura as $id => $nome)
            @if (\Request::has('pagamento'))
              <option value="{{$id}}" @if ( $id == Request::get('pagamento') )  selected="selected" @endif>{{$nome}}</option>
            @else
              <option value="{{$id}}">{{$nome}}</option>
            @endif
          @endforeach
          </optgroup>
        </select>
      </div>
      <div class="col-md-1" style="margin-top: 8px;">
        <label>che scadono al</label>
      </div>
      <div class="col-md-3 date">
        <select class="form-control" id="data_scadenza" name="data_scadenza">
          <optgroup label="Seleziona una scadenza">
          <option value="0">Seleziona</option>
          @foreach ($date as $data)
            @if (\Request::has('data_scadenza'))
              <option value="{{$data}}" @if ( $data == \Request::get('data_scadenza') )  selected="selected" @endif>{{$data}}</option>
            @else
              <option value="{{$data}}">{{$data}}</option>
            @endif
          @endforeach
          </optgroup>
        </select>
      </div>
      
      <div class="col-md-1">
          <button type="button" class="btn btn-pill btn-success searching">Cerca</button>      
      </div>

    
    </div>

    

    
</form>
