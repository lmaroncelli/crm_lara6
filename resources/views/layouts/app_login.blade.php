<!DOCTYPE html>
<html lang="it">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="CoreUI - Open Source Bootstrap Admin Template">
    <meta name="author" content="Łukasz Holeczek">
    <meta name="keyword" content="Bootstrap,Admin,Template,Open,Source,jQuery,CSS,HTML,RWD,Dashboard">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Main styles for this application-->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
  </head>
  <body class="app flex-row align-items-center">
    <div class="container">
      @yield('content')
    </div>
    <script src="{{ mix('js/app.js') }}"></script>
    <!--[if IE]><!-->
    <script src="{{ mix('js/svgxuse.min.js') }}"></script>
    <!--<![endif]-->
  </body>
</html>