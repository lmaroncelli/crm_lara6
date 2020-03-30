@extends('layouts.coreui.crm_lara6')


@section('js')
	<script type="text/javascript" charset="utf-8">
		
	

		jQuery(document).ready(function(){

        // click su ogni cella della griglia

        $(".clickable:not(.acquistata_1)").click(function(e){

            e.preventDefault();

            @if (!session()->has('id_cliente') || !session()->has('id_agente'))
              
              alert('seleziona un cliente!');

            @else
              
              $(".spinner_lu").show();

              var id_evidenza = $(this).attr("data-id-evidenza");
              var id_mese = $(this).attr("data-id-mese");
              
              var data = {
                'id_agente': "{{ session('id_agente') }}",
                'id_cliente': "{{ session('id_cliente') }}",
                'id_evidenza': id_evidenza,
                'id_mese': id_mese
              }  

              $.ajax({
                        url: "{{ route('assegna-mese-evidenza-ajax') }}",
                        data: data,
                        success: function(msg) {
                            if (msg == 'ok') {
                              location.reload();
                            } else {
                              $(".spinner_lu").hide();
                              window.alert(msg);
                            }
                        }
                    });

            @endif

          });

      

		});
	

	</script>
	
@endsection

@section('content')
<form action="{{ route('contratto-digitale.update',$contratto->id) }}" method="post" id="form_contratto_digitale">
  @csrf
  @method('PUT')
  <div class="row mt-2 row justify-content-between">
      <div class="col-lg-5">
      <div class="card card-accent-primary text-center">
          <div class="card-header">CONTRATTO FORNITURA SERVIZI</div>
          <div class="card-body">
              <div class="form-group">
                <label for="id_commerciale">Nome Agente:</label>
                <label  class="form-check-label">{{ strtoupper($commerciale_contratto) }}</label>
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

  {{-- Iban importato --}}
  @if ($mostra_iban_importato && $contratto->iban_importato != '')
  <div class="form-group row">
    <label class="col-md-3 col-form-label" for="text-input">IBAN IMPORTATO</label>
    <div class="col-md-9">
      <input class="form-control" id="iban_importato" type="text" name="iban_importato" placeholder="iban importato dal crm" value="{{$contratto->iban_importato}}">
      <span class="help-block">Importato dal CRM (questo campo verrà automaticamente nascosto dopo aver compilato l'IBAN sottostante e salvato)</span>
    </div>
  </div>
  @endif

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
          <label class="form-check-label" for="{{$cp}}">
            {{$cp}} @if ($cp == 'RIBA') (*) @endif
          </label>
        </div>
        <div class="form-group col-sm-7">
          <input class="form-control" class="data_pagamento" type="text" placeholder="">
        </div>
    </div>
  @endforeach

  <div class="row">
    <div class="form-group col-sm-8 offset-sm-2">
      <label class="riba">* In caso di mancato saldo Ri.BA. alla scadenza contrattualmente determinata verrà effettuato l’addebito delle spese accessorie causa insoluto. Dette spese sono quantificabili in euro 7,00.</label>
    </div>
  </div>

  {{-- Note --}}
  <div class="form-group row">
    <label class="col-md-3 col-form-label" for="text-input">NOTE</label>
    <div class="col-md-9">
      <textarea id="note" class="form-control" name="note" rows="5" placeholder="note">
{{$contratto->note}}
      </textarea>
    </div>
  </div>

  {{-- Sito Web --}}
  <div class="form-group row">
    <label class="col-md-3 col-form-label" for="text-input">Sito web</label>
    <div class="col-md-9">
      <input class="form-control" id="sito_web" type="text" name="sito_web" placeholder="Sito web" value="{{$contratto->sito_web}}">
    </div>
  </div>

  {{-- email --}}
  <div class="form-group row">
    <label class="col-md-3 col-form-label" for="text-input">Email</label>
    <div class="col-md-9">
      <input class="form-control" id="email" type="text" name="email" placeholder="Email" value="{{$contratto->email}}">
    </div>
  </div>

  {{--  Email amministrativa --}}
  <div class="form-group row">
    <label class="col-md-3 col-form-label" for="text-input">Email amministrativa</label>
    <div class="col-md-9">
      <input class="form-control" id="email_amministrativa" type="text" name="email_amministrativa" placeholder="Email amministrativa" value="{{$contratto->email_amministrativa}}">
    </div>
  </div>

  <div class="row">
    <div class="col mt-5">
      <button type="submit" class="btn btn-primary btn-xs">Salva</button>
    </div>
  </div>
</form>
<hr>
<div class="evidenze_contratto">
{{-- griglia_evidenze --}}
<h4 class="m-portlet__head-text" style="width: 100px;">
  Località
</h4>
{{--  Elenco macrolocalita  --}}
<div class="row">
<ul class="nav nav-tabs nav-griglia">
  @foreach ($macro as $id => $nome)
    <li class="nav-item">
      <a class="nav-link @if ($id == $macro_id) active @endif" href="{{ route('contratto-digitale.edit', ['contratto_id' => $contratto->id, 'macro_id' => $id]) }}">{{$nome}}</a>
    </li>
  @endforeach
  </ul>
</div>

@include('evidenze.griglia_evidenze_inc', ['contratto_digitale' => 1])
{{-- END griglia_evidenze --}}

</div>

@endsection

