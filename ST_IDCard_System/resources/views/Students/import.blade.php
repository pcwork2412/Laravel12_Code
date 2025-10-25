@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="col-md-12 d-flex justify-content-between ">
          <h3 class="mb-4">Import Students from Excel/CSV</h3>
      <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    <a href="{{ route('students.index') }}" class="btn btn-primary"><i class="bi bi-arrow-left-circle me-1"></i>Student List</a>
                </div>
    </div>

    {{-- Success and Error Messages --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('students.import') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label class="form-label">Choose Excel / CSV file</label>
            <input type="file" name="file" class="form-control" accept=".xlsx,.xls,.csv" required>
            @error('file') <div class="text-danger mt-1">{{ $message }}</div> @enderror
        </div>

        <button class="btn btn-primary">Import</button>
    </form>
@endsection
@section('scripts')
<script>
    // Custom JavaScript can be added here
</script>
@endsection