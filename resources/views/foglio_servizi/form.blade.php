@extends('layouts.coreui.crm_lara6')


@section('js')
	<script type="text/javascript" charset="utf-8">
		
		jQuery(document).ready(function(){

        /* toggle visibility 9 pti di forza*/
        $('#pti_anno_prec').change(function () {                
          $('#elenco_pti_forza').toggle(!this.checked);
          $('#note_pti_forza').toggle(this.checked);
        }).change(); //ensure visible state matches initially
      
        /* toggle visibility apertura reception */
        $('#h_24').change(function () {                
          $('#orari_reception').toggle(!this.checked);
        }).change(); //ensure visible state matches initially


        /* toggle visibility date aperture / annuale */
        $('#apertura').change(function(){
            if($('#apertura').val() == 'a') {
                $('#opzioni_apertura').hide(); 
            } else {
                $('#opzioni_apertura').show(); 
            } 
        }).change();
      

        /* toggle visibility numeri */
        $('#numeri_anno_prec').change(function () {                
           $('#elenco_numeri_locali').toggle(!this.checked);
        }).change(); //ensure visible state matches initially


        /* toggle visibility apertura reception */
        $('#h_24').change(function () {                
           $('.orari_reception').toggle(!this.checked);
        }).change(); //ensure visible state matches initially


        /* toggle visibility orari dei pasti*/
        $('#pasti_anno_prec').change(function () {                
           $('#elenco_orario_pasti').toggle(!this.checked);
        }).change(); //ensure visible state matches initially



        /* toggle visibility piscina */
        $('#piscina').change(function () {                
           $('#elenco_campi_piscina').toggle(this.checked);
           $('#importa_campi_piscina').toggle(this.checked);
           // se apro la sezione piscina "metto il check al servizio piscina in servizi in hotel"
           $("#servizio_94").prop('checked', this.checked);

           // visualizzo il messaggio di obbligatorietà delle note
           $("#obbligatorio_piscina").toggle(this.checked);

        }).change(); //ensure visible state matches initially

        $('#servizio_94').change(function () {
             // visualizzo il messaggio di obbligatorietà delle note
           $("#obbligatorio_piscina").toggle(this.checked);
        }).change(); //ensure visible state matches initially


        /* toggle visibility benessere */
        $('#benessere').change(function () {                
           $('#elenco_campi_benessere').toggle(this.checked);
           $('#importa_campi_benessere').toggle(this.checked);
           // se apro la sezione benessere "metto il check al servizio benessere in servizi in hotel"
           $("#servizio_96").prop('checked', this.checked);

           // visualizzo il messaggio di obbligatorietà delle note
           $("#obbligatorio_benessere").toggle(this.checked);

        }).change(); //ensure visible state matches initially

        $('#servizio_96').change(function () {
             // visualizzo il messaggio di obbligatorietà delle note
           $("#obbligatorio_benessere").toggle(this.checked);
        }).change(); //ensure visible state matches initially


        //  apertura stagionale date
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



       $(".add_servizio").click(function(event){
          
          event.preventDefault();
          var gruppo_id = $(this).attr('id');
          var value = $("#servizio_add_"+gruppo_id).val();


          if (value == '') {
          
            return false;
          
          } else {

            var foglio_id = '{{$foglio->id}}';  
            var data = {
                gruppo_id: gruppo_id,
                nome_servizio: value,
                foglio_id:foglio_id,
                };
            
            $.ajax({
                url: "{{ route('add-servizio-aggiuntivo-foglio-servizi-ajax') }}",
                type: 'POST',
                data: data,
                success: function(msg) {
                    $(msg).appendTo( $('#serv_agg_placeholder_'+gruppo_id) );
                    $("#servizio_add_"+gruppo_id).val('');
                }
              });
          
          }
          
          });

       /*
        http://stackoverflow.com/questions/9344306/jquery-click-doesnt-work-on-ajax-generated-content
         */
        $('body').on('click', '.del_aggiuntivo', function (event) {
            event.preventDefault();
            var id = $(this).attr('id');
            if (confirm('Sei sicuro di voler eliminare questo servizio ?')) {
              data = {
                id:id
              };

              $.ajax({
                  url: "{{ route('del-servizio-aggiuntivo-foglio-servizi-ajax') }}",
                  type: 'POST',
                  data: data,
                  success: function(msg) { 
                      if (msg == 'ok') {
                        $("#row_"+id).fadeOut();
                      } else  {
                        alert('Errore');
                      }
                  }
                });

            } /* end if*/

        }); /* /del_aggiuntivo */


		});
	


     // ===== Scroll to Top ==== 
      $(window).scroll(function() {
          if ($(this).scrollTop() >= 50) {        // If page is scrolled more than 50px
              $('#return-to-top').fadeIn(200);    // Fade in the arrow
          } else {
              $('#return-to-top').fadeOut(200);   // Else fade out the arrow
          }
      });
      $('#return-to-top').click(function() {      // When arrow is clicked
          $('body,html').animate({
              scrollTop : 0                       // Scroll to top of body
          }, 500);
      });


      // ===== Go to Bottom ==== 
      $(window).scroll(function() {
          var $h = $(document).height();
          var $limit = $h -50;
          //console.log($limit);
          if ($(this).scrollTop() >= 50 && $(this).scrollTop() < $limit) {        // If page is scrolled more than 50px
              $('#go-to-bottom').fadeIn(200);    // Fade in the arrow
          }  
          else {
              $('#go-to-bottom').fadeOut(200);   // Else fade out the arrow
          }
      });
      $('#go-to-bottom').click(function() {      // When arrow is clicked
          $('body,html').animate({
              scrollTop: $(document).height()                    // Scroll to top of body
          }, 500);
      });
	</script>
	
@endsection

