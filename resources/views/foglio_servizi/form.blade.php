@extends('layouts.coreui.crm_lara6')


@section('js')
	<script type="text/javascript" charset="utf-8">
		
		jQuery(document).ready(function(){
      
        $.datepicker.setDefaults( $.datepicker.regional[ "it" ] );

        var dateFormat = "dd/mm/yy",
       
        dal = $( "#dal" )
          .datepicker({
            defaultDate: "+0d",
            changeMonth: true,
            numberOfMonths: 1
          })
          .on( "change", function() {
            al.datepicker( "option", "minDate", getDate( this ) );
          }),
        al = $( "#al" ).datepicker({
          defaultDate: "+1w",
          changeMonth: true,
          numberOfMonths: 1
        })
        .on( "change", function() {
          dal.datepicker( "option", "maxDate", getDate( this ) );
        });
  
      function getDate( element ) {
        var date;
        try {
          date = $.datepicker.parseDate( dateFormat, element.value );
        } catch( error ) {
          date = null;
        }
  
        return date;
      }

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
      
      @php 
        for ($i=1; $i < 10; $i++) {
          $col = 'pf_'.$i; 
      @endphp  
        <div class="col-md-4">
          <div class="input-group margin-bottom-sm">
            <div class="input-group-prepend"><span class="input-group-text" id="btnGroupAddon"><i class="far fa-check-square"></i></span></div>
            <input type="text" name="{{$col}}" id="{{$col}}" class="form-control"  value="{{old($col) != '' ?  old($col) :  $foglio->$col}}"  maxlength="28">
          </div>
        </div>
      @php } @endphp
      
    </div> <!-- row -->
 </div> <!-- elenco_pti_forza -->

 <div class="spacerBlu"></div>

  <div class="row">
     <div class="col-md-4">
        <label>Tipologia</label>
        <select required id="tipo" class="form-control" name="tipo">
          @foreach (Utility::getFsTipologia() as $tipo_id => $tipo)
            <option value="{{$tipo_id}}" {{old('tipo') == $tipo_id || $foglio->tipo == $tipo_id ? 'selected' : '' }}>{{$tipo}}</option>
          @endforeach
        </select>
     </div>

     <div class="col-md-4">
        <label>Categoria</label>
        <select required id="categoria" class="form-control" name="tipo">
          @foreach (Utility::getHotelCategoria() as $categoria_id => $categoria)
            <option value="{{$categoria_id}}" {{old('categoria') == $categoria_id || $foglio->categoria == $categoria_id ? 'selected' : '' }}>{!!$categoria!!}</option>
          @endforeach
        </select>
     </div>


     <div class="col-md-4">
        <label>Apertura</label>
        <select required id="apertura" class="form-control" name="tipo">
          @foreach (Utility::getHotelApertura() as $apertura_id => $apertura)
            <option value="{{$apertura_id}}" {{old('apertura') == $apertura_id || $foglio->apertura == $apertura_id ? 'selected' : '' }}>{{$apertura}}</option>
          @endforeach
        </select>
     </div>
  </div>

  <div id="opzioni_apertura">

    <div class="spacerBlu"></div>
    
    <div class="row aperture">
      <div class="col-md-4">
        <label class="row_label">DATE APERTURA HOTEL</label> 
      </div>
      <div class="col-md-4">
          <label>DAL</label>
          <div class="input-group margin-bottom-sm">
            <div class="input-group-prepend"><span class="input-group-text" id="btnGroupAddon"><i class="far fa-calendar-alt"></i></span></div>
            <input type="text" id="dal" name="dal" value="" class="form-control">
          </div>
      </div>
      <div class="col-md-4">
         <label>AL</label>
         <div class="input-group margin-bottom-sm">
            <div class="input-group-prepend"><span class="input-group-text" id="btnGroupAddon"><i class="far fa-calendar-alt"></i></span></div>
            <input type="text" id="al" name="al" value="" class="form-control">
          </div>
      </div>
    </div>

     <div class="row">
      <div class="col-md-12">
        (In caso siate aperti in periodi dell’anno al di fuori della stagione estiva indicate quali):
      </div>
    </div>

    <div class="row form-inline altre_aperture">
      <div class="col-md-2">
        <input type="checkbox" name="fiere" id="fiere" value="1" {{ old('fiere') || $foglio->fiere ? 'checked' : '' }}  class="beautiful_checkbox"> 
        <label for="fiere">
          fiere
        </label>
      </div>
      <div class="col-md-2">
        <input type="checkbox" name="pasqua" id="pasqua" value="1" {{ old('pasqua') || $foglio->pasqua ? 'checked' : '' }}  class="beautiful_checkbox">
        <label for="pasqua">
           pasqua
        </label>
      </div>
      <div class="col-md-2">
        <input type="checkbox" name="capodanno" id="capodanno" value="1" {{ old('capodanno') || $foglio->capodanno ? 'checked' : '' }}  class="beautiful_checkbox"> 
        <label for="capodanno">
          capodanno
        </label>
      </div>
      <div class="col-md-2">
        <input type="checkbox" name="aprile_25" id="aprile_25" value="1" {{ old('aprile_25') || $foglio->aprile_25 ? 'checked' : '' }}  class="beautiful_checkbox">
        <label for="aprile_25">
           25 aprile
        </label>
      </div>
      <div class="col-md-2">
        <input type="checkbox" name="maggio_1" id="maggio_1" value="1" {{ old('maggio_1') || $foglio->maggio_1 ? 'checked' : '' }}  class="beautiful_checkbox">
        <label for="maggio_1">
           1° maggio
        </label>
      </div>
    </div>

    <div class="row">
      <label class="col-md-2">
        altro
      </label>
      <div class="col-md-5">
        <input type="text" name="altra_apertura" id="altra_apertura" class="form-control"  value="{{old('altra_apertura') != '' ?  old('altra_apertura') :  $foglio->altra_apertura}}">
      </div>
    </div>
    
  </div> {{-- opzioni_apertura --}}

  <div class="spacerBlu"></div>

  <div class="row">
    <label class="col-md-3">
      N. locali e posti letto
    </label>
    <div class="col-md-5">
      <input type="checkbox" name="numeri_anno_prec" id="numeri_anno_prec" value="1" {{ old('numeri_anno_prec') || $foglio->numeri_anno_prec ? 'checked' : '' }} class="beautiful_checkbox">       
    <label for="numeri_anno_prec">Stessi numeri anno precedente</label>
    </div>
  </div>

  <div id="elenco_numeri_locali">
    <div class="row">

      <div class="col-md-3">
        <label>
            NUMERO CAMERE:
        </label>
        <input type="text" name="n_camere" id="n_camere" class="form-control"  value="{{old('n_camere') != '' ?  old('n_camere') :  $foglio->n_camere}}">
      </div>

      <div class="col-md-3">
        <label>
            NUMERO APPARTAMENTI:
        </label>
        <input type="text" name="n_app" id="n_app" class="form-control"  value="{{old('n_app') != '' ?  old('n_app') :  $foglio->n_app}}">
      </div>

      <div class="col-md-3">
        <label>
            NUMERO SUITE:
        </label>
        <input type="text" name="n_suite" id="n_suite" class="form-control"  value="{{old('n_suite') != '' ?  old('n_suite') :  $foglio->n_suite}}">
      </div>

      <div class="col-md-3">
        <label>
            NUMERO LETTI:
        </label>
        <input type="text" name="n_letti" id="n_letti" class="form-control"  value="{{old('n_letti') != '' ?  old('n_letti') :  $foglio->n_letti}}">
      </div>
    </div>
  </div>

  <div class="spacerBlu"></div>

  <div class="row">

    <div class="col-md-2">  
      <label style="margin-top: 5px;">
         ORARIO APERTURA RECEPTION
      </label>
    </div>
    <div class="col-md-4">
      <input type="checkbox" name="h_24" id="h_24" value="1" {{ old('h_24') || $foglio->h_24 ? 'checked' : '' }} class="beautiful_checkbox">
      <label for="h_24">
         24 ore su 24
      </label>
    </div>   
      <label class="col-md-1 orari_reception">
          dalle
      </label>
      <div class="col-md-1 orari_reception">
        <select required id="rec_dalle_ore" class="form-control" name="rec_dalle_ore">
          @foreach (Utility::getFsOre() as $id => $value)
            <option value="{{$id}}" {{old('rec_dalle_ore') == $id || $foglio->rec_dalle_ore == $id ? 'selected' : '' }}>{{$value}}</option>
          @endforeach
        </select>
      </div>
      <div class="col-md-1 orari_reception">
        <select required id="rec_dalle_minuti" class="form-control" name="rec_dalle_minuti">
          @foreach (Utility::getFsMinuti() as $id => $value)
            <option value="{{$id}}" {{old('rec_dalle_minuti') == $id || $foglio->rec_dalle_minuti == $id ? 'selected' : '' }}>{{$value}}</option>
          @endforeach
        </select>
      </div>
      <label class="col-md-1 orari_reception">
          alle
      </label>
      <div class="col-md-1 orari_reception">
        <select required id="rec_alle_ore" class="form-control" name="rec_alle_ore">
          @foreach (Utility::getFsOre() as $id => $value)
            <option value="{{$id}}" {{old('rec_alle_ore') == $id || $foglio->rec_alle_ore == $id ? 'selected' : '' }}>{{$value}}</option>
          @endforeach
        </select>
      </div>
      <div class="col-md-1 orari_reception">
        <select required id="rec_alle_minuti" class="form-control" name="rec_alle_minuti">
          @foreach (Utility::getFsMinuti() as $id => $value)
            <option value="{{$id}}" {{old('rec_alle_minuti') == $id || $foglio->rec_alle_minuti == $id ? 'selected' : '' }}>{{$value}}</option>
          @endforeach
        </select>
      </div>
  </div> {{-- row --}}
       

</form>


@endsection

