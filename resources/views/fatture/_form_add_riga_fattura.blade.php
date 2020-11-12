<div>
    @if (is_null($riga_fattura))
        <form action="{{ route('fatture.add-riga') }}" method="POST" accept-charset="utf-8" id="riga_fattura_form">
        {{-- true expr --}}
    @else
        <form action="{{ route('fatture.update-riga',['rigafattura_id' => $riga_fattura->id]) }}" method="POST" accept-charset="utf-8" id="riga_fattura_form">
    @endif
     
        {!! csrf_field() !!}
        <input type="hidden" name="fattura_id" value="{{$fattura->id}}">
        <input type="hidden" id="empty_text_area" value="0"> 
        <div class="form-group row">
            <div class="offset-lg-3 col-lg-1">
                <label class=" col-form-label" for="numero">Servizio:</label>
            </div>
            @if (count($servizio_prefill_arr))
                    <div class="col-lg-4"  id="prefill">
                        <select class="form-control m-select2" id="servizi" multiple name="servizi[]">
                            <option></option>
                            <optgroup label="Seleziona i servizi da fatturare">
                            @foreach ($servizio_prefill_arr as $id => $nome)
                                <option value="{{$id}}">{{$nome}}</option>
                            @endforeach
                            </optgroup>
                        </select>
                    </div>
                    <div class="col-lg-1">
                        <a href="#" class="add_servizi btn btn-warning" title="modifica il servizio a mano">
                            mod
                        </a>
                    </div>
                    <div class="col-lg-1" id="reset_servizi" style="display:none;">
                        <a href="{{ route('fatture.edit',['fattura_id' => $fattura->id]) }}" class="btn btn-danger" title="refresh">
                            refresh
                        </a>
                    </div>
            @else
                <div class="col-lg-5">
                    @if (old('servizio') != '')
                        <textarea name="servizio" class="form-control" id="servizio" rows="4">{!!old('servizio') != ''!!}</textarea>
                    @else
                        <textarea name="servizio" class="form-control" id="servizio" rows="4">{!!optional($riga_fattura)->servizio!!}</textarea>
                    @endif
                </div>
            @endif
        </div>
        <div class="form-group m-form__group row">
            <label class="col-lg-1 col-form-label text-right" for="qta">Qta:</label>
            <div class="col-lg-1">
                <input type="text" name="qta" id="qta" value="{{ old('qta') != '' ?  old('qta') : optional($riga_fattura)->qta}}"  class="trigger_row form-control">
            </div>
            <label class="col-lg-1 col-form-label text-right" for="prezzo">Prezzo:</label>
            <div class="col-lg-1">
                <input type="text" name="prezzo" id="prezzo" value="{{ old('prezzo') != '' ?  old('prezzo') : optional($riga_fattura)->prezzo}}"  class="trigger_row form-control">
            </div>
            <label class="col-lg-1 col-form-label text-right" for="totale_netto">Tot netto:</label>
            <div class="col-lg-1">
                <input type="text" name="totale_netto" readonly id="totale_netto" value="{{ old('totale_netto') != '' ?  old('totale_netto') : optional($riga_fattura)->totale_netto}}"  class="form-control">
            </div>

            <label class="col-lg-1 col-form-label text-right" for="perc_sconto">% Sconto:</label>
            <div class="col-lg-1">
                <input type="text" name="perc_sconto" id="perc_sconto" 
                @if (is_null($riga_fattura))
                    value="0"
                @else
                    value="{{ old('perc_sconto') != '' ?  old('perc_sconto') : optional($riga_fattura)->perc_sconto}}"  
                @endif
                class="trigger_row form-control">
            </div>

            <label class="col-lg-1 col-form-label text-right" for="totale_netto_scontato">Tot netto scontato:</label>
            <div class="col-lg-1">
                <input type="text" name="totale_netto_scontato" readonly id="totale_netto_scontato" value="{{ old('totale_netto_scontato') != '' ?  old('totale_netto_scontato') : optional($riga_fattura)->totale_netto_scontato}}"class="form-control">
            </div>

            <label class="col-lg-1 col-form-label text-right" for="al_iva">Al. IVA:</label>
            <div class="col-lg-1">
                <input type="text" name="al_iva" id="al_iva" value="22"  class="trigger_row form-control">
            </div>
            <label class="col-lg-1 col-form-label text-right" for="iva">IVA:</label>
            <div class="col-lg-1">
                <input type="text" name="iva" id="iva" readonly value="{{ old('iva') != '' ?  old('iva') : optional($riga_fattura)->iva}}"  class="form-control">
            </div>
             <label class="col-lg-1 col-form-label text-right" for="totale">Totale:</label>
             <div class="col-lg-1">
                 <input type="text" name="totale" id="totale" readonly value="{{ old('totale') != '' ?  old('totale') : optional($riga_fattura)->totale}}"  class="form-control">
             </div>
        </div>
        <div class="text-center">
            @if (is_null($riga_fattura))
                <button type="submit" class="btn btn-success">Inserisci</button>
                <button type="reset"  title="Annulla" class="btn btn-secondary">Annulla</button>
            @else
                <button type="submit" class="btn btn-success">Modifica</button>
                <a href="{{ route('fatture.edit',['fattura_id' => $fattura->id]) }}" title="Annulla" class="btn btn-secondary">Annulla</a>
            @endif
        </div>
    </form>
</div>
    
