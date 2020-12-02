@extends('layouts.coreui.crm_lara6')

@section('content')

<div class="row">
  <div class="col-sm-2">
    <div class="callout callout-info b-t-1 b-r-1 b-b-1">
       Elenco slots {{$vetrina->nome}}
      @if (isset($slots))
      <br>
      <strong class="h4">{{$slots->total()}}</strong>
      @endif
    </div>
  </div><!--/.col-->
  @if (count(Request()->query()))
    <div class="col-sm-2">
      <div class="callout callout-noborder">
        <a href="{{ url('vetrina/slots/'.$vetrina->id) }}" title="Tutti gli slots" class="btn btn-warning">
          Tutti
        </a>
      </div>
    </div><!--/.col-->
  @endif
    <div class="to-right">
      <div class="callout callout-noborder">
        <a href="{{ route('slot.create', $vetrina->id) }}" title="Nuovo slot" class="btn btn-primary">
          Nuovo slot
        </a>
      </div>
    </div><!--/.col-->
</div>


<div class="row">
    <div class="col">
            
            @if (isset($slots))
              @foreach ($slots as $s)
                <form action="{{ route('slot.destroy',$s->id) }}" method="POST" id="delete_item_{{$s->id}}">
                    @csrf
                </form>
              @endforeach
              <div>
                  <table class="table table-responsive-sm m-table m-table--head-bg-success table-hover">
                      <thead>
                          <tr>
                              
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
                              
                              <th class="order" data-orderby="data_disattivazione" @if (\Request::get('orderby') == 'data_disattivazione' && \Request::get('order') == 'asc') data-order='desc' @else data-order='asc' @endif>
                                  Scadenza 
                                  @if (\Request::get('orderby') == 'data_disattivazione') 
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
                          @foreach ($slots as $s)                          
                              <tr>
                                <th scope="row"><a href="{{ route('slot.edit',$s->id) }}" title="Modifica vetrina">
                                  {{optional($s->cliente)->nome}}</a></th>
                                <td>{{$s->data_disattivazione->format('d/m/Y')}}</td>
                                <td>
                                  <a data-id="{{$s->id}}" href="#" class="delete btn btn-danger"><i class="fas fa-trash-alt"></i></a>
                                </td>
                              </tr>
                          @endforeach
                      </tbody>
                  </table>
                  
                  {{ $slots->links() }}
              
              </div>
            @else
              <div>
                Nessuno slot
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