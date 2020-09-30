@extends('layouts.coreui.crm_lara6')

@section('content')

<div class="row">
  <div class="col-sm-2">
    <div class="callout callout-info b-t-1 b-r-1 b-b-1">
       Elenco conteggi
      @if (isset($conteggi))
      <br>
      <strong class="h4">{{$conteggi->total()}}</strong>
      @endif
    </div>
  </div><!--/.col-->
  @if (count(Request()->query()))
    <div class="col-sm-2">
      <div class="callout callout-noborder">
        <a href="{{ url('conteggi') }}" title="Tutti i conteggi" class="btn btn-warning">
          Tutti
        </a>
      </div>
    </div><!--/.col-->
  @endif

</div>

<div>
  <form action="{{ route('conteggi.store') }}" method="post">
    <div class="form-group">
      <label for="">Titolo</label>
      <input type="text" name="titolo" id="titolo" class="form-control" placeholder="Titolo" required>
    </div>
    <button type="submit" class="btn btn-primary">Crea</button>
  </form>
</div>

<div class="row">
  <div class="col">
    @if ($conteggi->total())
      <div>
          <table class="table table-responsive">
              <tbody>
                <tr>
                  <th>Titolo</th>
                  <th></th>
                </tr>
                @foreach ($conteggi as $c)
                    <tr>
                      <td><a href="{{ route('conteggi.edit', $c->id) }}">{{$c->titolo}}</a></td>
                      <td>X</td>
                    </tr>
                @endforeach
              </tbody>
          </table>
      </div>
      <div>              
        {{ $conteggi->links() }}
      </div>
    @else
      <div>
        Nessun conteggio
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