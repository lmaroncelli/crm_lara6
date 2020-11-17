<script type="text/javascript">
      
  jQuery(document).ready(function(){

    // click su ogni cella della griglia

    $('body').on('click', ".clickable:not(.acquistata_1)", function(e){

        e.preventDefault();

        @if (!session()->has('id_cliente') || !session()->has('id_agente'))
          
          alert('seleziona un cliente!');

        @else
          
          $(".spinner_lu").show();

          var elem = $(this);

          var id_evidenza = elem.attr("data-id-evidenza");
          var id_mese = elem.attr("data-id-mese");
          var data = {
            'id_agente': "{{ session('id_agente') }}",
            'id_cliente': "{{ session('id_cliente') }}",
            'id_evidenza': id_evidenza,
            'id_mese': id_mese
          }  

          $.ajax({
                    url: "{{ route('assegna-mese-evidenza-ajax') }}",
                    data: data,
                    success: function(msg) {
                        if (msg == 'ok') {
                          //location.reload();
                          elem.data('id-hotel',"{{ session('id_cliente') }}");
                          
                          var newclass = 'sfondo_'+ "{{ session('id_agente') }}";
                          elem.toggleClass("sfondo_0 "+newclass);

                          var elem_content = elem.find("div.contenuto_cella").html().trim();

                          if (elem_content == '') 
                            {
                            elem.find("div.contenuto_cella").html("{{ session('id_info') }}");
                            } 
                          else 
                            {
                            elem.find("div.contenuto_cella").html('');
                            }
                          $("#refresh").show();
                          $(".spinner_lu").hide();

                        } else {
                          $(".spinner_lu").hide();
                          window.alert(msg);
                        }
                    }
                });

        @endif

      });// end clickable:not(.acquistata_1)

      $('body').on('click', ".compra_evidenza", function(e){

          e.preventDefault();

          @if (!session('id_cliente') || !session('id_agente'))
            alert('selezionare il cliente'); return;
          @else

            $(".spinner_lu").show();
            
            var elem = $(this);
            var id_evidenza = elem.attr("data-id-evidenza");
            
            @if (isset($contratto))
              var contratto_id =  "{{$contratto->id}}";
            @else
              var contratto_id =  0;
            @endif


            var data = {
              'id_agente': "{{ session('id_agente') }}",
              'id_cliente': "{{ session('id_cliente') }}",
              'contratto_id':contratto_id,
              'id_evidenza': id_evidenza,
            }
            
            $.ajax({
                url: "{{ route('acquista-evidenza-ajax') }}",
                data: data,
                success: function(msg) {
                    if (msg == 'ok') {
                      //location.reload();
                      elem.toggleClass('btn-primary btn-warning');
                      elem.toggleClass('compra_evidenza evidenza_comprata');
                      elem.prop('value', 'COMPRATA');
                      $("#carica_servizi").val(1);
                      $("#refresh").show();
                      $(".spinner_lu").hide();
                    } else {
                      $(".spinner_lu").hide();
                      window.alert(msg);
                    }
                }
            });        

          @endif

        }); // end compra_evidenza


        $('body').on('click', ".clickable_prelazionata",function(e){

            e.preventDefault();

            @if (!session('id_cliente') || !session('id_agente'))
              alert('selezionare il cliente'); return;
            @else
              var elem = $(this);

              var id_hotel = elem.attr("data-id-hotel");
              var id_cliente_session = {{ session('id_cliente') }};

              if (id_cliente_session != id_hotel) {
                    
                alert('selezionare il cliente corretto!!'); 

                return;
              }

              $(".spinner_lu").show();
              
              var id_evidenza = elem.attr("data-id-evidenza");
              var id_mese = elem.attr("data-id-mese");
              
              var data = {
              'id_evidenza': id_evidenza,
              'id_mese': id_mese
              }  
              
              $.ajax({
                  url: "{{ route('disassocia-mese-evidenza-prelazione-ajax') }}",
                  data: data,
                  success: function(msg) {
                      if (msg == 'ok') {
                        //location.reload();
                        elem.removeClass("sfondo_prelazione");
                        elem.addClass("sfondo_0");
                        elem.removeClass("clickable_prelazionata");
                        elem.data('id-hotel','0');
                        elem.find("div.contenuto_cella").html('');
                        $("#refresh").show();
                        $(".spinner_lu").hide();
                      } else {
                        $(".spinner_lu").hide();
                        window.alert(msg);
                      }
                  }
              });        

            @endif

        }); // end clickable_prelazionata

        $('body').on('click', ".prelaziona_evidenza", function(e){

            e.preventDefault();

            @if (!session('id_cliente') || !session('id_agente'))
              alert('selezionare il cliente'); return;
            @else

              $(".spinner_lu").show();
              
              var elem = $(this);

              var id_evidenza = elem.attr("data-id-evidenza");
              
              var data = {
                'id_agente': "{{ session('id_agente') }}",
                'id_cliente': "{{ session('id_cliente') }}",
                'id_foglio_servizi': 0,
                'id_evidenza': id_evidenza,
              }
              
              $.ajax({
                  url: "{{ route('prelaziona-evidenza-ajax') }}",
                  data: data,
                  success: function(msg) {
                      if (msg == 'ok') {
                        //location.reload();
                        elem.toggleClass('btn-primary btn-warning');
                        elem.toggleClass('prelaziona_evidenza evidenza_prelazionata');
                        elem.prop('value', 'PRELAZIONATA');
                        $("#refresh").show();
                        $(".spinner_lu").hide();
                      } else {
                        $(".spinner_lu").hide();
                        window.alert(msg);
                      }
                  }
              });        

            @endif

        }); // end prelaziona_evidenza

  }); // end jQuery(document).ready


  </script>