
<div class="row">
  <div class="col-sm-6 offset-sm-3">
    <div class="callout callout-info b-t-1 b-r-1 b-b-1 p-3">
      <strong class="h4">{{$cliente->nome}} ID={{$cliente->id_info}}</strong><br>
      <small class="text-muted">{{$cliente->indirizzo}} {{$cliente->localita->nome}}</small><br>
    </div>
  </div><!--/.col-->
</div>
<div class="row">
    <div class="col-md-12">
      <ul class="nav nav-tabs">
        <li class="nav-item">
          <a class="nav-link @if($controller=='ClientiController') active @endif"  href="{{ route('clienti.edit',$cliente->id) }}">Dati cliente</a>
        </li>
        <li class="nav-item">
          <a class="nav-link @if($controller=='ClientiFatturazioniController')  active @endif"  href="{{ route('clienti-fatturazioni',['cliente_id' => $cliente->id]) }}">Fatturazione</a>
        </li>
        <li class="nav-item">
          <a class="nav-link @if( $controller == 'ClientiServiziController' &&  $action == 'index')  active @endif" href="{{ route('clienti-servizi',['cliente_id' => $cliente->id]) }}">Servizi Venduti</a>
        </li>
        <li class="nav-item">
          <a class="nav-link @if( $controller == 'ClientiServiziController'  &&  $action == 'archiviati')  active @endif" href="{{ route('clienti-servizi-archiviati',['cliente_id' => $cliente->id]) }}">Storico servizi Venduti</a>
        </li>
        <li class="nav-item">
          <a class="nav-link @if( $controller == 'ClientiController'  &&  $action == 'elencoContratti')  active @endif" href="{{ route('clienti-contratti',['cliente_id' => $cliente->id]) }}">Contratti</a>
        </li>
        <li class="nav-item">
          <a class="nav-link @if( $controller == 'ClientiController'  &&  $action == 'elencoFoto')  active @endif" href="{{ route('clienti-foto',['cliente_id' => $cliente->id]) }}">Foto</a>
        </li>
      </ul>
    </div>
</div>