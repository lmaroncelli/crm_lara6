@extends('layouts.coreui.crm_lara6')


@section('js')
	<script type="text/javascript" charset="utf-8">
		
	

		jQuery(document).ready(function(){

        $(".toggle").click(function(){
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

                                });

                          }
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


<div class="row mt-2 row justify-content-between">
    <div class="col-lg-5">
     <div class="card card-accent-primary">
        <div class="card-header">Contratto fornutura servizi</div>
        <div class="card-body">
            
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
      <label for="cliente">Cliente</label> <a href="#" class="toggle">Nuovo cliente?</a>
      
      <div class="input-group mb-3 dati_cliente">
        <input class="clientiDaAssegnare form-control" style="width:400px" placeholder="Seleziona cliente...">     
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
      <div class="seleziona_cliente">Seleziona un cliente</div>
    </div>
  </div>
</div>


@endsection
