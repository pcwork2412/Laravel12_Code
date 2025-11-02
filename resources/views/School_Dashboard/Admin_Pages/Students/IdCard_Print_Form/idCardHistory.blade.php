@extends('School_Dashboard.Admin_Layouts.app')

@section('title', 'ID Card Generation History')

@section('content')
    <div class="container-fluid my-4">
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-header bg-danger">
                <h3 class="card-title mb-0 text-white fw-bold">
                    <i class="fa-solid fa-id-card"></i> ID Card Generation History
                </h3>
            </div>

            <div class="card-body">
                <!-- ✅ Filter Section -->
                <div class="row g-3 mb-4">
                    <div class="col-md-4 col-sm-6">
                        <label class="fw-bold mb-1">Filter by Class:</label>
                        <select id="filterClass" class="form-select">
                            <option value="All">All Classes</option>
                            @foreach ($classes as $class)
                                <option value="{{ $class->class_name }}">{{ $class->class_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <label class="fw-bold mb-1">Filter by Section:</label>
                        <select id="filterSection" class="form-select">
                            <option value="All">All Sections</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                        </select>
                    </div>
                    <div class="col-md-4 col-sm-12 d-flex align-items-end">
                        <button id="resetFilter" class="btn btn-secondary w-100">
                            <i class="fa fa-refresh"></i> Reset Filters
                        </button>
                    </div>
                </div>

                <!-- ✅ DataTable -->
                <div class="table-responsive">
                    <table id="historyTable" class="table table-bordered table-striped table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th width="5%">#</th>
                                <th width="22%">Student Info</th>
                                <th width="15%">Class & Section</th>
                                <th width="12%">Generation Type</th>
                                <th width="15%">Action Type</th>
                                <th width="8%">Total</th>
                                <th width="15%">Last Generated</th>
                                <th width="8%">Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- ✅ Modal: View All Students List -->
    <div class="modal fade" id="allStudentsModal" tabindex="-1" data-bs-keyboard="false" data-bs-backdrop="static" aria-labelledby="scrollableModalLabel" >
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h3 class="modal-title">
                        <i class="fa fa-users"></i> All Students in This Generation
                    </h3>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="fa fa-info-circle"></i> Total Students: <strong id="totalStudentsCount">0</strong>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle ">
                            <thead class="table-dark">
                                <tr>
                                    <th width="10%">#</th>
                                    <th width="40%">Student UID</th>
                                    <th width="50%">Student Name</th>
                                </tr>
                            </thead>
                            <tbody id="allStudentsTableBody"></tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- ✅ Modal: Student Complete History -->
    <div class="modal fade" id="studentHistoryModal" tabindex="-1" data-bs-keyboard="false" data-bs-backdrop="static" aria-labelledby="scrollableModalLabel" >
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h3 class="modal-title">
                        <i class="fa fa-history"></i> Complete Generation History
                    </h3>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <!-- Student Info Card -->
                    <div id="studentInfo" class="mb-4"></div>

                    <!-- Summary Stats -->
                    <div class="row mt-4 mb-4">
                        <div class="col-md-4">
                            <div class="card bg-light border">
                                <div class="card-body text-center">
                                    <h6 class="text-muted fs-6 fw-bold">Total Preview Count</h6>
                                    <h3 id="previewCount" class="text-primary fw-bold">0</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-light border">
                                <div class="card-body text-center">
                                    <h6 class="text-muted fs-6 fw-bold">Total Generate Count</h6>
                                    <h3 id="generateCount" class="text-success fw-bold">0</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-light border">
                                <div class="card-body text-center">
                                    <h6 class="text-muted fs-6 fw-bold">Total Count</h6>
                                    <h3 id="totalCount" class="text-warning fw-bold">0</h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- History Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="25%">Date & Time</th>
                                    <th width="20%">Generation Type</th>
                                    <th width="20%">Action Type</th>
                                    <th width="30%">Generated By</th>
                                </tr>
                            </thead>
                            <tbody id="historyDetailsBody"></tbody>
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
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // ✅ DataTable Initialization
            var table = $('#historyTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('students.idCardHistoryData') }}",
                    type: 'GET',
                    data: function(d) {
                        d.class_name = $('#filterClass').val();
                        d.section_name = $('#filterSection').val();
                    },
                    error: function(xhr) {
                        alert('Error loading data: ' + xhr.status);
                    }
                },
                columns: [
                    { data: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'student_info' },
                    { data: 'class_section' },
                    { data: 'generation_type' },
                    { data: 'action_type' },
                    { data: 'total_count', orderable: false },
                    { data: 'last_generated' },
                    { data: 'actions', orderable: false, searchable: false }
                ],
                language: {
                    processing: '<i class="fa fa-spinner fa-spin fa-3x text-danger"></i><br>Loading...'
                }
            });

            // ✅ Filter Events
            $('#filterClass, #filterSection').on('change', function() {
                $(this).addClass('border-info');
                table.draw();
            });

            $('#resetFilter').click(function() {
                $('#filterClass, #filterSection').val('All').removeClass('border-info');
                table.draw();
            });

            // ✅ View All Students Modal
            $('#historyTable').on('click', '.view-all-students', function() {
                const uids = $(this).data('uids').toString().split(',');
                const names = $(this).data('names').toString().split(',');
                
                const uniqueStudents = [];
                const seen = new Set();
                
                uids.forEach((uid, index) => {
                    const cleanUid = uid.trim();
                    if (!seen.has(cleanUid)) {
                        seen.add(cleanUid);
                        uniqueStudents.push({
                            uid: cleanUid,
                            name: names[index] ? names[index].trim() : 'N/A'
                        });
                    }
                });

                $('#totalStudentsCount').text(uniqueStudents.length);
                
                const tbody = $('#allStudentsTableBody').empty();
                uniqueStudents.forEach((student, i) => {
                    tbody.append(`
                        <tr>
                            <td class="text-center">${i + 1}</td>
                            <td><span class="badge bg-danger">${student.uid}</span></td>
                            <td><strong>${student.name}</strong></td>
                        </tr>
                    `);
                });

                $('#allStudentsModal').modal('show');
            });

            // ✅ View Student History Modal
            $('#historyTable').on('click', '.view-student-history', function() {
                var uid = $(this).data('uid');
                var type = $(this).data('type');
                var studentUids = $(this).data('uids');
                var studentNames = $(this).data('names');
                var className = $(this).data('class');
                var sectionName = $(this).data('section');
                var genDate = $(this).data('date');

                $.ajax({
                    url: `/admin/students/id-card-history/details/${uid}`,
                    method: 'GET',
                    success: function(data) {
                        const history = data.history;
                        const totalGenerations = data.total_generations;

                        if (history.length > 0) {
                            const previewCount = history.filter(d => d.action_type === 'preview').length;
                            const generateCount = history.filter(d => d.action_type === 'generate').length;

                            // ✅ Student Info Display
                            if (type === 'classwise') {
                                const uids = studentUids.toString().split(',');
                                const names = studentNames.toString().split(',');
                                
                                const uniqueStudents = [];
                                const seen = new Set();
                                
                                uids.forEach((id, index) => {
                                    const cleanUid = id.trim();
                                    if (!seen.has(cleanUid)) {
                                        seen.add(cleanUid);
                                        uniqueStudents.push({
                                            uid: cleanUid,
                                            name: names[index] ? names[index].trim() : 'N/A'
                                        });
                                    }
                                });

                                $('#studentInfo').html(`
                                    <div class="card bg-light border-0">
                                        <div class="card-body">
                                            <div class="row align-items-center">
                                                <div class="col-md-8">
                                                    <h4 class="text-danger mb-2">
                                                        <i class="fa fa-users"></i> Classwise ID Card Generation
                                                    </h4>
                                                    <p class="mb-1">
                                                        <strong>Class:</strong> <span class="badge bg-info">${className}</span>
                                                        <strong>Section:</strong> <span class="badge bg-secondary">${sectionName}</span>
                                                    </p>
                                                    <p class="text-muted mb-0">
                                                        <i class="fa fa-calendar"></i> Generated on: <strong>${genDate}</strong>
                                                    </p>
                                                </div>
                                                <div class="col-md-4 text-end">
                                                    <button class="btn btn-info btn-sm view-all-students-in-modal" 
                                                        data-students='${JSON.stringify(uniqueStudents)}'>
                                                        <i class="fa fa-list"></i> View All Students (${uniqueStudents.length})
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                `);
                            } else {
                                const first = history[0];
                                $('#studentInfo').html(`
                                    <div class="card bg-light border-0">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <p class="mb-2">
                                                        <strong><i class="fa fa-id-badge text-danger"></i> Student UID:</strong> 
                                                        <span class="badge bg-danger fs-6">${first.student_uid}</span>
                                                    </p>
                                                    <p class="mb-2">
                                                        <strong><i class="fa fa-user text-success"></i> Name:</strong> 
                                                        <span class="text-dark">${first.student_name}</span>
                                                    </p>
                                                </div>
                                                <div class="col-md-6">
                                                    <p class="mb-2">
                                                        <strong><i class="fa fa-graduation-cap text-info"></i> Class:</strong> 
                                                        <span class="badge bg-info">${first.class_name}</span>
                                                    </p>
                                                    <p class="mb-2">
                                                        <strong><i class="fa fa-users text-warning"></i> Section:</strong> 
                                                        <span class="badge bg-secondary">${first.section_name}</span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                `);
                            }

                            // ✅ History Details Table
                            const tbody = $('#historyDetailsBody').empty();
                            history.forEach((item, i) => {
                                const date = new Date(item.generated_at).toLocaleString('en-IN', {
                                    day: '2-digit',
                                    month: 'short',
                                    year: 'numeric',
                                    hour: '2-digit',
                                    minute: '2-digit',
                                    hour12: true
                                });

                                const genBadge = item.generation_type === 'single' ? 'bg-danger' : 'bg-info';
                                const actBadge = item.action_type === 'preview' ? 'bg-success' : 'bg-warning text-dark';

                                tbody.append(`
                                    <tr>
                                        <td class="text-center">${i + 1}</td>
                                        <td><i class="fa fa-calendar text-muted"></i> ${date}</td>
                                        <td><span class="badge ${genBadge}">${item.generation_type.toUpperCase()}</span></td>
                                        <td><span class="badge ${actBadge}">${item.action_type.toUpperCase()}</span></td>
                                        <td><i class="fa fa-user-circle text-secondary"></i> ${item.generated_by}</td>
                                    </tr>
                                `);
                            });

                            // ✅ Update Stats
                            $('#previewCount').text(previewCount);
                            $('#generateCount').text(generateCount);
                            $('#totalCount').text(totalGenerations);
                        } else {
                            $('#studentInfo').html('<div class="alert alert-warning">No history found</div>');
                            $('#historyDetailsBody').html('<tr><td colspan="5" class="text-center text-muted">No records available</td></tr>');
                            $('#previewCount, #generateCount, #totalCount').text('0');
                        }

                        $('#studentHistoryModal').modal('show');
                    },
                    error: function(xhr) {
                        alert('Error loading history details: ' + xhr.status);
                    }
                });
            });

            // ✅ View All Students from Modal Button
            $(document).on('click', '.view-all-students-in-modal', function() {
                const students = $(this).data('students');
                
                $('#totalStudentsCount').text(students.length);
                
                const tbody = $('#allStudentsTableBody').empty();
                students.forEach((student, i) => {
                    tbody.append(`
                        <tr>
                            <td class="text-center">${i + 1}</td>
                            <td><span class="badge bg-danger">${student.uid}</span></td>
                            <td><strong>${student.name}</strong></td>
                        </tr>
                    `);
                });

                // Hide history modal and show students list modal
                $('#studentHistoryModal').modal('hide');
                $('#allStudentsModal').modal('show');
            });

            // ✅ Return to history modal when closing students list
            $('#allStudentsModal').on('hidden.bs.modal', function() {
                if ($('#studentHistoryModal').hasClass('show') === false) {
                    $('#studentHistoryModal').modal('show');
                }
            });
        });
    </script>
