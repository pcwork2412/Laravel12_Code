<!-- Header -->
<div class="header">
    <!-- Logo -->
    <div class="header-left">
        <a href="{{ route('admin.dashboard') }}" class="logo">
            <i class="fa fa-graduation-cap fa-3x text-light mt-2"></i>
        </a>
    </div>
    <!-- /Logo -->
    
    <!-- Desktop Toggle Button -->
    <a id="toggle_btn" href="javascript:void(0);">
       <i class="fa fa-bars text-white"></i>
    </a>
    
    <!-- Header Title -->
    <div class="page-title-box">
        <h3>School Management System</h3>
    </div>
    <!-- /Header Title -->
    
    <!-- Mobile Toggle Button -->
    <a id="mobile_btn" class="mobile_btn" href="javascript:void(0);">
        <i class="fa fa-bars"></i>
    </a>
    
    <!-- Header Menu -->
    <ul class="nav user-menu">
        <!-- Search -->
        <li class="nav-item">
            <div class="top-nav-search">
                <a href="javascript:void(0);" class="responsive-search">
                    <i class="fa fa-search"></i>
               </a>
            </div>
        </li>
        <!-- /Search -->

        <!-- Notifications -->
        <li class="nav-item dropdown">
            <a href="javascript:void(0);" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
                <span class="user-img">
                    <i class="las la-bell"></i>
                    <span class="status online"></span>
                </span>
                <span>Notification</span>
            </a>
            <div class="dropdown-menu notifications">
                <div class="topnav-dropdown-header">
                    <span class="notification-title">Notifications</span>
                    <a href="javascript:void(0)" class="clear-noti"> Clear All </a>
                </div>
                <div class="noti-content">
                    <ul class="notification-list">
                        <li class="notification-message">
                            <a href="javascript:void(0);">
                                <div class="media d-flex">
                                    <span class="avatar flex-shrink-0">
                                        <i class="fa fa-info-circle"></i>
                                    </span>
                                    <div class="media-body flex-grow-1">
                                        <p class="noti-details">No new notifications</p>
                                        <p class="noti-time"><span class="notification-time">Just now</span></p>
                                    </div>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="topnav-dropdown-footer">
                    <a href="javascript:void(0);">View all Notifications</a>
                </div>
            </div>
        </li>
        <!-- /Notifications -->

        <!-- User Dropdown -->
        <li class="nav-item dropdown has-arrow main-drop">
            <a href="javascript:void(0);" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
                <span class="user-img">
                    <i class="fa fa-user-circle fa-2x text-light"></i>
                    <span class="status online"></span>
                </span>
                <span>{{ session('user_name') ?? 'Guest' }}</span>
            </a>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="{{ route('profile.show') }}">
                    <i class="fa fa-user me-2"></i> My Profile
                </a>
                <a class="dropdown-item" href="{{ route('profile.edit') }}">
                    <i class="fa fa-cog me-2"></i> Settings
                </a>
                <div class="dropdown-divider"></div>
                <!-- Laravel Logout -->
                <a class="dropdown-item" href="{{ route('admin.logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fa fa-sign-out me-2"></i> Logout
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
        <a href="javascript:void(0);" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fa fa-ellipsis-v"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-end">
            <a class="dropdown-item" href="{{ route('profile.show') }}">
                <i class="fa fa-user me-2"></i> My Profile
            </a>
            <a class="dropdown-item" href="{{ route('profile.edit') }}">
                <i class="fa fa-cog me-2"></i> Settings
            </a>
            <div class="dropdown-divider"></div>
            <!-- Laravel Logout -->
            <a class="dropdown-item" href="{{ route('admin.logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form-mobile').submit();">
                <i class="fa fa-sign-out me-2"></i> Logout
            </a>
            <form id="logout-form-mobile" action="{{ route('admin.logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </div>
    <!-- /Mobile Menu -->
</div>

<!-- Sidebar Overlay for Mobile -->
<div class="sidebar-overlay"></div>
<!-- /Header -->
<style>
    /* Sidebar Overlay */
