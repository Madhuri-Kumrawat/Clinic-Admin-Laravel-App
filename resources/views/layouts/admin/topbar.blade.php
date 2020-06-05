<!-- Navbar -->
<nav class="navbar navbar-expand navbar-dark">
    <!-- Brand Logo -->
    <a href="{{ url("/") }}" class="brand-link">
        <img src="{{ url("storage/uploads/logo.png") }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text text-light">Clinic Admin</span>
        <h4 class="brand-text text-center"></h4>
    </a>

    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item">

            <div class="dropdown-menu dropdown-menu-right profile-dropdown" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-40px, 70px, 0px);">
                <!-- item-->
                <div class="dropdown-header noti-title">
                    <h6 class="text-overflow m-0">Welcome !</h6>
                </div>

                <!-- item-->
                <a href="javascript:void(0);" class="dropdown-item notify-item">
                    <i class="fe-user"></i>
                    <span>My Account</span>
                </a>

                <!-- item-->
                <a href="javascript:void(0);" class="dropdown-item notify-item">
                    <i class="fe-settings"></i>
                    <span>Settings</span>
                </a>

                <!-- item-->
                <a href="javascript:void(0);" class="dropdown-item notify-item">
                    <i class="fe-lock"></i>
                    <span>Lock Screen</span>
                </a>

                <div class="dropdown-divider"></div>

                <!-- item-->
                <a href="javascript:void(0);" class="dropdown-item notify-item">
                    <i class="fe-log-out"></i>
                    <span>Logout</span>
                </a>

            </div>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link nav-user" href="{{ url("profile") }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img src="{{ url("public/dist/img/user7-128x128.jpg") }}" alt="user-image" class="rounded-circle mr-1">
                <span class="pro-user-name mr-2">
                    {{ Auth::user()->name }} 
                </span>
                <i class="fas fa-angle-down"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <a href="#" class="dropdown-item">
                    <i class="nav-icon fas fa-user mr-2"></i> Profile
                </a>
                <a href="#" class="dropdown-item">
                    <i class="nav-icon fas fa-cog mr-2"></i> Settings
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                           document.getElementById('logout-form').submit();">
                    <i class="nav-icon fas fa-power-off mr-2"></i> {{ __('Logout') }}
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </li>
    </ul>
</nav>