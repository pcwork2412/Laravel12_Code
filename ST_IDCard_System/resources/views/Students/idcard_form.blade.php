@extends('layouts.app')

@section('content')
    <div class="card tab-box my-4 shadow-sm">
        <div class="card-body bg-light">
            <div class="row d-flex align-items-center">
                <div class="col-md-8">
                    <h4 class="mb-0">Generate Student ID Card</h4>
                </div>
                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    <a href="{{ route('students.index') }}" class="btn btn-primary"><i class="bi bi-arrow-left-circle me-1"></i>Student List</a>
                </div>
            </div>
            <hr>
              @php
    @endphp
            <form action="{{ route('students.generateidcard') }}" method="POST" class="row g-3">
                @csrf
                
                <div class="col-md-6">
                    <label class="form-label">Select Class</label>
                    <select name="class_name" id="class_name" class="form-select rounded-3 shadow-sm">
                        <option value="">Select Class</option>
                        @foreach($classes as $class)
                        <option value="{{ $class->class_name }}">{{ $class->class_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 d-flex align-items-end">
                    <button type="submit" name="action" value="preview" class="btn btn-success me-2"><i class="bi bi-card-text me-1"></i>Preview ID Card</button>
                    <button type="submit" name="action" value="generate" class="btn btn-danger"><i class="bi bi-card-text me-1"></i>Generate ID Card</button>
                </div>
            </form>
        </div>
    </div>
    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $err)
                <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
@endif

@endsection