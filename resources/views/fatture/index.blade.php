@extends('layouts.coreui.crm_lara6')

@section('content')

<div class="row">
    <div class="col-sm-2">
      <div class="callout callout-info b-t-1 b-r-1 b-b-1">
        Elenco @if ($tipo == 'F') fatture @else prefatture @endif 
        @if (isset($fatture))
        <br>
        <strong class="h4">{{$fatture->total()}}</strong>
        @endif
      </div>
    </div><!--/.col-->
    @if (count(Request()->query()))
      <div class="col-sm-2">
        <div class="callout callout-noborder">
					@if ($tipo == 'F') 
          	<a href="{{ url('fatture') }}" title="Tutte le fatture" class="btn btn-warning">
					@else 
						<a href="{{ url('prefatture') }}" title="Tutte le prefatture" class="btn btn-warning">
					@endif
            Tutte
          </a>
        </div>
      </div><!--/.col-->
    @endif
      <div class="to-right">
        <div class="callout callout-noborder">
          <a href="{{ route('fatture.create',['tipo_id' => $tipo]) }}" title="Nuova Fattura" class="btn btn-primary">
            Nuova @if ($tipo == 'F') Fattura @else Prefattura @endif 
          </a>
        </div>
      </div><!--/.col-->
  </div>
  




<div class="row">
    <div class="col">
        
        @include('fatture._ricerca_fatture')

      
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
														<tr>
																<th scope="row"><a href="{{ route('fatture.edit',$fattura->id) }}" title="Modifica fattura">{{$fattura->numero_fattura}}</a></th>
																<td> {{optional($fattura->data)->format('d/m/Y')}}</a></td>
																<td>{{optional($fattura->pagamento)->nome}}</td>
																<td>{{App\Utility::formatta_cifra($fattura->totale,'€')}}</td>
																<td>{!!optional(optional($fattura->societa)->ragioneSociale)->nome!!}</td>
																<td>{{optional(optional($fattura->societa)->cliente)->nome}}</td>
																<td>
																<form action="{{ route('fatture.destroy', $fattura->id) }}" method="POST" accept-charset="utf-8" class="deleteForm" id="delete-riga-form">
																		@csrf
																		@method('DELETE')
																		<a href="#" style="margin-bottom: 5px!important;" class="delete btn btn-danger m-btn m-btn--icon m-btn--icon-only"> 
																				<i class="fas fa-trash-alt"></i>
																		</a>
																</form>
																</td>
														</tr>
												@endforeach
										</tbody>
								</table>
												
								{{ $fatture->links() }}
							</div>
            @else
							<div>
								{!! $message !!}
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