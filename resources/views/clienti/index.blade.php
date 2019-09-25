@extends('layouts.coreui.crm_lara6')

@section('content')


<div class="row">
  <div class="col-sm-2">
    <div class="callout callout-info b-t-1 b-r-1 b-b-1">
       Elenco clienti
      @if (isset($clienti))
      <br>
      <strong class="h4">{{$clienti->total()}}</strong>
      @endif
    </div>
  </div><!--/.col-->
  @if (count(Request()->query()))
    <div class="col-sm-2">
      <div class="callout callout-noborder">
        <a href="{{ url('clienti') }}" title="Tutti i clienti" class="btn btn-warning">
          Tutti
        </a>
      </div>
    </div><!--/.col-->
  @endif
    <div class="to-right">
      <div class="callout callout-noborder">
        <a href="{{ route('clienti.create') }}" title="Nuovo cliente" class="btn btn-primary">
          Nuovo cliente
        </a>
      </div>
    </div><!--/.col-->
</div>


<div class="row">
    <div class="col">

          @include('clienti._ricerca_clienti')

            @if (isset($clienti))
              <div>
              <table class="table table-responsive-sm m-table m-table--head-bg-success table-hover">
                  <thead>
                      <tr>
                          
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
                          
                          <th class="order" data-orderby="localita" @if (\Request::get('orderby') == 'localita' && \Request::get('order') == 'asc') data-order='desc' @else data-order='asc' @endif>
                              Località 
                              @if (\Request::get('orderby') == 'localita') 
                                  @if (\Request::get('order') == 'asc')
                                      <i class="fa fa-sort-alpha-down"></i>
                                  @else 
                                      <i class="fa fa-sort-alpha-up"></i> 
                                  @endif
                              @endif
                          </th>

                          <th class="order" data-orderby="categoria_id" @if (\Request::get('orderby') == 'categoria_id' && \Request::get('order') == 'asc') data-order='desc' @else data-order='asc' @endif>
                              Categoria 
                              @if (\Request::get('orderby') == 'categoria_id') 
                                  @if (\Request::get('order') == 'asc')
                                      <i class="fa fa-sort-numeric-down"></i>
                                  @else 
                                      <i class="fa fa-sort-numeric-up"></i> 
                                  @endif
                              @endif
                          </th>
                          
                          <th class="order" data-orderby="attivo" @if (\Request::get('orderby') == 'attivo' && \Request::get('order') == 'asc') data-order='desc' @else data-order='asc' @endif>
                              Stato 
                              @if (\Request::get('orderby') == 'attivo') 
                                  @if (\Request::get('order') == 'asc')
                                      <i class="fa fa-sort-alpha-down"></i>
                                  @else 
                                      <i class="fa fa-sort-alpha-up"></i> 
                                  @endif
                              @endif
                          </th>
                          <th>Commerciale</th>
                          <th></th>
                      </tr>
                  </thead>
                  <tbody>
                      @foreach ($clienti as $cliente)
                        <tr>
                            <th scope="row"><a href="" title=""></a>{{$cliente->id_info}}</th>
                            <td> <a href="{{ route('clienti.edit',$cliente->id) }}" title="Modifica cliente">{{$cliente->nome}}</a></td>
                            <td>{{optional($cliente->localita)->nome}}</td>
                            <td>{{optional($cliente->categoria)->categoria}}</td>
                            <td>{!!$cliente->stato($icon = true)!!}</td>
                            <td>{{$cliente->commerciali()}}</td>
                        </tr>
                      @endforeach
                  </tbody>
              </table>
              </div>

              <div>
                {{ $clienti->links() }}
              </div>            
            @else
                
              <div>
                  {!! $message !!}
              </div>
                
            @endif
            


    </div>
   
</div>
@endsection


@section('js')
    <script type="text/javascript" charset="utf-8">
         
          $(".searching").click(function(){
              $("#searchForm").submit();
          });

          $(".attivo_check").change(function(){
            $("#searchForm").submit();
          });


          $('.order').click(function(){
              var orderby = $(this).data("orderby");
              var order = $(this).data("order");
              $("#orderby").val(orderby);
              $("#order").val(order);
                $("#searchForm").submit();
          });

    </script>
@endsection