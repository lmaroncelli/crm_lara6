@extends('layouts.coreui.crm_lara6')


@section('js')
	<script type="text/javascript" charset="utf-8">
		
	

		jQuery(document).ready(function(){


        $("#form_contratto_digitale").submit(function(){
        
              if($('#id_commerciale').val() == 0) {
                 alert('Seleziona il commerciale');
                  return false; 
              }
        });

		});
	

	</script>
	
@endsection

@section('content')
<div class="spinner_lu" style="display:none;"></div>
<form action="{{ route('contratto-digitale.update',$contratto->id) }}" method="post" id="form_contratto_digitale">
  @csrf
  @method('PUT')
  <div class="row mt-2 row justify-content-between">
      <div class="col-lg-5">
      <div class="card card-accent-primary text-center">
          <div class="card-header">CONTRATTO FORNITURA SERVIZI</div>
          <div class="card-body">
              <div class="form-group">
                <label for="id_commerciale">Nome Agente</label>
                <select required id="id_commerciale" class="form-control" name="id_commerciale">
                  <option value="0">Seleziona</option>
                  @foreach ($utenti_commerciali as $commerciale)
                  <option value="{{$commerciale->id}}" @if ($contratto->user_id == $commerciale->id) selected="selected" @endif>{{$commerciale->name}}</option>
                  @endforeach
                </select>
              </div>
          </div>
          <div class="card-header">TIPO CONTRATTO</div>
          <div class="card-body">
            <div class="form-group">               
              <div class="form-check form-check-inline">
                 <label  class="form-check-label">{{ strtoupper($contratto->tipo_contratto) }}</label>
              </div>              
            </div>
            <div class="input-group">
            <input class="form-control" type="text" name="segnalatore" value="{{ $contratto->segnalatore }}" placeholder="Segnalato da ...">
            </div>
          </div>
        </div>    
      </div>{{-- col --}}


      <div class="col-lg-4">
      <div class="card card-accent-primary">
          <div class="card-body text-center">
              LOGO
          </div>
        </div>    
      </div>{{-- col --}}
  </div>{{-- row --}}


  <div class="row justify-content-between">
    {{-- Cliente --}}
    <div class="col-lg-5">
      <div class="form-group">
        <label for="cliente">Cliente</label>
        <textarea id="cliente" class="form-control" name="cliente" rows="5" placeholder="ID - Hotel XXXXX
  LOCALITA">
{{$contratto->dati_cliente}}
        </textarea>
        
      </div>
    </div>

    {{-- Fatturazione --}}
    <div class="col-lg-5">
      <div class="form-group">
        <label for="fatturazione">Dati Fatturazione</label>
        <textarea id="fatturazione" class="form-control" name="fatturazione" rows="5" placeholder="Hotel XXXXX s.a.s. di YYYYYY
  Viale ZZZZZZ
  CAP-LOCALITA(PROVINCIA) 
  P.IVA: PPPPPP
  Codice Fiscale:CCCCCCCCCCC">
{{$contratto->dati_fatturazione}}
        </textarea>
      </div>
    </div>
  </div>

  <div class="row">
    {{-- Referente --}}
    <div class="col-lg-5">
      <div class="form-group">
        <label for="referente">Dati Referente</label>
        <textarea id="referente" class="form-control" name="referente" rows="5" placeholder="Proprietario: Napoleone Bonaparte - 338-111222333">
{{$contratto->dati_referente}}
        </textarea>
      </div>
    </div>
  </div>

  {{-- IBAN  --}}
  <div class="form-group row">

    <label class="col-lg-3 col-form-label" for="i1">IBAN</label>
    <div class="col-lg-2">
      <input class="form-control" id="i1" type="text" value="{{ $i1 }}">
    </div>
    <div class="col-lg-2">
      <input class="form-control" id="i2" type="text" value="{{ $i2 }}">
    </div>
    <div class="col-lg-2">
      <input class="form-control" id="i3" type="text" value="{{ $i3 }}">
    </div>
    <div class="col-lg-2">
      <input class="form-control" id="i4" type="text" value="{{ $i4 }}">
    </div>
  </div>

  {{-- pec --}}
  <div class="form-group row">
    <label class="col-md-3 col-form-label" for="text-input">PEC</label>
    <div class="col-md-9">
      <input class="form-control" id="pec" type="text" name="pec" placeholder="PEC" value="{{$contratto->pec}}">
    </div>
  </div>
  
  {{-- codice destinatario --}}
  <div class="form-group row">
    <label class="col-md-3 col-form-label" for="text-input">Codice Destinatario</label>
    <div class="col-md-9">
      <input class="form-control" id="codice_destinatario" type="text" name="codice_destinatario" placeholder="Codice Destinatario" value="{{$contratto->codice_destinatario}}" maxlength="7">
    </div>
  </div>

  {{-- Condizioni di pagamento --}}

  <div class="row">
    <div class="form-group col-sm-3">
      <label for="condizioni_pagamento">Condizioni di pagamento</label>
    </div>
    <div class="form-group col-sm-7">
      <label for="data_pagamento">Data pagamento</label>
    </div>
  </div>
  @foreach ($condizioni_pagamento as $cp)
    <div class="row">
        <div class="form-check-inline form-group col-sm-3">
          <input class="form-check-input condizioni_pagamento" id="{{$cp}}" type="radio" value="{{$cp}}" name="condizioni_pagamento">
          <label class="form-check-label" for="{{$cp}}">{{$cp}}</label>
        </div>
        <div class="form-group col-sm-7">
          <input class="form-control" id="data_pagamento" type="text" placeholder="">
        </div>
    </div>
  @endforeach


  <div class="row">
    <div class="col mt-5">
      <button type="submit" class="btn btn-primary btn-xs">Salva</button>
    </div>
  </div>
</form>


@endsection

