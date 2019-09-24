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
        <form action="{{ url('clienti') }}" method="get" id="searchForm" accept-charset="utf-8">
        <input type="hidden" name="orderby" id="orderby" value="">
        <input type="hidden" name="order" id="order" value="">
        
        <div class="row p-3">
            <div class="col-md-5">
              <input type="text" name="q" value="{{\Request::get('q')}}" class="form-control" placeholder="Cerca per nome o ID">
            </div>

            <div class="col-md-1">
                <button type="button" class="btn btn-pill btn-success searching">Cerca</button>      
            </div>


            <div class="col-md-3">
              <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input attivo_check"name="attivo" id="attivo" @if ( \Request::get('attivo') ) checked="checked" @endif>
                <label class="custom-control-label" for="attivo">Solo attivi</label>
              </div>
            </div>

            <div class="col-md-3">
              <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input attivo_check"name="attivo_ia" id="attivo_ia" @if ( \Request::get('attivo_ia') ) checked="checked" @endif>
                <label class="custom-control-label" for="attivo_ia">Solo attivi IA</label>
              </div>
            </div>

        </div>

        <div class="row p-3">
            
          <div class="col-md-3">
              <input type="text" name="qf" value="{{\Request::get('qf')}}" class="form-control" placeholder="Cerca nel campo">
          </div>
          <div class="col-md-2">
              <select class="form-control" id="field" name="field">
                  @foreach ($campi_cliente_search as $key => $value)
                      <option value="{{$key}}" @if (\Request::get('field') == $key || old('key') == $key ) selected="selected" @endif>{{$value}}</option>
                  @endforeach
              </select>
          </div>
          <div class="col-md-1">
              <button type="button" class="btn btn-pill btn-success searching">Cerca</button>      
          </div>

          <div class="col-md-4">
            <input type="text" name="qc" value="{{\Request::get('qc')}}" class="form-control" placeholder="Cerca nei contatti">      
          </div>
          <div class="col-md-1">
              <button type="button" class="btn btn-pill btn-success searching">Cerca</button>      
          </div>
        
        </div>

        </form>

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