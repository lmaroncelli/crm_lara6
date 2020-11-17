@extends('layouts.coreui.crm_lara6')


@section('js')

<script type="text/javascript">

      function caricaGrigliaEvidenze(destroy_session = 0) {
          
          $(".spinner_lu").show();
          
          var contratto_id = '{{$contratto->id}}';
          var macro_id = '{{$macro_id}}';

          data = {
            contratto_id:contratto_id,
            macro_id:macro_id,
            destroy_session:destroy_session
          };
          
          $.ajax({
              url: "{{ route('crea_griglia_evidenza_contratto_ajax') }}",
              type: 'POST',
              data: data,
              success: function(griglia) {
                  $("#evidenze_contratto").html("");
                  $("#evidenze_contratto").html(griglia);

                  $(".spinner_lu").hide();
              },
              error: function() {
                $(".spinner_lu").hide();
              }
          });
          

      }

      function caricaServiziContratto(destroy_session = 0) {

          $(".spinner_lu.servizi").show();
          
          var contratto_id = '{{$contratto->id}}';
          var destroy_session = destroy_session;

          data = {
            contratto_id:contratto_id,
            destroy_session:destroy_session
          };
          
          $.ajax({
              url: "{{ route('carica_servizi_contratto_ajax') }}",
              type: 'POST',
              data: data,
              success: function(servizi) {
                  $("#servizi_contratto").html("");
                  $("#servizi_contratto").html(servizi);

                  $(".spinner_lu.servizi").hide();
              },
              error: function() {
                $(".spinner_lu.servizi").hide();
              }
          });
        
      }


