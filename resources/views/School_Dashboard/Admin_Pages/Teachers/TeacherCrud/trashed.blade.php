@extends('school_dashboard.admin_layouts.app')

@section('content')
<div class="container mt-4">

    <!-- 🔹 Page Header -->
    <div class="card shadow-sm p-3">
        <div class="d-flex justify-content-between align-items-center">
            <h3 class="fw-bold text-primary mb-0">
                <i class="fa fa-trash"></i> Recycle Bin - Teachers
            </h3>
            <div class="action">
                <a href="{{ route('teachers.index') }}" class="btn btn-outline-info">
                    <i class="fa fa-list me-1"></i> Teachers List
                </a>
            </div>
        </div>
    </div>

    <!-- 🔹 Table & Bulk Action Buttons -->
    <div class="card shadow-sm mt-3">
        <div class="card-header bg-light d-flex justify-content-between align-items-center">
            <div>
                <button id="bulkRestore" class="btn btn-success btn-sm me-2">
                    <i class="fa fa-undo me-1"></i> Restore Selected
                </button>
                <button id="bulkDelete" class="btn btn-danger btn-sm">
                    <i class="fa fa-trash me-1"></i> Delete Selected
                </button>
            </div>
            <h5 class="text-muted mb-0">Select multiple teachers to restore or permanently delete</h5>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table id="trashedTeachers" class="table table-hover table-bordered table-striped align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th class="text-center"><input type="checkbox" id="selectAll"></th>
                            <th>ID</th>
                            <th>Teacher Name</th>
                            <th>Qualification</th>
                            <th>Subject</th>
                            <th>Deleted At</th>
                            <th class="text-center">Actions</th>
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

    // 🧩 Initialize DataTable
    let trashedTable = $('#trashedTeachers').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('teachers.trashed') }}",
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
            { data: 'teacher_name', name: 'teacher_name' },
            { data: 'qualification', name: 'qualification' },
            { data: 'mobile', name: 'mobile' },
            {
                data: 'deleted_at',
                name: 'deleted_at',
                render: function(data){
                    return data ? new Date(data).toLocaleDateString('en-US', {
                        weekday: 'short', day: '2-digit', month: 'short', year: 'numeric'
                    }) : '';
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

    // ✅ Select All checkbox
    $('#selectAll').on('click', function() {
        $('.selectRow').prop('checked', this.checked);
    });

    $(document).on('change', '.selectRow', function() {
        $('#selectAll').prop('checked', $('.selectRow:checked').length === $('.selectRow').length);
    });

    // ♻️ Single Restore
    $(document).on('click', '.restore-btn', function() {
        let id = $(this).data('id');
        $.post("{{ url('teachers/restore') }}/" + id, {_token: '{{ csrf_token() }}'}, function(res) {
            toastr.success(res.message);
            trashedTable.ajax.reload();
        });
    });

    // ❌ Single Permanent Delete
    $(document).on('click', '.force-del-btn', function() {
        let id = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?',
            text: "This will permanently delete the teacher record!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Yes, Delete!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ url('teachers/force-delete') }}/" + id,
                    type: 'DELETE',
                    data: {_token: '{{ csrf_token() }}'},
                    success: function(res) {
                        toastr.success(res.message);
                        trashedTable.ajax.reload();
                    }
                });
            }
        });
    });

    // ♻️ Bulk Restore
    $('#bulkRestore').on('click', function() {
        let ids = $('.selectRow:checked').map(function(){ return $(this).val(); }).get();
        if(ids.length === 0) {
            toastr.warning('Please select at least one teacher');
            return;
        }
        $.post("{{ route('teachers.restoreAll') }}", {_token: '{{ csrf_token() }}', ids: ids}, function(res){
            toastr.success(res.message);
            trashedTable.ajax.reload();
        });
    });

    // ☠️ Bulk Permanent Delete
    $('#bulkDelete').on('click', function() {
        let ids = $('.selectRow:checked').map(function(){ return $(this).val(); }).get();
        if(ids.length === 0) {
            toastr.warning('Please select at least one teacher');
            return;
        }

        Swal.fire({
            title: 'Are you sure?',
            text: "Selected teachers will be permanently deleted!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Yes, Delete All!'
        }).then((result) => {
            if(result.isConfirmed){
                $.ajax({
                    url: "{{ route('teachers.forceDeleteAll') }}",
                    type: 'DELETE',
                    data: {_token: '{{ csrf_token() }}', ids: ids},
                    success: function(res) {
                        toastr.success(res.message);
                        trashedTable.ajax.reload();
                    }
                });
            }
        });
    });

});
</script>
@endpush
