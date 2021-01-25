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

  <div class="row">
    <div class="col-md-6">
      <label>
          ORARIO DI CHECK IN:
      </label>
      <input type="text" name="checkin" id="checkin" class="form-control"  value="{{old('checkin') != '' ?  old('checkin') :  $foglio->checkin}}">
    </div>

    <div class="col-md-6">
      <label>
         ORARIO DI CHECK OUT:
      </label>
      <input type="text" name="checkout" id="checkout" class="form-control"  value="{{old('checkout') != '' ?  old('checkout') :  $foglio->checkout}}">
    </div>
  </div>

  <div class="spacerBlu"></div>

   <div class="row">

    <div class="col-md-2">  
      <label style="margin-top: 5px;">
         ORARIO DEI PASTI
      </label>
    </div>
    <div class="col-md-4">
      <input type="checkbox" name="pasti_anno_prec" id="pasti_anno_prec" value="1" {{ old('pasti_anno_prec') || $foglio->pasti_anno_prec ? 'checked' : '' }} class="beautiful_checkbox">
      <label for="pasti_anno_prec">
         Stessi orari anno precedente
      </label>
    </div>
   </div>

   <div class="row">
     <div class="col-md-4">
        <div class="row">
          <label class="col-md-12">Colazione</label>
          <div class="col-md-2">
            <select required id="colazione_dalle_ore" class="form-control" name="colazione_dalle_ore">
            @foreach (Utility::getFsOre() as $id => $value)
              <option value="{{$id}}" {{old('colazione_dalle_ore') == $id || $foglio->colazione_dalle_ore == $id ? 'selected' : '' }}>{{$value}}</option>
            @endforeach
          </select>
          </div>
          <div class="col-md-2">
            <select required id="colazione_dalle_minuti" class="form-control" name="colazione_dalle_minuti">
              @foreach (Utility::getFsMinuti() as $id => $value)
                <option value="{{$id}}" {{old('colazione_dalle_minuti') == $id || $foglio->colazione_dalle_minuti == $id ? 'selected' : '' }}>{{$value}}</option>
              @endforeach
            </select>
          </div>
          <label class="col-md-2">
              alle
          </label>
          <div class="col-md-2">
            <select required id="colazione_alle_ore" class="form-control" name="colazione_alle_ore">
              @foreach (Utility::getFsOre() as $id => $value)
                <option value="{{$id}}" {{old('colazione_alle_ore') == $id || $foglio->colazione_alle_ore == $id ? 'selected' : '' }}>{{$value}}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-2">
            <select required id="colazione_alle_minuti" class="form-control" name="colazione_alle_minuti">
              @foreach (Utility::getFsMinuti() as $id => $value)
                <option value="{{$id}}" {{old('colazione_alle_minuti') == $id || $foglio->colazione_alle_minuti == $id ? 'selected' : '' }}>{{$value}}</option>
              @endforeach
            </select>
          </div>
        </div>

     </div>

     <div class="col-md-4">
        <div class="row">
          <label class="col-md-12">Pranzo</label>
          <div class="col-md-2">
            <select required id="pranzo_dalle_ore" class="form-control" name="pranzo_dalle_ore">
            @foreach (Utility::getFsOre() as $id => $value)
              <option value="{{$id}}" {{old('pranzo_dalle_ore') == $id || $foglio->pranzo_dalle_ore == $id ? 'selected' : '' }}>{{$value}}</option>
            @endforeach
          </select>
          </div>
          <div class="col-md-2">
            <select required id="pranzo_dalle_minuti" class="form-control" name="pranzo_dalle_minuti">
              @foreach (Utility::getFsMinuti() as $id => $value)
                <option value="{{$id}}" {{old('pranzo_dalle_minuti') == $id || $foglio->pranzo_dalle_minuti == $id ? 'selected' : '' }}>{{$value}}</option>
              @endforeach
            </select>
          </div>
          <label class="col-md-2">
              alle
          </label>
          <div class="col-md-2">
            <select required id="pranzo_alle_ore" class="form-control" name="pranzo_alle_ore">
              @foreach (Utility::getFsOre() as $id => $value)
                <option value="{{$id}}" {{old('pranzo_alle_ore') == $id || $foglio->pranzo_alle_ore == $id ? 'selected' : '' }}>{{$value}}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-2">
            <select required id="pranzo_alle_minuti" class="form-control" name="pranzo_alle_minuti">
              @foreach (Utility::getFsMinuti() as $id => $value)
                <option value="{{$id}}" {{old('pranzo_alle_minuti') == $id || $foglio->pranzo_alle_minuti == $id ? 'selected' : '' }}>{{$value}}</option>
              @endforeach
            </select>
          </div>
        </div>
        
     </div>


     <div class="col-md-4">
        <div class="row">
          <label class="col-md-12">Cena</label>
          <div class="col-md-2">
            <select required id="cena_dalle_ore" class="form-control" name="cena_dalle_ore">
            @foreach (Utility::getFsOre() as $id => $value)
              <option value="{{$id}}" {{old('cena_dalle_ore') == $id || $foglio->cena_dalle_ore == $id ? 'selected' : '' }}>{{$value}}</option>
            @endforeach
          </select>
          </div>
          <div class="col-md-2">
            <select required id="cena_dalle_minuti" class="form-control" name="cena_dalle_minuti">
              @foreach (Utility::getFsMinuti() as $id => $value)
                <option value="{{$id}}" {{old('cena_dalle_minuti') == $id || $foglio->cena_dalle_minuti == $id ? 'selected' : '' }}>{{$value}}</option>
              @endforeach
            </select>
          </div>
          <label class="col-md-2">
              alle
          </label>
          <div class="col-md-2">
            <select required id="cena_alle_ore" class="form-control" name="cena_alle_ore">
              @foreach (Utility::getFsOre() as $id => $value)
                <option value="{{$id}}" {{old('cena_alle_ore') == $id || $foglio->cena_alle_ore == $id ? 'selected' : '' }}>{{$value}}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-2">
            <select required id="cena_alle_minuti" class="form-control" name="cena_alle_minuti">
              @foreach (Utility::getFsMinuti() as $id => $value)
                <option value="{{$id}}" {{old('cena_alle_minuti') == $id || $foglio->cena_alle_minuti == $id ? 'selected' : '' }}>{{$value}}</option>
              @endforeach
            </select>
          </div>
        </div>
        
     </div>
  </div>

  <div class="spacerBlu"></div>

  <div class="row">
    <div class="col-md-12">
      <label>TRATTAMENTI PRINCIPALI:</label>
    </div>
  </div>

  <div class="row" style="padding-top: 0;">
    @foreach (Utility::getFsTrattamentiENote() as $key => $val)
      @if (strpos($key,'note_') !== false)
        <div class="col-md-9">
          <textarea name="{{$key}}" placeholder="Elenca i servizi inclusi" class="form-control">{{old('$key') != '' ?  old('$key') :  $foglio->$key}}</textarea>
        </div>
      @else
        <div class="col-md-3">
          <input type="checkbox" name="{{$key}}" id="{{$key}}" value="1" {{ old('$key') || $foglio->$key ? 'checked' : '' }}  class="beautiful_checkbox"> 
          <label for="{{$key}}">
          {{$val}}
          </label>
        </div>
      @endif
    @endforeach
  </div>

  <div class="spacerBlu"></div>

  <div class="row">
    <div class="col-md-12">
      <label>SI CHIEDE CAPARRA AL MOMENTO DELLA PRENOTAZIONE?</label>
    </div>
  </div>
  <div class="row">
    <div class="col-md-1">
      <select required id="caparra" class="form-control" name="caparra">
        @foreach (['si','no'] as $value)
          <option value="{{$id}}" {{old('caparra') == $id || $foglio->caparra == $id ? 'selected' : '' }}>{{$value}}</option>
        @endforeach
      </select>
    </div>
    <label class="offset-md-1 col-md-1">altro</label>
    <div class="col-md-6">
      <input type="text" name="altra_caparra" id="altra_caparra" class="form-control" value="{{old('altra_caparra') != '' ?  old('altra_caparra') :  $foglio->altra_caparra}}">
    </div>
  </div>
  
  <div class="spacerBlu"></div>

  <div class="row">
    <div class="col-md-12">
      <label>PAGAMENTI ACCETTATI:</label>
    </div>
  </div>
  <div class="row">
    @foreach (Utility::getFsPagamenti() as $key => $val)
      <div class="col-md-2">
        <input type="checkbox" name="{{$key}}" id="{{$key}}" value="1" {{ old('$key') || $foglio->$key ? 'checked' : '' }}  class="beautiful_checkbox"> 
        <label for="{{$key}}">
        {{$val}}
        </label>
      </div>
    @endforeach
  </div>
  <div class="row">
    <div class="col-md-12">
      <label>Note pagamenti</label>
    </div>
  </div>
  <div class="row" style="padding-top: 0;">
    <div class="col-md-12">
      <textarea name="note_pagamenti" class="form-control">{{old('note_pagamenti') != '' ?  old('note_pagamenti') :  $foglio->note_pagamenti}}</textarea>
    </div>
  </div>

  <div class="spacerBlu"></div>

  <div class="row">
    <div class="col-md-12">
      <label>LINGUE PARLATE:</label>
    </div>
  </div>
  <div class="row">
    @foreach (Utility::getFsLingue() as $key => $val)
      <div class="col-md-2">
        <input type="checkbox" name="{{$key}}" id="{{$key}}" value="1" {{ old('$key') || $foglio->$key ? 'checked' : '' }}  class="beautiful_checkbox"> 
        <label for="{{$key}}">
        {{$val}}
        </label>
      </div>
    @endforeach
  </div>
  <div class="row">
    <div class="col-md-12">
      <label>Altro</label>
    </div>
  </div>
  <div class="row" style="padding-top: 0;">
    <div class="col-md-12">
      <textarea name="altra_lingua" class="form-control">{{old('altra_lingua') != '' ?  old('altra_lingua') :  $foglio->altra_lingua}}</textarea>
    </div>
  </div>

  <div class="spacerBlu"></div>

  <div class="row">
    <div class="col-md-2">  
      <label style="margin-top: 5px;">
         INFO PISCINA
      </label>
    </div>
    <div class="col-md-4">
      <input type="checkbox" name="piscina" id="piscina" value="1" {{ old('piscina') || $foglio->piscina ? 'checked' : '' }} class="beautiful_checkbox">
      <label for="piscina">
        Ho una piscina
      </label>
    </div>
  </div>


  <div id="elenco_campi_piscina">
      
    <div class="row">
      <div class="col-md-6">
        <label>
            superficie (mq.)
        </label>
        <input class="form-control misure" maxlength="3" name="sup" type="text" value="{{old('sup') != '' ?  old('sup') :  $infoPiscina->sup}}" id="sup">
      </div>
    </div>

    <div class="row">
      <div class="col-md-4">
        <label>
            altezza unica (cm.)
        </label>
        <input id="h" class="form-control misure" maxlength="3" name="h" type="text" value="{{old('h') != '' ?  old('h') :  $infoPiscina->h}}">
      </div>
      <div class="col-md-4">
        <label>
            altezza min. (cm.)
        </label>
        <input id="h_min" class="form-control misure" maxlength="3" name="h_min" type="text" value="{{old('h_min') != '' ?  old('h_min') :  $infoPiscina->h_min}}">
      </div>
      <div class="col-md-4">
        <label>
            altezza max. (cm.)
        </label>
          <input id="h_max" class="form-control misure" maxlength="3" name="h_max" type="text" value="{{old('h_max') != '' ?  old('h_max') :  $infoPiscina->h_max}}">
      </div>
    </div>

    <div class="row">
      <label class="col-md-3">
          PERIODO APERTURA
      </label>
      <label class="col-md-1">
          da
      </label>
      <div class="col-md-2">
        <select required id="aperto_dal" class="form-control" name="aperto_dal">
          @foreach (Utility::getFsMesi() as $id => $value)
            <option value="{{$id}}" {{old('aperto_dal') == $id || $infoPiscina->aperto_dal == $id ? 'selected' : '' }}>{{$value}}</option>
          @endforeach
        </select>
      </div>
      <label class="col-md-1">
          a
      </label>
      <div class="col-md-2">
        <select required id="aperto_al" class="form-control" name="aperto_al">
          @foreach (Utility::getFsMesi() as $id => $value)
            <option value="{{$id}}" {{old('aperto_al') == $id || $infoPiscina->aperto_al == $id ? 'selected' : '' }}>{{$value}}</option>
          @endforeach
        </select>
      </div>
      <div class="col-md-2">
        <input type="checkbox" name="aperto_annuale" id="aperto_annuale" value="1" {{ old('aperto_annuale') || $infoPiscina->aperto_annuale ? 'checked' : '' }} class="beautiful_checkbox">
        <label for="aperto_annuale">
          annuale
        </label>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <label>POSIZIONE:</label>
      </div>
    </div>
    <div class="row posizione_piscina">
      @foreach (Utility::getFsPosizionePiscina() as $key => $val)
      <div class="col-md-2">
        <input type="radio" name="posizione" id="{{$key}}" value="{{$val}}" {{ old('$key') || $infoPiscina->posizione == $val ? 'checked' : '' }} class=""> 
        <label for="{{$key}}">
        {{$val}}
        </label>
      </div>
      @endforeach
    </div>

    <div class="row">
      <div class="col-md-12">
        <label>CARATTERISTICHE:</label>
      </div>
    </div>
    @php
      $row_carr = array_chunk(Utility::getFsCaratteristichePiscina(), 4, true);
    @endphp
    @foreach ($row_carr as $n_row => $caratteristichePiscina_in_row)
      <div class="row">
        @foreach ($caratteristichePiscina_in_row as $carr => $carr_view)
          <div class="col-md-3">
            <input type="checkbox" name="{{$carr}}" id="{{$carr}}" value="1" {{ old($carr) || $infoPiscina->$carr ? 'checked' : '' }} class="beautiful_checkbox">
            <label for="{{$carr}}">
              {{$carr_view}}
            </label>
          </div>
        @endforeach
      </div>
    @endforeach

    <div class="row">
      <div class="col-md-6">
        <label>
           N. lettini prendisole
        </label>
        <input id="lettini_dispo" class="form-control" maxlength="3" name="lettini_dispo" type="text" value="{{old('lettini_dispo') != '' ?  old('lettini_dispo') :  $infoPiscina->lettini_dispo}}">
      </div>
      <div class="col-md-3">
        <label>
            N. ore esposta al sole
        </label>
        <input id="espo_sole" class="form-control" maxlength="3" name="espo_sole" type="text" value="{{old('espo_sole') != '' ?  old('espo_sole') :  $infoPiscina->espo_sole}}">
      </div>
      <div class="col-md-3">
        <input type="checkbox" name="espo_sole_tutto_giorno" id="espo_sole_tutto_giorno" value="1" {{ old('espo_sole_tutto_giorno') || $infoPiscina->espo_sole_tutto_giorno ? 'checked' : '' }} class="beautiful_checkbox">
        <label for="espo_sole_tutto_giorno">
          tutto il giorno
        </label>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <label>Peculiarità</label>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <textarea name="peculiarita_piscina" class="form-control">{{old('peculiarita_piscina') != '' ?  old('peculiarita_piscina') :  $foglio->peculiarita_piscina}}</textarea>
      </div>
    </div>

    <hr>
    <div class="row">
      <div class="col-md-12">
        <label>VASCA BIMIBI</label>
      </div>
    </div>
    <div class="row">
      <div class="col-md-4">
        <label>
          superficie (mq.)
        </label>
        <input id="vasca_bimbi_sup" class="form-control" maxlength="3" name="vasca_bimbi_sup" type="text" value="{{old('vasca_bimbi_sup') != '' ?  old('vasca_bimbi_sup') :  $infoPiscina->vasca_bimbi_sup}}">
      </div>
      <div class="col-md-4">
        <label>
            altezza unica (cm.)
        </label>
        <input id="vasca_bimbi_h" class="form-control" maxlength="3" name="vasca_bimbi_h" type="text" value="{{old('vasca_bimbi_h') != '' ?  old('vasca_bimbi_h') :  $infoPiscina->vasca_bimbi_h}}">
      </div>
      <div class="col-md-4">
        <input type="checkbox" name="vasca_bimbi_riscaldata" id="vasca_bimbi_riscaldata" value="1" {{ old('vasca_bimbi_riscaldata') || $infoPiscina->vasca_bimbi_riscaldata ? 'checked' : '' }} class="beautiful_checkbox">
        <label for="vasca_bimbi_riscaldata">
          riscaldata
        </label>
      </div>
    </div>

    <hr>

    <div class="row">
      <div class="col-md-12">
        <label>VASCA IDROMASSAGGIO A PARTE</label>
      </div>
    </div>

    <div class="row">
      <div class="col-md-4">
        <label>
          N. vasche disponibili
        </label>
        <input id="vasca_idro_n_dispo" class="form-control" maxlength="3" name="vasca_idro_n_dispo" type="text" value="{{old('vasca_idro_n_dispo') != '' ?  old('vasca_idro_n_dispo') :  $infoPiscina->vasca_idro_n_dispo}}">
      </div>
      <div class="col-md-4">
        <label>
            N. posti disponibili
        </label>
        <input id="vasca_idro_posti_dispo" class="form-control" maxlength="3" name="vasca_idro_posti_dispo" type="text" value="{{old('vasca_idro_posti_dispo') != '' ?  old('vasca_idro_posti_dispo') :  $infoPiscina->vasca_idro_posti_dispo}}">
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <label>Posizione:</label>
      </div>
    </div>
    <div class="row posizione_vasca">
      @foreach (Utility::getFsPosizioneVasca() as $key => $val)
      <div class="col-md-2">
        <input type="radio" name="vasca_posizione" id="v_{{$key}}" value="{{$val}}" {{ old('$key') || $infoPiscina->vasca_posizione == $val ? 'checked' : '' }} class=""> 
        <label for="v_{{$key}}">
        {{$val}}
        </label>
      </div>
      @endforeach
    </div>

    <div class="row">
      <div class="col-md-3">
        <input type="checkbox" name="vasca_idro_riscaldata" id="vasca_idro_riscaldata" value="1" {{ old('vasca_idro_riscaldata') || $infoPiscina->vasca_idro_riscaldata ? 'checked' : '' }} class="beautiful_checkbox">
        <label for="vasca_idro_riscaldata">
          riscaldata
        </label>
      </div>
      <div class="col-md-3">
        <input type="checkbox" name="vasca_pagamento" id="vasca_pagamento" value="1" {{ old('vasca_pagamento') || $infoPiscina->vasca_pagamento ? 'checked' : '' }} class="beautiful_checkbox">
        <label for="vasca_pagamento">
          a pagamento
        </label>
      </div>
    </div>

  </div> {{-- elenco_campi_piscina --}}

  <div class="spacerBlu"></div>

  <div class="row">
    <div class="col-md-2">  
      <label style="margin-top: 5px;">
         INFO BENESSERE
      </label>
    </div>
    <div class="col-md-4">
      <input type="checkbox" name="benessere" id="benessere" value="1" {{ old('benessere') || $foglio->benessere ? 'checked' : '' }} class="beautiful_checkbox">
      <label for="benessere">
        Ho un centro benessere
      </label>
    </div>
  </div>

  <div id="elenco_campi_benessere">

     <div class="row">
      <div class="col-md-6">
        <label>
            superficie (mq.)
        </label>
        <input class="form-control misure" maxlength="3" name="sup_b" type="text" value="{{old('sup_b') != '' ?  old('sup_b') :  $centroBenessere->sup_b}}" id="sup_b">
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <label>Ho un'area fitness</label>
      </div>
    </div>
    <div class="row">
      <div class="col-md-2">
        <select required id="area_fitness" class="form-control" name="area_fitness">
        @foreach (['si','no'] as $value)
          <option value="{{$id}}" {{old('area_fitness') == $id || $centroBenessere->area_fitness == $id ? 'selected' : '' }}>{{$value}}</option>
        @endforeach
        </select>
      </div>
      <label class="offset-md-3 col-md-1">superficie (mq.)</label>
      <div class="col-md-5">
        <input type="text" name="sup_fitness" id="sup_fitness" class="form-control" value="{{old('sup_fitness') != '' ?  old('sup_fitness') :  $centroBenessere->sup_fitness}}">
      </div>
    </div>

    <div class="row">
      <label class="col-md-3">
          PERIODO APERTURA
      </label>
      <label class="col-md-1">
          da
      </label>
      <div class="col-md-2">
        <select required id="aperto_dal_b" class="form-control" name="aperto_dal_b">
          @foreach (Utility::getFsMesi() as $id => $value)
            <option value="{{$id}}" {{old('aperto_dal_b') == $id || $centroBenessere->aperto_dal_b == $id ? 'selected' : '' }}>{{$value}}</option>
          @endforeach
        </select>
      </div>
      <label class="col-md-1">
          a
      </label>
      <div class="col-md-2">
        <select required id="aperto_al_b" class="form-control" name="aperto_al_b">
          @foreach (Utility::getFsMesi() as $id => $value)
            <option value="{{$id}}" {{old('aperto_al_b') == $id || $centroBenessere->aperto_al_b == $id ? 'selected' : '' }}>{{$value}}</option>
          @endforeach
        </select>
      </div>
      <div class="col-md-2">
        <input type="checkbox" name="aperto_annuale_b" id="aperto_annuale_b" value="1" {{ old('aperto_annuale_b') || $centroBenessere->aperto_annuale_b ? 'checked' : '' }} class="beautiful_checkbox">
        <label for="aperto_annuale_b">
          annuale
        </label>
      </div>
    </div>

       <!-- a pagamento -->
    <div class="row">
      <div class="col-md-12">
        <label>A pagamento</label>
      </div>
    </div>
    <div class="row" style="padding-top: 0;">
      <div class="col-md-2">
         <select required id="a_pagamento" class="form-control" name="a_pagamento">
          @foreach (['si','no'] as $value)
            <option value="{{$id}}" {{old('a_pagamento') == $id || $centroBenessere->a_pagamento == $id ? 'selected' : '' }}>{{$value}}</option>
          @endforeach
          </select>
      </div>
    </div>


     <div class="row">
      <label class="col-md-2">Posizione:</label>
      <div class="col-md-3">
        <input type="checkbox" name="in_hotel" id="in_hotel" value="1" {{ old('in_hotel') || $centroBenessere->in_hotel ? 'checked' : '' }} class="beautiful_checkbox">
        <label for="in_hotel">
          in hotel
        </label>
      </div>
      <label class="col-md-1">a</label>
      <div class="col-md-2">
        <input type="text" name="distanza_hotel" id="distanza_hotel" class="form-control input_distanza_hotel"  value="{{old('distanza_hotel') != '' ?  old('distanza_hotel') :  $centroBenessere->distanza_hotel}}">
      </div>
      <label class="col-md-2"> metri dall'hotel</label>
    </div>

     <!-- eta minima per accedere -->
    <div class="row">
      <label class="col-md-3">Età minima per accedere</label>
      <div class="col-md-5">
        <input type="text" name="eta_minima" id="eta_minima" class="form-control input_eta_minima"  value="{{old('eta_minima') != '' ?  old('eta_minima') :  $centroBenessere->eta_minima}}">
      </div>
      <label class="col-md-1">anni</label>
    </div>

    <div class="row">
      <div class="col-md-12">
        <label>CARATTERISTICHE:</label>
      </div>
    </div>
    @php
      $row_carr = array_chunk(Utility::getFsCaratteristicheCentroBenessere(), 4, true);
    @endphp
    @foreach ($row_carr as $n_row => $caratteristicheCentroBenessere_in_row)
      <div class="row">
        @foreach ($caratteristicheCentroBenessere_in_row as $carr => $carr_view)
          <div class="col-md-3">
            <input type="checkbox" name="{{$carr}}" id="{{$carr}}" value="1" {{ old($carr) || $centroBenessere->$carr ? 'checked' : '' }} class="beautiful_checkbox">
            <label for="{{$carr}}">
              {{$carr_view}}
            </label>
          </div>
        @endforeach
      </div>
    @endforeach

    <div class="row">
      <div class="col-md-12">
        <label>Peculiarità</label>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <textarea name="peculiarita" class="form-control">{{old('peculiarita') != '' ?  old('peculiarita') :  $centroBenessere->peculiarita}}</textarea>
      </div>
    </div>

    <div class="row">
    <div class="col-md-12">
      <label>Obbligo di prenotazione</label>
    </div>
  </div>
  <div class="row">
    <div class="col-md-2">
      <select required id="obbligo_prenotazione" class="form-control" name="obbligo_prenotazione">
        @foreach (['si','no'] as $value)
          <option value="{{$id}}" {{old('obbligo_prenotazione') == $id || $centroBenessere->obbligo_prenotazione == $id ? 'selected' : '' }}>{{$value}}</option>
        @endforeach
      </select>
    </div>
  </div>

  <!-- uso in esclusiva -->
  <div class="row">
    <div class="col-md-12">
      <label>Uso in esclusiva</label>
    </div>
  </div>
  <div class="row" style="padding-top: 0;">
    <div class="col-md-2">
       <select required id="uso_esclusivo" class="form-control" name="uso_esclusivo">
        @foreach (['seleziona', 'si','no','a richiesta'] as $value)
          <option value="{{$id}}" {{old('uso_esclusivo') == $id || $centroBenessere->uso_esclusivo == $id ? 'selected' : '' }}>{{$value}}</option>
        @endforeach
      </select>
    </div>
  </div>

  </div> {{-- elenco_campi_benessere --}}


  <div class="spacerBlu"></div>


  {{-- Elenco gruppiServizi --}}

  @foreach ($gruppiServizi as $gruppo)
    <div class="row">
      <div class="col-md-12">
        <label>{{$gruppo->nome}}</label>
      </div>
    </div>
    <div class="elenco_servizi">
      @foreach ($gruppo->elenco_servizi as $servizio)
        <div class="row">
          <div class="col-md-3">
            <input type="checkbox" name="{{$servizio->id}}" id="{{$servizio->id}}" value="1" {{ old($servizio->id) || array_key_exists($servizio->id, $ids_servizi_associati) ? 'checked' : '' }}  class="beautiful_checkbox">
            <label for="{{$servizio->id}}">
              {{$servizio->nome}}
            </label>
          </div>
          <div class="col-md-3">
            <input type="text" 
                    name="nota_servizio_{{$servizio->id}}" 
                    id="nota_servizio_{{$servizio->id}}" 
                    class="form-control"  
                    value="{{ 
                      old('nota_servizio_'.$servizio->id) != '' ?  old('nota_servizio_'.$servizio->id) : (array_key_exists($servizio->id, $ids_servizi_associati) ? $ids_servizi_associati[$servizio->id] : '')  }} ">
          </div>  
        </div>
      @endforeach
    </div>
  @endforeach

</form>


@endsection