.sidebar-overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: 998;
    transition: all 0.3s ease;
}

/* Toggle Button Styles */
#toggle_btn {
    color: #333;
    cursor: pointer;
    display: inline-block;
    font-size: 24px;
    line-height: 60px;
    padding: 0 15px;
    text-decoration: none;
    transition: all 0.3s ease;
}

#toggle_btn:hover {
    color: #007bff;
}

.bar-icon {
    display: inline-block;
    width: 25px;
}

.bar-icon span {
    background-color: #333;
    display: block;
    height: 3px;
    margin: 5px 0;
    transition: all 0.3s ease;
    border-radius: 2px;
}

/* Mobile Button */
#mobile_btn {
    display: none;
    color: #333;
    font-size: 24px;
    line-height: 60px;
    padding: 0 15px;
    cursor: pointer;
}

/* Mini Sidebar */
body.mini-sidebar .sidebar {
    width: 60px;
}

body.mini-sidebar .sidebar .menu-title {
    display: none;
}

body.mini-sidebar .sidebar .submenu > a span {
    display: none;
}

body.mini-sidebar .page-wrapper {
    margin-left: 60px;
}

body.mini-sidebar .header-left {
    width: 60px;
}

/* Mobile Sidebar */
@media (max-width: 991.98px) {
    #toggle_btn {
        display: none;
    }
    
    #mobile_btn {
        display: inline-block;
    }
    
    .sidebar {
        position: fixed;
        left: -250px;
        top: 60px;
        z-index: 999;
        transition: left 0.3s ease;
    }
    
    .sidebar.open {
        left: 0;
    }
    
    body.sidebar-open .sidebar-overlay {
        display: block;
    }
    
    .page-wrapper {
        margin-left: 0 !important;
    }
}

/* Desktop View */
@media (min-width: 992px) {
    .sidebar {
        position: fixed;
        left: 0;
        top: 60px;
        width: 250px;
        transition: width 0.3s ease;
    }
    
    .page-wrapper {
        margin-left: 250px;
        transition: margin-left 0.3s ease;
    }
}
</style>
<!-- Sidebar Toggle Script -->
<script>
// Sidebar Toggle Functionality
(function() {
    'use strict';
    
    // Desktop Toggle Button
    const toggleBtn = document.getElementById('toggle_btn');
    const sidebar = document.querySelector('.sidebar');
    const body = document.body;
    
    if (toggleBtn) {
        toggleBtn.addEventListener('click', function(e) {
            e.preventDefault();
            body.classList.toggle('mini-sidebar');
            
            // Store state
            if (body.classList.contains('mini-sidebar')) {
                localStorage.setItem('sidebar-state', 'mini');
            } else {
                localStorage.setItem('sidebar-state', 'expanded');
            }
        });
    }
    
    // Mobile Toggle Button
    const mobileBtn = document.getElementById('mobile_btn');
    const sidebarOverlay = document.querySelector('.sidebar-overlay');
    
    if (mobileBtn && sidebar) {
        mobileBtn.addEventListener('click', function(e) {
            e.preventDefault();
            sidebar.classList.toggle('open');
            body.classList.toggle('sidebar-open');
        });
    }
    
    // Sidebar Overlay Click
    if (sidebarOverlay && sidebar) {
        sidebarOverlay.addEventListener('click', function() {
            sidebar.classList.remove('open');
            body.classList.remove('sidebar-open');
        });
    }
    
    // Restore sidebar state
    window.addEventListener('DOMContentLoaded', function() {
        const sidebarState = localStorage.getItem('sidebar-state');
        if (sidebarState === 'mini') {
            body.classList.add('mini-sidebar');
        }
    });
    
    // Handle window resize
    window.addEventListener('resize', function() {
        if (window.innerWidth >= 992 && sidebar) {
            sidebar.classList.remove('open');
            body.classList.remove('sidebar-open');
        }
    });
})();
</script>
