<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
  <!-- Styles -->
  <link href="{{ mix('css/app.css') }}" rel="stylesheet">
  <style>

    @font-face {
        font-family: 'calibri';
        src: url({{ storage_path('fonts/calibri.ttf') }}) format("truetype");
        font-weight: 400; 
        font-style: normal;
    }

    body {
      font-family: calibri, sans-serif;
      margin: 0;
      font-size: 12px;
      font-weight: 400;
    }

    .mt-4 {
      margin-top: 40px;
    }

    .mt-3 {
      margin-top: 30px;
    }

    .mt-2 {
      margin-top: 20px;
    }
    
    div.card {
      border: 1px solid #333;
    }

    div.card-header {
      padding:5px;
      font-size: 15px;
    	background-color: #efefef;
      /*border: 1px solid #333;*/
      font-weight:bold;
      margin-bottom: 0px;
      border-bottom: 1px solid #333;
    }

    div.card-body ul, 
    div.info ul {
      list-style-type: none;
      padding: 0;
      margin: 0;
      margin-left:20px;
    }

    div.card-body ul li{
      margin: 10px 0;
    }

    div.card-body ul li span{
      font-weight: bold;
      text-transform: uppercase;
    }


    .info {
      padding: 0;
      margin: 0;
      padding-left: 15px;
    }
    .info ul {
      list-style-type: none;
      padding: 0;
      margin: 0;
    }

    .info ul li {
      padding: 0;
      margin: 0;
    }


    div.dati_cliente {
      padding: 10px 30px;
    }


    div.elenco_servizi thead th {
      padding:5px;
      font-size: 15px;
    	background-color: #efefef;
      font-weight:bold;
      margin-bottom: 0px;
      border: 1px solid #fff;
    }



    div.elenco_servizi tr td{
      height:30px;
    }

    div.elenco_servizi tr.sconto {
      color: crimson;
    }

    div.elenco_servizi td.text-right {
      text-align: right;
    }


    div.subfooter{
      position: fixed;
      margin: 0 auto;
      bottom: 240px;
      border: 1px solid #333;
    }

    div.footer{
      position: fixed;
      margin: 0 auto;
      bottom: 150px;
      border: 1px solid #333;
    }


    div.footer span, div.subfooter span {
      font-weight: bold;
    }


    div.footer .note {
      min-height: 60px;
    }

  </style>
</head>
<body>
  <main class="main">
    <div class="container">

      <div class="row mt-2">
        <div class="col">

            <div class="header_pdf">
              <table width="100%" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="38%" valign="top">
                    <div class="card">
                      <div class="card-header">CONTRATTO FORNITURA SERVIZI</div>
                      <div class="card-body">
                        <ul>
                          <li><span>Nome Agente</span> {{strtoupper($commerciale_contratto)}}</li>
                          <li><span>Tipo Contratto</span> {{ strtoupper($contratto->tipo_contratto) }}</li>
                          @if ($contratto->segnalatore != '')
                            <li><span>Seganlato da</span> {{ strtoupper($contratto->segnalatore) }}</li>
                          @endif
                        </ul>
                      </div>
                    </div>
                  </td>
                  <td width="33%" valign="top">
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
                  <td align="right">
                    <img src="{{ asset('images/logo_pdf.png') }}">
                  </td>
                </tr>
              </table>
            </div>
        
        </div>
      </div>

      <div class="row mt-3">
        <div class="col">

            <div class="sub_header">
              <table width="100%" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="50%" valign="top">
                    <div class="card">
                      <div class="card-header">
                        Cliente
                      </div>
                      <div class="card-body">
                        <div class="dati_cliente">
                        {{$contratto->dati_cliente}}
                        @if ($contratto->dati_referente != '')
                        {{$contratto->dati_referente}}
                        @endif
                        </div>
                      </div>
                    </div>
                  </td>
                  <td width="50%" valign="top">
                    <div class="card">
                      <div class="card-header">
                        Dati fatturazione
                      </div>
                      <div class="card-body">
                        <div class="dati_cliente">
                        {{$contratto->dati_fatturazione}}
                        </div>
                      </div>
                    </div>
                  </td>
                </tr>
              </table>
            </div>
        
        </div>
      </div>
  
      <div class="row mt-3">
        <div class="col">
          <div class="elenco_servizi">
            <table width="100%" cellpadding="0" cellspacing="0">
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
                      <td class="text-right"> - {{Utility::formatta_cifra($servizio->importo)}}</td>
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
                      <td class="text-right">{{$servizio->qta}}</td>
                      <td class="text-right">{{Utility::formatta_cifra($servizio->importo)}}</td>
                    </tr>
                  @endif
                @endforeach
              </tbody>
            </table>
          </div>
        </div> 
      </div>
      
      
      <div class="subfooter">
        <table width="100%" cellpadding="5" cellspacing="0">
          <tr>
            <td>
              <span>Condizioni di pagamento</span>
            </td>
            <td>
            <span>Data</span>
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
        <table width="100%" cellpadding="5" cellspacing="0">
          <tr>
            <td colspan="2">
              <span>Sito web: </span> 
              @if ($contratto->sito_web != '')
              {{$contratto->sito_web}}
              @endif
            </td>
          </tr>
          <tr>
            <td><span>Email: </span> {{$contratto->email}}</td>
            <td><span>Email Amministrativa: </span> {{$contratto->email_amministrativa}}</td>
          </tr>
          <tr>
            <td colspan="2">
              <div class="note">
              <span>note: </span> 
                @if ($contratto->note != '')
                {{$contratto->note}}
                @endif
              </div>
            </td>
          </tr>
        </table>
      </div>
        
    
    </div>
  </main>
</body>
</html>