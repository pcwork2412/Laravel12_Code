@extends('School_Dashboard.Admin_Layouts.app')

@section('content')
    <div class="container">

        <!-- Teacher Form Modal -->
        <div class="modal fade" id="addTeacherModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
            aria-labelledby="teacherModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <form id="teacherForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" id="teacher_id">

                    <div class="modal-content shadow-sm rounded-3 border-0"
                        style="background: linear-gradient(145deg, #ffffff, #f8f9fa);">

                        <div class="modal-header bg-primary text-white border-0 rounded-top-3">
                            <h3 class="modal-title" id="teacherModalLabel">
                                <i class="bi bi-person-plus-fill me-2"></i>Add New Teacher
                            </h3>
                            <button type="button" class="btn-close btn-close-white" id="closeBtn" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>

                        <div class="modal-body p-4">
                            <!-- Personal Information -->
                            <h3 class="text-danger mb-2 fw-bold">Personal Information</h3>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="teacher_name" class="form-label fw-semibold">Teacher Name</label>
                                    <input type="text" id="teacher_name" name="teacher_name"
                                        class="form-control rounded-3" placeholder="Enter Name" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="dob" class="form-label fw-semibold">Date of Birth</label>
                                    <input type="date" id="dob" name="dob" class="form-control rounded-3">
                                </div>
                                <div class="col-md-6">
                                    <label for="gender" class="form-label fw-semibold">Gender</label>
                                    <select name="gender" id="gender" class="form-select rounded-3" required>
                                        <option value="" disabled selected>Select Gender</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Profile Image:</label>
                                    <input type="file" class="form-control" name="image" id="image">
                                    <div id="previewBox"
                                        style="display:none; width:100px; height:100px; overflow:hidden; border:1px solid #ccc; border-radius:8px;">
                                        <img id="previewImage" class="img-thumbnail mt-2" alt="Preview"
                                            style="width:100%; height:100%; object-fit:contain;">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label fw-semibold">Email</label>
                                    <input type="email" id="email" name="email" class="form-control rounded-3"
                                        placeholder="Enter Email" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="mobile" class="form-label fw-semibold">Mobile</label>
                                    <input type="number" id="mobile" name="mobile" class="form-control rounded-3"
                                        placeholder="Enter Mobile" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="qualification" class="form-label fw-semibold">Qualification</label>
                                    <input type="text" id="qualification" name="qualification"
                                        class="form-control rounded-3" placeholder="Enter Qualification" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="experience" class="form-label fw-semibold">Experience (Years)</label>
                                    <input type="number" id="experience" name="experience" class="form-control rounded-3"
                                        placeholder="Enter Experience">
                                </div>
                                <div class="col-md-12">
                                    <label for="documents" class="form-label fw-semibold">Upload Documents (zip)</label>
                                    <input type="file" id="documents" name="documents" accept=".zip"
                                        class="form-control rounded-3">
                                </div>
                                <div class="col-md-12">
                                    <label for="address" class="form-label fw-semibold">Address</label>
                                    <textarea name="address" id="address" class="form-control rounded-3" rows="3" placeholder="Enter Address"></textarea>
                                </div>
                                <div class="col-md-6">
                                    <label for="city" class="form-label fw-semibold">City</label>
                                    <input type="text" id="city" name="city" class="form-control rounded-3"
                                        placeholder="Enter City">
                                </div>
                                <div class="col-md-6">
                                    <label for="state" class="form-label fw-semibold">State</label>
                                    <input type="text" id="state" name="state" class="form-control rounded-3"
                                        placeholder="Enter State">
                                </div>
                                <div class="col-md-6">
                                    <label for="pincode" class="form-label fw-semibold">Pincode</label>
                                    <input type="text" id="pincode" name="pincode" class="form-control rounded-3"
                                        placeholder="Enter Pincode">
                                </div>

                            </div>

                            <!-- Hidden status field -->
                            <input type="hidden" name="status" value="pending">

                            <div class="mt-3 mb-5 border"></div>
                            <div class="mt-3">
                                <button type="button" class="btn btn-danger rounded-3 px-3 float-end"
                                    data-bs-dismiss="modal">
                                    <i class="bi bi-x-circle me-2"></i> Cancel
                                </button>
                                <button type="submit" id="saveBtn" class="btn btn-success rounded-3 px-4 float-start">
                                    <i class="bi bi-person-plus-fill me-2"></i> Register Teacher
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- End Teacher Form Modal -->

        <!-- Start Teacher Import Modal -->
        <div class="modal fade" id="importTeachersModal" tabindex="-1" aria-labelledby="importTeachersModalLabel"
            aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg ">

                    <!-- 🔸 Modal Header -->
                    <div class="modal-header bg-primary text-white ">
                        <h3 class="modal-title fw-bold" id="importTeachersModalLabel">
                            <i class="bi bi-file-earmark-arrow-up me-2"></i> Import Teachers Data
                        </h3>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>

                    <!-- 🔸 Modal Body -->
                    <div class="modal-body">
                        <form action="{{ route('teachers.import.data') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <!-- File Input -->
                            <div class="mb-3">
                                <label for="fileInput" class="form-label fw-bold">Choose Excel / CSV file</label>
                                <div class="input-group">
                                    <input type="file" name="file" class="form-control" id="fileInput"
                                        accept=".xlsx,.xls,.csv" required>
                                    <label class="input-group-text" for="fileInput"><i class="bi bi-upload"></i></label>
                                </div>
                                @error('file')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                                <div class="form-text mt-2">
                                    Accepted file types: <strong>.xlsx, .xls, .csv</strong>
                                </div>
                            </div>

                            <!-- Buttons -->
                            <div class="d-flex justify-content-between align-items-center mt-4">
                                <a href="{{ asset('pos/import/teacher_import_template.xlsx') }}"
                                    class="btn btn-outline-success btn-sm rounded-pill px-4 shadow-sm">
                                    <i class="bi bi-file-earmark-excel me-2"></i>
                                    Download Excel Template
                                </a>
                                <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">
                                    <i class="bi bi-box-arrow-in-down me-2"></i> Import Data
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
        <!-- End Teacher Import Modal -->

        {{-- Teacher Table Section --}}
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0 fw-bold text-primary">
                            <i class="fa-solid fa-users me-2"></i>Teachers List
                        </h4>
                        <!-- 🔹 Button to trigger modal -->
                        {{-- <button type="button" id="addStudentBtn" class="btn btn-success shadow-sm"
                            data-bs-toggle="modal" data-bs-target="#addStudentModal">
                            <i class="bi bi-person-plus-fill me-2"></i> Add New Student
                        </button> --}}
                        <a href="{{ route('teachers.create') }}" class="btn btn-primary shadow-sm">
                            <i class="bi bi-person-plus-fill me-2"></i> Add New Teacher
                        </a>

                    </div>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        {{-- Select option --}}
                        <button id="deleteSelected" class="btn btn-danger">
                            <i class="bi bi-trash-fill me-1"></i> Delete Selected
                        </button>
                        {{-- Action buttons --}}
                        <div>
                            <a href="{{ route('teachers.download.pdf') }}" id="printBtn" class="btn btn-secondary">
                                <i class="bi bi-file-earmark-pdf-fill me-1"></i> PDF
                            </a>
                             {{-- <a href="{{ route('teachers.trashed') }}"  class="btn btn-secondary">
                                <i class="bi bi-file-earmark-pdf-fill me-1"></i> trash
                            </a> --}}
                            <button id="printTeacher" class="btn btn-warning">
                                <i class="bi bi-printer-fill me-1"></i> Print
                            </button>

                            <div id="printableTeacherArea" style="display:none;">
                                <table id="printTeacherContent" border="1" cellpadding="5" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Image</th>
                                            <th>Teacher Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Class Assigned</th>
                                            <th>Subjects</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>


                            <button id="filterBtn" class="btn btn-info" data-bs-toggle="modal"
                                data-bs-target="#importTeachersModal">
                                <i class="bi bi-upload me-1"></i> Import
                            </button>
                            <a href="{{ route('teachers.export') }}" id="exportBtn" class="btn btn-success">
                                <i class="bi bi-file-earmark-excel-fill me-1"></i> Export
                            </a>
                        </div>
                    </div>
                    <div class="card-body">

                        <div class="table-responsive" id="teacherList">

                            <table id="teacherTable" class="table table-bordered table-striped"
                                data-url="{{ route('teachers.index') }}">
                                <thead class="table-dark">
                                    <tr>
                                        <th>
                                            <input type="checkbox" id="select_all">
                                        </th>

                                        <th>Image</th>
                                        <th>Name</th>
                                        {{-- <th>Role</th> --}}
                                        {{-- <th>Status</th> --}}
                                        {{-- <th>DOB</th>
                                        <th>Gender</th>
                                        <th>Email</th> --}}
                                        <th>Mobile</th>
                                        <th>Qualification</th>
                                        <th>Experience</th>
                                        <th>Documents</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                            </table>


                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Teacher Table Section End --}}
    @endsection
    @push('styles')
        <style>
            #printTeacherContent {
                border: #ccc 1px solid;
                border-collapse: collapse;
            }

            #printTeacherContent th,
            #printTeacherContent td {
                border: #ccc 1px solid;
                padding: 8px;
                text-align: left;
            }

            #printTeacherContent tr:nth-child(even) {
                background-color: #f2f2f2;

            }
        </style>
    @endpush
    @push('scripts')
        <script src="{{ asset('pos/assets/js/CustomJS/Teachers/teacherajax.js') }}"></script>
    @endpush
