@extends('web_layouts.app')
@section('content')
    
    <!-- Header Start -->
    <div
      class="jumbotron jumbotron-fluid page-header position-relative mb-5"
      style="margin-bottom: 50px"
    >
      <div class="container text-center py-5">
        <h1 class="text-white display-3">Our School Facilities</h1>
        <div class="d-inline-flex text-white mb-5">
          <p class="m-0 text-uppercase">
            <a class="text-white" href="{{route('web.index')}}">Home</a>
          </p>
          <i class="fa fa-angle-double-right pt-1 px-3"></i>
          <p class="m-0 text-uppercase">Our School Facilities</p>
        </div>
      </div>
    </div>
    <!-- Header End -->

    <!-- Computer Lab Section Start -->
    <div class="container mb-5 pb-5 mt-5 pt-5">
      <div class="row ">
        <div class="col-md-4">
          <img src="{{asset('website/assets/img/facility/computerroom.jpg')}}" alt="" class="img-fluid img-thumbnail" />
        </div>
        <div class="col-md-8">
          <h3 id="computer_lab" class="about-head">Computer Lab</h3>
          <p class="about-para">
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab porro
            neque expedita autem ratione laborum ipsam blanditiis qui, adipisci
            voluptas voluptate rem voluptates consectetur laudantium hic quo sit
            repellendus odio? Lorem ipsum dolor sit amet consectetur adipisicing
            elit. Dolor esse quisquam doloribus! Eligendi, sint saepe.
          </p>
        </div>
      </div>
    </div>
    <!-- Computer Lab Section End -->

    <!-- Library Section Start -->
    <div class="container mb-5 pb-5 mt-5 pt-5">
      <div class="row ">
        <div class="col-md-4">
          <img src="{{asset('website/assets/img/facility/library.jpg')}}" alt="" class="img-fluid img-thumbnail" />
        </div>
        <div class="col-md-8">
          <h3 id="library" class="about-head">Library</h3>
          <p class="about-para">
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab porro
            neque expedita autem ratione laborum ipsam blanditiis qui, adipisci
            voluptas voluptate rem voluptates consectetur laudantium hic quo sit
            repellendus odio? Lorem ipsum dolor sit amet consectetur adipisicing
            elit. Dolor esse quisquam doloribus! Eligendi, sint saepe.
          </p>
        </div>
      </div>
    </div>
    <!-- Library Section End -->

    <!-- science_lab Section Start -->
    <div class="container mb-5 pb-5 mt-5 pt-5">
      <div class="row ">
        <div class="col-md-4">
          <img src="{{asset('website/assets/img/facility/sciencelab.jpg')}}" alt="" class="img-fluid img-thumbnail" />
        </div>
        <div class="col-md-8">
          <h3 id="science_lab" class="about-head">Science Lab</h3>
          <p class="about-para">
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab porro
            neque expedita autem ratione laborum ipsam blanditiis qui, adipisci
            voluptas voluptate rem voluptates consectetur laudantium hic quo sit
            repellendus odio? Lorem ipsum dolor sit amet consectetur adipisicing
            elit. Dolor esse quisquam doloribus! Eligendi, sint saepe.
          </p>
        </div>
      </div>
    </div>
    <!-- science_lab Section End -->

    <!-- transport Section Start -->
    <div class="container mb-5 pb-5 mt-5 pt-5">
      <div class="row ">
        <div class="col-md-4">
          <img src="{{asset('website/assets/img/facility/schoolbus.jpg')}}" alt="" class="img-fluid img-thumbnail" />
        </div>
        <div class="col-md-8">
          <h3 id="transport" class="about-head">Transport</h3>
          <p class="about-para">
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab porro
            neque expedita autem ratione laborum ipsam blanditiis qui, adipisci
            voluptas voluptate rem voluptates consectetur laudantium hic quo sit
            repellendus odio? Lorem ipsum dolor sit amet consectetur adipisicing
            elit. Dolor esse quisquam doloribus! Eligendi, sint saepe.
          </p>
        </div>
      </div>
    </div>
    <!-- transport Section End -->
@endsection