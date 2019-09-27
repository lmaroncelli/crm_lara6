<div class="row">
    <div class="col">
                        
      @if ($cliente->societa->count())
      <table class="table table-responsive-sm m-table m-table--head-bg-success table-hover">
          <thead>
              <tr>
                  <th>Ragione sociale</th>
                  <th>Abi</th>
                  <th>Cab</th>
                  <th>Note</th>
                  <th></th>
                  <th></th>
              </tr>
          </thead>
          <tbody>
              @foreach ($cliente->societa as $s)
                  <form action="{{ route('clienti-fatturazioni.destroy', $s->id) }}" method="post" id="delete_item_{{$s->id}}">
                    @csrf
                  </form>
                  <tr @if ( isset($societa) && $societa->id == $s->id ) class="table-info" @endif>
                      <td><a href="{{ route('clienti-fatturazioni.edit', $s->id) }}"> {{optional($s->ragioneSociale)->nome}} </a></td>
                      <td>{{$s->abi}}</td>
                      <td>{{$s->cab}}</td>
                      <td>{!!$s->note!!}</td>
                      <td>
                        <a href="{{ route('societa-fatture',  [$cliente->id, $s->id]) }}" class="btn btn-info m-btn m-btn--icon m-btn--icon-only">
                          <i class="fa fa-euro-sign"></i>
                        </a>
                      </td>
                      <td>
                        <a  data-id="{{$s->id}}" href="#" class="delete btn btn-danger"><i class="fas fa-trash-alt"></i></a>
                      </td>
                  </tr>
              @endforeach
          </tbody>
      </table>
      @endif
        
    </div>{{-- col --}}
</div>{{-- row --}}


