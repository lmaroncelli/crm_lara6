<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
  <style>
    body {
      font-size: 11px;
    }
  </style>
</head>
<body>
  <div class="header_pdf">
    <table>
      <tr>
        <td>
          <div class="box">
            <div class="titolo_box">
              CONTRATTO FORNITURA SERVIZI
            </div>
            <ul>
              <li>Nome Agente:</li>{{strtoupper($commerciale_contratto)}}
              <li>Tipo Contratto:</li>{{ strtoupper($contratto->tipo_contratto) }}
              @if ($contratto->segnalatore != '')
                <li>Seganlato da:</li>{{ strtoupper($contratto->segnalatore) }}
              @endif
            </ul>
          </div>
        </td>
        <td>
          <div class="info">
            <ul>
              <li><b>Info Alberghi Srl</b></li>
              <li>Via Gambalunga, 81/A</li>
              <li>47921 Rimini (RN)</li>
              <li>Tel 0541-29187 - Fax 0541-202027</li>
              <li>P. Iva 03479440400</li>
              <li>info@info-alberghi.com</li>
              <li>www.info-alberghi.com</li>
            </ul>
          </div>
        </td>
        <td>
          LOGO
        </td>
      </tr>
    </table>
  </div>

  <div class="sub_header">
    <table>
      <tr>
        <td>
          <div class="box">
            <div class="titolo_box">
              Cliente
            </div>
            {{$contratto->dati_cliente}}
            @if ($contratto->dati_referente != '')
            <hr>
            {{$contratto->dati_referente}}
            @endif
          </div>
        </td>
        <td>
          <div class="box">
            <div class="titolo_box">
              Dati fatturazione
            </div>
            {{$contratto->dati_fatturazione}}
          </div>
        </td>
      </tr>
    </table>
  </div>

  <div class="elenco_servizi">
    <table>
      <caption>Servizi venduti</caption>
      <thead>
        <tr>
          <th scope="col">Servizi digitali INFOALBERGHI.COM</th>
          <th scope="col">Dal</th>
          <th scope="col">Al</th>
          <th scope="col">Q.tà</th>
          <th scope="col" class="text-right">Importo (€)</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($servizi_assoc as $servizio)
          @if ($servizio->sconto)
            <tr class="sconto">
              <td colspan="4">
                {{$servizio->nome}}  
              </td>
              <td class="text-right"> - {{Utility::formatta_cifra($servizio->importo, '€')}}</td>
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
            </tr>
          @endif
        @endforeach
      </tbody>
    </table>
  </div>

  <div class="subfooter">
    <table>
      <tr>
        <td>
          Condizioni di pagamento
        </td>
        <td>
          Data
        </td>
      </tr>
      <tr>
        <td>{{$contratto->condizioni_pagamento}}</td>
        <td>
            @if ($contratto->data_pagamento != '')
            {{$contratto->data_pagamento}}
            @endif
        </td>
      </tr>
      <tr>
        <td colspan="2">
          IBAN: 
          @if ($contratto->iban != '')
          {{$contratto->iban}}
          @endif
        </td>
      </tr>
    </table>
  </div>
  <div class="footer">
    <table>
      <tr>
        <td colspan="2">
          Sito web: 
          @if ($contratto->sito_web != '')
          {{$contratto->sito_web}}
          @endif
        </td>
      </tr>
      <tr>
        <td>Email: {{$contratto->email}}</td>
        <td>Email Amministrativa{{$contratto->email_amministrativa}}</td>
      </tr>
      <tr>
        <td colspan="2">
          note: 
          @if ($contratto->note != '')
          {{$contratto->note}}
          @endif
        </td>
      </tr>
    </table>
  </div>
</body>
</html>