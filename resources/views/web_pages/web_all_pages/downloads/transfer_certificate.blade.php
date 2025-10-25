@extends('web_layouts.app')
@section('content')
    <!-- Header Start -->
    <div class="jumbotron jumbotron-fluid page-header position-relative mb-5 " style="margin-bottom: 50px;">
        <div class="container text-center py-5">
            <h1 class="text-white display-1">Transfer Certificate</h1>
            <div class="d-inline-flex text-white mb-5">
                <p class="m-0 text-uppercase"><a class="text-white" href="{{ route('web.index') }}">Home</a></p>
                <i class="fa fa-angle-double-right pt-1 px-3"></i>
                <p class="m-0 text-uppercase">Transfer Certificate</p>
            </div>
        </div>
    </div>
    <!-- Header End -->

    <!-- Transfer Certificate Section Start -->
    <section class="tc-section py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-7">
                    <div class="tc-card p-4 border rounded-4">
                        <h2 class="text-center mb-4 fw-bold text-gradient">Transfer Certificate Form</h2>
                        <form action="">
                            <div class="mb-3">
                                <label for="std_name" class="form-label fw-semibold">Enter Student Name</label>
                                <input class="form-control form-control-lg" type="text" id="std_name">
                            </div>
                            <div class="mb-3">
                                <label for="adm_no" class="form-label fw-semibold">Enter Admission Number</label>
                                <input class="form-control form-control-lg" type="text" id="adm_no">
                            </div>
                            <button type="submit" class="btn btn-gradient w-100 py-2 fw-semibold">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Transfer Certificate Section End -->
@endsection
