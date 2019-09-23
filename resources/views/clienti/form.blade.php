@extends('layouts.lara_crm')

@section('content')

<div class="row">
    <div class="col-xl-12 sezioni-cliente">


			<!--begin::Portlet-->
			<div class="m-portlet m-portlet--last m-portlet--head-lg m-portlet--responsive-mobile" id="main_portlet"">
			
        @include('menu_sezioni_clienti') 


			<div class="m-portlet__body">

	          @if ($cliente->exists)
	          	
	          	<form action="{{ route('clienti.destroy', $cliente->id) }}" method="POST" id="record_delete">
	          		{{ method_field('DELETE') }}
	          	  {!! csrf_field() !!}
	          	  <input type="hidden" name="id" value="{{$cliente->id}}">
	          	</form>

	          	<form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" role="form" action="{{ route('clienti.update', $cliente->id) }}" method="POST">
	          	{{ method_field('PUT') }}
	          @else
	          	<form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" role="form" action="{{ route('clienti.store') }}" method="POST" enctype="multipart/form-data">
	          @endif
	          	{!! csrf_field() !!}
									
									{{-- Attivo-AttivoIA --}}
               		<div class="form-group m-form__group row">
               			<label class="col-lg-2 col-form-label" for="attivo">Stato:</label>
               			<div class="col-lg-3">
               					<select class="form-control m-input" id="attivo" name="attivo">
               							<option value="1" @if ( $cliente->attivo == 1 || old('attivo') == 1 ) selected="selected" @endif>Attivo</option>
               							<option value="0" @if ( $cliente->attivo == 0 || (old('attivo') !== null && old('attivo') == 0) ) selected="selected" @endif>NON Attivo</option>
               					</select>
												
												@if (!is_null($cliente->data_attivazione) || !is_null($cliente->data_disattivazione))

	               					<span class="m-form__help">
	               						@if ($cliente->attivo)
	               						<span class="m-badge m-badge--success m-badge--wide data_attivazione">
	               							{{optional($cliente->data_attivazione)->format('d/m/Y')}}
	               						</span>
	               						@else
	               						<span class="m-badge m-badge--danger m-badge--wide data_attivazione">
	               							{{optional($cliente->data_disattivazione)->format('d/m/Y')}}
	               						</span>
	               						@endif
	               					</span>

												@endif
               			</div>
               			<label class="col-lg-2 col-form-label" for="attivo_IA">Infoalberghi:</label>
               			<div class="col-lg-3">
               					<select class="form-control m-input" id="attivo_IA" name="attivo_IA">
               							<option value="1" @if ( $cliente->attivo_IA == 1 || old('attivo_IA') == 1 ) selected="selected" @endif>Attivo</option>
               							<option value="0" @if ( $cliente->attivo_IA == 0 || (old('attivo_IA') !== null && old('attivo_IA') == 0) ) selected="selected" @endif>NON Attivo</option>
               					</select>

												@if (!is_null($cliente->data_attivazione_IA) || !is_null($cliente->data_disattivazione_IA))
												
               					<span class="m-form__help">
               						@if ($cliente->attivo_IA)
               						<span class="m-badge m-badge--success m-badge--wide data_attivazione">
               							{{optional($cliente->data_attivazione_IA)->format('d/m/Y')}}
               						</span>
               						@else
               						<span class="m-badge m-badge--danger m-badge--wide data_attivazione">
               							{{optional($cliente->data_disattivazione_IA)->format('d/m/Y')}}
               						</span>
               						@endif
               					</span>
												
												@endif
               			</div>
               		</div>
									{{-- \Attivo-AttivoIA --}}


									{{-- Nome-Tipo --}}
	             		<div class="form-group m-form__group row">
	             			<label class="col-lg-2 col-form-label" for="nome">Nome:</label>
	             			<div class="col-lg-3">
	             				<input type="text" name="nome" id="nome" value="{{ old('nome') != '' ?  old('nome') : $cliente->nome}}"  class="form-control m-input" placeholder="Nome">
	             			</div>
	             			<label class="col-lg-2 col-form-label" for="tipo_id">Tipo:</label>
	             			<div class="col-lg-3">
	             					<select class="form-control m-input" id="tipo_id" name="tipo_id">
	             						@foreach ($tipi_cliente as $tipo_id => $tipo)
	             							<option value="{{$tipo_id}}" @if ($cliente->tipo_id == $tipo_id || old('tipo_id') == $tipo_id ) selected="selected" @endif>{{$tipo}}</option>
	             						@endforeach
	             					</select>
	             			</div>
	             		</div>
									{{-- \Nome-Tipo --}}

									{{-- Indirizzo-Categoria --}}
	             		<div class="form-group m-form__group row">
	             			<label class="col-lg-2 col-form-label" for="indirizzo">Indirizzo:</label>
	             			<div class="col-lg-3">
	             				<input type="text" name="indirizzo" id="indirizzo" value="{{ old('indirizzo') != '' ?  old('indirizzo') : $cliente->indirizzo}}"  class="form-control m-input" placeholder="Nome">
	             			</div>
	             			<label class="col-lg-2 col-form-label" for="categoria_id">Categoria:</label>
	             			<div class="col-lg-3">
	             					<select class="form-control m-input" id="categoria_id" name="categoria_id">
	             						<option value="6">Altro</option>
	             						@foreach ($cataegorie_cliente as $categoria_id => $categoria)
	             							<option value="{{$categoria_id}}" @if ($cliente->categoria_id == $categoria_id || old('categoria_id') == $categoria_id ) selected="selected" @endif>{{$categoria}}</option>
	             						@endforeach
	             					</select>
	             			</div>
	             		</div>
									{{-- \Indirizzo-Categoria --}}


									{{-- Città-CAP --}}
	             		<div class="form-group m-form__group row">
	             			<label class="col-lg-2 col-form-label" for="localita_id">Località:</label>
	             			<div class="col-lg-3">
	             					<select class="form-control m-input" id="localita_id" name="localita_id">
	             						<option value="6">Altro</option>
	             						@foreach ($localita_cliente as $localita_id => $localita)
	             							<option value="{{$localita_id}}" @if ($cliente->localita_id == $localita_id || old('localita_id') == $localita_id ) selected="selected" @endif>{{$localita}}</option>
	             						@endforeach
	             					</select>
	             			</div>
	             			<label class="col-lg-2 col-form-label" id="luogo">{{$cliente->localita->comune->nome}} ({{$cliente->localita->comune->provincia->sigla}}) - {{$cliente->localita->comune->provincia->regione->nome}}</label>
	             			<label class="col-lg-2 col-form-label" for="cap">CAP:</label>
	             			<div class="col-lg-3">
	             				<input type="text" name="cap" id="cap" value="{{ old('cap') != '' ?  old('cap') : $cliente->cap}}"  class="form-control m-input" placeholder="CAP">
	             			</div>
	             		</div>
									{{-- \Città-CAP --}}

									{{-- Telefono-Fax --}}
	             		<div class="form-group m-form__group row">
	             			<label class="col-lg-2 col-form-label" for="telefono">Telefono:</label>
	             			<div class="col-lg-3">
	             				<input type="text" name="telefono" id="telefono" value="{{ old('telefono') != '' ?  old('telefono') : $cliente->telefono}}"  class="form-control m-input" placeholder="Telefono">
	             			</div>
	             			<label class="col-lg-2 col-form-label" for="fax">FAX:</label>
	             			<div class="col-lg-3">
	             				<input type="text" name="fax" id="fax" value="{{ old('fax') != '' ?  old('fax') : $cliente->fax}}"  class="form-control m-input" placeholder="FAX">
	             			</div>
	             		</div>
									{{-- \Telefono-Fax --}}

									{{-- cellulare-Skype --}}
	             		<div class="form-group m-form__group row">
	             			<label class="col-lg-2 col-form-label" for="cell">Cellulare:</label>
	             			<div class="col-lg-3">
	             				<input type="text" name="cell" id="cell" value="{{ old('cell') != '' ?  old('cell') : $cliente->cell}}"  class="form-control m-input" placeholder="Cellulare">
	             			</div>
	             			<label class="col-lg-2 col-form-label" for="skype">Skype:</label>
	             			<div class="col-lg-3">
	             				<input type="text" name="skype" id="skype" value="{{ old('skype') != '' ?  old('skype') : $cliente->skype}}"  class="form-control m-input" placeholder="Skype">
	             			</div>
	             		</div>
									{{-- \cellulare-Skype --}}

									{{-- WhatsApp-Sms --}}
	             		<div class="form-group m-form__group row">
	             			<label class="col-lg-2 col-form-label" for="whatsapp">WhatsApp:</label>
	             			<div class="col-lg-3">
	             				<input type="text" name="whatsapp" id="whatsapp" value="{{ old('whatsapp') != '' ?  old('whatsapp') : $cliente->whatsapp}}"  class="form-control m-input" placeholder="WhatsApp">
	             			</div>
	             			<label class="col-lg-2 col-form-label" for="sms">Sms:</label>
	             			<div class="col-lg-3">
	             				<input type="text" name="sms" id="sms" value="{{ old('sms') != '' ?  old('sms') : $cliente->sms}}"  class="form-control m-input" placeholder="Sms">
	             			</div>
	             		</div>
									{{-- \WhatsApp-Sms --}}

									{{-- Web-Email --}}
	             		<div class="form-group m-form__group row">
	             			<label class="col-lg-2 col-form-label" for="web">Web:</label>
	             			<div class="col-lg-3 input-group">
	             				<input type="text" name="web" id="web" value="{{ old('web') != '' ?  old('web') : $cliente->web}}"  class="form-control m-input" placeholder="Web">
	             				@if ($cliente->web != '')
		             				<div class="input-group-append">
		             					<a href="{{$cliente->web}}" target="_blank" class="btn btn-warning" title="Vai">Vai!</a>
		             				</div>
	             				@endif
	             			</div>
	             			<label class="col-lg-2 col-form-label" for="email">Email:</label>
	             			<div class="col-lg-3">
	             				<input type="text" name="email" id="email" value="{{ old('email') != '' ?  old('email') : $cliente->email}}"  class="form-control m-input" placeholder="Email">
	             			</div>
	             		</div>
									{{-- \Web-Email --}}
									
									
									{{-- Associato-Visibile --}}
	             		<div class="form-group m-form__group row">
	             			<label class="col-lg-2 col-form-label" for="associato">Associato:</label>
	             			<div class="col-lg-3">
	             				<select class="form-control m-select2" id="associato" multiple name="associato">
													<option></option>
													<optgroup label="Associato a">
													@foreach ($commerciali as $id => $nome)
														<option value="{{$id}}" @if ( in_array($id, $cliente->commercialiAssociatiIds()) ) selected="selected" @endif >{{$nome}}</option>
													@endforeach
													</optgroup>
												</select>
	             			</div>
	             			<label class="col-lg-2 col-form-label" for="visibile">Visibile:</label>
	             			<div class="col-lg-3">
	             					<select class="form-control m-select2" id="visibile" multiple name="visibile">
														<option></option>
														<optgroup label="Visibile a">
														@foreach ($commerciali as $id => $nome)
															<option value="{{$id}}" @if ( in_array($id, $cliente->commercialiVisibilitaIds()) ) selected="selected" @endif >{{$nome}}</option>
														@endforeach
														</optgroup>
													</select>
	             			</div>
	             		</div>
									{{-- \Associato-Visibile --}}
									
									@if ($cliente->exists)
										{{-- Contatti --}}
										<div class="m-content">
											<div class="row">
												<div class="offset-lg-1 col-lg-10" style="padding: 10px; 0">
													<button type="button" class="btn btn-warning" data-toggle="modal" data-keyboard="false" data-backdrop="static" data-target="#m_modal_contatti">Associa contatti al ciente</button>
												</div>
											</div>
											<div class="row">
											<div class="offset-lg-1 col-lg-10">

													<!--begin::Portlet-->
													<div class="m-portlet m-portlet--tabs m-portlet--success m-portlet--head-solid-bg m-portlet--head-sm">
														<div class="m-portlet__head">
															<div class="m-portlet__head-caption">
																<div class="m-portlet__head-title">
																	<h3 class="m-portlet__head-text">
																		Contatti
																	</h3>
																</div>
															</div>
															<div class="m-portlet__head-tools">
																<ul class="nav nav-tabs m-tabs m-tabs-line  m-tabs-line--right" role="tablist">
																	@foreach ($cliente->contatti as $key => $contatto)
																	<li class="nav-item m-tabs__item">
																		<a class="nav-link m-tabs__link @if ($key == 0)active @endif" data-toggle="tab" href="#m_tabs_7_{{$key}}" role="tab">
																			{{$contatto->nome}}
																		</a>
																	</li>
																	@endforeach
																</ul>
															</div>
														</div>
														<div class="m-portlet__body">
															<div class="tab-content">
																@foreach ($cliente->contatti as $key => $contatto)
																<div class="tab-pane @if ($key == 0)active @endif" id="m_tabs_7_{{$key}}" role="tabpanel">
																	<ul class="content_contatto">
																		@foreach ($contatto->viewColumns() as $colonna)
																		@if ($contatto->$colonna != '')
																				@if ($colonna == 'fea_doc_nome')
																					<li class="fea_doc_nome"><a href="{{ asset('contrattti/documenti_fea/'.$contatto->$colonna) }}" title="Fea"><i class="fea_doc fa fa-file-pdf"></i></a></li>
																				@elseif($colonna == 'nome')
																					<li><span><i class="fa fa-user"></i> {!!$contatto->$colonna!!}</span></li>
																				@else
																					<li><span>{{$colonna}}:</span> {!!$contatto->$colonna!!}</li>
																				@endif
																		@endif
																		@endforeach
																		<li class="dissocia">
																			<a href="#" data-contatto="{{$contatto->id}}" class="dissocia_contatto btn btn-danger m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill m-btn--air">
																				<i class="fa fa-user-slash"></i>
																				<span class="associazione_contatto ">Elimina associazione con questo contatto</span>
																			</a>
																		</li>
																	</ul>
																	
																</div>
																@endforeach
															</div>
														</div>
													</div>

											</div>
											</div>
										</div>
										{{-- \Contatti --}}
									@endif

									@if ($cliente->exists && !is_null($cliente->gruppo))
										{{-- GRUPPI --}}
											<div class="m-content">
												<div class="row">
													<div class="offset-lg-1 col-lg-10" style="padding: 10px; 0">
														<div class="m-section">
															<h3 class="m-section__heading">
																{{$cliente->gruppo->nome}}
															</h3>
															<div class="m-section__content container_gruppo">
																@foreach ($cliente->gruppo->clienti as $cliente_gruppo)
																	@if ($cliente_gruppo->id != $cliente->id)
																		<a href="{{ route('clienti.edit',['id' => $cliente_gruppo->id]) }}" class="@if(!$cliente_gruppo->attivo) disattivato @endif">{{$cliente_gruppo->nome}} (ID {{$cliente_gruppo->id_info}})</a>
																	@endif
																@endforeach
															</div>
														</div>
													</div>
												</div>
											</div>
										{{-- \GRUPPI --}}
									@endif
									

            		</form>

            	</div> {{-- m-portlet__body --}}
						
            
            	<div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
            		<div class="m-form__actions m-form__actions--solid">
            			<div class="row">
            				<div class="col-lg-2"></div>
            				<div class="col-lg-10">
            					<button type="reset" class="btn btn-success">
            						@if ($cliente->exists)
            							Modifica
            						@else
            							Crea
            						@endif
            					</button>
            					<a href="{{ url('clienti') }}" title="Annulla" class="btn btn-secondary">Annulla</a>
            				</div>
            			</div>
            		</div>
            	</div>

     
        </div> {{-- m-portlet --}}

		</div>{{-- col --}}
