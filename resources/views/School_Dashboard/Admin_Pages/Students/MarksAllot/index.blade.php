@extends('School_Dashboard.Admin_Layouts.app')

@section('content')
    {{-- @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif --}}
   <div class="container">
     <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-1">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="mb-0 fw-bold text-primary">
                        <i class="fa-solid fa-users me-2"></i>Student List (Alloted / Not Alloted)
                    </h3>
                    <a href="{{ route('marks.create') }}" class="btn btn-primary">
                        <i class="fas fa-circle-plus"></i> Allot Marks
                    </a>

                </div>
            </div>
        </div>

    </div>

    <div class="card shadow-sm">
        <div class="card-body p-3">
            <div class="table-responsive">
                <table class="table table-bordered table-hover mb-0" id="marksTable">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Student UID</th>
                            <th>Student Name</th>
                            <th>Class</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

   </div>
    {{-- Marks All Subject View Modal --}}
    <div class="modal fade" id="viewMarksModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
        aria-labelledby="studentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content shadow">
                <div class="modal-header bg-primary text-white">
                    <h3 class="modal-title" id="studentModalLabel">Student Marks Details</h3>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Student Info -->
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-body d-flex align-items-center">
                            <!-- Avatar Circle -->
                            <div class="me-3">
                                <div id="studentAvatar"
                                    class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center"
                                    style="width:60px; height:60px; font-size:20px; font-weight:bold;">
                                    {{-- <i class="fas fa-user"></i> --}}
                                </div>
                            </div>


                            <!-- Info -->
                            <div>
                                <h3 id="studentName" class="mb-1 fw-bold text-dark"></h3>
                                <div class="d-flex flex-wrap small text-muted">
                                    <div class="me-3 mt-2 mb-1 fs-6">
                                        <i class="fas fa-id-card me-2 fa-1x text-primary"></i>
                                        <span id="studentUid" class=""></span>
                                    </div>
                                    <div class="me-3 mt-2 mb-1 fs-6">
                                        <i class="fas fa-chalkboard fa-1x me-1 text-success"></i>
                                        Class: <span id="studentClass" class=""></span>
                                    </div>
                                    <div class="mb-1 mt-2 fs-6">
                                        <i class="fas fa-users me-1 fa-1x text-info"></i>
                                        Section: <span id="studentSection" class=""></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Marks Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Subject</th>
                                    <th>Max Marks</th>
                                    <th>Obtained Marks</th>
                                    <th>Exam Type</th>
                                    <th>Year</th>
                                </tr>
                            </thead>
                            <tbody id="marksTableBody">
                                <!-- JS से data fill होगा -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            let table = $('#marksTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('marks.index') }}",
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
                        data: 'class',
                        name: 'class',

                    },
                    {
                        data: 'status',
                        name: 'status',

                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

            // $(document).on('click', '.editMarksBtn', function() {
            //     let studentId = $(this).data('id');

            //     $.ajax({
            //         url: '/marks/' + studentId + '/edit',
            //         success: function(response) {
            //             window.location.href = '/marks/' + studentId + '/edit';
            //         },
            //         error: function() {
            //             alert("Error while Editing!");
            //         }
            //     });
            // });
            $(document).on('click', '.allotNowBtn', function() {
                let studentId = $(this).data('id');

                $.ajax({
                    url: '/marks/' + studentId + '/allot',
                    success: function(response) {
                        window.location.href = '/marks/' + studentId + '/allot';
                    },
                    error: function() {
                        alert("Error while Allocation!");
                    }
                });
            });

            // Action button example events
            $(document).on("click", ".viewMarksBtn", function() {
                let studentId = $(this).data("id");

                $.ajax({
                    url: "/marks/" + studentId, // resource route => marks.show
                    type: "GET",
                    dataType: "json",
                    success: function(res) {
                        if (res.status) {
                            let s = res.student;

                            // ✅ Student info fill
                            $("#studentName").text(s.student_name);
                            $("#studentUid").text(s.student_uid);
                            $("#studentClass").text(s.promoted_class_name);
                            $("#studentSection").text(s.section);

                            // ✅ Avatar Image
                            if (res.image) {
                                $("#studentAvatar").html(
                                    `<img src="${res.image}" alt="Avatar" class="rounded-circle" style="width:60px;height:60px;object-fit:contain; background-color:white;">`
                                );
                            } else {
                                // fallback if no image
                                $("#studentAvatar").html(
                                    `<i class="fas fa-user" style="font-size:24px;"></i>`
                                );
                            }

                            // ✅ Marks table fill
                            let rows = "";
                            if (s.marks.length > 0) {
                                $.each(s.marks, function(i, m) {
                                    rows += `
                            <tr>
                                <td>${i + 1}</td>
                                <td>${m.subject_name}</td>
                                <td>${m.max_marks}</td>
                                <td>${m.obtained_marks}</td>
                                <td>${m.exam_type}</td>
                                <td>${m.year}</td>
                            </tr>
                        `;
                                });
                            } else {
                                rows =
                                    `<tr><td colspan="6" class="text-center text-muted">No Marks Found</td></tr>`;
                            }

                            $("#marksTableBody").html(rows);

                            // ✅ Modal show
                            $("#viewMarksModal").modal("show");
                        }
                    },
                    error: function(xhr) {
                        Swal.fire("Error", "Could not fetch marks!", "error");
                    }
                });
            });


            $(document).on('click', '.deleteMarksBtn', function() {
                let id = $(this).data('id');
                Swal.fire({
                    title: "Are you sure?",
                    text: "Do you really want to delete the student Marks Data.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes, delete",
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/marks/${id}`,
                            type: "DELETE",
                            data: {
                                _token: $('meta[name="csrf-token"]').attr(
                                    "content") // ✅ Important
                            },
                            success: function(res) {
                                table.ajax.reload(null, false);
                                Swal.fire("Deleted", res.message, "success");
                            },
                            error: function(xhr) {
                                Swal.fire("Error", xhr.responseJSON?.message ||
                                    "Delete failed", "error");
                            },
                        });
                    }
                });
            });

        });
    </script>
@endpush
