@extends('school_dashboard.admin_layouts.app')

@section('content')
  <div class="row">
            <div class="col-12">
                <div class="card shadow-sm border-1">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="mb-0 fw-bold text-warning">
                            <i class="fa-solid fa-clock me-1"></i>Pending Students List
                        </h3>
                       <div class="action-btn">
            <a href="{{ route('admin.student.reject.list') }}" class="btn btn-primary">
                <i class="fa fa-eye me-1"></i> Show Rejected List
            </a>
            <a href="{{ route('admin.student.approve.list') }}" class="btn btn-success">
                <i class="fa fa-eye me-1"></i> Show Approved List
            </a>
        </div>
                    </div>
                </div>
            </div>
        </div>
        
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <table id="studentsTable" class="table table-bordered table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Student ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

<!-- ✅ Scripts -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
$(function () {
    $('#studentsTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.student.pending.list') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'student_uid', name: 'student_uid' },
            { data: 'student_name', name: 'student_name' },
            { data: 'email_id', name: 'email_id' },
            { data: 'status', name: 'status', orderable: false, searchable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ],
        // language: {
        //     search: "🔍 Search:",
        //     lengthMenu: "Show _MENU_ entries",
        //     info: "Showing _START_ to _END_ of _TOTAL_ students",
        //     paginate: { previous: "⬅️", next: "➡️" }
        // }
    });
});
</script>
@endsection
