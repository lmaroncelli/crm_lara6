@extends('layouts.coreui.crm_lara6')

@section('content')

@include('layouts.coreui.menu_sezioni_clienti') 

<div class="row">
  <div class="col-sm-2">
    <div class="callout callout-info b-t-1 b-r-1 b-b-1">
       Elenco precontratti
      @if ($cliente->contrattiDigitaliAll()->count())
      <br>
      <strong class="h4">{{$cliente->contrattiDigitaliAll()->count()}}</strong>
      @endif
    </div>
  </div><!--/.col-->
</div>



@if ($cliente->contrattiDigitaliAll->count())
  <form action="{{ route('clienti-precontratti', $cliente->id) }}" method="get" id="searchForm" accept-charset="utf-8">
    <input type="hidden" name="orderby" id="orderby" value="">
    <input type="hidden" name="order" id="order" value="">
  </form>
  @foreach ($cliente->contrattiDigitaliAll as $contratto)
    <form action="{{ route('clienti-contratto-destroy',$contratto->id) }}" method="POST" id="delete_item_{{$contratto->id}}">
        @csrf
    </form>
  @endforeach
  <div>

    <table class="table table-responsive-sm m-table m-table--head-bg-success table-hover">
        <thead>
          <tr>
              
              <th class="order" data-orderby="data_creazione" @if (\Request::get('orderby') == 'data_creazione' && \Request::get('order') == 'asc') data-order='desc' @else data-order='asc' @endif>
                  Data creazione 
                  @if (\Request::get('orderby') == 'data_creazione') 
                      @if (\Request::get('order') == 'asc')
                          <i class="fa fa-sort-numeric-down"></i>
                      @else 
                          <i class="fa fa-sort-numeric-up"></i> 
                      @endif
                  @endif
              </th>
              
              <th class="order" data-orderby="tipo_contratto" @if (\Request::get('orderby') == 'tipo_contratto' && \Request::get('order') == 'asc') data-order='desc' @else data-order='asc' @endif>
                  Tipo 
                  @if (\Request::get('orderby') == 'tipo_contratto') 
                      @if (\Request::get('order') == 'asc')
                          <i class="fa fa-sort-alpha-down"></i>
                      @else 
                          <i class="fa fa-sort-alpha-up"></i> 
                      @endif
                  @endif
              </th>
              
              <th>
                  Commerciale
              </th>

              <th>
                Cliente 
              </th>
              <th></th>
          </tr>
        </thead>
        <tbody>
            @foreach ($cliente->contrattiDigitaliAll as $p)
              <tr>
                <th scope="row"><a href="{{ route('contratto-digitale.edit',$p->id) }}" title="Modifica precontratto">{{$p->data_creazione->format('d/m/Y H:i')}}</a></th>
                <td>{{$p->tipo_contratto}}</td>
                <td>{{optional($p->commerciale)->name}}</td>
                <td>{{optional($p->cliente)->nome}}</td>
                <td>
                  <a data-id="{{$p->id}}" href="#" class="delete btn btn-danger"><i class="fas fa-trash-alt"></i></a>
                </td>
              </tr>
            @endforeach
        </tbody>
    </table>
    

  </div>
@else
  <div>Nessun precontratto inserito!</div>    
@endif

@endsection


@section('js')
<script type="text/javascript" charset="utf-8">

  jQuery(document).ready(function(){
    

  });


</script>
@endsection