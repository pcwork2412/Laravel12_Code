@extends('layouts.app')
@section('content')
    <div class="card tab-box my-4 shadow-sm">
        <div class="row user-tabs">
            <div class="col-12 line-tabs">
                <ul class="nav nav-tabs nav-tabs-bottom" role="tablist">
                    <li class="nav-item">
                        <a href="#class" data-bs-toggle="tab" class="nav-link active" role="tab">Class Name</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="card-body bg-light">
            {{-- Master Sections Start --}}
            <div class="tab-content p-3">
                <div class="tab-pane show active" id="class" role="tabpanel">
                    @include('Masters.class', ['stdClasses' => $stdClasses ?? []])
                </div>
            </div>
            {{-- Master Sections End --}}
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('pos/assets/js/CustomJS/Master/classNameAjax.js') }}"></script>
@endpush
