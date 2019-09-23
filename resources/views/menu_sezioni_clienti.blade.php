<div class="m-portlet__head">
	<div class="m-portlet__head-progress">
	    
	    <!-- here can place a progress bar-->
	</div>
	<div class="m-portlet__head-wrapper">

		<div class="m-portlet__head-caption" style="width: 100%; display: flex; flex-wrap:wrap; justify-content: space-around; margin-top: 5px;">
			
			<div class="m-portlet__head-title">
				<h3 class="m-portlet__head-text info-cliente">
					<span class="main">{{$cliente->nome}} ID={{$cliente->id_info}}</span>
					<span class="other">{{$cliente->indirizzo}} {{$cliente->localita->nome}}</span>
			</div>

			<div class="add_item" style="margin-left: auto;">
						<div class="m-demo" data-code-preview="true" data-code-html="true" data-code-js="false">
							<div class="m-demo__preview">
								<ul class="m-nav m-nav--inline">
									<li class="m-nav__item">
										<a href="{{ route('clienti.edit',['cliente_id' => $cliente->id]) }}" {{-- class="m-nav__link --}} class="m-nav__link-text" ">
											<i class="m-nav__link-icon flaticon-share"></i>
											<span class="m-nav__link-text">Dati cliente</span>
										</a>
									</li>
									<li class="m-nav__item">
										<a href="{{ route('clienti-fatturazioni',['cliente_id' => $cliente->id]) }}" class="m-nav__link">
											<i class="m-nav__link-icon flaticon-chat-1"></i>
											<span class="m-nav__link-text">Fatturazione</span>
											<span class="m-nav__link-badge">
												<span class="m-badge m-badge--danger m-badge--wide m-badge--rounded">new</span>
											</span>
										</a>
									</li>
									<li class="m-nav__item">
										<a href="" class="m-nav__link">
											<i class="m-nav__link-icon flaticon-info"></i>
											<span class="m-nav__link-text">Servizi Venduti</span>
										</a>
									</li>
									<li class="m-nav__item">
										<a href="" class="m-nav__link">
											<i class="m-nav__link-icon flaticon-lifebuoy"></i>
											<span class="m-nav__link-text">Storico Servizi Venduti</span>
											<span class="m-nav__link-badge">
												<span class="m-badge m-badge--success m-badge--wide">23</span>
											</span>
										</a>
									</li>
								</ul>
							</div>
						</div>
			</div>

		</div>
	</div>
</div>