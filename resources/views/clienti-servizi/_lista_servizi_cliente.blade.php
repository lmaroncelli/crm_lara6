<div class="row">
    <div class="col">
                        
      @if ($servizi->count())
      <table class="table table-responsive-sm m-table m-table--head-bg-success table-hover">
          <thead>
              <tr>
                  <th>Prodotto</th>
                  <th>Inizio</th>
                  <th>Fine</th>
                  <th>Note</th>
                  <th>N. Fattura</th>
                  <th></th>
              </tr>
          </thead>
          <tbody>
              @foreach ($servizi as $s)
                  <form action="{{ route('clienti-servizi.destroy', $s->id) }}" method="post" id="delete_item_{{$s->id}}">
                    @csrf
                  </form>
                  <tr>
                      <td><nome-servizio-cliente servizio_id="{{$s->id}}" nome_prodotto="{{$s->prodotto->nome}}"></nome-servizio-cliente></td>
                      <td>{{optional($s->data_inizio)->format('d/m/Y')}}</td>
                      <td>{{optional($s->data_fine)->format('d/m/Y')}}</td>
                      <td>{{$s->note}}</td>
                      <td>{{optional($s->fattura)->numero_fattura}}</td>
                      <td>
                        <a data-id="{{$s->id}}" href="#" class="delete btn btn-danger"><i class="fas fa-trash-alt"></i></a>
                      </td>
                  </tr>
              @endforeach
          </tbody>
      </table>
      @endif
        
    </div>{{-- col --}}
</div>{{-- row --}}
