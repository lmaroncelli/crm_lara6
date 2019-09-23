<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'LaraCRM') }}</title>
    
    <!--begin::Web font -->
    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
    <script>
        WebFont.load({
            google: {
                "families": ["Poppins:300,400,500,600,700", "Roboto:300,400,500,600,700"]
            },
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>

    <!--end::Web font -->

    <!--begin::Base Styles -->

    <!--begin::Page Vendors -->
    <link href="{{ asset('vendors/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet" type="text/css" />

    <!--RTL version:<link href="assets/vendors/custom/fullcalendar/fullcalendar.bundle.rtl.css" rel="stylesheet" type="text/css" />-->

    <!--end::Page Vendors -->
    <link href="{{ asset('vendors/base/vendors.bundle.css') }}" rel="stylesheet" type="text/css" />

    <!--RTL version:<link href="assets/vendors/base/vendors.bundle.rtl.css" rel="stylesheet" type="text/css" />-->
    <link href="{{ asset('css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet" type="text/css" />

    <!--end::Base Styles -->
    <link rel="shortcut icon" href="assets/demo/default/media/img/logo/favicon.ico" />
    
</head>
<!-- begin::Body -->
<body class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--fixed m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">

    <!-- begin:: Page -->
    <div class="m-grid m-grid--hor m-grid--root m-page">
        
        @include('layouts.header')
        
        <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">
            @include('layouts.left_menu')
        
            <div class="m-grid__item m-grid__item--fluid m-wrapper">
                @if ($errors->any() || session('status'))
                    <div class="row">
                        <div class="offset-lg-2 col-lg-8">

                            @if ($errors->any())
                                <div class="m-alert m-alert--icon m-alert--icon-solid m-alert--outline alert alert-danger alert-dismissible fade show" role="alert" style="margin-top:30px;">
                                    <div class="m-alert__icon">
                                        <i class="flaticon-exclamation-1"></i>
                                    </div>
                                    @foreach ($errors->all() as $error)
                                    <div class="m-alert__text" style="display: block; padding-top: 4px;  padding-bottom: 4px;">
                                        <strong>Errore!</strong> {{ $error }}.
                                    </div>
                                    @endforeach
                                    <div class="m-alert__close">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        </button>
                                    </div>
                                </div>
                            @endif

                            @if (session('status'))
                                <div class="m-alert m-alert--icon m-alert--outline alert alert-success alert-dismissible fade show" role="alert" style="margin-top:30px;">
                                    <div class="m-alert__icon">
                                        <i class="la la-warning"></i>
                                    </div>
                                    <div class="m-alert__text">
                                        <strong>Perfetto!</strong> {{ session('status') }}.
                                    </div>
                                    <div class="m-alert__close">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        </button>
                                    </div>
                                </div>
                            @endif

                        </div>
                    </div>
                @endif
                <div class="m-content">
                    @yield('content')
                </div>
            </div>
        </div>

        @include('layouts.footer')    

    </div>
    <!-- end:: Page -->

    @include('layouts.quick_sidebar')
    
    <!-- begin::Scroll Top -->
    <div id="m_scroll_top" class="m-scroll-top">
        <i class="la la-arrow-up"></i>
    </div>
    <!-- end::Scroll Top -->
    
    @include('layouts.quick_navbar')


    <!--begin::Base Scripts -->
    <script src="{{ asset('vendors/base/vendors.bundle.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/scripts.bundle.js') }}" type="text/javascript"></script>

    <!--end::Base Scripts -->

    <!--begin::Page Vendors -->
    <script src="{{ asset('vendors/custom/fullcalendar/fullcalendar.bundle.js') }}" type="text/javascript"></script>

    <!--end::Page Vendors -->

    <!--begin::Page Snippets -->
    <script src="{{ asset('js/dashboard.js') }}" type="text/javascript"></script>
    

    @yield('js')


    
</body>
</html>
