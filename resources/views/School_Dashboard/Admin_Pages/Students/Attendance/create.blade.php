@extends('school_dashboard.admin_layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between bg-primary text-white">
                <h3><i class="fa fa-user-plus me-2"></i> Mark Students Attendance</h3>
                <div class="card-tools">
                    <a href="{{ route('student_attendance.index') }}" class="btn btn-light">
                        <i class="fa fa-list me-1"></i> Attendance List
                    </a>
                </div>
                
            </div>

            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Class</label>
                        <select id="class_id" name="class_id" class="globalClassSelect form-select rounded-3" required>
                            <option value="">Select Class</option>
                            @foreach ($classes as $class)
                                <option value="{{ $class->id }}">{{ $class->class_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Section</label>
                        <select id="section_id" name="section_id" required class="globalSectionSelect form-select">
                            <option value=""> Select Section </option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Date</label>
                        <input type="date" id="attendanceDate" class="form-control" value="{{ date('Y-m-d') }}"
                            max="{{ date('Y-m-d') }}">
                    </div>
                </div>

                <div class="mt-3">
                    <button id="loadStudents" class="btn btn-success" disabled>Load Students</button>
                </div>

                <form id="attendanceForm" class="mt-4">
                    @csrf
                    <table class="table table-bordered" id="studentTable" style="display:none;">
                        <thead>
                            <tr>
                                <th>Roll</th>
                                <th>Student Name</th>
                                <th>Father Mobile</th>
                                <th><input type="checkbox" id="selectAbsentAll"> Absents</th>
                                <th><input type="checkbox" id="selectLeaveAll"> Leave</th>
                                <th>Reason (if Leave)</th>
                            </tr>
                        </thead>
                        <tbody id="studentBody"></tbody>
                    </table>

                    <button type="submit" id="submitAttendance" class="btn btn-primary" style="display:none;">Submit
                        Attendance</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('pos/assets/js/CustomJS/Global/global.js') }}"></script>


    <script>
        $(function() {
            // CSRF for AJAX
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });

            // जब class चुने जाएं -> sections load
            $('#globalClassSelect').on('change', function() {
                let classId = $(this).val();
                $('#studentTable, #submitAttendance').hide();

                if (!classId) {
                    $('#loadStudents').prop('disabled', true);
                    return;
                }
            });

            // enable Load button when section selected
            $('.globalSectionSelect').on('change', function() {
                $('#loadStudents').prop('disabled', !$(this).val());
                $('#studentTable, #submitAttendance').hide();
            });

            // 🎯 When "Load Students" button is clicked
            $('#loadStudents').on('click', function(e) {
                e.preventDefault();

                // 🧩 Step 1: Cache button for easy control
                let btn = $('#loadStudents');
                let originalText = btn.html(); // Save original button text

                // 🟢 Step 2: Disable button and show spinner
                btn.prop('disabled', true);
                btn.html('<i class="fas fa-spinner fa-spin me-2"></i> Processing...');

                // 🧠 Step 3: Get selected class and section
                let classId = $('.globalClassSelect').val();
                let sectionId = $('.globalSectionSelect').val();

                // 🛑 Step 4: Validation check — section must be selected
                if (!sectionId) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Missing Section',
                        text: 'Please select a section before loading students.',
                    });
                    btn.prop('disabled', false).html(originalText); // reset button
                    return;
                }

                // 🧩 Step 5: AJAX GET request to fetch students
                $.get("{{ route('attendance.fetchStudents') }}", {
                        section_id: sectionId,
                        class_id: classId
                    })
                    .done(function(students) {
                        // ✅ If no students found
                        if (students.length === 0) {
                            $('#studentBody').html(`
                             <tr>
                                 <td colspan="6" class="text-center text-muted">
                                     <i class="fas fa-user-slash me-2"></i> No students found for this section.
                                 </td>
                             </tr>
                         `);
                            $('#studentTable, #submitAttendance').show();
                            return;
                        }

                        // 🧱 Step 6: Build student rows dynamically
                        let rows = '';
                        students.forEach(s => {
                            rows += `
                        <tr>
                         
                                <td>${s.student_uid ?? ''}</td>
                                <td>${s.student_name}</td>
                            <td>${s.father_mobile ?? '-'}</td>
                               <td>
                                <input type="checkbox" class="absentCheckbox" name="absent[]" value="${s.id}"> Absent
                            </td>
                        <td>
                                <input type="checkbox" class="leaveCheckbox" name="leave[]" value="${s.id}"> Leave
                                    </td>
                                    <td>
                                    <input type="text" 
                                   class="form-control reasonInput" 
                                   name="reason[${s.id}]" 
                                        placeholder="Enter reason (if leave)">
                        </td>
                            </tr>
                        `;
                        });

                        // 📦 Step 7: Inject rows into table
                        $('#studentBody').html(rows);

                        // 🪄 Step 8: Show table & submit button
                        $('#studentTable, #submitAttendance').show();

                        // 🧼 Step 9: Reset "Select All" checkbox
                        $('#selectAbsentAll').prop('checked', false);
                        $('#selectLeaveAll').prop('checked', false);
                    })
                    .fail(function() {
                        // ❌ Error handling
                        Swal.fire({
                            icon: 'error',
                            title: 'Error Loading Students',
                            text: 'Something went wrong while fetching student data.',
                        });
                    })
                    .always(function() {
                        // 🔚 Step 10: Re-enable button & restore text
                        btn.prop('disabled', false).html(originalText);
                    });
            });


            // Select all / deselect all for absent checkboxes
            $(document).on('change', '#selectAbsentAll', function() {
                $('.absentCheckbox').prop('checked', $(this).prop('checked'));
            });
            $(document).on('change', '#selectLeaveAll', function() {
                $('.leaveCheckbox').prop('checked', $(this).prop('checked'));
            });

            // 🟢 Attendance form submit event
            $('#attendanceForm').on('submit', function(e) {
                e.preventDefault();
                // 🟢 Step 1: Disable button & show spinner text
                let btn = $('#submitAttendance');
                let originalText = btn.html(); // Save original text (e.g. "Submit Attendance")
                btn.prop('disabled', true);
                btn.html('<i class="fas fa-spinner fa-spin me-2"></i> Processing...');
                $('#loadStudents').prop('disabled', true);

                let classId = $('#class_id').val();
                let sectionId = $('#section_id').val();
                let date = $('#attendanceDate').val();
                if (!sectionId || !date || !classId) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Missing Fields',
                        text: 'Please select class, section, and date before submitting.',
                    });
                     // 🔚 Step: Always reset button after request (success or fail)
                        btn.prop('disabled', false).html(originalText);
                    return;
                }

                // 🔹 Step 1: Collect all student IDs
                let studentIds = [];
                $('#studentBody').find('input').each(function() {
                    let name = $(this).attr('name') || '';
                    if (name.startsWith('reason[')) {
                        let id = name.match(/\d+/);
                        if (id) studentIds.push(id[0]);
                    }
                });
                studentIds = [...new Set(studentIds)];

                // 🔹 Step 2: Get Absent & Leave arrays
                let absentArr = $('.absentCheckbox:checked').map(function() {
                    return this.value;
                }).get();

                let leaveArr = $('.leaveCheckbox:checked').map(function() {
                    return this.value;
                }).get();

                // 🔹 Step 3: Conflict Handling — If same student is in both absent & leave, keep only leave
                let correctedAbsentArr = absentArr.filter(id => !leaveArr.includes(id));

                // 🔹 Step 4: Collect reasons
                let reasons = {};
                $('.reasonInput').each(function() {
                    let name = $(this).attr('name'); // example: reason[5]
                    let id = name.match(/\d+/);
                    if (id) reasons[id[0]] = $(this).val();
                });

                // 🔹 Step 5: Send Data via AJAX
                $.ajax({
                    url: "{{ route('student_attendance.store') }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        section_id: sectionId,
                        class_id: classId,
                        date: date,
                        student_ids: studentIds,
                        absent: correctedAbsentArr, // ✅ corrected absent list
                        leave: leaveArr, // ✅ leave has higher priority
                        reason: reasons
                    },
                    success: function(res) {
                        if (res.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Attendance Saved!',
                                text: res.message,
                                timer: false,
                                showConfirmButton: true
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: res.message || 'Something went wrong.',
                                timer: false,
                                showConfirmButton: true
                            });
                        }
                    },
                    error: function(xhr) {
                        let msg = 'Validation error occurred.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            msg = xhr.responseJSON.message;
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: msg,
                            timer: false,
                            showConfirmButton: true
                        });
                    },
                    complete: function() {
                        // 🔚 Step: Always reset button after request (success or fail)
                        btn.prop('disabled', false).html(originalText);
                    }
                });
            });

        });
    </script>
@endpush
