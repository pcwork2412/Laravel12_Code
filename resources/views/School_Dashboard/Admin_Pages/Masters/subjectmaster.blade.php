@extends('School_Dashboard.Admin_Layouts.app')
@section('content')
  
<div class="container">
      <div class="card shadow-sm mb-3">
        <div class="card-body bg-white">
            {{-- Add New Section Button --}}
            <div class="d-flex justify-content-between align-items-center">

                <!-- ✅ Left Button -->
                <div class="">
                    <h3 class="mb-0 fw-bold text-primary"><i class="fa fa-list me-1"></i> Subjects List</h3>

                </div>
                <!-- ✅ Right Button -->
                <div class="">
                    {{-- Add New Subject Button --}}
                    <button type="button" id="subjectCreateBtn" class="btn btn-success shadow-sm " data-bs-toggle="modal"
                        data-target="#subjectModal">
                        <i class="fa fa-plus-circle me-1"></i> Add New Subject
                    </button>
                </div>

            </div>
        </div>
    </div>

    {{-- Table Section Start --}}
    <div class="card shadow-sm">
        <div class="card-body bg-white">

            <div class="table-responsive" id="subjectList">
                <table id="subjectTable" class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Subject Name</th>
                            <th>Class</th>
                            <th>Max Marks</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
    {{-- Table Section End --}}

</div>
    {{-- Modal Section Start --}}
    <div class="modal fade" id="subjectModal" tabindex="-1" aria-labelledby="subjectModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content rounded shadow-sm">
                <div class="modal-header bg-primary text-white p-1">
                    <h3 class="subject-modal-title font-weight-normal m-1 p-2" id="subjectModalLabel">Add Subject Name</h3>
                    <button type="button" class="btn-close btn-close-white fs-5 m-1" id="cancelBtn" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form id="subjectForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" id="subject_id">
                    <div class="modal-body">
                        <div class="row g-1">
                            <div class="form-group col-md-6">
                                <label for="class_id" class="form-label font-weight-bold">Class Name</label>
                                <select id="class_id" name="class_id" class="form-select" required>
                                    <option value="" disabled selected>Select Class</option>
                                    @foreach ($classes as $cl)
                                        <option value="{{ $cl->id }}">{{ $cl->class_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="max_marks" class="form-label font-weight-bold">Subject Max Marks</label>
                                <input type="number" class="form-control shadow-sm " name="max_marks" value="100"
                                    id="max_marks" placeholder="Enter Subject Max Marks">
                            </div>
                        </div>
                        <div class="row g-1">
                            <div class="form-group col-md-12">
                                <label for="subject_name" class="form-label font-weight-bold">Subject Name</label>
                                <input type="text" class="form-control shadow-sm " name="subject_name" id="subject_name"
                                    placeholder="Enter Subject Name">
                            </div>
                        </div>



                    </div>
                    <div class="modal-footer d-flex justify-content-between">
                        <button type="button" id="closeBtn" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fa fa-times"></i> Close
                        </button>
                        <button type="submit" id="subjectSaveBtn" class="btn btn-primary">
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
    <script src="{{ asset('pos/assets/js/CustomJS/Master/subjectNameAjax.js') }}"></script>
@endpush
