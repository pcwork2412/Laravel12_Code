@extends('web_layouts.app')
@section('content')
    <!-- Header Start -->
    <div class="jumbotron jumbotron-fluid page-header position-relative mb-5" style="margin-bottom: 50px">
        <div class="container text-center py-5">
            <h1 class="text-white display-3">Admission Form</h1>
            <div class="d-inline-flex text-white mb-5">
                <p class="m-0 text-uppercase">
                    <a class="text-white" href="{{ route('web.index') }}">Home</a>
                </p>
                <i class="fa fa-angle-double-right pt-1 px-3"></i>
                <p class="m-0 text-uppercase">Admission Form</p>
            </div>
        </div>
    </div>
    <!-- Header End -->


    <!-- Admission Form Section Start -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-11">
                    <div class="card shadow-lg border-0 rounded-4">
                        <div class="card-body text-center p-5">
                            <h2 class="fw-bold text-primary mb-3">
                                Admission Form
                            </h2>
                            <p class="text-muted mb-4">
              Please save the admission form, fill it carefully and submit it along with the required documents.
            </p>
                            {{-- <a href="{{route('admission_form_pdf')}}" download 
               class="btn btn-lg btn-primary rounded-pill shadow-sm px-4 py-2">
              <i class="fa fa-download me-2"></i> Download Form
            </a> --}}


                            <object data="{{ asset('website/assets/pdf/School_admission_form.pdf') }}"
                                type="application/pdf" width="100%" height="600">
                                <p>
                                    Browser Not Supporting PDF View
                                    <a href="{{ asset('website/assets/pdf/School_admission_form.pdf') }}"
                                        target="_blank" rel="noopener">Click Here To Show Preview / download</a>
                                </p>
                            </object>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Admission Form Section End -->
@endsection
