@extends('layouts.coreui.crm_lara6')

@section('js')
    <script type="text/javascript">

      $(function() {
        var clientiDaAssegnare = {!!$clienti_autocomplete_js!!};
        
        $( ".clientiDaAssegnare" ).autocomplete({
           dropdownWidth:'auto',
           source: [clientiDaAssegnare],
        }).on('selected.xdsoft',function(e,datum){
          if(datum != null)
            {
              if (confirm('Sei sicuro di voler operare sulle evidenze come '+datum+' ?')) {
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
                                window.alert(msg);
                                $(".clientiDaAssegnare").val('');
                                return;
                              }

                          }
                      });// end ajax call
              } // if confirm
            }
        });



        // click su ogni cella della griglia

        $(".clickable").click(function(e){

          e.preventDefault();
          
          @if (!session()->has('nome_cliente') || !session()->has('nome_agente'))
            
            alert('seleziona un cliente!');
          
          @else
            
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
							              window.alert(msg);
							            }
							        }
							    });

          @endif

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
            </h3>
            {{--  Elenco macrolocalita  --}}
            <div class="row">
              <ul class="nav nav-tabs">
                @foreach ($macro as $id => $nome)
                  <li class="nav-item">
                    <a class="nav-link @if ($id == $macro_id) active @endif" href="{{ route('evidenze.view', $id) }}">{{$nome}}</a>
                  </li>
                @endforeach
                </ul>
            </div>


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
            
            <div class="m-portlet__body">
                <div class="tab-content">
                    <div class="m-section">
                        <div class="m-section__content">
                          <div class="Content">
                            <table class="table table-responsive-sm m-table m-table--head-bg-success table-hover table-bordered">
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
                                      <td>{{$item_tipo_ev_mese->pivot->costo}}</td>
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
                                      <td>{{$tipo_evidenza->nome}}</td>
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
           
            
        </div>

    </div>
   
</div>
@endsection


@section('js')
    <script type="text/javascript" charset="utf-8">

        jQuery(document).ready(function(){
            
           
        });
    

    </script>
@endsection