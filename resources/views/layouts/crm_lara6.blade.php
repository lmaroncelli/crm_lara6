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
</head>
<body class="app header-fixed sidebar-fixed aside-menu-fixed sidebar-lg-show">
  <header class="app-header navbar">
    <button class="navbar-toggler sidebar-toggler d-lg-none mr-auto" type="button" data-toggle="sidebar-show">
    <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="#">
      <img class="navbar-brand-full" src="img/brand/logo.svg" width="89" height="25" alt="CoreUI Logo">
      <img class="navbar-brand-minimized" src="img/brand/sygnet.svg" width="30" height="30" alt="CoreUI Logo">
    </a>
    <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button" data-toggle="sidebar-lg-show">
    <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="nav navbar-nav d-md-down-none">
      <li class="nav-item px-3">
      <a class="nav-link" href="#">Dashboard</a>
      </li>
      <li class="nav-item px-3">
      <a class="nav-link" href="#">Users</a>
      </li>
      <li class="nav-item px-3">
      <a class="nav-link" href="#">Settings</a>
      </li>
    </ul>
    <ul class="nav navbar-nav ml-auto">
      <li class="nav-item dropdown">
      <a class="nav-link nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
      <img class="img-avatar" src="img/avatars/6.jpg" alt="admin@bootstrapmaster.com">
      </a>
      <div class="dropdown-menu dropdown-menu-right">
      <div class="dropdown-header text-center">
      <strong>Account</strong>
      </div>
      <a class="dropdown-item" href="#">
      <i class="fa fa-lock"></i> Logout</a>
      </div>
      </li>
    </ul>
  </header>
  
  <div class="app-body">

    <div class="sidebar">
      <nav class="sidebar-nav">
        <ul class="nav">
          <li class="nav-title">Components</li>
            <li class="nav-item nav-dropdown">
              <a class="nav-link nav-dropdown-toggle" href="#">
              <i class="nav-icon icon-puzzle"></i> Base</a>
              <ul class="nav-dropdown-items">
                <li class="nav-item">
                <a class="nav-link" href="base/breadcrumb.html">
                <i class="nav-icon icon-puzzle"></i> Breadcrumb</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="base/cards.html">
                <i class="nav-icon icon-puzzle"></i> Cards</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="base/carousel.html">
                <i class="nav-icon icon-puzzle"></i> Carousel</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="base/collapse.html">
                <i class="nav-icon icon-puzzle"></i> Collapse</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="base/jumbotron.html">
                <i class="nav-icon icon-puzzle"></i> Jumbotron</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="base/list-group.html">
                <i class="nav-icon icon-puzzle"></i> List group</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="base/navs.html">
                <i class="nav-icon icon-puzzle"></i> Navs</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="base/pagination.html">
                <i class="nav-icon icon-puzzle"></i> Pagination</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="base/popovers.html">
                <i class="nav-icon icon-puzzle"></i> Popovers</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="base/progress.html">
                <i class="nav-icon icon-puzzle"></i> Progress</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="base/scrollspy.html">
                <i class="nav-icon icon-puzzle"></i> Scrollspy</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="base/switches.html">
                <i class="nav-icon icon-puzzle"></i> Switches</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="base/tabs.html">
                <i class="nav-icon icon-puzzle"></i> Tabs</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="base/tooltips.html">
                <i class="nav-icon icon-puzzle"></i> Tooltips</a>
                </li>
              </ul>
            </li>
        </ul>
      </nav>  
      <button class="sidebar-minimizer brand-minimizer" type="button"></button>
    </div> {{-- end sidebar  --}}
    <main class="main">
      @yield('content')
    </main> {{-- end main   --}}
  
  </div> {{-- app-body  --}}

  <footer class="app-footer">
    <div>
    <a href="https://coreui.io/pro/">CoreUI Pro</a>
    <span>© 2018 creativeLabs.</span>
    </div>
    <div class="ml-auto">
    <span>Powered by</span>
    <a href="https://coreui.io/pro/">CoreUI Pro</a>
    </div>
  </footer>
  
  @yield('js')
</body>
</html>
