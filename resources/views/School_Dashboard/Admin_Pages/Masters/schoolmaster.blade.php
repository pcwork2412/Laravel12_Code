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
                    <h3 class="mb-0 fw-bold text-primary"><i class="fa fa-list me-1"></i> School Details List</h3>

                </div>
                <!-- ✅ Right Button -->
                <div class="">
                    {{-- Add New School Button --}}
                    <button type="button" id="schoolCreateBtn" class="btn btn-success shadow-sm " data-bs-toggle="modal"
                        data-target="#schoolModal">
                        <i class="fa fa-plus-circle me-1"></i> Add New School
                    </button>
                </div>

            </div>
        </div>
    </div>

    {{-- Table Section Start --}}
    <div class="card shadow-sm">
        <div class="card-body bg-white">
            <div class="table-responsive" id="schoolList">
                <table id="schoolTable" class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <!-- Select All Checkbox -->
                            {{-- <th><input type="checkbox" id="selectAll"></th> --}}
                            <th>#</th>
                            <th>Logo</th>
                            <th>Principal Sign</th>
                            <th>School Name</th>
                            <th>Tagline</th>
                            <th>Address</th>
                            <th>Session</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
    {{-- Table Section End --}}

    {{-- Modal Section Start --}}
    <div class="modal fade" id="schoolModal" tabindex="-1" aria-labelledby="schoolModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content rounded shadow-sm">
                <div class="modal-header bg-primary text-white p-1">
                    <h3 class="school-modal-title font-weight-normal m-1 p-2" id="schoolModalLabel">Add School Details</h3>
                    <button type="button" class="btn-close btn-close-white fs-5 m-1" id="cancelBtn" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form id="schoolForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" id="school_id">
                    <div class="modal-body">
                        <div class="row g-1">
                            <div class="form-group col-md-6">
                                <label for="school_name" class="form-label font-weight-bold">School Name</label>
                                <input type="text" class="form-control shadow-sm " name="school_name" id="school_name"
                                    placeholder="Enter School Name">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="school_tagline" class="form-label font-weight-bold">School Tagline</label>
                                <input type="text" class="form-control shadow-sm " name="school_tagline"
                                    id="school_tagline" placeholder="Enter School Tagline">
                            </div>
                        </div>
                        <div class="row g-1">
                            <div class="form-group col-md-12">
                                <label for="school_session" class="form-label font-weight-bold">School Session</label>
                                <input type="text" class="form-control shadow-sm" name="school_session"
                                    id="school_session" placeholder="e.g. 2021-22">
                            </div>

                        </div>
                        <div class="row g-1">
                            <div class="form-group col-md-6">
                                <label for="school_logo" class="form-label font-weight-bold">School Logo</label>
                                <input type="file" class="form-control shadow-sm " name="school_logo" id="school_logo"
                                    placeholder="School Logo">
                                <div id="logoPreviewBox"
                                    style="display:none; width:100px; height:100px; overflow:hidden; border:1px solid #ccc; border-radius:8px;">
                                    <img id="logoPreviewImg" src="" alt="" class="img-thumbnail mt-2"
                                        style="width:100%; height:100%; object-fit:contain;">
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="school_principal_sign" class="form-label font-weight-bold">School Principal
                                    Sign(upload png img)</label>
                                <input type="file" class="form-control shadow-sm " name="school_principal_sign"
                                    id="school_principal_sign" placeholder="School Principal Sign">
                                <div id="signPreviewBox" style="display:none;">
                                    <img id="signPreviewImg" src="" alt="" style="width:80px; height:80px;"
                                        class="img-thumbnail">
                                </div>
                            </div>
                        </div>
                        <div class="row g-1">
                            <div class="form-group col-md-12">
                                <label for="school_address" class="form-label font-weight-bold">School Address</label>
                                <textarea name="school_address" id="school_address" class="form-control" cols="30" rows="3"
                                    placeholder="Enter Address Here......"></textarea>
                            </div>
                        </div>


                    </div>
                    <div class="modal-footer d-flex justify-content-between">
                        <button type="button" id="closeBtn" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fa fa-times"></i> Close
                        </button>
                        <button type="submit" id="schoolSaveBtn" class="btn btn-primary">
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
    <script src="{{ asset('pos/assets/js/CustomJS/Master/schoolNameAjax.js') }}"></script>
@endpush
