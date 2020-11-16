
@if ($fattura->scadenze->count())
<div class="row">
	<div class="col-lg-5">
		<div class="table-responsive">
				<table class="table riga_scadenza">
					<tbody>
					@foreach ($fattura->scadenze as $s)
					<tr>
						<td>{{$s->data_scadenza->format('d/m/Y')}}</td>
						<td>{{ App\Utility::formatta_cifra($s->importo,'€')}}</td>
						
						<td>
							@if (!$fattura->fatturaChiusa())
							<a href="{{ route('fatture.load-scadenza', ['scadenza_fattura_id' => $s->id]) }}" class="btn btn-info">
								<i class="fa fa-edit"></i>
							</a>
							@endif
						</td>
						
						<td>
							<form action="{{ route('fatture.delete-scadenza') }}" method="POST" accept-charset="utf-8" class="deleteForm"  id="delete_item_{{$s->id}}">
									<input type="hidden" name="_token" value="{{ csrf_token() }}" />
									<input type="hidden" name="scadenza_fattura_id" value="{{ $s->id }}" />
									<a data-id="{{$s->id}}" href="#" style="margin-bottom: 5px!important;" class="delete btn btn-danger"> 
											<i class="fa fa-trash"></i>
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
@endif

