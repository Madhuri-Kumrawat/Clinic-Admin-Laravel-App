<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-light-info">
    
    <!-- Sidebar -->
    <div class="sidebar text-sm">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                <li class="nav-item has-treeview">
                    <a href="{{ url("/") }}" class="nav-link @yield('mnuDashboard')">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url("admin/city") }}" class="nav-link @yield('mnuCity')">
                        <i class="nav-icon fas fa-road"></i>
                        <p>City</p>
                    </a>
                </li>
                <li class="nav-item has-treeview">
                    <a href="{{ url("admin/specialists") }}" class="nav-link @yield('mnuSpecialists')">
                        <i class="nav-icon fas fa-stethoscope"></i>
                        <p>Specialists</p>
                    </a>
                </li>
                <li class="nav-item has-treeview">
                    <a href="{{ url("admin/profile") }}" class="nav-link @yield('mnuProfile')">
                        <i class="nav-icon fas fa-user"></i>
                        <p>Profile</p>
                    </a>
                </li>
                <li class="nav-item has-treeview">
                    <a href="{{ url("admin/app-users") }}" class="nav-link @yield('mnuAppUsers')">
                        <i class="nav-icon fas fa-users"></i>
                        <p>App Users</p>
                    </a>
                </li>
                <li class="nav-item has-treeview">
                    <a href="{{ url("admin/reviews") }}" class="nav-link @yield('mnuReview')">
                        <i class="nav-icon fas fa-comment"></i>
                        <p>Review</p>
                    </a>
                </li>
                <li class="nav-item has-treeview">
                    <a href="{{ url("admin/notification") }}" class="nav-link @yield('mnuNotification')">
                        <i class="nav-icon fas fa-table"></i>
                        <p>Send Notification</p>
                    </a>
                </li>
                <li class="nav-item has-treeview">
                    <a href="{{ url("admin/notification-setting") }}" class="nav-link @yield('mnuNotificationSetting')">
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