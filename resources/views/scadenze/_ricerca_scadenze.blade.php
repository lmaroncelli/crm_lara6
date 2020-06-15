<form action="{{ url('scadenze/') }}" method="get" id="searchForm" accept-charset="utf-8">
    <input type="hidden" name="orderby" id="orderby" value="">
    <input type="hidden" name="order" id="order" value="">
    
    
    <div class="row p-3">
              
      <div class="col-md-3">
        <select class="form-control m-select2" id="pagamento" name="pagamento">
          <option></option>
          <optgroup label="Seleziona un pagamento">
          @foreach ($pagamenti_fattura as $id => $nome)
            @if (\Request::has('pagamento'))
              <option value="{{$id}}" @if ( in_array($id, \Request::get('pagamento')) ) selected="selected" @endif>{{$nome}}</option>
            @else
              <option value="{{$id}}">{{$nome}}</option>
            @endif
          @endforeach
          </optgroup>
        </select>
      </div>
      
      <div class="col-md-1">
          <button type="button" class="btn btn-pill btn-success searching">Cerca</button>      
      </div>

    
    </div>

    

    
</form>

<script>
  $( function() {
    
    $.datepicker.setDefaults( $.datepicker.regional[ "it" ] );

    var dateFormat = "dd/mm/yy",
      inizio = $( "#inizio" )
        .datepicker({
          defaultDate: "-1y",
          changeMonth: true,
          changeYear: true,
          numberOfMonths: 1
        })
        .on( "change", function() {
          scadenza.datepicker( "option", "minDate", getDate( this ) );
        }),
      scadenza = $( "#scadenza" ).datepicker({
        defaultDate: "+0d",
        changeMonth: true,
        changeYear: true,
        numberOfMonths: 1
      })
      .on( "change", function() {
        inizio.datepicker( "option", "maxDate", getDate( this ) );
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