</div>{{-- row --}}


{{-- MODAL elenco contatti --}}
<div class="modal fade" id="m_modal_contatti" tabindex="-1" role="dialog" aria-labelledby="contatti" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="contatti">Elenco contatti</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="m-scrollable m-scrollable--track m-scroller ps ps--active-y" data-scrollable="true" style="height: 400px; overflow: hidden;">
				<table class="table table-striped m-table m-table--head-bg-success">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($contatti as $contatto)
                  <tr>
                      <td>
                      	<label class="m-checkbox">
													<input type="checkbox" @if (in_array($contatto->id, $cliente->contatti->pluck('id')->toArray())) checked="checked" @endif class="contatti_cliente" value="{{$contatto->id}}"> {{$contatto->nome}}
													<span></span>
												</label>
                      </td>
                      <td>{{$contatto->email}}</td>
                  </tr>
                @endforeach
            </tbody>
        </table>
      	</div>
			</div>
		</div>
	</div>
</div>
{{-- \MODAL elenco contatti --}}


@endsection


@section('js')
	<script type="text/javascript" charset="utf-8">
		
		function gestisciContatti(val) {
			var contatto_id = val;
			var cliente_id = '{{$cliente->id}}';
			jQuery.ajax({
			        url: '<?=url("gestisci-contatti-ajax") ?>',
			        type: "post",
			        async: false,
			        data : { 
			               'contatto_id': contatto_id, 
			               'cliente_id': cliente_id,
			               '_token': jQuery('input[name=_token]').val()
			               },
			       	success: function(data) {
			         
			       }
			 });
		}

		jQuery(document).ready(function(){
			$("#associato").select2({placeholder:"Seleziona i commerciali da associare"});
			$("#visibile").select2({placeholder:"Seleziona i commerciali che hanno la visibilità"});
	

			$(".contatti_cliente").click(function(){
				gestisciContatti(this.value);
			});


			$(".close").click(function(){
				alert('La pagina si riaggiorna per visualizzare le modifiche effettuate!');
				location.reload();
			});

			$(".dissocia_contatto").click(function(e){
				e.preventDefault();
				var val = $(this).data("contatto");
				gestisciContatti(val);
				alert('La pagina si riaggiorna per visualizzare le modifiche effettuate!');
				location.reload();
			});



		});
	

	</script>
	<script src="{{ asset('js/select2.js') }}" type="text/javascript"></script>


@endsection