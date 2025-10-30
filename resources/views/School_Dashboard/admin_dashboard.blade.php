@extends('School_Dashboard.Admin_Layouts.app')

@section('content')
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #ffffff 0%, #ffffff 100%);
            min-height: 100vh;
        }

        .dashboard-container {
            padding: 20px;
            max-width: 1400px;
            margin: 0 auto;
        }

        /* Header Section */
        .dashboard-header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        }

        .welcome-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
        }

        .welcome-text h1 {
            font-size: 32px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 5px;
        }

        .welcome-text p {
            color: #64748b;
            font-size: 16px;
        }

        .welcome-text .current-date {
            display: inline-block;
            background: #eef2ff;
            color: #667eea;
            padding: 4px 12px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            margin-top: 8px;
        }

        .header-actions {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        .btn-custom {
            padding: 12px 24px;
            border-radius: 12px;
            border: none;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }

        .btn-primary-custom {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-secondary-custom {
            background: white;
            color: #667eea;
            border: 2px solid #667eea;
        }

        .btn-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            cursor: pointer;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.15);
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: var(--card-color);
        }

        .stat-card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 15px;
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            background: var(--card-bg);
            color: var(--card-color);
        }

        .stat-trend {
            background: #dcfce7;
            color: #16a34a;
            padding: 4px 10px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
        }

        .stat-trend.down {
            background: #fee2e2;
            color: #dc2626;
        }

        .stat-number {
            font-size: 36px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 5px;
        }

        .stat-label {
            color: #64748b;
            font-size: 14px;
            font-weight: 500;
        }

        .stat-footer {
            margin-top: 12px;
            padding-top: 12px;
            border-top: 1px solid #f1f5f9;
            font-size: 12px;
            color: #94a3b8;
        }

        /* Quick Actions */
        .quick-actions {
            background: white;
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
        }

        .section-title {
            font-size: 22px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-title-with-date {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .section-title-left {
            font-size: 22px;
            font-weight: 700;
            color: #1e293b;
            padding-right: 5px;
            /* display: flex;
                    align-items: center;
                    gap: 10px; */
        }

        .section-date {
            background: #eef2ff;
            color: #667eea;
            padding: 6px 8px;
            border-radius: 5px;
            font-size: 12px;
            font-weight: 600;
            /* display: flex;
                    align-items: center;
                    gap: 6px; */
        }

        .actions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }

        .action-card {
            background: linear-gradient(135deg, var(--action-color-1), var(--action-color-2));
            border-radius: 15px;
            padding: 20px;
            color: white;
            text-decoration: none;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .action-card:hover {
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            color: white;
        }

        .action-icon {
            font-size: 32px;
            opacity: 0.9;
        }

        .action-text h4 {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 3px;
        }

        .action-text p {
            font-size: 12px;
            opacity: 0.9;
            margin: 0;
        }

        /* Two Column Layout */
        .dashboard-grid {
            display: grid;
            grid-template-columns: 2fr 2fr;
            gap: 20px;
            margin-bottom: 30px;
        }

        .chart-card {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
        }

        /* Recent Activity */
        .activity-list {
            max-height: 400px;
            overflow-y: auto;
        }

        .activity-item {
            display: flex;
            gap: 15px;
            padding: 15px;
            border-bottom: 1px solid #f1f5f9;
            transition: all 0.2s ease;
        }

        .activity-item:hover {
            background: #f8fafc;
        }

        .activity-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
        }

        .activity-content h5 {
            font-size: 14px;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 3px;
        }

        .activity-content p {
            font-size: 12px;
            color: #64748b;
            margin: 0;
        }

        .activity-time {
            font-size: 11px;
            color: #94a3b8;
            margin-left: auto;
        }

        /* Bottom Section */
        .bottom-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        /* Section-wise Attendance */
        .attendance-scroll-container {
            max-height: 450px;
            overflow-y: auto;
            padding-right: 5px;
        }

        .attendance-scroll-container::-webkit-scrollbar {
            width: 6px;
        }

        .attendance-scroll-container::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        .attendance-scroll-container::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        .attendance-scroll-container::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 10px;
        }

        .section-attendance {
            margin-bottom: 20px;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
        }

        .section-header-bg {
            background: var(--section-header-bg);
            color: #94a3b8;
            border-radius: 10px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 12px 20px;
            /* margin: 0;
                position: sticky;
                top: 0;
                z-index: 10; */
        }

        .section-name {
            font-size: 14px;
            font-weight: 600;
            color: #ffffff;
        }


        .section-percentage {
            font-size: 13px;
            font-weight: 600;
            color: #667eea;
        }

        .progress-bar {
            height: 10px;
            background: #e2e8f0;
            border-radius: 10px;
            overflow: hidden;
            position: relative;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #667eea, #764ba2);
            border-radius: 10px;
            transition: width 0.6s ease;
            position: relative;
        }

        .progress-fill::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            animation: shimmer 2s infinite;
        }

        @keyframes shimmer {
            0% {
                transform: translateX(-100%);
            }

            100% {
                transform: translateX(100%);
            }
        }

        .attendance-stats {
            display: flex;
            justify-content: space-between;
            margin-top: 5px;
            font-size: 11px;
            color: #94a3b8;
        }

        /* Pending Requests */
        .request-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            background: #f8fafc;
            border-radius: 12px;
            margin-bottom: 10px;
            transition: all 0.2s ease;
        }

        .request-item:hover {
            background: #eef2ff;
        }

        .request-info h5 {
            font-size: 14px;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 3px;
        }

        .request-info p {
            font-size: 12px;
            color: #64748b;
            margin: 0;
        }

        .request-badge {
            background: #fef3c7;
            color: #f59e0b;
            padding: 4px 12px;
            border-radius: 8px;
            font-size: 11px;
            font-weight: 600;
        }

        .view-all {
            display: block;
            text-align: center;
            padding: 10px;
            background: #eef2ff;
            color: #667eea;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            font-size: 13px;
            margin-top: 10px;
            transition: all 0.3s ease;
        }

        .view-all:hover {
            background: #667eea;
            color: white;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .dashboard-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .welcome-text h1 {
                font-size: 24px;
            }

            .stat-number {
                font-size: 28px;
            }

            .actions-grid {
                grid-template-columns: 1fr;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .section-title-with-date {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }
        }

        /* Loading Animation */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .stat-card {
            animation: fadeInUp 0.6s ease forwards;
        }

        .stat-card:nth-child(1) {
            animation-delay: 0.1s;
        }

        .stat-card:nth-child(2) {
            animation-delay: 0.2s;
        }

        .stat-card:nth-child(3) {
            animation-delay: 0.3s;
        }

        .stat-card:nth-child(4) {
            animation-delay: 0.4s;
        }

        .stat-card:nth-child(5) {
            animation-delay: 0.5s;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: #94a3b8;
        }

        .empty-state i {
            font-size: 48px;
            margin-bottom: 15px;
            opacity: 0.5;
        }

        .empty-state p {
            font-size: 14px;
            margin: 0;
        }
    </style>

    <div class="dashboard-container">
        <!-- Header -->
        <div class="dashboard-header">
            <div class="welcome-section">
                <div class="welcome-text">
                    <h1>Welcome back, {{ session('user_name') ?? 'Admin' }}! 👋</h1>
                    <p>Here's what's happening with your school today</p>
                    <span class="current-date">
                        <i class="fas fa-calendar"></i> {{ date('l, F d, Y') }}
                    </span>
                </div>
                <div class="header-actions">
                    <a href="{{ route('students.index') }}" class="btn-custom btn-secondary-custom">
                        <i class="fas fa-users"></i>
                        View All Students
                    </a>
                    <button class="btn-custom btn-primary-custom" onclick="generateReport()">
                        <i class="fas fa-download"></i>
                        Download Report
                    </button>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="stats-grid">
            <!-- Total Students -->
            <div class="stat-card" style="--card-color: #667eea; --card-bg: #eef2ff;"
                onclick="location.href='{{ route('students.index') }}'">
                <div class="stat-card-header">
                    <div class="stat-icon">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    @php
                        $totalStudents = \App\Models\Students\Crud::count();
                        $lastMonthStudents = \App\Models\Students\Crud::whereMonth(
                            'created_at',
                            now()->subMonth()->month,
                        )->count();
                        $studentGrowth =
                            $lastMonthStudents > 0
                                ? round((($totalStudents - $lastMonthStudents) / $lastMonthStudents) * 100, 1)
                                : 0;
                    @endphp
                    <span class="stat-trend {{ $studentGrowth >= 0 ? '' : 'down' }}">
                        <i class="fas fa-arrow-{{ $studentGrowth >= 0 ? 'up' : 'down' }}"></i> {{ abs($studentGrowth) }}%
                    </span>
                </div>
                <div class="stat-number">{{ number_format($totalStudents) }}</div>
                <div class="stat-label">Total Students</div>
                <div class="stat-footer">
                    <i class="fas fa-info-circle"></i> Click to view all students
                </div>
            </div>

            <!-- Total Teachers -->
            <div class="stat-card" style="--card-color: #f59e0b; --card-bg: #fef3c7;"
                onclick="location.href='{{ route('teachers.index') }}'">
                <div class="stat-card-header">
                    <div class="stat-icon">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                    @php
                        $totalTeachers = \App\Models\Teacher\TeacherCrud::count();
                        $lastMonthTeachers = \App\Models\Teacher\TeacherCrud::whereMonth(
                            'created_at',
                            now()->subMonth()->month,
                        )->count();
                        $teacherGrowth =
                            $lastMonthTeachers > 0
                                ? round((($totalTeachers - $lastMonthTeachers) / $lastMonthTeachers) * 100, 1)
                                : 0;
                    @endphp
                    <span class="stat-trend {{ $teacherGrowth >= 0 ? '' : 'down' }}">
                        <i class="fas fa-arrow-{{ $teacherGrowth >= 0 ? 'up' : 'down' }}"></i> {{ abs($teacherGrowth) }}%
                    </span>
                </div>
                <div class="stat-number">{{ number_format($totalTeachers) }}</div>
                <div class="stat-label">Total Teachers</div>
                <div class="stat-footer">
                    <i class="fas fa-info-circle"></i> Click to view all teachers
                </div>
            </div>

            <!-- Total Classes -->
            <div class="stat-card" style="--card-color: #8b5cf6; --card-bg: #ede9fe;"
                onclick="location.href='{{ url('class_name') }}'">
                <div class="stat-card-header">
                    <div class="stat-icon">
                        <i class="fas fa-school"></i>
                    </div>
                    @php
                        $totalClasses = \App\Models\Masters\StdClass::count();
                    @endphp
                    <span class="stat-trend">
                        <i class="fas fa-check-circle"></i> Active
                    </span>
                </div>
                <div class="stat-number">{{ number_format($totalClasses) }}</div>
                <div class="stat-label">Total Classes</div>
                <div class="stat-footer">
                    <i class="fas fa-info-circle"></i> Click to manage classes
                </div>
            </div>

            <!-- Attendance Rate -->
            <div class="stat-card" style="--card-color: #10b981; --card-bg: #d1fae5;">
                <div class="stat-card-header">
                    <div class="stat-icon">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    @php
                        use App\Models\Attendance\StudentAttendance;
                        use App\Models\Students\Crud;

                        // ✅ Aaj ki attendance data
                        $today = today();
                        $todayPresentAttendance = StudentAttendance::whereDate('date', $today)
                            ->where('status', 'present')
                            ->count();

                        $todayAbsentAttendance = StudentAttendance::whereDate('date', $today)
                            ->where('status', 'absent')
                            ->count();

                        $todayLeaveAttendance = StudentAttendance::whereDate('date', $today)
                            ->where('status', 'leave')
                            ->count();

                        // ✅ Total students count
                        $totalStudentsToday = Crud::count();

                        // ✅ Attendance rate calculation fix
                        $attendanceRate =
                            $totalStudentsToday > 0
                                ? round(($todayPresentAttendance / $totalStudentsToday) * 100, 1)
                                : 0;
                    @endphp

                    <span class="stat-trend">
                        <i class="fas fa-arrow-up"></i> {{ $attendanceRate }}%
                    </span>
                </div>
                <div class="stat-number">{{ $attendanceRate }}%</div>
                <div class="stat-label">Today's Attendance</div>
                <div class="stat-footer">
                    <i class="fas fa-users"></i> {{ $todayPresentAttendance }} of {{ $totalStudentsToday }} present
                </div>
            </div>

            <!-- Pending Requests -->
            <div class="stat-card" style="--card-color: #ef4444; --card-bg: #fee2e2;"
                onclick="location.href='{{ route('admin.student.pending.list') }}'">
                <div class="stat-card-header">
                    <div class="stat-icon">
                        <i class="fas fa-exclamation-circle"></i>
                    </div>
                    @php
                        $pendingRequests = \App\Models\Students\Crud::where('status', 'pending')->count();
                    @endphp
                    <span class="stat-trend down">
                        <i class="fas fa-clock"></i> Pending
                    </span>
                </div>
                <div class="stat-number">{{ number_format($pendingRequests) }}</div>
                <div class="stat-label">Pending Requests</div>
                <div class="stat-footer">
                    <i class="fas fa-info-circle"></i> Click to review requests
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="quick-actions">
            <h3 class="section-title">
                <i class="fas fa-bolt"></i>
                Quick Actions
            </h3>
            <div class="actions-grid">
                <a href="{{ route('students.create') }}" class="action-card"
                    style="--action-color-1: #667eea; --action-color-2: #764ba2;">
                    <div class="action-icon"><i class="fas fa-user-plus"></i></div>
                    <div class="action-text">
                        <h4>Add Student</h4>
                        <p>Register new student</p>
                    </div>
                </a>

                <a href="{{ route('teachers.create') }}" class="action-card"
                    style="--action-color-1: #f59e0b; --action-color-2: #d97706;">
                    <div class="action-icon"><i class="fas fa-chalkboard-teacher"></i></div>
                    <div class="action-text">
                        <h4>Add Teacher</h4>
                        <p>Register new teacher</p>
                    </div>
                </a>

                <a href="{{ route('students.classwiseIdForm') }}" class="action-card"
                    style="--action-color-1: #10b981; --action-color-2: #059669;">
                    <div class="action-icon"><i class="fas fa-id-card"></i></div>
                    <div class="action-text">
                        <h4>Generate ID</h4>
                        <p>Create ID cards</p>
                    </div>
                </a>

                <a href="{{ route('marks.create') }}" class="action-card"
                    style="--action-color-1: #8b5cf6; --action-color-2: #7c3aed;">
                    <div class="action-icon"><i class="fas fa-pencil-alt"></i></div>
                    <div class="action-text">
                        <h4>Allot Marks</h4>
                        <p>Enter exam marks</p>
                    </div>
                </a>

                <a href="{{ route('student_attendance.create') }}" class="action-card"
                    style="--action-color-1: #ec4899; --action-color-2: #db2777;">
                    <div class="action-icon"><i class="fas fa-calendar-check"></i></div>
                    <div class="action-text">
                        <h4>Mark Attendance</h4>
                        <p>Student attendance</p>
                    </div>
                </a>

                <a href="{{ route('marksheet.form') }}" class="action-card"
                    style="--action-color-1: #06b6d4; --action-color-2: #0891b2;">
                    <div class="action-icon"><i class="fas fa-print"></i></div>
                    <div class="action-text">
                        <h4>Print Marksheet</h4>
                        <p>Generate reports</p>
                    </div>
                </a>
            </div>
        </div>

        <!-- Charts and Activity -->
        <div class="dashboard-grid">
            <!-- Main Chart - Dynamic Enrollment Trends -->
            <div class="chart-card">
                <h3 class="section-title">
                    <i class="fas fa-chart-line"></i>
                    Student Enrollment Trends
                </h3>
                <canvas id="enrollmentChart" style="max-height: 300px;"></canvas>
            </div>

            <!-- Recent Activity -->
            <div class="chart-card">
                <h3 class="section-title">
                    <i class="fas fa-clock"></i>
                    Recent Activity
                </h3>
                <div class="activity-list">
                    @php
                        $recentActivities = collect();

                        // Recent Students
                        $recentStudents = \App\Models\Students\Crud::latest()->take(1)->get();
                        foreach ($recentStudents as $student) {
                            $recentActivities->push([
                                'type' => 'student',
                                'title' => 'New Student Added',
                                'description' =>
                                    $student->student_name .
                                    ' enrolled in Class- ' .
                                    ($student->promoted_class_name ?? 'N/A'),
                                'time' => $student->created_at->diffForHumans(),
                                'icon' => 'user-plus',
                                'color' => '#667eea',
                                'bg' => '#eef2ff',
                            ]);
                        }

                        // Recent Teachers
                        $recentTeachers = \App\Models\Teacher\TeacherCrud::latest()->take(1)->get();
                        foreach ($recentTeachers as $teacher) {
                            $recentActivities->push([
                                'type' => 'teacher',
                                'title' => 'New Teacher Added',
                                'description' => ($teacher->teacher_name ?? 'N/A') . ' joined the staff',
                                'time' => $teacher->created_at->diffForHumans(),
                                'icon' => 'chalkboard-teacher',
                                'color' => '#f59e0b',
                                'bg' => '#fef3c7',
                            ]);
                        }

                        // Recent Marks
                        $recentMarks = \App\Models\Students\MarksAllotTable::latest()->take(1)->get();
                        foreach ($recentMarks as $mark) {
                            $recentActivities->push([
                                'type' => 'marks',
                                'title' => 'Marks Updated',
                                'description' => ($mark->subject_name ?? 'Subject') . ' exam marks uploaded',
                                'time' => $mark->created_at->diffForHumans(),
                                'icon' => 'check-circle',
                                'color' => '#10b981',
                                'bg' => '#d1fae5',
                            ]);
                        }

                        // Pending Approvals
                        if ($pendingRequests > 0) {
                            $recentActivities->push([
                                'type' => 'pending',
                                'title' => 'Pending Approval',
                                'description' => $pendingRequests . ' new admission requests waiting',
                                'time' => 'Now',
                                'icon' => 'exclamation-triangle',
                                'color' => '#ef4444',
                                'bg' => '#fee2e2',
                            ]);
                        }

                        $recentActivities = $recentActivities->take(5);
                    @endphp

                    @forelse($recentActivities as $activity)
                        <div class="activity-item">
                            <div class="activity-icon"
                                style="background: {{ $activity['bg'] }}; color: {{ $activity['color'] }};">
                                <i class="fas fa-{{ $activity['icon'] }}"></i>
                            </div>
                            <div class="activity-content">
                                <h5>{{ $activity['title'] }}</h5>
                                <p>{{ $activity['description'] }}</p>
                            </div>
                            <div class="activity-time">{{ $activity['time'] }}</div>
                        </div>
                    @empty
                        <div class="empty-state">
                            <i class="fas fa-inbox"></i>
                            <p>No recent activity</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Bottom Section -->
        <div class="bottom-grid">
            <!-- Class & Section-wise Attendance -->
            <div class="chart-card">
                <div class="section-title-with-date">
                    <h3 class="section-title-left">
                        <i class="fas fa-chart-bar"></i>
                        Class & Section Attendance
                    </h3>
                    <span class="section-date">
                        <i class="fas fa-calendar-day"></i>
                        {{ date('d M Y') }}
                    </span>
                </div>

                <div class="attendance-scroll-container">
                    @php
                        // Get all classes with their sections
                        $classes = \App\Models\Masters\StdClass::with('sections')->get();
                        $attendanceData = collect();

                        foreach ($classes as $class) {
                            $sections = $class->sections ?? collect([]);

                            if ($sections->count() > 0) {
                                // Class with sections
                                foreach ($sections as $section) {
                                    $sectionStudents = \App\Models\Students\Crud::where('class_id', $class->id)
                                        ->where('section_id', $section->id)
                                        ->count();
                                    $sectionPresentToday = \App\Models\Attendance\StudentAttendance::whereDate(
                                        'date',
                                        today(),
                                    )
                                        ->where('status', 'present')
                                        ->whereHas('student', function ($q) use ($class, $section) {
                                            $q->where('class_id', $class->id)->where('section_id', $section->id);
                                        })
                                        ->count();
                                    $sectionAttendanceRate =
                                        $sectionStudents > 0
                                            ? round(($sectionPresentToday / $sectionStudents) * 100)
                                            : 0;

                                    $attendanceData->push([
                                        'name' => $class->class_name . ' - ' . $section->section_name,
                                        'present' => $sectionPresentToday,
                                        'total' => $sectionStudents,
                                        'rate' => $sectionAttendanceRate,
                                    ]);
                                }
                            } else {
                                // Class without sections
                                $classStudents = \App\Models\Students\Crud::where('class_id', $class->id)->count();
                                $classPresentToday = \App\Models\Attendance\StudentAttendance::whereDate(
                                    'date',
                                    today(),
                                )
                                    ->where('status', 'present')
                                    ->whereHas('student', function ($q) use ($class) {
                                        $q->where('class_id', $class->id);
                                    })
                                    ->count();
                                $classAttendanceRate =
                                    $classStudents > 0 ? round(($classPresentToday / $classStudents) * 100) : 0;

                                $attendanceData->push([
                                    'name' => $class->class_name,
                                    'present' => $classPresentToday,
                                    'total' => $classStudents,
                                    'rate' => $classAttendanceRate,
                                ]);
                            }
                        }
                    @endphp

                    @forelse($attendanceData as $data)
                        <div class="section-attendance">
                            <div class="section-header section-header-bg">
                                <span class="section-name">
                                    <i class="fas fa-graduation-cap"></i>
                                    {{ $data['name'] }}
                                </span>
                                <span class="section-percentage">{{ $data['rate'] }}%</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: {{ $data['rate'] }}%"></div>
                            </div>
                            <div class="attendance-stats">
                                <span>
                                    <i class="fas fa-check-circle" style="color: #10b981;"></i>
                                    Present: {{ $data['present'] }}
                                </span>
                                <span>
                                    <i class="fas fa-users" style="color: #64748b;"></i>
                                    Total: {{ $data['total'] }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="empty-state">
                            <i class="fas fa-school"></i>
                            <p>No classes found</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Pending Requests Details -->
            <div class="chart-card">
                <h3 class="section-title">
                    <i class="fas fa-hourglass-half"></i>
                    Pending Requests
                </h3>
                @php
                    $pendingStudents = \App\Models\Students\Crud::where('status', 'pending')->latest()->take(5)->get();
                @endphp
                @forelse($pendingStudents as $student)
                    <div class="request-item">
                        <div class="request-info">
                            <h5>{{ $student->student_name }}</h5>
                            <p>Class: {{ $student->promoted_class_name ?? 'N/A' }} • Applied
                                {{ $student->created_at->diffForHumans() }}</p>
                        </div>
                        <span class="request-badge">Pending</span>
                    </div>
                @empty
                    <div class="empty-state">
                        <i class="fas fa-check-double"></i>
                        <p>No pending requests</p>
                    </div>
                @endforelse
                @if ($pendingStudents->count() > 0)
                    <a href="{{ route('admin.student.pending.list') }}" class="view-all">
                        View All Requests <i class="fas fa-arrow-right"></i>
                    </a>
                @endif
            </div>
        </div>

        <!-- Footer -->
        <footer class="footer mt-4 py-3"
            style="background: linear-gradient(90deg, #383838 0%, #757575 100%); color: #fff; box-shadow: 0 -2px 8px rgba(0, 0, 0, 0.1); border-radius: 15px;">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-md-6 text-start">
                        <p class="mb-0 fw-semibold">
                            © <span id="currentYear"></span>
                            <a href="#" class="text-white text-decoration-none fw-bold hover-link">
                                Tech RLP Team
                            </a> — All Rights Reserved
                        </p>
                    </div>
                    <div class="col-md-6 text-end">
                        <ul class="list-inline mb-0">
                            <li class="list-inline-item">
                                <a href="#" class="text-white text-decoration-none hover-link">Contact</a>
                            </li>
                            <li class="list-inline-item">
                                <a href="#" class="text-white text-decoration-none hover-link">About Us</a>
                            </li>
                            <li class="list-inline-item">
                                <a href="#" class="text-white text-decoration-none hover-link">Terms</a>
                            </li>
                            <li class="list-inline-item">
                                <a href="#" class="text-white text-decoration-none hover-link">Booking</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Auto update year
        document.getElementById("currentYear").textContent = new Date().getFullYear();

        // Hover effect for footer links
        const links = document.querySelectorAll(".hover-link");
        links.forEach(link => {
            link.addEventListener("mouseenter", () => {
                link.style.textShadow = "0 0 8px rgba(255,255,255,0.8)";
            });
            link.addEventListener("mouseleave", () => {
                link.style.textShadow = "none";
            });
        });

        // Dynamic Enrollment Chart
        const ctx = document.getElementById("enrollmentChart").getContext("2d");

        @php
            // Get enrollment data for last 12 months
            $monthlyData = [];
            $labels = [];

            for ($i = 11; $i >= 0; $i--) {
                $date = now()->subMonths($i);
                $labels[] = $date->format('M');

                // Count students created up to that month
                $count = \App\Models\Students\Crud::whereYear('created_at', '<=', $date->year)->whereMonth('created_at', '<=', $date->month)->count();

                $monthlyData[] = $count;
            }
        @endphp

        const enrollmentChart = new Chart(ctx, {
            type: "line",
            data: {
                labels: {!! json_encode($labels) !!},
                datasets: [{
                    label: "Total Students Enrolled",
                    data: {!! json_encode($monthlyData) !!},
                    borderColor: "#667eea",
                    backgroundColor: "rgba(102, 126, 234, 0.1)",
                    fill: true,
                    tension: 0.4,
                    borderWidth: 3,
                    pointBackgroundColor: "#667eea",
                    pointBorderColor: "#fff",
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: true,
                        labels: {
                            color: "#1e293b",
                            font: {
                                size: 13,
                                weight: '600'
                            }
                        }
                    },
                    tooltip: {
                        enabled: true,
                        backgroundColor: "#1e293b",
                        titleColor: "#fff",
                        bodyColor: "#fff",
                        padding: 12,
                        borderColor: "#667eea",
                        borderWidth: 1,
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                return 'Students: ' + context.parsed.y.toLocaleString();
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: "Month",
                            color: "#64748b",
                            font: {
                                size: 12,
                                weight: '600'
                            }
                        },
                        ticks: {
                            color: "#64748b"
                        },
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: "Number of Students",
                            color: "#64748b",
                            font: {
                                size: 12,
                                weight: '600'
                            }
                        },
                        beginAtZero: true,
                        ticks: {
                            color: "#64748b",
                            callback: function(value) {
                                return value.toLocaleString();
                            }
                        },
                        grid: {
                            color: "#f1f5f9"
                        }
                    }
                }
            }
        });

        // Download Report Function
        function generateReport() {
            // Show loading state
            const btn = event.target.closest('.btn-custom');
            const originalHTML = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Generating...';
            btn.disabled = true;

            // Simulate report generation
            setTimeout(() => {
                btn.innerHTML = '<i class="fas fa-check"></i> Downloaded!';

                setTimeout(() => {
                    btn.innerHTML = originalHTML;
                    btn.disabled = false;
                }, 2000);
            }, 1500);

            // In real implementation, you would call your report generation endpoint

        }

        // Add smooth scroll for progress bars on load
        document.addEventListener('DOMContentLoaded', function() {
            const progressBars = document.querySelectorAll('.progress-fill');
            progressBars.forEach((bar, index) => {
                const width = bar.style.width;
                bar.style.width = '0%';
                setTimeout(() => {
                    bar.style.width = width;
                }, index * 100);
            });
        });
    </script>
@endsection
