<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Clinic Admin Panel Login Witch control android and ios application data.">
        <meta name="keyword" content="Mobile App With Web development and design technology">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name')." | " }}@yield('title')</title>
        <link rel="shortcut icon" href="{{ url("storage/uploads/logo.png") }}" type="image/png" /> 
        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{ asset('public/plugins/fontawesome-free/css/all.min.css') }}" />
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" />
        <!-- icheck bootstrap -->
        <link rel="stylesheet" href="{{ asset('public/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}" />
        <!-- Theme style -->
        <link rel="stylesheet" href="{{ asset('public/dist/css/adminlte.min.css') }}" />
        <!-- Google Font: Source Sans Pro -->
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet" />
        <!-- DataTables -->
        <link rel="stylesheet" href="{{ asset('public/plugins/datatables-bs4/css/dataTables.bootstrap4.css') }}" />
    </head>
    <body class="hold-transition sidebar-mini layout-fixed">
        <div class="wrapper">
            <!-- Navbar -->
            <nav class="main-header navbar navbar-expand navbar-white navbar-light">
                <!-- Left navbar links -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
                    </li>
                </ul>

                <!-- Right navbar links -->
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                   document.getElementById('logout-form').submit();">
                            <i class="fas fa-power-off"></i> {{ __('Logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </nav>
            <!-- /.navbar -->
            <!-- Main Sidebar Container -->
            <aside class="main-sidebar sidebar-dark-primary elevation-4">
                <!-- Brand Logo -->
                <a href="{{ url("/") }}" class="brand-link">
                    <img src="{{ url("storage/uploads/logo.png") }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
                         style="opacity: .8">
                    <span class="brand-text font-weight-light">Clinic Admin</span>
                    <h4 class="brand-text text-center"></h4>
                </a>

                <!-- Sidebar -->
                <div class="sidebar">
                    <!-- Sidebar user panel (optional) -->
                    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                        <div class="image">
                            <img src="{{ url("storage/uploads/".Auth::user()->icon) }}" class="img-circle elevation-2" alt="User Image">
                        </div>
                        <div class="info">
                            <a href="{{ url("profile") }}" class="d-block">{{ Auth::user()->fullname }}</a>
                        </div>
                    </div>

                    <!-- Sidebar Menu -->
                    <nav class="mt-2">
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                            <!-- Add icons to the links using the .nav-icon class
                                 with font-awesome or any other icon font library -->
                            <li class="nav-item has-treeview menu-open">
                                <a href="{{ url("/") }}" class="nav-link active">
                                    <i class="nav-icon fas fa-tachometer-alt"></i>
                                    <p>Dashboard</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url("city") }}" class="nav-link">
                                    <i class="nav-icon fas fa-road"></i>
                                    <p>City</p>
                                </a>
                            </li>
                            <li class="nav-item has-treeview">
                                <a href="{{ url("specification") }}" class="nav-link">
                                    <i class="nav-icon fas fa-list"></i>
                                    <p>Specification</p>
                                </a>
                            </li>
                            <li class="nav-item has-treeview">
                                <a href="{{ url("profile") }}" class="nav-link">
                                    <i class="nav-icon fas fa-user"></i>
                                    <p>Profile</p>
                                </a>
                            </li>
                            <li class="nav-item has-treeview">
                                <a href="{{ url("app-users") }}" class="nav-link">
                                    <i class="nav-icon fas fa-users"></i>
                                    <p>App Users</p>
                                </a>
                            </li>
                            <li class="nav-item has-treeview">
                                <a href="{{ url("review") }}" class="nav-link">
                                    <i class="nav-icon fas fa-comment"></i>
                                    <p>Review</p>
                                </a>
                            </li>
                            <li class="nav-item has-treeview">
                                <a href="{{ url("send-notification") }}" class="nav-link">
                                    <i class="nav-icon fas fa-table"></i>
                                    <p>Send Notification</p>
                                </a>
                            </li>
                            <li class="nav-item has-treeview">
                                <a href="{{ url("send-notification") }}" class="nav-link">
                                    <i class="nav-icon fas fa-check"></i>
                                    <p>Notification Setting</p>
                                </a>
                            </li>
                        </ul>
                    </nav>
                    <!-- /.sidebar-menu -->
                </div>
                <!-- /.sidebar -->
            </aside>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                @yield('content')
            </div>
            <!-- /.content-wrapper -->
            <footer class="main-footer">
                <strong>Copyright &copy; 2019.</strong>
                All rights reserved.
            </footer>
        </div>
        <!-- ./wrapper -->

        <!-- jQuery -->
        <script src="{{ asset('public/plugins/jquery/jquery.min.js') }}"></script>
        <!-- Bootstrap 4 -->
        <script src="{{ asset('public/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <!-- AdminLTE App -->
        <script src="{{ asset('public/dist/js/adminlte.min.js') }}"></script>
        <!-- jQuery -->
        <script src="{{ asset('public/plugins/jquery/jquery.min.js') }}"></script>
        <!-- jQuery UI 1.11.4 -->
        <script src="{{ asset('public/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
        <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
        <!-- DataTables -->
        <script src="{{ asset('public/plugins/datatables/jquery.dataTables.js') }}"></script>
        <script src="{{ asset('public/plugins/datatables-bs4/js/dataTables.bootstrap4.js') }}"></script>
        @yield("footer")
    </body>
</html>
