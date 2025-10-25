@extends('School_Dashboard.Admin_Layouts.app')

@section('content')
    <h1>ID Card Templates</h1>
    <!-- Form jisse controller me path bhejna hai -->
    <form action="{{ route('students.templates.set') }}" method="POST">
        @csrf

        <div class="d-flex mb-3">
            <input type="text" id="selectedTemplate" name="template_path" class="form-control me-2"
                   placeholder="Selected Image Path" readonly>
            <button type="submit" class="btn btn-primary">Set</button>
        </div>
    </form>

    <div class="row" id="templateGallery">
        <div class="col-md-3">
            <div class="card mb-4 shadow-sm template-card">
                <img src="{{ asset('pos/assets/img/templates/img-01.jpg') }}" class="card-img-top fit-img" alt="Template 1">
                <div class="card-body">
                    <h5 class="card-title">Template 1</h5>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card mb-4 shadow-sm template-card">
                <img src="{{ asset('pos/assets/img/templates/profile.png') }}" class="card-img-top fit-img" alt="Template 2">
                <div class="card-body">
                    <h5 class="card-title">Template 2</h5>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card mb-4 shadow-sm template-card">
                <img src="{{ asset('pos/assets/img/templates/video-call.jpg') }}" class="card-img-top fit-img" alt="Template 3">
                <div class="card-body">
                    <h5 class="card-title">Template 3</h5>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .template-card {
        cursor: pointer;
        transition: 0.3s;
    }
    .template-card.selected {
        border: 3px solid #007bff;
        box-shadow: 0 0 10px rgba(0, 123, 255, 0.6);
    }
    .fit-img {
        width: 100%;
        height: 150px;
        object-fit: contain;  /* puri image fit ho, cut na ho */
        background: #f8f9fa;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const cards = document.querySelectorAll(".template-card");
        const input = document.getElementById("selectedTemplate");

        cards.forEach(card => {
            card.addEventListener("click", function () {
                cards.forEach(c => c.classList.remove("selected"));
                card.classList.add("selected");
                const img = card.querySelector("img");
                input.value = img.getAttribute("src");
            });
        });
    });
</script>
@endpush
