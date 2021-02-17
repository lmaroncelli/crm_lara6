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

    .fa-star:before {
      font-family: DejaVu Sans;
      content: "\2605";
      color:#000;
      font-style: normal;
      font-size: 15px;
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

    ul {
      list-style-type: none;
      margin: 0;
      padding: 0;
    }

    ul li:first-child {
      margin: 0;
      padding: 0; 
    }

    ul.one_row {
      margin: 0;
      padding: 0;
    }

    ul.list {
      display: inline; 
      margin: 0;
      padding: 0;
    }


    ul.list li:first-child {
      margin: 0;
      padding: 0; 
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

    td.header {
            font-weight: bold;
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
                    <td width="70%" valign="top">
                      <div class="card">
                        <div class="card-header">MODULO SERVIZI HOTEL</div>
                        <div class="card-body">
                          <table class="table" width="100%">
                              <tr>
                                <td width="50%" valign="top">
                                  <ul>
                                    <li><span>{{strtoupper($foglio->nome_hotel)}} {!! $foglio->cliente->categoria->namePdf !!}</span></li>
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
                    <td width="30%" align="right">
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
            @if ($foglio->altra_apertura != '')
              <div>  
                <ul class="list">
                  <li><i class="fa-check"></i> {{$foglio->altra_apertura}}</li>
                </ul>
              </div>
            @endif
          </div>
        </div>
        {{-- row --}}
        <div class="row mt-2">
          <div class="col">
            @if ($foglio->numeri_anno_prec)
              <div>
                <ul class="one_row">
                  <li><span>STESSI N. LOCALI/SUITE/APP.TI E POSTI LETTO ANNO PRECEDENTE</span></li>
                </ul>
              </div>
            @else
              <div>
                <table width="100%" cellpadding="0" cellspacing="0">
                  <tr>
                    <td width="25%" class="header">NUMERO CAMERE:</td>
                    <td width="25%" class="header">NUMERO APPARTAMENTI:</td>
                    <td width="25%" class="header">NUMERO SUITE:</td>
                    <td width="25%" class="header">NUMERO LETTI:</td>			
                  </tr>
                  <tr>
                    <td width="25%">{{$foglio->n_camere > 0 ? $foglio->n_camere : '......'}}</td>
                    <td width="25%">{{$foglio->n_app > 0 ? $foglio->n_app : '......'}}</td>
                    <td width="25%">{{$foglio->n_suite > 0 ? $foglio->n_suite : '......'}}</td>
                    <td width="25%">{{$foglio->n_letti > 0 ? $foglio->n_letti : '......'}}</td>
                  </tr>
                </table>
              </div>
            @endif
          </div>
        </div>

        <div class="row mt-2">
          <div class="col">
            <div>
              <ul class="one_row">
                <li><span>ORARIO APERTURA RECEPTION:</span></li>
              </ul>
            </div>
            @if ($foglio->h_24)
              <ul class="one_row">
                <li><i class="fa-check"></i> H24</li>
              </ul>
            @else
              <ul class="list">
                <li>dalle&nbsp;{{$foglio->rec_dalle_ore}}:{{$foglio->rec_dalle_minuti}}&nbsp;&nbsp;&nbsp;alle&nbsp;{{$foglio->rec_alle_ore}}:{{$foglio->rec_alle_minuti}}</li>
              </ul>
            @endif
          </div>
        </div>

        <div class="row mt-2">
          <div class="col">
            <div>
              <table width="100%" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="50%" class="header">ORARIO DI CHECK IN:</td>
                  <td width="50%" class="header">ORARIO DI CHECK OUT:</td>
                </tr>
                <tr>
                  <td width="50%">dalle ore:&nbsp;{{$foglio->checkin}}</td>
                  <td width="50%">fino alle ore:&nbsp;{{$foglio->checkout}}</td>
                </tr>
              </table>
            </div>
          </div>
        </div>

        <div class="row mt-2">
          <div class="col">
            <div>
              <ul class="one_row">
                <li><span>ORARIO DEI PASTI:</span></li>
              </ul>
            </div>
            @if ($foglio->pasti_anno_prec)
              <div>
                <ul class="list">
                  <li><span>STESSI ORARI PASTI ANNO PRECEDENTE</span></li>
                </ul>
              </div>
            @else
              <div>
                <table width="100%" cellpadding="0" cellspacing="0">
                  <tr width="100%">
                    <td width="10%">Colazione:&nbsp;&nbsp;</td>
                    <td>dalle&nbsp;{{ $foglio->colazione_dalle_ore }}:{{ $foglio->colazione_dalle_minuti }}&nbsp;&nbsp;alle&nbsp;{{ $foglio->colazione_alle_ore }}:{{ $foglio->colazione_alle_minuti }}</td>
                    <td width="8%">Pranzo:&nbsp;&nbsp;</td>
                    <td>dalle&nbsp;{{ $foglio->pranzo_dalle_ore }}:{{ $foglio->pranzo_dalle_minuti }}&nbsp;&nbsp;alle&nbsp;{{ $foglio->pranzo_alle_ore }}:{{ $foglio->pranzo_alle_minuti }}</td>
                    <td width="5%">Cena:&nbsp;&nbsp;</td>
                    <td>dalle&nbsp;{{ $foglio->cena_dalle_ore }}:{{ $foglio->cena_dalle_minuti }}&nbsp;&nbsp;alle&nbsp;{{ $foglio->cena_alle_ore }}:{{ $foglio->cena_alle_minuti }}</td>	
                  </tr>
                </table>
              </div>
            @endif
          </div>
        </div>

        <table class="p_break_after"><tr><td>&nbsp;</td></tr></table>

        <div class="row mt-2">
          <div class="col">
            <div>
              <ul class="one_row">
                <li><span>TRATTAMENTI PRINCIPALI:</span></li>
              </ul>
            </div>
            @foreach (Utility::getFsTrattamentiENote() as $key => $val)
                @if ($foglio->$key && strpos($key,'note_') === false)
                  <ul class="one_row">  
                    <li>{{ $val }}</li>
                @elseif($foglio->$key != '')
                    <li>{{ $foglio->$key }}</li>
                  </ul>
                @endif
            @endforeach
          </div>
        </div>

        <div class="row mt-2">
          <div class="col">
            <div>
              <ul class="one_row">
                <li><span>SI CHIEDE CAPARRA AL MOMENTO DELLA PRENOTAZIONE?</span></li>
              </ul>
            </div>
            <ul class="one_row">
              <li>{{$foglio->caparra}}</li>
              @if ($foglio->altra_caparra != '')     
                &nbsp;&nbsp;&nbsp;<li>{{$foglio->altra_caparra}}</li>
              @endif
            </ul>
          </div>
        </div>
        {{-- row --}}
        <div class="row mt-2">
          <div class="col">
            <div>
              <ul class="one_row">
                <li><span>PAGAMENTI ACCETTATI</span></li>
              </ul>
            </div>
            <div>
              <ul class="list">
                @foreach (Utility::getFsPagamenti() as $key => $val)
                  <li>{!!$foglio->$key ? '<i class="fa-check"></i>' : '<i class="fa-check-empty"></i>'!!} {{$val}}</li>
                @endforeach
              </ul>
            </div>
            @if ($foglio->note_pagamenti != '')
              <div>  
                <ul class="list">
                  <li>{{$foglio->note_pagamenti}}</li>
                </ul>
              </div>
            @endif
          </div>
        </div>

        {{-- row --}}
        <div class="row mt-2">
          <div class="col">
            <div>
              <ul class="one_row">
                <li><span>LINGUE PARLATE</span></li>
              </ul>
            </div>
            <div>
              <ul class="list">
                @foreach (Utility::getFsLingue() as $key => $val)
                  <li>{!!$foglio->$key ? '<i class="fa-check"></i>' : '<i class="fa-check-empty"></i>'!!} {{$val}}</li>
                @endforeach
              </ul>
            </div>
            @if ($foglio->altra_lingua != '')
              <div>  
                <ul class="list">
                  <li>{{$foglio->altra_lingua}}</li>
                </ul>
              </div>
            @endif
          </div>
        </div>

        {{-- row --}}
        <div class="row mt-2">
          <div class="col">
            <div>
              <ul class="one_row">
                <li><span>9 PUNTI DI FORZA/SERVIZI</span></li>
              </ul>
            </div>
            @if ($foglio->pti_anno_prec)
              <div>
                <ul class="list">
                  <li><span>Stessi punti di forza anno precedente</span></li>
                </ul>
              </div>
            @else
              <div>
                <table width="100%" cellpadding="0" cellspacing="0">
                  @for ($i = 1; $i < 10; $i++)
                    @php $attr = 'pf_'.$i; @endphp                      
                    @if ($i % 3 == 1)
                      <tr width="100%">
                      @php $col = 0; @endphp                      
                    @endif
                    <td  width="33%"><i class="fa-check"></i> {{ $foglio->$attr }}</td>
                      @php $col++; @endphp
                      @if ($col == 3)
                      </tr>
                      @endif                      
                  @endfor 
                </table>
              </div>
            @endif
            @if ($foglio->note_pf != '')
              <div> 
                <ul class="list">
                  <li>{{$foglio->note_pf}}</li>
                </ul>
              </div>
            @endif
          </div>
        </div>

        <table class="p_break_after"><tr><td>&nbsp;</td></tr></table>


        @if ($foglio->piscina)
        
          <div class="row mt-2">
            <div class="col">
              <div>
                <ul class="one_row">
                  <li><span>SEZIONE PISCINA</span></li>
                </ul>
              </div>
            </div>
          </div>

          <div class="row mt-2">
            <div class="col">
              <div>
                <ul class="one_row">
                  <li><span>INFO</span></li>
                </ul>
                <ul>
                  <li>Superficie: {{ $foglio->infoPiscina->sup }}  mq.</li>
                  @if ($foglio->infoPiscina->h)
                    <li>Altezza unica: {{ $foglio->infoPiscina->h }}  cm.</li>
                  @else
                    <li>Altezza min: {{ $foglio->infoPiscina->h_min }}  cm.</li>
                    <li>Altezza mx: {{ $foglio->infoPiscina->h_max }}  cm.</li>
                  @endif
                  @if ($foglio->infoPiscina->aperto_annuale)
                    <li>Apertura piscina: annuale</li>
                  @else
                    <li>Apertura piscina: da {{Utility::getFsMesi()[$foglio->infoPiscina->aperto_dal]}} a {{Utility::getFsMesi()[$foglio->infoPiscina->aperto_al]}}</li>
                  @endif
                  @if ($foglio->infoPiscina->posizione != '')
                    <li>Posizione piscina: {{$foglio->infoPiscina->posizione}}</li>
                  @endif
                </ul>
              </div>

            </div>
          </div>
          {{-- row --}}
          <div class="row mt-2">
            <div class="col">
              <div>
                <ul class="one_row">
                  <li><span>CARATTERISTICHE</span></li>
                </ul>
              </div>
              <div>
                <table width="100%" cellpadding="0" cellspacing="0">
                @php
                  $row_carr = array_chunk(Utility::getFsCaratteristichePiscina(), 4, true);
                @endphp
                @foreach ($row_carr as $n_row => $caratteristichePiscina_in_row)
                <tr>
                  @foreach ($caratteristichePiscina_in_row as $carr => $carr_view)
                    <td>{!!$foglio->infoPiscina->$carr ? '<i class="fa-check"></i>' : '<i class="fa-check-empty"></i>'!!} {{$carr_view}}</td>
                  @endforeach
                </tr>
                  @endforeach
                </table>
              </div>
              <div>
                <ul>
                  @if (!is_null($foglio->infoPiscina->peculiarita_piscina) && $foglio->infoPiscina->peculiarita_piscina != '')
                    <li>{{$foglio->infoPiscina->peculiarita_piscina}}</li>
                  @endif

                  @if ($foglio->infoPiscina->lettini_dispo > 0)
                    <li>N. lettini prendisole: {{$foglio->infoPiscina->lettini_dispo}}</li>
                  @endif

                  @if ($foglio->infoPiscina->espo_sole > 0 || $foglio->infoPiscina->espo_sole_tutto_giorno)
                    <li>N. ore esposta al sole: {{$foglio->infoPiscina->espo_sole > 0 ? $foglio->infoPiscina->espo_sole : 'tutto il giorno'}}</li>
                  @endif

                </ul>
              </div>
            </div>
          </div>
            
        @endif
        {{-- Piscina --}}

        <table class="p_break_after"><tr><td>&nbsp;</td></tr></table>

        @if ($foglio->benessere)

          <div class="row mt-2">
            <div class="col">
              <div>
                <ul class="one_row">
                  <li><span>SEZIONE CENTRO BENESSERE</span></li>
                </ul>
              </div>
            </div>
          </div>

          <div class="row mt-2">
            <div class="col">
              <div>
                <ul class="one_row">
                  <li><span>INFO</span></li>
                </ul>
                <ul>
                  <li>Superficie: {{ $foglio->centroBenessere->sup_b }}  mq.</li>
                  <li>Area fitness: {{ $foglio->centroBenessere->area_fitness }} 
                    {!! $foglio->centroBenessere->area_fitness == 'si' ? '&nbsp;&nbsp;&nbsp;'.$foglio->centroBenessere->sup_fitness . ' mq' : ''!!}
                  </li>
                  @if ($foglio->centroBenessere->aperto_annuale_b)
                    <li>Apertura centro benessere: annuale</li>
                  @else
                    <li>Apertura centro benessere: da {{Utility::getFsMesi()[$foglio->centroBenessere->aperto_dal_b]}} a {{Utility::getFsMesi()[$foglio->infoPiscina->aperto_al_b]}}</li>
                  @endif
                  <li>A pagamento: {{ $foglio->centroBenessere->a_pagamento }}</li>
                  <li>Posizione: @if ($foglio->centroBenessere->in_hotel) in hotel @else a {{$foglio->centroBenessere->distanza_hotel}} metri dall'hotel @endif
                  </li>
                  <li>Età minima per accedere: @if ($foglio->centroBenessere->eta_minima == 0) nessuna @else {{$foglio->centroBenessere->eta_minima}} anni @endif
                  </li>
                </ul>
              </div>
            </div>
          </div>

          {{-- row --}}
          <div class="row mt-2">
            <div class="col">
              <div>
                <ul class="one_row">
                  <li><span>CARATTERISTICHE</span></li>
                </ul>
              </div>
              <div>
                <table width="100%" cellpadding="0" cellspacing="0">
                  @php
                    $row_carr = array_chunk(Utility::getFsCaratteristicheCentroBenessere(), 4, true);
                  @endphp
                  @foreach ($row_carr as $n_row => $caratteristicheCentroBenessere_in_row)
                  <tr>
                    @foreach ($caratteristicheCentroBenessere_in_row as $carr => $carr_view)
                      <td>{!!$foglio->centroBenessere->$carr ? '<i class="fa-check"></i>' : '<i class="fa-check-empty"></i>'!!} {{$carr_view}}</td>
                    @endforeach
                  </tr>
                  @endforeach
                </table>
              </div>
              <div>
                <ul>
                  @if (!is_null($foglio->centroBenessere->peculiarita) && $foglio->centroBenessere->peculiarita != '')
                    <li>{{$foglio->centroBenessere->peculiarita}}</li>
                  @endif
                  <li>Obbligo di prenotazione: {{ $foglio->centroBenessere->obbligo_prenotazione }}</li>
                  <li>Uso in esclusiva: {{ $foglio->centroBenessere->uso_esclusivo }}</li>
                </ul>
              </div>
            </div>
          </div>

        @endif
        {{-- centro benessere --}}
        

        <table class="p_break_after"><tr><td>&nbsp;</td></tr></table>
          @foreach ($gruppiServizi as $gruppo)
            <div class="row mt-2">
              <div class="col">
                <div>
                  <ul class="one_row">
                    <li><span>{{$gruppo->nome}}</span></li>
                  </ul>
                  @foreach ($gruppo->elenco_servizi as $key => $servizio)
                    
                    @if (array_key_exists($servizio->id, $ids_servizi_associati))
                      <ul class="one_row">
                        <li><i class="fa-check"></i> {{$servizio->nome}}</li>
                        <li>{{$ids_servizi_associati[$servizio->id]}}</li>
                      </ul>
                    @else
                      <ul>
                        <li><i class="fa-check-empty"></i> {{$servizio->nome}}</li>
                      </ul>
                    @endif
                      
                  @endforeach
                </div>
              </div>
            </div>  
            @endforeach


          
      </div>
      {{-- container --}}
    </main>

</body>
</html>