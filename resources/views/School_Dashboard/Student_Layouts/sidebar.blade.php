<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li>
                    <a href="{{ route('student.dashboard') }}"><i class="bi bi-speedometer2"></i> <span>Student Dashboard</span></a>
                </li>

                {{-- <li class="submenu">
                    <a href="#"><i class="la la-cogs"></i>
                        <span>Masters Section</span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <!-- Add student-related links here -->
                        <li>
                            <a href="{{ url('class_name') }}"><i class="la la-graduation-cap me-1"></i> <span>Add
                                    Classes Master </span></a>
                        </li>
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
                </li> --}}
                {{-- Student Section --}}
                <li class="submenu">
                    <a href="#"><i class="la la-graduation-cap"></i>
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
                </li>
                {{-- End Student Section --}}

                {{-- ID GENERATOR --}}
                {{-- <li class="submenu">
                    <a href="#"><i class="la la-id-card"></i>
                        <span>Generate ID Card</span> <span class="menu-arrow"></span></a>
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
                </li> --}}
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

                {{-- Allot Students Marks --}}
                <li class="submenu">
                    <a href="#"><i class="fa-solid fa-circle-check fa-1x"style="font-size:18px;"></i>
                        <span>Allot Marks</span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li>
                            <a href="{{ route('marks.create') }}"><i
                                    class="fa-solid fa-circle-plus fa-1x"style="font-size:18px;"></i>&nbsp;&nbsp;Add
                                Marks</a>
                        </li>
                        <li>
                            <a href="{{ route('marks.index') }}"><i
                                    class="fa-solid fa-list fa-1x"style="font-size:18px;"></i>&nbsp;&nbsp;Marks List</a>
                        </li>
                        {{-- <li>
                            <a href="{{ route('marks.index') }}"><i class="fa-solid fa-list fa-1x"style="font-size:18px;"></i>&nbsp;&nbsp;View Marks List</a>
                        </li> --}}
                    </ul>
                </li>
                {{-- Print Students Marksheet --}}
                {{-- <li class="submenu">
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
                </li> --}}
                {{-- Teacher Aprove/Reject Section --}}
                {{-- <li class="submenu">
                    <a href="#"><i class="fa-solid fa-images fa-1x"style="font-size:18px;"></i>
                        <span>Approve/Reject</span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li>
                            <a href="{{ route('admin.teachers.pending') }}"><i
                                    class="fa-solid fa-circle-plus fa-1x"style="font-size:18px;"></i>&nbsp;&nbsp;Teacher
                                List</a>
                        </li>
                    </ul>
                </li> --}}
                {{-- Add Gallery Images --}}
                {{-- <li class="submenu">
                    <a href="#"><i class="fa-solid fa-images fa-1x"style="font-size:18px;"></i>
                        <span>Add Gallery Images</span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li>
                            <a href="{{ route('gallery.index') }}"><i
                                    class="fa-solid fa-circle-plus fa-1x"style="font-size:18px;"></i>&nbsp;&nbsp;Add
                                Image</a>
                        </li>
                    </ul>
                </li> --}}
            </ul>
        </div>
    </div>
</div>
<!-- /Sidebar -->
