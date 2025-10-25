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
                    <h3 class="mb-0 fw-bold text-primary"><i class="fa fa-list"></i> Class List</h3>

                </div>
                <!-- ✅ Right Button -->
                <div class="">
                    {{-- Add New Class Button --}}
                    <button type="button" id="createBtn" class="btn btn-success shadow-sm" data-bs-toggle="modal"
                        data-target="#myModal">
                        <i class="fa fa-plus-circle"></i> Add New Class
                    </button>
                </div>

            </div>
        </div>
    </div>
    {{-- View All Sections Model --}}
    <!-- Modal -->
<!-- ✅ View All Sections Modal -->
<!-- ✅ View All Sections Modal -->
<div class="modal fade" id="sectionsShowModal" tabindex="-1" aria-labelledby="sectionsShowModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content border-0 shadow-lg rounded-3">
      <div class="modal-header bg-primary text-white">
        <h3 class="modal-title fw-bold" id="sectionsShowModalLabel">
          <i class="fa fa-layer-group me-2"></i> Class: <span id="classNameText"></span>
        </h3>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body bg-light">
        <!-- Summary Info -->
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h4 class="mb-0 text-secondary">
            <i class="fa fa-list me-2"></i> Total Sections: 
            <span id="totalSectionsText" class="fw-bold text-dark">0</span>
          </h4>
          <h4 class="mb-0 text-secondary">
            <i class="fa fa-users me-2"></i> Total Students: 
            <span id="totalStudentsText" class="fw-bold text-dark">0</span>
          </h4>
        </div>

        <!-- Sections Table -->
        <div class="table-responsive">
          <table class="table table-bordered border-2 table-hover align-middle mb-0">
            <thead class="table-primary">
              <tr>
                <th style="width: 60px;">#</th>
                <th>Section Name</th>
                <th>Total Students in Section</th>
              </tr>
            </thead>
            <tbody id="sectionListBody">
              <tr>
                <td colspan="3" class="text-center text-muted py-3">
                  <!-- Section details will be loaded here dynamically -->
                </td>
              </tr>
            </tbody>
          </table>
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


    {{-- Table Section Start --}}
    <div class="card shadow-sm">
        <div class="card-body bg-white">

            <div class="table-responsive" id="classList">
                <table id="classTable" class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <!-- Select All Checkbox -->
                            {{-- <th><input type="checkbox" id="selectAll"></th> --}}
                            <th>#</th>
                            <th>Class Name</th>
                            <th>No. of Sections</th>
                            <th>Total Students Count<br><span style="font-size: 14px; font-weight:normal;">(View Section-Wise Count)</span></th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($stdClasses as $cl)
                            <tr id="studentRow_{{ $cl->id }}">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $cl->class_name }}</td>
                                <td>{{ $cl->sections->count() }}</td>
                                <td>
                                    {{-- {{ $cl->sections->sum(function($section) { return $section->students->count(); }) }} --}}
                                    <button class="btn btn-outline-info showAllSectionsBtn" title="View All Sections" data-id="{{ $cl->id }}">
                                        <i class="fa fa-eye"></i> View All Sections
                                    </button>
                                </td>
                                <td>
                                    <a href="{{ route('section_name.index', ['class_id' => $cl->id]) }}"
                                        class="btn btn-info btn-sm addSectionBtn" title="Add More Section">
                                        <i class="fa fa-plus-circle"></i>
                                    </a>

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
                    <h3 class="modal-title font-weight-normal m-1 ps-2" id="classModalLabel">Add Classes</h3>
                    <button type="button" class="btn-close btn-close-white fs-5 m-1" id="cancelBtn" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <form id="classForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" id="cl_id">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="class_name" class="form-label font-weight-bold">Class Name</label>
                            <input type="text" class="form-control shadow-sm" name="class_name" id="cl_name"
                                placeholder="Enter Class Name">
                        </div>
                        {{-- <div class="form-group" id="sections">
            <label for="sectionsInput" class="form-label font-weight-bold">Section Name (Select Single or Multiple)</label>
            <select class="form-control" name="sections[]" id="sectionsInput" multiple="multiple">
                <option value="A" class="m-1">A</option>
                <option value="B" class="m-1">B</option>
                <option value="C" class="m-1">C</option>
                <option value="D" class="m-1">D</option>
                <option value="E" class="m-1">E</option>
            </select>
        </div> --}}
                    </div>
                    <div class="modal-footer d-flex justify-content-between">
                        <button type="button" id="closeBtn" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fa fa-times"></i> Close
                        </button>
                        <button type="submit" id="saveBtn" class="btn btn-primary">
                            <i class="fa fa-save"></i> Add Class
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
