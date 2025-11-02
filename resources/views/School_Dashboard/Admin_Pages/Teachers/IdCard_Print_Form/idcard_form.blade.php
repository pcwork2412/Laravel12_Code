@extends('School_Dashboard.Admin_Layouts.app')

@section('content')
    <div class="container">
        <div class="card tab-box my-4 shadow-sm">
        <div class="card-header bg-primary text-white d-flex align-items-center">
            <div class="col-md-8">
                <h3 class="mb-0"><i class="fa fa-users"></i> Generate Teacher ID Card</h3>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <a href="{{ route('teachers.index') }}" class="btn btn-white"><i class="fa fa-list me-2"></i>Teacher List</a>
            </div>
        </div>
        <div class="card-body  rounded-3">
            @php
            @endphp
            <form action="{{ route('teachers.genIdAll') }}" method="POST" id="allIdCardForm" class="row g-3">
                @csrf

                <div class="col-md-4">
                    <label class="form-label">Generate For All Teachers</label>
                    <select name="class_name" id="class_name" class="form-control rounded-3 shadow-sm">
                        <option value="all_teacher">All Teacher</option>
                    </select>
                </div>
                <div class="col-md-6 d-flex align-items-end">
                    <button type="submit" name="action" value="preview" class="btn btn-success me-2"><i
                            class="bi bi-card-text me-1"></i>Preview ID Card</button>
                    <button type="submit" name="action" value="generate" class="btn btn-danger"><i
                            class="bi bi-card-text me-1"></i>Generate ID Card</button>
                </div>
            </form>
        </div>
    </div>
    </div>
    {{-- @if (session('error'))
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
     <script>
        // Form submit par button disable karne ka script
        document.addEventListener('DOMContentLoaded', function() {
            const allIdCardForm = document.getElementById('allIdCardForm');

            if (allIdCardForm) {
                // Sabhi submit buttons ko select karo
                const submitButtons = allIdCardForm.querySelectorAll('button[type="submit"]');

                submitButtons.forEach(function(button) {
                    button.addEventListener('click', function(e) {
                        // Hidden input add karo jo button ki value send karega
                        const existingHidden = allIdCardForm.querySelector(
                        'input[name="action"]');
                        if (existingHidden) {
                            existingHidden.remove();
                        }

                        // Naya hidden input create karo
                        const hiddenInput = document.createElement('input');
                        hiddenInput.type = 'hidden';
                        hiddenInput.name = 'action';
                        hiddenInput.value = button.value; // 'preview' ya 'generate'
                        allIdCardForm.appendChild(hiddenInput);
                    });
                });

                allIdCardForm.addEventListener('submit', function(e) {
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