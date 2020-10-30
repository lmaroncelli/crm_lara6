
    <script type="text/javascript">
      
    jQuery(document).ready(function(){


      $("#refresh").click(function(e){
        e.preventDefault();
        caricaGrigliaEvidenze();
      });

      // click su ogni cella della griglia

      $('body').on('click', ".clickable:not(.acquistata_1)", function(e){

          e.preventDefault();

          @if (!session()->has('id_cliente') || !session()->has('id_agente'))
            
            alert('seleziona un cliente!');

          @else
            
            $(".spinner_lu").show();

            var elem = $(this);

            var id_evidenza = elem.attr("data-id-evidenza");
            var id_mese = elem.attr("data-id-mese");
            var data = {
              'id_agente': "{{ session('id_agente') }}",
              'id_cliente': "{{ session('id_cliente') }}",
              'id_evidenza': id_evidenza,
              'id_mese': id_mese
            }  

            $.ajax({
                      url: "{{ route('assegna-mese-evidenza-ajax') }}",
                      data: data,
                      success: function(msg) {
                          if (msg == 'ok') {
                            //location.reload();
                            elem.data('id-hotel',"{{ session('id_cliente') }}");
                            
                            var newclass = 'sfondo_'+ "{{ session('id_agente') }}";
                            elem.toggleClass("sfondo_0 "+newclass);

                            var elem_content = elem.find("div.contenuto_cella").html().trim();

                            if (elem_content == '') 
                              {
                              elem.find("div.contenuto_cella").html("{{ session('id_info') }}");
                              } 
                            else 
                              {
                              elem.find("div.contenuto_cella").html('');
                              }
                            $("#refresh").show();
                            $(".spinner_lu").hide();

                          } else {
                            $(".spinner_lu").hide();
                            window.alert(msg);
                          }
                      }
                  });

          @endif

        });// end clickable:not(.acquistata_1)

        $('body').on('click', ".compra_evidenza", function(e){

            e.preventDefault();

            @if (!session('id_cliente') || !session('id_agente'))
              alert('selezionare il cliente'); return;
            @else

              $(".spinner_lu").show();
              
              var elem = $(this);
              var id_evidenza = elem.attr("data-id-evidenza");
              
              @if (isset($contratto_digitale))
                var contratto_id =  "{{$contratto->id}}";
              @else
                var contratto_id =  0;
              @endif


              var data = {
                'id_agente': "{{ session('id_agente') }}",
                'id_cliente': "{{ session('id_cliente') }}",
                'contratto_id':contratto_id,
                'id_evidenza': id_evidenza,
              }
              
              $.ajax({
                  url: "{{ route('acquista-evidenza-ajax') }}",
                  data: data,
                  success: function(msg) {
                      if (msg == 'ok') {
                        //location.reload();
                        elem.toggleClass('btn-primary btn-warning');
                        elem.toggleClass('compra_evidenza evidenza_comprata');
                        elem.prop('value', 'COMPRATA');
                        $("#refresh").show();
                        $(".spinner_lu").hide();
                      } else {
                        $(".spinner_lu").hide();
                        window.alert(msg);
                      }
                  }
              });        

            @endif

          }); // end compra_evidenza


          $('body').on('click', ".clickable_prelazionata",function(e){

              e.preventDefault();

              @if (!session('id_cliente') || !session('id_agente'))
                alert('selezionare il cliente'); return;
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
                    url: "{{ route('disassocia-mese-evidenza-prelazione-ajax') }}",
                    data: data,
                    success: function(msg) {
                        if (msg == 'ok') {
                          //location.reload();
                          elem.removeClass("sfondo_prelazione");
                          elem.addClass("sfondo_0");
                          elem.removeClass("clickable_prelazionata");
                          elem.data('id-hotel','0');
                          elem.find("div.contenuto_cella").html('');
                          $("#refresh").show();
                          $(".spinner_lu").hide();
                        } else {
                          $(".spinner_lu").hide();
                          window.alert(msg);
                        }
                    }
                });        

              @endif

          }); // end clickable_prelazionata

          $('body').on('click', ".prelaziona_evidenza", function(e){

              e.preventDefault();

              @if (!session('id_cliente') || !session('id_agente'))
                alert('selezionare il cliente'); return;
              @else

                $(".spinner_lu").show();
                
                var elem = $(this);

                var id_evidenza = elem.attr("data-id-evidenza");
                
                var data = {
                  'id_agente': "{{ session('id_agente') }}",
                  'id_cliente': "{{ session('id_cliente') }}",
                  'id_foglio_servizi': 0,
                  'id_evidenza': id_evidenza,
                }
                
                $.ajax({
                    url: "{{ route('prelaziona-evidenza-ajax') }}",
                    data: data,
                    success: function(msg) {
                        if (msg == 'ok') {
                          //location.reload();
                          elem.toggleClass('btn-primary btn-warning');
                          elem.toggleClass('prelaziona_evidenza evidenza_prelazionata');
                          elem.prop('value', 'PRELAZIONATA');
                          $("#refresh").show();
                          $(".spinner_lu").hide();
                        } else {
                          $(".spinner_lu").hide();
                          window.alert(msg);
                        }
                    }
                });        

              @endif

          }); // end prelaziona_evidenza

    }); // end jQuery(document).ready


    </script>



