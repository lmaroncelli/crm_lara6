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
      height: 72px;
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
      height: 65px;
      background-image:url('http://crm_lara6.xxx/images/fattura_pdf/footer.png');
      background-repeat: no-repeat; 
      background-position: center;
      background-size: contain;
  }


  #bottom_page {
      width:670px;
      margin: 0;
      padding: 0;
      position: fixed;
      border: 0px solid black;
      bottom:385px;
      left:70px;
  }


  #pagamento {
      width:500px;
      margin: 0;
      padding: 0;
      height: 170px;
      margin-bottom: 10px;
      border: 0px solid blue;

  }

  table.coord {
    border-collapse: collapse;
  }

  table.coord>tbody { 
      border: 1px solid black;
      padding:3px;
  }

  table.coord>tbody>tr>th { 
      border-bottom: 1px solid black;
  }

  table.coord>tbody>tr>td { 
      border-right: 1px solid black;
      padding: 3px;
  }

  #coord_bancarie {
      width:670px;
      margin: 0;
      padding: 0;
      margin-top: 10px;
      border: 0px solid red;
  }
  
  table.p_break_after {
      page-break-after: always;
  }

  </style>
</head>
<body>
  <script type="text/php">
    if ( isset($pdf) ) {

      $font = $fontMetrics->get_font("verdana");
      // If verdana isn't available, we'll use sans-serif.
      if (!isset($font)) { $fontMetrics->get_font("sans-serif"); }
      $size = 9;
      $color = array(0,0,0);
      $text_height = $fontMetrics->get_font_height($font, $size);
    
      $w = $pdf->get_width();
      $h = $pdf->get_height();

      $y = $h;

      $y += $text_height;
    
      <?php if ( $fattura->tipo_id == 'PF' ) { ?>
      // Mark the document as a duplicate (avvicino la scritta ai box in fondo altrimenti si sovrappone al totale se ci sono molte voci)
      $pdf->page_text($w/5, $h/2+160, "      Il presente documento non costituisce fattura valida ai fini del Dpr 633 26.10.72 e succ. mod.", $fontMetrics->get_font("verdana", "normal"),12, array(0.4196, 0.4196, 0.4196), 0, 0, -52);
      $pdf->page_text($w/5, $h/2+175, "La fattura definitiva verra' emessa all'atto del pagamento del corrispettivo (Art. 6 3 c. Dpr 633/72)", $fontMetrics->get_font("verdana", "normal"),12, array(0.4196, 0.4196, 0.4196), 0, 0, -52);
      <?php } ?>

      $text = "Pagina {PAGE_NUM}/{PAGE_COUNT}";  

      $img_w = 497; 
      $img_h = 32; 

      // Center the text
      $width = $fontMetrics->get_text_width("Pagina 1/2", $font, $size);
      $pdf->page_text($w - (2*$width+23), $y - ($img_h+40), $text, $font, $size, $color);

    }
</script>



  @php
    $array_elenco_righe_fattura = $fattura->righe->chunk(6);
    $tot_netto = 0;
    $tot_iva = 0;
    $tot = 0;
    $n_sottotab = count($array_elenco_righe_fattura);
    $num_sottotab = 0;
  @endphp

