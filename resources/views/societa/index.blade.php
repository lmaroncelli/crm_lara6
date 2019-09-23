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
                                    Elenco societa
                                @else
                                    <a href="{{ url('societa') }}" title="Tutte le societa" class="btn btn-warning">
                                        Elenco societa
                                    </a> 
                                @endif
                                &nbsp;&nbsp; @if (isset($societa)) <span class="m-badge m-badge--success m-badge--wide">{{$societa->total()}}@endif</span>
                            </h3>
                        </div>
                        
                        <div class="add_item col-x-6" style="margin-left: auto;">
                            <a href="{{ route('societa.create') }}" class="btn btn-success m-btn m-btn--custom m-btn--icon m-btn--pill m-btn--air">
                                <span>
                                    <i class="fa fa-file-medical"></i>
                                    <span>Nuova Societa</span>
                                </span>
                            </a>        
                        </div>
                    
                    </div>
                

                </div>
            </div>
            
            @include('societa._ricerca_societa')
            
            @if (isset($societa))
            <div class="m-portlet__body">
                <div class="tab-content">
                    <div class="m-section">
                        <div class="m-section__content">
                            <table class="table table-responsive-sm m-table m-table--head-bg-success table-hover">
                                <thead>
                                    <tr>
                                        
                                        <th class="order" data-orderby="nome_rag" @if (\Request::get('orderby') == 'nome_rag' && \Request::get('order') == 'asc') data-order='desc' @else data-order='asc' @endif>
                                            Società 
                                            @if (\Request::get('orderby') == 'nome_rag') 
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

                                        <th width="20%">Note</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($societa as $s)
                                      <tr>
                                          <th scope="row"><a href="{{ route('societa.edit',['id' => $s->id]) }}" title="Modifica societa">{{$s->ragioneSociale->nome}}</a></th>
                                          <td>{{$s->cliente->nome}}</td>
                                          <td>{{$s->cliente->id_info}}</td>
                                          <td>{{$s->note}}</td>
                                          <td>
                                            <form action="{{ route('societa.destroy', ['id' => $s->id]) }}" method="POST" accept-charset="utf-8" class="deleteForm" id="delete-riga-form">
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
                {{ $societa->links() }}
            </div>
            @else
                <div class="m-portlet__body">
                    <div class="tab-content">
                        <div class="m-section">
                            <div class="m-section__content">
                               Nessuna societa
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