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


  @php
      $num_sottotab = 0;
  @endphp
  @foreach ($chunk_servizi as $elenco_servizi)
    @php
      $num_sottotab += 1;
    @endphp
  
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
          
          </div>
        </div>
    
        {{-- ELENCO SERVIZI CON TOTALI SOLO SE ULTIMO CHUINK --}}
        <div class="row mt-3">
          <div class="col">
            <div class="elenco_servizi">
              <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <thead>
                  <tr>
                    <th scope="col">SERVIZI DIGITALI INFOALBERGHI.COM</th>
                    <th scope="col">Dal</th>
                    <th scope="col">Al</th>
                    <th scope="col">Q.tà</th>
                    <th scope="col" class="text-right">IMPORTO (€)</th>
                  </tr>
                </thead>
                @if ($n_sottotab)
                  <tbody>
                    @foreach ($elenco_servizi as $servizio)
                      @if ($servizio->sconto)
                        <tr class="sconto">
                          <td colspan="4" nowrap>
                            {{$servizio->nome}}  
                          </td>
                          <td class="text-right"> - {{Utility::formatta_cifra($servizio->importo)}}</td>
                        </tr>
                      @else
                        <tr>
                          @if ($servizio->nome == 'ALTRO')
                            <td>{!!$servizio->altro_servizio!!}</td>                  
                          @else
                            <td>{{$servizio->nome}} - {{$servizio->localita}}@if (!is_null($servizio->pagina)) - {{$servizio->pagina}} @endif</td>
                          @endif
                          <td>{{$servizio->dal}}</td>
                          <td>{{$servizio->al}}</td>
                          <td class="text-right">{{$servizio->qta}}</td>
                          <td class="text-right">{{Utility::formatta_cifra($servizio->importo)}}</td>
                        </tr>
                      @endif
                    @endforeach

                    @if ($n_sottotab == $num_sottotab)                        
                      {{-- riga totali --}}
                      <tr class="totali">
                        <td colspan="3" class="text-right font-weight-bold">TOTALE</td>
                        <td class="text-right">{{$totali['tot_qta']}}</td>
                        <td class="text-right">{{Utility::formatta_cifra($totali['tot_importo'])}}</td>
                      <tr class="totali">
                        <td colspan="3" class="text-right font-weight-bold">IVA</td>
                        <td class="text-right">{{Utility::getIva()}}%</td>
                        <td class="text-right">{{Utility::formatta_cifra($totali['tot_iva'])}}</td>
                      <tr class="totali">
                        <td colspan="3" class="text-right font-weight-bold">TOTALE FATTURA</td>
                        <td></td>
                        <td class="font-weight-bold text-right">{{Utility::formatta_cifra($totali['tot_importo_con_iva'])}}</td>
                      </tr>
                      {{-- / riga totali --}}
                    @endif

                  </tbody>
                @endif
              </table>
            </div>
          </div> 
        </div>
        
        
        {{-- SUBFOOTER E FOOTER --}}
        <div class="subfooter">
          <table width="100%" cellpadding="5" cellspacing="0">
            <tr class="condizioni_pagamento">
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

        @if ($num_sottotab <= $n_sottotab)
            <!-- CAMPO FIRMA POSIZIONATA IN MODO ASSOLUTO -->
            <div id="firma">
              Firma per accettazione ({{$num_sottotab}} di {{$n_sottotab}})
          </div>

          <table class="p_break_after"><tr><td>&nbsp;</td></tr></table>
        @endif


        @if ($num_sottotab == $n_sottotab)
            
        {{-- parte statica contratto--}}
        
        {{-- Pagina 1 statica --}}
        <div>
          <ul class="elenco_condizioni">
            <li class="title"><b>CONDIZIONI GENERALI</b></li>
            <li class="subtitle"><b>1. DEFINIZIONE DELLE PARTI</b></li>
            
            <li>1.1 Il presente contratto viene stipulato tra <span class="bi">INFO ALBERGHI S.R.L.</span>, con sede in Rimini, Via Gambalunga, 81/A - di seguito <span class="bi">"INFO ALBERGHI"</span> - ed il sottoscrittore del contratto o modulo d'ordine, di seguito denominato <span class="bi">"CLIENTE"</span>.</li>
            
            <li class="subtitle"><b>2. OGGETTO E TIPOLOGIA DI CONTRATTO</b></li>
            
            <li>2.1 Il contratto avrà ad oggetto la fornitura di servizi Internet da realizzare sul sito web <u>www.info-alberghi.com</u> - di seguito denominato <span class="bi">"SERVIZIO"</span> -, con particolare riguardo alla promozione dell'attività professionale svolta dal <span class="bi">CLIENTE</span> .</li>
            <li>2.2 Non si accettano eventuali condizioni di vendita imposte dal <span class="bi">CLIENTE</span> . La lavorazione inizierà nel momento in cui <span class="bi">INFO ALBERGHI</span> riceverà le presenti condizioni e il modulo d'ordine controfirmati.</li>
            <li>2.3 Con la sottoscrizione dell'ordine il <span class="bi">CLIENTE</span> richiede ad <span class="bi">INFO ALBERGHI</span> di mettere a disposizione il <span class="bi">SERVIZIO</span> secondo le caratteristiche indicate nell'ordine stesso. La sottoscrizione dell'ordine e l'utilizzo dei servizi implicano l'accettazione delle presenti condizioni generali di contratto.</li>
            <li>2.4 Qualsiasi modifica od aggiunta al presente contratto dovrà essere specificatamente approvata per iscritto dalle parti.</li>
            <li>2.5 Il presente contratto è rivolto esclusivamente a professionisti ed imprenditori e per tale ragione non è soggetto al D.L.gs. 06.09.2005 n. 206.</li>

            <li class="subtitle"><b>3. DESCRIZIONE, ESECUZIONE E MODALITà DEL SERVIZIO</b></li>

            <li>3.1 Le modalità di pubblicazione del <span class="bi">SERVIZIO</span> sul sito web <u>www.info-alberghi.com</u>, le relative dimensioni e qualità grafiche, nonché la collocazione all'interno delle pagine web, sono affidate ad <span class="bi">INFO ALBERGHI</span> senza possibilità di scelta da parte del <span class="bi">CLIENTE</span> , con facoltà inoltre di modificare/aggiornare l'aspetto grafico, il funzionamento e le informazioni presenti sul sito, anche senza preavviso alcuno.</li>
            <li>3.2 Il <span class="bi">CLIENTE</span> prende atto e accetta espressamente che <span class="bi">INFO ALBERGHI</span>, a suo insindacabile giudizio, riporterà nella pagina/scheda relativa alla struttura del <span class="bi">CLIENTE</span>, il punteggio ottenuto dalla media delle valutazioni pubblicate on-line sui principali portali/siti web di recensioni sulle strutture alberghiere, dichiarando fin d’ora di rinunciare a ogni e qualsivoglia pretesa, richiesta e/o eccezione e/o contestazione inerente il punteggio medio indicato.</li>

            <li class="subtitle"><b>4. DURATA E PROROGA DEL CONTRATTO</b></li>
            
            <li>4.1 Il contratto avrà effetto dal primo giorno di erogazione del <span class="bi">SERVIZIO</span> e avrà durata di un anno, salvo il caso in cui il <span class="bi">CLIENTE</span> non corrisponda il prezzo pattuito. Il contratto si intenderà automaticamente rinnovato per periodi successivi di un anno, salva disdetta di una delle parti da comunicarsi 30 gg prima della scadenza a mezzo lettera raccomandata con ricevuta di ritorno.</li>
            <li>4.2 Il pagamento del canone relativo all'annualità successiva, dovrà essere effettuato almeno 15 giorni prima della data di scadenza dell'annualità precedente. In caso di omesso rispetto di tale termine, <span class="bi">INFO ALBERGHI</span> avrà la facoltà di risolvere unilateralmente il contratto.</li>
            <li>4.3 In ogni caso di disattivazione del <span class="bi">SERVIZIO</span>, dovuto a disdetta, recesso o risoluzione del contratto, nonché a qualsivoglia altra causa dipendente dalle parti contraenti o da terzi, i contenuti on-line relativi al <span class="bi">CLIENTE</span> (foto, descrizioni, recapiti etc.) presenti all'interno del sito <u>www.info-alberghi.com</u>, non saranno più indicizzati all'interno di detto portale, ove verrà rimosso ogni tipo di collegamento (es. link) ad essi; tuttavia <span class="bi">INFO ALBERGHI</span> non si assume alcuna responsabilità, né alcun onere di intervento e rimozione, qualora tali contenuti siano comunque accessibili attraverso collegamenti di siti terzi, quali, a titolo esemplificativo, i motori di ricerca (es. Google).</li>

            <li class="subtitle"><b>5. PAGAMENTO DEL PREZZO</b></li>

            <li>5.1 L'ammontare del canone annuo si intende determinato secondo quanto pattuito dalle parti nel modulo d'ordine, fatti salvi gli adeguamenti relativi alle variazioni dell'ISTAT e salve eventuali variazioni di prezzo che <span class="bi">INFO ALBERGHI</span> ha la facoltà di apportare ad ogni scadenza contrattuale. Gli eventuali nuovi prezzi saranno comunicati in tempo utile per consentire al <span class="bi">CLIENTE</span> di esercitare il proprio diritto di recesso.</li>
            <li>5.2 Il canone sarà pagato in via anticipata alla sottoscrizione del presente contratto e del relativo modulo d'ordine e, per le annualità successive, al momento del tacito rinnovo. Il mancato pagamento del canone nei termini pattuiti comporta l'addebito di una penale pari al 15% del canone annuo a carico del <span class="bi">CLIENTE</span> ; il contratto, inoltre, dovrà ritenersi risolto di diritto.</li>
            <li>5.3 Per ritardi nei pagamenti decorrono gli interessi ufficiali di mora di cui al D.lgs. 231/02.</li>
            <li>5.4 In caso di mancato pagamento Ri.BA. alla scadenza contrattualmente determinata verrà effettuato l'addebito delle spese accessorie causa insoluto. Dette spese sono quantificabili in &euro; 7,00.</li>

            <li class="subtitle"><b>6. OBBLIGHI, DIVIETI E RESPONSABILITÀ DEL CLIENTE</b></li>

            <li>6.1 Il <span class="bi">CLIENTE</span> è l'unico responsabile, civilmente e penalmente, del contenuto, della liceità e veridicità del materiale informativo pubblicato sul web, esonerando espressamente <span class="bi">INFO ALBERGHI</span> da ogni conseguenza al riguardo e manlevandola e tenendola indenne da qualsivoglia pregiudizio dovesse alla stessa derivare.</li>
            <li>6.2 Il <span class="bi">CLIENTE</span> , al momento della sottoscrizione del contratto, è tenuto a fornire una serie completa di fotografie in alta risoluzione relative ad ogni ambiente della struttura (dimensioni min. 800x600 pixel). </li>
            <li>6.3 In alternativa, qualora non fosse in possesso di tali materiali o quelli forniti non fossero valutati idonei - ad insindacabile giudizio della <span class="bi">INFO ALBERGHI</span> - rispetto allo standard di riferimento dell'azienda, il <span class="bi">CLIENTE</span> si impegna a consentire ad operatori incaricati da <span class="bi">INFO ALBERGHI</span>, con oneri e spese a carico della stessa, di eseguire il <span class="bi">SERVIZIO</span> fotografico. In tal caso, le fotografie resteranno di proprietà di <span class="bi">INFO ALBERGHI</span> che le pubblicherà sui propri portali (munite di watermark), con possibilità per il <span class="bi">CLIENTE</span> di acquistarle successivamente.</li>
            <li>6.4 L'utilizzo delle apparecchiature di <span class="bi">INFO ALBERGHI</span> richiede che la zona d'intervento sia libera da persone e ostacoli. Sarà onere del <span class="bi">CLIENTE</span> informare <span class="bi">INFO ALBERGHI</span> dei rischi propri della sua attività che possono influire sulla sicurezza del personale ed indicare le norme di comportamento in caso di emergenza.</li>
            <li>6.5 Qualora il <span class="bi">CLIENTE</span> non fornisca il materiale di cui al punto 6.2 o non consenta le attività di cui al punto 6.3, la <span class="bi">INFO ALBERGHI</span> potrà sospendere la fornitura del <span class="bi">SERVIZIO</span>, con risoluzione anticipata del contratto.</li>
            <li>6.6 OBBLIGHI IN MATERIA DI PRIVACY.</li>
            <li>6.6.1 I dati personali, sensibili e non, relativi alle richieste inoltrate dai visitatori del sito, dovranno essere trattati nel rispetto della normativa sulla privacy (D.lgs. 193/2006 e Reg. UE 2016/679). Il <span class="bi">CLIENTE</span> diviene Titolare del trattamento dei dati ottenuti tramite compilazione del form dal sito da parte degli interessati, qualora intenda trattarli per finalità diversa da quella per cui sono stati ottenuti (rispondere alla richiesta del visitatore del sito). In tal caso, dovrà fornire all'interessato compiuta informativa ai sensi del Reg. UE 2016/679. In caso di utilizzo contra legem dei dati comunicati, il <span class="bi">CLIENTE</span> si obbliga a manlevare e tenere indenne <span class="bi">INFO ALBERGHI</span> da qualsivoglia pregiudizio e/o azione eventualmente intrapresa da terzi.</li>
            <li>6.6.2 In caso di trasmissione a <span class="bi">INFO ALBERGHI</span> di dati personali e/o immagini/video di terze persone, il <span class="bi">CLIENTE</span> , quale unico Titolare del trattamento di tali dati, si impegna ad ottenere la liberatoria per il relativo utilizzo a fini pubblicitari e promozionali. <span class="bi">INFO ALBERGHI</span> tratterà tali dati solo con la finalità di dare esecuzione al contratto di fornitura di servizi e di assistenza tecnica. A tal fine, il <span class="bi">CLIENTE</span> nomina <span class="bi">INFO ALBERGHI</span>, con la sottoscrizione del presente contratto, quale Responsabile del trattamento di tali dati, autorizzandola espressamente a nominare a sua volta altro Responsabile del trattamento, ossia il titolare del <span class="bi">SERVIZIO</span> di web hosting e del server su cui sono conservati i database nei quali vengono archiviati i suddetti dati personali, nei termini di cui alla nomina in calce al presente contratto.</li>

            <li class="subtitle"><b>7. IMPEGNI DI INFO ALBERGHI</b></li>
            
            <li>7.1 <span class="bi">INFO ALBERGHI</span> garantisce la qualità del prodotto e si impegna a mantenere l'efficienza del <span class="bi">SERVIZIO</span> offerto. Qualora <span class="bi">INFO ALBERGHI</span> fosse costretta ad interrompere il <span class="bi">SERVIZIO</span> per eventi eccezionali o per manutenzione, sarà sua cura contenere i periodi di interruzione o di malfunzionamento.</li>
            <li>7.2 <span class="bi">INFO ALBERGHI</span> provvede a pubblicare sullo spazio web esclusivamente le informazioni concordate con il <span class="bi">CLIENTE</span> .</li>
            <li>7.3 <span class="bi">INFO ALBERGHI</span> si impegna a fornire il <span class="bi">SERVIZIO</span> nei tempi e nei modi concordati.</li>

            <li class="subtitle"><b>8. LIMITAZIONE DI RESPONSABILITà DI INFO ALBERGHI - FORZA MAGGIORE, CASO FORTUITO, OPERA DI TERZI</b></li>

            <li>8.1 <span class="bi">INFO ALBERGHI</span> non è responsabile del contenuto del <span class="bi">SERVIZIO</span> e si limita a pubblicare quanto concordato con il <span class="bi">CLIENTE</span> stesso. <span class="bi">INFO ALBERGHI</span> si riserva la facoltà di rifiutare di pubblicare i contenuti contrari al comune senso civico ed alle leggi italiane, senza che ciò possa comportare alcuna conseguenza pregiudizievole di carattere economico.</li>
            <li>8.2 <span class="bi">INFO ALBERGHI</span> non è responsabile dell'eventuale interruzione, sospensione o cessazione del <span class="bi">SERVIZIO</span> oggetto del contratto, per fatto o colpa imputabili a terzi o che derivino da cause al di fuori della sfera del proprio prevedibile controllo o da cause di forza maggiore.</li>
            <li>8.3 In nessun caso <span class="bi">INFO ALBERGHI</span> sarà ritenuta responsabile del malfunzionamento del <span class="bi">SERVIZIO</span> derivante da responsabilità delle linee telefoniche, elettriche e di reti mondiali e nazionali, quali guasti, sovraccarichi, interruzioni, ecc.</li>
            <li>8.4 Per la struttura specifica di Internet, nessuna garanzia può essere data riguardo alla costante fruibilità del SERVIZIO. In questo senso il <span class="bi">CLIENTE</span> concorda nel non ritenere <span class="bi">INFO ALBERGHI</span> responsabile nel caso di impossibilità di accesso al <span class="bi">SERVIZIO</span>, causata da ritardi o interruzioni di internet.</li>
          </ul>
        </div>

        <div style="margin-bottom:5px;">
          <ul class="elenco_condizioni">
            <li>8.5 Nessuna delle due parti è responsabile per guasti imputabili a cause di incendio, esplosione, terremoto, eruzioni vulcaniche, frane, cicloni, tempeste, inondazioni, uragani, valanghe, guerra, insurrezioni popolari, tumulti, scioperi ed a qualsiasi altra causa imprevedibile ed eccezionale che impedisca di fornire il <span class="bi">SERVIZIO</span> concordato.</li>
            <li>8.6 Nessun risarcimento danni potrà essere richiesto a <span class="bi">INFO ALBERGHI</span> per danni diretti e/o indiretti causati dall'utilizzazione o mancata utilizzazione dei servizi.</li>
            <li>8.7 Se l'evento iniziato dovesse venire sospeso o annullato per qualsiasi causa di forza maggiore o caso fortuito, il <span class="bi">CLIENTE</span> è tenuto a corrispondere l'intero compenso pattuito.</li>
            <li class="subtitle"><b>9. CONTESTAZIONI</b></li>
            <li>9.1 Il <span class="bi">CLIENTE</span> è obbligato a controllare il <span class="bi">SERVIZIO</span> immediatamente dopo la pubblicazione dello stesso. Eventuali difetti devono essere fatti valere per iscritto entro 8 gg dalla pubblicazione.</li>
            <li class="subtitle"><b>10. RECESSO</b></li>
            <li>10.1 Il <span class="bi">CLIENTE</span> dichiara che il presente contratto viene sottoscritto per scopi professionali e/o imprenditoriali e pertanto prende atto che esso non è soggetto al D.lgs. n. 206/2005. <span class="bi">INFO ALBERGHI</span> concede comunque al <span class="bi">CLIENTE</span> la possibilità di recedere dal contratto prima che questo abbia avuto un principio di esecuzione, previo pagamento di un corrispettivo ai sensi dell'art. 1373 c.c., pari al 25% dell'importo contrattuale previsto.</li>
            <li class="subtitle"><b>11. RISOLUZIONE DI DIRITTO</b></li>
            <li>11.1 <span class="bi">INFO ALBERGHI</span> potrà, a suo insindacabile giudizio, sospendere la fornitura di servizi e/o risolvere anticipatamente il contratto nei seguenti casi: a) mancato rispetto da parte del <span class="bi">CLIENTE</span> delle leggi, dei regolamenti e degli accordi contrattuali; b) in caso di mancato pagamento dei canoni da parte del <span class="bi">CLIENTE</span> alle scadenze pattuite; c) qualora il <span class="bi">CLIENTE</span> non risulti più il titolare/gestore della struttura oggetto del presente contratto e dunque non disponga del legittimo esercizio dei diritti sulla relativa ditta, denominazione, ragione sociale, insegna e nome a dominio. In caso di anticipata risoluzione per i motivi sopra descritti o per motivi comunque imputabili al <span class="bi">CLIENTE</span>, quest’ultimo resterà obbligato al pagamento del prezzo pattuito per la scadenza naturale del contratto, con decadenza dall’eventuale beneficio del termine ex art. 1186 c.c. e dovrà altresì versare a <span class="bi">INFO ALBERGHI</span>, a titolo di indennità, un corrispettivo pari al saldo dell’annualità e dei servizi realizzati o in corso di realizzazione.</li>
            <li class="subtitle"><b>12. CONTROVERSIE - DEROGA AL FORO COMPETENTE</b></li>
            <li>12.1 Previa espressa trattativa, le parti convergono che, per qualsiasi controversia nascente o derivante dall'applicazione, interpretazione, esecuzione e risoluzione del presente contratto, il Foro competente in via esclusiva sia quello di RIMINI, con ciò derogando la competenza territoriale di altri Fori competenti per legge. Il <span class="bi">CLIENTE</span>, reso edotto del contenuto e del significato delle disposizioni di cui all’art. 1469-bis e segg. del C.C., dichiara e riconosce che l’indicazione del foro giudiziale così convenuto è stata liberamente determinata tra le parti e non costituisce squilibrio alcuno delle condizioni contrattuali.</li>
            <li class="subtitle"><b>13. PRIVACY</b></li>
            <li>13.1 La tutela della privacy riguarda unicamente le persone fisiche. Gli eventuali dati personali conferiti dal <span class="bi">CLIENTE</span> a <span class="bi">INFO ALBERGHI</span> (generalità, recapiti, dati bancari etc.) saranno trattati unicamente per la conclusione e l'esecuzione del presente contratto e per il perseguimento di un eventuale legittimo interesse di <span class="bi">INFO ALBERGHI.</span> I dati saranno conservati per la durata del contratto o fino alla persistenza di un legittimo interesse di <span class="bi">INFO ALBERGHI.</span> Per le medesime finalità, <span class="bi">INFO ALBERGHI</span> si avvale di collaboratori, dipendenti e soggetti esterni (liberi professionisti, tecnici informatici, titolari di servizi di web hosting etc.) che, qualora necessario, saranno in grado di accedere ai dati personali da Lei conferiti nei limiti strettamente necessari allo svolgimento dei propri compiti ausiliari. L'interessato potrà ottenere da <span class="bi">INFO ALBERGHI</span>, mediante richiesta scritta, informazioni circa la conferma dell'esistenza o meno dei propri dati personali; nel caso potrà chiederne una copia; il medesimo avrà diritto di chiedere la rettifica dei dati personali o la cancellazione, nonché di vederne limitato il trattamento futuro secondo le modalità e i casi indicati dalla normativa (art. 4 e 18 del reg. eu. 679/2016); infine, l'interessato ha diritto di proporre reclamo a un'autorità di controllo secondo quando previsto dagli articoli dal 15 al 22 del GDPR 679/2016.</li>
          </ul>
        </div>

        <table width="100%" class="firme_ultima_pagina">
          <tr width="100%">
              <td  width="100%" colspan="2">Rimini lì <?php echo date("d/m/Y") ?></td>
          </tr>
          <tr class="firme">
              <td width="50%" style="text-align: center;">
                  Agente <b>INFO ALBERGHI</b>
              </td>
              <td  width="50%" style="text-align: center;">
                  <b>CLIENTE</b>
              </td>
          </tr>
        </table>

        <table width="100%" class="firme_ultima_pagina">
            <tr>
                <td colspan="2">
                    <ul class="elenco_condizioni altre" style="margin-top:70px;">
                      <li style="text-decoration:underline; margin-top:0px;">AI SENSI DEGLI ARTT. 1341 E 1342 C.C., IL <b>CLIENTE</b> DICHIARA DI AVER PRESO VISIONE E DI BEN CONOSCERE TUTTE LE CLAUSOLE DEL PRESENTE CONTRATTO ED IN PARTICOLARE SI DICHIARA DI APPROVARE ESPRESSAMENTE ED IN MODO SPECIFICO LE CLAUSOLE SEGUENTI: 4. DURATA E PROROGA DEL CONTRATTO; 6. OBBLIGHI, DIVIETI E RESPONSABILITÀ DEL <b>CLIENTE</b>; 8. LIMITAZIONE DI RESPONSABILITÀ DI <b>INFO ALBERGHI</b> - FORZA MAGGIORE, CASO FORTUITO, OPERA DI TERZI; 10. RECESSO; 11. RISOLUZIONE DI DIRITTO; 12. CONTROVERSIE - DEROGA AL FORO COMPETENTE.</li>
                      <li style="text-decoration:underline; font-weight: bold; margin-top:0px;">DOPO ATTENTA PONDERAZIONE, INTENDE STIPULARE IL PRESENTE CONTRATTO ALLE CONDIZIONI TUTTE SOPRA INDICATE E DICHIARA DI AVERE RICEVUTO COPIA DELLO STESSO; SOTTOSCRIVE ANCHE PER RICEVUTA DEL PRESENTE CONTRATTO.
                    </ul>
                </td>
            </tr>
            <tr width="100%">
                <td  width="100%" colspan="2">Rimini lì <?php echo date("d/m/Y") ?></td>
            </tr>
            <tr class="firme">
                <td width="50%" style="text-align: center;">
                    Agente <b>INFO ALBERGHI</b>
                </td>
                <td  width="50%" style="text-align: center;">
                    <b>CLIENTE</b>
                </td>
            </tr>
        </table>

        <table class="respomsabile_trattamento">
            <tr width="100%">
                <td  width="100%" colspan="2">
                  <ul>
                    <b>NOMINA A RESPONSABILE DEL TRATTAMENTO</b><br />
                    Ai sensi e per gli effetti di cui all'art. 28 REG. UE 2016/679 e in relazione alla clausola contrattuale 6.6.2, <span class="bi">INFO ALBERGHI</span> si impegna a:
                    <li>trattare i dati personali su istruzione documentata del Titolare del Trattamento (cliente);</li>
                    <li>avvalersi di eventuali incaricati/autorizzati al trattamento che si siano impegnati alla riservatezza e/o abbiano un adeguato obbligo legale di riservatezza; </li>
                    <li>mettere in atto misure tecniche e organizzative per garantire un livello di sicurezza adeguato al rischio e, in particolare, per impedire la distruzione o la perdita, anche accidentale, dei dati personali trattati, nonché per evitarne l'accesso a soggetti non autorizzati;</li>
                    <li>interagire con il Garante, in caso di richieste di informazioni o effettuazione di controlli o di accessi da parte dell'autorità e nel caso informare prontamente il Titolare del Trattamento, e collaborare con esso per l'attuazione delle prescrizioni impartite dal Garante;</li>
                    <li>adottare misure tecniche e organizzative adeguate, nella misura in cui ciò sia possibile, al fine di soddisfare l'obbligo del Titolare del trattamento di dare seguito alle richieste per l'esercizio dei diritti dell'interessato;</li>
                    <li>mettere a disposizione del Titolare del trattamento tutte le informazioni necessarie per dimostrare il rispetto degli obblighi di legge e a contribuire alle attività di revisione, comprese le ispezioni;</li>
                    <li>comunicare al Titolare qualsiasi situazione di cui sia venuto a conoscenza, nell'espletamento delle attività di esecuzione dell'incarico professionale assegnato, che possa compromettere il corretto trattamento dei dati personali;</li>
                    <li>a richiesta del Titolare, cancellare o restituire i dati al momento della cessazione del rapporto contrattuale, salvo la conservazione per fini fiscali o per adempimenti imposti per legge;</li>
                    <li>ottenere l'autorizzazione del Titolare qualora intenda ricorrere ad altro responsabile per l'esecuzione di specifiche attività di trattamento per conto dello stesso.</li>
                  </ul>
                  <ul>
                    A tal fine, <span class="bi">INFO ALBERGHI</span> comunica che:
                    <li>i dati personali trattati per conto del Titolare sono conservati su database allocati su server di proprietà di impresa esterna con sede nell'Unione Europea, nominata a sua volta quale Responsabile del trattamento, giusta autorizzazione del Titolare;</li>
                    <li>vengono adottate le seguenti misure di sicurezza tecniche e organizzative:</li>
                    <ol>
                      <li>Tutti i computer sono protetti da programmi anti-virus e anti-intrusione, periodicamente aggiornati nel rispetto della legge, così come nel rispetto della legge sono periodicamente aggiornati i sistemi operativi;</li>
                      <li>Il sistema informatico in uso dispone di server di ultima generazione per il back-up dei dati informatici; tutto il materiale e gli strumenti in dotazione sono periodicamente sottoposti a controlli ad opera di tecnici autorizzati;</li>
                      <li>L' ingresso alla sede è dotato di serratura di sicurezza; l'accesso è consentito solo ai titolari ed agli incaricati/autorizzati del trattamento; i soggetti estranei sono sempre in presenza dei suddetti; la sede è dotata di gruppo di continuità per garantire il sistema informatico, e di cassaforte ignifuga per conservazione copie e archivio dotato di chiusura a chiave;</li>
                      <li>La sede è situata in struttura ristrutturata nel 2008 in conformità alle norme antisismiche, antincendio ed antiallagamento e tecnici autorizzati svolgono periodicamente i controlli necessari ai sistemi complementari (impianto elettrico, climatizzazione, ecc);</li>
                      <li>Ogni operatore è dotato di propri codici di accesso mnemonicamente annotati e si attiene al codice deontologico professionale ed è costantemente aggiornato sulle normative in materia di privacy e trattamento dei dati.</li>
                    </ol>
                    IL <span class="bi">CLIENTE</span>, PRESO ATTO DI QUANTO SOPRA, NOMINA <span class="bi">INFO ALBERGHI</span> SRL QUALE RESPONSABILE DEL TRATTAMENTO DEI DATI E LA AUTORIZZA A NOMINARE ALTRI RESPONSABILI DEL TRATTAMENTO.
                  </ul>
              </td>
            </tr>
            <tr width="100%">
                <td  width="100%" colspan="2">&nbsp;</td>
            </tr>
            <tr class="firme">
                <td width="50%" style="text-align: center;">
                    &nbsp;
                </td>
                <td  width="50%" style="text-align: center;">
                    <b>CLIENTE</b> (TITOLARE DEL TRATTAMENTO)
                </td>
            </tr>
        </table>

        {{-- /Pagina 1 statica --}}
        @endif
        
      </div>
    </main>
  @endforeach
</body>
</html>