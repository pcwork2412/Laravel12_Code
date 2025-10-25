<?php

namespace App\Http\Controllers\Attendance;

use App\Http\Controllers\Controller;
use App\Models\Attendance\TeacherAttendance;
use App\Models\Teacher\TeacherCrud;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TeacherAttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // 🧠 Step 2: AJAX request handle
        if ($request->ajax()) {

            // ✅ Fetch all attendance records with relations
            $data = TeacherAttendance::with(['teacher'])
                ->latest();
            return DataTables::of($data)
                ->addIndexColumn()

                // 🧩 Teacher Name Column
                ->addColumn('teacher_name', function ($row) {
                    return $row->teacher->teacher_name ?? 'N/A';
                })

                // 🧩 Date Column
                ->editColumn('date', function ($row) {
                    return \Carbon\Carbon::parse($row->date)->format('d M Y');
                })
                // edit reason agr null hai to "-" hojaye
                ->editColumn('reason', function ($row) {
                    return $row->reason ?? '-';
                })

                // 🧩 Status Badge Column
                ->addColumn('status_badge', function ($row) {
                    $color = match ($row->status) {
                        'Present' => 'success',
                        'Absent' => 'danger',
                        'Leave' => 'warning',
                        default => 'secondary'
                    };
                    return "<span class='badge bg-$color p-2 fw-normal fs-6'>$row->status</span>";
                })

                // 🧩 Action Buttons Column
                ->addColumn('action', function ($row) {
                    return '
                        <button class="btn btn-sm btn-warning text-white viewTeacherAttendanceBtn" data-id="' . $row->teacher_id . '">
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

                // ⚙️ Allow HTML in columns
                ->rawColumns(['status_badge', 'action'])
                ->make(true);
        }
        // 🖥️ Step 3: Return the index view
        return view('school_dashboard.admin_pages.teachers.attendance.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('school_dashboard.admin_pages.teachers.attendance.create');
    }
    public function fetchTeachers(Request $request)
    {
        $teachers = TeacherCrud::all();
        return response()->json($teachers);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 🧾 Step 1: Basic validation
        $request->validate([
            'date'         => 'required|date',
            'teacher_ids'  => 'required|array',
        ]);

        // 🚫 Step 2: Check if attendance already exists
        $exists = TeacherAttendance::where('date', $request->date)
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

        // ⚠️ Step 4: Leave reason required validation
        foreach ($leave as $teacherId) {
            if (empty($reasons[$teacherId])) {
                return response()->json([
                    'success' => false,
                    'message' => "Please provide a reason for teacher ID: $teacherId (Leave)."
                ]);
            }
        }

        // 🧠 Step 5: Save attendance
        foreach ($request->teacher_ids as $teacherId) {

            // Leave > Absent > Present
            if (in_array($teacherId, $leave)) {
                $status = 'Leave';
            } elseif (in_array($teacherId, $absent)) {
                $status = 'Absent';
            } else {
                $status = 'Present';
            }

            TeacherAttendance::create([
                'teacher_id' => $teacherId,
                'date'       => $request->date,
                'status'     => $status,
                'reason'     => $reasons[$teacherId] ?? null,
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
        $teacher = \App\Models\Teacher\TeacherCrud::findOrFail($id);

        // 🗓 Select month from input or current month
        $selectedMonth = $request->get('month') ?? now()->format('Y-m');

        // Parse month + year from the input
        $date = \Carbon\Carbon::createFromFormat('Y-m', $selectedMonth);
        $month = $date->month;
        $year = $date->year;

        // 🎯 Get attendance for selected month
        $attendance = \App\Models\Attendance\TeacherAttendance::where('teacher_id', $id)
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->get(['date', 'status']);

        // 🗂️ Convert to [day => status] array
        $attendanceData = [];
        foreach ($attendance as $record) {
            $day = \Carbon\Carbon::parse($record->date)->day;
            $status = strtolower($record->status) === 'present' ? 'P' : 'A';
            $attendanceData[$day] = $status;
        }

        // 🔹 Pass data to view
        return view('school_dashboard.admin_pages.teachers.attendance.report', [
            'teacher' => $teacher,
            'attendanceData' => $attendanceData,
            'selectedMonth' => $selectedMonth,
            'month' => $month,
            'year' => $year,
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $attendance = TeacherAttendance::with('teacher')->findOrFail($id);

        return response()->json([
            'id' => $attendance->id,
            'teacher_name' => $attendance->teacher->teacher_name, // assuming relation 'teacher'
            'date' => $attendance->date,
            'status' => $attendance->status,
            'reason' => $attendance->reason,
        ]);
    }


    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Present,Absent,Leave',
            'reason' => 'required_if:status,Leave',
        ]);

        $attendance = TeacherAttendance::findOrFail($id);
        $attendance->status = $request->status;
        $attendance->reason = $request->reason;
        $attendance->save();

        return response()->json(['message' => 'Attendance updated successfully!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $attendance = TeacherAttendance::findOrFail($id);
        $attendance->delete();

        return response()->json(['success' => true, 'message' => 'Record deleted successfully.']);
    }
}
