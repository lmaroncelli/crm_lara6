@extends('layouts.coreui.crm_lara6')

@section('content')

<div class="row">
  <div class="col-sm-2">
    <div class="callout callout-info b-t-1 b-r-1 b-b-1">
       Elenco servizi
      @if (isset($servizi))
      <br>
      <strong class="h4">{{$servizi->total()}}</strong>
      @endif
    </div>
  </div><!--/.col-->
  @if (count(Request()->query()))
    <div class="col-sm-2">
      <div class="callout callout-noborder">
        <a href="{{ url('servizi') }}" title="Tutti i servizi" class="btn btn-warning">
          Tutti
        </a>
      </div>
    </div><!--/.col-->
  @endif
</div>


<div class="row">
    <div class="col">

            @include('servizi._ricerca_servizi')
            
            @if (isset($servizi))
            
              <div>
                  <table class="table table-responsive-sm m-table m-table--head-bg-success table-hover">
                      <thead>
                          <tr>
                            <th class="order" data-orderby="nome_prodotto" @if (\Request::get('orderby') == 'nome_prodotto' && \Request::get('order') == 'asc') data-order='desc' @else data-order='asc' @endif>
                                  Prodotto 
                                  @if (\Request::get('orderby') == 'nome_prodotto') 
                                      @if (\Request::get('order') == 'asc')
                                          <i class="fa fa-sort-alpha-down"></i>
                                      @else 
                                          <i class="fa fa-sort-alpha-up"></i> 
                                      @endif
                                  @endif
                              </th>
                              <th class="order" data-orderby="nome_cliente" @if (\Request::get('orderby') == 'nome_cliente' && \Request::get('order') == 'asc') data-order='desc' @else data-order='asc' @endif>
                                  Cliente 
                                  @if (\Request::get('orderby') == 'nome_cliente') 
                                      @if (\Request::get('order') == 'asc')
                                          <i class="fa fa-sort-alpha-down"></i>
                                      @else 
                                          <i class="fa fa-sort-alpha-up"></i> 
                                      @endif
                                  @endif
                              </th>
                              <th class="order" data-orderby="id_info" @if (\Request::get('orderby') == 'id_info' && \Request::get('order') == 'asc') data-order='desc' @else data-order='asc' @endif>
                                  ID 
                                  @if (\Request::get('orderby') == 'id_info') 
                                      @if (\Request::get('order') == 'asc')
                                          <i class="fa fa-sort-numeric-down"></i>
                                      @else 
                                          <i class="fa fa-sort-numeric-up"></i> 
                                      @endif
                                  @endif
                              </th>
                              <th class="order" data-orderby="localita_id" @if (\Request::get('orderby') == 'localita_id' && \Request::get('order') == 'asc') data-order='desc' @else data-order='asc' @endif>
                                  Località 
                                  @if (\Request::get('orderby') == 'localita_id') 
                                      @if (\Request::get('order') == 'asc')
                                          <i class="fa fa-sort-alpha-down"></i>
                                      @else 
                                          <i class="fa fa-sort-alpha-up"></i> 
                                      @endif
                                  @endif
                              </th>
                              <th class="order" data-orderby="data_inizio" @if (\Request::get('orderby') == 'data_inizio' && \Request::get('order') == 'asc') data-order='desc' @else data-order='asc' @endif>
                                  Inizio 
                                  @if (\Request::get('orderby') == 'data_inizio') 
                                      @if (\Request::get('order') == 'asc')
                                          <i class="fa fa-sort-numeric-down"></i>
                                      @else 
                                          <i class="fa fa-sort-numeric-up"></i> 
                                      @endif
                                  @endif
                              </th>
                              <th class="order" data-orderby="data_fine" @if (\Request::get('orderby') == 'data_fine' && \Request::get('order') == 'asc') data-order='desc' @else data-order='asc' @endif>
                                  Scadenza 
                                  @if (\Request::get('orderby') == 'data_fine') 
                                      @if (\Request::get('order') == 'asc')
                                          <i class="fa fa-sort-numeric-down"></i>
                                      @else 
                                          <i class="fa fa-sort-numeric-up"></i> 
                                      @endif
                                  @endif
                              </th>
                              <th>N. Fattura</th>
                              <th>Note</th>
                              <th></th>
                          </tr>
                      </thead>
                      <tbody>
                          @foreach ($servizi as $s)
                              <form action="{{ route('servizi.destroy',$s->id) }}" method="POST" id="delete_item_{{$s->id}}">
                                  @csrf
                                  @method('DELETE')
                              </form>
                              <tr>
                                <th scope="row"><a href="#" title="Modifica servizi">{{optional($s->prodotto)->nome}}</a></th>
                                <td>{{optional($s->cliente)->nome}}</td>
                                <td>{{optional($s->cliente)->id_info}}</td>
                                <td>{{optional(optional($s->cliente)->localita)->nome}}</td>
                                <td>{{optional($s->data_inizio)->format('d/m/Y')}}</td>
                                <td>{{optional($s->data_fine)->format('d/m/Y')}}</td>
                                <td>{{optional($s->fattura)->numero_fattura}}</td>
                                <td>{{$s->note}}</td>
                                <td>
                                  <a data-id="{{$s->id}}" href="#" class="delete btn btn-danger"><i class="fas fa-trash-alt"></i></a>
                                </td>
                              </tr>
                          @endforeach
                      </tbody>
                  </table>
              </div>
              <div>              
                {{ $servizi->links() }}
              </div>
            @else
              <div>
                Nessun servizio
              </div>
            @endif
            
    </div>
</div>
@endsection


@section('js')
    <script type="text/javascript" charset="utf-8">

        jQuery(document).ready(function(){
            
            $("#prodotti").select2({placeholder:"Seleziona i prodotti da filtrare"});

            $(".searching").click(function(){
                $("#searchForm").submit();
            });

            $(".archiviato_check").click(function(){
                $("#searchForm").submit();
            });
  
        });
    

    </script>


@endsection