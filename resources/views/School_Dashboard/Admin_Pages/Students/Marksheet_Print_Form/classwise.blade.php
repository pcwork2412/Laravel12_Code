@extends('School_Dashboard.Admin_Layouts.app')

@section('content')
    <div class="container my-5">
        <div class="row justify-content-start">
            <div class="col-md-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white ">
                        <h3 class="mb-0">Generate Marksheets</h3>
                    </div>
                    <div class="card-body">

                        <form action="{{ route('students.marksheet.generate') }}" id="singalMarksheetForm" method="POST">
                            @csrf
                            <div class="row d-flex justify-between ">
                                <div class="mb-4 col-md-6">
                                    <label for="promoted_class_name" class="form-label fw-semibold">Choose Class</label>
                                   <select id="class_name" name="class_name" class="form-select globalClassSelect"
                                            required>
                                            <option value="">Select Class</option>
                                            @foreach ($classes as $class)
                                                <option value="{{ $class->id }}">{{ $class->class_name }}</option>
                                            @endforeach
                                        </select>
                                </div>
                                <div class="mb-4 col-md-6">
                                    <label for="section_name" class="form-label fw-semibold">Choose Section</label>
                                   <select id="section_name" name="section_name"
                                            class=" globalSectionSelect  form-select" required>
                                            <option value="">Select Section</option>
                                        </select>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <button type="submit" class="btn btn-info" name="action" value="preview"><i
                                        class="fa fa-eye"></i> Preview</button>
                                <button type="submit" class="btn btn-primary" name="action" value="generate"><i
                                        class="fa fa-download"></i> Download Marksheet</button>
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
            const singalMarksheetForm = document.getElementById('singalMarksheetForm');

            if (singalMarksheetForm) {
                // Sabhi submit buttons ko select karo
                const submitButtons = singalMarksheetForm.querySelectorAll('button[type="submit"]');

                submitButtons.forEach(function(button) {
                    button.addEventListener('click', function(e) {
                        // Hidden input add karo jo button ki value send karega
                        const existingHidden = singalMarksheetForm.querySelector(
                        'input[name="action"]');
                        if (existingHidden) {
                            existingHidden.remove();
                        }

                        // Naya hidden input create karo
                        const hiddenInput = document.createElement('input');
                        hiddenInput.type = 'hidden';
                        hiddenInput.name = 'action';
                        hiddenInput.value = button.value; // 'preview' ya 'generate'
                        singalMarksheetForm.appendChild(hiddenInput);
                    });
                });

                singalMarksheetForm.addEventListener('submit', function(e) {
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
