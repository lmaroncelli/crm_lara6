<div class="m-portlet__head">
	<div class="m-portlet__head-progress">
	    
	    <!-- here can place a progress bar-->
	</div>
	<div class="m-portlet__head-wrapper">

		<div class="m-portlet__head-caption" style="width: 100%; display: flex; flex-wrap:wrap; justify-content: space-around; margin-top: 5px;">
			
			<div class="m-portlet__head-title">
				<h3 class="m-portlet__head-text info-cliente">
					<span class="main">{{$ragioneSociale->nome}}</span>
					<span class="other">{{$ragioneSociale->indirizzo}}</span>
					<span class="other">{{$ragioneSociale->localita->nome}} - {{$ragioneSociale->cap}} - {{$ragioneSociale->localita->comune->provincia->nome}} ({{$ragioneSociale->localita->comune->provincia->sigla}})</span>
			</div>

			<div class="info_societa">
					<ul>
						<li>
							<li><span>Partita IVA</span>: {{$ragioneSociale->piva}}</li>
							<li><span>Cod. Fiscale</span>: {{$ragioneSociale->cf}}</li>
							<li><span>PEC</span>: {{$ragioneSociale->pec}}</li>
							<li><span>Codice SdI</span>: {{$ragioneSociale->codice_sdi}}</li>
						</li>
					</ul>
			</div>

		</div>
	</div>
</div>