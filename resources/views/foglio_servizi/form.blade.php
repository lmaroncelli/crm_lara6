@extends('layouts.coreui.crm_lara6')


@section('js')
	<script type="text/javascript" charset="utf-8">
		

		jQuery(document).ready(function(){

		});
	

	</script>
	
@endsection

@section('content')
<div class="spinner_lu" style="display:none;"></div>
<form action="{{ route('foglio-servizi.update',$foglio->id) }}" method="post" id="form_foglio_servizi">
  @csrf
  @method('PUT')
  <div class="row mt-2 row justify-content-between">
      <div class="col-lg-5">
      <div class="card card-accent-primary text-center">
          <div class="card-header">MODULO SERVIZI HOTEL</div>
          <div class="card-body">
              <div class="form-group">
                <label for="id_commerciale">Nome Agente</label>
                <label  class="form-check-label">{{ strtoupper($commerciale_contratto) }}</label>
              </div>
              <div class="row form-group">
                <div class="col-md-6">
                  <label>NOME HOTEL</label>
                  <input type="text" name="nome_hotel" id="nome_hotel" class="form-control"  value="{{old('nome_hotel') != '' ?  old('nome_hotel') :  $foglio->nome_hotel}}">
                </div>
                <div class="col-md-6">
                  <label>SMS</label>
                  <input type="text" name="sms" id="sms" class="form-control"  value="{{old('skype') != '' ?  old('skype') :  $foglio->skype}}">
                </div>
            </div>
            <div class="row form-group ">
              <div class="col-md-6">
                <label>LOCALITA</label>
                <input type="text" name="localita" id="localita" class="form-control"  value="{{old('localita') != '' ?  old('localita') :  $foglio->localita}}">
              </div>
              <div class="col-md-6">
                <label>WHATSAPP</label>
                <input type="text" name="whatsapp" id="whatsapp" class="form-control"  value="{{old('whatsapp') != '' ?  old('whatsapp') :  $foglio->whatsapp}}">
              </div>
            </div>
            <div class="row form-group ">
              <div class="col-md-6">
                <label>ANNO STAGIONE</label>
                <input type="text" name="stagione" id="stagione" class="form-control"  value="{{old('stagione') != '' ?  old('stagione') :  $foglio->stagione}}">
              </div>
              <div class="col-md-6">
                <label>SKYPE</label>
                <input type="text" name="skype" id="skype" class="form-control"  value="{{old('skype') != '' ?  old('skype') :  $foglio->skype}}">
              </div>
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

  <div class="spacerBlu"></div>

   <div class="row form-group">
    <div class="col-md-6">
      <label>
          PREZZO MIN:
      </label>
      <input type="text" name="prezzo_min" id="prezzo_min" class="form-control"  value="{{old('prezzo_min') != '' ?  old('prezzo_min') :  $foglio->prezzo_min}}">
    </div>

    <div class="col-md-6">
      <label>
         PREZZO MAX:
      </label>
      <input type="text" name="prezzo_max" id="prezzo_max" class="form-control"  value="{{old('prezzo_max') != '' ?  old('prezzo_max') :  $foglio->prezzo_max}}">
    </div>
  </div>

  <div class="spacerBlu"></div>

   <div class="row">
    <div class="col-md-12">
      <label>LA STRUTTURA ORGANIZZA:</label>
    </div>
  </div>
  
  <div class="row form-inline">
    <div class="col-md-3 form-check">
      <input type="checkbox" name="organizzazione_comunioni" class="organizzazione" id="organizzazione_comunioni" value="1" class="beautiful_checkbox" {{ old('organizzazione_comunioni') || $foglio->organizzazione_comunioni ? 'checked' : '' }}>  
      <label for="organizzazione_comunioni">comunioni</label> 
    </div>
    <div class="col-md-3 form-check">
      <input type="checkbox" name="organizzazione_cresime" class="organizzazione" id="organizzazione_cresime" value="1" class="beautiful_checkbox" {{ old('organizzazione_cresime') || $foglio->organizzazione_cresime ? 'checked' : '' }}>
      <label for="organizzazione_cresime">cresime</label> 
    </div>
    <div class="col-md-3 form-check">
      <input type="checkbox" name="organizzazione_matrimoni" class="organizzazione" id="organizzazione_matrimoni" value="1" class="beautiful_checkbox" {{ old('organizzazione_matrimoni') || $foglio->organizzazione_matrimoni ? 'checked' : '' }}>
      <label for="organizzazione_matrimoni">matrimoni</label> 
    </div>
  </div>

  <div id="note_organizzazione_matrimoni">
    <div class="row">
      <div class="col-md-12">
        <label>Note</label>
      </div>
    </div>
    <div class="row" style="padding-top: 0;">
      <div class="col-md-12">
        <textarea name="note_organizzazione_matrimoni" class="form-control">{{old('note_organizzazione_matrimoni') != '' ?  old('note_organizzazione_matrimoni') :  $foglio->note_organizzazione_matrimoni}}</textarea>
      </div>
    </div>
  </div>

  <div class="spacerBlu"></div>

  <div class="row">
    <div class="col-md-12">
      <label>9 PUNTI DI FORZA/SERVIZI (MAX 28 CARATTERI A SERVIZIO):</label>
    </div>
  </div>

  <div class="row form-inline" style="padding-top: 0;">
    <div class="col-md-12">
      <input type="checkbox" name="pti_anno_prec" id="pti_anno_prec" value="1" {{ old('pti_anno_prec') || $foglio->pti_anno_prec ? 'checked' : '' }} class="beautiful_checkbox">       
      <label for="pti_anno_prec">Stessi punti di forza anno precedente:</label>
    </div>
  </div>
    
  <div id="note_pti_forza">
    <div class="row">
      <div class="col-md-12">
        <label>Note sui punti di forza</label>
      </div>
    </div>
    <div class="row" style="padding-top: 0;">
      <div class="col-md-12">
        <textarea name="note_pf" class="form-control">
{{old('note_pf') != '' ?  old('note_pf') :  $foglio->note_pf}}</textarea>
      </div>
    </div>
  </div>


  <div id="elenco_pti_forza">
    <div class="row">
      
      @php for ($i=1; $i < 10; $i++) { @endphp  
        <div class="col-md-4">
          <div class="input-group margin-bottom-sm">
            <div class="input-group-prepend"><span class="input-group-text" id="btnGroupAddon"><i class="fas fa-check-square"></i></span></div>
            <input type="text" name="pf_2" id="pf_2" class="form-control"  value="{{old('pf_1') != '' ?  old('pf_1') :  $foglio->pf_1}}"  maxlength="28">
          </div>
        </div>
      @php } @endphp
      
    </div> <!-- row -->
 </div> <!-- elenco_pti_forza -->



</form>


@endsection

