@extends('school_dashboard.admin_layouts.app')

@section('content')
    @php
        use Carbon\Carbon;

        $daysInMonth = Carbon::createFromDate($year, $month)->daysInMonth;
        $firstDayOfWeek = Carbon::createFromDate($year, $month, 1)->dayOfWeek;
    @endphp
<div id="attendanceSection">
    <div class="container my-5">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-body p-4">
                <!-- Attendance Section (jo aap print karna chahte ho) -->
                <div class="d-flex justify-content-between align-items-center mb-3 border-bottom pb-2">
                    <div>
                        <h4 class="fw-bold text-primary">Teacher Monthly Attendance</h4>
                        <p class="text-muted small mb-0">Track your attendance with this calendar view</p>
                    </div>

              <div class="actions">
                      <!-- Print Button -->
                    <button id="printReportBtn" class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-printer"></i> Print Report
                    </button>
                    <!-- Teacher Attendance List Button -->
                    <a href="{{route('teacher_attendance.index')}}"  class="btn btn-outline-danger btn-sm">
                        <i class="bi bi-list-ul"></i> Attendance List
                    </a>
              </div>
                </div>

                <!-- Teacher Info -->
                <div class="row text-center bg-light py-3 rounded mb-4">
                    <div class="col-md-4">
                        <span class="fw-semibold text-secondary d-block">Teacher Name</span>
                        <span class="fw-bold">{{ $teacher->teacher_name }}</span>
                    </div>
                    <div class="col-md-4">
                        <span class="fw-semibold text-secondary d-block">Email</span>
                        <span class="fw-bold">{{ $teacher->email }}</span>
                    </div>
                    <div class="col-md-4">
                        <span class="fw-semibold text-secondary d-block">Teacher ID</span>
                        <span class="fw-bold">{{ $teacher->teacher_id }}</span>
                    </div>
                </div>

                <!-- 🗓 Month Selector -->
                <form method="GET" action="{{ route('teacher_attendance.show', $teacher->id) }}"
                    class="d-flex justify-content-center mb-4">
                    <input type="month" name="month" value="{{ $selectedMonth }}" class="form-control w-auto me-2"
                        onchange="this.form.submit()">
                </form>

                <!-- Calendar Table -->
                <div class="table-responsive">
                    <table class="table table-bordered text-center align-middle mb-4">
                        <thead class="table-primary">
                            <tr>
                                <th>Sun</th>
                                <th>Mon</th>
                                <th>Tue</th>
                                <th>Wed</th>
                                <th>Thu</th>
                                <th>Fri</th>
                                <th>Sat</th>
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

                <!-- Summary -->
                @php
                    $presentCount = collect($attendanceData)->where(fn($v) => $v === 'P')->count();
                    $absentCount = collect($attendanceData)->where(fn($v) => $v === 'A')->count();
                    $attendanceRate =
                        $presentCount + $absentCount > 0
                            ? round(($presentCount / ($presentCount + $absentCount)) * 100)
                            : 0;
                @endphp

                <div class="text-center mb-3">
                    <span class="badge bg-success px-3 py-2 me-2">Present (P)</span>
                    <span class="badge bg-danger px-3 py-2">Absent (A)</span>
                </div>

                <div class="row text-center">
                    <div class="col-md-4">
                        <span class="fw-bold text-success fs-5">{{ $presentCount }}</span><br>
                        <span class="text-secondary small">Days Present</span>
                    </div>
                    <div class="col-md-4">
                        <span class="fw-bold text-danger fs-5">{{ $absentCount }}</span><br>
                        <span class="text-secondary small">Days Absent</span>
                    </div>
                    <div class="col-md-4">
                        <span class="fw-bold text-primary fs-5">{{ $attendanceRate }}%</span><br>
                        <span class="text-secondary small">Attendance Rate</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

  
@endsection
@push('scripts')
      <script>
        document.getElementById('printReportBtn').addEventListener('click', async () => {
            try {
                const element = document.getElementById('attendanceSection');

                // 1) Ensure html2canvas available
                if (typeof html2canvas === 'undefined') {
                    alert('html2canvas loaded nahi hua — CDN include karen.');
                    return;
                }

                // 2) Get jsPDF constructor robustly (UMD exposes window.jspdf.jsPDF)
                const jsPDFConstructor = (window.jspdf && window.jspdf.jsPDF) ? window.jspdf.jsPDF :
                    (window.jsPDF ? window.jsPDF : null);

                if (!jsPDFConstructor) {
                    alert('jsPDF loaded nahi hua ya incompatible bundle. Use UMD build (jspdf.umd.min.js).');
                    return;
                }

                // 3) Render element to canvas (scale for better resolution)
                const canvas = await html2canvas(element, {
                    scale: 2,
                    useCORS: true,
                    allowTaint: true
                });
                const imgData = canvas.toDataURL('image/png');

                // 4) Prepare PDF sizes (mm)
                const pdf = new jsPDFConstructor('p', 'mm', 'a4');
                const pageWidth = pdf.internal.pageSize.getWidth();
                const pageHeight = pdf.internal.pageSize.getHeight();

                // convert canvas px to PDF mm
                const pxPerMm = canvas.width / (pageWidth * (96 /
                25.4)); // approximate — but simpler method below
                // Simpler: fit image width to pageWidth - margins
                const margin = 10; // mm
                const usableWidth = pageWidth - margin * 2;
                // compute image height keeping aspect ratio
                const imgProps = {
                    widthPx: canvas.width,
                    heightPx: canvas.height
                };
                const imgWidthMm = usableWidth;
                const imgHeightMm = (imgProps.heightPx * imgWidthMm) / imgProps.widthPx;

                // If single page fits
                if (imgHeightMm <= pageHeight - margin * 2) {
                    pdf.addImage(imgData, 'PNG', margin, margin, imgWidthMm, imgHeightMm);
                    pdf.save('Teacher_Attendance_Report.pdf');
                    return;
                }

                // Multi-page handling: slice the canvas vertically into pages
                const pageCanvas = document.createElement('canvas');
                const scale = canvas.width / imgWidthMm; // px per mm (approx)
                // Actually compute px height per PDF page
                const pxPerPage = Math.floor(canvas.width * ((pageHeight - margin * 2) / imgWidthMm));
                pageCanvas.width = canvas.width;
                pageCanvas.height = pxPerPage;

                const ctx = pageCanvas.getContext('2d');

                let renderedHeight = 0;
                let page = 0;
                while (renderedHeight < canvas.height) {
                    // clear and draw slice
                    ctx.clearRect(0, 0, pageCanvas.width, pageCanvas.height);
                    ctx.drawImage(
                        canvas,
                        0, renderedHeight, // source x,y
                        canvas.width, pxPerPage, // source w,h
                        0, 0, // dest x,y
                        pageCanvas.width, pageCanvas.height // dest w,h
                    );

                    const pageData = pageCanvas.toDataURL('image/png');
                    if (page > 0) pdf.addPage();

                    // The height on PDF for this slice: keep width = usableWidth, compute height proportional
                    const sliceImgHeightMm = (pageCanvas.height * imgWidthMm) / pageCanvas.width;
                    pdf.addImage(pageData, 'PNG', margin, margin, imgWidthMm, sliceImgHeightMm);

                    renderedHeight += pxPerPage;
                    page++;
                }

                pdf.save('Teacher_Attendance_Report.pdf');

            } catch (err) {
                console.error(err);
                alert('Kuch galat ho gaya — console me error dekhiye. (' + (err.message || err) + ')');
            }
        });
    </script>
@endpush