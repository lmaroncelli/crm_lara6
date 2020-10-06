@extends('layouts.coreui.crm_lara6')

@section('content')

<div class="row">
  <div class="col-sm-2">
    <div class="callout callout-info b-t-1 b-r-1 b-b-1">
       Elenco righe conteggio {{$conteggio->titolo}}
      @if (isset($righe))
      <br>
      <strong class="h4">{{$righe->total()}}</strong>
      @endif
    </div>
  </div><!--/.col-->
</div>


<riga-conteggio conteggio_id="{{$conteggio->id}}" commerciale_id="{{Auth::id()}}"></riga-conteggio>

<form action="{{ route('conteggi.edit',$conteggio->id) }}" method="get" id="searchForm" accept-charset="utf-8">
  <input type="hidden" name="orderby" id="orderby" value="">
  <input type="hidden" name="order" id="order" value="">
</form>


@foreach ($righe as $r)
  <form action="{{ route('conteggi.destroy.riga',$r->id) }}" method="POST" id="delete_item_{{$r->id}}">
    @csrf
    @method('DELETE')
  </form>
@endforeach

<div class="row">
  <div class="col">
    @if ($righe->total())
      <div>
          <table class="table table-responsive">
              <tbody>
                <tr>
                  <th class="order" data-orderby="nome" @if (\Request::get('orderby') == 'nome' && \Request::get('order') == 'asc') data-order='desc' @else data-order='asc' @endif>
                    Cliente 
                    @if (\Request::get('orderby') == 'nome') 
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
                  <th class="order" data-orderby="nome_servizio" @if (\Request::get('orderby') == 'nome_servizio' && \Request::get('order') == 'asc') data-order='desc' @else data-order='asc' @endif>
                    Servizi 
                    @if (\Request::get('orderby') == 'nome_servizio') 
                        @if (\Request::get('order') == 'asc')
                            <i class="fa fa-sort-alpha-down"></i>
                        @else 
                            <i class="fa fa-sort-alpha-up"></i> 
                        @endif
                    @endif
                  </th>
                  <th class="order" data-orderby="reale" @if (\Request::get('orderby') == 'reale' && \Request::get('order') == 'asc') data-order='desc' @else data-order='asc' @endif>
                    Valore 
                    @if (\Request::get('orderby') == 'reale') 
                        @if (\Request::get('order') == 'asc')
                            <i class="fa fa-sort-numeric-down"></i>
                        @else 
                            <i class="fa fa-sort-numeric-up"></i> 
                        @endif
                    @endif
                  </th>
                  <th class="order" data-orderby="nome_modalita" @if (\Request::get('orderby') == 'nome_modalita' && \Request::get('order') == 'asc') data-order='desc' @else data-order='asc' @endif>
                    Modalità 
                    @if (\Request::get('orderby') == 'nome_modalita') 
                        @if (\Request::get('order') == 'asc')
                            <i class="fa fa-sort-alpha-down"></i>
                        @else 
                            <i class="fa fa-sort-alpha-up"></i> 
                        @endif
                    @endif
                  </th> 	
                  <th class="order" data-orderby="percentuale" @if (\Request::get('orderby') == 'percentuale' && \Request::get('order') == 'asc') data-order='desc' @else data-order='asc' @endif>
                    Val. % 
                    @if (\Request::get('orderby') == 'percentuale') 
                        @if (\Request::get('order') == 'asc')
                            <i class="fa fa-sort-numeric-down"></i>
                        @else 
                            <i class="fa fa-sort-numeric-up"></i> 
                        @endif
                    @endif
                  </th>
                  <th></th>
                </tr>
                @foreach ($righe as $r) 
                  @if (!is_null($r->cliente))
                    @php
                        $servizi_arr = [];
                        foreach ($r->servizi as $servizio) 
                          {
                          $servizi_arr[] = $servizio->prodotto->nome;
                          }
                    @endphp  
                    <tr>
                      <td>{{optional($r->cliente)->nome}}</td>
                      <td>{{optional($r->cliente)->id_info}}</td>
                      <td>{{implode(',', $servizi_arr)}}</td>
                      <td>{{$r->reale}}</td>
                      <td>{{optional($r->modalita)->nome}}</td>
                      <td>{{$r->percentuale}} %</td>
                      <td>
                        <a data-id="{{$r->id}}" href="#" class="delete btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></a>
                      </td>
                    </tr>
                  @endif
                @endforeach
              </tbody>
          </table>
      </div>
      <div>              
        {{ $righe->links() }}
      </div>
    @else
      <div>
        Nessuna riga per questo conteggio
      </div>
    @endif      
  </div>
</div>


@endsection


@section('js')
    <script type="text/javascript" charset="utf-8">

        jQuery(document).ready(function(){
            
  
        });
    

    </script>


@endsection