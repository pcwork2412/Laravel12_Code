@extends('School_Dashboard.Admin_Layouts.app')

@section('content')
 <div class="container mt-4">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Import Teachers</h4>
                    <a href="{{ route('teachers.index') }}" class="btn btn-light btn-sm"><i
                            class="bi bi-arrow-left-circle me-1"></i>Back to Teacher List</a>
                </div>
            </div>
            <div class="card-body">
                <p class="card-text text-muted">Upload an Excel or CSV file to bulk import student data. Please ensure the
                    file follows the required format.</p>

                {{-- Success and Error Messages --}}
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form action="{{ route('teachers.import.data') }}" method="POST" enctype="multipart/form-data"
                    class="mt-4">
                    @csrf

                    <div class="mb-3">
                        <label for="fileInput" class="form-label fw-bold">Choose Excel / CSV file</label>
                        <div class="input-group">
                            <input type="file" name="file" class="form-control" id="fileInput"
                                accept=".xlsx,.xls,.csv" required>
                            <label class="input-group-text" for="fileInput"><i class="bi bi-upload"></i></label>
                        </div>
                        @error('file')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                        <div class="form-text mt-2">
                            Accepted file types: .xlsx, .xls, .csv.
                        </div>
                    </div>

                    <div class="col-12 d-flex justify-content-between">
                        <div class="mb-4">
                            <a href="{{asset('pos/import/teacher_import_template.xlsx')}}" class="btn btn-outline-success btn-sm rounded-pill px-4 shadow-sm">
                                <i class="bi bi-file-earmark-excel me-2"></i>
                                Download Excel Template
                            </a>
                        </div>
                        <button type="submit" class="btn btn-primary btn-md fs-5 fw-bold-sm"><i
                                class="bi bi-box-arrow-in-down me-2"></i>Import
                            Data</button>
                    </div>
                </form>

            </div>
            <div class="card-footer text-muted">
                <small>Ensure your data is clean before importing to avoid errors.</small>
            </div>
        </div>
    </div>
    </div>
    @endsection
@section('scripts')
<script>
    // Custom JavaScript can be added here
</script>
@endsection