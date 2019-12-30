@extends('layouts.coreui.crm_lara6')

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


            <form action="" method="get" id="searchForm" accept-charset="utf-8">
              <div class="row">
                Seleziona cliente
              </div>
            </form>


            <div class="row legenda">
              <ul>
                @foreach ($commerciali as $id => $name)
                    <li class="sfondo_{{$id}}">{{$name}}</li>
                @endforeach
                <li class="sfondo_prelazione">Prelazione</li>
              </ul>
            </div>

           
            <div class="m-portlet__body">
                <div class="tab-content">
                    <div class="m-section">
                        <div class="m-section__content">
                            <table class="table table-responsive-sm m-table m-table--head-bg-success table-hover">
                              <tr>
                                <td>griglia</td>
                              </tr>
                              @php
                                  $macrotipologia_old = '';
                              @endphp
                              @foreach ($tipi_evidenza as $tipo_evidenza)
                                  @if ($tipo_evidenza->macrotipologia != $macrotipologia_old)
                                  <tr>
                                    <td colspan="13">{{$tipo_evidenza->macrotipologia}}</td>
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
                                    <tr>
                                      <td>{{$tipo_evidenza->nome}}</td>
                                      @foreach ($evidenza->mesi as $item_ev_mese)
                                        {{-- se il tipo di evidenza per questo mese ha costo -1 vuole dire che NON E' VENDIBILE --}}
                                        @if (isset($mesi_non_vendibili) && in_array($item_ev_mese->pivot->mese_id, $mesi_non_vendibili))
                                        
                                          <td class="non_vendibile">&nbsp;</td>    
                                        
                                        @elseif($item_ev_mese->pivot->prelazionata)
                                          {{-- se è prelazionata ha lo sfondo ad hoc ed il nome del commerciale che ha la prelazione --}}
                                          <td class="sfondo_prelazione">
                                            {{$clienti_to_info[$item_ev_mese->pivot->cliente_id]}}<br/>{{ucfirst($commerciali_nome[$item_ev_mese->pivot->user_id])}}
                                          </td>
                                        
                                        @else
                                          {{-- ha lo sfondo del commerciale senza nome --}}
                                          <td class="sfondo_{{$item_ev_mese->pivot->user_id}}">
                                            {{$clienti_to_info[$item_ev_mese->pivot->cliente_id]}}
                                          </td>

                                        @endif
                                      @endforeach
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
@endsection


@section('js')
    <script type="text/javascript" charset="utf-8">

        jQuery(document).ready(function(){
            
           
        });
    

    </script>
@endsection