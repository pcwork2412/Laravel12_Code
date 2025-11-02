@extends('School_Dashboard.Admin_Layouts.app')

@section('content')
    <div class="container">
        <div class="card tab-box my-4 shadow-sm">
            <div class="card-header bg-primary text-white">
                <div class="row d-flex align-items-center">
                    <div class="col-md-8">
                        <h3 class="mb-0">Generate Individual Student ID Card</h3>
                    </div>
                    <div class="col-md-4 text-md-end mt-3 mt-md-0">
                        <a href="{{ route('students.index') }}" class="btn btn-white me-2">
                            <i class="fa fa-list me-1"></i>Student List</a>
                    </div>
                </div>
            </div>
            <div class="card-body bg-light">
                <form action="{{ route('students.genIdCardSingle') }}" id="singalIdCardForm" method="POST" class="row g-3">
                    @csrf
                    <!-- Class -->
                    <div class="col-md-6">
                        <label class="form-label">Select Class</label>
                        <select name="class_name" id="class_name" class="form-select rounded-3 shadow-sm globalClassSelect">
                            <option value="">Select Class</option>
                            @foreach ($classes as $class)
                                <option value="{{ $class->id }}"
                                    {{ old('class_name') == $class->class_name ? 'selected' : '' }}>
                                    {{ $class->class_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Section -->
                    <div class="col-md-6">
                        <label class="form-label">Select Section</label>
                        <select id="section_name" name="section_name" class=" globalSectionSelect  form-select" required>
                            <option value="">Select Section</option>
                        </select>
                        {{-- <select name="section_name" id="section_name" class="form-select rounded-3 shadow-sm">
            <option value="">Select Section</option>
            @foreach ($sections as $sectionName)
                <option value="{{ $sectionName }}"
                    {{ old('section_name') == $sectionName ? 'selected' : '' }}>
                    {{ $sectionName }}
                </option>
            @endforeach
        </select> --}}
                    </div>

                    <!-- Student UID -->
                    <div class="col-md-6">
                        <label class="form-label">Student UID</label>
                        <select name="student_uid" id="student_uid" class=" globalStudentSelect  form-select" required>
                            <option value="">Select Student</option>
                        </select>
                        {{-- <input type="text" name="student_uid" id="student_uid" placeholder="Enter Student UID"
            value="{{ old('student_uid') }}"
            class="form-control rounded-3 shadow-sm"> --}}
                    </div>

                    <!-- Action Buttons -->
                    <div class="col-md-6 d-flex align-items-end">
                        <button type="submit" name="action" value="preview" class="btn btn-success me-2">
                            <i class="bi bi-card-text me-1"></i>Preview ID Card
                        </button>
                        <button type="submit" name="action" value="generate" class="btn btn-danger">
                            <i class="fa fa-download me-1"></i>Generate ID Card
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    {{-- Error Message
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif --}}
@endsection
@push('scripts')
    <script src="{{ asset('pos/assets/js/CustomJS/Global/global.js') }}"></script>
    <script>
        // Form submit par button disable karne ka script
        document.addEventListener('DOMContentLoaded', function() {
            const singalIdCardForm = document.getElementById('singalIdCardForm');

            if (singalIdCardForm) {
                // Sabhi submit buttons ko select karo
                const submitButtons = singalIdCardForm.querySelectorAll('button[type="submit"]');

                submitButtons.forEach(function(button) {
                    button.addEventListener('click', function(e) {
                        // Hidden input add karo jo button ki value send karega
                        const existingHidden = singalIdCardForm.querySelector(
                            'input[name="action"]');
                        if (existingHidden) {
                            existingHidden.remove();
                        }

                        // Naya hidden input create karo
                        const hiddenInput = document.createElement('input');
                        hiddenInput.type = 'hidden';
                        hiddenInput.name = 'action';
                        hiddenInput.value = button.value; // 'preview' ya 'generate'
                        singalIdCardForm.appendChild(hiddenInput);
                    });
                });

                singalIdCardForm.addEventListener('submit', function(e) {
                    // Jo button click hua hai usko find karo
                    const clickedButton = document.activeElement;

                    // Check karo ki clicked element button hai ya nahi
                    if (clickedButton && clickedButton.type === 'submit') {
                        // Button ko disable karo
                        clickedButton.disabled = true;

                        // Button ka original text save karo
                        const originalText = clickedButton.innerHTML;

                        // Loading text show karo with icon
                        const iconClass = clickedButton.value === 'preview' ? 'fa-eye' : 'fa-download';
                        clickedButton.innerHTML =
                            '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Processing...';

                        // Agar form validation fail ho ya error aaye to button enable karo
                        setTimeout(function() {
                            if (document.body) {
                                clickedButton.disabled = false;
                                clickedButton.innerHTML = originalText;
                            }
                        }, 5000);
                    }
                });
            }
        });
    </script>
@endpush
