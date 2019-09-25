<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}"></script>
    

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/sweetalert2.min.css') }}" rel="stylesheet">
</head>
<body class="app header-fixed sidebar-fixed aside-menu-fixed sidebar-lg-show">
  @include('layouts.coreui.header')
  
  
  <div class="app-body">

     @include('layouts.coreui.sidebar')
    
    <main class="main">
      <div class="container-fluid">
        <div class="row mt-4">
          <div class="col">
            
            <div class="card"> 
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
                @yield('content')
              </div>
            </div>
          
          </div>
        </div>
      </div>
    </main> {{-- end main   --}}
  
  </div> {{-- app-body  --}}

  @include('layouts.coreui.footer')
  
  <script src="{{ asset('js/sweetalert2.min.js') }}"></script>
  <script type="text/javascript">

    $(".delete").click(function(e){
      e.preventDefault();
      var id = $(this).data("id");
      if(window.confirm('Eliminare?')){
        $("form#delete_item_"+id).submit();
      }
    })

  </script>
  @yield('js')
</body>
</html>