@endpush

@push('styles')
    <style>
        /* Table Styling */
        #historyTable {
            border-radius: 0.6rem;
            overflow: hidden;
        }

        #historyTable thead {
            background-color: #000000;
            color: #fff;
            text-align: center;
        }

        .table-hover tbody tr:hover {
            background-color: #ffe6e6;
        }

        /* Modal Styling */
        .modal-content {
            border-radius: 1rem;
            border: none;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
        }

        .modal-body {
            background-color: #f9fafc;
        }

        /* Cards inside Modal */
        .card.bg-light {
            border: none;
            border-radius: 0.75rem;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
        }

        /* Badges */
        .badge {
            font-size: 0.85rem;
            font-weight: 500;
            letter-spacing: 0.3px;
            padding: 0.4em 0.8em;
        }

        /* View All Students Button */
        .btn.view-all-students {
            white-space: nowrap;
            font-weight: 600;
        }

        .btn.view-all-students:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(220, 53, 69, 0.3);
            transition: all 0.2s;
        }

        /* Loading Spinner */
        .dataTables_processing {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 0.5rem;
            padding: 2rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .modal-lg {
                max-width: 95% !important;
            }

            .table-responsive {
                font-size: 0.85rem;
            }

            .badge {
                font-size: 0.75rem;
            }
        }
    </style>
@endpush