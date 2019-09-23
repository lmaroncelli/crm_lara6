<div class="m-portlet__body">
    @if (is_null($scadenza_fattura))
        <form action="{{ route('fatture.add-scadenza') }}" method="POST" accept-charset="utf-8" id="scadenza_fattura_form">
    @else
        <form action="{{ route('fatture.update-scadenza',['scadenza_fattura_id' => $scadenza_fattura->id]) }}" method="POST" accept-charset="utf-8" id="scadenza_fattura_form">
    @endif
     
        {!! csrf_field() !!}
        <input type="hidden" name="fattura_id" value="{{$fattura->id}}">
        <div class="form-group m-form__group row">

            <label class="col-lg-2 col-form-label text-right" for="tipo_id">Data:</label>
            <div class="col-lg-3">
                <div class="input-group date">
                    <input type="text" name="data_scadenza" class="form-control m-input" readonly value="{{ old('data_scadenza') != '' ?  old('data_scadenza') : optional(optional($scadenza_fattura)->data_scadenza)->format('d/m/Y')}}" id="m_datepicker_3" />
                    <div class="input-group-append">
                        <span class="input-group-text">
                            <i class="la la-calendar"></i>
                        </span>
                    </div>
                </div>
            </div>
             <label class="col-lg-1 col-form-label text-right" for="numero">Importo:</label>
             <div class="col-lg-1">
                    @if (old('importo') != '')
                       @php 
                       $valore = old('importo');
                        @endphp 
                    @else
                       @if (!is_null($scadenza_fattura))
                           @php
                               $valore = optional($scadenza_fattura)->importo;
                           @endphp
                       @else
                           @php
                              $valore = $fattura->getTotalePerChiudere();
                          @endphp
                       @endif
                    @endif
                 <input type="text" name="importo" id="importo" value="{{ $valore }}"  class="form-control m-input m-input--air m-input--pill">
             </div>
        </div>
        <div class="text-center">
            @if (is_null($scadenza_fattura))
                <button type="submit" class="btn btn-success">Inserisci</button>
                <button type="reset"  title="Annulla" class="btn btn-secondary">Annulla</button>
            @else
                <button type="submit" class="btn btn-success">Modifica</button>
                <a href="{{ route('fatture.edit',['fattura_id' => $fattura->id]) }}" title="Annulla" class="btn btn-secondary">Annulla</a>
            @endif
        </div>
    </form>
</div>