jQuery(document).ready(function($){


      caricaGrigliaEvidenze();
      caricaServiziContratto();


      $('body').on('click', "#refresh", function(e) {
        e.preventDefault();
        let carica_servizi = $("#carica_servizi").val();
        if(carica_servizi) {
          caricaServiziContratto(carica_servizi);
          caricaGrigliaEvidenze(carica_servizi);
        }
        $("#carica_servizi").val(0);
      });


      /* click sul bottone per aggiornare il form totale*/
      $( "#form_contratto_digitale" ).submit(function(e) {
        var i1 = $("#i1").val(); 
        var i2 = $("#i2").val(); 
        var i3 = $("#i3").val(); 
        var i4 = $("#i4").val(); 
        $("#iban").val(i1+i2+i3+i4);

        
        
      });


      $(".salva_nome_pdf").click(function(e) {
        e.preventDefault();

        var nome_file_scelto = $("#nome_file_scelto").val();
        $("#nome_file").val(nome_file_scelto);

        $( "#form_contratto_digitale" ).submit();

      })



      /* click bottone cancella riga servizio */
      $('body').on('click', ".delRow", function(e) {
        
        e.preventDefault();
        
        var nome = $(this).data('nome');
        
        if (confirm('Sei sicuro di eliminare '+ nome + '?')) {


          var idservizio = $(this).data('idservizio');
          var idcontratto = $(this).data('idcontratto');
          var destroy_session = 1;

          data = {
            idservizio:idservizio,
            idcontratto:idcontratto
          };
          
          $.ajax({
              url: "{{ route('del-riga-servizio-ajax') }}",
              type: 'POST',
              data: data,
              success: function(msg) {
                  caricaServiziContratto(destroy_session);
                  if (msg="is_evidenza") {
                    caricaGrigliaEvidenze(destroy_session);
                  }
              },
              error: function() {
                alert('Errore imprevisto!');
                $(".spinner_lu").hide();
                $(".spinner_lu.servizi").hide();
              }
          });
    
        
        } /*endif confirm*/

      }); /*end delRow */


    $('body').on('click', ".scontoRow", function(e){
      
      e.preventDefault();

      $(".spinner_lu.servizi").show();

      var idservizio = $(this).data('idservizio');
      var idcontratto = $(this).data('idcontratto');

      data = {
        idservizio:idservizio,
        idcontratto:idcontratto
      };
      $.ajax({
          url: "{{ route('load-riga-sconto-ajax') }}",
          type: 'POST',
          data: data,
          success: function(msg) {
              //alert(msg);
              $('#container_row_ajax').fadeOut('fast', function() {
                  
                  $('#container_row_ajax').html(msg);
                  
              });

              $('#container_row_ajax').fadeIn('fast', function(){
                  
                $(".spinner_lu.servizi").hide();
                $(".aggiorna").prop('disabled', true);
        

              });


          },
          error:function(){
            $(".spinner_lu.servizi").hide();
          }
      });

    }); /*end scontoRow*/



    /* click bottone salva riga sconto (AGGIUNTA VIA AJAX) */
    /*
    http://stackoverflow.com/questions/9344306/jquery-click-doesnt-work-on-ajax-generated-content
    */
    $('body').on('click', '#addRowSconto', function (e){
      e.preventDefault();
      $(".spinner_lu.servizi").show();

        var data = $("#formAddRowSconto").serialize();
     
        $.ajax({
            async:false,
            url: "{{ route('save-riga-sconto-ajax') }}",
            type: 'POST',
            data: data,
            success: function(msg) {
              if (msg == 'ok') {
                window.location.reload(true);
              }
              else {
              
                $('#container_row_ajax').fadeOut('fast', function() {
                    
                    $('#container_row_ajax').html(msg);
                    
                });

                $('#container_row_ajax').fadeIn('fast', function(){
                  $(".spinner_lu.servizi").hide();	 				
                });

              }
            },
            error : function(data) {
              $(".spinner_lu.servizi").hide();
              if( data.status === 422 ) {
                  
                  var errors = $.parseJSON(data.responseText);
                  $.each(errors, function (key, value) {
                    // console.log(key+ " " +value);
                  $('#response').addClass("alert alert-danger");

                      if($.isPlainObject(value)) {
                          $.each(value, function (key, value) {                       
                              console.log(key+ " " +value);
                          $('#response').show().append(value+"<br/>");

                          });
                      }else{
                      //$('#response').show().append(value+"<br/>"); //this is my div with messages
                      }
                  });
              } /* end if status */
            } /* end error */
        });
    }); /* end addRowSconto*/
          

    
    /* select servizi */
    $('body').on('change', '#servizi_select', function (e){

        $(".spinner_lu.servizi").show();

        var servizio = $(this).val();
        var idcontratto = $(this).data('idcontratto');

        data = {
          servizio:servizio,
          idcontratto:idcontratto
        };

        $.ajax({
            url: "{{ route('load-riga-servizio-ajax') }}",
            type: 'POST',
            data: data,
            success: function(msg) {
                //alert(msg);
                $('#container_row_ajax').fadeOut('fast', function() {
                    
                    $('#container_row_ajax').html(msg);
                    
                });

                $('#container_row_ajax').fadeIn('fast', function(){
                    // viene disabilitato il bottone salva del form totale				 				
                    if (servizio == "") {
                      $(".aggiorna").prop('disabled', false);
                    } 
                    else {
                      $(".aggiorna").prop('disabled', true);				 	        			
                    }
                });

                $(".spinner_lu.servizi").hide();

            },
            error : function(data) {
              $(".spinner_lu.servizi").hide();
            }
        }); /*end ajax call*/
        

		}); /*end servizi_select*/

    $('body').on('click', '#closeRow', function (e){
      e.preventDefault();

      $('#container_row_ajax').fadeOut('fast', function() {
                    
          $('#container_row_ajax').empty();
          
      });

      $('#container_row_ajax').fadeIn('fast', function(){
          // rimetto la select dei serivi da vendere 				 				
          $("select#servizi_select").prop('selectedIndex', 0);
      });

    });


    $('body').on('click', '#addRowServizio', function (e){
      e.preventDefault();
      $(".spinner_lu.servizi").show();

        var data = $("#formAddServizio").serialize();
        var destroy_session = 1;
        $.ajax({
            async:false,
            url: "{{ route('save-riga-servizio-ajax') }}",
            type: 'POST',
            data: data,
            success: function(msg) {
              if (msg == 'ok') {
                caricaServiziContratto(destroy_session);
              }
              else {
              
                $('#container_row_ajax').fadeOut('fast', function() {
                    
                    $('#container_row_ajax').html(msg);
                    
                });

                $('#container_row_ajax').fadeIn('fast', function(){
                    $(".spinner_lu.servizi").hide();	
                });

              }
            },
            error : function(data) {
              $(".spinner_lu.servizi").hide();
              if( data.status === 422 ) {
                  
                  var errors = $.parseJSON(data.responseText);
                  $('#response').empty();
                  $.each(errors, function (key, value) {
                    // console.log(key+ " " +value);
                  $('#response').addClass("alert alert-danger");

                      if($.isPlainObject(value)) {
                          $.each(value, function (key, value) {                       
                              console.log(key+ " " +value);
                          $('#response').show().append(value+"<br/>");

                          });
                      }else{
                      //$('#response').show().append(value+"<br/>"); //this is my div with messages
                      }
                  });
              } /* end if status */
            } /* end error */
        });
    }); /* end addRowServizio*/




    /* click bottone crea pdf */
    $( "#crea_pdf" ).click(function(e) {
      
      e.preventDefault();
      
      $(".spinner_lu.servizi").show();
        
        var contratto_id = {{$contratto->id}};

        data = {
          contratto_id:contratto_id
        };
        
        $.ajax({
            url: "{{ route('contratto-digitale.crea-pdf-ajax') }}",
            type: 'POST',
            data: data,
            success: function(msg) {
                if (msg="ok") {
                  $("#pdf_firmato").fadeIn('slow');
                } else {
                  alert(msg);
                }
              $(".spinner_lu.servizi").hide();
            },
            error: function() {
              $(".spinner_lu.servizi").hide();
              alert('errore imprevisto!');
            }
        });
      
      

    }); /*end crea pdf */

    

}); /* document.ready */
</script>
@endsection


