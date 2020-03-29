@extends('layouts.coreui.crm_lara6')


@section('js')
	<script type="text/javascript" charset="utf-8">
		
	

		jQuery(document).ready(function(){


        $("#form_contratto_digitale").submit(function(){
          if ($('input:radio.tipo_contratto', this).is(':checked')) {
                  // everything's fine...
              } else {
                  alert('Seleziona il tipo contratto');
                  return false;
              }

              if($('#id_commerciale').val() == 0) {
                 alert('Seleziona il commerciale');
                  return false; 
              }
        });


        function swapRequiredProp(item)
          {
            if (item.prop('required')) {
            item.prop('required', false);
            } else {
            item.prop('required', true);
            }
          }

        $(".toggle").click(function(e){
            e.preventDefault();
            
            $(this).text(function(i, text){
              return text === "Nuovo cliente?" ? "Cliente esistente?" : "Nuovo cliente?";
            })

            $(".seleziona_cliente").toggleClass('nascondi');
            $(".dati_cliente").toggleClass('nascondi');
            $(".solo_esistente").toggleClass('nascondi');

            

            swapRequiredProp($('.clientiDaAssegnare'));
            swapRequiredProp($('#fatturazione'));
            swapRequiredProp($('#referente'));
            swapRequiredProp($('#cliente'));
            swapRequiredProp($('.tipo_contratto'));

            if($("#radio_nuovo_contratto").prop("checked")) {
              $("#radio_nuovo_contratto").prop("checked", false);
            } else {
              $("#radio_nuovo_contratto").prop("checked", true);
            }
            
            

        });

        var clientiDaAssegnare = {!!$clienti_autocomplete_js!!};
        
        $( ".clientiDaAssegnare" ).autocomplete({
           dropdownWidth:'auto',
           source: [clientiDaAssegnare],
        }).on('selected.xdsoft',function(e,datum){
          if(datum != null)
            {
              if (confirm('Sei sicuro di voler selezionare '+datum+' ?')) {
                $(".spinner_lu").show();
                data = {
                        item:datum
                      };
                      $.ajax({
                          url:  "{{ route('load-fatturazione-contratto-digitale-ajax') }}",
                          data: data,
                          success: function(msg) {
                            
                                $('#dati_fatturazione').fadeOut('fast', function() {
                                    $("#radio_nuovo").prop('checked', false);
                                    $("#radio_nuovo").fadeOut('fast');
                                    $('#dati_fatturazione').html(msg);    
                                });

                                $('#dati_fatturazione').fadeIn('fast', function(){

                                  $.ajax({
                                          url: "{{ route('load-referente-contratto-digitale-ajax') }}",
                                          data: data,
                                          success: function(msg) {
                                              //alert(msg);
                                              $('#dati_referente').fadeOut('fast', function(){
                                                $('#dati_referente').html(msg);
                                              });

                                              $('#dati_referente').fadeIn('fast', function(){
                                                // visibile submit button               
                                                $("#continua").fadeIn('fast');
                                              });
                                          }
                                      }); 

                                });

                          }
                      }).done(function() {
                        $(".spinner_lu").hide();
                      });// end ajax call
              }
              else 
              {
              $(".clientiDaAssegnare").val('');
              } // if confirm
            }
        });




		});
	

	</script>
	
@endsection

@section('content')
<div class="spinner_lu" style="display:none;"></div>
<form action="{{ route('contratto-digitale.store') }}" method="post" id="form_contratto_digitale">
  @csrf
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
                  <option value="{{$commerciale->id}}">{{$commerciale->name}}</option>
                  @endforeach
                </select>
              </div>
          </div>
          <div class="card-header">TIPO CONTRATTO</div>
          <div class="card-body">
            <div class="form-group">               
              <div class="form-check form-check-inline dati_cliente nascondi">
                <input type="radio" class="tipo_contratto form-check-input" id="radio_nuovo_contratto" value="nuovo" name="tipo_contratto" class="" id="nuovo" required>
                <label  class="form-check-label" for="nuovo">NUOVO</label>
              </div>
              <div class="form-check form-check-inline solo_esistente">
                <input type="radio" class="tipo_contratto form-check-input" value="rinnovo" name="tipo_contratto" class="" id="rinnovo" required>
                <label  class="form-check-label" for="rinnovo">RINNOVO</label>
              </div>
              <div class="form-check form-check-inline solo_esistente">
                <input type="radio" class="tipo_contratto form-check-input" value="cambio_gestione" name="tipo_contratto" class="" id="cambio_gestione" required>
                <label  class="form-check-label" for="cambio_gestione">CAMBIO GESTIONE</label>
              </div>
            </div>
            <div class="input-group">
              <input class="form-control" type="text" name="segnalatore" placeholder="Segnalato da ...">
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
    <div class="col-lg-5">
      <div class="form-group">
        <label for="cliente">Cliente</label> <a href="" class="toggle">Nuovo cliente?</a>
        
        <div class="input-group mb-3 dati_cliente">
          <input name="item" class="clientiDaAssegnare form-control" style="width:400px" placeholder="Seleziona cliente..." value="{{ old('item') }}" required>     
          <button type="button" class="btn btn-success btn-xs">OK</button>
        </div>
        
        <textarea id="cliente" class="form-control dati_cliente nascondi" name="cliente" rows="5" placeholder="ID - Hotel XXXXX
  LOCALITA"></textarea>
        
        
      </div>
    </div>

    <div class="col-lg-5">
      <div class="form-group">
        <label for="fatturazione">Dati Fatturazione</label>
        <textarea id="fatturazione" class="form-control dati_cliente nascondi" name="fatturazione" rows="5" placeholder="Hotel XXXXX s.a.s. di YYYYYY
  Viale ZZZZZZ
  CAP-LOCALITA(PROVINCIA) 
  P.IVA: PPPPPP
  Codice Fiscale:CCCCCCCCCCC"></textarea>
        <div id="dati_fatturazione" class="seleziona_cliente">Seleziona un cliente</div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-5">
      <div class="form-group">
        <label for="referente">Dati Referente</label>
        <textarea id="referente" class="form-control dati_cliente nascondi" name="referente" rows="5" placeholder="Proprietario: Napoleone Bonaparte - 338-111222333"></textarea>
        <div id="dati_referente" class="seleziona_cliente">Seleziona un cliente</div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col mt-5">
      <button type="submit" class="btn btn-primary btn-xs">Salva e continua</button>
    </div>
  </div>
</form>


@endsection

