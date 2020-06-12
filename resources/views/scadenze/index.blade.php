@extends('layouts.coreui.crm_lara6')

@section('content')

<div class="row">
  <div class="col-sm-2">
    <div class="callout callout-info b-t-1 b-r-1 b-b-1">
       Elenco scadenze
      @if (isset($scadenze))
      <br>
      <strong class="h4">{{$scadenze->total()}}</strong>
      @endif
    </div>
  </div><!--/.col-->
  @if (count(Request()->query()))
    <div class="col-sm-2">
      <div class="callout callout-noborder">
        <a href="{{ url('scadenze') }}" title="Tutti le scadenze" class="btn btn-warning">
          Tutti
        </a>
      </div>
    </div><!--/.col-->
  @endif
</div>


<div class="row">
    <div class="col">

            {{-- @include('servizi._ricerca_servizi', ['tipo' => $tipo]) --}}
            
            @if (isset($scadenze))
            
              <div>
                  <table class="table table-responsive-sm m-table m-table--head-bg-success table-striped">
                      <thead>
                          <tr>
                            <th>N. Fattura</th>
                            <th class="order" data-orderby="data_scadenza" @if (\Request::get('orderby') == 'data_scadenza' && \Request::get('order') == 'asc') data-order='desc' @else data-order='asc' @endif>
                                Scadenza 
                                @if (\Request::get('orderby') == 'data_scadenza') 
                                    @if (\Request::get('order') == 'asc')
                                        <i class="fa fa-sort-numeric-down"></i>
                                    @else 
                                        <i class="fa fa-sort-numeric-up"></i> 
                                    @endif
                                @endif
                              </th>
                              <th class="order" data-orderby="importo" @if (\Request::get('orderby') == 'importo' && \Request::get('order') == 'asc') data-order='desc' @else data-order='asc' @endif>
                                  Importo 
                                  @if (\Request::get('orderby') == 'importo') 
                                      @if (\Request::get('order') == 'asc')
                                          <i class="fa fa-sort-numeric-down"></i>
                                      @else 
                                          <i class="fa fa-sort-numeric-up"></i> 
                                      @endif
                                  @endif
                              </th>
                              <th class="order" data-orderby="gg_rimasti" @if (\Request::get('orderby') == 'gg_rimasti' && \Request::get('order') == 'asc') data-order='desc' @else data-order='asc' @endif>
                                  Giorni rimanenti 
                                  @if (\Request::get('orderby') == 'gg_rimasti') 
                                      @if (\Request::get('order') == 'asc')
                                          <i class="fa fa-sort-numeric-down"></i>
                                      @else 
                                          <i class="fa fa-sort-numeric-up"></i> 
                                      @endif
                                  @endif
                              </th>
                              <th class="order" data-orderby="tipo_pagamento" @if (\Request::get('orderby') == 'tipo_pagamento' && \Request::get('order') == 'asc') data-order='desc' @else data-order='asc' @endif>
                                  Tipo pagamento 
                                  @if (\Request::get('orderby') == 'tipo_pagamento') 
                                      @if (\Request::get('order') == 'asc')
                                          <i class="fa fa-sort-alpha-down"></i>
                                      @else 
                                          <i class="fa fa-sort-alpha-up"></i> 
                                      @endif
                                  @endif
                              </th>
                              <th>Note</th>
                          </tr>
                      </thead>
                      <tbody>
                          @foreach ($scadenze as $s)
                              <tr>
                                <th scope="row">{{optional($s->fattura)->numero_fattura}}</th>
                                <td>{{optional($s->data_scadenza)->format('d/m/Y')}}</td>
                                <td>{{Utility::formatta_cifra($s->importo,'€')}}</td>
                                <td>0</td>
                                <td>{{optional(optional($s->fattura)->pagamento)->nome}}</td>
                                <td>{{$s->note}}</td>
                              </tr>
                              @php
                                $fattura = $s->fattura;
                              @endphp
                              <tr>
                                <td colspan="2">&nbsp;</td>
                                <td colspan="4">
                                  <table class="table table-responsive-sm table-sm">
                                      <tr>
                                        <th>N. Doc</th>
                                        <th>Data Doc</th>
                                        <th>Cliente</th>
                                        <th>Importo Totale</th>
                                        <th>Tipo</th>
                                      </tr>
                                      <tr>
                                        <td>{{$fattura->numero_fattura}}</td>
                                        <td>{{$fattura->data->format('d/m/Y')}}</td>
                                        <td>{{optional(optional(optional($fattura)->societa)->cliente)->nome}}</td>
                                        <td>{{Utility::formatta_cifra($fattura->totale,'€')}}</td>
                                        <td>{{$fattura->tipo_id}}</td>
                                      </tr>
                                  </table>
                                </td>
                              </tr>
                          @endforeach
                      </tbody>
                  </table>
              </div>
              <div>              
                {{ $scadenze->links() }}
              </div>
            @else
              <div>
                Nessun scadenza
              </div>
            @endif
            
    </div>
</div>


@endsection


@section('js')
    <script type="text/javascript" charset="utf-8">

        jQuery(document).ready(function(){
            
          /*  $("#prodotti").select2({placeholder:"Seleziona i prodotti da filtrare"});

            $(".searching").click(function(){
                $("#searchForm").submit();
            });

            $(".archiviato_check").click(function(){
                $("#searchForm").submit();
            });*/
  
        });
    

    </script>


@endsection