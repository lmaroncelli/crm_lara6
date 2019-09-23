@extends('layouts.lara_crm')

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
                                    Elenco fatture
                                @else
                                    <a href="{{ url('fatture') }}" title="Tutte le fatture" class="btn btn-warning">
                                        Elenco fatture
                                    </a> 
                                @endif
                                &nbsp;&nbsp; @if (isset($fatture)) <span class="m-badge m-badge--success m-badge--wide">{{$fatture->total()}}@endif</span>
                            </h3>
                        </div>
                        
                        <div class="add_item col-x-6" style="margin-left: auto;">
                            <a href="{{ route('fatture.create') }}" class="btn btn-success m-btn m-btn--custom m-btn--icon m-btn--pill m-btn--air">
                                <span>
                                    <i class="fa fa-file-medical"></i>
                                    <span>Nuova fattura</span>
                                </span>
                            </a>        
                        </div>
                    
                    </div>
                

                </div>
            </div>
                <form action="{{ url('fatture') }}" method="get" id="searchForm" accept-charset="utf-8">
                <input type="hidden" name="orderby" id="orderby" value="">
                <input type="hidden" name="order" id="order" value="">
                
                <div class="row">
                    

                    <div class="col-lg-3" style="padding-left: 40px; padding-right: 40px; padding-top: 20px">
                        <div class="m-input-icon m-input-icon--left m-input-icon--right">
                            <input type="text" name="qf" value="{{\Request::get('qf')}}" class="form-control m-input m-input--pill m-input--air" placeholder="Cerca nel campo">
                            <span class="m-input-icon__icon m-input-icon__icon--left">
                                <span>
                                    <i class="la la-tags"></i>
                                </span>
                            </span>
                            <span class="m-input-icon__icon m-input-icon__icon--right">
                                <span>
                                    <i class="la la-search"></i>
                                </span>
                            </span>
                        </div>
                    </div>
                    <div class="col-lg-3" style="padding-top: 20px;">
                        <select class="form-control m-input" id="field" name="field">
                            @foreach ($campi_fattura_search as $key => $value)
                                <option value="{{$key}}" @if (\Request::get('field') == $key || old('key') == $key ) selected="selected" @endif>{{$value}}</option>
                            @endforeach
                        </select>
                    </div>

                </div>
                </form>

            @if (isset($fatture))
            <div class="m-portlet__body">
                <div class="tab-content">
                    <div class="m-section">
                        <div class="m-section__content">
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
                                      <tr>
                                          <th scope="row"><a href="{{ route('fatture.edit',['id' => $fattura->id]) }}" title="Modifica fattura">{{$fattura->numero_fattura}}</a></th>
                                          <td> {{optional($fattura->data)->format('d/m/Y')}}</a></td>
                                          <td>{{optional($fattura->pagamento)->nome}}</td>
                                          <td>{{App\Utility::formatta_cifra($fattura->totale,'€')}}</td>
                                          <td>{!!optional(optional($fattura->societa)->ragioneSociale)->nome!!}</td>
                                          <td>{{optional(optional($fattura->societa)->cliente)->nome}}</td>
                                          <td>
                                            <form action="{{ route('fatture.destroy', ['id' => $fattura->id]) }}" method="POST" accept-charset="utf-8" class="deleteForm" id="delete-riga-form">
                                                @csrf
                                                @method('DELETE')
                                                <a href="#" style="margin-bottom: 5px!important;" class="delete btn btn-danger m-btn m-btn--icon m-btn--icon-only"> 
                                                    <i class="la la-trash"></i>
                                                </a>
                                            </form>
                                          </td>
                                      </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {{ $fatture->links() }}
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
    <script src="{{ asset('js/bootstrap-switch.js') }}" type="text/javascript"></script>
    <script type="text/javascript" charset="utf-8">

        jQuery(document).ready(function(){
            
            $(".la-search").click(function(){
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



            $(".delete").click(function(e){
              e.preventDefault();
              swal({
                title: 'Sei sicuro?',
                text: "Operazione irreversibile!",
                type: 'question',
                showCancelButton: true,
                cancelButtonColor: '#c4c5d6',
                confirmButtonColor: '#d33',
                confirmButtonText: 'Sì, elimina!'
              }).then((result) => { 
                    if (result.value) {
                     //$("#delete-riga-form").submit();
                     $(this).closest("form.deleteForm").submit();
                    }
                })

            });

          
        });
    

    </script>
@endsection