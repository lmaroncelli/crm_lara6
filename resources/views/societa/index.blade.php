@extends('layouts.coreui.crm_lara6')

@section('content')

<div class="row">
  <div class="col-sm-2">
    <div class="callout callout-info b-t-1 b-r-1 b-b-1">
       Elenco societa
      @if (isset($societa))
      <br>
      <strong class="h4">{{$societa->total()}}</strong>
      @endif
    </div>
  </div><!--/.col-->
  @if (count(Request()->query()))
    <div class="col-sm-2">
      <div class="callout callout-noborder">
        <a href="{{ url('societa') }}" title="Tutti i societa" class="btn btn-warning">
          Tutti
        </a>
      </div>
    </div><!--/.col-->
  @endif
    <div class="to-right">
      <div class="callout callout-noborder">
        <a href="{{ route('societa.create') }}" title="Nuova Societa" class="btn btn-primary">
          Nuova Societa
        </a>
      </div>
    </div><!--/.col-->
</div>


<div class="row">
    <div class="col">

            @include('societa._ricerca_societa')
            
            @if (isset($societa))
            
              <div>
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
                                <th scope="row"><a href="{{ route('societa.edit',['id' => $s->id]) }}" title="Modifica societa">{{optional($s->ragioneSociale)->nome}}</a></th>
                                <td>{{optional($s->cliente)->nome}}</td>
                                <td>{{optional($s->cliente)->id_info}}</td>
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
              <div>              
                {{ $societa->links() }}
              </div>
            @else
              <div>
                Nessuna societa
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


            $('.order').click(function(){
                var orderby = $(this).data("orderby");
                var order = $(this).data("order");
                $("#orderby").val(orderby);
                $("#order").val(order);
                 $("#searchForm").submit();
            });



            $(".delete").click(function(e){
              e.preventDefault();
              swal.fire({
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