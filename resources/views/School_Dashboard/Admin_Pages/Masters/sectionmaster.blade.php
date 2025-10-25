@extends('School_Dashboard.Admin_Layouts.app')
@section('content')
    {{-- Delete Selected Button --}}
    {{-- <button type="button" id="deleteSelectedBtn" class="btn btn-danger shadow mb-3 ms-2"
    data-url="{{ route('master-class.deleteMultiple') }}">
    <i class="fa fa-trash"></i> Delete Selected
</button> --}}
    <div class="card shadow-sm mb-3">
        <div class="card-body bg-white">
            {{-- Add New Section Button --}}
            <div class="d-flex justify-content-between align-items-center">

                <!-- ✅ Left Button -->
                <div class="">
                    <h3 class="mb-0 fw-bold text-primary"><i class="fa fa-list"></i> Sections List</h3>

                </div>
                <!-- ✅ Right Button -->
                <div class="">
                    <button type="button" id="createBtn" class="btn btn-success shadow-sm" data-bs-toggle="modal"
                        data-bs-target="#myModal">
                        <i class="fa fa-plus-circle"></i> Add New Section
                    </button>
                    <a href="{{ route('class_name.index') }}" class="btn btn-outline-primary shadow-sm">
                        <i class="fa fa-arrow-left"></i> Back to Class List
                    </a>
                </div>

            </div>
        </div>
    </div>

    {{-- Table Section Start --}}
    <div class="card shadow-sm">
        <div class="card-body bg-white">
            @if (isset($stdClasses) && $stdClasses->count() > 0)
                <div class="alert alert-info">
                    <strong>Selected Class Name:</strong> {{ $stdClasses->first()->class_name }}
                </div>
            @endif


            <div class="table-responsive" id="sectionList">
                <table id="sectionTable" class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Class Name</th>
                            <th>Section Name</th>
                            <th>Total Students</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $sn = 1; @endphp
                        @foreach ($stdClasses as $cl)
                            @foreach ($cl->sections as $sec)
                                <tr id="studentRow_{{ $cl->id }}_{{ $sec->id }}">
                                    <td>{{ $sn++ }}</td>
                                    <td>{{ $cl->class_name }}</td>
                                    <td>{{ $sec->section_name }}</td>
                                                <td>{{ $sec->students_count }}</td>
                                    <td>
                                        <button class="btn btn-warning btn-sm editSectionBtn" data-id="{{ $sec->id }}">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                        <button class="btn btn-danger btn-sm deleteSectionBtn"
                                            data-id="{{ $sec->id }}">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
    {{-- Table Section End --}}

    {{-- Modal Section Start --}}
    <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="sectionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded shadow-sm">
                <div class="modal-header bg-primary text-white p-1">
                    <h2 class="modal-title font-weight-normal m-1 ps-2" id="sectionModalLabel">Add Section</h2>
                    <button type="button" class="btn-close btn-close-white fs-5 m-1" id="cancelBtn" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form id="sectionForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="class_id" id="class_id" value="{{ $classId }}">
                    <input type="hidden" name="id" id="section_id" value=""> <!-- section id for edit -->

                    <div class="modal-body">
                        <div class="form-group">
                            <label for="section_name" class="form-label font-weight-bold">Section Name</label>
                            <input type="text" class="form-control shadow-sm" name="section_name" id="section_name"
                                placeholder="Enter Section Name">
                        </div>

                    </div>
                    <div class="modal-footer d-flex justify-content-between">
                        <button type="button" id="closeBtn" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fa fa-times"></i> Close
                        </button>
                        <button type="submit" id="saveBtn" class="btn btn-primary">
                            <i class="fa fa-save"></i> Submit
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    {{-- Modal Section End --}}
@endsection

@push('scripts')
    <script src="{{ asset('pos/assets/js/CustomJS/Master/sectionNameAjax.js') }}"></script>
@endpush