<div class="m-portlet__body">
  <div class="tab-content">
      <div class="m-section">
          <div class="m-section__content">
            <div class="spinner_lu" style="display:none;"></div>
            <div class="Content" style="position: static;">
              <input type="button" class="btn btn-danger btn-xs" name="refresh" value="Rendi effettive le modifiche" id="refresh" style="position: fixed; right: 110px; top: 200px; z-index: 100; display: none;">
              <table class="table table-responsive-sm m-table m-table--head-bg-success table-bordered">
                @php
                    $macrotipologia_old = '';
                @endphp
                @foreach ($tipi_evidenza as $tipo_evidenza)
                    @if ($tipo_evidenza->macrotipologia != $macrotipologia_old)
                    <tr>
                      <td colspan="15" class="griglia_header">{{$tipo_evidenza->macrotipologia}}</td>
                    </tr>
                    @php
                      $macrotipologia_old = $tipo_evidenza->macrotipologia;
                    @endphp
                    @endif
                    <tr>
                      <td>Tipo Offerta</td>
                      @foreach ($tipo_evidenza->mesi as $item_tipo_ev_mese)
                        <td>{{$item_tipo_ev_mese->nome}}</td>
                      @endforeach
                    </tr>
                    <tr>
                      <td>Costo mese</td>
                      @php
                          unset($mesi_non_vendibili);
                      @endphp
                      @foreach ($tipo_evidenza->mesi as $item_tipo_ev_mese)
                        <td>
                          @if (isset($contratto_digitale))
                            @if ($item_tipo_ev_mese->pivot->costo == -1)
                            //
                            @else
                            {{$item_tipo_ev_mese->pivot->costo}}
                            @endif
                          @else
                            <a href="#" class="costo" data-type="text" data-pk="{{$tipo_evidenza->id}} | {{$item_tipo_ev_mese->pivot->mese_id}}" data-url="{{ route('assegna-costo-tipo-evidenza-mese-ajax') }}" data-title="Inserisci il prezzo">
                              @if ($item_tipo_ev_mese->pivot->costo == -1)
                              //
                              @else
                              {{$item_tipo_ev_mese->pivot->costo}}
                              @endif
                            </a>
                          @endif
                        </td>
                        @if ($item_tipo_ev_mese->pivot->costo == -1)
                          {{-- per ogni tipologia trovo i mesi non vendibili --}}
                          @php
                          $mesi_non_vendibili[] = $item_tipo_ev_mese->pivot->mese_id;  
                          @endphp
                        @endif
                      @endforeach
                    </tr>
                    @foreach ($tipo_evidenza->evidenze as $evidenza)
                      <tr id ="{{$evidenza->id}}">
                        <td>{{$tipo_evidenza->nome}}({{$tipo_evidenza->n_min_mesi}})</td>
                        @foreach ($evidenza->mesi as $item_ev_mese)
                          {{-- se il tipo di evidenza per questo mese ha costo -1 vuole dire che NON E' VENDIBILE --}}
                          @if (isset($mesi_non_vendibili) && in_array($item_ev_mese->pivot->mese_id, $mesi_non_vendibili))
                          
                            <td class="non_vendibile">&nbsp;</td>    
                          
                          @elseif($item_ev_mese->pivot->prelazionata)
                            {{-- se è prelazionata ha lo sfondo ad hoc ed il nome del commerciale che ha la prelazione --}}
                      <td class="clickable_prelazionata sfondo_prelazione" data-id-evidenza="{{$evidenza->id}}" data-id-mese="{{$item_ev_mese->pivot->mese_id}}" data-id-hotel="{{$item_ev_mese->pivot->cliente_id}}">
                              <div class="contenuto_cella">
                                {{$clienti_to_info[$item_ev_mese->pivot->cliente_id]}}<br/>{{ucfirst($commerciali_nome[$item_ev_mese->pivot->user_id])}}
                              </div>
                            </td>
                          
                          @else
                            @php
                              // SE SONO IN UN CONTRATTO verifico se evidenza è associata a qualche servizio di questo contratto per EVIDENZIARLA !!
                              if ( isset($contratto_digitale) && in_array($item_ev_mese->pivot->servizioweb_id, $servizi_venduti_ids) )
                                {
                                  $class = 'acquistata_nel_contratto';
                                }
                              else 
                                {
                                  $class = '';
                                }
                            @endphp  
                            {{-- ha lo sfondo del commerciale senza nome --}}
                            <td class="{{$class}} clickable sfondo_{{$item_ev_mese->pivot->user_id}} acquistata_{{$item_ev_mese->pivot->acquistata}}" data-id-evidenza="{{$evidenza->id}}" data-id-mese="{{$item_ev_mese->pivot->mese_id}}" data-id-hotel="{{$item_ev_mese->pivot->cliente_id}}">
                              <div class="contenuto_cella">
                                {{$clienti_to_info[$item_ev_mese->pivot->cliente_id]}}
                              </div>
                            </td>

                          @endif
                        @endforeach 
                        {{-- /foreach mesi --}}
                        @if (session()->has('id_cliente') && $evidenza->mesi->where('pivot.acquistata',0)->where('pivot.prelazionata',0)->where('pivot.cliente_id','!=',0)->count())
                          <td>
                            <input type="button" class="btn btn-primary btn-sm compra_evidenza" data-id-evidenza="{{$evidenza->id}}" name="compra_evidenza" value="Compra">
                          </td>
                          @type('A')
                            <td>
                              <input type="button" class="btn btn-success btn-sm prelaziona_evidenza" data-id-evidenza="{{$evidenza->id}}" name="prelaziona_evidenza" value="Prelaziona">
                            </td>
                          @endtype
                        @else
                          <td>
                            <input type="button" class="btn btn-info btn-sm disabled" name="compra_evidenza" value="Compra">
                          </td>
                          @type('A')
                            <td>
                              <input type="button" class="btn btn-success btn-sm disabled" name="prelaziona_evidenza" value="Prelaziona">
                            </td>
                          @endtype
                        @endif
                      </tr>
                    @endforeach


                @endforeach
              </table>
            </div>
          </div>
      </div>
  </div>
</div>