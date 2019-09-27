<div class="row">
  <div class="col-sm-6 offset-sm-3">
    <div class="callout callout-info b-t-1 b-r-1 b-b-1 p-3">
      <strong class="h4">{{$ragioneSociale->nome}}</strong><br>
      <small class="text-muted">
        {{$ragioneSociale->indirizzo}}
        {{$ragioneSociale->localita->nome}} - {{$ragioneSociale->cap}} - {{$ragioneSociale->localita->comune->provincia->nome}} ({{$ragioneSociale->localita->comune->provincia->sigla}})
        <ul>
            <li><span>Partita IVA</span>: {{$ragioneSociale->piva}}</li>
            <li><span>Cod. Fiscale</span>: {{$ragioneSociale->cf}}</li>
            <li><span>PEC</span>: {{$ragioneSociale->pec}}</li>
            <li><span>Codice SdI</span>: {{$ragioneSociale->codice_sdi}}</li>
        </ul>
      </small>
    </div>
  </div><!--/.col-->
</div>

<form action="{{ url('societa/fatture/'.$societa_id) }}" method="get" id="searchForm" accept-charset="utf-8">
    <input type="hidden" name="orderby" id="orderby" value="">
    <input type="hidden" name="order" id="order" value="">
</form>