@extends('school_dashboard.admin_layouts.app')
@section('content')
    {{-- ✅ Success & Error Alerts --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show  rounded-3" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show  rounded-3" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

   <div class="container">
     {{-- ✅ Allot Teacher Card --}}
    <div class="card border-1 shadow-md rounded-1 overflow-hidden">
        <div class="card-header text-white bg-primary d-flex justify-content-between align-items-center">
            <h3 class="mb-0 fw-bold"><i class="bi bi-person-plus-fill me-2"></i>Allot Teacher</h3>
            <a href="{{ route('admin_teachers_allot.index') }}" class="btn btn-white ">
                <i class="fa fa-list me-1"></i>Allot Teacher List
            </a>
        </div>

        <div class="card-body bg-light p-4">
            <form id="teacherAllotForm" class="needs-validation" novalidate>
                @csrf
                {{-- 🔹 Teacher Dropdown --}}
                <div class="mb-4">
                    <label class="form-label fw-semibold text-secondary">Select Teacher</label>
                    <select name="teacher_id" class="form-select " required>
                        <option value="">-- Choose Teacher --</option>
                        @foreach ($teachers as $teacher)
                            {{-- @php
                                $isAllotted = $allotedTeachers->contains('teacher_id', $teacher->id);
                            @endphp --}}
                            <option value="{{ $teacher->id }}">
                                {{-- @if ($isAllotted) class="bg-light bg-opacity-10 text-success fw-semibold" @endif> --}}
                                {{ $teacher->teacher_name }}
                                {{-- @if ($isAllotted) --}}
                                    {{-- (Already Allotted) --}}
                                {{-- @endif --}}
                            </option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback">Please select a teacher.</div>
                </div>

                {{-- 🔹 Main Class & Section --}}
                <div class="row g-4 mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-secondary">Main Class</label>
                        <select id="main_class_id" name="main_class_id" class="globalClassSelect form-select  rounded-3"
                            required>
                            <option value="">Select Class</option>
                            @foreach ($classes as $class)
                                @php
                                    // $isAllotted = $allotedTeachers->contains('teacher_id', $teacher->id);
                                @endphp
                                <option value="{{ $class->id }}">{{ $class->class_name }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">Please select a class.</div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-secondary">Main Section</label>
                        <select name="main_section_id" class="globalSectionSelect form-select  rounded-3" required>
                        </select>
                        <div class="invalid-feedback">Please select a section.</div>
                    </div>
                </div>
                <div class="row g-4 mb-4">
                    <div class="col-12">
                        <label class="form-label fw-semibold text-secondary">Sub Classes & Sections</label>
                        <div class=" d-flex gap-2 flex-wrap justify-content-start align-items-start" style="max-height: 400px; overflow-y: auto;">
                            @foreach ($classes as $class)
                                <div class="mb-3 border p-3 rounded-3 bg-white">
                                    {{-- Class Checkbox --}}
                                    <div class="form-check mb-1 ">
                                        <input class="form-check-input class-checkbox" type="checkbox"
                                            id="classCheck{{ $class->id }}" data-class-id="{{ $class->id }}"
                                            name="sub_class_ids[]" value="{{ $class->id }}">
                                        <label class="form-check-label fw-bold" for="classCheck{{ $class->id }}">
                                            {{ $class->class_name }}
                                        </label>
                                    </div>

                                    {{-- Sections under this class --}}
                                    <div class="ms-4">
                                        @foreach ($sections[$class->id] ?? [] as $section)
                                            <div class="form-check">
                                                <input
                                                    class="form-check-input section-checkbox section-of-{{ $class->id }}"
                                                    type="checkbox" id="sectionCheck{{ $section->id }}"
                                                    name="sub_section_ids[{{ $class->id }}][]"
                                                    value="{{ $section->id }}" disabled>
                                                <label class="form-check-label" for="sectionCheck{{ $section->id }}">
                                                    Section-{{ $section->section_name }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>




                {{-- 🔹 Buttons --}}
                <div class="d-flex justify-content-end pt-3 border-top">
                    <button type="submit" class="btn btn-success rounded-pill ">
                        <i class="bi bi-plus-circle me-1"></i>Allot Teacher
                    </button>
                </div>
            </form>
        </div>
    </div>
   </div>
@endsection

@push('scripts')
    <script src="{{ asset('pos/assets/js/CustomJS/Global/global.js') }}"></script>


    <script>
        $(document).ready(function() {

            // When class checkbox is toggled
            $('.class-checkbox').on('change', function() {
                let classId = $(this).data('class-id');
                let isChecked = $(this).is(':checked');

                let sections = $('.section-of-' + classId);
                sections.prop('disabled', !isChecked); // enable/disable sections
                sections.prop('checked', isChecked); // check/uncheck all sections
            });

            // ✅ Add / Update via AJAX
            $('#teacherAllotForm').on('submit', function(e) {
                e.preventDefault();

                let form = $(this);
                let formData = form.serialize();

                // ✅ Get ID from hidden field (or data attribute)
                let id = form.data('id'); // ya aap edit button se set kar rahe ho
                let url = id ? `/admin_teachers_allot/${id}` : '/admin_teachers_allot';
                let method = id ? 'POST' :
                'POST'; // always POST for AJAX, _method=PUT handle karega Laravel

                $.ajax({
                    url: url,
                    type: method,
                    data: formData,
                    beforeSend: function() {
                        form.find('button[type="submit"]').prop('disabled', true).text(
                            'Processing...');
                    },
                    success: function(res) {
                        $('#teacherAllotModal').modal('hide');
                        form[0].reset();
                        form.find('button[type="submit"]').prop('disabled', false).html(
                            '<i class="bi bi-check-circle-fill me-1"></i>Allot Teacher');

                        Toastify({
                            text: res.message || "Saved successfully!",
                            duration: 3000,
                            gravity: "top",
                            position: "right",
                            background: "linear-gradient(to right, #00b09b, #96c93d)",
                            close: true
                        }).showToast();

                        allotTable.ajax.reload();
                    },
                    error: function(xhr) {
                        form.find('button[type="submit"]').prop('disabled', false).text(
                            'Allot Teacher');
                        Toastify({
                            text: xhr.responseJSON?.message || "Something went wrong!",
                            duration: 4000,
                            gravity: "top",
                            position: "right",
                            background: "linear-gradient(to right, #ff5f6d, #ffc371)",
                            close: true
                        }).showToast();
                    }
                });
            });


        });
    </script>
@endpush
