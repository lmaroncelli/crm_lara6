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

  
    div.elenco_servizi tr td{
      height:50px;
    }
    
    div.elenco_servizi tr.totali td
     {
      padding:3px;
      height:20px;  
    	background-color: #efefef;
      font-weight:bold;
      margin-bottom: 0px;
      border: 1px solid #fff;
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

    tr.underline {
      border-bottom:2px solid #000;
    }

  </style>
</head>
<body>
  <script type="text/php">	 
    $font = $fontMetrics->get_font("verdana");
    // If verdana isn't available, we'll use sans-serif.
    if (!isset($font)) { $fontMetrics->get_font("sans-serif"); }
    $size = 9;
    $color = array(0,0,0);
    $text_height = $fontMetrics->get_font_height($font, $size);
    
    $w = $pdf->get_width();
    $h = $pdf->get_height();

    // HEADER
    $header = $pdf->open_object();  
    
    $pdf->close_object();
    $pdf->add_object($header, "all");

    $text = "- {PAGE_NUM} -";  

    // Center the text
    $width = $fontMetrics->get_text_width("Pagina 1/2", $font, $size);
    $pdf->page_text($w/2, 10, $text, $font, $size, $color);
  </script>

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
                <tr class="underline">
                    <th width="35%" class="text-left">Servizio</th>
                    <th class="text-right">Qta</th>
                    <th class="text-right">Prezzo</th>
                    <th class="text-right">% Sconto</th>
                    <th class="text-right">Netto</th>
                    <th class="text-right">Al.IVA</th>
                    <th class="text-right">IVA</th>
                    <th class="text-right">Totale</th>
                </tr>
            <tbody>
            @php
                $tot_netto = 0;
                $tot_iva = 0;
                $tot = 0;
            @endphp
            @foreach ($fattura->righe as $riga)
                <tr>
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
            <tr class="underline">
              <th colspan="7" class="text-right">&nbsp;</th>
              <th class="text-right">Totali</th>
            </tr>
            <tr>
              <td colspan="7" class="text-right">Totale Netto</td>
              <td class="text-right">{{App\Utility::formatta_cifra($tot_netto)}}</th>
            </tr>
            <tr>
              <td colspan="7" class="text-right">Totale IVA</td>
              <td class="text-right">{{App\Utility::formatta_cifra($tot_iva)}}</th>
            </tr>
            <tr>
              <td colspan="7" class="text-right">Totale</td>
              <td class="text-right">{{App\Utility::formatta_cifra($tot)}}</th>
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