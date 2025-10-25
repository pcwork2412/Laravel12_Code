@extends('school_dashboard.admin_layouts.app')
@section('content')
    @include('school_dashboard.admin_layouts.flash-message')
    <!-- 🔹 Modal -->
    <div class="modal fade" id="teacherAllotModal" tabindex="-1" aria-labelledby="teacherAllotModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h3 class="modal-title" id="teacherAllotModalLabel">Allot Teacher</h3>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form id="teacherAllotForm" class="needs-validation" novalidate>
                        @csrf
                        {{-- 🔹 Teacher Dropdown --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-secondary">Select Teacher</label>
                            <select name="teacher_id" id="teacher_id" class="form-select " required>
                                <option value="">-- Choose Teacher --</option>
                                @foreach ($teachers as $teacher)
                                    <option value="{{ $teacher->id }}">{{ $teacher->teacher_name }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">Please select a teacher.</div>
                        </div>

                        {{-- 🔹 Main Class & Section --}}
                        <div class="row g-4 mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-secondary">Main Class</label>
                                <select id="main_class_id" name="main_class_id"
                                    class="globalClassSelect form-select  rounded-3" required>
                                    <option value="">Select Class</option>
                                    @foreach ($classes as $class)
                                        <option value="{{ $class->id }}">{{ $class->class_name }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Please select a class.</div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-secondary">Main Section</label>
                                <select name="main_section_id" id="main_section_id"
                                    class="globalSectionSelect form-select  rounded-3" required>
                                </select>
                                <div class="invalid-feedback">Please select a section.</div>
                            </div>
                        </div>

                        <div class="row g-4 mb-4">
                            <div class="col-12">
                                <label class="form-label fw-semibold text-secondary">Sub Classes & Sections</label>
                                <div class=" d-flex gap-2 flex-wrap justify-content-start align-items-start"
                                    style="max-height: 400px; overflow-y: auto;">
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
                                                        <label class="form-check-label"
                                                            for="sectionCheck{{ $section->id }}">
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
                            <button type="submit" id="teacherAllotSaveBtn" class="btn btn-success rounded-pill px-4 ">
                                <i class="bi bi-check-circle-fill me-1"></i>Allot Teacher
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Alloted Data View Model --}}
   <!-- Alloted Data View Modal -->
<div class="modal fade" id="allotedDataShowModal" tabindex="-1" aria-labelledby="allotedDataShowModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg rounded-3">
            <div class="modal-header bg-primary text-white">
                <h3 class="modal-title fw-bold" id="allotedDataShowModalLabel">
                    <i class="fa fa-layer-group me-2"></i> Teacher Name: <span id="teacherNameText"></span>
                </h3>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>

            <div class="modal-body bg-light">
                <!-- Summary Info -->
                <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
                    <h5 class="mb-0 text-secondary">
                        <i class="fa fa-chalkboard me-2"></i> Total Classes:
                        <span id="totalClassesText" class="fw-bold text-dark">0</span>
                    </h5>
                    <h5 class="mb-0 text-secondary">
                        <i class="fa fa-list me-2"></i> Total Sections:
                        <span id="totalSectionsText" class="fw-bold text-dark">0</span>
                    </h5>
                    <h5 class="mb-0 text-secondary">
                        <i class="fa fa-users me-2"></i> Total Students:
                        <span id="totalTeachersText" class="fw-bold text-dark">0</span>
                    </h5>
                </div>

                <!-- Dynamic Cards Container -->
                <div id="allotedCardsContainer" class="row gy-3">
                    <!-- Cards will be injected here -->
                </div>
            </div>

            <div class="modal-footer bg-white border-top">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fa fa-times me-1"></i> Close
                </button>
            </div>
        </div>
    </div>
</div>




    {{-- ✅ Allotted Teachers List --}}
    <div class="card shadow-sm rounded-2">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="mb-0 fw-bold text-primary">
                <i class="fa-solid fa-chalkboard-teacher me-2"></i>Allotted Teachers List
            </h3>
            <!-- 🔹 Button to trigger modal -->
            <button type="button" id="teacherAllotBtn" class="btn btn-primary" data-bs-toggle="modal"
                data-bs-target="#teacherAllotModal">
                <i class="fa-solid fa-plus-circle me-1"></i> Allot Teacher
            </button>
        </div>
    </div>
    <div class="card shadow-sm border-0 rounded-1">
        <div class="card-body p-3">
            <div class="table-responsive">
                <table id="teacherAllotTable" class="table table-bordered table-striped align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th style="width: 5%">#</th>
                            <th>Teacher</th>
                            <th>Main Class</th>
                            <th>Main Section</th>
                            <th>View Allotted Classes / Sections</th>

                            {{-- <th>Sub Sections</th> --}}
                            <th style="width: 10%">Actions</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>

            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('pos/assets/js/CustomJS/Global/global.js') }}"></script>
    {{-- AJAX & DataTable Script --}}
    <script src="{{ asset('pos/assets/js/CustomJS/Teachers/allotclassajax.js') }}"></script>
    <script></script>
@endpush
