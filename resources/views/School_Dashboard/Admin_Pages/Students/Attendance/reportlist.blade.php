@extends('school_dashboard.admin_layouts.app')
@section('content')
    <div class="container mt-4">
        {{-- Attendance Table --}}
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-header d-flex justify-content-between bg-primary text-white">
                <h3 class="mb-0"><i class="fas fa-eye me-2"></i> View Student Attendance Report</h3>
                {{-- <div class="card-tools">
                    <a href="{{ route('student_attendance.create') }}" class="btn btn-light">
                        <i class="fa fa-plus me-1"></i> Add Attendance
                    </a>
                </div> --}}
            </div>
            <div class="card-body">
                <div class="row d-flex justify-content-start align-items-center mb-3">
                    <div class="col-md-3 mb-2">
                        <label class="form-label fw-semibold">Select Date</label>
                        <input type="date" name="attendance_date" id="attendanceDate" class="form-control" max="{{ date('Y-m-d') }}"
                            value="{{ request('attendance_date', now()->format('Y-m-d')) }}">
                    </div>

                    <div class="col-md-3 mb-2">
                        <label for="class_id" class="form-label me-2 fw-semibold">Select Class Name</label>
                        <select id="classFilter" name="class_id" class="globalClassSelect form-select ">
                            <option value="All">All</option>
                            @foreach ($classes as $class)
                                <option value="{{ $class->id }}">{{ $class->class_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 mb-2">
                        <label class="form-label fw-semibold">Select Section</label>
                        <select id="sectionFilter" name="section_id" class="globalSectionSelect form-select">
                            <option value=""> Select Section </option>
                        </select>
                    </div>
                </div>
                <!-- Table -->
                <div class="table-responsive">
                    <table id="attendanceTable" class="table table-bordered table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Student Name</th>
                                <th>Class</th>
                                <th>Section</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Reason</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        {{-- End Card --}}
        <!-- Edit Attendance Modal -->
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form id="editAttendanceForm">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="editAttendanceId" name="id">

                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel">Edit Attendance</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="editStudentName" class="form-label">Student Name</label>
                                <input type="text" class="form-control" id="editStudentName" name="student_name"
                                    readonly>
                            </div>

                            <div class="mb-3">
                                <label for="editDate" class="form-label">Date</label>
                                <input type="date" class="form-control" id="editDate" name="date" readonly>
                            </div>

                            <div class="mb-3">
                                <label for="editStatus" class="form-label">Status</label>
                                <select class="form-select" id="editStatus" name="status">
                                    <option value="Present">Present</option>
                                    <option value="Absent">Absent</option>
                                    <option value="Leave">Leave</option>
                                </select>
                            </div>
                            <div class="mb-3" id="reasonBox" style="display: none;">
                                <label for="editReason" class="form-label">Reason (if Absent or Leave)</label>
                                <textarea class="form-control" id="editReason" name="reason" rows="3"></textarea>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" id="updateAttendanceBtn" class="btn btn-primary">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- End Edit Attendance Modal -->
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('pos/assets/js/CustomJS/Global/global.js') }}"></script>

    <script>
        $(document).ready(function() {

            // 🧾 Initialize Yajra DataTable
            if ($.fn.DataTable.isDataTable('#attendanceTable')) {
                $('#attendanceTable').DataTable().destroy();
            }

            let table = $('#attendanceTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('student_attendance.report') }}",
                    data: function(d) {
                        d.class_id = $('#classFilter').val();
                        d.section_id = $('#sectionFilter').val();
                        d.attendance_date = $('#attendanceDate').val(); // ✅ Added

                    }
                },
                responsive: true,
                // 🧩 Buttons config
            //     dom: `
            //  <"d-flex justify-content-between align-items-center "
            //     <"col-auto"l>
            //     <"col text-center"B>
            //     <"col-auto"f>
            //   >
            //   t
            //   t<'d-flex justify-content-between mt-2'<'col'i><'col-auto'p>>
                        
            //  `,

                // buttons: [{
                //         extend: 'copy',
                //         text: '<i class="fas fa-copy"></i> Copy',
                //         className: 'btn btn-sm btn-outline-primary',
                //         init: function(api, node, config) {
                //             $(node).removeClass('dt-button');
                //         },
                //         exportOptions: {
                //             columns: ':visible:not(:last-child)' // 👈 last column (action) exclude
                //         }
                //     },
                //     {
                //         extend: 'csv',
                //         text: '<i class="fas fa-file-csv"></i> CSV',
                //         className: 'btn btn-sm btn-outline-success',
                //         init: function(api, node, config) {
                //             $(node).removeClass('dt-button');
                //         },
                //         exportOptions: {
                //             columns: [0, 1, 2, 3, 4, 5] // 👈 sirf ye columns export honge
                //         }
                //     },
                //     {
                //         extend: 'excelHtml5',
                //         text: '<i class="fas fa-file-excel"></i> Excel',
                //         className: 'btn btn-sm btn-outline-success',
                //         title: 'Student Attendance Report',
                //         filename: 'attendance_report_' + new Date().toISOString().slice(0, 10),
                //         init: function(api, node, config) {
                //             $(node).removeClass('dt-button');
                //         },
                //         exportOptions: {
                //             columns: ':not(:last-child)' // 👈 last column (action) ko skip karega
                //         }
                //     },
                //     {
                //         extend: 'pdfHtml5',
                //         text: '<i class="fas fa-file-pdf"></i> PDF',
                //         className: 'btn btn-sm btn-outline-danger',
                //         init: function(api, node, config) {
                //             $(node).removeClass('dt-button');
                //         },
                //         exportOptions: {
                //             columns: [0, 1, 2, 3, 4, 5] // 👈 sirf ye columns export honge
                //         }
                //     },
                //     {
                //         extend: 'print',
                //         text: '<i class="fas fa-print"></i> Print',
                //         className: 'btn btn-sm btn-outline-primary',
                //         init: function(api, node, config) {
                //             $(node).removeClass('dt-button');
                //         },
                //         exportOptions: {
                //             columns: ':visible:not(:last-child)' // 👈 last column (action) exclude
                //         }
                //     }
                // ],
                order: [
                    [0, 'desc']
                ],
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'student_name',
                        name: 'student.student_name'
                    },
                    {
                        data: 'class',
                        name: 'class'
                    },
                    {
                        data: 'section',
                        name: 'section'
                    },
                    {
                        data: 'date',
                        name: 'date'
                    },
                    {
                        data: 'status_badge',
                        name: 'status',
                    },
                    {
                        data: 'reason',
                        name: 'reason'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            // 👇 Agar 'All' select hua, to section reset kar do
            $('#classFilter').on('change', function() {
                let classId = $(this).val();
                if (classId !== 'All') {
                    $('#sectionFilter').html('<option value="">-- Select Section --</option>').prop(
                        'disabled', false);
                    // 🎯 Jab section select ho → Table reload karo
                    $('#sectionFilter').on('change', function() {
                        table.ajax.reload();
                    });

                } else {
                    $('#sectionFilter').html('<option value="">-- Select Section --</option>').prop(
                        'disabled', true);
                    table.ajax.reload();
                }
            });
            $('#attendanceDate').on('change', function() {
                $('#attendanceTable').DataTable().ajax.reload(); // ✅ Table reload when date changes
            });

            // if (classId === 'All') {
            //     $('#sectionFilter').html('<option value="">-- Select Section --</option>').prop('disabled', true);
            //     table.ajax.reload();
            // }

            // Edit Button Click
            $(document).on('click', '.editBtn', function() {
                let id = $(this).data('id');

                $.ajax({
                    url: `/student_attendance/${id}/edit`,
                    type: 'GET',
                    success: function(data) {
                        $('#editAttendanceId').val(data.id);
                        $('#editStudentName').val(data.student_name);
                        $('#editDate').val(data.date);
                        $('#editStatus').val(data.status);
                        $('#editReason').val(data.reason);

                        $('#editModal').modal('show');
                    }
                });
            });

            function toggleReasonBox() {
                let status = $('#editStatus').val();
                if (status === 'Leave') {
                    $('#reasonBox').show();
                } else {
                    $('#reasonBox').hide();
                    $('#editReason').val('');
                }
            }
            // On modal show, set reason box visibility
            $('#editModal').on('show.bs.modal', function() {
                toggleReasonBox();
            });
            // On status change
            $('#editStatus').on('change', function() {
                toggleReasonBox();
            });

            // Update Form Submit
            $('#editAttendanceForm').submit(function(e) {
                e.preventDefault();

                let id = $('#editAttendanceId').val();
                let formData = $(this).serialize();

                $("#updateAttendanceBtn").prop("disabled", true).text("Updating...");

                $.ajax({
                    url: `/student_attendance/${id}`,
                    type: 'PUT',
                    data: formData,
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Update Successful',
                            text: response.message
                        });
                        $('#editModal').modal('hide');
                        table.ajax.reload();
                        $("#updateAttendanceBtn").prop("disabled", false).text("Update");
                    },
                    error: function(err) {
                        console.log(err);
                        Swal.fire({
                            icon: 'error',
                            title: 'Update Failed',
                            text: 'Error updating record!'
                        });
                        $("#updateAttendanceBtn").prop("disabled", false).text("Update");
                    }
                });
            });


            // ❌ Delete Record
            $(document).on('click', '.deleteBtn', function() {
                let id = $(this).data('id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'This record will be permanently deleted.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, Delete it!'
                }).then(result => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/student_attendance/${id}`,
                            type: 'DELETE',
                            data: {
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(res) {
                                Swal.fire('Deleted!', res.message, 'success');
                                table.ajax.reload();
                            }
                        });
                    }
                });
            });

            $(document).on('click', '.viewBtn', function() {
                let id = $(this).data('id');

                // redirect to show page
                window.location.href = "/student_attendance/" + id;
            });

        });
    </script>
@endpush
