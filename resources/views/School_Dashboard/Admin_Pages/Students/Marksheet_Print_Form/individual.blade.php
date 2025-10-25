@extends('School_Dashboard.Admin_Layouts.app')
@section('content')
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-12">

                {{-- Alerts --}}
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                {{-- Card --}}
                <div class="card shadow-sm border-0">
                    <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white">
                        <h3 class="mb-0">Individual Student Marksheet Download</h3>
                           <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    <a href="{{ route('marks.index') }}" class="btn btn-white me-2">
                        <i class="fa fa-list me-1"></i>Marks Allot List</a>
                </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('marksheet.student.download') }}" method="POST" id="marksForm">
                            @csrf
                            <div class="row">

                                {{-- Class --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="class_name" class="form-label fw-bold">Class</label>
                                        <select id="class_name" name="class_name" class="form-select globalClassSelect"
                                            required>
                                            <option value="">Select Class</option>
                                            @foreach ($classes as $class)
                                                <option value="{{ $class->id }}">{{ $class->class_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                {{-- Section --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="section" class="form-label fw-bold">Section</label>
                                        <select id="section_name" name="section_name"
                                            class=" globalSectionSelect  form-select" required>
                                            <option value="">Select Section</option>
                                        </select>
                                        {{-- <select id="section" name="section" class="form-select" required>
                                    <option value="">Select Section</option>
                                    @foreach ($sections as $sectionName)
                                        <option value="{{ $sectionName }}"
                                            {{ old('section_name') == $sectionName ? 'selected' : '' }}>
                                            {{ $sectionName }}
                                        </option>
                                    @endforeach
                                </select> --}}
                                    </div>
                                </div>

                            </div>
                         
                            <div class="row">
                                   {{-- Student UID --}}
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="student_uid" class="form-label fw-bold">Student UID</label>
                                    <select name="student_uid" id="student_uid" class="globalStudentSelect  form-select"
                                        required>
                                        <option value="">Select Student</option>
                                    </select>
                                    {{-- <input type="text" id="student_uid" name="student_uid" class="form-control"
                                    placeholder="Enter Student UID" required> --}}
                                </div>
                            </div>
                            {{-- Buttons --}}
                            <div class="col-md-6 d-flex align-items-center gap-2">
                                <button type="submit" class="btn btn-info" name="action" value="preview"><i
                                        class="fa fa-eye"></i> Preview</button>
                                <button type="submit" class="btn btn-primary" name="action" value="generate"><i
                                        class="fa fa-download"></i> Download Marksheet</button>
                            </div>

                            </div>

                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>


@endsection

@push('scripts')
    <script src="{{ asset('pos/assets/js/CustomJS/Global/global.js') }}"></script>
@endpush
