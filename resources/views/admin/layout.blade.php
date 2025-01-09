<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="au theme template">
    <meta name="author" content="Hau Nguyen">
    <meta name="keywords" content="au theme template">

    <!-- Title Page-->
    <title>Admin | @yield('title')</title>

    <!-- Fontfaces CSS-->
    <link href="{{ asset('public/admin_asset/css/font-face.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('public/admin_asset/vendor/font-awesome-4.7/css/font-awesome.min.css') }}" rel="stylesheet"
        media="all">
    <link href="{{ asset('public/admin_asset/vendor/font-awesome-5/css/fontawesome-all.min.css') }}" rel="stylesheet"
        media="all">
    <link href="{{ asset('public/admin_asset/vendor/mdi-font/css/material-design-iconic-font.min.css') }}"
        rel="stylesheet" media="all">

    <!-- Bootstrap CSS-->
    <link href="{{ asset('public/admin_asset/vendor/bootstrap-4.1/bootstrap.min.css') }}" rel="stylesheet"
        media="all">

    <!-- Vendor CSS-->
    <link href="{{asset('public/admin_asset/vendor/animsition/animsition.min.css')}}" rel="stylesheet" media="all">
    {{-- <link href="{{asset('public/admin_asset/vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css')}}" rel="stylesheet" media="all"> --}}
    {{-- <link href="{{asset('public/admin_asset/vendor/wow/animate.css')}}" rel="stylesheet" media="all"> --}}
    {{-- <link href="{{asset('public/admin_asset/vendor/css-hamburgers/hamburgers.min.css')}}" rel="stylesheet" media="all"> --}}
    {{-- <link href="{{asset('public/admin_asset/vendor/slick/slick.css')}}" rel="stylesheet" media="all"> --}}
    {{-- <link href="{{asset('public/admin_asset/vendor/select2/select2.min.css')}}" rel="stylesheet" media="all"> --}}
    {{-- <link href="{{asset('public/admin_asset/vendor/perfect-scrollbar/perfect-scrollbar.css')}}" rel="stylesheet" media="all"> --}}


    <!-- Main CSS-->
    <link href="{{ asset('public/admin_asset/css/theme.css') }}" rel="stylesheet" media="all">
    <!-- Additional CSS-->
    @stack('css')

</head>

