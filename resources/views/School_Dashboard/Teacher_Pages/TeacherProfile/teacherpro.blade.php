@extends('school_dashboard.Teacher_Layouts.app')
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
    <div class="container py-5">
        <div class="row justify-content-center">

            {{-- Profile Card --}}
            <div class="col-md-10 mx-auto tecaherProCard">
                <div class="card shadow-md rounded-4 p-4 position-relative">
                    <div class="profile-header mb-3 border-1 border-bottom ">
                        <!-- Main Heading -->
                        <h2 class="text-center fw-bold text-primary mb-4">Teacher Profile</h2>

                        <!-- Edit Button Top Right -->
                        <button
                            class="editTeacherBtn btn btn-primary position-absolute top-0 end-0 mt-3 me-3 rounded-pill "
                            data-id="{{ $teacher->id }}">
                            <i class="fa fa-edit me-1"></i> Edit
                        </button>
                    </div>

                    <div class="row align-items-center mb-4">
                        <!-- Profile Image Left -->
                        <div class="col-md-4 text-center mb-3 mb-md-0">
                            <img src="{{ asset('storage/' . ($teacher->image ?? 'default_profile.jpg')) }}"
                                alt="Teacher Photo" class="img-fluid rounded-circle shadow-sm"
                                style="width:200px; height:200px; object-fit:cover;">
                        </div>

                        <!-- Teacher Details Right -->
                        <div class="col-md-8">
                            <h3 class="fw-bold mb-2">{{ $teacher->teacher_name ?? 'Teacher Name' }}</h3>
                            <p class="mb-1"><strong>Email:</strong> {{ $teacher->email ?? 'example@email.com' }}</p>
                            <p class="mb-1"><strong>Mobile:</strong> {{ $teacher->mobile ?? '+91 9999999999' }}</p>
                            <p class="mb-1"><strong>Qualification:</strong> {{ $teacher->qualification ?? '-' }}</p>
                            <p class="mb-1"><strong>Experience:</strong> {{ $teacher->experience ?? '0' }} years</p>
                            <p class="mb-1"><strong>Role:</strong> {{ $teacher->role ?? '-' }}</p>
                            <p class="mb-1"><strong>Status:</strong>
                                <span class="{{ $teacher->status == 'Active' ? 'text-success' : 'text-danger' }}">
                                    {{ $teacher->status ?? '-' }}
                                </span>
                            </p>
                        </div>
                    </div>

                    <div class="my-4 border-1 border-bottom"></div>

                    <!-- Password Change Section -->
                    <div class="row">
                        <div class="col-12">
                            <h3 class="text-danger mb-3"><i class="fa fa-lock me-2"></i>Change Password</h3>
                            <form id="updatePasswordForm" method="POST">
                                @csrf
                                <div class="row mb-3">
                                    <div class="col-md-6 mb-3 mb-md-0">
                                        <label for="current_password" class="form-label fw-semibold">Current
                                            Password</label>
                                        <input type="password" id="current_password" name="current_password"
                                            class="form-control rounded-3" placeholder="Enter current password">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="new_password" class="form-label fw-semibold">New Password</label>
                                        <input type="password" id="new_password" name="new_password"
                                            class="form-control rounded-3" placeholder="Enter new password">
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <label for="confirm_password" class="form-label fw-semibold">Confirm
                                            Password</label>
                                        <input type="password" id="confirm_password" name="confirm_password"
                                            class="form-control rounded-3" placeholder="Confirm new password">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary px-4 py-2 rounded-pill">
                                    <i class="fa fa-save me-2"></i> Update Password
                                </button>
                            </form>
                            <!-- Success & Error alert area -->
                            <div id="alertArea" class="mt-3"></div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('pos/assets/js/CustomJS/Teachers/teacherajax.js') }}"></script>
    {{-- Password Update Ajax --}}
    <script>
        $(document).ready(function() {
            $('#updatePasswordForm').on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    url: "{{ route('teacher.password.update') }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        current_password: $('#current_password').val(),
                        new_password: $('#new_password').val(),
                        confirm_password: $('#confirm_password').val(),
                    },
                    success: function(res) {
                        $('#alertArea').html(`
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        ${res.message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                `);
                        $('#updatePasswordForm')[0].reset();
                    },
                    error: function(xhr) {
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            let errors = xhr.responseJSON.errors;
                            let errorList = Object.values(errors).map(err =>
                                `<li>${err[0]}</li>`).join('');
                            $('#alertArea').html(`
                        <div class="alert alert-danger">
                            <ul class="mb-0">${errorList}</ul>
                        </div>
                    `);
                        } else if (xhr.responseJSON && xhr.responseJSON.message) {
                            $('#alertArea').html(`
                        <div class="alert alert-danger">${xhr.responseJSON.message}</div>
                    `);
                        }
                    }
                });
            });
        });
    </script>
@endpush
