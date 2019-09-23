
@if ($fattura->scadenze->count())
<div class="row">
	<div class="col-lg-5">
		<div class="m-invoice__body">
		    <div class="table-responsive">
		        <table class="table riga_scadenza">
							<tbody>
							@foreach ($fattura->scadenze as $s)
							<tr>
								<td  style="max-width: 20px!important"><span class="m-list-timeline__icon flaticon-interface-7"></span></td>
								<td>{{$s->data_scadenza->format('d/m/Y')}}</td>
								<td><span class="m-badge m-badge--danger m-badge--wide">{{ App\Utility::formatta_cifra($s->importo,'€')}}	</span></td>
								<td>
									<a href="{{ route('fatture.load-scadenza', ['scadenza_fattura_id' => $s->id]) }}" style="margin-bottom: 5px!important;" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill">
									  <i class="la la-edit"></i>
									</a>
								</td>
								<td>
									<form action="{{ route('fatture.delete-scadenza') }}" method="POST" accept-charset="utf-8" class="deleteForm" id="delete-riga-form">
									    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
									     <input type="hidden" name="scadenza_fattura_id" value="{{ $s->id }}" />
									    <a href="#" style="margin-bottom: 5px!important;" class="delete btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill"> 
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
</div>
@endif

