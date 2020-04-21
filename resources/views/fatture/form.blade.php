@extends('layouts.coreui.crm_lara6')


<div class="spinner_lu intestazione" style="display:none;"></div>
@section('card-header')
    <div class="card-header">
        {{ App\Utility::getNomeTipoFattura($fattura->tipo_id) }} N° <strong>{{$fattura->tipo_id == 'PF' ? $fattura->numero_prefattura : $fattura->numero_fattura}}</strong> - Data: <strong>{{ $fattura->data->format('d/m/Y') }}</strong> - 
        Metodo di pagamento:
        <select id="pagamento_id" name="pagamento_id" class="pagamento_card_header">
          @foreach ($tipo_pagamento as $key => $value)
              <option value="{{$key}}" @if ( $fattura->pagamento_id == $key ) selected="selected" @endif>{{$value}}</option>
          @endforeach
      </select> 
        {{-- <strong>{{App\Utility::getPagamentoFattura($fattura->pagamento_id)}}</strong> --}}
    </div>
@endsection

@section('content')

<div class="row mt-1">
    <div class="col-md-12 sezioni-fattura">
        
            
            {{-- intestazione fattura --}}
            @include('fatture._header_fattura')
            
            <hr>

            <div class="">
                <h3>Associa/Dissocia le prefatture</span></h3>
                  
                {{-- PREFATTURE DA ASSOCIARE --}}
                @include('fatture._prefatture_da_associare')
            </div>

            <hr>

            
            <div class="">
                <h3>Aggiungi/modifica riga fattura</h3>

                {{-- form aggiunta servizio / riga di fatturazione --}}
                @include('fatture._form_add_riga_fattura')
            </div>  
            
            @if ($fattura->righe()->count())
            <div class="">
                <h3>Elenco rghe di fatturazione</h3>
                
                {{-- righe fatturazione --}}
                @include('fatture._righe_fatturazione')
            </div>
            @endif


            @if ($fattura->righe()->count())
            <div class="">
                <h3>Totale ed eventuali note</h3>
            
                {{-- footer fattura --}}
                @include('fatture._footer_fattura_'.strtolower($fattura->tipo_id))
            </div>
            @endif


            



            @if ($fattura->righe()->count())

                <div class="">
                    
                    @if ($fattura->scadenze->count())
                    <h3>Elenco scadenze fattura</h3>
                    @endif
                     
                    @if (!$fattura->fatturaChiusa())
                        {{-- Scadenze fattura --}}
                        @include('fatture._form_add_scadenza_fattura')
                    @endif
                    
                    {{-- elenco righe scadenze --}}
                    @include('fatture._elenco_scadenze')
                    
                    @if($fattura->fatturaChiusa())
                    {{-- Avviso Fattura chiusa --}}
                    <div class="row">
                        <div class="col-lg-6 offset-lg-3">
                        <div class="alert alert-danger" role="alert">
                            <strong>Perfetto!</strong> La fattura è chiusa.
                        </div>
                        </div>
                    </div>
                    @endif
                </div>  
            @endif
            
    </div>{{-- col --}}       
</div>{{-- row --}}