{{--  
  questo js era in griglia_evidenze_inc.blade.php, ma siccome adesso questo snippet viene ricaricato con ajax
  ricaricando anche il js SI INCASINA e fa le chiamate doppie 
  
  --}}
@section('js_griglia_evidenze')
  

  @include('javascript_view.js_griglia')


@endsection



@section('content')
<form action="{{ route('contratto-digitale.update',$contratto->id) }}" method="post" id="form_contratto_digitale">
  @csrf
  @method('PUT')
  <input type="hidden" id="carica_servizi" value="0">
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
            <input class="form-control" type="text" name="segnalatore" value="{{ old('segnalatore') != '' ?  old('segnalatore') :  $contratto->segnalatore }}" placeholder="Segnalato da ...">
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
        <label for="dati_cliente">Cliente</label>
        <textarea id="dati_cliente" class="form-control" name="dati_cliente" rows="5" placeholder="ID - Hotel XXXXX
  LOCALITA">
{{old('dati_cliente') != '' ?  old('dati_cliente') :  $contratto->dati_cliente}}
        </textarea>
        
      </div>
    </div>

    {{-- Fatturazione --}}
    <div class="col-lg-5">
      <div class="form-group">
        <label for="dati_fatturazione">Dati Fatturazione</label>
        <textarea id="dati_fatturazione" class="form-control" name="dati_fatturazione" rows="5" placeholder="Hotel XXXXX s.a.s. di YYYYYY
  Viale ZZZZZZ
  CAP-LOCALITA(PROVINCIA) 
  P.IVA: PPPPPP
  Codice Fiscale:CCCCCCCCCCC">
{{old('dati_fatturazione') != '' ?  old('dati_fatturazione') :  $contratto->dati_fatturazione}}
        </textarea>
      </div>
    </div>
  </div>

  <div class="row">
    {{-- Referente --}}
    <div class="col-lg-5">
      <div class="form-group">
        <label for="dati_referente">Dati Referente</label>
        <textarea id="dati_referente" class="form-control" name="dati_referente" rows="5" placeholder="Proprietario: Napoleone Bonaparte - 338-111222333">
{{old('dati_referente') != '' ?  old('dati_referente') :  $contratto->dati_referente}}
        </textarea>
      </div>
    </div>
  </div>

  {{-- Iban importato --}}
  @if ($mostra_iban_importato && $contratto->iban_importato != '')
  <div class="form-group row">
    <label class="col-md-3 col-form-label" for="text-input">IBAN IMPORTATO</label>
    <div class="col-md-9">
      <input class="form-control" id="iban_importato" type="text" name="iban_importato" placeholder="iban importato dal crm" value="{{old('iban_importato') != '' ?  old('iban_importato') :  $contratto->iban_importato}}">
      <span class="help-block">Importato dal CRM (questo campo verrà automaticamente nascosto dopo aver compilato l'IBAN sottostante e salvato)</span>
    </div>
  </div>
  @endif

  {{-- IBAN  --}}
  <div class="form-group row">

    <label class="col-lg-3 col-form-label" for="i1">IBAN</label>
    <div class="col-lg-2">
      <input class="form-control" name="i1" id="i1" type="text" value="{{ old('i1') != '' ?  old('i1') :  $i1 }}">
    </div>
    <div class="col-lg-2">
      <input class="form-control" name="i2" id="i2" type="text" value="{{ old('i2') != '' ?  old('i2') :  $i2 }}">
    </div>
    <div class="col-lg-2">
      <input class="form-control" name="i3" id="i3" type="text" value="{{ old('i3') != '' ?  old('i3') :  $i3 }}">
    </div>
    <div class="col-lg-2">
      <input class="form-control" name="i4" id="i4" type="text" value="{{ old('i4') != '' ?  old('i4') :  $i4 }}">
    </div>

    <input type="hidden" name="iban" id="iban">

  </div>

  <div class="row header">
    <div class="form-group col-sm-12">
      <label for="condizioni_pagamento">Fatturazione Elettronica</label>
    </div>
  </div>

  {{-- pec --}}
  <div class="form-group row">
    <label class="col-md-3 col-form-label" for="text-input">PEC</label>
    <div class="col-md-9">
      <input class="form-control" id="pec" type="text" name="pec" placeholder="PEC" value="{{old('pec') != '' ?  old('pec') :  $contratto->pec}}">
    </div>
  </div>
  
  {{-- codice destinatario --}}
  <div class="form-group row">
    <label class="col-md-3 col-form-label" for="text-input">Codice Destinatario</label>
    <div class="col-md-9">
      <input class="form-control" id="codice_destinatario" type="text" name="codice_destinatario" placeholder="Codice Destinatario" value="{{old('codice_destinatario') != '' ?  old('codice_destinatario') :  $contratto->codice_destinatario}}" maxlength="7">
    </div>
  </div>

  {{-- Condizioni di pagamento --}}

  <div class="row header">
    <div class="form-group col-sm-3">
      <label for="condizioni_pagamento">Condizioni di pagamento</label>
    </div>
    <div class="form-group col-sm-7">
      <label for="data_pagamento">Data pagamento</label>
    </div>
  </div>
  @foreach ($condizioni_pagamento as $cp => $value)
    <div class="row">
        <div class="form-check-inline form-group col-sm-3">
          <input class="form-check-input condizioni_pagamento" id="{{$cp}}" type="radio" value="{{$cp}}" name="condizioni_pagamento" @if (old('condizioni_pagamento') == $cp || $contratto->condizioni_pagamento == $cp ) checked @endif>
          <label class="form-check-label" for="{{$cp}}">
            {{$cp}} @if ($cp == 'RIBA') (*) @endif
          </label>
        </div>
        <div class="form-group col-sm-7">
          <input class="form-control" class="data_pagamento" name="data_pagamento_{{$value}}" type="text" placeholder="" value="{{old('data_pagamento'.$value) != '' ?  old('data_pagamento'.$value) :  $contratto->condizioni_pagamento == $cp ? $contratto->data_pagamento : '' }}">
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
{{old('note') != '' ?  old('note') :  $contratto->note}}
      </textarea>
    </div>
  </div>

  {{-- Sito Web --}}
  <div class="form-group row">
    <label class="col-md-3 col-form-label" for="text-input">Sito web</label>
    <div class="col-md-9">
      <input class="form-control" id="sito_web" type="text" name="sito_web" placeholder="Sito web" value="{{old('sito_web') != '' ?  old('sito_web') :  $contratto->sito_web}}">
    </div>
  </div>

  {{-- email --}}
  <div class="form-group row">
    <label class="col-md-3 col-form-label" for="text-input">Email</label>
    <div class="col-md-9">
      <input class="form-control" id="email" type="text" name="email" placeholder="Email" value="{{old('email') != '' ?  old('email') :  $contratto->email}}">
    </div>
  </div>

  {{--  Email amministrativa --}}
  <div class="form-group row">
    <label class="col-md-3 col-form-label" for="text-input">Email amministrativa</label>
    <div class="col-md-9">
      <input class="form-control" id="email_amministrativa" type="text" name="email_amministrativa" placeholder="Email amministrativa" value="{{old('email_amministrativa') != '' ?  old('email_amministrativa') :  $contratto->email_amministrativa}}">
    </div>
  </div>
  <input type="hidden" name="nome_file" id="nome_file" value="{{old('nome_file') != '' ?  old('nome_file') :  $contratto->nome_file}}">
  <div class="row">
    <div class="col mt-5">
      <button type="submit" class="aggiorna btn btn-primary btn-xs">Salva</button>
    </div>
  </div>
</form>
<hr>

<div class="spinner_lu" style="display:none;"></div>
<div class="evidenze_contratto" id="evidenze_contratto">
</div>


<hr>

<div id="servizi_contratto">
  
</div>
<div class="spinner_lu servizi" style="display:none;"></div>





{{--  Nome file pdf --}}
<div class="form-group row">
  <label class="col-lg-1 col-form-label col-md-1" for="text-input">Nome file pdf</label>
    
  <div class="col-md-4">
    <div class="input-group">
      <input class="form-control" id="nome_file_scelto" type="text" name="nome_file_scelto" placeholder="Nome file pdf" value="{{old('nome_file') != '' ?  old('nome_file') :  $contratto->nome_file}}"> 
      <div class="input-group-append">
        <span class="input-group-text">.pdf</span>
      </div>
    </div>
  </div>

  <div class="col-md-5">
    <button type="button" class="salva_nome_pdf btn btn-primary btn-xs">Salva</button>
    <a id="crea_pdf" href="#" class="btn btn-danger btn-xs">Crea Pdf con firma</a>
  </div>

  <div class="col-md-1 text-right" @if (!$exists) style="display:none;" @endif  id="pdf_firmato">
    <a href="{{asset('storage/precontratti').'/'.$contratto->nome_file.'_firmato.pdf'}}" target="_blank" class="btn btn-success btn-xs">Apri Pdf</a>
  </div>

  
</div>
{{--  end Nome file pdf --}}

@endsection

