<style>
    .bg-color {
        background: #ffffff2f;
        color: rgba(255, 255, 255, 0.849);
        font-size: 18px;
        font-weight: normal !important;
        padding: 3px 8px;
    }

    .sidebar {
        /* width: 260px;
        height: 100vh; Full screen height */
        overflow-y: auto;
        /* Vertical scroll */
        overflow-x: hidden;
        /* Hide horizontal scroll */
        /* background: #ffffff5e; */
    }

    /* Scrollbar style (optional but clean look) */
    .sidebar::-webkit-scrollbar {
        width: 6px;
    }

    .sidebar::-webkit-scrollbar-thumb {
        background: #a0a0a0;
        /* Blue scroll thumb */
        border-radius: 3px;
    }

    .sidebar::-webkit-scrollbar-track {
        background: transparent;
    }
</style>

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li>
                    <a href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2"></i> <span>Admin
                            Dashboard</span></a>
                </li>
                {{-- ****************** Masters Section ****************** --}}
                <div class=" bg-color">Masters Section</div>
                <li class="submenu">
                    <a href="#"><i class="la la-cogs"></i>
                        <span>Masters Section</span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <!-- Add student-related links here -->
                        <li>
                            <a href="{{ url('class_name') }}"><i class="la la-graduation-cap me-1"></i> <span>Add
                                    Classes Master </span></a>
                        </li>
                        {{-- <li>
                            <a href="{{ url('section_name') }}"><i class="la la-graduation-cap me-1"></i> <span>Add
                                    Section Master </span></a>
                        </li> --}}
                        <li>
                            <a href="{{ url('school_name') }}">
                                <i class="fa-solid fa-building "style="font-size:18px;"></i>&nbsp;&nbsp;Add School
                                Master
                            </a>

                        </li>
                        <li>
                            <a href="{{ url('subject_name') }}">
                                <i class="fa-solid fa-book "style="font-size:18px;"></i>&nbsp;&nbsp;Add Subjects Master
                            </a>
                        </li>

                    </ul>
                </li>
                {{-- ****************** End Masters Section ****************** --}}
                {{-- *************** Student Section ************* --}}
                <div class=" bg-color">Student Section</div>
                <li class="">
                    <a href="{{ route('students.index') }}"><i class="la la-users"></i>
                        <span>Student </span> <span class=""></span></a>
                </li>
                {{-- <li class="submenu">
                    <a href="#"><i class="la la-users"></i>
                        <span>Student Section</span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <!-- Add student-related links here -->
                        <li>
                            <a href="{{ route('students.create') }}">
                                <i class="fa-solid fa-circle-plus "style="font-size:18px;"></i>&nbsp;&nbsp;Add Students
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('students.index') }}">
                                <i class="fa-solid fa-rectangle-list "style="font-size:18px;"></i>&nbsp;&nbsp;Students
                                List
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('students.import.form') }}">
                                <i class="fa-solid fa-file-excel "style="font-size:18px;"></i>&nbsp;&nbsp;Import
                                Students
                            </a>
                        </li>
                    </ul>
                </li> --}}

               

                {{-- Students ID GENERATOR  --}}
                <li class="submenu">
                    <a href="#"><i class="la la-id-card"></i>
                        <span>Student ID Card</span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li>
                            <a href="{{ route('students.singleIdForm') }}"><i
                                    class="fa-solid fa-user"style="font-size:18px;"></i>&nbsp;&nbsp;Generate
                                Individual</a>
                        </li>
                        <li>
                            <a href="{{ route('students.classwiseIdForm') }}"><i
                                    class="fa-solid fa-users"style="font-size:18px;"></i>&nbsp;&nbsp;Generate Class
                                Wise</a>
                        </li>
                    </ul>
                </li>

                {{-- Allot Students Marks --}}
                <li class="submenu">
                    <a href="#"><i class="fa-solid fa-pencil-alt fa-1x"style="font-size:18px;"></i>
                        <span>Allot Marks</span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li>
                            <a href="{{ route('marks.create') }}"><i
                                    class="fa-solid fa-circle-plus fa-1x"style="font-size:18px;"></i>&nbsp;&nbsp;Add
                                Marks</a>
                        </li>
                        <li>
                            <a href="{{ route('marks.index') }}"><i
                                    class="fa-solid fa-rectangle-list fa-1x"style="font-size:18px;"></i>&nbsp;&nbsp;Marks
                                List</a>
                        </li>
                        {{-- <li>
                            <a href="{{ route('marks.index') }}"><i class="fa-solid fa-list fa-1x"style="font-size:18px;"></i>&nbsp;&nbsp;View Marks List</a>
                        </li> --}}
                    </ul>
                </li>
                {{-- Print Students Marksheet --}}
                <li class="submenu">
                    <a href="#"><i class="fa-solid fa-print fa-1x"style="font-size:18px;"></i>
                        <span>Print Marksheet</span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li>
                            <a href="{{ route('marksheet.student.form') }}"><i
                                    class="fa-solid fa-user fa-1x"style="font-size:18px;"></i>&nbsp;&nbsp;Individual
                                Marksheet</a>
                        </li>
                        <li>
                            <a href="{{ route('marksheet.form') }}"><i
                                    class="fa-solid fa-users fa-1x"style="font-size:18px;"></i>&nbsp;&nbsp;Classwise
                                Marksheet</a>
                        </li>

                    </ul>
                </li>
                {{-- Students Aprove/Reject Section --}}
                <li class="submenu">
                    <a href="#"><i class="fa-solid fa-warning fa-1x"style="font-size:18px;"></i>
                        <span>Students All Request</span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li>
                            <a href="{{ route('admin.student.pending.list') }}"><i
                                    class="fa-solid fa-rectangle-list fa-1x"style="font-size:18px;"></i>&nbsp;&nbsp;Pending
                                List</a>
                        </li>
                        <li>
                            <a href="{{ route('admin.student.approve.list') }}"><i
                                    class="fa-solid fa-rectangle-list fa-1x"style="font-size:18px;"></i>&nbsp;&nbsp;Approved
                                List</a>
                        </li>
                        <li>
                            <a href="{{ route('admin.student.reject.list') }}"><i
                                    class="fa-solid fa-rectangle-list fa-1x"style="font-size:18px;"></i>&nbsp;&nbsp;Rejected
                                List</a>
                        </li>
                    </ul>
                </li>
                {{-- ***************End Student Section ************* --}}

                {{-- *************** Teacher Section ************* --}}
                <div class=" bg-color">Teacher Section</div>
                <li class="">
                    <a href="{{ route('teachers.index') }}"><i class="la la-users"></i>
                        <span>Teacher </span> <span class=""></span></a>

                </li>
                {{-- <li class="submenu">
                    <a href="#"><i class="la la-users"></i>
                        <span>Teacher Section</span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <!-- Add student-related links here -->
                        <li>
                            <a href="{{ route('teachers.create') }}">
                                <i class="fa-solid fa-circle-plus "style="font-size:18px;"></i>&nbsp;&nbsp;Add Teachers
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('teachers.index') }}">
                                <i class="fa-solid fa-rectangle-list "style="font-size:18px;"></i>&nbsp;&nbsp;Teachers
                                List
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('teachers.import.form') }}">
                                <i class="fa-solid fa-file-excel "style="font-size:18px;"></i>&nbsp;&nbsp;Import
                                Teachers
                            </a>
                        </li>
                    </ul>
                </li> --}}

                {{-- Teachers Attendance  --}}
                {{-- TEACHERS ID GENERATOR --}}
                <li class="submenu">
                    <a href="#"><i class="la la-id-card"></i>
                        <span> Teacher ID Card</span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li>
                            <a href="{{ route('teachers.allIdCardForm') }}"><i
                                    class="fa-solid fa-users"style="font-size:18px;"></i>&nbsp;&nbsp;Generate All</a>
                        </li>
                        <li>
                            <a href="{{ route('teachers.singleIdForm') }}"><i
                                    class="fa-solid fa-user"style="font-size:18px;"></i>&nbsp;&nbsp;Generate
                                Individual</a>
                        </li>
                    </ul>
                </li>

                {{-- ALLOT CLASSES FOR TEACHERS --}}
                <li class="submenu">
                    <a href="#"><i class="la la-chalkboard-teacher"></i>
                        <span>Class Allotment</span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">

                        <li>
                            <a href="{{ route('admin_teachers_allot.create') }}">
                                <i class="fa-solid fa-circle-plus "style="font-size:18px;"></i>&nbsp;&nbsp;Allot Classes
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin_teachers_allot.index') }}">
                                <i class="fa-solid fa-rectangle-list "style="font-size:18px;"></i>&nbsp;&nbsp;Alloted
                                Classes List
                            </a>
                        </li>
                    </ul>
                </li>
                {{-- *************** End Teacher Section ************* --}}
                {{-- Teachers Attendance  --}}
                <div class=" bg-color">Attendance Section</div>
                <li class="submenu">
                    <a href="#"><i class="la la-id-card"></i>
                        <span>Manage Attendance</span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        {{-- Student Attendance --}}
                        <li>
                            <a href="{{ route('student_attendance.create') }}"><i
                                class="fa-solid fa-plus-circle"style="font-size:18px;"></i>&nbsp;&nbsp;Student Attedance</a>
                            </li>
                            {{-- Teacher Attendance --}}
                        <li>
                            <a href="{{ route('teacher_attendance.create') }}"><i
                                    class="fa-solid fa-plus-circle"style="font-size:18px;"></i>&nbsp;&nbsp;Teacher Attedance</a>
                        </li>
                        {{-- <li>
                            <a href="{{ route('students.classwiseIdForm') }}"><i
                                    class="fa-solid fa-users"style="font-size:18px;"></i>&nbsp;&nbsp;Generate Class
                                Wise</a>
                        </li> --}}
                    </ul>
                </li>

                {{-- ID CARD TEMPLATE --}}
                {{-- <li class="submenu">
                    <a href="#"><i class="fa-solid fa-layer-group" style="font-size:18px;"></i>
                        <span>ID Card Template</span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li>
                            <a href="{{ route('students.idcardtemplate') }}"><i class="fa-solid fa-file-pen" style="font-size:18px;"></i>&nbsp;&nbsp;Templates</a>
                        </li>
                    </ul>
                </li> --}}


                {{-- Add Gallery Images --}}
                <div class=" bg-color">Website Section</div>
                <li class="submenu">
                    <a href="#"><i class="fa-solid fa-images fa-1x"style="font-size:18px;"></i>
                        <span>Add Gallery Images</span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li>
                            <a href="{{ route('gallery.index') }}"><i
                                    class="fa-solid fa-circle-plus fa-1x"style="font-size:18px;"></i>&nbsp;&nbsp;Add
                                Image</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- /Sidebar -->
