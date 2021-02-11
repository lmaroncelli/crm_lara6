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
      font-size: 13px;
    	background-color: #efefef;
      /*border: 1px solid #333;*/
      font-weight:bold;
      margin-bottom: 0px;
      border-bottom: 1px solid #333;
      text-transform: uppercase;
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
      padding: 2px 10px 1px 10px;
    }


    div.elenco_servizi thead th
     {
      padding:5px;
      font-size: 13px;
    	background-color: #efefef;
      font-weight:bold;
      margin-bottom: 0px;
      border: 1px solid #fff;
    }

  
    div.elenco_servizi tr td{
      height:30px;
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

    div.elenco_servizi td.text-right {
      text-align: right;
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

    table.p_break_after {
        page-break-after: always;
    }

    /* PARTE STATICA */
    ul.elenco_condizioni {
      font-size: 10.2px;
      list-style-type: none;
      margin: 0;
      padding:0;
      line-height: 10px;
      text-align: justify;
      page-break-inside: auto;
    }

    ul.elenco_condizioni.altre li{
        margin: 10px 0;
    }

    ul.elenco_condizioni li {
        text-align: justify;
        page-break-inside: auto;
    }

    ul.elenco_condizioni li.title {
        margin: 0 0 10px 0;
    }

    ul.elenco_condizioni li.subtitle  {
      margin-top: 6px;
    }

    ul.elenco_condizioni li.subtitle b {
        font-weight: bold;
        text-transform: uppercase;
    }

    table.firme_ultima_pagina {
        margin-top: 5px;
    }

    table.firme_ultima_pagina td {
        height: 10px;
    }

    table.firme_ultima_pagina tr.firme td {
        height:50px;
    }

    .bi {
        font-weight: bold!important;
        font-variant: italic!important;
    }


    div#firma {
        padding: 0;
        margin: 0;
        text-align: right;
        position: fixed;
        right: 300px;
        bottom: 0px;
        font-size: 10px;
        /*border: 1px solid green;*/
    }

    table.respomsabile_trattamento {
            margin-top:35px;
        }

        
    table.respomsabile_trattamento ul {
        font-size: 10.2px;
        text-align: justify;
        line-height: 10px;
        list-style: none;
        text-indent: 0px;
        margin:0;
        padding:0;
    }

    table.respomsabile_trattamento ul li {
        text-align: justify;
        margin:0;
        padding:0;
    }

    table.respomsabile_trattamento ul li:before {
        content: "-";
    }
    

    table.respomsabile_trattamento ol {
        text-align: justify;
        list-style-type: upper-alpha;
        text-indent: 0px;
        margin:0;
        padding:0;
        padding-left:18px;
    }

    table.respomsabile_trattamento ol li {
        text-align: justify;
        margin:0;
        padding:0;
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

        {{-- RIGA HEADER con LOGO a DX --}}
        <div class="row mt-2">
          <div class="col">

              <div class="header_pdf">
                <table width="100%" cellpadding="0" cellspacing="0">
                  <tr>
                    <td width="38%" valign="top">
                      <div class="card">
                        <div class="card-header">MODULO SERVIZI HOTEL</div>
                        <div class="card-body">
                          <ul>
                            <li><span>Nome Hotel</span> {{strtoupper($foglio->nome_hotel)}}</li>
                            <li><span>Anno Stagione</span> {{ strtoupper($foglio->stagione) }}</li>
                            <li><span>Categoria</span> {{ strtoupper($foglio->cliente->categoria->name) }}</li>
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
        {{-- row --}}


        {{--  RIGA SUBHEADER CLIENTE - DATI FATTUIRAZIONE --}}
        <div class="row mt-3">
          <div class="col">

              <div class="sub_header">
                <table width="100%" cellpadding="0" cellspacing="0">
                  <tr>
                    <td width="48%" valign="top">
                      <div class="card">
                        <div class="card-header">
                          Cliente
                        </div>
                        <div class="card-body">
                          <div class="dati_cliente">
                          {!!nl2br($contratto->dati_cliente)!!}
                          @if ($contratto->dati_referente != '')
                          <br/>
                          <br/>
                          {!!nl2br($contratto->dati_referente)!!}
                          @endif
                          </div>
                        </div>
                      </div>
                    </td>
                    <td width="4%" valign="top">
                      &nbsp;
                    </td>
                    <td width="48%" valign="top">
                      <div class="card">
                        <div class="card-header">
                          Dati fatturazione
                        </div>
                        <div class="card-body">
                          <div class="dati_cliente">
                          {!!nl2br($contratto->dati_fatturazione)!!}
                          </div>
                        </div>
                      </div>
                    </td>
                  </tr>
                </table>
              </div>
              {{-- sub_header --}}
          
          </div>
        </div>
        {{-- row --}}
          
      </div>
      {{-- container --}}
    </main>

</body>
</html>