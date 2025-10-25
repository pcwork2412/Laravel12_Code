@extends('school_dashboard.Admin_Layouts.app')
@section('content')
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
                                <input type="text" id="teacher_name" name="teacher_name" class="form-control rounded-3"
                                    placeholder="Enter Name" required>
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
                                <div id="previewBox" style="display:none;">
                                    <img id="previewImage" src="" class="img-thumbnail mt-2" width="80"
                                        alt="Preview">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label fw-semibold">Email</label>
                                <input type="email" id="email" name="email" class="form-control rounded-3"
                                    placeholder="Enter Email" required>
                            </div>
                            <div class="col-md-6">
                                <label for="mobile" class="form-label fw-semibold">Mobile</label>
                                <input type="text" id="mobile" name="mobile" class="form-control rounded-3"
                                    placeholder="Enter Mobile" required>
                            </div>
                            <div class="col-md-6">
                                <label for="qualification" class="form-label fw-semibold">Qualification</label>
                                <input type="text" id="qualification" name="qualification" class="form-control rounded-3"
                                    placeholder="Enter Qualification" required>
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
    <div class="container py-4 teacherProfile">
        <div class="row align-items-center mb-4">
            <div class="col-md-12 d-flex justify-content-between align-items-center">
                <h2 class="mb-0 text-danger fw-bold"><i class="fas fa-user-graduate me-2"></i> Teacher Profile</h2>
                <a href="{{ route('teachers.index') }}" class=" btn btn-outline-danger">
                    <i class="fas fa-arrow-left me-2"></i>Back to Teachers
                </a>
            </div>
        </div>
        <div class="profile-header text-center">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-3 text-center mb-3 mb-md-0" id="image">
                        @if (isset($teacher) && $teacher->image)
                            <img src="{{ asset('storage/' . $teacher->image) }}" class="profile-avatar"
                                alt="Teacher Photo">
                        @else
                            <div class="profile-avatar-placeholder">
                                <i class="fas fa-user fa-3x text-white"></i>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-9 text-md-start">
                        <h2 class="teacher-name" id="teacherName"><i class="fas fa-user me-2"></i>{{ $teacher->teacher_name }}</h2>
                        <h2 class="teacher-id" id="teacherId"><i class="fas fa-id-card me-2"></i>ID: {{ $teacher->teacher_id }}</h2>
                    </div>
                    {{-- Edit Profile --}}
                    <div class="col-12 text-end mt-3">
                        <button class="editTeacherBtn btn btn-primary" data-id="{{ $teacher->id }}">
                            <i class="fas fa-edit me-2"></i>Edit Profile
                        </button>
                    </div>
                </div>

            </div>
        </div>
        <div class="profile-card">
            <!-- Profile Header -->

            <!-- Profile Content -->
            <div class="info-section">
                <div class="container">
                    <div class="row">
                        <!-- Personal Information -->
                        <div class="col-md-6 mb-4">
                            <h3 class="section-title text-dark mb-2 fw-bold">
                                <i class="fas fa-user-circle me-2"></i>Personal Information
                            </h3>

                            <div class="info-item">
                                <div class="info-icon">
                                    <i class="fas fa-user-tag"></i>
                                </div>
                                <div class="info-content">
                                    <div class="info-label">Role</div>
                                    <div class="info-value" id="teacherRole">{{ $teacher->role }}</div>
                                </div>
                            </div>

                            <div class="info-item">
                                <div class="info-icon">
                                    <i class="fas fa-chart-line"></i>
                                </div>
                                <div class="info-content">
                                    <div class="info-label">Status</div>
                                    <div class="info-value" id="teacherStatus">
                                        <span
                                            class="status-badge {{ $teacher->status == 'Active' ? 'status-active' : 'status-inactive' }}">
                                            {{ $teacher->status }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="info-item">
                                <div class="info-icon">
                                    <i class="fas fa-birthday-cake"></i>
                                </div>
                                <div class="info-content">
                                    <div class="info-label">Date of Birth</div>
                                    <div class="info-value" id="teacherDob">{{ $teacher->dob }}</div>
                                </div>
                            </div>

                            <div class="info-item">
                                <div class="info-icon">
                                    <i class="fas fa-venus-mars"></i>
                                </div>
                                <div class="info-content">
                                    <div class="info-label">Gender</div>
                                    <div class="info-value" id="teacherGender">{{ $teacher->gender }}</div>
                                </div>
                            </div>
                        </div>

                        <!-- Professional Information -->
                        <div class="col-md-6 mb-4">
                            <h3 class="section-title text-dark mb-2 fw-bold">
                                <i class="fas fa-graduation-cap me-2"></i>Professional Information
                            </h3>

                            <div class="info-item">
                                <div class="info-icon">
                                    <i class="fas fa-user-graduate"></i>
                                </div>
                                <div class="info-content">
                                    <div class="info-label">Qualification</div>
                                    <div class="info-value" id="teacherQualification">{{ $teacher->qualification }}</div>
                                </div>
                            </div>

                            <div class="info-item">
                                <div class="info-icon">
                                    <i class="fas fa-briefcase"></i>
                                </div>
                                <div class="info-content">
                                    <div class="info-label">Experience</div>
                                    <div class="info-value" id="teacherExperience">{{ $teacher->experience }} years</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Contact Information -->
                        <div class="col-md-6 mb-4">
                            <h3 class="section-title text-dark mb-2 fw-bold">
                                <i class="fas fa-address-book me-2"></i>Contact Information
                            </h3>

                            <div class="info-item">
                                <div class="info-icon">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div class="info-content">
                                    <div class="info-label">Email</div>
                                    <div class="info-value" id="teacherEmail">{{ $teacher->email }}</div>
                                </div>
                            </div>

                            <div class="info-item">
                                <div class="info-icon">
                                    <i class="fas fa-mobile-alt"></i>
                                </div>
                                <div class="info-content">
                                    <div class="info-label">Mobile</div>
                                    <div class="info-value" id="teacherMobile">{{ $teacher->mobile }}</div>
                                </div>
                            </div>

                            <div class="info-item">
                                <div class="info-icon">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div class="info-content">
                                    <div class="info-label">Address</div>
                                    <div class="info-value" id="teacherAddress">{{ $teacher->address }}</div>
                                </div>
                            </div>
                            <h3 class="section-title text-dark mb-2 fw-bold">
                                <i class="fas fa-lock me-2"></i>Security Information
                            </h3>

                            <div class="info-item">
                                <div class="info-icon">
                                    <i class="fas fa-lock"></i>
                                </div>
                                <div class="info-content">
                                    <div class="info-label">Password</div>
                                    <input type="text" class="form-control" value="{{ $teacher->password }}"
                                        readonly>

                                </div>
                            </div>
                        </div>

                        <!-- Location Information -->
                        <div class="col-md-6 mb-4">
                            <h3 class="section-title text-dark mb-2 fw-bold">
                                <i class="fas fa-map-marked-alt me-2"></i>Location Information
                            </h3>

                            <div class="info-item">
                                <div class="info-icon">
                                    <i class="fas fa-city"></i>
                                </div>
                                <div class="info-content">
                                    <div class="info-label">City</div>
                                    <div class="info-value" id="teacherCity">{{ $teacher->city }}</div>
                                </div>
                            </div>

                            <div class="info-item">
                                <div class="info-icon">
                                    <i class="fas fa-landmark"></i>
                                </div>
                                <div class="info-content">
                                    <div class="info-label">State</div>
                                    <div class="info-value" id="teacherState">{{ $teacher->state }}</div>
                                </div>
                            </div>

                            <div class="info-item">
                                <div class="info-icon">
                                    <i class="fas fa-map-pin"></i>
                                </div>
                                <div class="info-content">
                                    <div class="info-label">Pincode</div>
                                    <div class="info-value" id="teacherPincode">{{ $teacher->pincode }}</div>
                                </div>
                            </div>

                            <div class="info-item">
                                <div class="info-icon">
                                    <i class="fas fa-file-alt"></i>
                                </div>
                                <div class="info-content">
                                    <div class="info-label">Documents</div>
                                    <div class="info-value" id="teacherDocuments">
                                        @if (!empty($teacher->documents))
                                            <a href="{{ asset('storage/' . $teacher->documents) }}" target="_blank"
                                                class="document-link">
                                                <i class="fas fa-external-link-alt me-1"></i>View Document
                                            </a>
                                        @else
                                            <span class="badge bg-secondary">No Document</span>
                                        @endif

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('styles')
    <style>
        :root {
            --primary-color: #348adb;
            --secondary-color: #2c3e50;
            --accent-color: #1abc9c;
            --light-bg: #f8f9fa;
            --card-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            --transition: all 0.3s ease;
        }

        body {
            background-color: #f5f7fb;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
        }

        .profile-card {
            background: white;
            border-radius: 16px;
            /* box-shadow: var(--card-shadow); */
            overflow: hidden;
            transition: var(--transition);
            border: none;
        }

        .profile-header {
            background: white;
            color: rgb(0, 0, 0);
            padding: 30px 0;
            /* position: relative; */
            border-radius: 16px;
            margin-bottom: 20px;
        }

        .profile-avatar {
            width: 140px;
            height: 140px;
            border-radius: 50%;
            border: 4px solid white;
            object-fit: cover;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .profile-avatar-placeholder {
            width: 140px;
            height: 140px;
            border-radius: 50%;
            border: 4px solid white;
            background: rgba(255, 255, 255, 0.2);
            /* display: flex;
                            align-items: center;
                            justify-content: center; */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .teacher-name {
            font-weight: 700;
            margin-top: 15px;
            font-size: 1.8rem;
        }

        .teacher-id {
            background: rgba(255, 255, 255, 0.2);
            padding: 6px 15px;
            border-radius: 20px;
            font-size: 0.9rem;
        }

        .info-section {
            /* border-top: #3469db 58px solid; */
            padding: 25px;
        }

        .section-title {
            color: var(--secondary-color);
            font-weight: 600;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--light-bg);
            font-size: 1.2rem;
        }

        .info-item {
            display: flex;
            margin-bottom: 15px;
            align-items: flex-start;
        }

        .info-icon {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: var(--light-bg);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            color: var(--primary-color);
            flex-shrink: 0;
        }

        .info-content {
            flex: 1;
        }

        .info-label {
            font-weight: 500;
            color: #666;
            font-size: 0.9rem;
        }

        .info-value {
            font-weight: 600;
            color: #333;
            margin-top: 2px;
        }

        .status-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .status-active {
            background: #e8f7f3;
            color: var(--accent-color);
        }

        .status-inactive {
            background: #fde8e8;
            color: #e74c3c;
        }

        .document-link {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
            transition: var(--transition);
        }

        .document-link:hover {
            color: var(--secondary-color);
        }

        @media (max-width: 768px) {

            .profile-avatar,
            .profile-avatar-placeholder {
                width: 120px;
                height: 120px;
            }

            .teacher-name {
                font-size: 1.5rem;
            }
        }
    </style>
@endpush
@push('scripts')
    <script src="{{ asset('pos/assets/js/CustomJS/Teachers/teacherajax.js') }}"></script>
@endpush