@section('content')
<!-- Return to Top -->
<a href="javascript:" id="return-to-top"><i class="fa fa-chevron-up"></i></a>
<!-- Go to Bottom --> 
<a href="javascript:" id="go-to-bottom"><i class="fa fa-chevron-down"></i></a>
<div class="spinner_lu" style="display:none;"></div>
<form action="{{ route('foglio-servizi.update',$foglio->id) }}" method="post" id="form_foglio_servizi">
  @csrf
  @method('PUT')
  <div class="row mt-2 row justify-content-between">
      <div class="col-lg-5">
      <div class="card card-accent-primary text-center">
          <div class="card-header font-weight-bold">MODULO SERVIZI HOTEL</div>
          <div class="card-body">
              <div class="form-group">
                <label for="id_commerciale">Nome Agente</label>
                <label  class="form-check-label font-weight-bold">{{ strtoupper($commerciale_contratto) }}</label>
              </div>
              <div class="row form-group">
                <div class="col-md-6 text-left">
                  <label class="font-weight-bold">NOME HOTEL</label>
                  <input type="text" name="nome_hotel" id="nome_hotel" class="form-control"  value="{{old('nome_hotel') != '' ?  old('nome_hotel') :  $foglio->nome_hotel}}">
                </div>
                <div class="col-md-6 text-left">
                  <label class="font-weight-bold">SMS</label>
                  <input type="text" name="sms" id="sms" class="form-control"  value="{{old('sms') != '' ?  old('sms') :  $foglio->sms}}">
                </div>
            </div>
            <div class="row form-group ">
              <div class="col-md-6 text-left">
                <label class="font-weight-bold">LOCALITA</label>
                <input type="text" name="localita" id="localita" class="form-control"  value="{{old('localita') != '' ?  old('localita') :  $foglio->localita}}">
              </div>
              <div class="col-md-6 text-left">
                <label class="font-weight-bold">WHATSAPP</label>
                <input type="text" name="whatsapp" id="whatsapp" class="form-control"  value="{{old('whatsapp') != '' ?  old('whatsapp') :  $foglio->whatsapp}}">
              </div>
            </div>
            <div class="row form-group ">
              <div class="col-md-6 text-left">
                <label class="font-weight-bold">ANNO STAGIONE</label>
                <input type="text" name="stagione" id="stagione" class="form-control"  value="{{old('stagione') != '' ?  old('stagione') :  $foglio->stagione}}">
              </div>
              <div class="col-md-6 text-left">
                <label class="font-weight-bold">SKYPE</label>
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
      <label class="font-weight-bold">
          PREZZO MIN:
      </label>
      <input type="text" name="prezzo_min" id="prezzo_min" class="form-control"  value="{{old('prezzo_min') != '' ?  old('prezzo_min') :  $foglio->prezzo_min}}">
    </div>

    <div class="col-md-6">
      <label class="font-weight-bold">
         PREZZO MAX:
      </label>
      <input type="text" name="prezzo_max" id="prezzo_max" class="form-control"  value="{{old('prezzo_max') != '' ?  old('prezzo_max') :  $foglio->prezzo_max}}">
    </div>
  </div>

  <div class="spacerBlu"></div>

   <div class="row form-group">
    <div class="col-md-12">
      <label class="font-weight-bold">LA STRUTTURA ORGANIZZA:</label>
    </div>
  </div>
  
  <div class="row form-group">
    <div class="col-md-3 form-check">
      <input type="checkbox" name="organizzazione_comunioni" class="organizzazione" id="organizzazione_comunioni" value="1" class="beautiful_checkbox" {{ old('organizzazione_comunioni') || $foglio->organizzazione_comunioni ? 'checked' : '' }}>  
      <label for="organizzazione_comunioni" class="font-weight-bold">comunioni</label> 
    </div>
    <div class="col-md-3 form-check">
      <input type="checkbox" name="organizzazione_cresime" class="organizzazione" id="organizzazione_cresime" value="1" class="beautiful_checkbox" {{ old('organizzazione_cresime') || $foglio->organizzazione_cresime ? 'checked' : '' }}>
      <label for="organizzazione_cresime" class="font-weight-bold">cresime</label> 
    </div>
    <div class="col-md-3 form-check">
      <input type="checkbox" name="organizzazione_matrimoni" class="organizzazione" id="organizzazione_matrimoni" value="1" class="beautiful_checkbox" {{ old('organizzazione_matrimoni') || $foglio->organizzazione_matrimoni ? 'checked' : '' }}>
      <label for="organizzazione_matrimoni" class="font-weight-bold">matrimoni</label> 
    </div>
  </div>

  <div id="note_organizzazione_matrimoni">
    <div class="row">
      <div class="col-md-12">
        <label class="font-weight-bold">Note</label>
      </div>
    </div>
    <div class="row form-group">
      <div class="col-md-12">
        <textarea name="note_organizzazione_matrimoni" class="form-control">{{old('note_organizzazione_matrimoni') != '' ?  old('note_organizzazione_matrimoni') :  $foglio->note_organizzazione_matrimoni}}</textarea>
      </div>
    </div>
  </div>

  <div class="spacerBlu"></div>

  <div class="row form-group">
    <div class="col-md-12">
      <label class="font-weight-bold">9 PUNTI DI FORZA/SERVIZI (MAX 28 CARATTERI A SERVIZIO):</label>
    </div>
  </div>

  <div class="row form-group" style="">
    <div class="col-md-12">
      <input type="checkbox" name="pti_anno_prec" id="pti_anno_prec" value="1" {{ old('pti_anno_prec') || $foglio->pti_anno_prec ? 'checked' : '' }} class="beautiful_checkbox">       
      <label for="pti_anno_prec"  class="font-weight-bold">Stessi punti di forza anno precedente:</label>
    </div>
  </div>
    
  <div id="note_pti_forza">
    <div class="row">
      <div class="col-md-12">
        <label class="font-weight-bold">Note sui punti di forza</label>
      </div>
    </div>
    <div class="row form-group">
      <div class="col-md-12">
        <textarea name="note_pf" class="form-control">
{{old('note_pf') != '' ?  old('note_pf') :  $foglio->note_pf}}</textarea>
      </div>
    </div>
  </div>


  <div id="elenco_pti_forza">
    <div class="row form-group">
      
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

  <div class="row form-group">
     <div class="col-md-4">
        <label class="font-weight-bold">Tipologia</label>
        <select required id="tipo" class="form-control" name="tipo">
          @foreach (Utility::getFsTipologia() as $tipo_id => $tipo)
            <option value="{{$tipo_id}}" {{old('tipo') == $tipo_id || $foglio->tipo == $tipo_id ? 'selected' : '' }}>{{$tipo}}</option>
          @endforeach
        </select>
     </div>

     <div class="col-md-4">
        <label class="font-weight-bold">Categoria</label>
        <select required id="categoria" class="form-control" name="categoria">
          @foreach (Utility::getHotelCategoria() as $categoria_id => $categoria)
            <option value="{{$categoria_id}}" {{old('categoria') == $categoria_id || $foglio->categoria == $categoria_id ? 'selected' : '' }}>{!!$categoria!!}</option>
          @endforeach
        </select>
     </div>


     <div class="col-md-4">
        <label class="font-weight-bold">Apertura</label>
        <select required class="form-control" name="apertura" id="apertura">
          @foreach (Utility::getHotelApertura() as $apertura_id => $apertura)
            <option value="{{$apertura_id}}" {{old('apertura') == $apertura_id || $foglio->apertura == $apertura_id ? 'selected' : '' }}>{{$apertura}}</option>
          @endforeach
        </select>
     </div>
  </div>

  <div id="opzioni_apertura">

    <div class="spacerBlu"></div>
    
    <div class="row form-group aperture">
      <label class="font-weight-bold col-md-2 col-form-label">DATE APERTURA HOTEL</label> 
      <label class="font-weight-bold col-md-2 col-xl-1 col-form-label">DAL</label>
      <div class="col-md-3  col-xl-2">
          <div class="input-group margin-bottom-sm">
            <div class="input-group-prepend"><span class="input-group-text" id="btnGroupAddon"><i class="far fa-calendar-alt"></i></span></div>
            <input type="text" id="dal" name="dal" value="" class="form-control">
          </div>
      </div>
      <label class="font-weight-bold col-md-2 col-xl-1 col-form-label">AL</label>
      <div class="col-md-3  col-xl-2">
         <div class="input-group margin-bottom-sm">
            <div class="input-group-prepend"><span class="input-group-text" id="btnGroupAddon"><i class="far fa-calendar-alt"></i></span></div>
            <input type="text" id="al" name="al" value="" class="form-control">
          </div>
      </div>
    </div>

     <div class="row form-group">
      <div class="col-md-12">
        (In caso siate aperti in periodi dell’anno al di fuori della stagione estiva indicate quali):
      </div>
    </div>

    <div class="row form-group altre_aperture">
      <div class="col-xl-2 col-md-6">
        <input type="checkbox" name="fiere" id="fiere" value="1" {{ old('fiere') || $foglio->fiere ? 'checked' : '' }}  class="beautiful_checkbox"> 
        <label for="fiere" class="font-weight-bold">
          fiere
        </label>
      </div>
      <div class="col-xl-2 col-md-6">
        <input type="checkbox" name="pasqua" id="pasqua" value="1" {{ old('pasqua') || $foglio->pasqua ? 'checked' : '' }}  class="beautiful_checkbox">
        <label for="pasqua" class="font-weight-bold">
           pasqua
        </label>
      </div>
      <div class="col-xl-2 col-md-6">
        <input type="checkbox" name="capodanno" id="capodanno" value="1" {{ old('capodanno') || $foglio->capodanno ? 'checked' : '' }}  class="beautiful_checkbox"> 
        <label for="capodanno" class="font-weight-bold">
          capodanno
        </label>
      </div>
      <div class="col-xl-2 col-md-6">
        <input type="checkbox" name="aprile_25" id="aprile_25" value="1" {{ old('aprile_25') || $foglio->aprile_25 ? 'checked' : '' }}  class="beautiful_checkbox">
        <label for="aprile_25" class="font-weight-bold">
           25 aprile
        </label>
      </div>
      <div class="col-xl-2 col-md-6">
        <input type="checkbox" name="maggio_1" id="maggio_1" value="1" {{ old('maggio_1') || $foglio->maggio_1 ? 'checked' : '' }}  class="beautiful_checkbox">
        <label for="maggio_1" class="font-weight-bold">
           1° maggio
        </label>
      </div>
    </div>

    <div class="row form-group">
      <label class="col-md-2 font-weight-bold">
        altro
      </label>
      <div class="col-md-5">
        <input type="text" name="altra_apertura" id="altra_apertura" class="form-control"  value="{{old('altra_apertura') != '' ?  old('altra_apertura') :  $foglio->altra_apertura}}">
      </div>
    </div>
    
  </div> {{-- opzioni_apertura --}}

  <div class="spacerBlu"></div>

  <div class="row form-group">
    <label class="col-md-3 font-weight-bold">
      N. locali e posti letto
        </label>
    </label>
    <input type="hidden" name="numeri_anno_prec" value=0>
    <div class="col-md-5">
      <input type="checkbox" 
      name="numeri_anno_prec" 
      id="numeri_anno_prec" 
      value="1" 
      {{ old('numeri_anno_prec') == '0' ? '' : (old('numeri_anno_prec') == 1 || $foglio->numeri_anno_prec ? 'checked' : '') }} class="beautiful_checkbox">       
    <label for="numeri_anno_prec" class="font-weight-bold">Stessi numeri anno precedente</label>
    </div>
  </div>

  <div id="elenco_numeri_locali">
    <div class="row form-group">

      <div class="col-xl-3 col-md-6">
        <label class="font-weight-bold">
            NUMERO CAMERE: 
        <input type="text" name="n_camere" id="n_camere" class="form-control"  value="{{old('n_camere') != '' ?  old('n_camere') :  $foglio->n_camere}}">
      </div>

      <div class="col-xl-3 col-md-6">
        <label class="font-weight-bold">
            NUMERO APPARTAMENTI:
        </label>
        <input type="text" name="n_app" id="n_app" class="form-control"  value="{{old('n_app') != '' ?  old('n_app') :  $foglio->n_app}}">
      </div>

      <div class="col-xl-3 col-md-6">
        <label class="font-weight-bold">
            NUMERO SUITE:
        </label>
        <input type="text" name="n_suite" id="n_suite" class="form-control"  value="{{old('n_suite') != '' ?  old('n_suite') :  $foglio->n_suite}}">
      </div>

      <div class="col-xl-3 col-md-6">
        <label class="font-weight-bold">
            NUMERO LETTI:
        </label>
        <input type="text" name="n_letti" id="n_letti" class="form-control"  value="{{old('n_letti') != '' ?  old('n_letti') :  $foglio->n_letti}}">
      </div>
    </div>
  </div>

  <div class="spacerBlu"></div>

  <div class="row form-group">
    <input type="hidden" name="h_24" value=0>

    <label class="font-weight-bold col-md-6 col-xl-2 col-form-label">
        ORARIO APERTURA RECEPTION
    </label>
    <div class="col-md-6 col-xl-2">
      <input type="checkbox" name="h_24" id="h_24" value="1" {{ old('h_24') == '0' ? '' : (old('h_24') || $foglio->h_24 ? 'checked' : '') }} class="beautiful_checkbox">
      <label for="h_24" class="font-weight-bold col-form-label">
         24 ore su 24
      </label>
    </div>   
    <label class="col-md-2 col-xl-1 orari_reception font-weight-bold col-form-label text-right">
        dalle
    </label>
    <div class="col-md-2 col-xl-1 orari_reception">
      <select required id="rec_dalle_ore" class="form-control" name="rec_dalle_ore">
        @foreach (Utility::getFsOre() as $id => $value)
          <option value="{{$id}}" {{old('rec_dalle_ore') == $id || $foglio->rec_dalle_ore == $id ? 'selected' : '' }}>{{$value}}</option>
        @endforeach
      </select>
    </div>
    <div class="col-md-2 col-xl-1 orari_reception">
      <select required id="rec_dalle_minuti" class="form-control" name="rec_dalle_minuti">
        @foreach (Utility::getFsMinuti() as $id => $value)
          <option value="{{$id}}" {{old('rec_dalle_minuti') == $id || $foglio->rec_dalle_minuti == $id ? 'selected' : '' }}>{{$value}}</option>
        @endforeach
      </select>
    </div>
    <label class="col-md-2 col-xl-1 orari_reception font-weight-bold col-form-label text-right">
        alle
    </label>
    <div class="col-md-2 col-xl-1 orari_reception">
      <select required id="rec_alle_ore" class="form-control" name="rec_alle_ore">
        @foreach (Utility::getFsOre() as $id => $value)
          <option value="{{$id}}" {{old('rec_alle_ore') == $id || $foglio->rec_alle_ore == $id ? 'selected' : '' }}>{{$value}}</option>
        @endforeach
      </select>
    </div>
    <div class="col-md-2 col-xl-1 orari_reception">
      <select required id="rec_alle_minuti" class="form-control" name="rec_alle_minuti">
        @foreach (Utility::getFsMinuti() as $id => $value)
          <option value="{{$id}}" {{old('rec_alle_minuti') == $id || $foglio->rec_alle_minuti == $id ? 'selected' : '' }}>{{$value}}</option>
        @endforeach
      </select>
    </div>
  </div> {{-- row --}}

  <div class="row form-group">
    <div class="col-md-6">
      <label class="font-weight-bold">
          ORARIO DI CHECK IN:
      </label>
      <input type="text" name="checkin" id="checkin" class="form-control"  value="{{old('checkin') != '' ?  old('checkin') :  $foglio->checkin}}">
    </div>

    <div class="col-md-6">
      <label class="font-weight-bold">
         ORARIO DI CHECK OUT:
      </label>
      <input type="text" name="checkout" id="checkout" class="form-control"  value="{{old('checkout') != '' ?  old('checkout') :  $foglio->checkout}}">
    </div>
  </div>

  <div class="spacerBlu"></div>

  <div class="row form-group">
    <input type="hidden" name="pasti_anno_prec" value=0>

    <label class="font-weight-bold col-md-3">
        ORARIO DEI PASTI
    </label>
    <div class="col-md-5">
      <input type="checkbox" name="pasti_anno_prec" id="pasti_anno_prec" value="1" {{old('pasti_anno_prec') == 0 ? '' : (old('pasti_anno_prec') || $foglio->pasti_anno_prec ? 'checked' : '') }}>
      <label for="pasti_anno_prec" class="col-form-label font-weight-bold">
          Stessi orari anno precedente
      </label>
    </div>
  </div>

   <div class="row form-group" id="elenco_orario_pasti">
     <div class="col-xl-4 col-md-12">
        <div class="row form-group">
          <label class="col-md-12 font-weight-bold col-form-label">Colazione</label>
          <div class="col-md-2 font-weight-bold">
            <select required id="colazione_dalle_ore" class="form-control" name="colazione_dalle_ore">
            @foreach (Utility::getFsOre() as $id => $value)
              <option value="{{$id}}" {{old('colazione_dalle_ore') == $id || $foglio->colazione_dalle_ore == $id ? 'selected' : '' }}>{{$value}}</option>
            @endforeach
          </select>
          </div>
          <div class="col-md-2 font-weight-bold">
            <select required id="colazione_dalle_minuti" class="form-control" name="colazione_dalle_minuti">
              @foreach (Utility::getFsMinuti() as $id => $value)
                <option value="{{$id}}" {{old('colazione_dalle_minuti') == $id || $foglio->colazione_dalle_minuti == $id ? 'selected' : '' }}>{{$value}}</option>
              @endforeach
            </select>
          </div>
          <label class="col-xl-2 col-md-1 font-weight-bold  col-form-label">
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

     <div class="col-xl-4 col-md-12">
        <div class="row form-group">
          <label class="col-md-12 font-weight-bold col-form-label">Pranzo</label>
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
          <label class="col-xl-2 col-md-1 font-weight-bold col-form-label">
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


     <div class="col-xl-4 col-md-12">
        <div class="row form-group">
          <label class="col-md-12 font-weight-bold col-form-label">Cena</label>
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
          <label class="col-xl-2 col-md-1 font-weight-bold col-form-label">
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

  <div class="row form-group">
    <div class="col-md-12">
      <label class="font-weight-bold">TRATTAMENTI PRINCIPALI:</label>
    </div>
  </div>

  <div class="row form-group">
    @foreach (Utility::getFsTrattamentiENote() as $key => $val)
      @if (strpos($key,'note_') !== false)
        <div class="col-xl-9 col-md-8 mt-3">
          <textarea name="{{$key}}" placeholder="Elenca i servizi inclusi" class="form-control">{{old($key) != '' ?  old($key) :  $foglio->$key}}</textarea>
        </div>
      @else
        <div class="col-xl-3 col-md-4 mt-3">
          <input type="hidden" name="{{$key}}" value="0">
          <input type="checkbox" name="{{$key}}" id="{{$key}}" value="1" {{ old($key) == '0' ? '' : (old($key) || $foglio->$key ? 'checked' : '') }}  class="beautiful_checkbox"> 
          <label for="{{$key}}" class="font-weight-bold  col-form-label">
          {{$val}}
          </label>
        </div>
      @endif
    @endforeach
  </div>

  <div class="spacerBlu"></div>

  <div class="row form-group">
    <div class="col-md-12">
      <label class="font-weight-bold">SI CHIEDE CAPARRA AL MOMENTO DELLA PRENOTAZIONE?</label>
    </div>
  </div>
  <div class="row form-group">
    <div class="col-xl-1 col-md-3">
      <select required id="caparra" class="form-control" name="caparra">
        @foreach (['seleziona', 'si','no'] as $value)
          @if ( old('caparra') !== null)   
            <option value="{{$value}}" {{old('caparra') == $value ? 'selected' : '' }}>{{$value}}</option>
          @else
            <option value="{{$value}}" {{ $foglio->caparra == $value ? 'selected' : '' }}>{{$value}}</option>
          @endif
        @endforeach
      </select>
    </div>
    <label class="offset-xl-1 offset-md-1 col-xl-1 col-md-2 font-weight-bold col-form-label">altro</label>
    <div class="col-xl-6 col-md-5 ">
      <input type="text" name="altra_caparra" id="altra_caparra" class="form-control" value="{{old('altra_caparra') != '' ?  old('altra_caparra') :  $foglio->altra_caparra}}">
    </div>
  </div>
  
  <div class="spacerBlu"></div>

  <div class="row form-group">
    <div class="col-md-12">
      <label class="font-weight-bold">PAGAMENTI ACCETTATI:</label>
    </div>
  </div>
  <div class="row form-group">
    @foreach (Utility::getFsPagamenti() as $key => $val)
      <input type="hidden" name="{{$key}}" value="0">
      <div class="col-xl-2 col-md-4">
        <input type="checkbox" name="{{$key}}" id="{{$key}}" value="1" {{ old($key) == '0' ? '' : (old($key) || $foglio->$key ? 'checked' : '') }}  class="beautiful_checkbox"> 
        <label for="{{$key}}" class="font-weight-bold">
        {{$val}}
        </label>
      </div>
    @endforeach
  </div>
  <div class="row">
    <div class="col-md-12">
      <label class="font-weight-bold">Note pagamenti</label>
    </div>
  </div>
  <div class="row form-group" style="padding-top: 0;">
    <div class="col-md-12">
      <textarea name="note_pagamenti" class="form-control">{{old('note_pagamenti') != '' ?  old('note_pagamenti') :  $foglio->note_pagamenti}}</textarea>
    </div>
  </div>

  <div class="spacerBlu"></div>

  <div class="row form-group">
    <div class="col-md-12">
      <label class="font-weight-bold">LINGUE PARLATE:</label>
    </div>
  </div>
  <div class="row form-group">
    @foreach (Utility::getFsLingue() as $key => $val)
      <input type="hidden" name="{{$key}}" value="0">
      <div class="col-xl-2 col-md-4">
        <input type="checkbox" name="{{$key}}" id="{{$key}}" value="1" {{ old($key) == '0' ? '' : ( old($key) || $foglio->$key ? 'checked' : '' )}}  class="beautiful_checkbox"> 
        <label for="{{$key}}" class="font-weight-bold">
        {{$val}}
        </label>
      </div>
    @endforeach
  </div>
  <div class="row">
    <div class="col-md-12">
      <label class="font-weight-bold">Altro</label>
    </div>
  </div>
  <div class="row form-group">
    <div class="col-md-12">
      <textarea name="altra_lingua" class="form-control">{{old('altra_lingua') != '' ?  old('altra_lingua') :  $foglio->altra_lingua}}</textarea>
    </div>
  </div>

  <div class="spacerBlu"></div>

  <div class="row form-group">
    <div class="col-xl-2 col-md-4">  
      <label class="font-weight-bold">
         INFO PISCINA
      </label>
    </div>
    <div class="col-xl-4 col-md-4">
      <input type="hidden" name="piscina" value="0">
      <input type="checkbox" name="piscina" id="piscina" value="1" {{ old('piscina') == '0' ? '' : (old('piscina') || $foglio->piscina ? 'checked' : '') }} class="beautiful_checkbox">
      <label for="piscina" class="font-weight-bold">
        Ho una piscina
      </label>
    </div>
  </div>


  <div id="elenco_campi_piscina">
      
    <div class="row form-group">
      <div class="col-md-6">
        <label class="font-weight-bold">
            superficie (mq.)
        </label>
        <input class="form-control misure" maxlength="3" name="sup" type="text" value="{{old('sup') != '' ?  old('sup') :  $infoPiscina->sup}}" id="sup">
      </div>
    </div>

    <div class="row form-group">
      <div class="col-md-4">
        <label class="font-weight-bold">
            altezza unica (cm.)
        </label>
        <input id="h" class="form-control misure" maxlength="3" name="h" type="text" value="{{old('h') != '' ?  old('h') :  $infoPiscina->h}}">
      </div>
      <div class="col-md-4">
        <label class="font-weight-bold">
            altezza min. (cm.)
        </label>
        <input id="h_min" class="form-control misure" maxlength="3" name="h_min" type="text" value="{{old('h_min') != '' ?  old('h_min') :  $infoPiscina->h_min}}">
      </div>
      <div class="col-md-4">
        <label class="font-weight-bold">
            altezza max. (cm.)
        </label>
          <input id="h_max" class="form-control misure" maxlength="3" name="h_max" type="text" value="{{old('h_max') != '' ?  old('h_max') :  $infoPiscina->h_max}}">
      </div>
    </div>

    <div class="row form-group">
      <label class="col-xl-3 col-md-2 font-weight-bold">
          PERIODO APERTURA GGGGG
      </label>
      <label class="col-xl-1 col-md-1 font-weight-bold col-form-label text-right">
          da
      </label>
      <div class="col-xl-2 col-md-3 font-weight-bold">
        <select required id="aperto_dal" class="form-control" name="aperto_dal">
          @foreach (Utility::getFsMesi() as $id => $value)
            @if (old('aperto_dal'))
            <option value="{{$id}}" {{ old('aperto_dal') == $id ? 'selected' : '' }}>{{$value}}</option>
            @else
            <option value="{{$id}}" {{ $infoPiscina->aperto_dal == $id ? 'selected' : '' }}>{{$value}}</option>
            @endif
          @endforeach
        </select>
      </div>
      <label class="col-xl-1 col-md-1 font-weight-bold col-form-label text-right">
          a
      </label>
      <div class="col-xl-2 col-md-3">
        <select required id="aperto_al" class="form-control" name="aperto_al">
          @foreach (Utility::getFsMesi() as $id => $value)
           @if (old('aperto_al'))
            <option value="{{$id}}" {{ old('aperto_al') == $id ? 'selected' : '' }}>{{$value}}</option>
            @else
            <option value="{{$id}}" {{ $infoPiscina->aperto_al == $id ? 'selected' : '' }}>{{$value}}</option>
            @endif
          @endforeach
        </select>
      </div>
      <div class="col-xl-2 col-md-2">
        <input type="hidden" name="aperto_annuale" value="0">
        <input type="checkbox" name="aperto_annuale" id="aperto_annuale" value="1" {{ old('aperto_annuale') == '0' ? '' : (old('aperto_annuale') || $infoPiscina->aperto_annuale ? 'checked' : '') }} class="beautiful_checkbox">
        <label for="aperto_annuale" class="font-weight-bold col-form-label">
          annuale
        </label>
      </div>
    </div>

    <div class="row form-group">
      <div class="col-md-12">
        <label class="font-weight-bold">POSIZIONE:</label>
      </div>
    </div>
    <div class="row form-group posizione_piscina">
      @foreach (Utility::getFsPosizionePiscina() as $key => $val)
      <div class="col-xl-2 col-md-4">
        <input type="radio" name="posizione" id="{{$key}}" value="{{$val}}" {{ old($key) || $infoPiscina->posizione == $val ? 'checked' : '' }} class=""> 
        <label for="{{$key}}" class="font-weight-bold">
        {{$val}}
        </label>
      </div>
      @endforeach
    </div>

    <div class="row form-group">
      <div class="col-md-12">
        <label class="font-weight-bold">CARATTERISTICHE:</label>
      </div>
    </div>
    @php
      $row_carr = array_chunk(Utility::getFsCaratteristichePiscina(), 4, true);
    @endphp
    @foreach ($row_carr as $n_row => $caratteristichePiscina_in_row)
      <div class="row form-group">
        @foreach ($caratteristichePiscina_in_row as $carr => $carr_view)
          <input type="hidden" name="{{$carr}}" value="0">
          <div class="col-xl-3 col-md-6">
            <input type="checkbox" name="{{$carr}}" id="{{$carr}}" value="1" {{ old($carr) == '0' ? '' : (old($carr) || $infoPiscina->$carr ? 'checked' : '') }} class="beautiful_checkbox">
            <label for="{{$carr}}" class="font-weight-bold">
              {{$carr_view}}
            </label>
          </div>
        @endforeach
      </div>
    @endforeach

    <div class="row form-group">
      <div class="col-md-6">
        <label class="font-weight-bold">
           N. lettini prendisole
        </label>
        <input id="lettini_dispo" class="form-control" maxlength="3" name="lettini_dispo" type="text" value="{{old('lettini_dispo') != '' ?  old('lettini_dispo') :  $infoPiscina->lettini_dispo}}">
      </div>
      <div class="col-md-3">
        <label class="font-weight-bold">
            N. ore esposta al sole
        </label>
        <input id="espo_sole" class="form-control" maxlength="3" name="espo_sole" type="text" value="{{old('espo_sole') != '' ?  old('espo_sole') :  $infoPiscina->espo_sole}}">
      </div>
      <div class="col-md-3">
        <input type="hidden" name="espo_sole_tutto_giorno" value="0">
        <input type="checkbox" name="espo_sole_tutto_giorno" id="espo_sole_tutto_giorno" value="1" {{ old('espo_sole_tutto_giorno') == '0' ? '' : (old('espo_sole_tutto_giorno') || $infoPiscina->espo_sole_tutto_giorno ? 'checked' : '') }} class="beautiful_checkbox">
        <label for="espo_sole_tutto_giorno" class="font-weight-bold">
          tutto il giorno
        </label>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <label class="font-weight-bold">Peculiarità</label>
      </div>
    </div>
    <div class="row form-group">
      <div class="col-md-12">
        <textarea name="peculiarita_piscina" class="form-control">{{old('peculiarita_piscina') != '' ?  old('peculiarita_piscina') :  $foglio->peculiarita_piscina}}</textarea>
      </div>
    </div>

    <hr>
    <div class="row form-group">
      <div class="col-md-12">
        <label class="font-weight-bold">VASCA BIMIBI</label>
      </div>
    </div>
    <div class="row form-group">
      <div class="col-md-4">
        <label class="font-weight-bold">
          superficie (mq.)
        </label>
        <input id="vasca_bimbi_sup" class="form-control" maxlength="3" name="vasca_bimbi_sup" type="text" value="{{old('vasca_bimbi_sup') != '' ?  old('vasca_bimbi_sup') :  $infoPiscina->vasca_bimbi_sup}}">
      </div>
      <div class="col-md-4">
        <label class="font-weight-bold">
            altezza unica (cm.)
        </label>
        <input id="vasca_bimbi_h" class="form-control" maxlength="3" name="vasca_bimbi_h" type="text" value="{{old('vasca_bimbi_h') != '' ?  old('vasca_bimbi_h') :  $infoPiscina->vasca_bimbi_h}}">
      </div>
      <div class="col-md-4">
        <input type="hidden" name="vasca_bimbi_riscaldata" value="0">
        <input type="checkbox" name="vasca_bimbi_riscaldata" id="vasca_bimbi_riscaldata" value="1" {{ old('vasca_bimbi_riscaldata') == '0' ? '' : (old('vasca_bimbi_riscaldata') || $infoPiscina->vasca_bimbi_riscaldata ? 'checked' : '') }} class="beautiful_checkbox">
        <label for="vasca_bimbi_riscaldata" class="font-weight-bold">
          riscaldata
        </label>
      </div>
    </div>

    <hr>

    <div class="row form-group">
      <div class="col-md-12">
        <label class="font-weight-bold">VASCA IDROMASSAGGIO A PARTE</label>
      </div>
    </div>

    <div class="row form-group">
      <div class="col-md-4">
        <label class="font-weight-bold">
          N. vasche disponibili
        </label>
        <input id="vasca_idro_n_dispo" class="form-control" maxlength="3" name="vasca_idro_n_dispo" type="text" value="{{old('vasca_idro_n_dispo') != '' ?  old('vasca_idro_n_dispo') :  $infoPiscina->vasca_idro_n_dispo}}">
      </div>
      <div class="col-md-4">
        <label class="font-weight-bold">
            N. posti disponibili
        </label>
        <input id="vasca_idro_posti_dispo" class="form-control" maxlength="3" name="vasca_idro_posti_dispo" type="text" value="{{old('vasca_idro_posti_dispo') != '' ?  old('vasca_idro_posti_dispo') :  $infoPiscina->vasca_idro_posti_dispo}}">
      </div>
    </div>

    <div class="row form-group">
      <div class="col-md-12">
        <label class="font-weight-bold">Posizione:</label>
      </div>
    </div>
    <div class="row form-group posizione_vasca">
      @foreach (Utility::getFsPosizioneVasca() as $key => $val)
      <div class="col-xl-2 col-md-4">
        <input type="radio" name="vasca_posizione" id="v_{{$key}}" value="{{$val}}" {{ old($key) || $infoPiscina->vasca_posizione == $val ? 'checked' : '' }} class=""> 
        <label for="v_{{$key}}" class="font-weight-bold">
        {{$val}}
        </label>
      </div>
      @endforeach
    </div>

    <div class="row form-group">
      <div class="col-md-3">
        <input type="hidden" name="vasca_idro_riscaldata" value="0">
        <input type="checkbox" name="vasca_idro_riscaldata" id="vasca_idro_riscaldata" value="1" {{ old('vasca_idro_riscaldata') == '0' ? '' : (old('vasca_idro_riscaldata') || $infoPiscina->vasca_idro_riscaldata ? 'checked' : '') }} class="beautiful_checkbox">
        <label for="vasca_idro_riscaldata" class="font-weight-bold">
          riscaldata
        </label>
      </div>
      <div class="col-md-3">
        <input type="hidden" name="vasca_pagamento" value="0">
        <input type="checkbox" name="vasca_pagamento" id="vasca_pagamento" value="1" {{ old('vasca_pagamento') == '0' ? '' : (old('vasca_pagamento') || $infoPiscina->vasca_pagamento ? 'checked' : '') }} class="beautiful_checkbox">
        <label for="vasca_pagamento" class="font-weight-bold">
          a pagamento
        </label>
      </div>
    </div>

  </div> {{-- elenco_campi_piscina --}}

  <div class="spacerBlu"></div>

  <div class="row form-group">
    <div class="col-xl-2 col-md-4">  
      <label class="font-weight-bold">
         INFO BENESSERE
      </label>
    </div>
    <div class="col-xl-4 col-md-4">
      <input type="hidden" name="benessere" value="0">
      <input type="checkbox" name="benessere" id="benessere" value="1" {{ old('benessere') == '0' ? '' : (old('benessere') || $foglio->benessere ? 'checked' : '') }} class="beautiful_checkbox">
      <label for="benessere" class="font-weight-bold">
        Ho un centro benessere
      </label>
    </div>
  </div>

  <div id="elenco_campi_benessere">

     <div class="row form-group">
      <div class="col-md-6">
        <label class="font-weight-bold col-form-label">
            superficie (mq.)
        </label>
        <input class="form-control misure" maxlength="3" name="sup_b" type="text" value="{{old('sup_b') != '' ?  old('sup_b') :  $centroBenessere->sup_b}}" id="sup_b">
      </div>
    </div>

    <div class="row form-group">
      <div class="col-md-12">
        <label class="font-weight-bold">Ho un'area fitness</label>
      </div>
    </div>
    <div class="row form-group">
      <div class="col-xl-2 col-md-2">
        <select required id="area_fitness" class="form-control" name="area_fitness">
        
        @foreach (['seleziona', 'si','no'] as $value)
          @if ( old('area_fitness') !== null)   
            <option value="{{$value}}" {{old('area_fitness') == $value ? 'selected' : '' }}>{{$value}}</option>
          @else
            <option value="{{$value}}" {{$centroBenessere->area_fitness == $value ? 'selected' : '' }}>{{$value}}</option>
          @endif
        @endforeach

        </select>
      </div>
      <label class="offset-xl-3 col-xl-1 offset-md-1 col-md-3 font-weight-bold col-form-label">superficie (mq.)</label>
      <div class="col-md-5">
        <input type="text" name="sup_fitness" id="sup_fitness" class="form-control" value="{{old('sup_fitness') != '' ?  old('sup_fitness') :  $centroBenessere->sup_fitness}}">
      </div>
    </div>

    <div class="row form-group">
      <label class="col-xl-3 col-md-2 font-weight-bold">
          PERIODO APERTURA
      </label>
      <label class="col-xl-1 col-md-1 font-weight-bold col-form-label text-right">
          da
      </label>
      <div class="col-xl-2 col-md-3 font-weight-bold">
        <select required id="aperto_dal_b" class="form-control" name="aperto_dal_b">
          @foreach (Utility::getFsMesi() as $id => $value)
            <option value="{{$id}}" {{old('aperto_dal_b') == $id || $centroBenessere->aperto_dal_b == $id ? 'selected' : '' }}>{{$value}}</option>
          @endforeach
        </select>
      </div>
      <label class="col-xl-1 col-md-1 font-weight-bold col-form-label text-right">
          a
      </label>
      <div class="col-xl-2 col-md-3">
        <select required id="aperto_al_b" class="form-control" name="aperto_al_b">
          @foreach (Utility::getFsMesi() as $id => $value)
            <option value="{{$id}}" {{old('aperto_al_b') == $id || $centroBenessere->aperto_al_b == $id ? 'selected' : '' }}>{{$value}}</option>
          @endforeach
        </select>
      </div>
      <div class="col-xl-2 col-md-2">
        <input type="hidden" name="aperto_annuale_b" value="0">
        <input type="checkbox" name="aperto_annuale_b" id="aperto_annuale_b" value="1" {{ old('aperto_annuale_b') == '0' ? '' : (old('aperto_annuale_b') || $centroBenessere->aperto_annuale_b ? 'checked' : '') }} class="beautiful_checkbox">
        <label for="aperto_annuale_b" class="font-weight-bold col-form-label">
          annuale
        </label>
      </div>
    </div>

       <!-- a pagamento -->
    <div class="row form-group">
      <label class="font-weight-bold col-xl-2 col-md-3 col-form-label">A pagamento</label>
      <div class="col-xl-2 col-md-2">
        <select required id="a_pagamento" class="form-control" name="a_pagamento">
          @foreach (['seleziona', 'si','no'] as $value)
            @if ( old('a_pagamento') !== null)   
              <option value="{{$value}}" {{old('a_pagamento') == $value ? 'selected' : '' }}>{{$value}}</option>
            @else
              <option value="{{$value}}" {{$centroBenessere->a_pagamento == $value ? 'selected' : '' }}>{{$value}}</option>
            @endif
          @endforeach
        </select>
      </div>
    </div>


     <div class="row form-group">
      <label class="col-xl-2 col-md-2 font-weight-bold  col-form-label">Posizione:</label>
      <div class="col-xl-3 col-md-3">
        <input type="hidden" name="in_hotel" value="0">
        <input type="checkbox" name="in_hotel" id="in_hotel" value="1" {{ old('in_hotel') == '0' ? '' : (old('in_hotel') || $centroBenessere->in_hotel ? 'checked' : '') }} class="beautiful_checkbox">
        <label for="in_hotel" class="font-weight-bold col-form-label">
          in hotel
        </label>
      </div>
      <label class="col-xl-1 col-md-1 font-weight-bold col-form-label text-right">a</label>
      <div class="col-xl-1 col-md-2">
        <input type="text" name="distanza_hotel" id="distanza_hotel" class="form-control input_distanza_hotel"  value="{{old('distanza_hotel') != '' ?  old('distanza_hotel') :  $centroBenessere->distanza_hotel}}">
      </div>
      <label class="col-xl-2 col-md-4 col-form-label font-weight-bold"> metri dall'hotel</label>
    </div>

     <!-- eta minima per accedere -->
    <div class="row form-group">
      <label class="col-xl-2 col-md-4 font-weight-bold col-form-label">Età minima per accedere</label>
      <div class="col-xl-2 col-md-2">
        <input type="text" name="eta_minima" id="eta_minima" class="form-control input_eta_minima"  value="{{old('eta_minima') != '' ?  old('eta_minima') :  $centroBenessere->eta_minima}}">
      </div>
      <label class="col-xl-1 col-md-3 col-form-label font-weight-bold">anni</label>
    </div>

    <div class="row form-group">
      <div class="col-md-12">
        <label class="font-weight-bold">CARATTERISTICHE:</label>
      </div>
    </div>
    @php
      $row_carr = array_chunk(Utility::getFsCaratteristicheCentroBenessere(), 4, true);
    @endphp
    @foreach ($row_carr as $n_row => $caratteristicheCentroBenessere_in_row)
    <div class="row form-group">
      @foreach ($caratteristicheCentroBenessere_in_row as $carr => $carr_view)
          <input type="hidden" name="{{$carr}}" value="0">
          <div class="col-xl-3 col-md-6">
            <input type="checkbox" name="{{$carr}}" id="{{$carr}}" value="1" {{ old($carr) == '0' ? '' : (old($carr) || $centroBenessere->$carr ? 'checked' : '') }} class="beautiful_checkbox">
            <label for="{{$carr}}" class="font-weight-bold">
              {{$carr_view}}
            </label>
          </div>
        @endforeach
      </div>
    @endforeach

    <div class="row">
      <div class="col-md-12">
        <label class="font-weight-bold">Peculiarità</label>
      </div>
    </div>
    <div class="row form-group">
      <div class="col-md-12">
        <textarea name="peculiarita" class="form-control">{{old('peculiarita') != '' ?  old('peculiarita') :  $centroBenessere->peculiarita}}</textarea>
      </div>
    </div>

    <div class="row form-group">
      <label class="font-weight-bold col-xl-2 col-md-3 col-form-label">Obbligo di prenotazione</label>
      <div class="col-xl-2 col-md-2">
        <select required id="obbligo_prenotazione" class="form-control" name="obbligo_prenotazione">
        @foreach (['si','no'] as $value)
          <option value="{{$value}}" {{old('obbligo_prenotazione') == $value || $centroBenessere->obbligo_prenotazione == $value ? 'selected' : '' }}>{{$value}}</option>
        @endforeach
        </select>
      </div>
    </div>

  <!-- uso in esclusiva -->
  <div class="row form-group">
    <label class="font-weight-bold col-xl-2 col-md-3 col-form-label">Uso in esclusiva</label>
    <div class="col-xl-3 col-md-3">
       <select required id="uso_esclusivo" class="form-control" name="uso_esclusivo">
        @foreach (['seleziona', 'si','no','a richiesta'] as $value)
          <option value="{{$value}}" {{old('uso_esclusivo') == $value || $centroBenessere->uso_esclusivo == $value ? 'selected' : '' }}>{{$value}}</option>
        @endforeach
      </select>
    </div>
  </div>

  </div> {{-- elenco_campi_benessere --}}


  <div class="spacerBlu"></div>


  {{-- Elenco gruppiServizi --}}

  @foreach ($gruppiServizi as $gruppo)

    <div class="row form-group">
      <div class="col-md-12">
        <label class="font-weight-bold">{{$gruppo->nome}}</label>
      </div>
    </div>
    <div class="elenco_servizi">
      @foreach ($gruppo->elenco_servizi as $key => $servizio)
        <input type="hidden" name="{{$servizio->id}}" value="0">
        <div class="row form-group servizio">
          <div class="col-xl-2 col-md-4 flex-container">
            <input type="checkbox" name="{{$servizio->id}}" id="{{$servizio->id}}" value="1" {{ old($servizio->id) == '0' ? '' : (old($servizio->id) || array_key_exists($servizio->id, $ids_servizi_associati) ? 'checked' : '') }}  class="beautiful_checkbox">
            <label for="{{$servizio->id}}">
              {{$servizio->nome}}
            </label>
          </div>
          <div class="col-xl-8 col-md-8">
            <input type="text" 
                    name="nota_servizio_{{$servizio->id}}" 
                    id="nota_servizio_{{$servizio->id}}" 
                    class="form-control"  
                    value="{{ 
                      old('nota_servizio_'.$servizio->id) != '' ?  old('nota_servizio_'.$servizio->id) : (array_key_exists($servizio->id, $ids_servizi_associati) ? $ids_servizi_associati[$servizio->id] : '')  }} ">

            @if ($servizio->id == 94)
            <div id="obbligatorio_piscina" class="alert alert-danger" role="alert">
              É obbligatorio compilare questo campo
            </div>
            @endif

            @if ($servizio->id == 96)
            <div id="obbligatorio_benessere" class="alert alert-danger" role="alert">
              É obbligatorio compilare questo campo
            </div>
            @endif
          </div>  
        </div>
      @endforeach
      @if ( isset($serv_agg[$gruppo->id]) )        
        @foreach ($serv_agg[$gruppo->id] as $servizio)
            @php
                list($id_serv_agg,$nome_serv_agg) = explode('|',$servizio);
            @endphp
            @include('foglio_servizi._riga_servizio_agg')
        @endforeach
      @endif
      <div id="serv_agg_placeholder_{{$gruppo->id}}">
        <!-- aggiungo i serivizi via ajax -->
      </div>
      <!-- servizio aggiuntivo -->
      <div class="row form-group servizio">
        <label class="col-xl-2 col-md-4 col-form-label" for="servizio_add_{{$gruppo->id}}">
            Servizio aggiuntivo
        </label>       
        <div class="col-xl-4 col-md-4">
          <input type="text" id="servizio_add_{{$gruppo->id}}" class="form-control">
        </div>
        <div class="col-xl-1 col-md-1">
          <a class="btn btn-primary add_servizio" id="{{$gruppo->id}}"><i class="fas fa-plus-square"></i></a>
        </div>
      </div>

    </div>

    <div class="spacerBlu"></div>
  @endforeach

 <div class="row form-group">
    <label class="col-xl-1 col-md-2 col-form-label">Data:</label>
    <div class="col-xl-1 col-md-5 ">
      <input type="text" name="data_firma" id="data_firma" class="form-control input_data_firma"  value="{{old('data_firma') != '' ?  old('data_firma') :  optional($foglio->data_firma)->format('d/m/Y')}}">
    </div>
  </div>
    {{--  Nome file pdf --}}
<div class="form-group row">
  <label class="col-xl-1 col-md-3 col-form-label " for="nome_file">Nome file pdf</label>
    
  <div class="col-xl-4 col-md-9">
    <div class="input-group">
      <input class="form-control" id="nome_file" type="text" name="nome_file" placeholder="Nome file pdf" value="{{old('nome_file') != '' ?  old('nome_file') :  $foglio->nome_file}}"> 
      <div class="input-group-append">
        <span class="input-group-text">.pdf</span>
      </div>
    </div>
  </div>

  <div class="col-xl-2 col-md-5">
    <button type="submit" class="salva_nome_pdf btn btn-primary btn-xs">Salva</button>
    <a id="crea_pdf" href="#" class="btn btn-danger btn-xs">Crea Pdf con firma</a>
  </div>

  <div class="col-xl-2 col-md-5 col-xs-12" id="pdf_firmato">
    <a href="{{asset('storage/precontratti').'/'.$foglio->nome_file.'_firmato.pdf'}}" target="_blank" class="btn btn-success btn-xs">Apri Pdf</a>
  </div>

  
</div>
{{--  end Nome file pdf --}}

    <div class="spacerBlu"></div>



</form>


@endsection

