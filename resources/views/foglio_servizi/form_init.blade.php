@extends('layouts.coreui.crm_lara6')


@section('js')
	<script type="text/javascript" charset="utf-8">
		
	

		jQuery(document).ready(function(){


        $("#form_foglio_servizi").submit(function(){
          
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

            $('#cliente_id').val('');
            $(".seleziona_cliente").toggleClass('nascondi');
            $(".dati_cliente").toggleClass('nascondi');

          
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
                          url:  "{{ route('load-cliente-foglio-servizi-ajax') }}",
                          type: 'POST',
                          dataType: 'json',
                          data: data,
                          success: function(data) {
                            $('#cliente_id').val(data.cliente_id);
                            $('#cliente').val(data.cliente);
                            $('#localita').val(data.localita);
                            $('#sms').val(data.sms);
                            $('#whatsapp').val(data.whatsapp);
                            $('#skype').val(data.skype);
                            
                            $(".seleziona_cliente").toggleClass('nascondi');
                            $(".dati_cliente").toggleClass('nascondi');
                          
                          }
                      }).done(function() {
                        $("#salva_e_continua").removeClass('nascondi');
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
<form action="{{ route('foglio-servizi.store') }}" method="post" id="form_foglio_servizi">
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
          <input name="item" class="clientiDaAssegnare form-control" style="width:400px" placeholder="Seleziona cliente..." value="{{ old('item') }}">     
          <button type="button" class="btn btn-success btn-xs">OK</button>
        </div>
        
         <input type="text"  class="form-control dati_cliente nascondi" name="cliente" id="cliente" placeholder="Cliente" required>

         <input type="hidden" name="cliente_id" id="cliente_id" value="">
       
      </div>
    </div>
    
  </div>


  <div class="row">
    <div class="col-lg-5">
      <div class="form-group">
        <label for="cliente">Località</label>
         <input type="text"  class="form-control dati_cliente nascondi" name="localita" id="localita" placeholder="Località" required>
        <div id="dati_fatturazione" class="seleziona_cliente">Seleziona un cliente</div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-5">
      <div class="form-group">
        <label for="sms">SMS</label>
        <input type="text"  class="form-control dati_cliente nascondi" name="sms" id="sms" placeholder="SMS">
        <div id="dati_fatturazione" class="seleziona_cliente">Seleziona un cliente</div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-5">
      <div class="form-group">
        <label for="whatsapp">WhatsApp</label>
        <input type="text"  class="form-control dati_cliente nascondi" name="whatsapp" id="whatsapp" placeholder="WhatsApp">
        <div id="dati_referente" class="seleziona_cliente">Seleziona un cliente</div>
      </div>
    </div>
  </div>

   <div class="row">
    <div class="col-lg-5">
      <div class="form-group">
        <label for="skype">Skype</label>
        <input type="text"  class="form-control dati_cliente nascondi" name="skype" id="skype" placeholder="Skype">
        <div id="dati_referente" class="seleziona_cliente">Seleziona un cliente</div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col mt-5">
      <button type="submit" id="salva_e_continua" class="btn btn-primary btn-xs dati_cliente nascondi">Salva e continua</button>
    </div>
  </div>
</form>


@endsection

