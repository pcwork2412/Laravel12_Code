<style>
    :root {
        --primary-color: #4f46e5;
        --primary-hover: #4338ca;
        --sidebar-bg: #1e293b;
        --sidebar-text: #cbd5e1;
        --sidebar-text-active: #ffffff;
        --section-header-bg: #334155;
        --hover-bg: #334155;
        --active-bg: #4f46e5;
        --border-color: #334155;
    }

    .sidebar {
        width: 260px;
        height: auto;
        overflow-y: auto;
        overflow-x: hidden;
        background: var(--sidebar-bg);
        box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .sidebar::-webkit-scrollbar {
        width: 6px;
    }

    .sidebar::-webkit-scrollbar-thumb {
        background: #475569;
        border-radius: 3px;
    }

    .sidebar::-webkit-scrollbar-track {
        background: transparent;
    }

    .sidebar-menu ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .sidebar-menu > ul > li {
        border-bottom: 1px solid var(--border-color);
    }

    /* Section Headers */
    .section-header {
        background: var(--section-header-bg);
        color: #94a3b8;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        padding: 12px 20px;
        margin: 0;
        position: sticky;
        top: 0;
        z-index: 10;
    }

    /* Main Menu Links */
    .sidebar-menu a {
        display: flex;
        align-items: center;
        padding: 12px 20px;
        color: var(--sidebar-text);
        text-decoration: none;
        transition: all 0.3s ease;
        position: relative;
        font-size: 14px;
    }

    .sidebar-menu a:hover {
        background: var(--hover-bg);
        color: var(--sidebar-text-active);
        padding-left: 25px;
    }

    /* Active State */
    .sidebar-menu a.active {
        background: var(--active-bg);
        color: var(--sidebar-text-active);
        border-left: 4px solid #fff;
        padding-left: 16px;
        font-weight: 500;
    }

    .sidebar-menu a.active i {
        color: #fff;
    }

    /* Icons */
    .sidebar-menu a i,
    .sidebar-menu a .fa-solid,
    .sidebar-menu a .bi,
    .sidebar-menu a .fas,
    .sidebar-menu a .far {
        margin-right: 12px;
        font-size: 18px;
        width: 20px;
        text-align: center;
        opacity: 0.8;
        transition: all 0.3s ease;
    }

    .sidebar-menu a:hover i,
    .sidebar-menu a:hover .fa-solid,
    .sidebar-menu a:hover .bi,
    .sidebar-menu a:hover .fas,
    .sidebar-menu a:hover .far {
        opacity: 1;
        transform: scale(1.1);
    }

    /* Submenu */
    .submenu > a .menu-arrow {
        margin-left: auto;
        transition: transform 0.3s ease;
    }

    .submenu.active > a .menu-arrow {
        transform: rotate(90deg);
    }

    .submenu ul {
        background: #0f172a;
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease;
    }

    .submenu.active ul {
        max-height: 500px;
    }

    .submenu ul li a {
        padding: 10px 20px 10px 50px;
        font-size: 13px;
    }

    .submenu ul li a:hover {
        padding-left: 55px;
    }

    .submenu ul li a.active {
        padding-left: 46px;
    }

    /* Menu Arrow Icon */
    .menu-arrow::before {
        content: "›";
        font-size: 20px;
        font-weight: bold;
    }

    /* Badges */
    .badge {
        background: #ef4444;
        color: white;
        padding: 2px 8px;
        border-radius: 10px;
        font-size: 11px;
        margin-left: auto;
    }
</style>

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-inner">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <!-- Dashboard -->
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="menu-link">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Admin Dashboard</span>
                    </a>
                </li>

                <!-- Masters Section -->
                <div class="section-header">Masters Section</div>
                <li class="submenu">
                    <a href="javascript:void(0);" class="submenu-toggle">
                        <i class="fas fa-cog"></i>
                        <span>Masters Section</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li>
                            <a href="{{ url('class_name') }}" class="menu-link">
                                <i class="fas fa-chalkboard"></i>
                                <span>Add Classes Master</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('school_name') }}" class="menu-link">
                                <i class="fas fa-school"></i>
                                <span>Add School Master</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('subject_name') }}" class="menu-link">
                                <i class="fas fa-book-open"></i>
                                <span>Add Subjects Master</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Student Section -->
                <div class="section-header">Student Section</div>
                <li>
                    <a href="{{ route('students.index') }}" class="menu-link">
                        <i class="fas fa-user-graduate"></i>
                        <span>Student</span>
                    </a>
                </li>

                <!-- Student ID Card -->
                <li class="submenu">
                    <a href="javascript:void(0);" class="submenu-toggle">
                        <i class="fas fa-id-badge"></i>
                        <span>Student ID Card</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li>
                            <a href="{{ route('students.singleIdForm') }}" class="menu-link">
                                <i class="fas fa-user"></i>
                                <span>Generate Individual</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('students.classwiseIdForm') }}" class="menu-link">
                                <i class="fas fa-users"></i>
                                <span>Generate Class Wise</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('students.idCardHistoryData') }}" class="menu-link">
                                <i class="fas fa-history"></i>
                                <span>ID Card Reports</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Allot Marks -->
                <li class="submenu">
                    <a href="javascript:void(0);" class="submenu-toggle">
                        <i class="fas fa-edit"></i>
                        <span>Allot Marks</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li>
                            <a href="{{ route('marks.create') }}" class="menu-link">
                                <i class="fas fa-plus-circle"></i>
                                <span>Add Marks</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('marks.index') }}" class="menu-link">
                                <i class="fas fa-list-alt"></i>
                                <span>Marks List</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Print Marksheet -->
                <li class="submenu">
                    <a href="javascript:void(0);" class="submenu-toggle">
                        <i class="fas fa-print"></i>
                        <span>Print Marksheet</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li>
                            <a href="{{ route('students.marksheet.individual') }}" class="menu-link">
                                <i class="fas fa-file-alt"></i>
                                <span>Individual Marksheet</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('students.marksheet.classwise') }}" class="menu-link">
                                <i class="fas fa-file-invoice"></i>
                                <span>Classwise Marksheet</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('students.marksheetHistoryData') }}" class="menu-link">
                                <i class="fas fa-history"></i>
                                <span>Marksheet Report</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Students Request -->
                <li class="submenu">
                    <a href="javascript:void(0);" class="submenu-toggle">
                        <i class="fas fa-exclamation-triangle"></i>
                        <span>Students All Request</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li>
                            <a href="{{ route('admin.student.pending.list') }}" class="menu-link">
                                <i class="fas fa-clock"></i>
                                <span>Pending List</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.student.approve.list') }}" class="menu-link">
                                <i class="fas fa-check-circle"></i>
                                <span>Approved List</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.student.reject.list') }}" class="menu-link">
                                <i class="fas fa-times-circle"></i>
                                <span>Rejected List</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Teacher Section -->
                <div class="section-header">Teacher Section</div>
                <li>
                    <a href="{{ route('teachers.index') }}" class="menu-link">
                        <i class="fas fa-chalkboard-teacher"></i>
                        <span>Teacher</span>
                    </a>
                </li>

                <!-- Teacher ID Card -->
                <li class="submenu">
                    <a href="javascript:void(0);" class="submenu-toggle">
                        <i class="fas fa-id-card"></i>
                        <span>Teacher ID Card</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li>
                            <a href="{{ route('teachers.allIdCardForm') }}" class="menu-link">
                                <i class="fas fa-users-cog"></i>
                                <span>Generate All</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('teachers.singleIdForm') }}" class="menu-link">
                                <i class="fas fa-user-tie"></i>
                                <span>Generate Individual</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('teachers.idCardHistoryData') }}" class="menu-link">
                                <i class="fas fa-history"></i>
                                <span>ID Card Reports</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Class Allotment -->
                <li class="submenu">
                    <a href="javascript:void(0);" class="submenu-toggle">
                        <i class="fas fa-tasks"></i>
                        <span>Class Allotment</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li>
                            <a href="{{ route('admin_teachers_allot.create') }}" class="menu-link">
                                <i class="fas fa-user-plus"></i>
                                <span>Allot Classes</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin_teachers_allot.index') }}" class="menu-link">
                                <i class="fas fa-clipboard-list"></i>
                                <span>Alloted Classes List</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Attendance Section -->
                <div class="section-header">Attendance Section</div>
                <li class="submenu">
                    <a href="javascript:void(0);" class="submenu-toggle">
                        <i class="fas fa-calendar-check"></i>
                        <span>Manage Attendance</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li>
                            <a href="{{ route('student_attendance.create') }}" class="menu-link">
                                <i class="fas fa-user-check"></i>
                                <span>Student Attendance</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('student_attendance.report') }}" class="menu-link">
                                <i class="fas fa-chart-bar"></i>
                                <span>Student Report</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('teacher_attendance.create') }}" class="menu-link">
                                <i class="fas fa-user-shield"></i>
                                <span>Teacher Attendance</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('teacher_attendance.report') }}" class="menu-link">
                                <i class="fas fa-chart-line"></i>
                                <span>Teacher Report</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Website Section -->
                <div class="section-header">Website Section</div>
                <li class="submenu">
                    <a href="javascript:void(0);" class="submenu-toggle">
                        <i class="fas fa-images"></i>
                        <span>Add Gallery Images</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li>
                            <a href="{{ route('gallery.index') }}" class="menu-link">
                                <i class="fas fa-camera"></i>
                                <span>Add Image</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Recycle Bin -->
                <div class="section-header">Recycle Bin</div>
                <li class="submenu">
                    <a href="javascript:void(0);" class="submenu-toggle">
                        <i class="fas fa-trash-restore"></i>
                        <span>Manage Deleted Data</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li>
                            <a href="{{ route('students.trashed') }}" class="menu-link">
                                <i class="fas fa-user-times"></i>
                                <span>Students Data</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('teachers.trashed') }}" class="menu-link">
                                <i class="fas fa-user-slash"></i>
                                <span>Teachers Data</span>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const currentUrl = window.location.href;
    const menuLinks = document.querySelectorAll('.menu-link');
    const submenuToggles = document.querySelectorAll('.submenu-toggle');

    // Set active state for current page
    menuLinks.forEach(link => {
        if (link.href === currentUrl) {
            link.classList.add('active');
            
            // Open parent submenu if link is inside one
            const parentSubmenu = link.closest('.submenu');
            if (parentSubmenu) {
                parentSubmenu.classList.add('active');
            }
        }
    });

    // Toggle submenu on click
    submenuToggles.forEach(toggle => {
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            const parentLi = this.closest('.submenu');
            
            // Close other submenus
            document.querySelectorAll('.submenu').forEach(item => {
                if (item !== parentLi) {
                    item.classList.remove('active');
                }
            });
            
            // Toggle current submenu
            parentLi.classList.toggle('active');
        });
    });

    // Keep submenu open if a child link is active
    document.querySelectorAll('.submenu ul li a.active').forEach(activeLink => {
        const parentSubmenu = activeLink.closest('.submenu');
        if (parentSubmenu) {
            parentSubmenu.classList.add('active');
        }
    });
});
</script>