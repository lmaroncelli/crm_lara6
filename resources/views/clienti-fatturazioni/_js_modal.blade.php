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