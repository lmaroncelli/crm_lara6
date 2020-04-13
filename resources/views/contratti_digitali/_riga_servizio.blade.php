<form id="formAddServizio">
  @csrf
  <div class="form-group row">

    @if ($servizio == 'SCONTO GENERICO')
      <div class="form-group col-lg-8">
        <label for="sconto">Sconto</label>
        <input class="form-control" id="sconto" type="text" name="sconto" placeholder="sconto per....." value="">
      </div>
    @else

      @if ($servizio == 'ALTRO')
        <div class="form-group col-lg-3">
          <label for="altro_servizio">Altro servizio</label>
          <textarea id="altro_servizio" class="form-control" name="altro_servizio" rows="5"></textarea>
        </div>     
      @else
        <div class="form-group col-lg-3">
          <label for="localita">Località</label>
          <select id="localita" class="form-control" name="localita">
            @foreach ($localita as $key => $loc)
              <option value="{{$key}}">{{$loc}}</option>
            @endforeach
          </select>
        </div>
      @endif
      <div class="form-group col-lg-2">
        <label for="dal">Dal</label>
        <input class="form-control" id="dal" type="text" name="dal" value="">
      </div>
      <div class="form-group col-lg-2">
        <label for="al">Al</label>
        <input class="form-control" id="al" type="text" name="al" value="">
      </div>

      <div class="form-group col-lg-1">
        <label for="qta">qta</label>
        <input class="form-control" id="qta" type="text" name="qta" value="">
      </div>

    @endif
    <div class="form-group col-lg-2">
      <label for="importo">Importo</label>
      <input class="form-control" id="importo" type="text" name="importo" value="">
    </div>

    <div class="form-group col-lg-1">
      <label style="display: block;">&nbsp;</label>
      <button type="button" class="btn btn-primary btn-sm" id="addRowServizio">add</button>
    </div>

    <div class="form-group col-lg-1">
      <label style="display: block;">&nbsp;</label>
      <button type="button" class="btn btn-danger btn-sm" id="closeRow">close</button>
    </div>
    <input type="hidden" name="idcontratto" value="{{ $idcontratto }}">
    <input type="hidden" name="servizio" value="{{ $servizio }}">
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
