@extends('layouts.coreui.crm_lara6')

@section('content')
<div class="row">
    <div class="col">
        <p>Link veloci</p>  
    </div>
</div>
<div class="row">
  <div class="col-sm-6 col-md-2 link_to" data-url="{{ url('memorex') }}">
    <div class="card text-white bg-primary">
			<div class="card-body">
				<div class="text-muted text-right mb-4">
					<i class="nav-icon icon-book-open icon-homepage"></i>
				</div>
				<div class="text-value-lg">{{$memorex_count}}</div><small class="text-muted text-uppercase font-weight-bold">MEMOREX scadute</small>
				<div class="progress progress-white progress-xs mt-3">
					<div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
				</div>
			</div>
    </div>
	</div>
	<div class="col-sm-6 col-md-2 link_to" data-url="{{ route('clienti.index') }}">
    <div class="card text-white bg-warning">
			<div class="card-body">
				<div class="text-muted text-right mb-4">
					<i class="fas fa-users icon-homepage"></i>
				</div>
				<div class="text-value-lg">{{$clienti_attivi_count}}</div><small class="text-muted text-uppercase font-weight-bold">CLIENTI attivi</small>
				<div class="progress progress-white progress-xs mt-3">
					<div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
				</div>
			</div>
    </div>
	</div>
	<div class="col-sm-6 col-md-2 link_to" data-url="{{ route('clienti.index') }}">
    <div class="card text-white bg-success">
			<div class="card-body">
				<div class="text-muted text-right mb-4">
					<i class="nav-icon icon-people icon-homepage"></i>
				</div>
				<div class="text-value-lg">{{$clienti_attivi_ia_count}}</div><small class="text-muted text-uppercase font-weight-bold">CLIENTI attivi su IA</small>
				<div class="progress progress-white progress-xs mt-3">
					<div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
				</div>
			</div>
    </div>
	</div>
	
	<div class="col-sm-6 col-md-2 link_to" data-url="{{ route('clienti.index') }}">
    <div class="card text-white bg-info">
			<div class="card-body">
				<div class="text-muted text-right mb-4">
					<i class="nav-icon icon-people icon-homepage"></i>
				</div>
				<div class="text-value-lg">{{$fatture_count}}</div><small class="text-muted text-uppercase font-weight-bold">Fatture ultimi {{$last_days}} giorni </small>
				<div class="progress progress-white progress-xs mt-3">
					<div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
				</div>
			</div>
    </div>
	</div>
	
	<div class="col-sm-6 col-md-2 link_to" data-url="{{ route('clienti.index') }}">
    <div class="card text-white bg-secondary">
			<div class="card-body">
				<div class="text-muted text-right mb-4">
					<i class="nav-icon icon-people icon-homepage"></i>
				</div>
				<div class="text-value-lg">{{$prefatture_count}}</div><small class="text-muted text-uppercase font-weight-bold">Prefatture ultimi {{$last_days}} giorni </small>
				<div class="progress progress-white progress-xs mt-3">
					<div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
				</div>
			</div>
    </div>
  </div>
</div>

<div class="row">
	<div class="col">
		<graph-attivazioni></graph-attivazioni>
	</div>
</div>
@endsection


@section('js')
	<script type="text/javascript" charset="utf-8">

  jQuery(document).ready(function($=jQuery){
    
		$(".link_to").click(function(){
			let url = $(this).data("url");
			location.href = url;
		});

  });


</script>
@endsection