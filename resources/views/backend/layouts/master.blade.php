<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ URL::asset('backend/plugins/fontawesome-free/css/all.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet"
        href="{{ URL::asset('backend/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
    <link rel="stylesheet" href="{{ URL::asset('backend/css/style.css')}}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ URL::asset('backend/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}'">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{ URL::asset('backend/plugins/jqvmap/jqvmap.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ URL::asset('backend/dist/css/adminlte.min.css')}}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ URL::asset('backend/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ URL::asset('backend/plugins/daterangepicker/daterangepicker.css')}}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ URL::asset('backend/plugins/summernote/summernote-bs4.min.css')}}">
    <link rel="stylesheet" href="{{ URL::asset('backend/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet"
        href="{{ URL::asset('backend/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{ URL::asset('backend/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{ URL::asset('backend/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')}}">
    <!-- Toastr -->
    <link rel="stylesheet" href="{{ URL::asset('backend/plugins/toastr/toastr.min.css')}}">
    <script src="{{ URL::asset('backend/plugins/jquery/jquery.min.js')}}"></script>
    <!-- SweetAlert2 -->
    <script src="{{ URL::asset('backend/plugins/sweetalert2/sweetalert2.min.js')}}"></script>
    <!-- Toastr -->
    <script src="{{ URL::asset('backend/plugins/toastr/toastr.min.js')}}"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <script src="{{ URL::asset('backend/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
</head>

