@extends('layouts.coreui.crm_lara6')

@section('content')

@include('layouts.coreui.menu_sezioni_clienti') 

<div class="row">
  <div class="col-sm-2">
    <div class="callout callout-info b-t-1 b-r-1 b-b-1">
       Elenco società
      @if (isset($clienti))
      <br>
      <strong class="h4">{{$clienti->total()}}</strong>
      @endif
    </div>
  </div><!--/.col-->
  <div class="to-right">
      <div class="callout callout-noborder">
        <button type="button" class="btn btn-warning" data-toggle="modal" data-keyboard="false" data-backdrop="static" data-target="#m_modal_contatti">Aggiungi Società</button>
        </a>
      </div>
    </div><!--/.col-->
</div>
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
                  <tr>
                      <td><a href="{{ route('clienti-fatturazioni.edit', $s->id) }}"> {{optional($s->ragioneSociale)->nome}} </a></td>
                      <td>{{$s->abi}}</td>
                      <td>{{$s->cab}}</td>
                      <td>{!!$s->note!!}</td>
                      <td>
                        <a href="{{ route('societa-fatture', $s->id) }}" class="btn btn-info m-btn m-btn--icon m-btn--icon-only">
                          <i class="fa fa-euro-sign"></i>
                        </a>
                      </td>
                      <td>
                        <td><a  data-id="{{$s->id}}" href="" class="delete btn btn-danger"><i class="fas fa-trash-alt"></i></a></td>
                      </td>
                  </tr>
              @endforeach
          </tbody>
      </table>
      @endif
        
    </div>{{-- col --}}
</div>{{-- row --}}




{{-- MODAL elenco societa --}}
<div class="modal fade" id="m_modal_contatti" tabindex="-1" role="dialog" aria-labelledby="societa" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="col-lg-3" style="margin-top: 10px">
                    <h5 class="modal-title" id="societa">Elenco Società </h5>
                </div>
                <span style="margin-top: 10px" class="col-lg-1 m-badge m-badge--success m-badge--wide" id="n_societa">{{$ragioneSociale->count()}}</span>
                <div class="col-lg-6">
                    <input id="myInput" type="text" class="form-control m-input m-input--pill m-input--air" placeholder="scrivi per filtrare">
                </div>
                <div class="col-lg-1">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            <div class="modal-body">
                <div class="m-scrollable m-scrollable--track m-scroller ps ps--active-y" data-scrollable="true" style="height: 400px; overflow: hidden;">
            <table class="table table-striped m-table m-table--head-bg-success" id="tabellaSocieta">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Cliente</th>
                    <th>ID</th>
                    <th>Note</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ragioneSociale as $r)
                    @foreach ($r->societa as $s)
                      <tr class="societa">
                          <td><a data-id="{{$s->id}}" data-nome="{{$r->nome}}"  class="societa_fattura" title="Fattura a questa società">{{$r->nome}}</a></td>
                          <td>{{optional($s->cliente)->nome}}</td>
                          <td>{{optional($s->cliente)->id_info}}</td>
                          <td>{{$r->note}}</td>
                      </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
        </div>
            </div>
        </div>
    </div>
</div>
{{-- \MODAL elenco contatti --}}


@endsection


@section('js')
  
    <script type="text/javascript" charset="utf-8">

        jQuery(document).ready(function(){

            $(".societa_fattura").click(function(e){
                e.preventDefault();
                var societa_id = $(this).data("id");
                ///////////////////////////////////////////////////
                // Ajax call per associare la società al cliente //
                ///////////////////////////////////////////////////
                console.log('societa_id ='+societa_id);
                jQuery.ajax({
                        url: '<?=url("associa-societa-ajax") ?>',
                        type: "get",
                        async: false,
                        data : { 
                                'cliente_id': {{$cliente->id}},
                               'societa_id': societa_id,        
                               },
                        success: function(data) {
                          location.reload();
                          Swal.fire({
                            type: 'success',
                            title: 'Perfetto',
                            text: 'La società è passata a questo cliente!',
                          })
                        }
                 });

            });



            /* ricerca nelle societa in popup modale */
            $("#myInput").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("tr.societa").filter(function() {
                  $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
                var visible_rows = $('tr.societa:visible').length;
                jQuery("#n_societa").html(visible_rows);
              });


        });
    

    </script>
@endsection