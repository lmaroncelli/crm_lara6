@extends('layouts.coreui.crm_lara6')

@section('content')

@include('layouts.coreui.menu_sezioni_clienti') 

<div class="row">
  <div class="col-sm-2">
    <div class="callout callout-info b-t-1 b-r-1 b-b-1">
       Elenco servizi foto
      @if ($cliente->servizi_foto_count)
      <br>
      <strong class="h4">{{$cliente->servizi_foto_count}}</strong>
      @endif
    </div>
  </div><!--/.col-->
</div>


<div class="row">
  <div class="col">
    
    <form action="{{route('clienti-foto-save')}}" method="post" enctype="multipart/form-data">
      @csrf
      <input type="hidden" name="cliente_id" value="{{$cliente->id}}">
     
      <div class="form-group row">
        <label class="col-md-2 text-change" for="anno">Anno:</label>
        <div class="col-md-6">
            <select class="form-control" id="anno" name="anno">
              @foreach ($anni as $anno)
                <option id="{{$anno}}" @if (old('anno') == $anno || date('Y') == $anno) selected="selected" @endif>{{$anno}}</option>
              @endforeach
            </select>
        </div>
      </div>

      <div class="form-group row">
        <label class="col-md-2 text-change" for="note">Note:</label>
        <div class="col-md-6">
        <textarea class="form-control" cols="25" rows="6" name="note" id="note">{{old('note')}}</textarea>
        </div>
      </div>

      <button type="submit" class="btn btn-primary offset-md-2 mt-3 mb-4">Salva</button>
        
    </form>
    
  </div>
</div>


@if ($cliente->servizi_foto_count)
  <form action="{{ route('clienti-foto', $cliente->id) }}" method="get" id="searchForm" accept-charset="utf-8">
    <input type="hidden" name="orderby" id="orderby" value="">
    <input type="hidden" name="order" id="order" value="">
  </form>
  @foreach ($cliente->servizi_foto as $foto)
    <form action="{{ route('clienti-foto-destroy',$foto->id) }}" method="POST" id="delete_item_{{$foto->id}}">
        @csrf
    </form>
  @endforeach
  <div>

    <table class="table table-responsive-sm m-table m-table--head-bg-success table-hover">
        <thead>
            <tr>
                <th class="order" data-orderby="anno" @if (\Request::get('orderby') == 'anno' && \Request::get('order') == 'asc') data-order='desc' @else data-order='asc' @endif>
                    Inserito 
                    @if (\Request::get('orderby') == 'anno') 
                        @if (\Request::get('order') == 'asc')
                            <i class="fa fa-sort-numeric-down"></i>
                        @else 
                            <i class="fa fa-sort-numeric-up"></i> 
                        @endif
                    @endif
                </th>
                <th>Note</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cliente->servizi_foto as $foto)
                <tr>
                  <td>{{$foto->anno}}</td>
                  <td>{{$foto->note}}</td>
                  <td>
                    <a data-id="{{$foto->id}}" href="#" class="delete btn btn-danger"><i class="fas fa-trash-alt"></i></a>
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