<body class="hold-transition  sidebar-mini layout-fixed layout-navbar-fixed">
    <style>

    </style>
    <div class="wrapper">
        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="{{ URL::asset('assets/img/loader.gif')}}" alt="METC" height="60"
                width="60">
        </div>
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <div class="media align-items-center">
                            <span class="avatar avatar-sm rounded-circle">
                                <img src="{{ URL::asset('assets/img/user.gif')}}" alt="User Avatar" class="img-circle"
                                    style="width: 30px;">
                            </span>
                        </div>
                    </a>
                    <div class="dropdown-menu  dropdown-menu-right ">
                        <a href="{{ url('admin/profile') }}" class="dropdown-item">
                            <i class="ni ni-single-02"></i>
                            <span>Welcome {{ Auth::user()->name }}</span>
                        </a>
                        <a href="{{ url('admin/profile') }}" class="dropdown-item">
                            <i class="fa fa-user-circle-o" aria-hidden="true"></i>
                            <span>Profile</span>
                        </a>

                        <div class="dropdown-divider"></div>
                        <a href="{{ url('admin/change-password') }}" class="dropdown-item">
                            <i class="fa fa-key" aria-hidden="true"></i>
                            <span>Change Password</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i> {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->
        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="{{ URL::asset('admin/dashboard')}}" class="brand-link">
                <img src="{{ URL::asset('assets/img/admin.gif')}}" alt="AdminLTE Logo"
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">Admin</span>
            </a>
            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <li class="nav-item">
                            <a href="{{ URL::asset('admin/dashboard')}}" class="nav-link dashboard">
                                <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M5 12l-2 0l9 -9l9 9l-2 0"></path>
                                    <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7"></path>
                                    <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6"></path>
                                </svg>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>

                        <li class="nav-item has-treeview">
                            <a href="/docs/3.0/components" class="nav-link tournament">
                                <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M3 21l18 0"></path>
                                    <path
                                        d="M3 7v1a3 3 0 0 0 6 0v-1m0 1a3 3 0 0 0 6 0v-1m0 1a3 3 0 0 0 6 0v-1h-18l2 -4h14l2 4">
                                    </path>
                                    <path d="M5 21l0 -10.15"></path>
                                    <path d="M19 21l0 -10.15"></path>
                                    <path d="M9 21v-4a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v4"></path>
                                </svg>
                                <p>
                                    Tournament
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview" style="display: none;">
                                <li class="nav-item">
                                    <a href="{{ URL::asset('admin/tournament')}}" class="nav-link faq-all">
                                        <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M12 12m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"></path>
                                        </svg>
                                        <p>ALL Tournament</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ URL::asset('admin/tournament/create')}}" class="nav-link faq-all">
                                        <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M12 12m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"></path>
                                        </svg>
                                        <p>Create Tournament</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ URL::asset('admin/category')}}" class="nav-link all-category">
                                        <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M12 12m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"></path>
                                        </svg>
                                        <p>Categories</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ URL::asset('admin/type')}}" class="nav-link all-type">
                                        <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M12 12m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"></path>
                                        </svg>
                                        <p>Type</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="{{ URL::asset('admin/subscriber')}}" class="nav-link subscriber">
                                <i class="nav-icon fa fa-users"></i>
                                <p>
                                 Organizer
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ URL::asset('admin/users')}}" class="nav-link users">
                                <i class="nav-icon fa fa-users"></i>
                                <p>
                                 Users
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ URL::asset('admin/payment-history')}}" class="nav-link payment">
                                <i class="nav-icon fa fa-money"></i>
                                <p>
                                 Payment History
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ URL::asset('admin/players')}}" class="nav-link players">
                                <i class="nav-icon fa fa-users"></i>
                                <p>
                                 Player
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ URL::asset('admin/enquiry-list')}}" class="nav-link enquiry-all">
                                <i class="nav-icon  fa fa-envelope-open-o" aria-hidden="true"></i>
                                <p> WebSite Enquiry</p>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>


        @yield('main-content')


        <footer class="main-footer">
            <p>Copyrights © 2023 All Rights Reserved</p>
            </p>
        </footer>
        <!-- jQuery UI 1.11.4 -->

        <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->

        <!-- Bootstrap 4 -->
        <script src="{{ URL::asset('backend/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
        <!-- ChartJS -->
        <script src="{{ URL::asset('backend/plugins/chart.js/Chart.min.js')}}"></script>
        <!-- Sparkline -->
        <script src="{{ URL::asset('backend/plugins/sparklines/sparkline.js')}}"></script>
        <!-- JQVMap -->
        <script src="{{ URL::asset('backend/plugins/jqvmap/jquery.vmap.min.js')}}"></script>
        <script src="{{ URL::asset('backend/plugins/jqvmap/maps/jquery.vmap.usa.js')}}"></script>
        <!-- jQuery Knob Chart -->
        <script src="{{ URL::asset('backend/plugins/jquery-knob/jquery.knob.min.js')}}"></script>
        <!-- daterangepicker -->
        <script src="{{ URL::asset('backend/plugins/moment/moment.min.js')}}"></script>
        <script src="{{ URL::asset('backend/plugins/daterangepicker/daterangepicker.js')}}"></script>
        <!-- Tempusdominus Bootstrap 4 -->
        <script src="{{ URL::asset('backend/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}">
        </script>
        <!-- Summernote -->
        <script src="{{ URL::asset('backend/plugins/summernote/summernote-bs4.min.js')}}"></script>
        <!-- overlayScrollbars -->
        <script src="{{ URL::asset('backend/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
        <!-- AdminLTE App -->
        <script src="{{ URL::asset('backend/dist/js/adminlte.js')}}"></script>
        <script src="{{ URL::asset('backend/plugins/datatables/jquery.dataTables.min.js')}}"></script>
        <script src="{{ URL::asset('backend/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
        <script src="{{ URL::asset('backend/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
        <script src="{{ URL::asset('backend/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
        <script src="{{ URL::asset('backend/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
        <script src="{{ URL::asset('backend/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
        <script src="{{ URL::asset('backend/plugins/jszip/jszip.min.js')}}"></script>
        <script src="{{ URL::asset('backend/plugins/pdfmake/pdfmake.min.js')}}"></script>
        <script src="{{ URL::asset('backend/plugins/pdfmake/vfs_fonts.js')}}"></script>
        <script src="{{ URL::asset('backend/plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
        <script src="{{ URL::asset('backend/plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
        <script src="{{ URL::asset('backend/plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>
        <!-- /.content-wrapper -->
        <script>
        function updateClock() {
            var now = moment();
            var formattedTime = now.format('dddd, MMMM D, YYYY, h:mm:ss A');
            document.getElementById('clock').textContent = formattedTime;
        }

        // Update the clock every second
        setInterval(updateClock, 1000);

        // Initial call to display clock when the page loads
        updateClock();
        </script>
        <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "lengthMenu": [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ],
                //"buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });
        </script>
</body>

</html>
processing: true,
