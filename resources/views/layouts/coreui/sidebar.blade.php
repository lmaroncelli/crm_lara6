<div class="sidebar">
  <nav class="sidebar-nav">
    <ul class="nav">

      <li class="nav-item">
        <a class="nav-link" href="{{ route('clienti.index') }}">
        <i class="nav-icon icon-people"></i>Clienti
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="{{ route('societa.index') }}">
        <i class="nav-icon icon-globe"></i>Società
        </a>
      </li>

      <li class="nav-item nav-dropdown">
        <a class="nav-link nav-dropdown-toggle" href="#">
          <i class="nav-icon icon-docs"></i>Fogli digitali
        </a>
          <ul class="nav-dropdown-items">
            <li class="nav-item"><a class="nav-link" href="{{ route('contratto-digitale.index') }}"><i class="nav-icon icon-note"></i>Precontratti</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('foglio-servizi.index') }}"><i class="nav-icon icon-tag"></i>Fogli Servizi</a></li>
            <li class="nav-item"><a class="nav-link" href="#"><i class="nav-icon icon-note"></i>Precontratti HM(TD)</a></li>
          </ul>
      </li>

      @if (Auth::user()->hasType('A'))

        <li class="nav-item">
          <a class="nav-link" href="{{ route('fatture.index') }}">
          <i class="nav-icon icon-wallet"></i>Fatture
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="{{ route('prefatture.index') }}">
          <i class="nav-icon icon-wallet"></i>Prefatture
          </a>
        </li>

        <li class="nav-item nav-dropdown">
          <a class="nav-link nav-dropdown-toggle" href="#">
            <i class="nav-icon icon-clock"></i>Scadenziario
          </a>
            <ul class="nav-dropdown-items">
              <li class="nav-item"><a class="nav-link" href="{{ route('scadenze.index') }}"><i class="nav-icon icon-close"></i>Non incassato</a></li>
              <li class="nav-item"><a class="nav-link" href="{{ route('scadenze.incassate') }}"><i class="nav-icon icon-login"></i>Incassato</a></li>
            </ul>
        </li>
        
      @endif

      <li class="nav-item nav-dropdown">
        <a class="nav-link nav-dropdown-toggle" href="#">
          <i class="nav-icon icon-layers"></i>Servizi
        </a>
          <ul class="nav-dropdown-items">
            <li class="nav-item"><a class="nav-link" href="{{ route('servizi.index') }}"><i class="nav-icon icon-hourglass"></i>Sadenze servizi</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('servizi.index',['tipo' => 'evidenze']) }}"><i class="nav-icon icon-magic-wand"></i>Evidenze</a></li>
          </ul>
      </li>

      <li class="nav-item nav-dropdown">
        <a class="nav-link nav-dropdown-toggle" href="#">
          <i class="nav-icon icon-social-dropbox"></i>Utility
        </a>
          <ul class="nav-dropdown-items">
            <li class="nav-item"><a class="nav-link" href="{{ route('vetrine.index') }}"><i class="nav-icon icon-screen-tablet"></i>Vetrine</a></li>
            
             @if (Auth::user()->hasType('A'))
              <li class="nav-item"><a class="nav-link" href=" {{ url('memorex') }} "><i class="nav-icon icon-book-open"></i>Memorex</a></li>
            @endif

            @if (Auth::user()->hasType('A'))
              <li class="nav-item"><a class="nav-link" href="{{ route('conteggi.index_commerciali') }}"><i class="nav-icon icon-calculator"></i>Conteggi</a></li>
            @else
              <li class="nav-item"><a class="nav-link" href="{{ route('conteggi.index') }}"><i class="nav-icon icon-calculator"></i>Conteggi</a></li>
            @endif            
            <li class="nav-item"><a class="nav-link" href="#"><i class="nav-icon icon-pie-chart"></i>Statistiche(TD)</a></li>
            <li class="nav-item"><a class="nav-link" href="#"><i class="nav-icon icon-graph"></i>Andamento attivazioni(TD)</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('evidenze.view') }}"><i class="nav-icon icon-present"></i>Evidenze</a></li>
          </ul>
      </li>

      @if (Auth::user()->hasType('A'))
        <li class="nav-item nav-dropdown">
          <a class="nav-link nav-dropdown-toggle" href="#">
            <i class="nav-icon icon-wrench"></i>Settings
          </a>
            <ul class="nav-dropdown-items">
              <li class="nav-item"><a class="nav-link" href="{{ route('localita.index') }}"><i class="nav-icon icon-directions"></i>Localita</a></li>
              <li class="nav-item"><a class="nav-link" href="#"><i class="nav-icon icon-envelope"></i>Avvisi fatture(TD)</a></li>
              <li class="nav-item"><a class="nav-link" href="#"><i class="nav-icon icon-share"></i>Gruppi clienti(TD)</a></li>
              <li class="nav-item"><a class="nav-link" href="#"><i class="nav-icon icon-present"></i>Evidenze(TD)</a></li>
            </ul>
        </li>
      @endif

    </ul>
  </nav>  
</div> {{-- end sidebar  --}}