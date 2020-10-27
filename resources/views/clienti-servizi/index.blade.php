@extends('layouts.coreui.crm_lara6')

@section('content')

@include('layouts.coreui.menu_sezioni_clienti') 

<div class="row">
  <div class="col-sm-2">
    <div class="callout callout-info b-t-1 b-r-1 b-b-1">
       Elenco servizi
      @if ($servizi->count())
      <br>
      <strong class="h4">{{$servizi->count()}}</strong>
      @endif
    </div>
  </div><!--/.col-->
</div>


<form-servizio-cliente ref='formServizioClienteComponent' cliente_id="{{$cliente->id}}"></form-servizio-cliente>


@include('clienti-servizi._lista_servizi_cliente')

@endsection


@section('js')
<script type="text/javascript" charset="utf-8">

  jQuery(document).ready(function(){
      

    $(".archivia").click(function(e){
        
        e.preventDefault();
        
        let servizio_id = $(this).data('id');
        let archivia = $(this).data('archivia');

        $.ajax({
            type: 'POST',
            url: "{{ route('clienti-servizi-archivia') }}",
            data: {'servizio_id':servizio_id, 'archiviato':archivia},
            success: function(msg) {
                $('tr#'+servizio_id).fadeOut('fast');
            }
        });
        
    });

  });


</script>
   
@endsection