<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Students\Crud;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class StudentApprovalController extends Controller
{
      public function pendingStudent(Request $request)
    {
         if ($request->ajax()) {
            $data = Crud::where('status', 'pending')->latest();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                    return '<span class="badge bg-warning text-dark">'.$row->status.'</span>';
                })
                ->addColumn('action', function ($row) {
    $approveBtn = '<form action="'.route('admin.students.approve', $row->id).'" method="POST" class="actionForm d-inline-block">
                        '.csrf_field().'
                        <button type="submit" class="btn btn-success btn-sm action-btn">
                            <i class="fa fa-check me-1"></i> Approve
                        </button>
                    </form>';

    $rejectBtn = '<form action="'.route('admin.students.reject', $row->id).'" method="POST" class="actionForm d-inline-block">
                        '.csrf_field().'
                        <button type="submit" class="btn btn-danger btn-sm action-btn">
                            <i class="fa fa-times me-1"></i> Reject
                        </button>
                    </form>';

    return $approveBtn . ' ' . $rejectBtn;
})

                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        return view('school_dashboard.admin_pages.students.Student_Requests.pendingstudent');
        
        // $pendingStudents = Crud::where('role', 'student')->where('status', 'pending')->get();
        // return view('school_dashboard.admin_pages.students.Student_Requests.pendingstudent', compact('pendingStudents'));
    }
    public function approveStudent(Request $request)
    {
        // $approvedStudents = Crud::where('role', 'student')->where('status', 'approved')->get();
        // return view('school_dashboard.admin_pages.students.Student_Requests.approvedstudent', compact('approvedStudents'));
        if ($request->ajax()) {
            $data = Crud::where('status', 'approved')->latest();
            
        return \Yajra\DataTables\Facades\DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('status', function ($row) {
                return '<span class="badge bg-success">'.$row->status.'</span>';
            })
           ->addColumn('action', function ($row) {
    return '<form action="'.route('admin.students.reject', $row->id).'" method="POST" class="rejectForm" style="display:inline-block">'
        .csrf_field().
        '<button type="submit" class="btn btn-danger btn-sm rejectBtn">
            <i class="fa fa-times me-1"></i> Reject
        </button>
    </form>';
})

            ->rawColumns(['status', 'action'])
            ->make(true);
        }
        return view('school_dashboard.admin_pages.students.Student_Requests.approvedstudent');
    }
     public function rejectStudent(Request $request)
    {
        // $rejectedStudents = Crud::where('role', 'student')->where('status', 'rejected')->get();
        // return view('school_dashboard.admin_pages.students.Student_Requests.rejectedstudent', compact('rejectedStudents'));
          if ($request->ajax()) {
        $data = Crud::where('status', 'rejected')->latest();

        return \Yajra\DataTables\Facades\DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('status', function ($row) {
                return '<span class="badge bg-danger">'.$row->status.'</span>';
            })
           ->addColumn('action', function ($row) {
    $approveBtn = '<form action="'.route('admin.students.approve', $row->id).'" method="POST" class="approveForm" style="display:inline-block">'
                    .csrf_field().
                    '<button type="submit" class="btn btn-success btn-sm approveBtn">
                        <i class="fa fa-check me-1"></i> Approve
                    </button>
                  </form>';

    // $deleteBtn = '<form action="'.route('admin.students.destroy', $row->id).'" method="POST" class="deleteForm" style="display:inline-block">'
    //                 .csrf_field().method_field('DELETE').
    //                 '<button type="submit" class="btn btn-danger btn-sm deleteBtn">
    //                     <i class="fa fa-trash"></i>
    //                 </button>
    //               </form>';

    return $approveBtn;
})

            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    return view('school_dashboard.admin_pages.students.Student_Requests.rejectedstudent');
    }

    public function approve($id)
{
    $student = Crud::findOrFail($id);
    $student->status = 'approved';
    $student->save();

    return response()->json(['message' => 'Student approved successfully!']);
}

public function reject($id)
{
    $student = Crud::findOrFail($id);
    $student->status = 'rejected';
    $student->save();

    return response()->json(['message' => 'Student rejected successfully!']);
}

    public function destroy($id)
    {
        $student = Crud::findOrFail($id);
        $student->delete();
            return response()->json(['message' => 'Student Deleted!!']);
    }
}
