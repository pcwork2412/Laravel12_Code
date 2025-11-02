@extends('school_dashboard.admin_layouts.app')

@section('content')
<div class="container mt-4">

    <!-- Page Header -->
    <div class="card  shadow-sm p-3">
        <div class="d-flex justify-content-between align-items-center ">
            <h3 class="fw-bold text-primary mb-0"><i class="fa fa-trash"></i> Recyle Bin Students Data</h4>
                <div class="action">
                    <a href="{{ route('students.index') }}" class="btn btn-outline-info ">
                        <i class="fa fa-list me-1"></i> Student List
                    </a>
                </div>
            </div>
        </div>

    <!-- Card for table + actions -->
    <div class="card shadow-sm">
        <div class="card-header bg-light d-flex justify-content-between align-items-center">
            <div>
                <button id="bulkRestore" class="btn btn-success btn-sm me-2">
                    <i class="fa fa-undo me-1"></i> Restore Selected
                </button>
                <button id="bulkDelete" class="btn btn-danger btn-sm">
                    <i class="fa fa-trash me-1"></i> Delete Selected
                </button>
            </div>
            <h5 class="text-muted">Select multiple students to restore or permanently delete</h5>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table id="trashedTable" class="table table-hover table-bordered table-striped align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th class="text-center"><input type="checkbox" id="selectAll"></th>
                            <th>ID</th>
                            <th>Student ID</th>
                            <th>Student Name</th>
                            <th>Class</th>
                            <th>Section</th>
                            <th>Deleted At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {

    // Initialize DataTable
    let trashedTable = $('#trashedTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('students.trashed') }}",
        responsive: true,
        order: [[1, 'desc']],
        columns: [
            {
                data: 'id',
                name: 'checkbox',
                orderable: false,
                searchable: false,
                className: 'text-center',
                render: function(data) {
                    return `<input type="checkbox" class="selectRow" value="${data}">`;
                }
            },
            { data: 'id', name: 'id' },
            { data: 'student_uid', name: 'student_uid' },
            { data: 'student_name', name: 'student_name' },
            { data: 'promoted_class_name', name: 'promoted_class_name' },
            { data: 'section', name: 'section' },
            {
                data: 'deleted_at',
                name: 'deleted_at',
                render: function(data){
                    return data ? new Date(data).toLocaleDateString('en-US', { weekday: 'short', day: '2-digit', month: 'short', year: 'numeric' }) : '';
                }
            },
            {
                data: 'actions',
                name: 'actions',
                orderable: false,
                searchable: false,
                className: 'text-center'
            }
        ]
    });

    // Checkbox select all
    $('#selectAll').on('click', function() {
        $('.selectRow').prop('checked', this.checked);
    });

    $(document).on('change', '.selectRow', function() {
        $('#selectAll').prop('checked', $('.selectRow:checked').length === $('.selectRow').length);
    });

    // Spinner Helper Function
    function showSpinner(btn, text = 'Processing...') {
        btn.prop('disabled', true);
        btn.data('original', btn.html());
        btn.html(`<span class="spinner-border spinner-border-sm me-2"></span>${text}`);
    }

    function resetSpinner(btn) {
        btn.prop('disabled', false);
        if (btn.data('original')) btn.html(btn.data('original'));
    }

    // 🔹 Single Restore
    $(document).on('click', '.restore-btn', function() {
        let btn = $(this);
        let id = btn.data('id');

        showSpinner(btn, 'Restoring...');
        $.post("{{ url('students/restore') }}/" + id, {_token: '{{ csrf_token() }}'}, function(res) {
            toastr.success(res.message);
            trashedTable.ajax.reload();
        }).always(() => resetSpinner(btn));
    });

    // 🔹 Single Permanent Delete
    $(document).on('click', '.force-del-btn', function() {
        let btn = $(this);
        let id = btn.data('id');

        Swal.fire({
            title: 'Are you sure?',
            text: "This will permanently delete the student!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Yes, Delete!'
        }).then((result) => {
            if (result.isConfirmed) {
                showSpinner(btn, 'Deleting...');
                $.ajax({
                    url: "{{ url('students/forcedelete') }}/" + id,
                    type: 'DELETE',
                    data: {_token: '{{ csrf_token() }}'},
                    success: function(res) {
                        toastr.success(res.message);
                        trashedTable.ajax.reload();
                    },
                    complete: () => resetSpinner(btn)
                });
            }
        });
    });

    // 🔹 Bulk Restore
    $('#bulkRestore').on('click', function() {
        let btn = $(this);
        let ids = $('.selectRow:checked').map(function(){ return $(this).val(); }).get();

        if(ids.length === 0) { toastr.warning('Please select at least one student'); return; }

        showSpinner(btn, 'Restoring...');
        $.post("{{ url('students/bulk-restore') }}", {_token: '{{ csrf_token() }}', ids: ids}, function(res){
            toastr.success(res.message);
            trashedTable.ajax.reload();
        }).always(() => resetSpinner(btn));
    });

    // 🔹 Bulk Permanent Delete
    $('#bulkDelete').on('click', function() {
        let btn = $(this);
        let ids = $('.selectRow:checked').map(function(){ return $(this).val(); }).get();

        if(ids.length === 0) { toastr.warning('Please select at least one student'); return; }

        Swal.fire({
            title: 'Are you sure?',
            text: "This will permanently delete selected students!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Yes, Delete All!'
        }).then((result) => {
            if(result.isConfirmed){
                showSpinner(btn, 'Deleting...');
                $.ajax({
                    url: "{{ url('students/bulk-delete') }}",
                    type: 'DELETE',
                    data: {_token: '{{ csrf_token() }}', ids: ids},
                    success: function(res) {
                        toastr.success(res.message);
                        trashedTable.ajax.reload();
                    },
                    complete: () => resetSpinner(btn)
                });
            }
        });
    });

});
</script>

@endpush
