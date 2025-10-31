@extends('School_Dashboard.Admin_Layouts.app')
@section('content')
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-12">

                {{-- Card --}}
                <div class="card shadow-sm border-0">
                    <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white">
                        <h3 class="mb-0">Individual Student Marksheet Download</h3>
                           <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    <a href="{{ route('marks.index') }}" class="btn btn-white me-2">
                        <i class="fa fa-list me-1"></i>Marks Allot List</a>
                </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('students.marksheet.generateSeparate') }}" method="POST" id="marksForm">
                            @csrf
                            <div class="row">

                                {{-- Class --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="class_name" class="form-label fw-bold">Class</label>
                                        <select id="class_name" name="class_name" class="form-select globalClassSelect"
                                            required>
                                            <option value="">Select Class</option>
                                            @foreach ($classes as $class)
                                                <option value="{{ $class->id }}">{{ $class->class_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                {{-- Section --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="section" class="form-label fw-bold">Section</label>
                                        <select id="section_name" name="section_name"
                                            class=" globalSectionSelect  form-select" required>
                                            <option value="">Select Section</option>
                                        </select>
                                        {{-- <select id="section" name="section" class="form-select" required>
                                    <option value="">Select Section</option>
                                    @foreach ($sections as $sectionName)
                                        <option value="{{ $sectionName }}"
                                            {{ old('section_name') == $sectionName ? 'selected' : '' }}>
                                            {{ $sectionName }}
                                        </option>
                                    @endforeach
                                </select> --}}
                                    </div>
                                </div>

                            </div>
                         
                            <div class="row">
                                   {{-- Student UID --}}
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="student_uid" class="form-label fw-bold">Student UID</label>
                                    <select name="student_uid" id="student_uid" class="globalStudentSelect  form-select"
                                        required>
                                        <option value="">Select Student</option>
                                    </select>
                                    {{-- <input type="text" id="student_uid" name="student_uid" class="form-control"
                                    placeholder="Enter Student UID" required> --}}
                                </div>
                            </div>
                            {{-- Buttons --}}
                            <div class="col-md-6 d-flex align-items-center gap-2">
                                <button type="submit" class="btn btn-info" name="action" value="preview"><i
                                        class="fa fa-eye"></i> Preview</button>
                                <button type="submit" class="btn btn-primary" name="action" value="generate"><i
                                        class="fa fa-download"></i> Download Marksheet</button>
                            </div>

                            </div>

                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>


@endsection

@push('scripts')
    <script src="{{ asset('pos/assets/js/CustomJS/Global/global.js') }}"></script>
    <script>
        // Form submit par button disable karne ka script
document.addEventListener('DOMContentLoaded', function() {
    const marksForm = document.getElementById('marksForm');
    
    if (marksForm) {
        // Sabhi submit buttons ko select karo
        const submitButtons = marksForm.querySelectorAll('button[type="submit"]');
        
        submitButtons.forEach(function(button) {
            button.addEventListener('click', function(e) {
                // Hidden input add karo jo button ki value send karega
                const existingHidden = marksForm.querySelector('input[name="action"]');
                if (existingHidden) {
                    existingHidden.remove();
                }
                
                // Naya hidden input create karo
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'action';
                hiddenInput.value = button.value; // 'preview' ya 'generate'
                marksForm.appendChild(hiddenInput);
            });
        });
        
        marksForm.addEventListener('submit', function(e) {
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
                clickedButton.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Processing...';
                
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
