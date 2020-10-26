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
  
    
@endsection