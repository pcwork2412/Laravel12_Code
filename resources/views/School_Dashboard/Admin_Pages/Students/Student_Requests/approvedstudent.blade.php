@extends('school_dashboard.admin_layouts.app')

@section('content')
<div class="row">
            <div class="col-12">
                <div class="card shadow-sm border-1">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="mb-0 fw-bold text-success">
                            <i class="fa-solid fa-check-circle me-1 "></i>Approved Students List
                        </h3>
                <div class="action-btn">
            <a href="{{ route('admin.student.pending.list') }}" class="btn btn-warning">
                <i class="fa fa-eye me-1"></i> Show Pending List
            </a>
            <a href="{{ route('admin.student.reject.list') }}" class="btn btn-danger">
                <i class="fa fa-eye me-1"></i> Show Rejected List
            </a>
        </div>

                    </div>
                </div>
            </div>
        </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <table id="approvedTable" class="table table-bordered table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Student Name</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>


<!-- ✅ Include DataTable dependencies -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
$(function () {
    $('#approvedTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.student.approve.list') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'student_name', name: 'student_name' },
            { data: 'email_id', name: 'email_id' },
            { data: 'status', name: 'status', orderable: false, searchable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ],
        // language: {
        //     search: "🔍 खोजें:",
        //     lengthMenu: "प्रति पृष्ठ _MENU_ रिकॉर्ड दिखाएँ",
        //     info: "कुल _TOTAL_ में से _START_ से _END_ तक दिखा रहा है",
        //     paginate: { previous: "⬅️", next: "➡️" }
        // }
    });
});
</script>
@endsection
