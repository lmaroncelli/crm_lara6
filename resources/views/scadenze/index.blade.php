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

            @include('scadenze._ricerca_scadenze')
            
            @if (isset($scadenze))
            
              <div>
                  <table class="table table-responsive-sm m-table m-table--head-bg-success wrapper">
                      <tbody>
                          @foreach ($scadenze as $s)
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
                                  <th class="order" data-orderby="giorni_rimasti" @if (\Request::get('orderby') == 'giorni_rimasti' && \Request::get('order') == 'asc') data-order='desc' @else data-order='asc' @endif>
                                      Giorni rimanenti 
                                      @if (\Request::get('orderby') == 'giorni_rimasti') 
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
                              <tr class="main">
                                <th scope="row">{{optional($s->fattura)->numero_fattura}}</th>
                                <td>{{optional($s->data_scadenza)->format('d/m/Y')}}</td>
                                <td>{{Utility::formatta_cifra($s->importo,'€')}}</td>
                                <td>{{$s->giorni_rimasti}}</td>
                                <td>{{optional(optional($s->fattura)->pagamento)->nome}}</td>
                                <td>{{$s->note}}</td>
                              </tr>
                              @php
                                $fattura = $s->fattura;
                              @endphp
                              <tr>
                                <td colspan="1">&nbsp;</td>
                                <td colspan="5">
                                  <table class="table table-responsive-sm m-table m-table--head-bg-success">
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
                                        <td>{{optional(optional(optional($fattura)->societa)->ragioneSociale)->nome}}</td>
                                        <td>{{Utility::formatta_cifra($fattura->totale,'€')}}</td>
                                        <td>{{$fattura->tipo_id}}</td>
                                      </tr>
                                  </table>
                                </td>
                              </tr>
                              @if ($fattura->avvisi->count())
                                <tr>
                                  <td colspan="1">&nbsp;</td>
                                  <td colspan="5">
                                     <table class="table table-responsive-sm m-table m-table--head-bg-success">
                                        <tr>
                                          <th>Data</th>
                                          <th>Tipo</th>
                                          <th>Giorni</th>
                                          <th>Email</th>
                                        </tr>
                                        @foreach ($fattura->avvisi as $avviso)
                                          <tr>
                                            <td>{{$avviso->data->format('d/m/Y H:i')}}</td>
                                            <td>{{$avviso->tipo_pagamento}}</td>
                                            <td>{{$avviso->giorni}}</td>
                                            <td>{{$avviso->email}}</td>
                                          </tr>        
                                        @endforeach
                                      </table>
                                  </td>
                                </tr>
                              @endif
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