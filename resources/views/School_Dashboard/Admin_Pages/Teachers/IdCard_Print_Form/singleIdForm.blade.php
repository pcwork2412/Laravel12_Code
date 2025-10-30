@extends('School_Dashboard.Admin_Layouts.app')

@section('content')
    <div class="container">
        <div class="card tab-box my-4 shadow-sm">
        <div class="card-header bg-primary text-white d-flex align-items-center">
            <div class="col-md-8">
                <h3 class="mb-0"><i class="fa fa-user"></i> Generate Individual Teacher ID Card</h3>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <a href="{{ route('teachers.index') }}" class="btn btn-white"><i class="fa fa-list me-2"></i>Teacher List</a>
            </div>
        </div>
        <div class="card-body bg-light">

            <form action="{{ route('teachers.genIdCardSingle') }}" method="POST" target="_blank" class="row g-3">
                @csrf

                <!-- Teacher ID -->
                <div class="col-md-6">
                    <label class="form-label">Teacher ID</label>

                    <select name="teacher_id" id="teacher_id" value="{{ old('teacher_id') }}"
                        class="form-select rounded-3 shadow-sm">
                        <option value="">Select Teacher</option>
                        @foreach ($teachers as $item)
                            <option value="{{ $item->teacher_id }}">{{ $item->teacher_name }}({{ $item->teacher_id }})
                            </option>
                        @endforeach
                    </select>
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
    {{-- Error Message --}}
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
