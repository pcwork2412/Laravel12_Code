@extends('School_Dashboard.Teacher_Layouts.app')

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
                <form action="{{ url('/marks/' . $data['student_id'] . '/update') }}" method="POST">
                    @csrf
                    {{-- @method('PUT') <!-- ✅ PUT method for update --> --}}

                    {{-- <input type="hidden" name="student_id" id="student_id" value="{{ $data['student_id'] }}"> --}}

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
                        @foreach ($data['subjects'] as $subject)
                            <div class="row g-2 mb-3 align-items-center subject-row">
                                <div class="col-md-4">
                                    <input type="text" name="subject_name[]" class="form-control"
                                        value="{{ $subject['subject_name'] }}" readonly>
                                </div>
                                <div class="col-md-4">
                                    <input type="number" name="max_marks[]" class="form-control"
                                        value="{{ $subject['max_marks'] }}" readonly>
                                </div>
                                <div class="col-md-4">
                                    <input type="number" name="obtained_marks[]" class="form-control"
                                        value="{{ $subject['obtained_marks'] }}">
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Exam Type & Year -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Exam Type</label>
                            <input type="text" value="{{ $data['exam_type'] }}" name="exam_type"
                                class="exam_type form-control" placeholder="e.g. Final">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Year</label>
                            <input type="number" value="{{ $data['year'] }}" name="year" class="year form-control">
                        </div>
                    </div>

                    <!-- Submit -->
                    <div class="d-flex justify-content-end">
                        <button type="submit" id="saveMarks" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Marks
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
