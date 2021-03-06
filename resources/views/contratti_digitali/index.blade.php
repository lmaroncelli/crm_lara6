@extends('layouts.coreui.crm_lara6')

@section('content')


<div class="row">
  <div class="col-sm-2">
    <div class="callout callout-info b-t-1 b-r-1 b-b-1">
       Elenco precontratti  @if (!$all) <a class="all" href="{{ url('contratto-digitale/all') }}">Tutti</a> @else <a class="all" href="{{ url('contratto-digitale') }}">Ultimi anni</a> @endif
      @if (isset($precontratti))
      <br>
      <strong class="h4">{{$precontratti->total()}}</strong>
      @endif
    </div>
  </div><!--/.col-->
  @if (count(Request()->query()))
    <div class="col-sm-2">
      <div class="callout callout-noborder">
        <a href="{{ url($url_index) }}" title="Tutti i precontratti" class="btn btn-warning">
          Tutti
        </a>
      </div>
    </div><!--/.col-->
  @endif
    <div class="to-right">
      <div class="callout callout-noborder">
        <a href="{{ route('contratto-digitale.create') }}" title="Nuovo precontratto" class="btn btn-primary">
          Nuovo precontratto
        </a>
      </div>
    </div><!--/.col-->
</div>


<div class="row">
    <div class="col">      
      @if (isset($precontratti))
        <form action="{{ url($url_index) }}" method="get" id="searchForm" accept-charset="utf-8">
          <input type="hidden" name="orderby" id="orderby" value="">
          <input type="hidden" name="order" id="order" value="">
          <div class="row p-3">

            <div class="col-md-3">
              <input type="text" name="qf" value="{{ \Request::get('qf') }}" class="form-control" placeholder="Cerca nel campo">
            </div>
            <div class="col-md-2">
              <select class="form-control m-input" id="field" name="field">
                @foreach ($campi_precontratti_search as $key => $value)
                  <option value="{{ $key }}" @if (\Request::get('field') == $key || old('key') == $key) selected="selected"
                @endif>{{ $value }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-1">
              <button type="button" class="btn btn-pill btn-success searching">Cerca</button>
            </div>
        
          </div>
        </form>
        @foreach ($precontratti as $p)
          <form action="{{ route('contratto-digitale.destroy',$p->id) }}" method="POST" id="delete_item_{{$p->id}}">
              @csrf
              @method('DELETE')
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
                      
                      <th class="order" data-orderby="nome_commerciale" @if (\Request::get('orderby') == 'nome_commerciale' && \Request::get('order') == 'asc') data-order='desc' @else data-order='asc' @endif>
                          Commerciale 
                          @if (\Request::get('orderby') == 'nome_commerciale') 
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
                  @foreach ($precontratti as $p)
                      <tr>
                        <th scope="row"><a href="{{ route('contratto-digitale.edit',$p->id) }}" title="Modifica precontratto">{{$p->data_creazione->format('d/m/Y H:i')}}</a> ({{$p->servizi_count}})</th>
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
          
          {{ $precontratti->links() }}
        </div>
      @else
        <div>
          Nessuna precontratto
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