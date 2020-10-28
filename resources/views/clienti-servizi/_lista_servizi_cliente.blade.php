

<div class="row">
    <div class="col">
                        
			@if ($servizi->count())
				@foreach ($servizi as $s)
					<form action="{{ route('clienti-servizi.destroy', $s->id) }}" method="post" id="delete_item_{{$s->id}}">
						@csrf
					</form>
				@endforeach
				@php
					!$venduti ? $action = route('clienti-servizi',$cliente->id) : $action = route('clienti-servizi-archiviati',$cliente->id);	
				@endphp
				<form action="{{ $action }}" method="get" id="searchForm" accept-charset="utf-8">
					<input type="hidden" name="orderby" id="orderby" value="">
					<input type="hidden" name="order" id="order" value="">
				</form>
				<table class="table table-responsive-sm m-table m-table--head-bg-success table-hover">
						<thead>
								<tr>
										<th></th>
										<th class="order" data-orderby="nome_prodotto" @if (\Request::get('orderby') == 'nome_prodotto' && \Request::get('order') == 'asc') data-order='desc' @else data-order='asc' @endif>
											Prodotto 
											@if (\Request::get('orderby') == 'nome_prodotto') 
													@if (\Request::get('order') == 'asc')
															<i class="fa fa-sort-alpha-down"></i>
													@else 
															<i class="fa fa-sort-alpha-up"></i> 
													@endif
											@endif
										</th>
										<th class="order" data-orderby="data_inizio" @if (\Request::get('orderby') == 'data_inizio' && \Request::get('order') == 'asc') data-order='desc' @else data-order='asc' @endif>
											Inizio 
											@if (\Request::get('orderby') == 'data_inizio') 
													@if (\Request::get('order') == 'asc')
															<i class="fa fa-sort-numeric-down"></i>
													@else 
															<i class="fa fa-sort-numeric-up"></i> 
													@endif
											@endif
										</th>
										<th class="order" data-orderby="data_fine" @if (\Request::get('orderby') == 'data_fine' && \Request::get('order') == 'asc') data-order='desc' @else data-order='asc' @endif>
											Fine 
											@if (\Request::get('orderby') == 'data_fine') 
													@if (\Request::get('order') == 'asc')
															<i class="fa fa-sort-numeric-down"></i>
													@else 
															<i class="fa fa-sort-numeric-up"></i> 
													@endif
											@endif
										</th>
										<th>Note</th>
										<th>N. Fattura</th>
										<th></th>
								</tr>
						</thead>
						<tbody>
								@foreach ($servizi as $s)
										<tr id="{{$s->id}}">
												@if (!$venduti)
													<td><a href="#" class="archivia" data-id="{{$s->id}}" data-archivia="1"><i class="icon-action-redo icons font-2xl" data-toggle="tooltip" data-placement="left" title="" data-original-title="Archivia il servizio"></i></a></td>
												@else
													<td><a href="#" class="archivia" data-id="{{$s->id}}" data-archivia="0"><i class="icon-action-undo icons font-2xl" data-toggle="tooltip" data-placement="left" title="" data-original-title="Ripristina il servizio"></i></a></td>
												@endif

												<td><nome-servizio-cliente servizio_id="{{$s->id}}" nome_prodotto="{{$s->prodotto->nome}}"></nome-servizio-cliente></td>
												<td>{{optional($s->data_inizio)->format('d/m/Y')}}</td>
												<td>{{optional($s->data_fine)->format('d/m/Y')}}</td>
												<td>{{$s->note}}</td>
												<td>{{optional($s->fattura)->numero_fattura}}</td>
												<td>
													<a data-id="{{$s->id}}" href="#" class="delete btn btn-danger"><i class="fas fa-trash-alt"></i></a>
												</td>
										</tr>
								@endforeach
						</tbody>
				</table>
      @endif
        
    </div>{{-- col --}}
</div>{{-- row --}}
