<header class="app-header navbar">
  <button class="navbar-toggler sidebar-toggler d-lg-none mr-auto" type="button" data-toggle="sidebar-show">
  <span class="navbar-toggler-icon"></span>
  </button>
  <a class="navbar-brand" href="#">
    <img class="navbar-brand-full" src="{{ asset('images/logo.svg') }}" width="89" height="25" alt="CoreUI Logo">
    <img class="navbar-brand-minimized" src="{{ asset('images/sygnet.svg') }}" width="30" height="30" alt="CoreUI Logo">
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
    <img class="img-avatar" src="{{ asset('images/6.jpg') }}" alt="admin@bootstrapmaster.com">
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