@extends('layouts.coreui.crm_lara6')

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
      
      <textarea id="cliente" class="form-control dati_cliente nascondi" name="cliente" rows="5"></textarea>
      <div class="seleziona_cliente">Seleziona un cliente</div>
    </div>
  </div>

  <div class="col-lg-5">
    <div class="form-group">
      <label for="fatturazione">Dati Fatturazione</label>
      <textarea id="fatturazione" class="form-control dati_cliente nascondi" name="fatturazione" rows="5"></textarea>
      <div class="seleziona_cliente">Seleziona un cliente</div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-lg-5">
    <div class="form-group">
      <label for="referente">Dati Referente</label>
      <textarea id="referente" class="form-control dati_cliente nascondi" name="referente" rows="5"></textarea>
      <div class="seleziona_cliente">Seleziona un cliente</div>
    </div>
  </div>
</div>


@endsection


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
                 $(".spinner_lu").show();
                data = {
                        item:datum
                      };
                      $.ajax({
                          url:  "{{ route('seleziona-cliente-contratto-digitale-ajax') }}",
                          data: data,
                          success: function(msg) {
                              if (msg == 'ok') {
                                window.location.reload(true);
                                
                              } else {
                                 $(".spinner_lu").hide();
                                window.alert(msg);
                                $(".clientiDaAssegnare").val('');
                                return;
                              }

                          }
                      });// end ajax call
              } // if confirm
            }
        });




		});
	

	</script>
	
@endsection