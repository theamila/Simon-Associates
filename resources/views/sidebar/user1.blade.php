<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title')</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('admin/assets/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendors/css/vendor.bundle.base.css') }}">

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="{{ asset('admin/assets/css/style.css') }}">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="{{ asset('admin/assets/images/favicon.ico') }}" />
</head>

<body>
    @extends('sidebar.preloader')

    <div class="container-scroller">

        <!-- partial:partials/_navbar.html -->
        <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
            <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
                <a class="navbar-brand brand-logo" href=""><h3 class="text-muted">
                    Dashboard</h3></a>
                <a class="navbar-brand brand-logo-mini" href="#"><img
                        src="{{ asset('admin/assets/images/logo-mini.svg') }}" alt="logo" /></a>
            </div>
            <div class="navbar-menu-wrapper d-flex align-items-stretch">
                <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                    <span class="mdi mdi-menu"></span>
                </button>
                <div class="search-field d-none d-md-block">
                    <form class="d-flex align-items-center h-100" action="#">
                        <div class="input-group">
                            <div class="input-group-prepend bg-transparent">
                                <i class="input-group-text border-0 mdi mdi-magnify"></i>
                            </div>
                            <input type="text" class="form-control bg-transparent border-0"
                                placeholder="Search projects">
                        </div>
                    </form>
                </div>
                <ul class="navbar-nav navbar-nav-right">
                    <li class="nav-item nav-profile dropdown">
                        <a class="nav-link dropdown-toggle" id="profileDropdown" href="#"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="nav-profile-img">
                                <img src="{{ asset('admin/assets/images/faces/face1.jpg') }}" alt="image">
                                <span class="availability-status online"></span>
                            </div>
                            <div class="nav-profile-text">
                                <p class="mb-1 text-black">{{ Auth::user()->name }}</p>
                            </div>
                        </a>
                        <div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">
                            <a class="dropdown-item" href="#">
                                <i class="mdi mdi-cached me-2 text-success"></i> Activity Log </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ Route('logout') }}">
                                <i class="mdi mdi-logout me-2 text-primary"></i> Signout </a>
                        </div>
                    </li>
                    <li class="nav-item d-none d-lg-block full-screen-link">
                        <a class="nav-link">
                            <i class="mdi mdi-fullscreen" id="fullscreen-button"></i>
                        </a>
                    </li>


                    <li class="nav-item nav-logout d-none d-lg-block">
                        <a class="nav-link" href="#">
                            <i class="mdi mdi-power"></i>
                        </a>
                    </li>
                    <li class="nav-item nav-settings d-none d-lg-block">
                        <a class="nav-link" href="#">
                            <i class="mdi mdi-format-line-spacing"></i>
                        </a>
                    </li>
                </ul>
                <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
                    data-toggle="offcanvas">
                    <span class="mdi mdi-menu"></span>
                </button>
            </div>
        </nav>
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_sidebar.html -->
            <nav class="sidebar sidebar-offcanvas shadow" id="sidebar">
                <ul class="nav">
                    <li class="nav-item nav-profile">
                        <a href="#" class="nav-link">
                            <div class="nav-profile-image">
                                <img src="{{ asset('admin/assets/images/faces/face1.jpg') }}" alt="profile">
                                <span class="login-status online"></span>
                                <!--change to offline or busy as needed-->
                            </div>
                            <div class="nav-profile-text d-flex flex-column">
                                <span class="font-weight-bold mb-2">{{ Auth::user()->name }}</span>
                                <span class="text-secondary text-small">{{ Auth::user()->roleName() }}</span>
                            </div>
                            <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ Route('dashboard') }}">
                            <span class="menu-title">Dashboard</span>
                            <i class="mdi mdi-home menu-icon"></i>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('Company-register') }}">
                            <span class="menu-title">Registration</span>
                            <i class="material-symbols-outlined menu-icon mdi">
                                domain_add
                            </i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('new-invoice') }}">
                            <span class="menu-title">New Invoice</span>
                            <i class="material-symbols-outlined menu-icon">
                                add
                            </i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('ongoing-invoice') }}">
                            <span class="menu-title">Ongoing Invoice</span>
                            <i class="material-symbols-outlined menu-icon ">
                                hourglass_top
                            </i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('Approved-invoice') }}">
                            <span class="menu-title">Approved Invoices</span>
                            <i class="material-symbols-outlined menu-icon">
                                order_approve
                            </i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('Outstanding-invoice') }}">
                            <span class="menu-title">Outstanding</span>
                            <i class="material-symbols-outlined menu-icon">
                                schedule
                            </i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('Receipt') }}">
                            <span class="menu-title">Receipts</span>
                            <i class="material-symbols-outlined mdi menu-icon">
                                receipt_long
                            </i>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('allInvoice') }}">
                            <span class="menu-title">All Invoices</span>
                            <i class="material-symbols-outlined mdi menu-icon">
                                receipt_long
                            </i>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('rejectInvoice') }}">
                            <span class="menu-title">Rejected Invoices</span>
                            <i class="material-symbols-outlined mdi menu-icon">
                                thumb_down
                            </i>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="/aging/report/user">
                            <span class="menu-title">Aging Report</span>
                            <i class="material-symbols-outlined mdi menu-icon">monitoring</i>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('logout') }}">
                            <span class="menu-title">Log Out</span>
                            <i class="material-symbols-outlined menu-icon">
                                logout
                            </i>
                        </a>
                    </li>
                    <!-- <li class="nav-item">
              <a class="nav-link" data-bs-toggle="collapse" href="#general-pages" aria-expanded="false" aria-controls="general-pages">
                <span class="menu-title">Sample Pages</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-medical-bag menu-icon"></i>
              </a>
              <div class="collapse" id="general-pages">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item"> <a class="nav-link" href="pages/samples/blank-page.html"> Blank Page </a></li>
                  <li class="nav-item"> <a class="nav-link" href="pages/samples/login.html"> Login </a></li>
                  <li class="nav-item"> <a class="nav-link" href="pages/samples/register.html"> Register </a></li>
                  <li class="nav-item"> <a class="nav-link" href="pages/samples/error-404.html"> 404 </a></li>
                  <li class="nav-item"> <a class="nav-link" href="pages/samples/error-500.html"> 500 </a></li>
                </ul>
              </div>
            </li> -->

                </ul>
            </nav>
            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header">
                        <h3 class="page-title">
                            <span class="page-title-icon bg-gradient-primary text-white me-2">
                                <i class="mdi mdi-home"></i>
                            </span> @yield('pageTitle')
                        </h3>
                        <nav aria-label="breadcrumb">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item active" aria-current="page">
                                    <span></span>Overview <i
                                        class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
                                </li>
                            </ul>
                        </nav>
                    </div>

                    <div class="row">
                        <div class="col-md-4 stretch-card grid-margin">
                            <div class="card bg-gradient-success card-img-holder text-white shadow">
                                <div class="card-body">
                                    <img src="{{ asset('admin/assets/images/dashboard/circle.svg') }}"
                                        class="card-img-absolute" alt="circle-image" />
                                    <h4 class="font-weight-normal mb-3">@yield('f-state')
                                        @yield('f-icon')
                                    </h4>
                                    <h2 class="mb-5">@yield('f-state-c')</h2>
                                    {{-- <h6 class="card-text">Increased by 60%</h6> --}}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 stretch-card grid-margin">
                            <div class="card bg-gradient-primary card-img-holder text-white shadow">
                                <div class="card-body">
                                    <img src="{{ asset('admin/assets/images/dashboard/circle.svg') }}"
                                        class="card-img-absolute" alt="circle-image" />
                                    <h4 class="font-weight-normal mb-3">@yield('s-state') @yield('s-icon')
                                    </h4>
                                    <h2 class="mb-5">@yield('s-state-c')</h2>
                                    {{-- <h6 class="card-text">Decreased by 10%</h6> --}}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 stretch-card grid-margin">
                            <div class="card bg-gradient-danger card-img-holder text-white shadow">
                                <div class="card-body">
                                    <img src="{{ asset('admin/assets/images/dashboard/circle.svg') }}"
                                        class="card-img-absolute" alt="circle-image" />
                                    <h4 class="font-weight-normal mb-3">@yield('t-state') @yield('t-icon')
                                    </h4>
                                    <h2 class="mb-5">@yield('t-state-c')</h2>
                                    {{-- <h6 class="card-text">Increased by 5%</h6> --}}
                                </div>
                            </div>
                        </div>
                    </div>

                    @yield('Recent')

                    <div class="row">
                        <div class="col-12 grid-margin">
                            <div class="card shadow" style="border-radius: 15px;">
                                <div class="card-body">
                                    <h4 class="card-title">@yield('Ttopic')</h4>
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    @yield('thead')
                                                </tr>
                                            </thead>
                                            <tbody>

                                                @yield('tbody')

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="d-flex justify-content-center mt-4">
                        <nav>
                            <ul class="pagination">
                                <li class="page-item {{ $data->currentPage() == 1 ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $data->previousPageUrl() }}"
                                        aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                                @for ($i = 1; $i <= $data->lastPage(); $i++)
                                    <li class="page-item {{ $data->currentPage() == $i ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $data->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endfor
                                <li
                                    class="page-item {{ $data->currentPage() == $data->lastPage() ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $data->nextPageUrl() }}" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>

                    @yield('content')


                </div>
                <!-- content-wrapper ends -->
                <!-- partial:partials/_footer.html -->

                <!-- partial -->
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="{{ asset('admin/assets/vendors/js/vendor.bundle.base.js') }}"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="{{ asset('admin/assets/vendors/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/jquery.cookie.js') }}" type="text/javascript"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="{{ asset('admin/assets/js/off-canvas.js') }}"></script>
    <script src="{{ asset('admin/assets/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('admin/assets/js/misc.js') }}"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="{{ asset('admin/assets/js/dashboard.js') }}"></script>
    <script src="{{ asset('admin/assets/js/todolist.js') }}"></script>
    <!-- End custom js for this page -->
</body>

</html>
