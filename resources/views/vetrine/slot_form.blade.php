@extends('layouts.coreui.crm_lara6')

@section('content')
<div class="row">
  <div class="col">
    

    @if (!$slot->exists)
      <form action="{{route('slot.store', $vetrina->id)}}" method="post" enctype="multipart/form-data">
    @else
      <form action="{{route('slot.update',$slot->id)}}" method="post" enctype="multipart/form-data">
    @endif
      @csrf

      <div class="form-group row">
        <label class="col-md-2 text-change" for="cliente_id">Cliente:</label>
        <div class="col-md-6">
            <select class="form-control" id="cliente_id" name="cliente_id">
              @foreach ($clienti_select as $cliente_id => $nome)
                <option value="{{$cliente_id}}" @if (old('cliente_id') == $cliente_id ) selected="selected" @elseif($slot->exists && $slot->cliente_id == $cliente_id) selected="selected" @endif>{{$nome}}</option>
              @endforeach
            </select>
        </div>
      </div>

      <div class="form-group row">
        <label class="col-md-2 text-change" for="data_disattivazione">Scadenza:</label>
        <div class="col-xl-2">
          <div class="input-group date">
              <input type="text" name="data_disattivazione" class="form-control" readonly value="{{ old('data_disattivazione') != '' ?  old('data_disattivazione') :  $slot->exists ? $slot->data_disattivazione->format('d/m/Y') : ''}}" id="data_disattivazione" />
              <div class="input-group-append">
                  <span class="input-group-text">
                      <i class="fa fa-calendar"></i>
                  </span>
              </div>
          </div>
        </div>
      </div>

      <button type="submit" class="btn btn-primary offset-md-2 mt-3 mb-4">
      @if (!$slot->exists) Salva @else Modifica @endif
      </button>
      <a href="{{ route('slot.index', $vetrina->id) }}  " class="btn btn-success offset-md-2 mt-3 mb-4">Annulla</a>
        
      
    </form>
    
  </div>
</div>
@endsection

@section('js')

<script type="text/javascript" charset="utf-8">
  jQuery(document).ready(function(){

            $('#data_disattivazione').datepicker({
                format: 'dd/mm/yyyy',
                clearBtn:true,
                todayBtn:'linked',
            });
 
  });
</script>

@endsection