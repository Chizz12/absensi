<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport"
        content="width=device-width, initial-scale=1, maximum-scale=1, viewport-fit=cover, shrink-to-fit=no">
    <meta name="description" content="Suha - Multipurpose Ecommerce Mobile HTML Template">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="theme-color" content="#100DD1">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <!-- The above tags *must* come first in the head, any other head content must come *after* these tags-->
    <!-- Title-->
    <title>Absensi</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&amp;display=swap">
    <!-- Favicon-->
    <link rel="icon" href="/assets/img/logo.png">
    <!-- Apple Touch Icon-->
    <link rel="apple-touch-icon" href="/assets/img/logo.png">

    <!-- CSS Libraries-->
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/animate.css">
    <link rel="stylesheet" href="/assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="/assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="/assets/css/default/lineicons.min.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Stylesheet-->
    <link rel="stylesheet" href="/assets/style.css">
    @stack('styles')
    <style>
        body.shimeji-pinned iframe {
            pointer-events: none;
        }

        body.shimeji-select-ie {
            cursor: cell !important;
        }

        #shimeji-contextMenu::-webkit-scrollbar {
            width: 6px;
        }

        #shimeji-contextMenu::-webkit-scrollbar-thumb {
            background-color: rgba(30, 30, 30, 0.6);
            border-radius: 3px;
        }

        #shimeji-contextMenu::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
    </style>
    <meta name="shimejiBrowserExtensionId" content="gohjpllcolmccldfdggmamodembldgpc" data-version="2.0.5">
</head>

<body>
    <!-- Preloader-->
    <div class="overlay" style="display: none;"></div>

    <!-- Header Area-->
    <div class="header-area" id="headerArea">
        <div class="container h-100 d-flex align-items-center justify-content-between">
            <!-- Logo Wrapper-->
            @stack('header')

            <!-- Search Form-->
            <!--<div class="top-search-form">
          <form action="" method="">
            <input class="form-control" type="search" placeholder="Enter your keyword">
            <button type="submit"><i class="fa fa-search"></i></button>
          </form>
        </div>-->

            <!-- Navbar Toggler-->
            <div class="suha-navbar-toggler d-flex flex-wrap" id="suhaNavbarToggler">
                <span></span><span></span><span></span>
            </div>
        </div>
    </div>
    @guest
    @else
        <!-- Sidenav Black Overlay-->
        <div class="sidenav-black-overlay"></div>
        <!-- Side Nav Wrapper-->
        <div class="suha-sidenav-wrapper" id="sidenavWrapper">
            <!-- Sidenav Profile-->
            <div class="sidenav-profile">

                <div class="user-profile"><img src="{{ asset('assets/img/avatar-profile.png') }}" alt="">
                </div>
                <div class="user-info">
                    <h6 class="user-name mb-0">
                        {{ ucwords(strtoupper(preg_split('/[\s_]+/', Auth::user()->member->nama)[0])) }}{{ ' (' . Auth::user()->member->id_member . ')' }}
                    </h6>
                </div>
            </div>
            <!-- Sidenav Nav-->
            <ul class="sidenav-nav ps-0">
                <li><a href="#"><i class="lni lni-user"></i>Profil Ku</a>
                </li>
                <li><a href="#"><i class="lni lni-cog"></i>Pengaturan</a>
                </li>
                <li><a href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"><i
                            class="lni lni-power-switch"></i>Keluar</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>

            </ul>
            <!-- Go Back Button-->
            <div class="go-home-btn" id="goHomeBtn"><i class="lni lni-arrow-left"></i></div>
        </div>
    @endguest

    @if (session('info'))
        <!-- PWA Install Alert-->
        <div class="toast pwa-install-alert shadow bg-white" role="alert" aria-live="assertive" aria-atomic="true"
            data-bs-delay="5000" data-bs-autohide="true">
            <div class="toast-body">
                <div class="content d-flex align-items-center mb-2"><img src="/assets/img/tms.png" alt="">
                    <h6 class="mb-0">INFO</h6>
                    <button class="btn-close ms-auto" type="button" data-bs-dismiss="toast"
                        aria-label="Close"></button>
                </div><span class="mb-0 d-block">{{ session('info') }}</span>
            </div>
        </div>
    @endif
    <div class="page-content-wrapper">
        @yield('content')

    </div>

    @stack('modals')

    @stack('scripts')

    <script src="/assets/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/jquery.min.js"></script>
    <script src="/assets/js/waypoints.min.js"></script>
    <script src="/assets/js/jquery.easing.min.js"></script>
    <script src="/assets/js/owl.carousel.min.js"></script>
    <script src="/assets/js/jquery.counterup.min.js"></script>
    <script src="/assets/js/jquery.countdown.min.js"></script>
    <script src="/assets/js/default/jquery.passwordstrength.js"></script>
    <script src="/assets/js/default/dark-mode-switch.js"></script>
    <script src="/assets/js/default/no-internet.js"></script>
    <script src="/assets/js/default/active.js"></script>
    <script src="/assets/js/pwa.js"></script>
    <!-- Internet Connection Status-->
    <div class="internet-connection-status" id="internetStatus"></div>
    <!-- Footer Nav-->
    <div class="footer-nav-area" id="footerNav">
        <div class="container h-100 px-0">
            <div class="suha-footer-nav h-100">
                <ul class="h-100 d-flex align-items-center justify-content-between ps-0">
                    <li class="active"><a href="{{ route('home') }}"><i
                                class="lni lni-home"></i>Beranda</a></li>
                    <li><a href="#"><i
                                class="lni lni-life-ring"></i>Dukungan</a></li>
                    <li><a href="#"><i
                                class="lni lni-cog"></i>Pengaturan</a></li>
                </ul>
            </div>
        </div>
    </div>
    <!-- All JavaScript Files-->


    <div id="shimeji-workArea"
        style="position: fixed; background: transparent; z-index: 2147483643; width: 100vw; height: 100vh; left: 0px; top: 0px; transform: translate(0px, 0px); pointer-events: none;">
    </div>
</body>

</html>
