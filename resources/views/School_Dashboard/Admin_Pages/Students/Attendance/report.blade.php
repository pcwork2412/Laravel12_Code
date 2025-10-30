@extends('school_dashboard.admin_layouts.app')

@section('content')
    @php
        use Carbon\Carbon;

        $daysInMonth = Carbon::createFromDate($year, $month)->daysInMonth;
        $firstDayOfWeek = Carbon::createFromDate($year, $month, 1)->dayOfWeek;
    @endphp

    <style>
        .attendance-container {
            min-height: 100vh;
            padding: 2rem 0;
            background: #f5f7fa;
        }

        .attendance-card {
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        .card-header-custom {
            background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%);
            color: white;
            padding: 2rem;
            border-radius: 20px 20px 0 0;
        }

        .header-title {
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .header-subtitle {
            opacity: 0.95;
            font-size: 0.95rem;
        }

        .action-buttons {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        .btn-modern {
            padding: 0.6rem 1.25rem;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            border: 2px solid;
        }

        .btn-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        .btn-print {
            background: white;
            color: #4F46E5;
            border-color: white;
        }

        .btn-print:hover {
            background: #F9FAFB;
            color: #4338CA;
        }

        .btn-list {
            background: transparent;
            color: white;
            border-color: white;
        }

        .btn-list:hover {
            background: rgba(255, 255, 255, 0.15);
            color: white;
        }

        .student-info-card {
            background: linear-gradient(135deg, #EEF2FF 0%, #E0E7FF 100%);
            border-radius: 15px;
            margin: 2rem 0;
            border: 1px solid #C7D2FE;
        }

        .info-item {
            text-align: center;
            padding: 1rem;
        }

        .info-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 1.5rem;
            color: white;
            box-shadow: 0 4px 15px rgba(79, 70, 229, 0.3);
        }

        .info-label {
            font-size: 0.85rem;
            color: #6B7280;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.5rem;
        }

        .info-value {
            font-size: 1.1rem;
            font-weight: 700;
            color: #1F2937;
        }

        .month-selector {
            background: #F9FAFB;
            padding: 1.5rem;
            border-radius: 15px;
            margin-bottom: 2rem;
            text-align: center;
            border: 1px solid #E5E7EB;
        }

        .month-input-wrapper {
            display: inline-flex;
            align-items: center;
            gap: 1rem;
            background: white;
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            border: 1px solid #E5E7EB;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .month-input-wrapper:hover {
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.15);
            border-color: #4F46E5;
        }

        .month-input-wrapper i {
            color: #4F46E5;
            font-size: 1.25rem;
        }

        .month-input-wrapper input {
            border: none;
            outline: none;
            font-weight: 600;
            color: #1F2937;
            font-size: 1rem;
        }

        .calendar-table {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.06);
        }

        .calendar-table thead {
            background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%);
        }

        .calendar-table thead th {
            padding: 1rem 1rem;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 1rem;
            letter-spacing: 0.8px;
            border: rgb(187, 186, 186) 1px solid;
            position: relative;
            color: white;
            background-color: #667eea;
        }

        .calendar-table thead th:first-child {
            border-radius: 12px 0 0 0;
        }

        .calendar-table thead th:last-child {
            border-radius: 0 12px 0 0;
        }

        .calendar-table thead th i {
            margin-right: 0.5rem;
            font-size: 1rem;
        }

        .calendar-table tbody td {
            padding: 1.5rem 0.75rem;
            font-weight: 600;
            font-size: 1.1rem;
            border: 2px solid #F3F4F6;
            transition: all 0.3s ease;
            background: white;
            color: #374151;
        }

        .calendar-table tbody td:hover {
            background: #F9FAFB;
            transform: scale(1.05);
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.15);
            z-index: 10;
        }

        .calendar-table tbody td.bg-success {
            background: linear-gradient(135deg, #10B981 0%, #059669 100%) !important;
            color: white;
            box-shadow: 0 3px 12px rgba(16, 185, 129, 0.3) !important;
            border-color: #059669;
        }

        .calendar-table tbody td.bg-success:hover {
            transform: scale(1.08);
            box-shadow: 0 5px 18px rgba(16, 185, 129, 0.4) !important;
        }

        .calendar-table tbody td.bg-danger {
            background: linear-gradient(135deg, #EF4444 0%, #DC2626 100%) !important;
            color: white;
            box-shadow: 0 3px 12px rgba(239, 68, 68, 0.3) !important;
            border-color: #DC2626;
        }

        .calendar-table tbody td.bg-danger:hover {
            transform: scale(1.08);
            box-shadow: 0 5px 18px rgba(239, 68, 68, 0.4) !important;
        }

        .calendar-table tbody td.bg-warning {
            background: linear-gradient(135deg, #F59E0B 0%, #D97706 100%) !important;
            color: white;
            box-shadow: 0 3px 12px rgba(245, 158, 11, 0.3) !important;
            border-color: #D97706;
        }

        .calendar-table tbody td.bg-warning:hover {
            transform: scale(1.08);
            box-shadow: 0 5px 18px rgba(245, 158, 11, 0.4) !important;
        }

        .legend-section {
            text-align: center;
            margin: 2rem 0 1.5rem;
        }

        .legend-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            font-weight: 600;
            margin: 0 0.5rem 0.5rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            color: white;
        }

        .legend-badge.bg-success {
            background: linear-gradient(135deg, #10B981 0%, #059669 100%);
        }

        .legend-badge.bg-danger {
            background: linear-gradient(135deg, #EF4444 0%, #DC2626 100%);
        }

        .legend-badge.bg-warning {
            background: linear-gradient(135deg, #F59E0B 0%, #D97706 100%);
        }

        .legend-badge i {
            font-size: 1.1rem;
        }

        .summary-section {
            background: #F9FAFB;
            border-radius: 15px;
            padding: 2rem;
            margin-top: 2rem;
            border: 1px solid #E5E7EB;
        }

        .summary-item {
            text-align: center;
            padding: 1.5rem;
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04);
            transition: all 0.3s ease;
            border: 1px solid #F3F4F6;
        }

        .summary-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        .summary-icon {
            width: 60px;
            height: 60px;
            margin: 0 auto 1rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.75rem;
        }

        .summary-icon.present {
            background: linear-gradient(135deg, #10B981 0%, #059669 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
        }

        .summary-icon.absent {
            background: linear-gradient(135deg, #EF4444 0%, #DC2626 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);
        }

        .summary-icon.leave {
            background: linear-gradient(135deg, #F59E0B 0%, #D97706 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3);
        }

        .summary-icon.rate {
            background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(79, 70, 229, 0.3);
        }

        .summary-value {
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
        }

        .summary-value.text-success {
            color: #10B981;
        }

        .summary-value.text-danger {
            color: #EF4444;
        }

        .summary-value.text-warning {
            color: #F59E0B;
        }

        .summary-value.text-primary {
            color: #4F46E5;
        }

        .summary-label {
            font-size: 0.9rem;
            color: #6B7280;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        @media print {
            .attendance-container {
                background: white;
                padding: 0;
            }

            .action-buttons,
            .btn-modern {
                display: none !important;
            }
        }
    </style>

    <div id="attendanceSection" class="attendance-container">
        <div class="container">
            <div class="attendance-card">
                <!-- Header -->
                <div class="card-header-custom">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                        <div>
                            <h1 class="header-title">
                                <i class="bi bi-calendar-check"></i>
                                Student Monthly Attendance
                            </h1>
                            <p class="header-subtitle mb-0">
                                <i class="bi bi-info-circle"></i>
                                Track and monitor attendance with detailed calendar view
                            </p>
                        </div>

                        <div class="action-buttons">
                            <button id="printReportBtn" class="btn btn-modern btn-print">
                                <i class="bi bi-printer-fill"></i>
                                Print Report
                            </button>
                            <button id="smartBackBtn" class="btn btn-modern btn-list">
                                <i class="fa fa-arrow-left me-1"></i> Back
                            </button>
                        </div>
                    </div>
                </div>

                <div class="p-4">
                    <!-- Student Info -->
                    <div class="student-info-card">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="info-item">
                                    <div class="info-icon">
                                        <i class="bi bi-person-fill"></i>
                                    </div>
                                    <div class="info-label">Student Name</div>
                                    <div class="info-value">{{ $student->student_name }}</div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="info-item">
                                    <div class="info-icon">
                                        <i class="bi bi-envelope-fill"></i>
                                    </div>
                                    <div class="info-label">Email Address</div>
                                    <div class="info-value">{{ $student->email_id }}</div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="info-item">
                                    <div class="info-icon">
                                        <i class="bi bi-book-fill"></i>
                                    </div>
                                    <div class="info-label">Class</div>
                                    <div class="info-value">{{ $student->promoted_class_name ?? 'N/A' }}</div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="info-item">
                                    <div class="info-icon">
                                        <i class="bi bi-credit-card-fill"></i>
                                    </div>
                                    <div class="info-label">Student ID</div>
                                    <div class="info-value">{{ $student->student_uid }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Month Selector -->
                    <div class="month-selector">
                        <label for="" class="fs-5 fw-bold">Select Month </label>
                        <form method="GET" action="{{ route('student_attendance.show', $student->id) }}" id="monthForm">
                            <div class="month-input-wrapper" onclick="document.getElementById('monthInput').showPicker()">
                                <input type="month" name="month" id="monthInput" value="{{ $selectedMonth }}"
                                    class="form-control-plaintext" onchange="this.form.submit()">
                                <i class="bi bi-chevron-down"></i>
                            </div>
                        </form>
                    </div>

                    <!-- Calendar Table -->
                    <div class="table-responsive">
                        <table class="table calendar-table text-center align-middle mb-0">
                            <thead>
                                <tr>
                                    <th><i class="bi bi-sun"></i> Sun</th>
                                    <th><i class="bi bi-moon"></i> Mon</th>
                                    <th><i class="bi bi-moon"></i> Tue</th>
                                    <th><i class="bi bi-moon"></i> Wed</th>
                                    <th><i class="bi bi-moon"></i> Thu</th>
                                    <th><i class="bi bi-moon"></i> Fri</th>
                                    <th><i class="bi bi-sun"></i> Sat</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $day = 1;
                                    $weekDay = $firstDayOfWeek;
                                @endphp

                                @while ($day <= $daysInMonth)
                                    <tr>
                                        {{-- Empty cells before first day --}}
                                        @for ($i = 0; $i < $firstDayOfWeek && $day == 1; $i++)
                                            <td></td>
                                        @endfor

                                        {{-- Loop through days --}}
                                        @for ($col = $firstDayOfWeek; $col < 7 && $day <= $daysInMonth; $col++)
                                            @php
                                                $status = $attendanceData[$day] ?? null;
                                                $class = '';
                                                $label = '';

                                                if ($status === 'P') {
                                                    $class = 'bg-success text-white fw-bold';
                                                    $label = 'P';
                                                } elseif ($status === 'A') {
                                                    $class = 'bg-danger text-white fw-bold';
                                                    $label = 'A';
                                                } elseif ($status === 'L') {
                                                    $class = 'bg-warning text-white fw-bold';
                                                    $label = 'L';
                                                }
                                            @endphp
                                            <td class="{{ $class }}">{{ $day }}<br>{{ $label }}</td>
                                            @php $day++; @endphp
                                        @endfor

                                        {{-- Reset firstDayOfWeek after first row --}}
                                        @php $firstDayOfWeek = 0; @endphp
                                    </tr>
                                @endwhile
                            </tbody>
                        </table>
                    </div>

                    <!-- Legend -->
                    <div class="legend-section">
                        <span class="legend-badge bg-success">
                            <i class="bi bi-check-circle-fill"></i>
                            Present (P)
                        </span>
                        <span class="legend-badge bg-danger">
                            <i class="bi bi-x-circle-fill"></i>
                            Absent (A)
                        </span>
                        <span class="legend-badge bg-warning">
                            <i class="bi bi-calendar-x-fill"></i>
                            Leave (L)
                        </span>
                    </div>

                    <!-- Summary -->
                    @php
                        $presentCount = collect($attendanceData)->where(fn($v) => $v === 'P')->count();
                        $absentCount = collect($attendanceData)->where(fn($v) => $v === 'A')->count();
                        $leaveCount = collect($attendanceData)->where(fn($v) => $v === 'L')->count();
                        $totalMarked = $presentCount + $absentCount + $leaveCount;
                        $attendanceRate = $totalMarked > 0 ? round(($presentCount / $totalMarked) * 100) : 0;
                    @endphp

                    <div class="summary-section">
                        <div class="row g-4">
                            <div class="col-md-3">
                                <div class="summary-item">
                                    <div class="summary-icon present">
                                        <i class="bi bi-check-circle-fill"></i>
                                    </div>
                                    <div class="summary-value text-success">{{ $presentCount }}</div>
                                    <div class="summary-label">Days Present</div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="summary-item">
                                    <div class="summary-icon absent">
                                        <i class="bi bi-x-circle-fill"></i>
                                    </div>
                                    <div class="summary-value text-danger">{{ $absentCount }}</div>
                                    <div class="summary-label">Days Absent</div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="summary-item">
                                    <div class="summary-icon leave">
                                        <i class="bi bi-calendar-x-fill"></i>
                                    </div>
                                    <div class="summary-value text-warning">{{ $leaveCount }}</div>
                                    <div class="summary-label">Days Leave</div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="summary-item">
                                    <div class="summary-icon rate">
                                        <i class="bi bi-graph-up"></i>
                                    </div>
                                    <div class="summary-value text-primary">{{ $attendanceRate }}%</div>
                                    <div class="summary-label">Attendance Rate</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        document.getElementById('printReportBtn').addEventListener('click', () => {
            try {
                const {
                    jsPDF
                } = window.jspdf;
                const doc = new jsPDF();

                const studentName = "{{ $student->student_name }}";
                const studentEmail = "{{ $student->email_id }}";
                const studentId = "{{ $student->student_uid }}";
                const studentClass = "{{ $student->promoted_class_name ?? 'N/A' }}";
                const selectedMonth = "{{ $selectedMonth }}";

                const attendanceData = @json($attendanceData);
                const daysInMonth = {{ $daysInMonth }};
                const firstDayOfWeek = {{ Carbon::createFromDate($year, $month, 1)->dayOfWeek }};

                let presentCount = 0;
                let absentCount = 0;
                let leaveCount = 0;
                Object.values(attendanceData).forEach(status => {
                    if (status === 'P') presentCount++;
                    if (status === 'A') absentCount++;
                    if (status === 'L') leaveCount++;
                });
                const totalMarked = presentCount + absentCount + leaveCount;
                const attendanceRate = totalMarked > 0 ? Math.round((presentCount / totalMarked) * 100) : 0;

                doc.setFillColor(79, 70, 229);
                doc.rect(0, 0, 210, 35, 'F');
                doc.setTextColor(255, 255, 255);
                doc.setFontSize(20);
                doc.setFont(undefined, 'bold');
                doc.text('Student Monthly Attendance Report', 105, 15, {
                    align: 'center'
                });
                doc.setFontSize(10);
                doc.setFont(undefined, 'normal');
                doc.text('Track and monitor attendance with detailed calendar view', 105, 25, {
                    align: 'center'
                });

                doc.setTextColor(0, 0, 0);
                doc.setFontSize(12);
                doc.setFont(undefined, 'bold');
                doc.text('Student Information', 14, 45);

                doc.autoTable({
                    startY: 50,
                    head: [
                        ['Student Name', 'Email', 'Class', 'Student ID']
                    ],
                    body: [
                        [studentName, studentEmail, studentClass, studentId]
                    ],
                    theme: 'grid',
                    headStyles: {
                        fillColor: [79, 70, 229],
                        textColor: [255, 255, 255],
                        fontStyle: 'bold',
                        halign: 'center'
                    },
                    bodyStyles: {
                        halign: 'center',
                        fontSize: 9
                    },
                    margin: {
                        left: 14,
                        right: 14
                    }
                });

                const finalY = doc.lastAutoTable.finalY || 70;
                doc.setFontSize(11);
                doc.setFont(undefined, 'bold');
                doc.text(`Month: ${selectedMonth}`, 14, finalY + 10);

                const calendarData = [];
                const weekDays = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];

                let day = 1;
                let currentWeek = [];

                for (let i = 0; i < firstDayOfWeek; i++) {
                    currentWeek.push('');
                }

                while (day <= daysInMonth) {
                    const status = attendanceData[day] || '';
                    const cellContent = status ? `${day}\n(${status})` : `${day}`;
                    currentWeek.push(cellContent);

                    if (currentWeek.length === 7) {
                        calendarData.push([...currentWeek]);
                        currentWeek = [];
                    }
                    day++;
                }

                while (currentWeek.length > 0 && currentWeek.length < 7) {
                    currentWeek.push('');
                }
                if (currentWeek.length > 0) {
                    calendarData.push(currentWeek);
                }

                doc.setFontSize(12);
                doc.setFont(undefined, 'bold');
                doc.text('Attendance Calendar', 14, finalY + 20);

                doc.autoTable({
                    startY: finalY + 25,
                    head: [weekDays],
                    body: calendarData,
                    theme: 'grid',
                    headStyles: {
                        fillColor: [79, 70, 229],
                        textColor: [255, 255, 255],
                        fontStyle: 'bold',
                        halign: 'center',
                        fontSize: 10
                    },
                    bodyStyles: {
                        halign: 'center',
                        valign: 'middle',
                        fontSize: 9,
                        minCellHeight: 12
                    },
                    columnStyles: {
                        0: {
                            cellWidth: 25
                        },
                        1: {
                            cellWidth: 25
                        },
                        2: {
                            cellWidth: 25
                        },
                        3: {
                            cellWidth: 25
                        },
                        4: {
                            cellWidth: 25
                        },
                        5: {
                            cellWidth: 25
                        },
                        6: {
                            cellWidth: 25
                        }
                    },
                    didParseCell: function(data) {
                        if (data.section === 'body' && data.cell.text[0]) {
                            const cellText = data.cell.text[0];
                            if (cellText.includes('(P)')) {
                                data.cell.styles.fillColor = [16, 185, 129];
                                data.cell.styles.textColor = [255, 255, 255];
                                data.cell.styles.fontStyle = 'bold';
                            } else if (cellText.includes('(A)')) {
                                data.cell.styles.fillColor = [239, 68, 68];
                                data.cell.styles.textColor = [255, 255, 255];
                                data.cell.styles.fontStyle = 'bold';
                            } else if (cellText.includes('(L)')) {
                                data.cell.styles.fillColor = [245, 158, 11];
                                data.cell.styles.textColor = [255, 255, 255];
                                data.cell.styles.fontStyle = 'bold';
                            }
                        }
                    },
                    margin: {
                        left: 14,
                        right: 14
                    }
                });

                const legendY = doc.lastAutoTable.finalY + 10;
                doc.setFontSize(10);
                doc.setFont(undefined, 'normal');

                doc.setFillColor(16, 185, 129);
                doc.rect(40, legendY - 3, 8, 5, 'F');
                doc.text('Present (P)', 50, legendY);

                doc.setFillColor(239, 68, 68);
                doc.rect(85, legendY - 3, 8, 5, 'F');
                doc.text('Absent (A)', 95, legendY);

                doc.setFillColor(245, 158, 11);
                doc.rect(130, legendY - 3, 8, 5, 'F');
                doc.text('Leave (L)', 140, legendY);

                doc.setFontSize(12);
                doc.setFont(undefined, 'bold');
                doc.text('Attendance Summary', 14, legendY + 15);

                doc.autoTable({
                    startY: legendY + 20,
                    head: [
                        ['Days Present', 'Days Absent', 'Days Leave', 'Attendance Rate']
                    ],
                    body: [
                        [presentCount, absentCount, leaveCount, `${attendanceRate}%`]
                    ],
                    theme: 'grid',
                    headStyles: {
                        fillColor: [79, 70, 229],
                        textColor: [255, 255, 255],
                        fontStyle: 'bold',
                        halign: 'center'
                    },
                    bodyStyles: {
                        halign: 'center',
                        fontSize: 11,
                        fontStyle: 'bold'
                    },
                    columnStyles: {
                        0: {
                            textColor: [16, 185, 129]
                        },
                        1: {
                            textColor: [239, 68, 68]
                        },
                        2: {
                            textColor: [245, 158, 11]
                        },
                        3: {
                            textColor: [79, 70, 229]
                        }
                    },
                    margin: {
                        left: 14,
                        right: 14
                    }
                });

                doc.save(`Student_Attendance_${studentName}_${selectedMonth}.pdf`);

            } catch (err) {
                console.error(err);
                alert('Error generating PDF: ' + err.message);
            }
        });
    </script>
@endpush
