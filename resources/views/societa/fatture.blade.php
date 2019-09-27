@extends('layouts.coreui.crm_lara6')

@section('content')

<div class="row">
    <div class="col-xl-12 sezioni-societa">

        

          @include('layouts.coreui.menu_sezioni_societa') 
            
            @if (isset($fatture))

              <div>
                  <table class="table table-responsive-sm m-table m-table--head-bg-success table-hover">
                      <thead>
                          <tr>
                              
                              <th class="order" data-orderby="numero_fattura" @if (\Request::get('orderby') == 'numero_fattura' && \Request::get('order') == 'asc') data-order='desc' @else data-order='asc' @endif>
                                  N.fattura 
                                  @if (\Request::get('orderby') == 'numero_fattura') 
                                      @if (\Request::get('order') == 'asc')
                                          <i class="fa fa-sort-numeric-down"></i>
                                      @else 
                                          <i class="fa fa-sort-numeric-up"></i> 
                                      @endif
                                  @endif
                              </th>
                              
                              <th class="order" data-orderby="data" @if (\Request::get('orderby') == 'data' && \Request::get('order') == 'asc') data-order='desc' @else data-order='asc' @endif>
                                  Data 
                                  @if (\Request::get('orderby') == 'data') 
                                      @if (\Request::get('order') == 'asc')
                                          <i class="fa fa-sort-numeric-down"></i>
                                      @else 
                                          <i class="fa fa-sort-numeric-up"></i> 
                                      @endif
                                  @endif
                              </th>
                              
                              <th class="order" data-orderby="nome_pagamento" @if (\Request::get('orderby') == 'nome_pagamento' && \Request::get('order') == 'asc') data-order='desc' @else data-order='asc' @endif>
                                  Pagamento 
                                  @if (\Request::get('orderby') == 'nome_pagamento') 
                                      @if (\Request::get('order') == 'asc')
                                          <i class="fa fa-sort-alpha-down"></i>
                                      @else 
                                          <i class="fa fa-sort-alpha-up"></i> 
                                      @endif
                                  @endif
                              </th>

                              <th>Totale</th>

                              <th class="order" data-orderby="nome_societa" @if (\Request::get('orderby') == 'nome_societa' && \Request::get('order') == 'asc') data-order='desc' @else data-order='asc' @endif>
                                  Societa 
                                  @if (\Request::get('orderby') == 'nome_societa') 
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
                              <th></th>
                          </tr>
                      </thead>
                      <tbody>
                          @foreach ($fatture as $fattura)
                            <form action="{{ route('fatture.destroy', ['id' => $fattura->id]) }}" method="post" id="delete_item_{{$fattura->id}}">
                              @csrf
                              @method('DELETE')
                            </form>
                            <tr>
                                <th scope="row"><a href="{{ route('fatture.edit', $fattura->id) }}" title="Modifica fattura">{{$fattura->numero_fattura}}</a></th>
                                <td> {{optional($fattura->data)->format('d/m/Y')}}</a></td>
                                <td>{{optional($fattura->pagamento)->nome}}</td>
                                <td>{{App\Utility::formatta_cifra($fattura->totale,'€')}}</td>
                                <td>{!!optional(optional($fattura->societa)->ragioneSociale)->nome!!}</td>
                                <td>{{optional(optional($fattura->societa)->cliente)->nome}}</td>
                                <td>
                                  <a  data-id="{{$fattura->id}}" href="#" class="delete btn btn-danger"><i class="fas fa-trash-alt"></i></a>
                                </td>
                            </tr>
                          @endforeach
                      </tbody>
                  </table>
              </div>
            
            @else
                
              <div>
                  Nessuna fattura
              </div>
                
            @endif
      >
    </div>
   
</div>

@endsection


@section('js')
    <script type="text/javascript" charset="utf-8">
        jQuery(document).ready(function(){
        });
    </script>
@endsection