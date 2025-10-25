@extends('school_dashboard.student_layouts.app')
@section('content')
{{-- Toast Notification --}}
<div class="position-fixed top-0 end-0 p-3" style="z-index: 1080;">
    @if(session('success'))
    <div class="toast align-items-center text-bg-success border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                <i class="bi bi-check-circle-fill me-2"></i> {{-- Bootstrap icon --}}
                {{ session('success') }}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
    @endif
</div>
<h1>Student Dashboard</h1>

@endsection