<header></header>
<footer></footer>
  <main class="main">
    <div class="container">
      
      @foreach ($array_elenco_righe_fattura as $elenco_righe)
        @php
          $num_sottotab += 1;
        @endphp

        {{-- Header --}}
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

        {{-- Elenco servizi --}}
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
                
                @foreach ($elenco_righe as $riga)
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

                @if ($num_sottotab == $n_sottotab)
                  <tr>
                    <th colspan="7" class="text-right underline">&nbsp;</th>
                    <th class="text-right underline">Totali</th>
                  </tr>
                  <tr class="totale">
                    <td colspan="6" class="text-right">Totale Netto</td>
                    <td colspan="2" class="text-right">{{App\Utility::formatta_cifra($tot_netto, '€')}}</th>
                  </tr>
                  <tr class="totale">
                    <td colspan="6" class="text-right">Totale IVA</td>
                    <td colspan="2" class="text-right">{{App\Utility::formatta_cifra($tot_iva, '€')}}</th>
                  </tr>
                  <tr class="totale">
                    <td colspan="8">&nbsp;</td>
                  </tr>
                  <tr class="totale">
                    <td colspan="5" class="text-right">&nbsp;</td>
                    <td class="text-right totalone">Totale</td>
                    <td colspan="2" class="text-right totalone">{{App\Utility::formatta_cifra($tot, '€')}}</th>
                  </tr>
                @else
                  <tr>
                    <th colspan="6" class="text-right underline">&nbsp;</th>
                    <th colspan="2" class="text-right underline">Segue >>></th>
                  </tr>
                @endif
                
                </tbody>
                </table>
              </div>
            </div>
          </div>

        {{-- Pagamento/coordinate/mote --}}
        <div id="bottom_page">
            <div id="pagamento">
              @if ($fattura->tipo_id != 'NC')
              <table width="283px" border="0" class="coord">
                <tbody>
                  <tr style="font-size:11px;">
                      <td colspan="2" align="center"><strong>Pagamento:</strong></td>
                  </tr>
                  <tr style="font-size:11px; text-transform:uppercase;">
                      <td colspan="2" align="center"><strong> {{$fattura->pagamento->nome}} </strong></td>
                  </tr>
                  <tr>
                      <td style="font-size:11px;" colspan="2"><strong>Scadenze:</strong></td>
                  </tr>
                  <tr style="font-size:11px;">
                      <td style="border-right:0px;">Data</td>
                      <td class="text-right">Importo</td>
                  </tr>

                      @foreach ($fattura->scadenze as $s)
                        <tr style="font-size:11px;">									
                          <td style="border-right:0px;">{{$s->data_scadenza->format('d/m/Y')}}</td>
                          <td class="text-right">{{ App\Utility::formatta_cifra($s->importo,'€')}}</td>
                        </tr>							 
                      @endforeach
                  </tbody>
                </table>
                @endif
            </div>
            
            <div id="coord_bancarie">
              @if ($fattura->tipo_id != 'NC')
              <table width="280px" border="0" align="left" class="coord" >
                  <tbody>
                      <tr>
                          <td colspan="3" style="font-size:11px;"><strong>Coordinate bancarie Info Alberghi Srl</strong></td>
                      </tr>
                      <tr>
                          <td colspan="3"></td>
                      </tr>
                      <tr style="font-size:11px;">
                          <td colspan="3">{{App\Utility::getBancaIa()['nome']}}<br> 
                          C/C: {{App\Utility::getBancaIa()['cc']}}<br>intestato a: {{App\Utility::getBancaIa()['intestatario']}}<br> 
                          ABI: {{App\Utility::getBancaIa()['abi']}} - CAB: {{App\Utility::getBancaIa()['cab']}} - CIN: {{App\Utility::getBancaIa()['cin']}}<br> 
                          IBAN: {{App\Utility::getBancaIa()['iban']}}<br></td>
                      </tr>
              </table>
              @endif

              @if ($fattura->note != '')
                <div style=" margin-right:20px;">
                    <table width="200" border="0" align="right" class="coord space">
                      <tbody style="min-height:200px;" >
                        <tr style="font-size:11px;">
                          <td valign="top"><strong>Note:</strong></td>
                        </tr>
                        <tr style="font-size:11px;">
                          <td valign="top" >{{$fattura->note}}</td>
                        </tr>
                      </tbody>
                    </table>
                </div>
              @endif
          </div>
            
        </div>
        
        @if ($num_sottotab < $n_sottotab)
        <table class="p_break_after"><tr><td>&nbsp;</td></tr></table>
        @endif

      @endforeach
    </div>
  </main>
</body>
</html>