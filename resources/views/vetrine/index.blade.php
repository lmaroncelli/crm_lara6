@extends('layouts.coreui.crm_lara6')

@section('content')

<div class="row">
  <div class="col-sm-2">
    <div class="callout callout-info b-t-1 b-r-1 b-b-1">
       Elenco vetrine
      @if (isset($vetrine))
      <br>
      <strong class="h4">{{$vetrine->total()}}</strong>
      @endif
    </div>
  </div><!--/.col-->
  @if (count(Request()->query()))
    <div class="col-sm-2">
      <div class="callout callout-noborder">
        <a href="{{ url('vetrine') }}" title="Tutte le vetrine" class="btn btn-warning">
          Tutte
        </a>
      </div>
    </div><!--/.col-->
  @endif
    <div class="to-right">
      <div class="callout callout-noborder">
        <a href="{{ route('vetrine.create') }}" title="Nuova vetrina" class="btn btn-primary">
          Nuova vetrina
        </a>
      </div>
    </div><!--/.col-->
</div>


<div class="row">
    <div class="col">
            
            @if (isset($vetrine))
              @foreach ($vetrine as $v)
                <form action="{{ route('vetrine.destroy',$v->id) }}" method="POST" id="delete_item_{{$v->id}}">
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
                              
                              <th class="order" data-orderby="tipo" @if (\Request::get('orderby') == 'tipo' && \Request::get('order') == 'asc') data-order='desc' @else data-order='asc' @endif>
                                  Tipo 
                                  @if (\Request::get('orderby') == 'tipo') 
                                      @if (\Request::get('order') == 'asc')
                                          <i class="fa fa-sort-alpha-down"></i>
                                      @else 
                                          <i class="fa fa-sort-alpha-up"></i> 
                                      @endif
                                  @endif
                              </th>
                              <th>Slots</th>
                              <th></th>
                          </tr>
                      </thead>
                      <tbody>
                          @foreach ($vetrine as $v)                          
                              <tr>
                                <th scope="row"><a href="{{ route('vetrine.edit',$v->id) }}" title="Modifica vetrina">
                                  {{$v->nome}}</a></th>
                                <td>{{$v->tipo}}</td>
                                <td><a class="badge badge-success" href="{{ route('slot.index', $v->id) }}">{{$v->slots_count}}</a></td>
                                <td>
                                  <a data-id="{{$v->id}}" href="#" class="delete btn btn-danger"><i class="fas fa-trash-alt"></i></a>
                                </td>
                              </tr>
                          @endforeach
                      </tbody>
                  </table>
                  
                  {{ $vetrine->links() }}
              
              </div>
            @else
              <div>
                Nessuna vetrina
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