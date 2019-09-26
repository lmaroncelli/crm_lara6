@extends('layouts.coreui.crm_lara6')

@section('content')

@include('layouts.coreui.menu_sezioni_clienti') 

<div class="row mt-5">
    <div class="col-md-12 sezioni-cliente">
    	
        <form action="" method="POST" id="record_delete">
          {{ method_field('DELETE') }}
          {!! csrf_field() !!}
          <input type="hidden" name="id" value="{{$societa->id}}">
        </form>

       <form class="" role="form" action="{{ route('clienti-fatturazioni.update', $societa->id) }}" method="POST">
     
        	{!! csrf_field() !!}


					{{-- Ragione sociale-Indirizzo --}}
       		<div class="form-group row">
       			<label class="col-md-2 text-change" for="nome_rag_soc">Ragione sociale:</label>
       			<div class="col-md-3">
       				<input type="text" name="nome_rag_soc" id="nome_rag_soc" value="{{ old('nome_rag_soc') != '' ?  old('nome_rag_soc') : $societa->ragioneSociale->nome}}"  class="form-control" placeholder="Ragione sociale">
       			</div>
       			<label class="col-md-2 text-change" for="indirizzo">Indirizzo:</label>
       			<div class="col-md-3">
       				<input type="text" name="indirizzo" id="indirizzo" value="{{ old('indirizzo') != '' ?  old('indirizzo') : $societa->ragioneSociale->indirizzo}}"  class="form-control" placeholder="Indirizzo">
       			</div>
       		</div>
					{{-- \Ragione sociale-Indirizzo --}}

					{{-- Città-CAP --}}
       		<div class="form-group row">
       			<label class="col-md-2 text-change" for="citta">Città:</label>
       			<div class="col-md-3">
       					<select class="form-control" id="localita_id" name="localita_id">
       						<option value="6">Altro</option>
       						@foreach ($localita as $localita_id => $localita)
       							<option value="{{$localita_id}}" @if ($societa->ragioneSociale->localita_id == $localita_id || old('localita_id') == $localita_id ) selected="selected" @endif>{{$localita}}</option>
       						@endforeach
       					</select>
       			</div>
       			<label class="col-md-2 text-change" for="cap">CAP:</label>
       			<div class="col-md-3">
       				<input type="text" name="cap" id="cap" value="{{ old('cap') != '' ?  old('cap') : $societa->ragioneSociale->cap}}"  class="form-control" placeholder="CAP">
       			</div>
       		</div>
					{{-- \Città-CAP --}}
					

					{{-- Partita IVA-Codice Fiscale --}}
       		<div class="form-group row">
       			<label class="col-md-2 text-change" for="piva">Partita IVA:</label>
       			<div class="col-md-3">
       				<input type="text" name="piva" id="piva" value="{{ old('piva') != '' ?  old('piva') : $societa->ragioneSociale->piva}}"  class="form-control" placeholder="Partita IVA">
       			</div>
       			<label class="col-md-2 text-change" for="cf">Codice Fiscale:</label>
       			<div class="col-md-3">
       				<input type="text" name="cf" id="cf" value="{{ old('cf') != '' ?  old('cf') : $societa->ragioneSociale->cf}}"  class="form-control" placeholder="Codice Fiscale">
       			</div>
       		</div>
					{{-- \Partita IVA-Codice Fiscale  --}}


					{{-- PEC-Codice SdI --}}
       		<div class="form-group row">
       			<label class="col-md-2 text-change" for="pec">PEC:</label>
       			<div class="col-md-3">
       				<input type="text" name="pec" id="pec" value="{{ old('pec') != '' ?  old('pec') : $societa->ragioneSociale->pec}}"  class="form-control" placeholder="PEC">
       			</div>
       			<label class="col-md-2 text-change" for="codice_sdi">Codice SdI:</label>
       			<div class="col-md-3">
       				<input type="text" name="codice_sdi" id="codice_sdi" value="{{ old('codice_sdi') != '' ?  old('codice_sdi') : $societa->ragioneSociale->codice_sdi}}"  class="form-control" placeholder="Codice SdI">
       			</div>
       		</div>
					{{-- \PEC-Codice SdI  --}}

					{{-- Banca --}}
		     		<div class="form-group row">
		     			<label class="col-md-2 text-change" for="banca">BANCA:</label>
		     			<div class="col-md-6">
		     				<input type="text" name="banca" id="banca" value="{{ old('banca') != '' ?  old('banca') : $societa->banca}}"  class="form-control" placeholder="BANCA">
		     			</div>
		     		</div>
						{{-- \Banca --}}
						
						{{-- abi cab iban --}}
		     		<div class="form-group row">
		     			<label class="col-md-1 col-form-label" for="abi">ABI:</label>
		     			<div class="col-md-2">
		     				<input type="text" name="abi" id="abi" value="{{ old('abi') != '' ?  old('abi') : $societa->abi}}"  class="form-control" placeholder="ABI">
		     			</div>
		     			<label class="col-md-1 col-form-label" for="cab">CAB:</label>
		     			<div class="col-md-2">
		     				<input type="text" name="cab" id="cab" value="{{ old('cab') != '' ?  old('cab') : $societa->cab}}"  class="form-control" placeholder="CAB">
		     			</div>
		     			<label class="col-md-1 col-form-label" for="iban">IBAN:</label>
		     			<div class="col-md-4">
		     				<input type="text" name="iban" id="iban" value="{{ old('iban') != '' ?  old('iban') : $societa->iban}}"  class="form-control" placeholder="IBAN">
		     			</div>
		     		</div>
						{{-- \abi cab iban  --}}


						<div class="form-group row">
							<label class="col-md-2 text-change" for="note">NOTE:</label>
							<div class="col-md-6">
									<textarea name="note" class="form-control" id="note" rows="4">{{ old('note') != '' ?  old('note') : $societa->note}}</textarea>
							</div>
						</div>
				
            <button type="submit" class="btn btn-success">
              @if ($societa->exists)
                Modifica
              @else
                Crea
              @endif
            </button>
            <a href="{{ url('clienti/fatturazioni/'.$societa->cliente_id) }}" title="Annulla" class="btn btn-secondary">Annulla</a>
    			     
     </form>

		</div>{{-- col --}}
</div>{{-- row --}}

<hr>

@include('clienti-fatturazioni._lista_societa_cliente')


@endsection


@section('js')

	<script type="text/javascript" charset="utf-8">

		jQuery(document).ready(function(){
		});
	
	</script>



@endsection