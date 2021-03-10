@extends('layouts.coreui.crm_lara6')

@section('content')

<div class="row">
    <div class="col-xl-12 sezioni-societa">

          @include('layouts.coreui.menu_sezioni_societa') 
            
            @if (isset($fatture))

              <div>
                  <table class="table table-responsive-sm m-table m-table--head-bg-success table-hover">
                      @include('societa._header_elenco_fatture')
                      @include('societa._elenco_fatture', ['fatture' => $fatture])
                  </table>
              </div>
            
            @else
                
              <div>
                  Nessuna fattura
              </div>
                
            @endif
            <hr>
            <hr>
            @if (isset($prefatture))

              <div>
                  <table class="table table-responsive-sm m-table m-table--head-bg-success table-hover">
                      @include('societa._header_elenco_fatture')
                      @include('societa._elenco_fatture', ['fatture' => $prefatture])
                  </table>
              </div>
            
            @else
                
              <div>
                  Nessuna fattura
              </div>
                
            @endif

            
            
    </div>
   
</div>

@endsection


@section('js')
    <script type="text/javascript" charset="utf-8">
        jQuery(document).ready(function(){
        });
    </script>
@endsection