{{-- MODAL elenco societa --}}
<div class="modal fade" id="m_modal_societa" tabindex="-1" role="dialog" aria-labelledby="societa" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="societa">Elenco Società</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-striped">
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
                            <tr>
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


        function cambiaIntestazione(societa_id)
          {
          var societa_id = societa_id;
              
          jQuery.ajax({
                  url: '<?=url("cambia-intestazione-fattura-ajax") ?>',
                  type: "post",
                  async: false,
                  data : { 
                          'societa_id': societa_id,
                          'fattura_id': '{{$fattura->id}}'
                          },
                  success: function(data) {
                      if(data=='ko') {
                        alert('Errore. La fattura non esiste!')
                      } else {
                        $("#intestazione_cambiata").val(1);
                        alert("Società "+ data + " associata correttamente!\nPuoi chiudere il popup!");
                      }                      
                  }
          });
         
          }
        
    
        jQuery(document).ready(function(){


            $("#pagamento_id").change(function(e){
                var pagamento_id = $(this).val();
                jQuery.ajax({
                    url: '<?=url("cambia-pagamento-fattura-ajax") ?>',
                    type: "post",
                    data : { 
                            'pagamento_id': pagamento_id,
                            'fattura_id': '{{$fattura->id}}'
                            },
                    success: function(data) {
                        if(data=='ko') {
                          alert('Errore. La fattura non esiste!')
                        } else {
                          alert("Pagamento cambiato correttamente");
                        }                      
                    }
                });
            }); /*pagamento_id").change*/



            // checkbox associa/dissocia prefatture
            $(".fatture_prefatture").change(function() {
                $(".spinner_lu.prefatture").show();

                var prefattura_id = $(this).val();
                var associa = this.checked;
                
                jQuery.ajax({
                        url: '<?=url("associa-fattura-prefattura-ajax") ?>',
                        type: "post",
                        data : { 
                               'prefattura_id': prefattura_id,
                               'fattura_id': '{{$fattura->id}}',
                               'associa': associa
                               },
                        success: function(data) {
                            $(".spinner_lu.prefatture").hide();
                            if(data=='ko') {
                                alert('Errore. La fattura non esiste!')
                            }
                       }
                 });
            }); /*.fatture_prefatture").change*/






            $('#m_datepicker_3').datepicker({
                format: 'dd/mm/yyyy',
                clearBtn:true,
                todayBtn:'linked',
            });
         
            $(".societa_fattura").click(function(e){
                e.preventDefault();
                var societa_id = $(this).data("id");

                cambiaIntestazione(societa_id);
                 
            });


            $(".close").click(function(){
              var intestazione_cambiata = $("#intestazione_cambiata").val();
              console.log('intestazione_cambiata = '+intestazione_cambiata);
              if( intestazione_cambiata == 1 ) {
                window.alert('La pagina si riaggiorna per visualizzare le modifiche effettuate!');
                $(".spinner_lu.intestazione").show();
                location.reload();
              }
            });


            /* aggiornamento degli ultimi numeroìi in base al tipo di fattura */
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


            /* aggiornamento della riga di fatturazione */
            $(".trigger_row").blur(function(){
                var qta = $("#qta").val();
                var prezzo = $("#prezzo").val();
                var al_iva = $("#al_iva").val();
                if(qta != '' && prezzo != '' && !isNaN(qta) && !isNaN(prezzo))
                  {
                  var totale_netto = qta*prezzo;
                  var iva = totale_netto*al_iva/100;
                  var totale = totale_netto + iva;
                  if(!isNaN(totale_netto) && !isNaN(iva) && !isNaN(totale)) 
                    {
                    $("#totale_netto").val(totale_netto);
                    $("#iva").val(iva);
                    $("#totale").val(totale);
                    }
                  }
            });


            $("#servizi").select2({placeholder:"Seleziona i servizi da fatturare"});


            function servizi_select_to_servizio_text()
              {
                var servizi_ids = $("#servizi").val();

                var selText = [];
                $("#servizi option:selected").each(function () {
                   var $this = $(this);
                   if ($this.length) {
                    selText.push($this.text());
                   }
                });

                $("#prefill").html(' <textarea name="servizio" class="form-control m-input m-input--air m-input--pill" id="servizio" rows="4">' + selText.join("\n") + '</textarea> <input type="hidden" name="servizi" value="'+ servizi_ids +'">');
                $("#reset_servizi").show();
              }


            $(".add_servizi").click(function(e){
                e.preventDefault();

                servizi_select_to_servizio_text();
               
            });


            $("#riga_fattura_form").submit(function(){
                servizi_select_to_servizio_text();
            });


            $(".fatture_prefatture_OLD").click(function(){
              var prefattura_id = $(this).val();
              var associa = this.checked;

              //console.log('prefattura_id = '+prefattura_id);
              //console.log('associa = '+associa);

              jQuery.ajax({
                      url: '<?=url("/fatture-prefatture-ajax") ?>',
                      type: "post",
                      async: false,
                      datatype: 'json',
                      data : { 
                             'prefattura_id': prefattura_id, 
                             'fattura_id':{{$fattura->id}},
                             'associa': associa,
                             },
                      success: function(msg) {
                       //console.log(msg);
                       var msg = JSON.parse(msg);
                        swal({
                          type: msg.type,
                          title: msg.title,
                          text: msg.text
                        })
                      }
               });

            });



            $(".delete").click(function(e){
              e.preventDefault();
              swal({
                title: 'Sei sicuro?',
                text: "Operazione irreversibile!",
                type: 'question',
                showCancelButton: true,
                cancelButtonColor: '#c4c5d6',
                confirmButtonColor: '#d33',
                confirmButtonText: 'Sì, elimina!'
              }).then((result) => { 
                    if (result.value) {
                     //$("#delete-riga-form").submit();
                     $(this).closest("form.deleteForm").submit();
                    }
                })

            });


        });
    

    </script>
    <script src="{{ asset('js/bootstrap-datepicker.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/select2.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/sweetalert2.js') }}" type="text/javascript"></script>

@endsection