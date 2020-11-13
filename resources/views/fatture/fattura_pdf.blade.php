<!DOCTYPE html>
<html lang="it">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
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

    div.elenco_servizi thead th
     {
      padding:5px;
      font-size: 12px;
    	/* background-color: #efefef; */
      font-weight:bold;
      margin-bottom: 0px;
      border: 1px solid #fff;
    }

  
    div.elenco_servizi tr.elenco td{
      height:50px;
      font-size: 11px;
    }
    
    div.elenco_servizi tr.totale td
     {
      font-weight:bold;
    }

    div.elenco_servizi tr.totale td.totalone {
      padding:5px;
      font-size: 12px;
    	background-color: #000;
      font-weight:bold;
      color: #fff;
      text-transform: uppercase;
    }


    div.elenco_servizi tr.sconto {
      color: crimson;
    }


    div.elenco_servizi font-weight-bold {
      font-weight: 700!important;
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

    div.subfooter tr.condizioni_pagamento td
     {
      padding:3px;
      height:20px;  
    	background-color: #efefef;
      font-weight:bold;
      margin-bottom: 0px;
    }


    div.footer .note {
      min-height: 60px;
    }


    .text-left {
      text-align: left;
    }

    .text-right {
      text-align: right;
    }

    .underline {
      border-bottom:2px solid #000;
    }



     /** 
      Set the margins of the page to 0, so the footer and the header
      can be of the full height and width !
    **/
  @page {
      margin: 0cm 0cm;
  }

  /** Define now the real margins of every page in the PDF **/
  body {
      margin-top: 2cm;
      margin-left: 2cm;
      margin-right: 2cm;
      margin-bottom: 2cm;
  }

  /** Define the header rules **/
  header {
      position: fixed;
      top: 0cm;
      left: 0cm;
      right: 0cm;
      height: 75px;
      background-image:url('http://crm_lara6.xxx/images/fattura_pdf/header.png');
      background-repeat: no-repeat; 
      background-position: center;
      background-size: contain;
  }

  /** Define the footer rules **/
  footer {
      position: fixed; 
      bottom: 0cm; 
      left: 0cm; 
      right: 0cm;
      height: 2cm;
  }


  </style>
</head>
<body>

  <header></header>
  <main class="main">
    <div class="container">

      <div class="row mt-2">
        <div class="col">

            <div class="header_pdf">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr class="underline">
                    <td width="25%">Tipo documento</td>
                    <td width="13%" align="center">Numero</td>
                    <td width="17%" align="center">Data</td>
                    <td width="45%">Cliente</td>
                </tr>
                <tr style="font-size:4px;" >
                    <td colspan="4" style="border-top:#000 2px solid; line-height: 5px; height:5px;">&nbsp;</td>
                </tr>
                <tr style="">
                    <td valign="top"><strong>{{ $fattura->getTipo() }} </strong></td>
                    <td align="center" valign="top">{{$fattura->getNumero()}}</td>
                    <td align="center" valign="top">{{ $fattura->getDataFattura() }}</td>
                    <td>
                      <b>{{$fattura->getSocietaNome()}}</</b><br> 	
                      {{$fattura->getSocietaIndirizzo()}}<br> 	
                      {{$fattura->getCap()}} - {{$fattura->getLocalita()}} ({{$fattura->getSiglaProv()}})<br>
                      @php
                          $piva = $fattura->getPiva();
                          $cf = $fattura->getCf();
                      @endphp 	
                      @if ($piva != '')
                        P. IVA&nbsp;&nbsp;&nbsp;{{ $piva }}<br>  
                      @endif
                      @if ($cf != '')
                      C.F.&nbsp;&nbsp;&nbsp;{{ $cf }}<br>
                      @endif
                    </td>
                </tr>
              </table>
            </div>
        
        </div>
      </div>

      <div class="row mt-3">
        <div class="col">
          <div class="elenco_servizi">
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <th width="45%" class="underline text-left">Servizio</th>
                    <th class="underline text-right">Qta</th>
                    <th class="underline text-right">Prezzo</th>
                    <th class="underline text-right">% Sconto</th>
                    <th class="underline text-right">Netto</th>
                    <th class="underline text-right">Al.IVA</th>
                    <th class="underline text-right">IVA</th>
                    <th class="underline text-right">Totale</th>
                </tr>
            <tbody>
            @php
                $tot_netto = 0;
                $tot_iva = 0;
                $tot = 0;
            @endphp
            @foreach ($fattura->righe as $riga)
                <tr class="elenco">
                    <td>{{$riga->servizio}}</td>
                    <td class="text-right">{{$riga->qta}}</td>
                    <td class="text-right">{{App\Utility::formatta_cifra($riga->totale_netto)}}</td>
                    <td class="text-right">
                      @if ($riga->perc_sconto == 0)
                        /
                      @else
                      {{$riga->perc_sconto}}%
                      @endif
                    </td>
                    <td class="text-right">{{App\Utility::formatta_cifra($riga->totale_netto_scontato)}}</td>
                    <td class="text-right">{{$riga->al_iva}}</td>
                    <td class="text-right">{{App\Utility::formatta_cifra($riga->iva)}}</td>
                    <td class="text-right">{{App\Utility::formatta_cifra($riga->totale)}}</td>
                </tr>
                @php
                  $tot_netto += $riga->totale_netto_scontato;
                  $tot_iva += $riga->iva;
                @endphp 
            @endforeach
            @php
              $tot = $tot_netto + $tot_iva;
            @endphp
            <tr>
              <th colspan="7" class="text-right underline">&nbsp;</th>
              <th class="text-right underline">Totali</th>
            </tr>
            <tr class="totale">
              <td colspan="7" class="text-right">Totale Netto</td>
              <td class="text-right">{{App\Utility::formatta_cifra($tot_netto, '€')}}</th>
            </tr>
            <tr class="totale">
              <td colspan="7" class="text-right">Totale IVA</td>
              <td class="text-right">{{App\Utility::formatta_cifra($tot_iva, '€')}}</th>
            </tr>
            <tr class="totale">
              <td colspan="8">&nbsp;</td>
            </tr>
            <tr class="totale">
              <td colspan="5" class="text-right">&nbsp;</td>
              <td class="text-right totalone">Totale</td>
              <td colspan="2" class="text-right totalone">{{App\Utility::formatta_cifra($tot, '€')}}</th>
            </tr>
            </tbody>
            </table>
          </div>
        </div>
      </div>

  
    
    
    </div>
  </main>
</body>
</html>