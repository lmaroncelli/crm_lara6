
@if ($pagata)
  <form action="{{ route('scadenze.incassate') }}" method="get" id="searchForm" accept-charset="utf-8">
@else  
  <form action="{{ route('scadenze.index') }}" method="get" id="searchForm" accept-charset="utf-8">
@endif

    <input type="hidden" name="orderby" id="orderby" value="">
    <input type="hidden" name="order" id="order" value="">

    <div class="row p-3">
      
      <div class="col-md-4">
        <div class="form-group">
          <select class="form-control" id="field" name="field">
            <optgroup label="Seleziona un campo">
            <option value="0">Campo in cui cercare</option>
            @foreach (['numero_fattura' => 'Num. Fattura', 'importo' => 'Importo', 'note' => 'Note', 'cliente_nome' => 'Hotel'] as $id => $nome)
              @if (\Request::has('field'))
                <option value="{{$id}}" @if ( $id == Request::get('field') )  selected="selected" @endif>{{$nome}}</option>
              @else
                <option value="{{$id}}" @if ( $id == 'note' )  selected="selected" @endif>{{$nome}}</option>
              @endif
            @endforeach
            </optgroup>
          </select>
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <input type="text" name="qf" value="{{ \Request::get('qf') }}" class="form-control" placeholder="Cerca nel campo">
        </div>
      </div>

    </div>

    <div class="row p-3">
      <div class="col-md-3">
        <div class="form-group">
          <label for="name">Pagamento</label>
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
      </div>

      <div class="col-md-2 date">
        <div class="form-group">
          <label for="name">Scadenza dal</label>
          <select class="form-control" id="scadenza_dal" name="scadenza_dal">
            <optgroup label="Seleziona una scadenza">
            <option value="0">Seleziona</option>
            @foreach ($date as $data)
              @if (\Request::has('scadenza_dal'))
                <option value="{{$data}}" @if ( $data == \Request::get('scadenza_dal') )  selected="selected" @endif>{{$data}}</option>
              @else
                <option value="{{$data}}">{{$data}}</option>
              @endif
            @endforeach
            </optgroup>
          </select>
        </div>
      </div>


      <div class="col-md-2 date">
        <div class="form-group">
          <label for="name">Al</label>
          <select class="form-control" id="scadenza_al" name="scadenza_al">
            <optgroup label="Seleziona una scadenza">
            <option value="0">Seleziona</option>
            @foreach ($date as $data)
              @if (\Request::has('scadenza_al'))
                <option value="{{$data}}" @if ( $data == \Request::get('scadenza_al') )  selected="selected" @endif>{{$data}}</option>
              @else
                <option value="{{$data}}">{{$data}}</option>
              @endif
            @endforeach
            </optgroup>
          </select>
        </div>
      </div>
      
      <div class="col-md-3">
        <div class="form-group">
          <label for="name">Commerciale</label>
          <select class="form-control" id="commerciale_id" name="commerciale_id">
            <optgroup label="Seleziona un commerciale">
            <option value="0">Seleziona</option>
            @foreach ($commerciali as $id => $name)
              @if (\Request::has('commerciale_id'))
                <option value="{{$id}}" @if ( $id == Request::get('commerciale_id') )  selected="selected" @endif>{{$name}}</option>
              @else
                <option value="{{$id}}">{{$name}}</option>
              @endif
            @endforeach
            </optgroup>
          </select>
        </div>
      </div>

      <div class="col-md-1" style="margin-top: 30px;">
        <button type="button" class="btn btn-pill btn-success searching">Cerca</button>      
      </div>

    </div>
    

    
</form>
