@section('js_griglia_evidenze')
    <script type="text/javascript">
      
    jQuery(document).ready(function(){

      // click su ogni cella della griglia

      $(".clickable:not(.acquistata_1)").click(function(e){

          e.preventDefault();

          @if (!session()->has('id_cliente') || !session()->has('id_agente'))
            
            alert('seleziona un cliente!');

          @else
            
            $(".spinner_lu").show();

            var id_evidenza = $(this).attr("data-id-evidenza");
            var id_mese = $(this).attr("data-id-mese");
            
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
                            location.reload();
                          } else {
                            $(".spinner_lu").hide();
                            window.alert(msg);
                          }
                      }
                  });

          @endif

        });// end clickable:not(.acquistata_1)

        $(".compra_evidenza").click(function(e){

            e.preventDefault();

            @if (!session('id_cliente') || !session('id_agente'))
              alert('selezionare il cliente'); return;
            @else

              $(".spinner_lu").show();
              
              var id_evidenza = $(this).attr("data-id-evidenza");
              
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
                        location.reload();
                      } else {
                        $(".spinner_lu").hide();
                        window.alert(msg);
                      }
                  }
              });        

            @endif

          }); // end compra_evidenza



    }); // end jQuery(document).ready


    </script>
@endsection


<div class="m-portlet__body">
  <div class="tab-content">
      <div class="m-section">
          <div class="m-section__content">
            <div class="spinner_lu" style="display:none;"></div>
            <div class="Content">
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
                            {{-- ha lo sfondo del commerciale senza nome --}}
                            <td class="clickable sfondo_{{$item_ev_mese->pivot->user_id}} acquistata_{{$item_ev_mese->pivot->acquistata}}" data-id-evidenza="{{$evidenza->id}}" data-id-mese="{{$item_ev_mese->pivot->mese_id}}" data-id-hotel="{{$item_ev_mese->pivot->cliente_id}}">
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
                          <td>
                            <input type="button" class="btn btn-success btn-sm prelaziona_evidenza" data-id-evidenza="{{$evidenza->id}}" name="prelaziona_evidenza" value="Prelaziona">
                          </td>
                        @else
                          <td>
                            <input type="button" class="btn btn-info btn-sm disabled" name="compra_evidenza" value="Compra">
                          </td>
                          <td>
                             <input type="button" class="btn btn-success btn-sm disabled" name="prelaziona_evidenza" value="Prelaziona">
                          </td>
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