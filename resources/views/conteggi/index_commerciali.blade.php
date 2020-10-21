@extends('layouts.coreui.crm_lara6')

@section('content')

<div class="row">
  <div class="col-sm-2">
    <div class="callout callout-info b-t-1 b-r-1 b-b-1">
       Conteggi: elenco commerciali
      @if (isset($commerciali))
      <br>
      <strong class="h4">{{$commerciali->count()}}</strong>
      @endif
    </div>
  </div><!--/.col-->
</div>


<div class="row">
  <div class="col">
    @if ($commerciali->count())
      <div>
          <table class="table table-responsive">
              <tbody>
                <tr>
                  <th>Nome</th>
                  <th>N. conteggi</th>
                </tr>
                @foreach ($commerciali as $c)
                  <tr>
                    <td><a href="{{ route('conteggi.index', $c->id) }}">{{$c->name}}</a></td>
                    <td><a href="{{ route('conteggi.index', $c->id) }}"> {{$c->conteggi_count}} </a></td>
                  </tr>
                @endforeach
              </tbody>
          </table>
      </div>
    @else
      <div>
        Nessun commerciale con conteggio
      </div>
    @endif      
  </div>
</div>


@endsection


@section('js')
    <script type="text/javascript" charset="utf-8">

        jQuery(document).ready(function(){
            

          jQuery("tr.dettaglio_fattura").click(function(){
            jQuery(this).next().toggleClass('riga_fattura');
            $(this).find("i").toggleClass('fa-angle-right fa-angle-down');
          })

          jQuery("tr.avvisi_scadenze").click(function(){
            jQuery(this).next().toggleClass('riga_scadenze');
          })

          $(".searching").click(function(){
              $("#searchForm").submit();
          });

          /*  $("#prodotti").select2({placeholder:"Seleziona i prodotti da filtrare"});


            $(".archiviato_check").click(function(){
                $("#searchForm").submit();
            });*/
  
        });
    

    </script>


@endsection