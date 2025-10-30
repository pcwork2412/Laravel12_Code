<?php

namespace App\Http\Controllers\Attendance;

use App\Http\Controllers\Controller;
use App\Models\Attendance\StudentAttendance;
use App\Models\Masters\Section;
use App\Models\Masters\StdClass;
use App\Models\Students\Crud;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\Calculation\Statistical\Distributions\StudentT;
use Yajra\DataTables\Facades\DataTables;

class StudentAttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // 🧾 Step 1: Index View
   public function index(Request $request)
{
    // 🧠 Step 1: AJAX request handle
    if ($request->ajax()) {

        // ✅ Fetch all attendance records with relations
        $data = StudentAttendance::with(['student', 'section', 'class'])
            ->latest();

        // ✅ Get filters
        $date = $request->attendance_date ?? now()->toDateString();

        // ✅ Apply filters
        if (!empty($date)) {
            $data->whereDate('date', $date);
        }

        // ✅ Filter by class if not "All"
        if ($request->class_id && $request->class_id != 'All') {
            $data->where('class_id', $request->class_id);
        }

        // ✅ Filter by section if not "All"
        if ($request->section_id && $request->section_id != 'All') {
            $data->where('section_id', $request->section_id);
        }

        // ✅ Return DataTable
        return DataTables::of($data)
            ->addIndexColumn()

            // Student Name
            ->addColumn('student_name', fn($row) => $row->student->student_name ?? 'N/A')

            // Class
            ->addColumn('class', fn($row) => $row->class->class_name ?? '')

            // Section
            ->addColumn('section', fn($row) => 'Sec-' . trim($row->section->section_name ?? ''))

            // Date Format
            ->editColumn('date', fn($row) => \Carbon\Carbon::parse($row->date)->format('D, d M Y'))

            // Reason Format
            ->editColumn('reason', fn($row) => $row->reason ?? '-')

            // Status Badge
            ->addColumn('status_badge', function ($row) {
                $color = match ($row->status) {
                    'Present' => 'success',
                    'Absent'  => 'danger',
                    'Leave'   => 'warning',
                    default   => 'secondary',
                };
                return "<span class='badge bg-$color p-2 fw-normal fs-6'>$row->status</span>";
            })

            // Action Buttons
            ->addColumn('action', function ($row) {
                return '
                   
                    <button class="btn btn-sm btn-warning text-white viewBtn" data-id="' . $row->student_id . '">
                        <i class="fas fa-eye"></i>
                    </button>
                    <button class="btn btn-sm btn-info editBtn" data-id="' . $row->id . '">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn btn-sm btn-danger deleteBtn" data-id="' . $row->id . '">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                ';
            })

            ->rawColumns(['status_badge', 'action'])
            ->make(true);
    }

    // 🖥️ Step 3: Return the index view
    $classes = StdClass::all();
    return view('school_dashboard.admin_pages.students.attendance.index', compact('classes'));
}
   public function report(Request $request)
{
    // 🧠 Step 1: AJAX request handle
    if ($request->ajax()) {

        // ✅ Fetch all attendance records with relations
        $data = StudentAttendance::with(['student', 'section', 'class'])
            ->latest();

        // ✅ Get filters
        $date = $request->attendance_date ?? now()->toDateString();

        // ✅ Apply filters
        if (!empty($date)) {
            $data->whereDate('date', $date);
        }

        // ✅ Filter by class if not "All"
        if ($request->class_id && $request->class_id != 'All') {
            $data->where('class_id', $request->class_id);
        }

        // ✅ Filter by section if not "All"
        if ($request->section_id && $request->section_id != 'All') {
            $data->where('section_id', $request->section_id);
        }

        // ✅ Return DataTable
        return DataTables::of($data)
            ->addIndexColumn()

            // Student Name
            ->addColumn('student_name', fn($row) => $row->student->student_name ?? 'N/A')

            // Class
            ->addColumn('class', fn($row) => $row->class->class_name ?? '')

            // Section
            ->addColumn('section', fn($row) => 'Sec-' . trim($row->section->section_name ?? ''))

            // Date Format
            ->editColumn('date', fn($row) => \Carbon\Carbon::parse($row->date)->format('D, d M Y'))

            // Reason Format
            ->editColumn('reason', fn($row) => $row->reason ?? '-')

            // Status Badge
            ->addColumn('status_badge', function ($row) {
                $color = match ($row->status) {
                    'Present' => 'success',
                    'Absent'  => 'danger',
                    'Leave'   => 'warning',
                    default   => 'secondary',
                };
                return "<span class='badge bg-$color p-2 fw-normal fs-6'>$row->status</span>";
            })

            // Action Buttons
            ->addColumn('action', function ($row) {
                return '
                 <button class="btn btn-sm btn-info text-white viewBtn" data-id="' . $row->student_id . '">
                        <i class="fas fa-eye"></i> View Full Report
                    </button>
                ';
            })

            ->rawColumns(['status_badge', 'action'])
            ->make(true);
    }

    // 🖥️ Step 3: Return the index view
    $classes = StdClass::all();
    return view('school_dashboard.admin_pages.students.attendance.reportlist', compact('classes'));
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $classes = StdClass::all();
        return view('school_dashboard.admin_pages.students.attendance.create', compact('classes'));
    }

    // Class select -> sections load
    // public function fetchSections(Request $request)
    // {
    //     $sections = Section::where('class_id', $request->class_id)->get();
    //     return response()->json($sections);
    // }

    // Section select -> students load
    public function fetchStudents(Request $request)
    {
        $students = Crud::where('section_id', $request->section_id)->where('class_id', $request->class_id)->get();
        return response()->json($students);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 🧾 Step 1: Basic validation
        $request->validate([
            'class_id'   => 'required|exists:std_classes,id',
            'section_id'   => 'required|exists:sections,id',
            'date'         => 'required|date',
            'student_ids'  => 'required|array',
        ]);

        // 🚫 Step 2: Check if attendance already exists
        $exists = StudentAttendance::where('date', $request->date)
            ->where('section_id', $request->section_id)
            ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'Attendance already exists for this Class,Section and date.'
            ]);
        }

        // 📦 Step 3: Get data safely
        $absent  = $request->absent ?? [];
        $leave   = $request->leave ?? [];
        $reasons = $request->reason ?? [];

        // ⚠️ Step 4: Validate Leave reason
        foreach ($leave as $studentId) {
            if (empty($reasons[$studentId])) {
                // Student name fetch karte hain
                $student = Crud::find($studentId);
                $studentName = $student ? $student->student_name : 'Unknown Student';

                return response()->json([
                    'success' => false,
                    'message' => "Please provide a reason for student Name: {$studentName} (Leave)."
                ]);
            }
        }

        // 🧠 Step 5: Save attendance
        foreach ($request->student_ids as $studentId) {

            // Leave > Absent > Present
            if (in_array($studentId, $leave)) {
                $status = 'Leave';
            } elseif (in_array($studentId, $absent)) {
                $status = 'Absent';
            } else {
                $status = 'Present';
            }

            StudentAttendance::create([
                'student_id' => $studentId,
                'section_id' => $request->section_id,
                'class_id'   => $request->class_id,
                'date'       => $request->date,
                'status'     => $status,
                'reason'     => $reasons[$studentId] ?? null,
            ]);
        }

        // ✅ Step 6: Success response
        return response()->json([
            'success' => true,
            'message' => 'Attendance created successfully.'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id)
    {
        $student = Crud::findOrFail($id);

        // 🗓 Select month from input or current month
        $selectedMonth = $request->get('month') ?? now()->format('Y-m');

        // Parse month + year from the input
        $date = \Carbon\Carbon::createFromFormat('Y-m', $selectedMonth);
        $month = $date->month;
        $year = $date->year;

        // 🎯 Get attendance for selected month
        $attendance = StudentAttendance::where('student_id', $id)
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->get(['date', 'status']);

        // 🗂️ Convert to [day => status] array
        $attendanceData = [];
        foreach ($attendance as $record) {
            $day = \Carbon\Carbon::parse($record->date)->day;
            // P = Present, A = Absent, L = Leave
            $status = match (strtolower($record->status)) {
                'present' => 'P',
                'absent' => 'A',
                'leave' => 'L',
                default => '-'
            };
            $attendanceData[$day] = $status;
        }

        // 🔹 Pass data to view
        return view('school_dashboard.admin_pages.students.attendance.report', [
            'student' => $student,
            'attendanceData' => $attendanceData,
            'selectedMonth' => $selectedMonth,
            'month' => $month,
            'year' => $year,
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     */
    // ✏️ Step 4: Edit Record
    public function edit($id)
    {
        $attendance = StudentAttendance::with('student')->findOrFail($id);

        return response()->json([
            'id' => $attendance->id,
            'student_name' => $attendance->student->student_name, // assuming relation 'student'
            'date' => $attendance->date,
            'status' => $attendance->status,
            'reason' => $attendance->reason,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Present,Absent,Leave',
            'reason' => 'required_if:status,Leave',
        ]);

        $attendance = StudentAttendance::findOrFail($id);
        $attendance->status = $request->status;
        $attendance->reason = $request->reason;
        $attendance->save();

        return response()->json(['message' => 'Attendance updated successfully!']);
    }


    /**
     * Remove the specified resource from storage.
     */
    // ❌ Step 6: Delete Record
    public function destroy($id)
    {
        $attendance = StudentAttendance::findOrFail($id);
        $attendance->delete();

        return response()->json(['success' => true, 'message' => 'Record deleted successfully.']);
    }
}
