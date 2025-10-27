@extends('School_Dashboard.Admin_Layouts.app')

@section('content')
    <div class="container">

        <!-- Student Form Modal -->
        <div class="modal fade" id="addStudentModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
            aria-labelledby="studentModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">

                <form id="studentForm" enctype="multipart/form-data">
                    @csrf
                    <!-- Hidden id field (inside form) -->
                    <input type="hidden" name="id" id="student_id">
                    <div class="modal-content shadow-sm rounded-3 border-0"
                        style="background: linear-gradient(145deg, #ffffff, #f8f9fa);">
                        <div class="modal-header bg-primary text-white border-0 rounded-top-3">
                            <h3 class="modal-title" id="studentModalLabel">
                                <i class="bi bi-person-plus-fill me-2"></i>Add New Student
                            </h3>
                            <button type="button" class="btn-close btn-close-white" id="closeBtn" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body p-4">
                            <!-- Student Information Section -->
                            <h3 class=" text-danger mb-2 fw-bold">Student Information</h3>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="">
                                        <label for="promoted_class_name" class="form-label fw-semibold">Promoted Class
                                            Name</label>
                                        <select id="promoted_class_name" name="promoted_class_name"
                                            class="classSelect form-select rounded-3" required>
                                            <option value="">Select Class</option>
                                            @foreach ($classes as $class)
                                                <option value="{{ $class->id }}">{{ $class->class_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="">
                                        <label for="student_name" class="form-label fw-semibold">Student
                                            Name</label>
                                        <input type="text" id="student_name" value="{{ old('student_name') }}"
                                            name="student_name" class="form-control rounded-3" placeholder="Enter Name ">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="">
                                        <label>Section:</label>
                                        <select id="" name="section_name"
                                            class="sectionSelect section_name form-select" required>
                                            <option value="">Select Section</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="">
                                        <label for="dob" class="form-label fw-semibold">Date of
                                            Birth </label>
                                        <input type="date" id="dob" value="{{ old('dob') }}" name="dob"
                                            class="form-control rounded-3">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-1">
                                        <label for="gender" class="form-label fw-semibold">Gender</label>
                                        <select name="gender" id="gender" class="form-select rounded-3">
                                            <option value="" disabled selected>Select Gender</option>
                                            <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>
                                                Male
                                            </option>
                                            <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female
                                            </option>
                                            <option value="Other" {{ old('gender') == 'Other' ? 'selected' : '' }}>
                                                Other
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Image:</label>
                                    <input type="file" class="form-control" name="image" id="image">
                                    <!-- Preview Selected Image -->
                                    <!-- Image preview (ids must match JS) -->
                                    <div id="previewBox"
                                        style="display:none; width:100px; height:100px; overflow:hidden; border:1px solid #ccc; border-radius:8px;">
                                        <img id="previewImage" class="img-thumbnail mt-2" alt="Preview"
                                            style="width:100%; height:100%; object-fit:contain;">
                                    </div>

                                    <span class="text-danger" id="imageError"></span>
                                </div>
                            </div>

                            <!-- Parent/Guardian Details Section -->
                            <h3 class=" text-danger mb-2 fw-bold">Parent/Guardian Details</h3>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="">
                                        <label for="mother_name" class="form-label fw-semibold">Mother's
                                            Name </label>
                                        <input type="text" id="mother_name" value="{{ old('mother_name') }}"
                                            name="mother_name" class="form-control rounded-3"
                                            placeholder="Enter Mother's Name">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="">
                                        <label for="father_name" class="form-label fw-semibold">Father's
                                            Name </label>
                                        <input type="text" id="father_name" value="{{ old('father_name') }}"
                                            name="father_name" class="form-control rounded-3"
                                            placeholder="Enter Father's Name">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="">
                                        <label for="guardian_name" class="form-label fw-semibold">Guardian's
                                            Name</label>
                                        <input type="text" id="guardian_name" value="{{ old('guardian_name') }}"
                                            name="guardian_name" class="form-control rounded-3"
                                            placeholder="Enter Guardian's Name">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="">
                                        <label for="father_occupation_income" class="form-label fw-semibold">Father's
                                            Occupation & Annual
                                            Income</label>
                                        <input type="text" id="father_occupation_income"
                                            value="{{ old('father_occupation_income') }}" name="father_occupation_income"
                                            class="form-control rounded-3"
                                            placeholder="Enter Father's Occupation & Annual Income">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="mother_mobile" class="form-label fw-semibold">Mother's
                                            Mobile No.</label>
                                        <input type="text" id="mother_mobile" value="{{ old('mother_mobile') }}"
                                            name="mother_mobile" class="form-control rounded-3"
                                            placeholder="Enter Mother's Mobile No.">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="">
                                        <label for="father_mobile" class="form-label fw-semibold">Father's
                                            Mobile No.</label>
                                        <input type="text" id="father_mobile" value="{{ old('father_mobile') }}"
                                            name="father_mobile" class="form-control rounded-3"
                                            placeholder="Enter Father's Mobile No.">
                                    </div>
                                </div>
                            </div>

                            <!-- Address Details Section -->
                            <h3 class=" text-danger mb-2 fw-bold">Address Details</h3>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="">
                                        <label for="present_address" class="form-label fw-semibold">Present
                                            Address (with PIN
                                            code)</label>
                                        <input type="text" id="present_address" value="{{ old('present_address') }}"
                                            name="present_address" class="form-control rounded-3"
                                            placeholder="Enter Present Address with PIN code">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="">
                                        <label for="permanent_address" class="form-label fw-semibold">Permanent
                                            Address (with
                                            PIN
                                            code)</label>
                                        <input type="text" id="permanent_address"
                                            value="{{ old('permanent_address') }}" name="permanent_address"
                                            class="form-control rounded-3"
                                            placeholder="Enter Permanent Address with PIN code">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="">
                                        <label for="local_guardian" class="form-label fw-semibold">Local
                                            Guardian Name & Address</label>
                                        <input type="text" id="local_guardian" value="{{ old('local_guardian') }}"
                                            name="local_guardian" class="form-control rounded-3"
                                            placeholder="Enter Local Guardian Name & Address">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="state_belong" class="form-label fw-semibold">State You
                                            Belong To</label>
                                        <input type="text" id="state_belong" value="{{ old('state_belong') }}"
                                            name="state_belong" class="form-control rounded-3"
                                            placeholder="Enter State You Belong To">
                                    </div>
                                </div>
                            </div>

                            <!-- Contact Details Section -->
                            <h3 class=" text-danger mb-2 fw-bold">Contact Details</h3>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="">
                                        <label for="whatsapp_mobile" class="form-label fw-semibold">WhatsApp
                                            Mobile
                                            No.</label>
                                        <input type="text" id="whatsapp_mobile" value="{{ old('whatsapp_mobile') }}"
                                            name="whatsapp_mobile" class="form-control rounded-3"
                                            placeholder="Enter WhatsApp Mobile No.">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="">
                                        <label for="alternate_mobile" class="form-label fw-semibold">Alternate
                                            Mobile
                                            No.</label>
                                        <input type="text" id="alternate_mobile"
                                            value="{{ old('alternate_mobile') }}" name="alternate_mobile"
                                            class="form-control rounded-3" placeholder="Enter Alternate Mobile No.">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="email_id" class="form-label fw-semibold">Email
                                            Id</label>
                                        <input type="email" id="email_id" value="{{ old('email_id') }}"
                                            name="email_id" class="form-control rounded-3" placeholder="Enter Email Id">
                                    </div>
                                </div>
                            </div>

                            <!-- Identity Details Section -->
                            <h3 class=" text-danger mb-2 fw-bold">Identity Details</h3>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="">
                                        <label for="aadhaar_number" class="form-label fw-semibold">Aadhaar
                                            Number</label>
                                        <input type="text" id="aadhaar_number" value="{{ old('aadhaar_number') }}"
                                            name="aadhaar_number" class="form-control rounded-3"
                                            placeholder="Enter Aadhaar Number">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="">
                                        <label for="ration_card_type" class="form-label fw-semibold">Ration Card
                                            Type</label>
                                        <select name="ration_card_type"
                                            id="ration_card_type"class="form-select rounded-3">
                                            <option value="" disabled selected>Select Ration Card
                                                Type</option>
                                            <option value="APL"
                                                {{ old('ration_card_type') == 'APL' ? 'selected' : '' }}>
                                                APL</option>
                                            <option value="BPL"
                                                {{ old('ration_card_type') == 'BPL' ? 'selected' : '' }}>
                                                BPL</option>
                                            <option value="Antyodaya"
                                                {{ old('ration_card_type') == 'Antyodaya' ? 'selected' : '' }}>
                                                Antyodaya</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="physically_handicapped" class="form-label fw-semibold">Physically
                                            Handicapped
                                            (Yes/No)</label>
                                        <select name="physically_handicapped" id="physically_handicapped"
                                            class="form-select rounded-3">
                                            <option value="" disabled selected>Select Disability
                                                Status</option>
                                            <option value="Yes"
                                                {{ old('physically_handicapped') == 'Yes' ? 'selected' : '' }}>
                                                Yes</option>
                                            <option value="No"
                                                {{ old('physically_handicapped') == 'No' ? 'selected' : '' }}>
                                                No</option>
                                        </select>
                                    </div>
                                </div>
                            </div>


                            <!-- Health Info Section -->
                            <h3 class=" text-danger mb-2 fw-bold">Health Info</h3>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="">
                                        <label for="blood_group" class="form-label fw-semibold">Blood
                                            Group</label>
                                        <select name="blood_group" id="blood_group" class="form-select rounded-3">
                                            <option id="student_id" value="" disabled selected>Select
                                                Blood Group
                                            </option>
                                            <option value="A+" {{ old('blood_group') == 'A+' ? 'selected' : '' }}>A+
                                            </option>
                                            <option value="A-" {{ old('blood_group') == 'A-' ? 'selected' : '' }}>A-
                                            </option>
                                            <option value="B+" {{ old('blood_group') == 'B+' ? 'selected' : '' }}>B+
                                            </option>
                                            <option value="B-" {{ old('blood_group') == 'B-' ? 'selected' : '' }}>B-
                                            </option>
                                            <option value="AB+" {{ old('blood_group') == 'AB+' ? 'selected' : '' }}>AB+
                                            </option>
                                            <option value="AB-" {{ old('blood_group') == 'AB-' ? 'selected' : '' }}>AB-
                                            </option>
                                            <option value="O+" {{ old('blood_group') == 'O+' ? 'selected' : '' }}>O+
                                            </option>
                                            <option value="O-" {{ old('blood_group') == 'O-' ? 'selected' : '' }}>O-
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="">
                                        <label for="height" class="form-label fw-semibold">Height</label>
                                        <input type="text" id="height" value="{{ old('height') }}" name="height"
                                            class="form-control rounded-3" placeholder="Enter Height">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="weight" class="form-label fw-semibold">Weight</label>
                                        <input type="text" id="weight" value="{{ old('weight') }}" name="weight"
                                            class="form-control rounded-3" placeholder="Enter Weight">
                                    </div>
                                </div>
                            </div>

                            <!-- Bank Account Details Section -->
                            <h3 class=" text-danger mb-2 fw-bold">Bank Account Details</h3>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="">
                                        <label for="account_holder_name" class="form-label fw-semibold">Account
                                            Holder
                                            Name</label>
                                        <input type="text" id="account_holder_name"
                                            value="{{ old('account_holder_name') }}" name="account_holder_name"
                                            class="form-control rounded-3" placeholder="Enter Account Holder Name">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="">
                                        <label for="bank_name_branch" class="form-label fw-semibold">Bank
                                            Name & Branch</label>
                                        <input type="text" id="bank_name_branch"
                                            value="{{ old('bank_name_branch') }}" name="bank_name_branch"
                                            class="form-control rounded-3" placeholder="Enter Bank Name & Branch">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="">
                                        <label for="account_number" class="form-label fw-semibold">Account
                                            Number</label>
                                        <input type="text" id="account_number" value="{{ old('account_number') }}"
                                            name="account_number" class="form-control rounded-3"
                                            placeholder="Enter Account Number">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="">
                                        <label for="ifsc_code" class="form-label fw-semibold">IFSC
                                            Code</label>
                                        <input type="text" id="ifsc_code" value="{{ old('ifsc_code') }}"
                                            name="ifsc_code" class="form-control rounded-3"
                                            placeholder="Enter IFSC Code">
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3 mb-5 border"></div>
                            <div class="mt-3">
                                <button type="button" class="btn btn-danger rounded-3 px-3 float-end" id="cancelBtn"
                                    data-bs-dismiss="modal" aria-label="Close">
                                    <i class="bi bi-x-circle me-2"></i> Cancel
                                </button>
                                <button type="submit" id="saveBtn" class="btn btn-success rounded-3 px-4 float-start">
                                    <i class="bi bi-person-plus-fill me-2"></i> Register Student
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        {{-- End Student Form Modal --}}

        {{-- Start Student Import Modal --}}
        <div class="modal fade" id="importStudentsModal" tabindex="-1" aria-labelledby="importStudentsModalLabel"
            aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg rounded-1">

                    <!-- 🔸 Modal Header -->
                    <div class="modal-header bg-primary text-white">
                        <h3 class="modal-title fw-bold" id="importStudentsModalLabel">
                            <i class="bi bi-file-earmark-arrow-up me-2"></i> Import Students Data
                        </h3>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>

                    <!-- 🔸 Modal Body -->
                    <div class="modal-body">
                        <form action="{{ route('students.import.data') }}" method="POST" enctype="multipart/form-data">
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
                                <a href="{{ asset('pos/import/student_excel_template(admin).xlsx') }}"
                                    class="btn btn-outline-success btn-sm rounded-pill px-4 shadow-sm">
                                    <i class="bi bi-file-earmark-excel me-2"></i> Download Excel Template
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
        {{-- End Student Import Modal --}}



        {{-- Table Section --}}
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0 fw-bold text-primary">
                            <i class="fa-solid fa-users me-2"></i>Students List
                        </h4>
                        <!-- 🔹 Button to trigger modal -->
                        {{-- <button type="button" id="addStudentBtn" class="btn btn-success shadow-sm"
                            data-bs-toggle="modal" data-bs-target="#addStudentModal">
                            <i class="bi bi-person-plus-fill me-2"></i> Add New Student
                        </button> --}}
                        <a href="{{ route('students.create') }}" class="btn btn-primary shadow-sm">
                            <i class="bi bi-person-plus-fill me-2"></i> Add New Student
                        </a>

                    </div>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm border-0 mb-4" style="">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        {{-- Select option --}}
                        <div>
                            <label for="class_id" class="form-label me-2 fw-semibold">Select Class Name</label>
                            <select id="classFilter" name="class_id" class="form-select d-inline-block ">
                                <option value="All">All</option>
                                @foreach ($classes as $class)
                                    <option value="{{ $class->id }}">{{ $class->class_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        {{-- Action buttons --}}
                        <div>
                            <button id="deleteSelected" class="btn btn-danger">
                                <i class="bi bi-trash-fill me-1"></i> Delete Selected 
                            </button>
                            {{-- <a href="{{ route('students.trashed') }}"  class="btn btn-secondary">
                                <i class="bi bi-file-earmark-pdf-fill me-1"></i> trash
                            </a> --}}
                            <a href="{{ route('students.download.pdf') }}" id="printBtn" class="btn btn-secondary">
                                <i class="bi bi-file-earmark-pdf-fill me-1"></i> PDF
                            </a>
                            <button id="printTable" class="btn btn-warning">
                                <i class="bi bi-printer-fill me-1"></i> Print
                            </button>

                            <div id="printableArea" style="display:none;">
                                <table id="printTableContent" border="1" cellpadding="5" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Student UID</th>
                                            <th>Image</th>
                                            <th>Name</th>
                                            <th>Class</th>
                                            <th>Section</th>
                                            <th>Father Name</th>
                                            <th>Mobile</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>


                            <button id="filterBtn" class="btn btn-info" data-bs-toggle="modal"
                                data-bs-target="#importStudentsModal">
                                <i class="bi bi-upload me-1"></i> Import
                            </button>
                            <a href="{{ route('students.export') }}" id="exportBtn" class="btn btn-success">
                                <i class="bi bi-file-earmark-excel-fill me-1"></i> Export
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive" id="studentList">
                            <table id="studentTable" data-url="{{ route('students.index') }}"
                                class="table table-hover align-middle table-bordered rounded-3 overflow-hidden">
                                <thead class="table-dark text-center align-middle">
                                    <tr>
                                        <th>
                                            <input type="checkbox" id="select_all">
                                        </th>
                                        <th>Image</th>
                                        <th>Student Name</th>
                                        <th>Class</th>
                                        <th>Section</th>
                                        {{-- <th>Gender</th> --}}
                                        <th>Father Name</th>
                                        <th>Mobile</th>
                                        <th>Actions</th>
                                    </tr>

                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Table Section End --}}
       
    @endsection
    @push('styles')
         <style>
          #printTableContent {
              border: #ccc 1px solid;
              border-collapse: collapse;
            }
            #printTableContent th, #printTableContent td {
              border: #ccc 1px solid;
              padding: 8px;
              text-align: left;
          }
          #printTableContent tr:nth-child(even) {
              background-color: #f2f2f2;
              
          }
        </style>
    @endpush
    @push('scripts')
    
        <script src="{{ asset('pos/assets/js/CustomJS/Global/global.js') }}"></script>
        <script src="{{ asset('pos/assets/js/CustomJS/Students/studentajax.js') }}"></script>
    @endpush
