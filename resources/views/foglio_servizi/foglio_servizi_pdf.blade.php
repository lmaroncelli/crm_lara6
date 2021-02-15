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


    .fa-check:before {
            font-family: DejaVu Sans;
            font-style: normal;
            content: "\2611";
            color:#000;
            font-size: 18px;
    }

     .fa-check-empty:before {
            font-family: DejaVu Sans;
            content: "\2610";
            color:#000;
            font-style: normal;
            font-size: 18px;
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

    div.card-body ul {
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

    table.p_break_after {
        page-break-after: always;
    }

    ul.list {
      display: inline; 
      padding: 0 20px; 
    }

    ul.one_row li:first-child {
      font-weight: bold;
      margin-right: 50px;
      padding: 0; 
    }

    ul.one_row li,
    ul.list li{
      display: inline; 
      padding: 0 20px; 
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
                    <td width="60%" valign="top">
                      <div class="card">
                        <div class="card-header">MODULO SERVIZI HOTEL</div>
                        <div class="card-body">
                          <table class="table">
                              <tr>
                                <td width="50%" valign="top">
                                  <ul>
                                    <li><span>Hotel</span> {{strtoupper($foglio->nome_hotel)}} {!! strtoupper($foglio->cliente->categoria->name) !!}</li>
                                    <li><span>Anno Stagione</span> {{ strtoupper($foglio->stagione) }}</li>
                                    <li><span>WhatsApp</span> {{ strtoupper($foglio->whatsapp) }}</li>
                                    <li><span>Apertura</span> {{ strtoupper($foglio->getApertura()) }}</li>
                                  </ul>
                                </td>
                                <td width="50%" valign="top">
                                  <ul>
                                    <li><span>Localita</span> {{strtoupper($foglio->cliente->localita->nome)}}</li>
                                    <li><span>Tipologia</span> {{ strtoupper($foglio->getTipologia()) }}</li>
                                    <li><span>SMS</span> {{ strtoupper($foglio->sms) }}</li>
                                    <li><span>Prezzi Min/Max</span> {{ $foglio->prezzo_min .' / '. $foglio->prezzo_max }}</li>
                                  </ul>
                                </td>
                              </tr>
                          </table>
                        </div>
                      </div>
                    </td>
                    <td width="40%" align="right">
                      <img src="{{ asset('images/logo_pdf.png') }}">
                    </td>
                  </tr>
                </table>
              </div>
          
          </div>
        </div>
        {{-- row --}}

        <div class="row mt-2">
          <div class="col">
            <div>
              <ul class="one_row">
                <li><span>Organizzazione eventi</span></li>
                <li>{!!$foglio->organizzazione_comunioni ? '<i class="fa-check"></i>' : '<i class="fa-check-empty"></i>'!!} comunioni</li>
                <li>{!!$foglio->organizzazione_cresime ? '<i class="fa-check"></i>' : '<i class="fa-check-empty"></i>'!!} cresime</li>
                <li>{!!$foglio->organizzazione_matrimoni ? '<i class="fa-check"></i>' : '<i class="fa-check-empty"></i>'!!} matrimoni</li>
              </ul>
            </div>
          </div>
        </div>
        <div class="row mt-2">
          <div class="col">
            <div>
              <ul class="one_row">
                <li><span>Date apertura hotel</span></li>
                <li>{{$foglio->dal->format('d/m/Y')}}</li>
                <li>{{$foglio->al->format('d/m/Y')}}</li>
              </ul>
            </div>
          </div>
        </div>
        {{-- row --}}
        <div class="row mt-2">
          <div class="col">
            <div>
              <ul class="one_row">
                <li><span>(In caso siate aperti in periodi dell’anno al di fuori della stagione estiva indicate quali):</span></li>
              </ul>
            </div>
            <div>
              <ul class="list">
                <li>{!!$foglio->fiere ? '<i class="fa-check"></i>' : '<i class="fa-check-empty"></i>'!!} fiere</li>
                <li>{!!$foglio->pasqua ? '<i class="fa-check"></i>' : '<i class="fa-check-empty"></i>'!!} pasqua</li>
                <li>{!!$foglio->capodanno ? '<i class="fa-check"></i>' : '<i class="fa-check-empty"></i>'!!} capodanno</li>
                <li>{!!$foglio->aprile_25 ? '<i class="fa-check"></i>' : '<i class="fa-check-empty"></i>'!!} 25 aprile</li>
                <li>{!!$foglio->maggio_1 ? '<i class="fa-check"></i>' : '<i class="fa-check-empty"></i>'!!} 1° maggio</li>
              </ul>
            </div>
          </div>
        </div>

          
      </div>
      {{-- container --}}
    </main>

</body>
</html>