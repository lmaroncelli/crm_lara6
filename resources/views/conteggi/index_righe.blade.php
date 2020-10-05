@extends('layouts.coreui.crm_lara6')

@section('content')

<div class="row">
  <div class="col-sm-2">
    <div class="callout callout-info b-t-1 b-r-1 b-b-1">
       Elenco righe conteggio {{$conteggio->titolo}}
      @if (isset($righe))
      <br>
      <strong class="h4">{{$righe->total()}}</strong>
      @endif
    </div>
  </div><!--/.col-->
</div>


<riga-conteggio conteggio_id="{{$conteggio->id}}" commerciale_id="{{Auth::id()}}"></riga-conteggio>


<div class="row">
  <div class="col">
    @if ($righe->total())
      <div>
          <table class="table table-responsive">
              <tbody>
                <tr>
                  <th>Cliente</th> 	
                  <th>ID</th>
                  <th>Servizi</th> 	
                  <th>Valore</th> 	
                  <th>Modalità</th> 	
                  <th>Val. %</th>
                  <th></th>
                </tr>
                @foreach ($righe as $r)
                  @if (!is_null($r->cliente))
                    @php
                        $servizi_arr = [];
                        foreach ($r->servizi as $servizio) 
                          {
                          $servizi_arr[] = $servizio->prodotto->nome;
                          }
                    @endphp  
                    <tr>
                      <td>{{optional($r->cliente)->nome}}</td>
                      <td>{{optional($r->cliente)->id_info}}</td>
                      <td>{{implode(',', $servizi_arr)}}</td>
                      <td>{{$r->reale}}</td>
                      <td>{{optional($r->modalita)->nome}}</td>
                      <td>{{$r->percentuale}} %</td>
                      <td>Elimina</td>
                    </tr>
                  @endif
                @endforeach
              </tbody>
          </table>
      </div>
      <div>              
        {{ $righe->links() }}
      </div>
    @else
      <div>
        Nessuna riga per questo conteggio
      </div>
    @endif      
  </div>
</div>


@endsection


@section('js')
    <script type="text/javascript" charset="utf-8">

        jQuery(document).ready(function(){
            
  
        });
    

    </script>


@endsection