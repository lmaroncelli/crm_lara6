<form id="formAddRow">
  @csrf
  <div class="form-group row">
    <div class="form-group col-lg-4">
      <label for="altro_servizio">Servizio</label>
      <textarea id="altro_servizio" class="form-control" name="altro_servizio" rows="5"></textarea>
    </div>
    <div class="form-group col-lg-2">
      <label for="dal">Dal</label>
      <input class="form-control" id="dal" type="text" name="dal" value="">
    </div>
    <div class="form-group col-lg-2">
      <label for="al">Al</label>
      <input class="form-control" id="al" type="text" name="al" value="">
    </div>

    <div class="form-group col-lg-1">
      <label style="display: block;">&nbsp;</label>
      <button type="button" class="btn btn-primary btn-sm" id="addRowSconto">add</button>
    </div>

    <div class="form-group col-lg-1">
      <label style="display: block;">&nbsp;</label>
      <button type="button" class="btn btn-danger btn-sm" id="delRowSconto">close</button>
    </div>

    <input type="hidden" name="idcontratto" value="<?php echo $idcontratto ?>">
    <input type="hidden" name="idservizio" value="<?php echo $servizio ?>">
  </div>
  <div id="response"></div>
</form>


<script>
  $( function() {
    
    $.datepicker.setDefaults( $.datepicker.regional[ "it" ] );

    var dateFormat = "dd/mm/yy",
      dal = $( "#dal" )
        .datepicker({
          defaultDate: "+0d",
          changeMonth: true,
          numberOfMonths: 1
        })
        .on( "change", function() {
          al.datepicker( "option", "minDate", getDate( this ) );
        }),
      al = $( "#al" ).datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        numberOfMonths: 1
      })
      .on( "change", function() {
        dal.datepicker( "option", "maxDate", getDate( this ) );
      });
 
    function getDate( element ) {
      var date;
      try {
        date = $.datepicker.parseDate( dateFormat, element.value );
      } catch( error ) {
        date = null;
      }
 
      return date;
    }
  } );
  </script>
