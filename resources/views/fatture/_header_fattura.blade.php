<input type="hidden" id="intestazione_cambiata" value=0>
<div class="row mb-5">
    <div class="col-sm-4">
        <div>
        <strong>Info Alberghi Srl</strong>
        </div>
        <div>Via Gambalunga, 81/A</div>
        <div>47921, Rimini(RN)</div>
        <div>P.IVA</div>
        <div>C.F.</div>
        <div>Codice SDI</div>
        <hr>
        <div><strong>Info Alberghi</strong></div>
        <div>Tel. 0541 29187</div>
        <div>Fax 0541 202027</div>
    </div>
    
    <div class="col-sm-4">
        <div>
        <strong>{{$fattura->getSocietaNome()}}</strong>
        </div>
        <div>{{$fattura->getSocietaIndirizzo()}}</div>
        <div>{{$fattura->getCap()}} - {{$fattura->getLocalita()}} ({{$fattura->getSiglaProv()}})</div>
        <div>P.IVA {{ $fattura->getPiva() }}</div>
        <div>C.F. {{ $fattura->getCf() }}</div>
        <div>Codice SDI {{ $fattura->getSdi() }}</div>
        <hr>
        <div><strong>{{optional(optional($fattura->societa)->cliente)->nome}}</strong></div>
        <div>Tel.{{optional(optional($fattura->societa)->cliente)->telefono}}</div>
        <div>Fax {{optional(optional($fattura->societa)->cliente)->fax}}</div>
    </div>
    
    <div class="col-sm-4">
        <button type="button" class="btn btn-warning" data-toggle="modal" data-keyboard="false" data-backdrop="static" data-target="#m_modal_societa">CAMBIA INTESTAZIONE</button>
    </div>
    
</div>
