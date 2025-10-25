@extends('School_Dashboard.Admin_Layouts.app')

@section('content')
  @if ($errors->any())
                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

                    <script>
                        let errors = @json($errors->all());
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops!',
                            html: errors.join("<br>"), // line break in HTML
                        });
                    </script>
                @endif
    <div class="container my-5">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Allot Marks</h4>
                <a href="{{ route('marks.index') }}" class="btn btn-light btn-sm">
                    <i class="fas fa-eye"></i> See Marks List
                </a>
            </div>
            <div class="card-body">
              

                <form action="{{ route('marks.store') }}" method="POST" id="allotNowMarksForm">
                    @csrf
                    {{-- @method('PUT') <!-- ✅ PUT method for update --> --}}

                    <input type="hidden" name="student_id" id="student_id">

                    <!-- Class, Section, Student -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Class</label>
                            <select id="classSelect" name="class_name" class="class_name form-select" required>
                                <option value="{{ $data['class_id'] }}" selected>
                                    {{ $data['promoted_class_name'] }}
                                </option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Section</label>
                            <select name="section_id" class="form-select">
                                <option value="{{ $data['section_id'] }}" selected>
                                    {{ $data['section'] }}
                                </option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Student</label>
                            <select name="student_id" data-check-url="{{ url('/check-student-marks') }}" id="studentSelect"
                                class="student_id form-select" required>
                                <option value="{{ $data['student_id'] }}" selected>
                                    {{ $data['student_name'] }}
                                </option>
                            </select>
                        </div>
                    </div>

                    <!-- Subjects -->
                    <div id="subjects">
                        @foreach ($subjects as $subject)
                            <div class="row g-2 mb-3 align-items-center subject-row">
                                <div class="col-md-4">
                                    <input type="text" name="subject_name[]" class="form-control"
                                        value="{{ $subject->subject_name }}" readonly>
                                </div>
                                <div class="col-md-4">
                                    <input type="number" name="max_marks[]" class="form-control"
                                        value="{{ $subject->max_marks }}" readonly>
                                </div>
                                <div class="col-md-4">
                                    <input type="number" name="obtained_marks[]" class="form-control"
                                        placeholder="Enter Obtained Marks" value="">
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Exam Type & Year -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Exam Type</label>
                            <input type="text" value="" name="exam_type" class="exam_type form-control"
                                placeholder="e.g. Final">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Year</label>
                            <input type="number" value="" name="year" class="year form-control">
                        </div>
                    </div>

                    <!-- Submit -->
                    <div class="d-flex justify-content-end">
                        <button type="submit" name="action" value="allotNowBtn" id="saveMarks" class="btn btn-primary">
                            <i class="fas fa-save"></i> Save Marks
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
@endsection
@push('scripts')
    <script>
        $(document).on("submit", "#updateMarksForm", function(e) {
            e.preventDefault();

            let form = $(this);
            let url = form.attr("action");
            let formData = form.serialize();

            $.ajax({
                url: url,
                type: "PUT", // या POST + _method=PUT अगर serialize कर रहे हो तो form में @method('PUT') होना चाहिए
                data: formData,
                dataType: "json", // ✅ parse response as JSON
                success: function(res) {
                    console.log("AJAX success response:", res); // debug के लिए
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: res.message || 'Updated'
                    }).then(function() {
                        // अगर redirect_url मिला तो redirect, नहीं तो page reload
                        if (res && res.redirect_url) {
                            window.location.href = res.redirect_url;
                        } else {
                            location.reload();
                        }
                    });
                },
                error: function(xhr) {
                    console.log("AJAX error:", xhr);
                    if (xhr.status === 422) {
                        // validation errors
                        let errors = xhr.responseJSON?.errors || {};
                        let html = "<ul style='text-align:left'>";
                        $.each(errors, function(k, v) {
                            html += "<li>" + v[0] + "</li>";
                        });
                        html += "</ul>";
                        Swal.fire({
                            icon: 'error',
                            title: 'Validation',
                            html: html
                        });
                    } else {
                        // अगर server ने HTML भेजा (redirect to login etc.) तो xhr.responseText में HTML होगा
                        let msg = xhr.responseJSON?.message || "Something went wrong!";
                        Swal.fire('Error', msg, 'error');
                    }
                }
            });
        });
    </script>
@endpush
