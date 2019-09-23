@extends('layouts.lara_crm')

@section('content')

<div class="m-content">
<div class="row">
    <div class="col-xl-12">

        <!--begin:: Widgets/Tasks -->
        <div class="m-portlet m-portlet--full-height ">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            Form fattura
                        </h3>
                    </div>
                </div>
            </div>

            <form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" role="form" action="{{ route('fatture.store') }}" method="POST" enctype="multipart/form-data">            
            {!! csrf_field() !!}
            <input type="hidden" name="societa_id" id="societa_id" value="{{old('societa_id')}}">
            <div class="m-portlet__body">
            {{-- Tipo-Societa --}}
            <div class="form-group m-form__group row">
                <label class="col-lg-2 col-form-label" for="attivo">Tipo:</label>
                <div class="col-lg-3">
                    <select class="form-control m-input" id="tipo_id" name="tipo_id">
                        @foreach ($tipo_fattura as $key => $value)
                            <option value="{{$key}}" @if ( $fattura->tipo_id == $key || old('tipo_id') != null ) selected="selected" @endif>{{$value}}</option>
                        @endforeach
                    </select>
                </div>
                <label class="col-lg-2 col-form-label" for="societa">Societa:</label>
                <div class="col-lg-2">
                    <input type="text" name="societa" id="societa" value="{{ old('societa') != '' ?  old('societa') : optional(optional($fattura->societa)->ragioneSociale)->nome }}"  class="form-control m-input" placeholder="Societa" readonly="readonly">
                </div>
                <div class="col-lg-1">
                    <button type="button" class="btn btn-warning" data-toggle="modal" data-keyboard="false" data-backdrop="static" data-target="#m_modal_contatti">Società</button>
                </div>
            </div>
            {{-- numero-Data --}}
            <div class="form-group m-form__group row">
                <label class="col-lg-2 col-form-label" for="numero">Numero:</label>
                <div class="col-lg-2">
                    <input type="text" name="numero" id="numero" value="{{ old('numero') != '' ?  old('numero') : $fattura->numero}}"  class="form-control m-input" placeholder="Numero">
                </div>
                <div class="col-lg-1">
                    <button type="button" class="btn btn-warning" data-toggle="modal" data-keyboard="false" data-backdrop="static" data-target="#m_modal_numeri_fattura">Ultimi</button>
                </div>
                <label class="col-lg-2 col-form-label" for="tipo_id">Data:</label>
                <div class="col-lg-3">
                    <div class="input-group date">
                        <input type="text" name="data" class="form-control m-input" readonly value="{{Carbon\Carbon::today()->format('d/m/Y')}}" id="m_datepicker_3" />
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <i class="la la-calendar"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            {{-- \numero-Data --}}

            {{-- tipo pagamento --}}
            <div class="form-group m-form__group row">
                <label class="col-lg-2 col-form-label" for="attivo">Tipo:</label>
                <div class="col-lg-3">
                    <select class="form-control m-input" id="pagamento_id" name="pagamento_id">
                        @foreach ($tipo_pagamento as $key => $value)
                            <option value="{{$key}}" @if ( $fattura->pagamento_id == $key || old('pagamento_id') != null ) selected="selected" @endif>{{$value}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            {{-- \tipo pagamento --}}

            </div> {{-- m-portlet__body --}}

            <div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
                <div class="m-form__actions m-form__actions--solid">
                    <div class="row">
                        <div class="col-lg-2"></div>
                        <div class="col-lg-10">
                            <button type="submit" class="btn btn-success">
                                @if ($fattura->exists)
                                    Modifica
                                @else
                                    Crea
                                @endif
                            </button>
                            <button type="reset"  title="Annulla" class="btn btn-secondary">Annulla</button>
                        </div>
                    </div>
                </div>
            </div>

            </form>
        </div> {{-- m-portlet --}}
    </div>{{-- col --}}
               
</div>{{-- row --}}
</div>{{-- content --}}


{{-- MODAL numeri fatture --}}
<div class="modal fade" id="m_modal_numeri_fattura" tabindex="-1" role="dialog" aria-labelledby="numeri_fattura" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            
            <div class="modal-header">
                <h5 class="modal-title" id="numeri_fattura">Numerazione precedente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <div class="modal-body" id="wrapper_last_numeri">
                @include('fatture._numeri_fatture')
            </div>

        </div>
    </div>
</div>
{{-- \MODAL elenco contatti --}}


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

            $('#m_datepicker_3').datepicker({
                format: 'dd/mm/yyyy',
                clearBtn:true,
                todayBtn:'linked',
            });
         
            $(".societa_fattura").click(function(e){
                e.preventDefault();
                $("#societa_id").val($(this).data("id"));
                $("#societa").val($(this).data("nome"));
                alert('Società '+$(this).data("nome")+ ' associata correttamente!\nPuoi chiudere il popup!')
            });


            $("#tipo_id").change(function(){
                jQuery.ajax({
                        url: '<?=url("last-fatture-ajax") ?>',
                        type: "post",
                        async: false,
                        data : { 
                               'tipo_id': this.value, 
                               '_token': jQuery('input[name=_token]').val()
                               },
                        success: function(data) {
                         $("#wrapper_last_numeri").html(data);
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
    <script src="{{ asset('js/bootstrap-datepicker.js') }}" type="text/javascript"></script>
@endsection