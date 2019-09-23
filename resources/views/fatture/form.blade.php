@extends('layouts.lara_crm')

@section('content')

<div class="m-content">
<div class="row">
    <div class="col-xl-12">
        
        <div class="m-portlet">
            <div class="m-portlet__body m-portlet__body--no-padding">
                
                <div class="m-invoice-2">
                    <div class="m-invoice__wrapper">
                        
                        {{-- intestazione fattura --}}
                        @include('fatture._header_fattura')
                        

                        <div class="m-portlet m-portlet--creative m-portlet--first m-portlet--bordered-semi">
                            <div class="m-portlet__head">
                                <div class="m-portlet__head-caption">
                                    <div class="m-portlet__head-title">
                                        <span class="m-portlet__head-icon m--hide">
                                            <i class="flaticon-statistics"></i>
                                        </span>
                                        <h3 class="m-portlet__head-text">
                                            Associa/Dissocia le prefatture
                                        </h3>
                                        <h2 class="m-portlet__head-label m-portlet__head-label--info">
                                            <span>Prefatture</span>
                                        </h2>
                                    </div>
                                </div>
                            </div>
                            {{-- PREFATTURE DA ASSOCIARE --}}
                            @include('fatture._prefatture_da_associare')
                        </div>
                        
                        <div class="m-portlet m-portlet--creative m-portlet--first m-portlet--bordered-semi">
                            <div class="m-portlet__head">
                                <div class="m-portlet__head-caption">
                                    <div class="m-portlet__head-title">
                                        <span class="m-portlet__head-icon m--hide">
                                            <i class="flaticon-statistics"></i>
                                        </span>
                                        <h3 class="m-portlet__head-text">
                                            Aggiungi/modifica riga fattura
                                        </h3>
                                        <h2 class="m-portlet__head-label m-portlet__head-label--info">
                                            <span>Riga Fattura</span>
                                        </h2>
                                    </div>
                                </div>
                            </div>

                            {{-- form aggiunta servizio / riga di fatturazione --}}
                            @include('fatture._form_add_riga_fattura')
                          </div>  
                        
                        @if ($fattura->righe()->count())
                          <div class="m-portlet m-portlet--creative m-portlet--first m-portlet--bordered-semi">
                              <div class="m-portlet__head">
                                  <div class="m-portlet__head-caption">
                                      <div class="m-portlet__head-title">
                                          <span class="m-portlet__head-icon m--hide">
                                              <i class="flaticon-statistics"></i>
                                          </span>
                                          <h3 class="m-portlet__head-text">
                                              Elenco rghe di fatturazione
                                          </h3>
                                          <h2 class="m-portlet__head-label m-portlet__head-label--info">
                                              <span>Righe</span>
                                          </h2>
                                      </div>
                                  </div>
                              </div>
                              {{-- righe fatturazione --}}
                              @include('fatture._righe_fatturazione')
                          </div>
                        @endif


                        @if ($fattura->righe()->count())
                          <div class="m-portlet m-portlet--creative m-portlet--first m-portlet--bordered-semi">
                              <div class="m-portlet__head">
                                  <div class="m-portlet__head-caption">
                                      <div class="m-portlet__head-title">
                                          <span class="m-portlet__head-icon m--hide">
                                              <i class="flaticon-statistics"></i>
                                          </span>
                                          <h3 class="m-portlet__head-text">
                                              Totale ed eventuali note
                                          </h3>
                                          <h2 class="m-portlet__head-label m-portlet__head-label--info">
                                              <span>Totale</span>
                                          </h2>
                                      </div>
                                  </div>
                              </div>
                              {{-- footer fattura --}}
                              @include('fatture._footer_fattura_'.strtolower($fattura->tipo_id))
                          </div>
                        @endif


                        



                        @if ($fattura->righe()->count())

                          <div class="m-portlet m-portlet--creative m-portlet--first m-portlet--bordered-semi">
                              <div class="m-portlet__head">
                                  <div class="m-portlet__head-caption">
                                      <div class="m-portlet__head-title">
                                          <span class="m-portlet__head-icon m--hide">
                                              <i class="flaticon-statistics"></i>
                                          </span>
                                          @if ($fattura->scadenze->count())
                                          <h3 class="m-portlet__head-text">
                                              Elenco scadenze fattura
                                          </h3>
                                          @endif
                                          <h2 class="m-portlet__head-label m-portlet__head-label--info">
                                              <span>Scadenze</span>
                                          </h2>
                                      </div>
                                  </div>
                              </div>
                              
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
                        
                       
                        
                    </div> {{--  \wrapper --}}
                </div> {{-- "m-invoice-2 --}} 

          
            </div> {{-- m-portlet__body --}}
        </div>{{-- m-portlet --}}
    
    </div>{{-- col --}}       
</div>{{-- row --}}
</div>{{-- content --}}

{{-- MODAL elenco societa --}}
<div class="modal fade" id="m_modal_contatti" tabindex="-1" role="dialog" aria-labelledby="societa" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="societa">Elenco Società</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="m-scrollable m-scrollable--track m-scroller ps ps--active-y" data-scrollable="true" style="height: 400px; overflow: hidden;">
                <table class="table table-striped m-table m-table--head-bg-success">
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


            $(".fatture_prefatture").click(function(){
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
                             '_token': jQuery('input[name=_token]').val()
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