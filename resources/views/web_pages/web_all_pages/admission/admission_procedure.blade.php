@extends('web_layouts.app')
@section('content')
    
    <!-- Header Start -->
    <div
      class="jumbotron jumbotron-fluid page-header position-relative mb-5"
      style="margin-bottom: 50px"
    >
      <div class="container text-center py-5">
        <h1 class="text-white display-3">Admission Procedure</h1>
        <div class="d-inline-flex text-white mb-5">
          <p class="m-0 text-uppercase">
            <a class="text-white" href="{{route('web.index')}}">Home</a>
          </p>
          <i class="fa fa-angle-double-right pt-1 px-3"></i>
          <p class="m-0 text-uppercase">Admission Procedure</p>
        </div>
      </div>
    </div>
    <!-- Header End -->

    <!-- Admission Procedure Section Start -->
    <div class="container">
      <div class="row">
        <div class="col-md-4">
          <img src="{{asset('website/assets/img/admission_procedure.jpg')}}" alt="" class="img-fluid img-thumbnail" />
        </div>
        <div class="col-md-8">
          <h3 class="about-head">Admission Procedure</h3>
          <p class="about-para">
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab porro
            neque expedita autem ratione laborum ipsam blanditiis qui, adipisci
            voluptas voluptate rem voluptates consectetur laudantium hic quo sit
            repellendus odio? Lorem ipsum dolor sit amet consectetur adipisicing
            elit. Dolor esse quisquam doloribus! Eligendi, sint saepe.
          </p>
          <h5>The following documents must be submitted at the time of admission:-</h5>
            <ol class="list-group list-group-numbered ml-4">
                <li>Admission form</li>
                <li>10th Marksheet</li>
                <li>12th Marksheet</li>
                <li>Transfer Certificate</li>
                <li>Passport size Photograph</li>
                <li>10th Marksheet</li>
                <li>12th Marksheet</li>
                <li>Transfer Certificate</li>
                <li>Passport size Photograph</li>
            </ol>
        </div>
      </div>
    </div>

    <!-- Admission Procedure Section End -->
@endsection