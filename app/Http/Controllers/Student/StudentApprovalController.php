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
            $data = Crud::where('status', 'pending')->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                    return '<span class="badge bg-warning text-dark">'.$row->status.'</span>';
                })
                ->addColumn('action', function ($row) {
                    $approveBtn = '<form action="'.route('admin.students.approve', $row->id).'" method="POST" style="display:inline-block">
                                    '.csrf_field().'
                                    <button type="submit" class="btn btn-success btn-sm">
                                        <i class="fa fa-check"></i> Approve
                                    </button>
                                </form>';

                    $rejectBtn = '<form action="'.route('admin.students.reject', $row->id).'" method="POST" style="display:inline-block">
                                    '.csrf_field().'
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fa fa-times"></i> Reject
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
            $data = Crud::where('status', 'approved')->get();
            
        return \Yajra\DataTables\Facades\DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('status', function ($row) {
                return '<span class="badge bg-success">'.$row->status.'</span>';
            })
            ->addColumn('action', function ($row) {
                $rejectBtn = '<form action="'.route('admin.students.reject', $row->id).'" method="POST" style="display:inline-block">
                                '.csrf_field().'
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fa fa-times"></i> Reject
                                </button>
                              </form>';
                return $rejectBtn;
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
        $data = Crud::where('status', 'rejected')->get();

        return \Yajra\DataTables\Facades\DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('status', function ($row) {
                return '<span class="badge bg-danger">'.$row->status.'</span>';
            })
            ->addColumn('action', function ($row) {
                $approveBtn = '<form action="'.route('admin.students.approve', $row->id).'" method="POST" style="display:inline-block">
                                '.csrf_field().'
                                <button type="submit" class="btn btn-success btn-sm">
                                    <i class="fa fa-check"></i> Approve
                                </button>
                              </form>';

                $deleteBtn = '<form action="'.route('admin.students.destroy', $row->id).'" method="POST" style="display:inline-block" onsubmit="return confirm(\'Are you sure you want to delete this student?\')">
                                '.csrf_field().method_field('DELETE').'
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fa fa-trash"></i>
                                </button>
                              </form>';

                return $approveBtn . ' ' . $deleteBtn;
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

        return back()->with('success', 'Student approved successfully!');
    }

    public function reject($id)
    {
        $student = Crud::findOrFail($id);
        $student->status = 'rejected';
        $student->save();

        return back()->with('error', 'Student rejected!');
    }
    public function destroy($id)
    {
        $student = Crud::findOrFail($id);
        $student->delete();

        return back()->with('success', 'Student Deleted!');
    }
}
