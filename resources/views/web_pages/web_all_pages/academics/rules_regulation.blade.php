@extends('web_layouts.app')
@section('content')
    <!-- Header Start -->
    <div class="jumbotron jumbotron-fluid page-header position-relative mb-5" style="margin-bottom: 50px">
        <div class="container text-center py-5">
            <h1 class="text-white display-1">Rules & Regulations</h1>
            <div class="d-inline-flex text-white mb-5">
                <p class="m-0 text-uppercase">
                    <a class="text-white" href="{{ route('web.index') }}">Home</a>
                </p>
                <i class="fa fa-angle-double-right pt-1 px-3"></i>
                <p class="m-0 text-uppercase">Rules & Regulations</p>
            </div>
        </div>
    </div>
    <!-- Header End -->

    <!-- Rules & Regulations Section Start -->
    <div class="container-fluid">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card border-0">
                        <div class="card-header">
                            <h3 class="mb-0 text-center">Rules & Regulations</h3>
                        </div>
                        <div class="card-body">
                            <div class="pdf-container">

                                <object data="{{ asset('website/assets/pdf/School_Rules_and_Regulations.pdf') }}"
                                    type="application/pdf" width="100%" height="600">
                                    <p>
                                        Browser Not Supporting PDF View
                                        <a href="{{ asset('website/assets/pdf/School_Rules_and_Regulations.pdf') }}"
                                            target="_blank" rel="noopener">Click Here To Show Preview / download</a>
                                    </p>
                                </object>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Rules & Regulations Section End -->
@endsection
