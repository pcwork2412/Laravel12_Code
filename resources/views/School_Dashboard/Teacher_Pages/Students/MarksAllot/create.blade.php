@extends('School_Dashboard.Teacher_Layouts.app')

@section('content')
    <div class="container my-5">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Allot Marks</h4>
                <a href="{{ route('marks.index') }}" class="btn btn-light btn-sm">
                    <i class="fas fa-eye"></i> See Marks List
                </a>
            </div>
            <div class="card-body">
                <form action="{{ route('marks.store') }}" id="marksForm" method="POST">
                    @csrf
                    <input type="hidden" name="student_id" id="student_id">
                    <!-- Class, Section, Student -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Class</label>
                            <select id="classSelect" name="class_name" class="class_name  form-select" required>
                                <option value="">Select Class</option>
                                @foreach ($classes as $class)
                                    <option value="{{ $class->id }}">{{ $class->class_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Section</label>
                            <select id="sectionSelect" name="section_name" class="section_name  form-select" required>
                                <option value="">Select Section</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Student</label>
                            <select name="student_id" data-check-url="{{ url('/check-student-marks') }}" id="studentSelect" class="student_id  form-select" required>
                                <option value="">Select Student</option>
                            </select>
                        </div>
                    </div>

                    <!-- Subjects -->
                    <!-- Subjects -->
                    <div id="subjects"></div>



                    <!-- Exam Type & Year -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Exam Type</label>
                            <input type="text" name="exam_type" class="exam_type form-control" placeholder="e.g. Final">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Year</label>
                            <input type="number" name="year" class="year form-control" value="{{ date('Y') }}">
                        </div>
                    </div>

                    <!-- Submit -->
                    <div class="d-flex justify-content-end">
                        <button type="submit" id="saveMarks" class="btn btn-primary">
                            <i class="fas fa-save"></i> Save Marks
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('pos/assets/js/CustomJS/MarksAllot/createfile.js') }}"></script>
@endpush