<body class="animsition">
    <div class="page-wrapper">
        <!-- HEADER MOBILE-->
        <header class="header-mobile d-block d-lg-none">
            <div class="header-mobile__bar">
                <div class="container-fluid">
                    <div class="header-mobile-inner">
                        <a class="logo" href="#">
                            <img src="{{ asset('public/admin_asset/images/icon/logo.png') }}" alt="CoolAdmin" />
                        </a>
                        <button class="hamburger hamburger--slider" type="button">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
            <nav class="navbar-mobile">
                <div class="container-fluid">
                    <ul class="navbar-mobile__list list-unstyled">
                        <li>
                            <a href="{{ route('admin.dashboard') }}">
                                <i class="fas fa-tachometer-alt"></i>Dashboard</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <!-- END HEADER MOBILE-->

        <!-- MENU SIDEBAR-->
        <aside class="menu-sidebar d-none d-lg-block">
            <div class="logo">
                <a href="#">
                    <img src="{{ asset('public/admin_asset/images/icon/logo.png') }}" alt="Cool Admin" />
                </a>
            </div>
            <div class="menu-sidebar__content js-scrollbar1">
                <nav class="navbar-sidebar">
                    <ul class="list-unstyled navbar__list">
                        <li>
                            <a href="{{ route('admin.dashboard') }}">
                                <i class="fas fa-tachometer-alt"></i>Dashboard</a>
                        </li>

                        <li>
                            <a href="{{ route('admin.allUsers') }}">
                                <i class="fa fa-users"></i>Users
                            </a>
                        </li>
                        <li class="has-sub">
                            <a class="js-arrow" href="#">
                                <i class="fas fa-copy"></i>Category Manage</a>
                            <ul class="navbar-mobile-sub__list list-unstyled js-sub-list">
                                <li>
                                    <a href="{{route('admin.addCategory')}}">Category</a>
                                </li>
                                <li>
                                    <a href="#">Setting</a>
                                </li>
                                
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>
        <!-- END MENU SIDEBAR-->

        <!-- PAGE CONTAINER-->
        <div class="page-container">
            <!-- HEADER DESKTOP-->
            <header class="header-desktop">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="header-wrap">
                            <form class="form-header" action="" method="POST">

                            </form>
                            <div class="header-button">
                                <div class="account-wrap">
                                    <div class="account-item clearfix js-item-menu">
                                        <div class="image">
                                            <img src="{{ asset('public/admin_asset/images/icon/avatar-01.jpg') }}"
                                                alt="John Doe" />
                                        </div>
                                        <div class="content">
                                            <a class="js-acc-btn"
                                                href="#">{{ Auth::guard('admin')->user()->name ?? 'Guest User' }}</a>
                                        </div>
                                        <div class="account-dropdown js-dropdown">

                                            <div class="account-dropdown__body">
                                                <div class="account-dropdown__item">
                                                    <a href="#">
                                                        <i class="zmdi zmdi-account"></i>Account</a>
                                                </div>

                                                <div class="account-dropdown__item">
                                                    <a href="#">
                                                        <i class="zmdi zmdi-money-box"></i>Billing</a>
                                                </div>
                                            </div>
                                            <div class="account-dropdown__footer">
                                                <form id="admin-logout-form" action="{{ route('admin.logout') }}"
                                                    method="post" style="display: none;">
                                                    @csrf
                                                </form>
                                                <a href="#"
                                                    onclick="event.preventDefault(); document.getElementById('admin-logout-form').submit();">
                                                    <i class="zmdi zmdi-power"></i>Logout</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <!-- HEADER DESKTOP-->

            <!-- MAIN CONTENT-->
            <main>
                @yield('content')
            </main>

            <!-- END MAIN CONTENT-->
            <!-- END PAGE CONTAINER-->
        </div>

    </div>

    <!-- Jquery JS-->
    <script src="{{ asset('public/admin_asset/vendor/jquery-3.2.1.min.js') }}"></script>
    <!-- Bootstrap JS-->
    <script src="{{ asset('public/admin_asset/vendor/bootstrap-4.1/popper.min.js') }}"></script>
    <script src="{{ asset('public/admin_asset/vendor/bootstrap-4.1/bootstrap.min.js') }}"></script>
    <!-- Vendor JS       -->
    {{-- <script src="{{asset('public/admin_asset/vendor/slick/slick.min.js')}}"></script> --}}
    {{-- <script src="{{asset('public/admin_asset/vendor/wow/wow.min.js')}}"></script> --}}
    <script src="{{ asset('public/admin_asset/vendor/animsition/animsition.min.js') }}"></script>
    {{-- <script src="{{asset('public/admin_asset/vendor/bootstrap-progressbar/bootstrap-progressbar.min.js')}}"></script> --}}
    {{-- <script src="{{asset('public/admin_asset/vendor/counter-up/jquery.waypoints.min.js')}}"></script> --}}
    {{-- <script src="{{asset('public/admin_asset/vendor/counter-up/jquery.counterup.min.js')}}"></script> --}}
    {{-- <script src="{{asset('public/admin_asset/vendor/circle-progress/circle-progress.min.js')}}"></script> --}}
    {{-- <script src="{{asset('public/admin_asset/vendor/perfect-scrollbar/perfect-scrollbar.js')}}"></script> --}}
    {{-- <script src="{{asset('public/admin_asset/vendor/chartjs/Chart.bundle.min.js')}}"></script> --}}
    {{-- <script src="{{asset('public/admin_asset/vendor/select2/select2.min.js')}}"></script> --}}
    <!-- Main JS-->
    <script src="{{ asset('public/admin_asset/js/main.js') }}"></script>
    <script>
        function removeError(id) {
            var errElement = document.getElementById(id);
            if (errElement) {
                errElement.style.display = 'none'
            }
        }
    </script>
    <!-- For additional page-specific JS -->
    @stack('js')
</body>

</html>
<!-- end document-->
