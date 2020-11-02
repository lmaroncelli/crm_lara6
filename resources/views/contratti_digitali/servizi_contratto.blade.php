{{-- ServiziDigitali associati al contratto --}}
<div class="table-responsive">
  <table class="table">
    <caption>Servizi venduti</caption>
    <thead>
      <tr>
        <th scope="col">Servizi digitali INFOALBERGHI.COM</th>
        <th scope="col">Dal</th>
        <th scope="col">Al</th>
        <th scope="col">Q.tà</th>
        <th scope="col" class="text-right">Importo (€)</th>
        <th colspan="2"></th>
      </tr>
    </thead>
    <tbody>
      @foreach ($servizi_assoc as $servizio)
        @php
            if ($servizio->sconto) 
              {
              $nome = 'lo sconto';
              $title_del='Elimina '.$nome;
              } 
            else 
              {
              $nome = 'il servizio';
              $title_del='Elimina '.$nome;
              }
        @endphp
          @if ($servizio->sconto)
            <tr class="sconto">
              <td colspan="4">
                <i class="fas fa-tags"></i>&nbsp;&nbsp;{{$servizio->nome}}  
              </td>
              <td class="text-right"> - {{Utility::formatta_cifra($servizio->importo, '€')}}</td>
              <td></td>
              <td class="text-right">
                <button type="button" class="btn btn-danger btn-sm delRow" title="{{$title_del}}" data-nome ="{{$nome}}" data-idcontratto="{{$contratto->id}}" data-idservizio="{{$servizio->id}}"><i class="fas fa-trash-alt"></i></button>
              </td>
            </tr>
          @else
            <tr>
              @if ($servizio->nome == 'ALTRO')
                <td>{!!$servizio->altro_servizio!!}</td>                  
              @else
                <td>{{$servizio->nome}} - {{$servizio->localita}} @if ( !is_null($servizio->pagina) ) <br/> {{$servizio->pagina}} @endif</td>
              @endif
              <td>{{$servizio->dal}}</td>
              <td>{{$servizio->al}}</td>
              <td>{{$servizio->qta}}</td>
              <td class="text-right">{{Utility::formatta_cifra($servizio->importo, '€')}}</td>

              <td class="text-right">
                
                <button type="button" class="btn btn-primary btn-sm scontoRow" @if (!is_null($servizio->scontoAssociato)) disabled @endif title="Crea uno sconto per il servizio" data-idcontratto="{{$contratto->id}}" data-idservizio="{{$servizio->id}}">
                  <i class="fas fa-piggy-bank"></i>
                </button>
              </td>
              
              <td class="text-right">
                <button type="button" class="btn btn-danger btn-sm delRow" title="{{$title_del}}" data-nome ="{{$nome}}" data-idcontratto="{{$contratto->id}}" data-idservizio="{{$servizio->id}}"><i class="fas fa-trash-alt"></i></button>
              </td>
            </tr>
          @endif
      @endforeach
      
      {{-- riga sconto/servizio evidenza --}}
      <tr>
        <td colspan="7">
          <div id="container_row_ajax">
          </div>
        </td>
      </tr>
      {{-- /riga sconto/servizio evidenza --}}

      {{-- Riga creazione servizio da vendere --}}
      

      <tr>
        <td>
          <div class="form-group">
            <label for="servizio">Servizio da vendere</label>
            <select required id="servizi_select" class="form-control" name="servizio" data-idcontratto="{{$contratto->id}}">
              @foreach ($servizi_contratto as $key => $value)
                <option value="{{$key}}">{{$value}}</option>
              @endforeach
            </select>
          </div>
        </td>
      </tr>

      {{-- /Riga creazione servizio da vendere --}}

      {{-- riga totali --}}
      <tr>
        <td colspan="3" class="text-right font-weight-bold">TOTALE</td>
        <td>{{$totali['tot_qta']}}</td>
        <td class="text-right">{{Utility::formatta_cifra($totali['tot_importo'],'€')}}</td>
        <td colspan="2"></td>
      </tr>
      <tr>
        <td colspan="3" class="text-right font-weight-bold">IVA</td>
        <td>{{Utility::getIva()}}%</td>
        <td class="text-right">{{Utility::formatta_cifra($totali['tot_iva'],'€')}}</td>
        <td colspan="2"></td>
      </tr>
      <tr>
        <td colspan="3" class="text-right font-weight-bold">TOTALE FATTURA</td>
        <td></td>
        <td class="font-weight-bold text-right">{{Utility::formatta_cifra($totali['tot_importo_con_iva'],'€')}}</td>
        <td colspan="2"></td>
      </tr>
      {{-- / riga totali --}}

    </tbody>
  </table>
</div>
{{-- end ServiziDigitali associati al contratto --}}
