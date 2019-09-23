@extends('layouts.lara_crm')

@section('content')

<div class="row">
    <div class="col-xl-12 sezioni-cliente">

        <!--begin:: Widgets/Tasks -->
        <div class="m-portlet m-portlet--last m-portlet--head-lg m-portlet--responsive-mobile" id="main_portlet">
         
            @include('menu_sezioni_clienti') 

            <div class="m-portlet__body">
                <div class="tab-content">
                    <div class="m-section">
                        <div class="m-section__heading">
                            Elenco Società  <button type="button" class="btn btn-warning" data-toggle="modal" data-keyboard="false" data-backdrop="static" data-target="#m_modal_contatti">Aggiungi Società</button>
                        </div>
                         <div class="m-section__content">
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
                                              <form action="{{ route('clienti-fatturazioni.destroy', ['id' => $s->id]) }}" method="POST" accept-charset="utf-8" class="deleteForm" id="delete-riga-form">
                                                  @csrf
                                                  <a href="#" style="margin-bottom: 5px!important;" class="delete btn btn-danger m-btn m-btn--icon m-btn--icon-only"> 
                                                      <i class="la la-trash"></i>
                                                  </a>
                                              </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @endif
                        </div>
                    </div>
                </div>     
            </div>
        </div> {{-- m-port  let --}}

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
                          <td><a href="#" data-id="{{$s->id}}" data-nome="{{$r->nome}}"  class="societa_fattura" title="Fattura a questa società">{{$r->nome}}</a></td>
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
                          Swal({
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
    <script src="{{ asset('js/sweetalert2.js') }}" type="text/javascript"></script>
@endsection