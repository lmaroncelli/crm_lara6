<form action="{{ url('localita') }}" method="get" id="searchForm" accept-charset="utf-8">
  <input type="hidden" name="orderby" id="orderby" value="">
  <input type="hidden" name="order" id="order" value="">

  <div class="row p-3">
        
    <div class="col-md-3">
        <input type="text" name="qf" value="{{\Request::get('qf')}}" class="form-control" placeholder="Cerca nel campo">
    </div>
    <div class="col-md-2">
        <select class="form-control m-input" id="field" name="field">
            @foreach (['l' => 'Località', 'c' => 'Comune', 'p' => 'Provincia', 'r' => 'Regione'] as $key => $value)
                <option value="{{$key}}" @if (\Request::get('field') == $key || old('key') == $key ) selected="selected" @endif>{{$value}}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-1">
        <button type="button" class="btn btn-pill btn-success searching">Cerca</button>      
    </div>

  
  </div>
</form>