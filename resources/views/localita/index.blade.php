@extends('layouts.coreui.crm_lara6')

@section('content')

<div class="row">
  <div class="col-sm-2">
    <div class="callout callout-info b-t-1 b-r-1 b-b-1">
       Elenco localita
      @if (isset($localita))
      <br>
      <strong class="h4">{{$localita->total()}}</strong>
      @endif
    </div>
  </div><!--/.col-->
  @if (count(Request()->query()))
    <div class="col-sm-2">
      <div class="callout callout-noborder">
        <a href="{{ url('localita') }}" title="Tutti i localita" class="btn btn-warning">
          Tutte
        </a>
      </div>
    </div><!--/.col-->
  @endif
    <div class="to-right">
      <div class="callout callout-noborder">
        <a href="{{ route('localita.create') }}" title="Nuova localita" class="btn btn-primary">
          Nuova localita
        </a>
        <a href="{{ route('comune.create') }}" title="Nuovo comune" class="btn btn-warning">
          Nuovo comune
        </a>
      </div>
    </div><!--/.col-->
</div>


<div class="row">
    <div class="col">

            @include('localita._ricerca_localita')
            
            @if (isset($localita))
              @foreach ($localita as $l)
                <form action="{{ route('localita.destroy',$l->id) }}" method="POST" id="delete_item_{{$l->id}}">
                    @csrf
                    @method('DELETE')
                </form>
              @endforeach
              <div>
                  <table class="table table-responsive-sm m-table m-table--head-bg-success table-hover">
                      <thead>
                          <tr>
                              
                              <th class="order" data-orderby="nome" @if (\Request::get('orderby') == 'nome' && \Request::get('order') == 'asc') data-order='desc' @else data-order='asc' @endif>
                                  Nome 
                                  @if (\Request::get('orderby') == 'nome') 
                                      @if (\Request::get('order') == 'asc')
                                          <i class="fa fa-sort-alpha-down"></i>
                                      @else 
                                          <i class="fa fa-sort-alpha-up"></i> 
                                      @endif
                                  @endif
                              </th>
                              
                              <th class="order" data-orderby="nome_comune" @if (\Request::get('orderby') == 'nome_comune' && \Request::get('order') == 'asc') data-order='desc' @else data-order='asc' @endif>
                                  Comune 
                                  @if (\Request::get('orderby') == 'nome_comune') 
                                      @if (\Request::get('order') == 'asc')
                                          <i class="fa fa-sort-alpha-down"></i>
                                      @else 
                                          <i class="fa fa-sort-alpha-up"></i> 
                                      @endif
                                  @endif
                              </th>
                              
                              <th class="order" data-orderby="nome_provincia" @if (\Request::get('orderby') == 'nome_provincia' && \Request::get('order') == 'asc') data-order='desc' @else data-order='asc' @endif>
                                  Provincia 
                                  @if (\Request::get('orderby') == 'nome_provincia') 
                                      @if (\Request::get('order') == 'asc')
                                          <i class="fa fa-sort-numeric-down"></i>
                                      @else 
                                          <i class="fa fa-sort-numeric-up"></i> 
                                      @endif
                                  @endif
                              </th>

                              <th class="order" data-orderby="nome_regione" @if (\Request::get('orderby') == 'nome_regione' && \Request::get('order') == 'asc') data-order='desc' @else data-order='asc' @endif>
                                Regione 
                                @if (\Request::get('orderby') == 'nome_regione') 
                                    @if (\Request::get('order') == 'asc')
                                        <i class="fa fa-sort-numeric-down"></i>
                                    @else 
                                        <i class="fa fa-sort-numeric-up"></i> 
                                    @endif
                                @endif
                            </th>

                              <th></th>
                          </tr>
                      </thead>
                      <tbody>
                          @foreach ($localita as $l)                          
                              <tr>
                                <th scope="row"><a href="{{ route('localita.edit',$l->id) }}" title="Modifica localita">
                                  {{$l->nome}}</a></th>
                                <td>{{optional($l->comune)->nome}}</td>
                                <td>{{optional(optional($l->comune)->provincia)->nome}}</td>
                                <td>{{ optional(optional(optional($l->comune)->provincia)->regione)->nome }}</td>
                                <td>
                                  <a data-id="{{$l->id}}" href="#" class="delete btn btn-danger"><i class="fas fa-trash-alt"></i></a>
                                </td>
                              </tr>
                          @endforeach
                      </tbody>
                  </table>
                  
                  {{ $localita->links() }}
              
              </div>
            @else
              <div>
                Nessuna localita
              </div>
            @endif
            
    </div>
</div>
@endsection


@section('js')
    <script type="text/javascript" charset="utf-8">

        jQuery(document).ready(function(){
            
            $(".searching").click(function(){
                $("#searchForm").submit();
            });

          
        });
    

    </script>
@endsection