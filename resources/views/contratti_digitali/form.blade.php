@extends('layouts.coreui.crm_lara6')


@section('js')

<script type="text/javascript">

jQuery(document).ready(function($){

      /* click bottone cancella riga servizio */
      $( ".delRow" ).click(function(e) {
        
        e.preventDefault();
        
        var nome = $(this).data('nome');
        
        if (confirm('Sei sicuro di eliminare '+ nome + '?')) {

          
          var id = $(this).data('id');
          
          var idservizio = $(this).data('idservizio');
          var idcontratto = $(this).data('idcontratto');

          data = {
            idservizio:idservizio,
            idcontratto:idcontratto
          };
          
          $.ajax({
              url: "{{ route('del-riga-servizio-ajax') }}",
              type: 'POST',
              data: data,
              success: function(msg) {
                  if (msg="ok") {
                    window.location.reload(true);
                  } else {
                    alert(msg);
                  }
              }
          });
        
        } /*endif confirm*/

      }); /*end delRow */


    $(".scontoRow").click(function(e){
      
      e.preventDefault();

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
                  
                  $(".aggiorna").prop('disabled', true);
        

              });


          }
      });

    }); /*end scontoRow*/



    /* click bottone salva riga sconto (AGGIUNTA VIA AJAX) */
    /*
    http://stackoverflow.com/questions/9344306/jquery-click-doesnt-work-on-ajax-generated-content
    */
    $('body').on('click', '#addRowSconto', function (e){
      e.preventDefault();
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
                    // do nothing				 				
                });

              }
            },
            error : function(data) {
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
        var servizio = $(this).val();
        var idcontratto = $("#servizio").data('idcontratto');

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


            }
        }); /*end ajax call*/

		}); /*end servizi_select*/

    $('body').on('click', '#delRowSconto', function (e){
      e.preventDefault();

      $('#container_row_ajax').fadeOut('fast', function() {
                    
          $('#container_row_ajax').empty();
          
      });

      $('#container_row_ajax').fadeIn('fast', function(){
          // rimetto la select dei serivi da vendere 				 				
          $("select#servizi_select").prop('selectedIndex', 0);
      });

    });

    

}); /* document.ready */
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

  <div class="row header">
    <div class="form-group col-sm-12">
      <label for="condizioni_pagamento">Fatturazione Elettronica</label>
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

  <div class="row header">
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

  <hr>
  @include('evidenze.griglia_evidenze_inc', ['contratto_digitale' => 1])
  <hr>
</div> {{-- end evidenze_contratto --}}

{{-- ServiziDigitali associati al contratto --}}
<div class="table-responsive">
  <table class="table">
    <caption>Servizi venduti</caption>
    <thead>
      <tr>
        <th scope="col">Servizi digitali INFOALBERGHI.COM</th>
        <th scope="col">Dal</th>
        <th scope="col">Al</th>
        <th scope="col">Q.tà</th>
        <th scope="col" class="text-right">Importo (€)</th>
        <th colspan="2"></th>
      </tr>
    </thead>
    <tbody>
      @foreach ($servizi_assoc as $servizio)
        @php
            if ($servizio->sconto) 
              {
              $nome = 'lo sconto';
              $title_del='Elimina '.$nome;
              } 
            else 
              {
              $nome = 'il servizio';
              $title_del='Elimina '.$nome;
              }
        @endphp
          @if ($servizio->sconto)
            <tr class="sconto">
              <td colspan="4">
                <i class="fas fa-tags"></i>&nbsp;&nbsp;{{$servizio->nome}}  
              </td>
              <td class="text-right"> - {{Utility::formatta_cifra($servizio->importo, '€')}}</td>
              <td></td>
              <td class="text-right">
                <button type="button" class="btn btn-danger btn-sm delRow" title="{{$title_del}}" data-nome ="{{$nome}}" data-idcontratto="{{$contratto->id}}" data-idservizio="{{$servizio->id}}"><i class="fas fa-trash-alt"></i></button>
              </td>
            </tr>
          @else
            <tr>
              <td>{{$servizio->nome}} - {{$servizio->localita}} @if ($servizio->pagina != '') <br/> {{$servizio->pagina}}@endif</td>
              <td>{{$servizio->dal}}</td>
              <td>{{$servizio->al}}</td>
              <td>{{$servizio->qta}}</td>
              <td class="text-right">{{Utility::formatta_cifra($servizio->importo, '€')}}</td>
              <td class="text-right">
                <button type="button" class="btn btn-primary btn-sm scontoRow" title="Crea uno sconto per il servizio" data-idcontratto="{{$contratto->id}}" data-idservizio="{{$servizio->id}}">
                  <i class="fas fa-piggy-bank"></i>
                </button>
              </td>
              <td class="text-right">
                <button type="button" class="btn btn-danger btn-sm delRow" title="{{$title_del}}" data-id="{{$servizio->id}}"><i class="fas fa-trash-alt"></i></button>
              </td>
            </tr>
          @endif
      @endforeach
      
      {{-- riga sconto/servizio evidenza --}}
      <tr>
        <td colspan="7">
          <div id="container_row_ajax">
  
          </div>
        </td>
      </tr>
      {{-- /riga sconto/servizio evidenza --}}

      {{-- Riga creazione servizio da vendere --}}
      

      <tr>
        <td>
          <div class="form-group">
            <label for="servizio">Servizio da vendere</label>
            <select required id="servizi_select" class="form-control" name="servizio" data-idcontratto="{{$contratto->id}}">
              @foreach ($servizi_contratto as $key => $value)
                <option value="{{$key}}">{{$value}}</option>
              @endforeach
            </select>
          </div>
        </td>
      </tr>

      {{-- /Riga creazione servizio da vendere --}}

      {{-- riga totali --}}
      <tr>
        <td colspan="3" class="text-right font-weight-bold">TOTALE</td>
        <td>{{$totali['tot_qta']}}</td>
        <td class="text-right">{{Utility::formatta_cifra($totali['tot_importo'],'€')}}</td>
        <td colspan="2"></td>
      </tr>
      <tr>
        <td colspan="3" class="text-right font-weight-bold">IVA</td>
        <td>{{Utility::getIva()}}%</td>
        <td class="text-right">{{Utility::formatta_cifra($totali['tot_iva'],'€')}}</td>
        <td colspan="2"></td>
      </tr>
      <tr>
        <td colspan="3" class="text-right font-weight-bold">TOTALE FATTURA</td>
        <td></td>
        <td class="font-weight-bold text-right">{{Utility::formatta_cifra($totali['tot_importo_con_iva'],'€')}}</td>
        <td colspan="2"></td>
      </tr>
      {{-- / riga totali --}}

    </tbody>
  </table>
</div>

@endsection

