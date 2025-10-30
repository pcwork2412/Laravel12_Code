@extends('School_Dashboard.Admin_Layouts.app')
@section('content')
    <style>
        #viewGalleryModal .modal-content {
            border-radius: 1rem;
            overflow: hidden;
        }

        #viewGalleryModal .table th {
            background-color: #f8f9fa;
            width: 180px;
        }
    </style>
<div class="container">
    
    <div class="card shadow-sm">
        <div class="card-body d-flex justify-content-between align-items-center">
            <h3 class="mb-0 text-primary fw-bold"><i class="bi bi-images"></i> Upload Gallery Images</h3>
            <button id="addImgBtn" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#galleryModal">
                <i class="bi bi-plus-circle"></i> Add Images
            </button>
        </div>
    </div>
    
    <!-- Gallery Upload Image List Start -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle bg-amber-50" id="galleryTable">
                    <thead class="table-dark">
                        <tr>
                            <th style="width: 5%;">ID</th>
                            <th style="width: 20%;">Title</th>
                            <th style="width: 35%;">Description</th>
                            <th style="width: 20%;">Image</th>
                            <th style="width: 20%;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- @foreach ($galleryData as $galleryData)
                            <tr>
                                <td>{{ $galleryData->id }}</td>
                                <td>{{ $galleryData->title }}</td>
                                <td>{{ $galleryData->description }}</td>
                                <td>
                                    <img src="{{ asset('storage/' . $galleryData->image) }}" class="img-thumbnail" width="100" alt="">
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-warning me-1">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </button>
                                    <button class="btn btn-sm btn-danger">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </td>
                            </tr>
                        @endforeach --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Gallery Upload Image List End -->
</div>

    <!-- View Gallery Modal Start -->
    <div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="viewGalleryModal" tabindex="-1"
        aria-labelledby="viewGalleryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content shadow-lg border-0 rounded-4">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title fw-semibold" id="viewGalleryModalLabel">View Gallery</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <div class="modal-body p-4">
                    <div id="viewGalleryContent">
                        <!-- AJAX se yaha data load hoga -->
                        <div class="text-center text-muted py-3">
                            <i class="fa fa-spinner fa-spin fa-2x"></i>
                            <p class="mt-2">Loading gallery data...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- View Gallery Modal End -->


    <!-- Gallery Upload Image Modal Start -->
    <div class="modal fade" id="galleryModal" tabindex="-1" aria-labelledby="galleryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow">
                <div class="modal-header bg-primary text-white">
                    <h3 class="modal-title" id="galleryModalLabel"><i class="fa fa-upload"></i> Upload Image</h3>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="galleryForm" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="galleryId" id="galleryId">
                        <div class="mb-3">
                            <label for="title" class="form-label fw-semibold">Title <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="editGalleryTitle" name="title" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label fw-semibold">Description</label>
                            <textarea class="form-control" id="editGalleryDescription" name="description" rows="2"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label fw-semibold">Image <span
                                    class="text-danger">*</span></label>
                            <input type="file" id="editGalleryImage" name="images[]" class="form-control" multiple>
                            {{-- <div class="form-text">You can upload multiple images. Allowed types: jpg, jpeg, png, gif.
                                    Max size: 2MB each.</div> --}}
                        </div>

                        <div class="mb-3 text-center">
                            <div id="previewGalleryContainer" class="d-flex flex-wrap gap-2"></div>
                        </div>

                        <div class="d-grid">
                            <button id="uploadGalleryBtn" type="submit" class="btn btn-primary">
                                <i class="bi bi-upload"></i> Upload
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Gallery Upload Image Modal End -->

@endsection

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
@endpush

@push('scripts')
    <script src="{{ asset('pos/assets/js/customjs/gallery/gallery.js') }}"></script>
@endpush
