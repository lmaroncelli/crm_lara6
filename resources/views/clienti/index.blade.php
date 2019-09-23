@extends('layouts.crm_lara6')

@section('content')

<div class="row">
    <div class="col-xl-12">

        <!--begin:: Widgets/Tasks -->
        <div class="m-portlet m-portlet--last m-portlet--head-lg m-portlet--responsive-mobile" id="main_portlet">
            <div class="m-portlet__head">
                <div class="m-portlet__head-progress">
                   
                   <!-- here can place a progress bar-->
               </div>
               <div class="m-portlet__head-wrapper">
                   <div class="m-portlet__head-caption" style="width: 100%;">

                        <div class="m-portlet__head-title col-x-6">
                            <h3 class="m-portlet__head-text" style="width: 200px;">
                                @if (!count(Request()->query()))
                                    Elenco clienti
                                @else
                                    <a href="{{ url('clienti') }}" title="Tutti i clienti" class="btn btn-warning">
                                        Elenco clienti
                                    </a> 
                                @endif
                                &nbsp;&nbsp; @if (isset($clienti)) <span class="m-badge m-badge--success m-badge--wide">{{$clienti->total()}}@endif</span>
                            </h3>
                        </div>
                        
                        <div class="add_item col-x-6" style="margin-left: auto;">
                            <a href="{{ route('clienti.create') }}" class="btn btn-success m-btn m-btn--custom m-btn--icon m-btn--pill m-btn--air">
                                <span>
                                    <i class="fa fa-file-medical"></i>
                                    <span>Nuovo cliente</span>
                                </span>
                            </a>        
                        </div>

                    </div>

                </div>

            </div>
                <form action="{{ url('clienti') }}" method="get" id="searchForm" accept-charset="utf-8">
                <input type="hidden" name="orderby" id="orderby" value="">
                <input type="hidden" name="order" id="order" value="">
                <div class="row">
                    
                    <div class="col-lg-6" style="padding-left: 40px; padding-right: 40px; padding-top: 20px">
                        <div class="m-input-icon m-input-icon--left m-input-icon--right">
                            <input type="text" name="q" value="{{\Request::get('q')}}" class="form-control m-input m-input--pill m-input--air" placeholder="Cerca per nome o ID">
                            <span class="m-input-icon__icon m-input-icon__icon--left">
                                <span>
                                    <i class="far fa-user"></i>
                                </span>
                            </span>
                            <span class="m-input-icon__icon m-input-icon__icon--right">
                                <span>
                                    <i class="fas fa-search searching"></i>
                                </span>
                            </span>
                        </div>
                    </div>

                    <div class="col-lg-3" style="padding-top: 20px">
                        <span class="label">Solo attivi</span>
                        <input class="attivo_check" data-switch="true" type="checkbox" name="attivo" @if ( \Request::get('attivo') ) checked="checked" @endif  data-on-color="success" data-off-color="danger" data-on-text="Sì" data-off-text="No">
                    </div>

                    <div class="col-lg-3" style="padding-top: 20px">
                        <span class="label">Solo attivi IA</span>
                        <input class="attivo_check" data-switch="true" type="checkbox" name="attivo_ia" @if ( \Request::get('attivo_ia') ) checked="checked" @endif data-on-color="success" data-off-color="danger" data-on-text="Sì" data-off-text="No">
                    </div>

                </div>

                <div class="row">
                    

                    <div class="col-lg-3" style="padding-left: 40px; padding-right: 40px; padding-top: 20px">
                        <div class="m-input-icon m-input-icon--left m-input-icon--right">
                            <input type="text" name="qf" value="{{\Request::get('qf')}}" class="form-control m-input m-input--pill m-input--air" placeholder="Cerca nel campo">
                            <span class="m-input-icon__icon m-input-icon__icon--left">
                                <span>
                                    <i class="far fa-tags"></i>
                                </span>
                            </span>
                            <span class="m-input-icon__icon m-input-icon__icon--right">
                                <span>
                                    <i class="fas fa-search searching"></i>
                                </span>
                            </span>
                        </div>
                    </div>
                    <div class="col-lg-3" style="padding-top: 20px;">
                        <select class="form-control m-input" id="field" name="field">
                            @foreach ($campi_cliente_search as $key => $value)
                                <option value="{{$key}}" @if (\Request::get('field') == $key || old('key') == $key ) selected="selected" @endif>{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="offset-lg-1 col-lg-5" style="padding-right: 40px; padding-top: 20px">
                        <div class="m-input-icon m-input-icon--left m-input-icon--right">
                            <input type="text" name="qc" value="{{\Request::get('qc')}}" class="form-control m-input m-input--pill m-input--air" placeholder="Cerca nei contatti">
                            <span class="m-input-icon__icon m-input-icon__icon--left">
                                <span>
                                    <i class="far fa-user-secret"></i>
                                </span>
                            </span>
                            <span class="m-input-icon__icon m-input-icon__icon--right">
                                <span>
                                    <i class="fas fa-search searching"></i>
                                </span>
                            </span>
                        </div>
                    </div>

                </div>
                </form>

            @if (isset($clienti))
            <div class="m-portlet__body">
                <div class="tab-content">
                    <div class="m-section">
                        <div class="m-section__content">
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
                                          <td> <a href="{{ route('clienti.edit',['id' => $cliente->id]) }}" title="Modifica cliente">{{$cliente->nome}}</a></td>
                                          <td>{{optional($cliente->localita)->nome}}</td>
                                          <td>{{optional($cliente->categoria)->categoria}}</td>
                                          <td>{!!$cliente->stato($icon = true)!!}</td>
                                          <td>{{$cliente->commerciali()}}</td>
                                      </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {{ $clienti->links() }}
            </div>
            @else
                <div class="m-portlet__body">
                    <div class="tab-content">
                        <div class="m-section">
                            <div class="m-section__content">
                                {!! $message !!}
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            
        </div>


        <!--end:: Widgets/Tasks -->
    </div>
   
</div>
@endsection


@section('js')
    <script type="text/javascript" charset="utf-8">
         
          $(".searching").click(function(){
              $("#searchForm").submit();
          });

          $(".attivo_check").on('switchChange.bootstrapSwitch', function (event, state) {
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