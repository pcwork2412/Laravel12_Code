@extends('school_dashboard.admin_layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between bg-primary text-white">
                <h3><i class="fa fa-user-plus me-2"></i> Mark Teachers Attendance</h3>
                <div class="card-tools">
                    <a href="{{ route('teacher_attendance.index') }}" class="btn btn-light">
                        <i class="fa fa-list me-1"></i> Attendance List
                    </a>
                </div>
                
            </div>

            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Date</label>
                        <input type="date" id="attendanceDate" class="form-control" value="{{ date('Y-m-d') }}"
                            max="{{ date('Y-m-d') }}">
                    </div>
                </div>

                <div class="mt-3">
                    <button id="loadTeachers" class="btn btn-success" >Load Teachers</button>
                </div>

                <form id="attendanceForm" class="mt-4">
                    @csrf
                    <table class="table table-bordered" id="teacherTable" style="display:none;">
                        <thead>
                            <tr>
                                <th style="width:40px;"><input type="checkbox" id="selectAll"></th>
                                <th>Teacher ID</th>
                                <th>Teacher Name</th>
                                <th>Teacher Mobile</th>
                                <th style="width:100px;">Leave</th>
                                <th>Reason (if Leave)</th>
                            </tr>
                        </thead>
                        <tbody id="teacherBody"></tbody>
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
         

            // 🎯 When "Load Teachers" button is clicked
            $('#loadTeachers').on('click', function(e) {
                e.preventDefault();

                // 🧩 Step 1: Cache button for easy control
                let btn = $('#loadTeachers');
                let originalText = btn.html(); // Save original button text

                // 🟢 Step 2: Disable button and show spinner
                btn.prop('disabled', true);
                btn.html('<i class="fas fa-spinner fa-spin me-2"></i> Processing...');

              
                // 🧩 Step 5: AJAX GET request to fetch teachers
                $.get("{{ route('attendance.fetchTeachers') }}", {
                            // section_id: sectionId,
                            // class_id: classId
                })
                    .done(function(teachers) {
                        // ✅ If no teachers found
                        if (teachers.length === 0) {
                            $('#teacherBody').html(`
                             <tr>
                                 <td colspan="6" class="text-center text-muted">
                                     <i class="fas fa-user-slash me-2"></i> No teachers found for this section.
                                 </td>
                             </tr>
                         `);
                            $('#teacherTable, #submitAttendance').show();
                            return;
                        }

                        // 🧱 Step 6: Build teacher rows dynamically
                        let rows = '';
                        teachers.forEach(s => {
                            rows += `
                        <tr>
                            <td>
                                <input type="checkbox" class="absentCheckbox" name="absent[]" value="${s.id}">
                            </td>
                                <td>${s.teacher_id ?? ''}</td>
                                <td>${s.teacher_name}</td>
                            <td>${s.mobile ?? '-'}</td>
                        <td>
                                <input type="checkbox" class="leaveCheckbox" name="leave[]" value="${s.id}">
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
                        $('#teacherBody').html(rows);

                        // 🪄 Step 8: Show table & submit button
                        $('#teacherTable, #submitAttendance').show();

                        // 🧼 Step 9: Reset "Select All" checkbox
                        $('#selectAll').prop('checked', false);
                    })
                    .fail(function() {
                        // ❌ Error handling
                        Swal.fire({
                            icon: 'error',
                            title: 'Error Loading Teachers',
                            text: 'Something went wrong while fetching teacher data.',
                        });
                    })
                    .always(function() {
                        // 🔚 Step 10: Re-enable button & restore text
                        btn.prop('disabled', false).html(originalText);
                    });
            });


            // Select all / deselect all for absent checkboxes
            $(document).on('change', '#selectAll', function() {
                $('.absentCheckbox').prop('checked', $(this).prop('checked'));
            });

            // 🟢 Attendance form submit event
            $('#attendanceForm').on('submit', function(e) {
                e.preventDefault();
                // 🟢 Step 1: Disable button & show spinner text
                let btn = $('#submitAttendance');
                let originalText = btn.html(); // Save original text (e.g. "Submit Attendance")
                btn.prop('disabled', true);
                btn.html('<i class="fas fa-spinner fa-spin me-2"></i> Processing...');
                $('#loadTeachers').prop('disabled', true);
                // 🟢 Step 2: Gather form data
                let date = $('#attendanceDate').val();
                if (!date) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Date Required',
                        text: 'Please select an attendance date.',
                    });
                    btn.prop('disabled', false).html(originalText);
                    $('#loadTeachers').prop('disabled', false);
                    return;
                }

                // 🔹 Step 1: Collect all teacher IDs
                let teacherIds = [];
                $('#teacherBody').find('input').each(function() {
                    let name = $(this).attr('name') || '';
                    if (name.startsWith('reason[')) {
                        let id = name.match(/\d+/);
                        if (id) teacherIds.push(id[0]);
                    }
                });
                teacherIds = [...new Set(teacherIds)];

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
                    url: "{{ route('teacher_attendance.store') }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        date: date,
                        teacher_ids: teacherIds,
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
