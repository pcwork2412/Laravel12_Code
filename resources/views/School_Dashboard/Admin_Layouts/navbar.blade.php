<!-- Header -->
<div class="header">
    <!-- Logo -->
    <div class="header-left">
<a href="{{ route('admin.dashboard') }}" class="logo">
            <i class="fa fa-graduation-cap fa-3x text-light mt-2"></i>
        </a> 
    </div>
    <!-- /Logo -->
    
    <a id="toggle_btn" href="#" role="button">
        <span class="bar-icon">
            <span></span>
            <span></span>
            <span></span>
        </span>
    </a>
    
    <!-- Header Title -->
    <div class="page-title-box">
        <h3>School Management System</h3>
    </div>
    <!-- /Header Title -->
    
    <a id="mobile_btn" class="mobile_btn " href="#sidebar"><i class="fa fa-bars"></i></a>
    <div class="sidebar-overlay" onclick="document.querySelector('.sidebar').classList.remove('open');"></div>

    
    <!-- Header Menu -->
    <ul class="nav user-menu">
        <!-- Search -->
        <li class="nav-item">
            <div class="top-nav-search">
                <a href="#" class="responsive-search">
                    <i class="fa fa-search"></i>
               </a>
            </div>
        </li>
        <!-- /Search -->

        <!-- Notifications -->
        <li class="nav-item">
            <a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
                <span class="user-img"><i class="las la-bell"></i>
                <span class="status online"></span></span>
                <span>Notification</span>
            </a>
        </li>

        <!-- User Dropdown -->
        <li class="nav-item dropdown has-arrow main-drop submenu">
            <a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
                <span class="user-img"><i class="fa fa-graduation-cap fa-1x text-light mt-2"></i>
                <span class="status online"></span></span>
<span>{{ session('user_name') ?? 'Guest' }}</span>
            </a>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="{{ route('profile.show') }}">My Profile</a>
                {{-- <a class="dropdown-item" href="{{ route('profile.edit') }}">Settings</a> --}}

                <!-- Laravel Logout -->
                <a class="dropdown-item" href="{{ route('admin.logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Logout
                </a>

                <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </li>
    </ul>
    <!-- /Header Menu -->

    <!-- Mobile Menu -->
    <div class="dropdown mobile-user-menu">
        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
        <div class="dropdown-menu dropdown-menu-right">
            <a class="dropdown-item" href="{{ route('profile.show') }}">My Profile</a>
            <a class="dropdown-item" href="{{ route('profile.edit') }}">Settings</a>
           <!-- Laravel Logout -->
                <a class="dropdown-item" href="{{ route('admin.logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Logout
                </a>

            <form id="logout-form-mobile" action="{{ route('admin.logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </div>
    <!-- /Mobile Menu -->
</div>
<!-- /Header -->
