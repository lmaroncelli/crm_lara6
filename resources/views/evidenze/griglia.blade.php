@extends('layouts.coreui.crm_lara6')

@section('js')
    
    @include('javascript_view.js_griglia')


    <script type="text/javascript">

      function caricaGrigliaEvidenze(destroy_session = 0) {
                
            $(".spinner_lu").show();
            
            var macro_id = '{{$macro_id}}';

            data = {
              macro_id:macro_id,
              destroy_session:destroy_session
            };
            
            $.ajax({
                url: "{{ route('crea_griglia_evidenza_ajax') }}",
                type: 'POST',
                data: data,
                success: function(griglia) {
                    $("#griglia_evidenze").html("");
                    $("#griglia_evidenze").html(griglia);

                    $(".spinner_lu").hide();
                },
                error: function() {
                  $(".spinner_lu").hide();
                }
            });
  
      }


      $(function() {

        caricaGrigliaEvidenze();

        $('body').on('click', "#refresh", function(e) {
             e.preventDefault();
             caricaGrigliaEvidenze();
            
        });

        var clientiDaAssegnare = {!!$clienti_autocomplete_js!!};
        
        $( ".clientiDaAssegnare" ).autocomplete({
           dropdownWidth:'auto',
           source: [clientiDaAssegnare],
        }).on('selected.xdsoft',function(e,datum){
          if(datum != null)
            {
              if (confirm('Sei sicuro di voler operare sulle evidenze come '+datum+' ?')) {
                 $(".spinner_lu").show();
                data = {
                        item:datum,
                        macro_id:"{{ $macro_id }}"
                      };
                      $.ajax({
                          url:  "{{ route('seleziona-cliente-evidenze-ajax') }}",
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


        $('body').on('click', ".clickable.acquistata_1", function(e){
      
          e.preventDefault();
          
          @if (!session()->has('nome_cliente') || !session()->has('nome_agente'))
            
            alert('seleziona un cliente!');
          
          @else
            
            var elem = $(this);
          
            var id_hotel = elem.attr("data-id-hotel");
            var id_cliente_session = {{ session('id_cliente') }};

            if (id_cliente_session != id_hotel) {
                  
              alert('selezionare il cliente corretto!!'); 

              return;
            }

            $(".spinner_lu").show();


            var id_evidenza = elem.attr("data-id-evidenza");
						var id_mese = elem.attr("data-id-mese");
            
            var data = {
              'id_evidenza': id_evidenza,
              'id_mese': id_mese
            }  

             $.ajax({
							        url: "{{ route('annulla_acquisto_evidenza_ajax') }}",
							        data: data,
							        success: function(msg) {
							            if (msg == 'ok') {
							             //location.reload();
							             elem.removeClass();
                           elem.addClass('clickable sfondo_0 acquistata_0');
                           $("#refresh").show();
                           $(".spinner_lu").hide();
                          } else {
                            $(".spinner_lu").hide();
							              window.alert(msg);
							            }
							        }
							    });

          @endif

        });

        $.fn.editable.defaults.mode = 'inline';
        $.fn.editable.defaults.ajaxOptions = {type: "GET"};
        $('.costo').editable({
          error: function(response, newValue) {
                        return '';
                  },
          
        });


        /**
          * Store scroll position for and set it after reload
          *
          * @return {boolean} [loacalStorage is available]
          */
        $.fn.scrollPosReaload = function(){
            if (localStorage) {
                var posReader = localStorage["posStorage"];
                if (posReader) {
                    $('.Content').scrollTop(posReader);
                    localStorage.removeItem("posStorage");
                }
                $(this).click(function(e) {
                    localStorage["posStorage"] = $('.Content').scrollTop();
                });

                return true;
            }

            return false;
        }

        @foreach ($tipi_evidenza as $tipo_evidenza)
          @foreach ($tipo_evidenza->evidenze as $evidenza)
            
            var id = '{{$evidenza->id}}';
            $('#'+id).scrollPosReaload();

          @endforeach
        @endforeach


      });

</script>
@endsection


@section('content')

<div class="row">
    <div class="col-xl-12">

        <div class="m-portlet m-portlet--last m-portlet--head-lg m-portlet--responsive-mobile" id="main_portlet">
            <div class="m-portlet__head">
                <div class="m-portlet__head-progress">
                    
                    <!-- here can place a progress bar-->
                </div>
                <div class="m-portlet__head-wrapper">
                    <div class="m-portlet__head-caption" style="width: 100%;">
                        
                        <div class="m-portlet__head-title col-x-6">
                            <h3 class="m-portlet__head-text" style="width: 200px;">
                                Evidenze
                                &nbsp;&nbsp; <span class="m-badge m-badge--success m-badge--wide">{{ date('Y') }}</span>
                            </h3>
                        </div>
                      
                    
                    </div>
                

                </div>
            </div>


            <div class="row legenda">
              <ul>
                @foreach ($commerciali as $id => $name)
                    <li class="sfondo_{{$id}}">{{$name}}</li>
                @endforeach
                <li class="sfondo_prelazione">Prelazione</li>
              </ul>
            </div>

            <h4 class="m-portlet__head-text" style="width: 100px;">
                Località
            </h4>
            {{--  Elenco macrolocalita  --}}
            <div class="row">
              <ul class="nav nav-tabs nav-griglia">
                @foreach ($macro as $id => $nome)
                  <li class="nav-item">
                    <a class="nav-link @if ($id == $macro_id) active @endif" href="{{ route('evidenze.view', $id) }}">{{$nome}}</a>
                  </li>
                @endforeach
                </ul>
            </div>

            @if ($macro_id)
                
              <div class="row">
                @if (session()->has('nome_cliente') && session()->has('nome_agente'))
                <form action="{{ route('cambia-clinte') }}">
                  <div class="input-group m-4 alert alert-dark">
                    CLIENTE SELEZIONATO: {{session('id_info')}} - {{session('nome_cliente')}}<br/>
                    AGENTE: {{session('nome_agente')}}
                    <button type="submit" id="cambia" class="btn btn-block btn-primary">CAMBIA</button>  
                  </div>
                </form>
                  @else
                  <form class="form-inline" id="searchForm" accept-charset="utf-8">
                    <div class="input-group m-4">
                      <label for="clientiDaAssegnare" class="m-1">SELEZIONA CLIENTE:</label>
                      <input class="clientiDaAssegnare form-control" style="width:400px" placeholder="ID-nomehotel">     
                    </div>
                    <button type="button" class="btn btn-success btn-xs">OK</button>
                  </form>
                  @endif
              </div>

            @endif
            <div class="spinner_lu" style="display:none;"></div>
            {{-- griglia_evidenze --}}
            <div class="griglia_evidenze" id="griglia_evidenze"></div>
            {{-- END griglia_evidenze --}}
            
        </div>

    </div>
   
</div>
@endsection