@extends('layouts.coreui.crm_lara6')


@section('card-header')
    <div class="card-header">
        <h3>Nuovo documento</h3>
    </div>
@endsection


@section('content')

<div class="row">
    <div class="col-xl-12">
       
    <form action="{{ route('fatture.store') }}" method="POST" enctype="multipart/form-data">            
        {!! csrf_field() !!}
        <input type="hidden" name="societa_id" id="societa_id" value="{{old('societa_id')}}">

        {{-- Tipo-Societa --}}
        <div class="form-group row">

            <label class="col-xl-1 col-form-label" for="attivo">Tipo:</label>
            
            <select class="form-control col-xl-4" id="tipo_id" name="tipo_id">
                @foreach ($tipo_fattura as $key => $value)
                    <option value="{{$key}}" @if ( $fattura->tipo_id == $key || old('tipo_id') != null ) selected="selected" @endif>{{$value}}</option>
                @endforeach
            </select>

            <label for="societa" class="col-xl-1 col-form-label">Societa:</label>
            
            <input type="text" name="societa" id="societa" value="{{ old('societa') != '' ?  old('societa') : optional(optional($fattura->societa)->ragioneSociale)->nome }}"  class="form-control col-xl-4 mr-1" placeholder="Societa" readonly="readonly">
            
            <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#m_modal_contatti">Società</button>
        </div>

        {{-- numero-Data --}}
        <div class="form-group row">

            <label class="col-xl-1 col-form-label" for="numero">Numero:</label>
            
            <div class="col-xl-2">
                <input type="text" name="numero" id="numero" value="{{ old('numero') != '' ?  old('numero') : $fattura->numero}}"  class="form-control mr-1" placeholder="Numero">
            </div>

            <div class="col-xl-1">
            <button type="button" class="btn btn-warning" data-toggle="modal" data-keyboard="false" data-backdrop="static" data-target="#m_modal_numeri_fattura">Ultimi</button>
            </div>

            <label class="col-xl-1 col-form-label" for="tipo_id">Data:</label>

            <div class="col-xl-2">
                <div class="input-group date">
                    <input type="text" name="data" class="form-control" readonly value="{{Carbon\Carbon::today()->format('d/m/Y')}}" id="m_datepicker_3" />
                    <div class="input-group-append">
                        <span class="input-group-text">
                            <i class="fa fa-calendar"></i>
                        </span>
                    </div>
                </div>
            </div>
            {{-- \numero-Data --}}
            {{-- tipo pagamento --}}
            <label class="col-xl-1 col-form-label" for="attivo">Pagamento:</label>

            <div class="col-xl-4">
                <select class="form-control" id="pagamento_id" name="pagamento_id">
                    @foreach ($tipo_pagamento as $key => $value)
                        <option value="{{$key}}" @if ( $fattura->pagamento_id == $key || old('pagamento_id') != null ) selected="selected" @endif>{{$value}}</option>
                    @endforeach
                </select>
            </div>

        </div>

        <button type="submit" class="btn btn-success">
            @if ($fattura->exists)
                Modifica
            @else
                Crea
            @endif
        </button>
        <button type="reset"  title="Annulla" class="btn btn-secondary">Annulla</button>

        </form>
    </div>{{-- col --}}               
</div>{{-- row --}}


{{-- MODAL numeri fatture --}}
<div class="modal fade" id="m_modal_numeri_fattura" tabindex="-1" role="dialog" aria-labelledby="numeri_fattura" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
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


{{-- MODAL elenco contatti --}}
<div class="modal fade" id="m_modal_contatti" tabindex="-1" role="dialog" aria-labelledby="contatti" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
            <div class="col-xl-3" style="margin-top: 10px">
                <h5 class="modal-title" id="societa">Elenco Società </h5>
            </div>
            <span style="margin-top: 10px" class="col-xl-1" id="n_societa">{{$ragioneSociale->count()}}</span>
            <div class="col-xl-6">
                <input id="myInput" type="text" class="form-control" placeholder="scrivi per filtrare">
            </div>
            <div class="col-xl-1">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
        <div class="modal-body">
          <table class="table table-striped" id="tabellaSocieta">
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