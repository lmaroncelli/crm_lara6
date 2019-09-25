<form action="{{ url('clienti') }}" method="get" id="searchForm" accept-charset="utf-8">
    <input type="hidden" name="orderby" id="orderby" value="">
    <input type="hidden" name="order" id="order" value="">
    
    <div class="row p-3">
        <div class="col-md-5">
          <input type="text" name="q" value="{{\Request::get('q')}}" class="form-control" placeholder="Cerca per nome o ID">
        </div>

        <div class="col-md-1">
            <button type="button" class="btn btn-pill btn-success searching">Cerca</button>      
        </div>


        <div class="col-md-3">
          <div class="custom-control custom-switch">
            <input type="checkbox" class="custom-control-input attivo_check"name="attivo" id="attivo" @if ( \Request::get('attivo') ) checked="checked" @endif>
            <label class="custom-control-label" for="attivo">Solo attivi</label>
          </div>
        </div>

        <div class="col-md-3">
          <div class="custom-control custom-switch">
            <input type="checkbox" class="custom-control-input attivo_check"name="attivo_ia" id="attivo_ia" @if ( \Request::get('attivo_ia') ) checked="checked" @endif>
            <label class="custom-control-label" for="attivo_ia">Solo attivi IA</label>
          </div>
        </div>

    </div>

    <div class="row p-3">
        
      <div class="col-md-3">
          <input type="text" name="qf" value="{{\Request::get('qf')}}" class="form-control" placeholder="Cerca nel campo">
      </div>
      <div class="col-md-2">
          <select class="form-control" id="field" name="field">
              @foreach ($campi_cliente_search as $key => $value)
                  <option value="{{$key}}" @if (\Request::get('field') == $key || old('key') == $key ) selected="selected" @endif>{{$value}}</option>
              @endforeach
          </select>
      </div>
      <div class="col-md-1">
          <button type="button" class="btn btn-pill btn-success searching">Cerca</button>      
      </div>

      <div class="col-md-4">
        <input type="text" name="qc" value="{{\Request::get('qc')}}" class="form-control" placeholder="Cerca nei contatti">      
      </div>
      <div class="col-md-1">
          <button type="button" class="btn btn-pill btn-success searching">Cerca</button>      
      </div>
    
    </div>

</form>