@extends('layouts.app')
@section('content')
  

{{-- Delete Selected Button --}}
{{-- <button type="button" id="deleteSelectedBtn" class="btn btn-danger shadow mb-3 ms-2"
    data-url="{{ route('master-class.deleteMultiple') }}">
    <i class="fa fa-trash"></i> Delete Selected
</button> --}}

{{-- Table Section Start --}}
<div class="card shadow-sm">
    <div class="card-body bg-white">
          {{-- Add New Class Button --}}
<button type="button" id="createBtn" class="btn btn-success shadow-sm mb-3" data-bs-toggle="modal" data-target="#myModal">
    <i class="fa fa-plus-circle"></i> Add New Class
</button>
        <div class="table-responsive" id="classList">
            <table id="classTable" class="table table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <!-- Select All Checkbox -->
                        {{-- <th><input type="checkbox" id="selectAll"></th> --}}
                        <th>#</th>
                        <th>Class Name</th>
                        <th>Sections Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($stdClasses as $cl)
                        <tr id="studentRow_{{ $cl->id }}">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $cl->class_name }}</td>
                            <td>@foreach ($cl->sections as $sec)
                                {{$sec->section_name.','}}
                            @endforeach</td>
                            <td>
                                <button class="btn btn-warning btn-sm editClassBtn" data-id="{{ $cl->id }}">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button class="btn btn-danger btn-sm deleteBtn" data-id="{{ $cl->id }}">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
{{-- Table Section End --}}

{{-- Modal Section Start --}}
<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="classModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded shadow-sm">
            <div class="modal-header bg-primary text-white p-1">
                <h2 class="modal-title font-weight-normal m-1 ps-2" id="classModalLabel">Add Class</h2>
                <button type="button" class="btn-close btn-close-white fs-5 m-1" id="cancelBtn" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            {{-- <form id="classForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" id="cl_id">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="class_name" class="form-label font-weight-bold">Class Name</label>
                        <input type="text" class="form-control shadow-sm " name="class_name" id="cl_name"
                            placeholder="Enter Class Name">
                    </div>
                    <div class="form-group" id="sections">
                        <label for="sectionsInput" class="form-label font-weight-bold">Section Name(Select Singal or Multiple)</label>
                        <select class="form-control" name="sections[]" id="sectionsInput" multiple="multiple">
                            <option value="A" class="m-1">A</option>
                            <option value="B" class="m-1">B</option>
                            <option value="C" class="m-1">C</option>    
                        </select>
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
            </form> --}}
            <form id="classForm" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="id" id="cl_id">
    <div class="modal-body">
        <div class="form-group">
            <label for="class_name" class="form-label font-weight-bold">Class Name</label>
            <input type="text" class="form-control shadow-sm" name="class_name" id="cl_name"
                placeholder="Enter Class Name">
        </div>
        <div class="form-group" id="sections">
            <label for="sectionsInput" class="form-label font-weight-bold">Section Name (Select Single or Multiple)</label>
            <select class="form-control" name="sections[]" id="sectionsInput" multiple="multiple">
                <option value="A" class="m-1">A</option>
                <option value="B" class="m-1">B</option>
                <option value="C" class="m-1">C</option>
            </select>
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
    <script src="{{ asset('pos/assets/js/CustomJS/Master/classNameAjax.js') }}"></script>
@endpush
