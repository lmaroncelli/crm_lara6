@extends('layouts.coreui.crm_lara6')

@section('content')
<div class="spinner_lu" style="display:none;"></div>
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
  @if (session()->has('scadenze_csv')) 
    <div class="col-sm-2">
      <div class="callout callout-noborder">
        <a href="{{ route('scadenze.csv') }}" title="Esporta in CSV" class="btn btn-success">
          <i class="fas fa-file-csv"></i> Export CSV
        </a>
      </div>
    </div>
  @endif
</div>


<div class="row">
    <div class="col">

            @include('scadenze._ricerca_scadenze')
            
            @if (isset($scadenze) && !is_null($scadenze))
            
              <div>
                  <table class="table table-responsive m-table m-table--head-bg-success wrapper">
                      <tbody>
                          @foreach ($scadenze as $s)
                              <tr class="main row_{{$s->id}}">
                                <th></th>
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

                                  @if (!$pagata)
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
                                  @endif
                                  
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
                                  <th>Commerciale</th>
                                  <th>Note</th>
                              </tr>
                              <tr class="main row_{{$s->id}}">
                                <td>
                                  @if (!$pagata)
                                    <a href="#" class="btn btn-warning m-btn m-btn--icon m-btn--icon-only switch_incassata" data-id="{{$s->id}}"><i class="nav-icon icon-login"></i></a>
                                  @else
                                    <a href="#" class="btn btn-danger m-btn m-btn--icon m-btn--icon-only switch_da_pagare" data-id="{{$s->id}}"><i class="nav-icon icon-close"></i></a>
                                  @endif
                                </td>
                                <th scope="row">{{optional($s->fattura)->numero_fattura}}</th>
                                <td>{{optional($s->data_scadenza)->format('d/m/Y')}}</td>
                                <td>{{Utility::formatta_cifra($s->importo,'€')}}</td>

                                @if (!$pagata)
                                  <td>
                                    @if ($s->giorni_rimasti <= 0)
                                      <i class="bg-danger p-1 m-1">{{$s->giorni_rimasti}}</i>
                                    @elseif ($s->giorni_rimasti > 0 && $s->giorni_rimasti < 15)
                                      <i class="bg-warning p-1 m-1" style="color:#000;">{{$s->giorni_rimasti}}</i>
                                    @else
                                      {{$s->giorni_rimasti}}
                                    @endif
                                    <a href="#" class="send_mail_notification" data-id="{{$s->id}}"><i class="fas fa-envelope"></i></a>
                                  </td>
                                @endif
                                
                                <td>{{optional(optional($s->fattura)->pagamento)->nome}}</td>
                                <td>{{optional(optional(optional($s->fattura)->societa)->cliente)->commerciali()}}</td>
                                <td style="width: 35%;">{{$s->note}}</td>
                              </tr>
                              @php
                                $fattura = $s->fattura;
                              @endphp
                              <tr class="dettaglio_fattura row_{{$s->id}}">
                                <td colspan="1" style="text-align: right"><i class="fas fa-angle-right"></i></td>
                                <td colspan="6">Dettaglio Fattura</td>
                              </tr>
                              <tr class="riga_fattura ">
                                <td colspan="1">&nbsp;</td>
                                <td colspan="6">
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
                                <tr class="avvisi_scadenze row_{{$s->id}}">
                                  <td colspan="1" style="text-align: right"><i class="fas fa-angle-right"></i></td>
                                  <td colspan="6">Avvisi Scadenze</td>
                                </tr>
                                <tr class="riga_scadenze row_{{$s->id}}">
                                  <td colspan="1">&nbsp;</td>
                                  <td colspan="6">
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

        

        function ajaxSwtch(data, scadenza_id) {

          $.ajax({
                  url: "{{ route('switch-scadenza-ajax') }}",
                  type: 'POST',
                  data: data,
                  success: function(msg) {
                      $(".row_"+scadenza_id).fadeOut();
                      $(".spinner_lu").hide();
                  },
                  error: function() {
                    $(".spinner_lu").hide();
                  }
              });

        }
      


        $(document).ready(function(){
            

          $("tr.dettaglio_fattura").click(function(){
            $(this).next().toggleClass('riga_fattura');
            $(this).find("i").toggleClass('fa-angle-right fa-angle-down');
          })

          $("tr.avvisi_scadenze").click(function(){
            $(this).next().toggleClass('riga_scadenze');
          })

          $(".searching").click(function(){
              $("#searchForm").submit();
          });

          /*  $("#prodotti").select2({placeholder:"Seleziona i prodotti da filtrare"});


            $(".archiviato_check").click(function(){
                $("#searchForm").submit();
            });*/

          $(".send_mail_notification").click(function(e){
              
              e.preventDefault();
              $(".spinner_lu").show();


              let scadenza_id = $(this).data("id");
                            
              data = {
                scadenza_id:scadenza_id
                  };
              
              $.ajax({
                  url: "{{ route('send-mail-avviso-pagamento-ajax') }}",
                  type: 'POST',
                  data: data,
                  success: function(msg) {
                      alert(msg);
                      $(".spinner_lu").hide();
                  },
                  error: function() {
                    $(".spinner_lu").hide();
                  }
              });

          });





          $(".switch_incassata").click(function(e){

              e.preventDefault();

              if (window.confirm('Sicuro?')) {
                
              
                  $(".spinner_lu").show();


                  let scadenza_id = $(this).data("id");
                                
                  data = {
                    scadenza_id:scadenza_id,
                    pagata:1
                      };

                  ajaxSwtch(data, scadenza_id);

              }
              
          });


          

          $(".switch_da_pagare").click(function(e){

              e.preventDefault();

              if (window.confirm('Sicuro?')) {

                    $(".spinner_lu").show();


                    let scadenza_id = $(this).data("id");
                                  
                    data = {
                      scadenza_id:scadenza_id,
                      pagata:0
                        };
                    
                    ajaxSwtch(data, scadenza_id);
              }

          });
  
        });
    

    </script>


@endsection