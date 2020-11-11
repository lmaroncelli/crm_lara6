@extends('layouts.coreui.crm_lara6')

@section('content')

@include('layouts.coreui.menu_sezioni_clienti') 

<div class="row">
  <div class="col-sm-2">
    <div class="callout callout-info b-t-1 b-r-1 b-b-1">
       Elenco contratti
      @if ($cliente->contratti_count)
      <br>
      <strong class="h4">{{$cliente->contratti_count}}</strong>
      @endif
    </div>
  </div><!--/.col-->
</div>


<div class="row">
  <div class="col">
    
    <form action="{{route('contratto-upload')}}" method="post" enctype="multipart/form-data">
      @csrf
      <input type="hidden" name="cliente_id" value="{{$cliente->id}}">
      <div class="form-group row">
        <label class="col-md-2 text-change" for="titolo">Titolo:</label>
        <div class="col-md-6">
          <input type="text" name="titolo" id="titolo" value="{{ old('titolo') != '' ?  old('titolo') : ''}}"  class="form-control" placeholder="Titolo">
        </div>
      </div>

      <div class="form-group row">
        <label class="col-md-2 text-change" for="tipo">Tipo:</label>
        <div class="col-md-6">
            <select class="form-control" id="tipo" name="tipo">
              @foreach (['Info Alberghi','Hotel Manager'] as $tipo)
                <option id="{{$tipo}}" @if (old('tipo') == $tipo ) selected="selected" @endif>{{$tipo}}</option>
              @endforeach
            </select>
        </div>
      </div>

      <div class="form-group row">
        <label class="col-md-2 text-change" for="tipo">Anno:</label>
        <div class="col-md-3">
            <select class="form-control" id="anno_dal" name="anno_dal">
              @foreach ($anni_i as $anno_dal)
                <option id="{{$anno_dal}}" @if (old('anno_dal') == $anno_dal ) selected="selected" @endif>{{$anno_dal}}</option>
              @endforeach
            </select>
        </div>
        <div class="col-md-3">
          <select class="form-control" id="anno_al" name="anno_al">
            @foreach ($anni_f as $anno_al)
              <option id="{{$anno_al}}" @if (old('anno_al') == $anno_al ) selected="selected" @endif>{{$anno_al}}</option>
            @endforeach
          </select>
      </div>
      </div>

      <div class="form-group row">
        <label class="col-md-2 text-change" for="tipo">Contratto:</label>
        <div class="col-md-6">
            <input type="file" name="contratto" id="contratto">
        </div>
      </div>

      <button type="submit" class="btn btn-primary offset-md-2 mt-3 mb-4">Carica</button>
        
      
    </form>
    
  </div>
</div>


@if ($cliente->contratti_count)
  <form action="{{ route('clienti-contratti', $cliente->id) }}" method="get" id="searchForm" accept-charset="utf-8">
    <input type="hidden" name="orderby" id="orderby" value="">
    <input type="hidden" name="order" id="order" value="">
  </form>
  @foreach ($cliente->contratti as $contratto)
    <form action="{{ route('clienti-contratto-destroy',$contratto->id) }}" method="POST" id="delete_item_{{$contratto->id}}">
        @csrf
    </form>
  @endforeach
  <div>

    <table class="table table-responsive-sm m-table m-table--head-bg-success table-hover">
        <thead>
            <tr>
                
               <th>Titolo</th>
               <th>Anno</th>
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
                
                <th class="order" data-orderby="data_inserimento" @if (\Request::get('orderby') == 'data_inserimento' && \Request::get('order') == 'asc') data-order='desc' @else data-order='asc' @endif>
                    Inserito 
                    @if (\Request::get('orderby') == 'data_inserimento') 
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
            @foreach ($cliente->contratti as $contratto)
                <tr>
                  <th scope="row"><a href="" title="Apri contratto">{{$contratto->titolo}}</a></th>
                  <td>{{$contratto->anno}}</td>
                  <td>{{$contratto->tipo}}</td>
                  <td>{{$contratto->data_inserimento}}</td>
                  <td>
                    <a data-id="{{$contratto->id}}" href="#" class="delete btn btn-danger"><i class="fas fa-trash-alt"></i></a>
                  </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    

  </div>
@else
  <div>Nessun Contratto inserito!</div>    
@endif

@endsection


@section('js')
<script type="text/javascript" charset="utf-8">

  jQuery(document).ready(function(){
    

  });


</script>
@endsection