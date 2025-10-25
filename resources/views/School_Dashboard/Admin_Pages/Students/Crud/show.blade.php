@extends('School_Dashboard.Admin_Layouts.app')
@section('content')
    <!-- Page Wrapper -->


    <!-- Page Content -->
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-4">
            <h3 class="text-primary mb-0">🎓 Student Profile</h3>
            <a href="{{ route('students.index') }}" class="btn btn-outline-danger">
                <i class="bi bi-arrow-left me-1"></i> Back
            </a>
        </div>

        <!-- Profile Card -->
        <div class="card  rounded-4 border-0">
            <div class="card-body p-4">
                <div class="row align-items-center">
                    <!-- Profile Image -->
                    <div class="col-md-3 text-center mb-3 mb-md-0">
                        @if (isset($student) && $student->image)
                            <img src="{{ asset('storage/' . $student->image) }}" class="rounded-circle border shadow-sm"
                                style="width: 120px; height: 120px; object-fit: cover;">
                        @else
                            <div class="rounded-circle bg-light d-flex align-items-center justify-content-center border shadow-sm"
                                style="width: 120px; height: 120px;">
                                <span class="text-muted small">No Image</span>
                            </div>
                        @endif
                        <h3 class="mt-3 text-danger border-1 border-danger border-bottom">{{ $student->student_name }}</h3>
                        <span class="badge bg-info text-white fw-normal p-2">ID: {{ $student->student_uid }}</span>
                    </div>

                    <!-- Profile Info -->
                    <div class="col-md-5">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item px-0 py-2"><strong>Class Name:</strong>
                                {{ $student->promoted_class_name }}</li>
                            <li class="list-group-item px-0 py-2"><strong>Section:</strong> {{ $student->section }}</li>
                            <li class="list-group-item px-0 py-2"><strong>Date of Registration:</strong>
                                {{ $student->created_at->format('d M Y') }} <small
                                    class="text-muted">({{ $student->created_at->diffForHumans() }})</small></li>
                            <li class="list-group-item px-0 py-2"><strong>Gender:</strong> {{ $student->gender }}</li>
                            <li class="list-group-item px-0 py-2"><strong>Date of Birth:</strong> {{ $student->dob }}</li>
                        </ul>
                    </div>

                    <!-- Contact & Address -->
                    <div class="col-md-4">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item px-0 py-2"><strong>Phone:</strong> <a
                                    href="tel:{{ $student->whatsapp_mobile }}">{{ $student->whatsapp_mobile }}</a></li>
                            <li class="list-group-item px-0 py-2"><strong>Email:</strong> <a
                                    href="mailto:{{ $student->email_id }}">{{ $student->email_id }}</a></li>
                            <li class="list-group-item px-0 py-2"><strong>Address:</strong>
                                {{ $student->permanent_address }}</li>
                            {{-- <li class="list-group-item px-0 py-2">
                        <a href="chat.html" class="btn btn-sm btn-outline-secondary mt-2">💬 Message Student</a>
                    </li> --}}
                        </ul>
                    </div>
                </div>
                <hr>
                {{-- <div class="text-end">
                    <a href="#" data-bs-toggle="modal" data-target="#profile_info"
                        class="btn btn-sm btn-outline-danger">
                        <i class="fa fa-pencil-alt me-1"></i> Edit Profile
                    </a>
                </div> --}}
            </div>
        </div>


        {{-- <div class="card tab-box">
            <div class="row user-tabs">
                <div class="col-lg-12 col-md-12 col-sm-12 line-tabs">
                    <ul class="nav nav-tabs nav-tabs-bottom">
                        <li class="nav-item"><a href="#emp_profile" data-toggle="tab" class="nav-link active">Profile</a>
                        </li>
                        <li class="nav-item"><a href="#emp_projects" data-toggle="tab" class="nav-link">Projects</a></li>
                        <li class="nav-item"><a href="#bank_statutory" data-toggle="tab" class="nav-link">Bank & Statutory
                                <small class="text-danger">(Admin Only)</small></a></li>
                    </ul>
                </div>
            </div>
        </div> --}}

        <div class="tab-content">

            <!-- Profile Info Tab -->
            <div id="emp_profile" class="pro-overview tab-pane fade show active">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card shadow-sm rounded-4">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="card-title mb-0 text-primary">Student Information</h5>
                                    {{-- <a href="#" class="text-primary" data-bs-toggle="modal"
                                        data-bs-target="#personal_info_modal" title="Edit">
                                        <i class="fa fa-pencil-alt"></i>
                                    </a> --}}
                                </div>

                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex justify-content-between">
                                        <strong>Aadhaar
                                            Number:</strong>
                                        <span>{{ $student->aadhaar_number }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <strong>Ration Card Type:</strong>
                                        <span>{{ $student->ration_card_type }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <strong>Physically
                                            Handicapped:</strong>
                                        <span>{{ $student->physically_handicapped }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <strong>Blood
                                            Group:</strong>
                                        <span>{{ $student->blood_group }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <strong>Height:</strong>
                                        <span>{{ $student->height }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <strong>Weight:</strong>
                                        <span>{{ $student->weight }}</span>
                                    </li>

                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card shadow-sm rounded-4">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="card-title mb-0 text-primary">Parents Information</h5>
                                    {{-- <a href="#" class="text-primary" data-bs-toggle="modal"
                                        data-bs-target="#personal_info_modal" title="Edit">
                                        <i class="fa fa-pencil-alt"></i>
                                    </a> --}}
                                </div>

                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex justify-content-between">
                                        <strong>Father’s Name:</strong>
                                        <span>{{ $student->father_name }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <strong>Mother’s Name:</strong>
                                        <span>{{ $student->mother_name }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <strong>Guardian’s Name:</strong>
                                        <span>{{ $student->guardian_name }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <strong>Father’s Occupation & Income:</strong>
                                        <span>{{ $student->father_occupation_income }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <strong>Present Address:</strong>
                                        <span>{{ $student->present_address }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <strong>Permanent Address:</strong>
                                        <span>{{ $student->permanent_address }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <strong>Guardian Address:</strong>
                                        <span>{{ $student->local_guardian }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <strong>State You Belong To:</strong>
                                        <span>{{ $student->state_belong }}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="row">

                    <div class="col-md-6">
                        <div class="card shadow-sm rounded-4">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="card-title mb-0 text-primary">Bank Details</h5>
                                    {{-- <a href="#" class="text-primary" data-bs-toggle="modal"
                                        data-bs-target="#personal_info_modal" title="Edit">
                                        <i class="fa fa-pencil-alt"></i>
                                    </a> --}}
                                </div>

                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex justify-content-between">
                                        <strong>Bank
                                            Name & Branch:</strong>
                                        <span>{{ $student->bank_name_branch }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <strong>Account Holder
                                            Name:</strong>
                                        <span>{{ $student->account_holder_name }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <strong>Account
                                            Number</strong>
                                        <span>{{ $student->account_number }}</span>
                                    </li>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <strong>IFSC
                                            Code:</strong>
                                        <span>{{ $student->ifsc_code }}</span>
                                    </li>


                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card shadow-sm rounded-4">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="card-title mb-0 text-primary">Contacts Details</h5>
                                    {{-- <a href="#" class="text-primary" data-bs-toggle="modal"
                                        data-bs-target="#personal_info_modal" title="Edit">
                                        <i class="fa fa-pencil-alt"></i>
                                    </a> --}}
                                </div>

                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex justify-content-between">
                                        <strong>Father’s Mobile Number:</strong>
                                        <span>{{ $student->father_mobile }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <strong>Mother’s Mobile Number:</strong>
                                        <span>{{ $student->mother_mobile }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <strong>Alternate Mobile
                                            No.</strong>
                                        <span>{{ $student->alternate_mobile }}</span>
                                    </li>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <strong>WhatsApp Mobile
                                            No.:</strong>
                                        <span>{{ $student->whatsapp_mobile }}</span>
                                    </li>

                                    <li class="list-group-item d-flex justify-content-between">
                                        <strong>Email:</strong>
                                        <span>{{ $student->email_id }}</span>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            {{-- <div class="row">
                    <div class="col-md-6 d-flex">
                        <div class="card profile-box flex-fill">
                            <div class="card-body">
                                <h3 class="card-title">Education Informations <a href="#" class="edit-icon"
                                        data-toggle="modal" data-target="#education_info"><i
                                            class="fa fa-pencil"></i></a></h3>
                                <div class="experience-box">
                                    <ul class="experience-list">
                                        <li>
                                            <div class="experience-user">
                                                <div class="before-circle"></div>
                                            </div>
                                            <div class="experience-content">
                                                <div class="timeline-content">
                                                    <a href="#/" class="name">International College of Arts and
                                                        Science (UG)</a>
                                                    <div>Bsc Computer Science</div>
                                                    <span class="time">2000 - 2003</span>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="experience-user">
                                                <div class="before-circle"></div>
                                            </div>
                                            <div class="experience-content">
                                                <div class="timeline-content">
                                                    <a href="#/" class="name">International College of Arts and
                                                        Science (PG)</a>
                                                    <div>Msc Computer Science</div>
                                                    <span class="time">2000 - 2003</span>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
           
                </div> --}}
        </div>
        <!-- /Profile Info Tab -->


    </div>
    </div>
    <!-- /Page Content -->

    <!-- Profile Modal -->
    <div id="profile_info" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Profile Information</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="profile-img-wrap edit-img">
                                    <img class="inline-block" src="assets/img/profiles/avatar-02.jpg" alt="user">
                                    <div class="fileupload btn">
                                        <span class="btn-text">edit</span>
                                        <input class="upload" type="file">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Student Name</label>
                                            <input type="text" class="form-control" value="John">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Birth Date</label>
                                            <div class="cal-icon">
                                                <input class="form-control datetimepicker" type="text"
                                                    value="05/06/1985">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Gender</label>
                                            <select class="select form-control">
                                                <option value="male selected">Male</option>
                                                <option value="female">Female</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Address</label>
                                    <input type="text" class="form-control" value="4487 Snowbird Lane">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>State</label>
                                    <input type="text" class="form-control" value="New York">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Country</label>
                                    <input type="text" class="form-control" value="United States">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Pin Code</label>
                                    <input type="text" class="form-control" value="10523">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Phone Number</label>
                                    <input type="text" class="form-control" value="631-889-3206">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Department <span class="text-danger">*</span></label>
                                    <select class="select">
                                        <option>Select Department</option>
                                        <option>Web Development</option>
                                        <option>IT Management</option>
                                        <option>Marketing</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Designation <span class="text-danger">*</span></label>
                                    <select class="select">
                                        <option>Select Designation</option>
                                        <option>Web Designer</option>
                                        <option>Web Developer</option>
                                        <option>Android Developer</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Reports To <span class="text-danger">*</span></label>
                                    <select class="select">
                                        <option>-</option>
                                        <option>Wilmer Deluna</option>
                                        <option>Lesley Grauer</option>
                                        <option>Jeffery Lalor</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Profile Modal -->

    <!-- Parents Info Modal -->
    <div id="personal_info_modal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content rounded-4 shadow-sm">
                <div class="modal-header bg-light border-bottom">
                    <h5 class="modal-title">Parents Information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form id="parentsInfoForm">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="father_name" class="form-label">Father's Name</label>
                                <input type="text" name="father_name" class="form-control"
                                    value="{{ $student->father_name ?? '' }}">
                            </div>
                            <div class="col-md-6">
                                <label for="mother_name" class="form-label">Mother's Name</label>
                                <input type="text" name="mother_name" class="form-control"
                                    value="{{ $student->mother_name ?? '' }}">
                            </div>
                            <div class="col-md-6">
                                <label for="guardian_name" class="form-label">Guardian's Name</label>
                                <input type="text" name="guardian_name" class="form-control"
                                    value="{{ $student->guardian_name ?? '' }}">
                            </div>
                            <div class="col-md-6">
                                <label for="father_occupation_income" class="form-label">Father's Occupation & Annual
                                    Income</label>
                                <input type="text" name="father_occupation_income" class="form-control"
                                    value="{{ $student->father_occupation_income ?? '' }}">
                            </div>
                            <div class="col-md-6">
                                <label for="present_address" class="form-label">Present Address</label>
                                <input type="text" name="present_address" class="form-control"
                                    value="{{ $student->present_address ?? '' }}">
                            </div>
                            <div class="col-md-6">
                                <label for="permanent_address" class="form-label">Permanent Address</label>
                                <input type="text" name="permanent_address" class="form-control"
                                    value="{{ $student->permanent_address ?? '' }}">
                            </div>
                            <div class="col-md-6">
                                <label for="local_guardian" class="form-label">Guardian Address</label>
                                <input type="text" name="local_guardian" class="form-control"
                                    value="{{ $student->local_guardian ?? '' }}">
                            </div>
                            <div class="col-md-6">
                                <label for="state_belong" class="form-label">State You Belong To</label>
                                <input type="text" name="state_belong" class="form-control"
                                    value="{{ $student->state_belong ?? '' }}">
                            </div>
                        </div>

                        <div class="submit-section text-end mt-4">
                            <button type="submit" class="btn btn-primary px-4">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Parents Info Modal -->

    <!-- Family Info Modal -->
    <div id="family_info_modal" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"> Family Informations</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-scroll">
                            <div class="card">
                                <div class="card-body">
                                    <h3 class="card-title">Family Member <a href="javascript:void(0);"
                                            class="delete-icon"><i class="fa fa-trash-o"></i></a></h3>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Name <span class="text-danger">*</span></label>
                                                <input class="form-control" type="text">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Relationship <span class="text-danger">*</span></label>
                                                <input class="form-control" type="text">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Date of birth <span class="text-danger">*</span></label>
                                                <input class="form-control" type="text">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Phone <span class="text-danger">*</span></label>
                                                <input class="form-control" type="text">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-body">
                                    <h3 class="card-title">Education Informations <a href="javascript:void(0);"
                                            class="delete-icon"><i class="fa fa-trash-o"></i></a></h3>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Name <span class="text-danger">*</span></label>
                                                <input class="form-control" type="text">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Relationship <span class="text-danger">*</span></label>
                                                <input class="form-control" type="text">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Date of birth <span class="text-danger">*</span></label>
                                                <input class="form-control" type="text">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Phone <span class="text-danger">*</span></label>
                                                <input class="form-control" type="text">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="add-more">
                                        <a href="javascript:void(0);"><i class="fa fa-plus-circle"></i> Add More</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Family Info Modal -->

    <!-- Emergency Contact Modal -->
    <div id="emergency_contact_modal" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Personal Information</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title">Primary Contact</h3>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Relationship <span class="text-danger">*</span></label>
                                            <input class="form-control" type="text">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Phone <span class="text-danger">*</span></label>
                                            <input class="form-control" type="text">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Phone 2</label>
                                            <input class="form-control" type="text">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title">Primary Contact</h3>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Relationship <span class="text-danger">*</span></label>
                                            <input class="form-control" type="text">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Phone <span class="text-danger">*</span></label>
                                            <input class="form-control" type="text">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Phone 2</label>
                                            <input class="form-control" type="text">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Emergency Contact Modal -->

    <!-- Education Modal -->
    <div id="education_info" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"> Education Informations</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-scroll">
                            <div class="card">
                                <div class="card-body">
                                    <h3 class="card-title">Education Informations <a href="javascript:void(0);"
                                            class="delete-icon"><i class="fa fa-trash-o"></i></a></h3>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group form-focus focused">
                                                <input type="text" value="Oxford University"
                                                    class="form-control floating">
                                                <label class="focus-label">Institution</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-focus focused">
                                                <input type="text" value="Computer Science"
                                                    class="form-control floating">
                                                <label class="focus-label">Subject</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-focus focused">
                                                <div class="cal-icon">
                                                    <input type="text" value="01/06/2002"
                                                        class="form-control floating datetimepicker">
                                                </div>
                                                <label class="focus-label">Starting Date</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-focus focused">
                                                <div class="cal-icon">
                                                    <input type="text" value="31/05/2006"
                                                        class="form-control floating datetimepicker">
                                                </div>
                                                <label class="focus-label">Complete Date</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-focus focused">
                                                <input type="text" value="BE Computer Science"
                                                    class="form-control floating">
                                                <label class="focus-label">Degree</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-focus focused">
                                                <input type="text" value="Grade A" class="form-control floating">
                                                <label class="focus-label">Grade</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-body">
                                    <h3 class="card-title">Education Informations <a href="javascript:void(0);"
                                            class="delete-icon"><i class="fa fa-trash-o"></i></a></h3>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group form-focus focused">
                                                <input type="text" value="Oxford University"
                                                    class="form-control floating">
                                                <label class="focus-label">Institution</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-focus focused">
                                                <input type="text" value="Computer Science"
                                                    class="form-control floating">
                                                <label class="focus-label">Subject</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-focus focused">
                                                <div class="cal-icon">
                                                    <input type="text" value="01/06/2002"
                                                        class="form-control floating datetimepicker">
                                                </div>
                                                <label class="focus-label">Starting Date</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-focus focused">
                                                <div class="cal-icon">
                                                    <input type="text" value="31/05/2006"
                                                        class="form-control floating datetimepicker">
                                                </div>
                                                <label class="focus-label">Complete Date</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-focus focused">
                                                <input type="text" value="BE Computer Science"
                                                    class="form-control floating">
                                                <label class="focus-label">Degree</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-focus focused">
                                                <input type="text" value="Grade A" class="form-control floating">
                                                <label class="focus-label">Grade</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="add-more">
                                        <a href="javascript:void(0);"><i class="fa fa-plus-circle"></i> Add More</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Education Modal -->

    <!-- Experience Modal -->
    <div id="experience_info" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Experience Informations</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-scroll">
                            <div class="card">
                                <div class="card-body">
                                    <h3 class="card-title">Experience Informations <a href="javascript:void(0);"
                                            class="delete-icon"><i class="fa fa-trash-o"></i></a></h3>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group form-focus">
                                                <input type="text" class="form-control floating"
                                                    value="Digital Devlopment Inc">
                                                <label class="focus-label">Company Name</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-focus">
                                                <input type="text" class="form-control floating"
                                                    value="United States">
                                                <label class="focus-label">Location</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-focus">
                                                <input type="text" class="form-control floating"
                                                    value="Web Developer">
                                                <label class="focus-label">Job Position</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-focus">
                                                <div class="cal-icon">
                                                    <input type="text" class="form-control floating datetimepicker"
                                                        value="01/07/2007">
                                                </div>
                                                <label class="focus-label">Period From</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-focus">
                                                <div class="cal-icon">
                                                    <input type="text" class="form-control floating datetimepicker"
                                                        value="08/06/2018">
                                                </div>
                                                <label class="focus-label">Period To</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-body">
                                    <h3 class="card-title">Experience Informations <a href="javascript:void(0);"
                                            class="delete-icon"><i class="fa fa-trash-o"></i></a></h3>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group form-focus">
                                                <input type="text" class="form-control floating"
                                                    value="Digital Devlopment Inc">
                                                <label class="focus-label">Company Name</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-focus">
                                                <input type="text" class="form-control floating"
                                                    value="United States">
                                                <label class="focus-label">Location</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-focus">
                                                <input type="text" class="form-control floating"
                                                    value="Web Developer">
                                                <label class="focus-label">Job Position</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-focus">
                                                <div class="cal-icon">
                                                    <input type="text" class="form-control floating datetimepicker"
                                                        value="01/07/2007">
                                                </div>
                                                <label class="focus-label">Period From</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-focus">
                                                <div class="cal-icon">
                                                    <input type="text" class="form-control floating datetimepicker"
                                                        value="08/06/2018">
                                                </div>
                                                <label class="focus-label">Period To</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="add-more">
                                        <a href="javascript:void(0);"><i class="fa fa-plus-circle"></i> Add More</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Experience Modal -->
@endsection
