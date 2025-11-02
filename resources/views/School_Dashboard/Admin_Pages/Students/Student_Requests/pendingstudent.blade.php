@extends('school_dashboard.admin_layouts.app')

@section('content')
  <div class="container">
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
 

  </div>
@endsection
@push('scripts')
    <script>
        $(function() {
            $('#studentsTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.student.pending.list') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'student_uid',
                        name: 'student_uid'
                    },
                    {
                        data: 'student_name',
                        name: 'student_name'
                    },
                    {
                        data: 'email_id',
                        name: 'email_id'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
                // language: {
                //     search: "🔍 Search:",
                //     lengthMenu: "Show _MENU_ entries",
                //     info: "Showing _START_ to _END_ of _TOTAL_ students",
                //     paginate: { previous: "⬅️", next: "➡️" }
                // }
            });
        });
        $(document).on('submit', '.actionForm', function(e) {
    e.preventDefault();

    let form = $(this);
    let btn = form.find('.action-btn');
    let originalHTML = btn.html();

    // Disable button + show spinner
    btn.prop('disabled', true)
       .html('<i class="fa fa-spinner fa-spin me-1"></i> Processing...');

    // AJAX form submit
    $.ajax({
        url: form.attr('action'),
        method: form.attr('method'),
        data: form.serialize(),
        success: function(res) {
            $('#studentsTable').DataTable().ajax.reload(); // reload table
            toastr.success(res.message || 'Action completed successfully!');
        },
        error: function(xhr) {
            toastr.error('Something went wrong!');
        },
        complete: function() {
            // Re-enable button
            btn.prop('disabled', false).html(originalHTML);
        }
    });
});
    </script>
    
@endpush
