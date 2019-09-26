@extends('layouts.coreui.crm_lara6')

@section('content')

@include('layouts.coreui.menu_sezioni_clienti') 

<div class="row">
  <div class="col-sm-2">
    <div class="callout callout-info b-t-1 b-r-1 b-b-1">
       Elenco società
      @if ($cliente->societa->count())
      <br>
      <strong class="h4">{{$cliente->societa->count()}}</strong>
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

@include('clienti-fatturazioni._lista_societa_cliente')


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
  
  @include('clienti-fatturazioni._js_modal')
    
@endsection