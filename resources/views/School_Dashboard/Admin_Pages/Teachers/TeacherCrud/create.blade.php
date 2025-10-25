@extends('School_Dashboard.Admin_Layouts.app')
@section('content')
    {{-- Modal Section --}}
    <div class="modal fade" id="myModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-lg modal-dialog-centered">

        </div>
    </div>
    <form id="teacherCreateForm" enctype="multipart/form-data">
        @csrf
        <div class="modal-content shadow-sm rounded-3 border-0"
            style="background: linear-gradient(145deg, #ffffff, #f8f9fa);">

            <div class="modal-header bg-primary text-white border-0 rounded-top-3">
                <h3 class="modal-title" id="teacherModalLabel">
                    <i class="bi bi-person-plus-fill me-2"></i>Add New Teacher
                </h3>
                <a href="{{route('teachers.index')}}" type="button" class="btn btn-white" ><i class="fa fa-list"></i> View Teachers List</a>
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
                            <img id="previewImage" src="" class="img-thumbnail mt-2" width="80" alt="Preview">
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
                        <input type="file" id="documents" name="documents" accept=".zip" class="form-control rounded-3">
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
                    {{-- <button type="button" class="btn btn-danger rounded-3 px-3 float-end" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-2"></i> Cancel
                    </button> --}}
                    <button type="submit" id="saveBtn" class="btn btn-success rounded-3 px-4 float-start">
                        <i class="bi bi-person-plus-fill me-2"></i> Register Teacher
                    </button>
                </div>
            </div>
        </div>
    </form>
    {{-- End --}}
@endsection

@push('scripts')
    <script src="{{ asset('pos/assets/js/CustomJS/Teachers/createajax.js') }}"></script>
@endpush
