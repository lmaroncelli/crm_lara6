@extends('layouts.lara_crm')

@section('content')

<div class="row">
    <div class="col-xl-12 sezioni-cliente">


			<!--begin::Portlet-->
			<div class="m-portlet m-portlet--last m-portlet--head-lg m-portlet--responsive-mobile" id="main_portlet"">
			
        @include('menu_sezioni_clienti') 

        @if ($societa->exists)
        	
        	<form action="" method="POST" id="record_delete">
        		{{ method_field('DELETE') }}
        	  {!! csrf_field() !!}
        	  <input type="hidden" name="id" value="{{$societa->id}}">
        	</form>

       <form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" role="form" action="{{ route('clienti-fatturazioni.update', $societa->id) }}" method="POST">
        @else
        	<form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" role="form" action="{{ route('clienti-fatturazioni.store') }}" method="POST" enctype="multipart/form-data">
        @endif
        	{!! csrf_field() !!}

			<div class="m-portlet__body">

					{{-- Ragione sociale-Indirizzo --}}
       		<div class="form-group m-form__group row">
       			<label class="col-lg-2 col-form-label" for="nome_rag_soc">Ragione sociale:</label>
       			<div class="col-lg-3">
       				<input type="text" name="nome_rag_soc" id="nome_rag_soc" value="{{ old('nome_rag_soc') != '' ?  old('nome_rag_soc') : $societa->ragioneSociale->nome}}"  class="form-control m-input" placeholder="Ragione sociale">
       			</div>
       			<label class="col-lg-2 col-form-label" for="indirizzo">Indirizzo:</label>
       			<div class="col-lg-3">
       				<input type="text" name="indirizzo" id="indirizzo" value="{{ old('indirizzo') != '' ?  old('indirizzo') : $societa->ragioneSociale->indirizzo}}"  class="form-control m-input" placeholder="Indirizzo">
       			</div>
       		</div>
					{{-- \Ragione sociale-Indirizzo --}}

					{{-- Città-CAP --}}
       		<div class="form-group m-form__group row">
       			<label class="col-lg-2 col-form-label" for="citta">Città:</label>
       			<div class="col-lg-3">
       					<select class="form-control m-input" id="localita_id" name="localita_id">
       						<option value="6">Altro</option>
       						@foreach ($localita as $localita_id => $localita)
       							<option value="{{$localita_id}}" @if ($societa->ragioneSociale->localita_id == $localita_id || old('localita_id') == $localita_id ) selected="selected" @endif>{{$localita}}</option>
       						@endforeach
       					</select>
       			</div>
       			<label class="col-lg-2 col-form-label" for="cap">CAP:</label>
       			<div class="col-lg-3">
       				<input type="text" name="cap" id="cap" value="{{ old('cap') != '' ?  old('cap') : $societa->ragioneSociale->cap}}"  class="form-control m-input" placeholder="CAP">
       			</div>
       		</div>
					{{-- \Città-CAP --}}
					

					{{-- Partita IVA-Codice Fiscale --}}
       		<div class="form-group m-form__group row">
       			<label class="col-lg-2 col-form-label" for="piva">Partita IVA:</label>
       			<div class="col-lg-3">
       				<input type="text" name="piva" id="piva" value="{{ old('piva') != '' ?  old('piva') : $societa->ragioneSociale->piva}}"  class="form-control m-input" placeholder="Partita IVA">
       			</div>
       			<label class="col-lg-2 col-form-label" for="cf">Codice Fiscale:</label>
       			<div class="col-lg-3">
       				<input type="text" name="cf" id="cf" value="{{ old('cf') != '' ?  old('cf') : $societa->ragioneSociale->cf}}"  class="form-control m-input" placeholder="Codice Fiscale">
       			</div>
       		</div>
					{{-- \Partita IVA-Codice Fiscale  --}}


					{{-- PEC-Codice SdI --}}
       		<div class="form-group m-form__group row">
       			<label class="col-lg-2 col-form-label" for="pec">PEC:</label>
       			<div class="col-lg-3">
       				<input type="text" name="pec" id="pec" value="{{ old('pec') != '' ?  old('pec') : $societa->ragioneSociale->pec}}"  class="form-control m-input" placeholder="PEC">
       			</div>
       			<label class="col-lg-2 col-form-label" for="codice_sdi">Codice SdI:</label>
       			<div class="col-lg-3">
       				<input type="text" name="codice_sdi" id="codice_sdi" value="{{ old('codice_sdi') != '' ?  old('codice_sdi') : $societa->ragioneSociale->codice_sdi}}"  class="form-control m-input" placeholder="Codice SdI">
       			</div>
       		</div>
					{{-- \PEC-Codice SdI  --}}

					{{-- Banca --}}
		     		<div class="form-group m-form__group row">
		     			<label class="col-lg-2 col-form-label" for="banca">BANCA:</label>
		     			<div class="col-lg-6">
		     				<input type="text" name="banca" id="banca" value="{{ old('banca') != '' ?  old('banca') : $societa->banca}}"  class="form-control m-input" placeholder="BANCA">
		     			</div>
		     		</div>
						{{-- \Banca --}}
						
						{{-- abi cab iban --}}
		     		<div class="form-group m-form__group row">
		     			<label class="col-lg-1 col-form-label" for="abi">ABI:</label>
		     			<div class="col-lg-2">
		     				<input type="text" name="abi" id="abi" value="{{ old('abi') != '' ?  old('abi') : $societa->abi}}"  class="form-control m-input" placeholder="ABI">
		     			</div>
		     			<label class="col-lg-1 col-form-label" for="cab">CAB:</label>
		     			<div class="col-lg-2">
		     				<input type="text" name="cab" id="cab" value="{{ old('cab') != '' ?  old('cab') : $societa->cab}}"  class="form-control m-input" placeholder="CAB">
		     			</div>
		     			<label class="col-lg-1 col-form-label" for="iban">IBAN:</label>
		     			<div class="col-lg-4">
		     				<input type="text" name="iban" id="iban" value="{{ old('iban') != '' ?  old('iban') : $societa->iban}}"  class="form-control m-input" placeholder="IBAN">
		     			</div>
		     		</div>
						{{-- \abi cab iban  --}}


						<div class="form-group m-form__group row">
							<label class="col-lg-2 col-form-label" for="note">NOTE:</label>
							<div class="col-lg-6">
									<textarea name="note" class="form-control m-input" id="note" rows="4">{{ old('note') != '' ?  old('note') : $societa->note}}</textarea>
							</div>
						</div>
					
      </div> {{-- m-portlet__body --}}
						
    	<div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
    		<div class="m-form__actions m-form__actions--solid">
    			<div class="row">
    				<div class="col-lg-2"></div>
    				<div class="col-lg-10">
    					<button type="submit" class="btn btn-success">
    						@if ($societa->exists)
    							Modifica
    						@else
    							Crea
    						@endif
    					</button>
    					<a href="{{ url('clienti/fatturazioni/'.$societa->cliente_id) }}" title="Annulla" class="btn btn-secondary">Annulla</a>
    				</div>
    			</div>
    		</div>
    	</div>

     
     </form>
  </div> {{-- m-portlet --}}

		</div>{{-- col --}}
</div>{{-- row --}}

@endsection


@section('js')

	<script type="text/javascript" charset="utf-8">

		jQuery(document).ready(function(){
		});
	
	</script>



@endsection