<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/sweetalert2.min.css') }}" rel="stylesheet">

    {{-- jQuery Datepicker --}}
    <link href="{{ asset('css/jQueryDatepicker/jquery-ui.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/jQueryDatepicker/jquery-ui.structure.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/jQueryDatepicker/jquery-ui.theme.min.css') }}" rel="stylesheet">

</head>
<body class="app header-fixed sidebar-fixed aside-menu-fixed sidebar-lg-show">
  <div id="app">
  @include('layouts.coreui.header')
  
  
  <div class="app-body">

     @include('layouts.coreui.sidebar')

     
    <main class="main">
       @if (isset($bread))
        {!!Utility::breadcrumb($bread)!!}
      @endif
       @yield('breadcrump')
       <div class="container-fluid">
        <div class="row mt-4">
          <div class="col">
            
            <div class="card">
              @yield('card-header')
              <div class="card-body">
                @if ($errors->any())
                  <div class="row">
                    <div class="col-md-6 offset-md-3">
                      <div class="alert alert-danger">
                          <ul>
                              @foreach ($errors->all() as $error)
                                  <li>{{ $error }}</li>
                              @endforeach
                          </ul>
                      </div> 
                    </div>
                  </div>
                @endif
                @if (session('status'))
                  <div class="row">
                    <div class="col-md-6 offset-md-3">
                      <div class="alert alert-success">
                          {{ session('status') }}
                      </div>
                    </div>
                  </div>
                @endif
                @if (session('alert'))
                  <div class="row">
                    <div class="col-md-6 offset-md-3">
                      <div class="alert alert-danger">
                          {{ session('alert') }}
                      </div>
                    </div>
                  </div>
                @endif
                @yield('content')
              </div>
            </div>
          
          </div>
        </div>
      </div>
    </main> {{-- end main   --}}
  
  </div> {{-- app-body  --}}

  @include('layouts.coreui.footer')
  
  </div> {{-- #app --}}
  

 <!-- Scripts -->
  <script src="{{ mix('js/app.js') }}"></script>

  {{-- jQuery Datepicker --}}
  <script src="{{ asset('js/jQueryDatepicker/jquery-ui.min.js') }}"></script>
  <script src="{{ asset('js/jQueryDatepicker/datepicker-it.js') }}"></script>

  
  <script src="{{ asset('js/sweetalert2.min.js') }}"></script>

  <script type="text/javascript">


// initialize all tooltips on a page
    $(function () {
      $('[data-toggle="tooltip"]').tooltip()
    })

    // AJAX library automatically attach the CSRF token to every outgoing request.
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    $(".delete").click(function(e){
          e.preventDefault();
          var id = $(this).data("id");

          swal.fire({
            title: 'Sei sicuro?',
            text: "Operazione irreversibile!",
            type: 'question',
            showCancelButton: true,
            cancelButtonColor: '#c4c5d6',
            confirmButtonColor: '#d33',
            confirmButtonText: 'Sì, elimina!'
          }).then((result) => { 
                if (result.value) {
                  $("form#delete_item_"+id).submit();
                }
            })

    });



    $('.order').click(function(){
        var orderby = $(this).data("orderby");
        var order = $(this).data("order");
        $("#orderby").val(orderby);
        $("#order").val(order);
        $("#searchForm").submit();
    });

  </script>
  @yield('js')
  @yield('js_griglia_evidenze');

</body>
</html>
