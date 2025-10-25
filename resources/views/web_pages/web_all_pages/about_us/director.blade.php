@extends('web_layouts.app')
@section('content')
    
    <!-- Header Start -->
    <div
      class="jumbotron jumbotron-fluid page-header position-relative mb-5"
      style="margin-bottom: 50px"
    >
      <div class="container text-center py-5">
        <h1 class="text-white display-3">Academic Director`s Profile</h1>
        <div class="d-inline-flex text-white mb-5">
          <p class="m-0 text-uppercase">
            <a class="text-white" href="{{route('web.index')}}">Home</a>
          </p>
          <i class="fa fa-angle-double-right pt-1 px-3"></i>
          <p class="m-0 text-uppercase">Academic Director`s Profile</p>
        </div>
      </div>
    </div>
    <!-- Header End -->

    <!-- Director Content Section Start -->
    <div class="container">
      <div class="row">
        <div class="col-md-4">
          <img src="{{asset('website/assets/img/teacher/team-2.jpg')}}" alt="" class="img-fluid img-thumbnail" />
        </div>
        <div class="col-md-8">
          <h3 class="about-head">Academic Director`s Profile</h3>
          <p class="about-para">
            "Ms. Geetika Gupta is a future oriented educationalist who believes
            in effective and quality education that keeps evolving with the
            changing times."
          </p>
          <p class="about-para">
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab porro
            neque expedita autem ratione laborum ipsam blanditiis qui, adipisci
            voluptas voluptate rem voluptates consectetur laudantium hic quo sit
            repellendus odio? Lorem ipsum dolor sit amet consectetur adipisicing
            elit. Dolor esse quisquam doloribus! Eligendi, sint saepe.
          </p>
          <p class="about-para">
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab porro
            neque expedita autem ratione laborum ipsam blanditiis qui, adipisci
            voluptas voluptate rem voluptates consectetur laudantium hic quo sit
            repellendus odio? Lorem ipsum dolor sit amet consectetur adipisicing
            elit. Dolor esse quisquam doloribus! Eligendi, sint saepe.
          </p>
          <p class="about-para">
            Lorem ipsum dolor, sit amet consectetur adipisicing elit. Nam, vel?
            ipsum dolor sit amet, consectetur adipisicing elit. Ab porro neque
            expedita autem ratione laborum ipsam blanditiis qui, adipisci
            voluptas voluptate rem voluptates consectetur laudantium hic quo sit
            repellendus odio? Lorem ipsum dolor sit amet consectetur adipisicing
            elit. Dolor esse quisquam doloribus! Eligendi, sint saepe.
          </p>
          <p class="about-para">
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid
            quis vitae laudantium dolores laborum sunt! ipsum dolor sit amet,
            consectetur adipisicing elit. Ab porro neque expedita autem ratione
            laborum ipsam blanditiis qui, adipisci voluptas voluptate rem
            voluptates consectetur laudantium hic quo sit repellendus odio?
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolor esse
            quisquam doloribus! Eligendi, sint saepe.
          </p>
          <p class="about-para">
            Ms. Geetika Gupta <br>(Academic Director)<br> BA, B.Ed, M.Ed, MA English
            Literature
          </p>
        </div>
        <div class="col-md-12">
            <h2 class="text-center mt-5 mb-3" >Awards & Achievements</h2>
            <div class="row mb-5">
                <div class="col-md-3 award-img">
                    <img src="{{asset('website/assets/img/awards/award-1.jpg')}} " alt="" class="img-fluid img-thumbnail">
                </div>
                <div class="col-md-3 award-img">
                    <img src="{{asset('website/assets/img/awards/award-2.jpg')}}" alt="" class="img-fluid img-thumbnail">
                </div>
                <div class="col-md-3 award-img">
                    <img src="{{asset('website/assets/img/awards/award-3.jpg')}}" alt="" class="img-fluid img-thumbnail">
                </div>
                <div class="col-md-3 award-img">
                    <img src="{{asset('website/assets/img/awards/award-4.jpg')}} " alt="" class="img-fluid img-thumbnail">
                </div>
                <div class="col-md-3 award-img">
                    <img src="{{asset('website/assets/img/awards/award-5.jpg')}}" alt="" class="img-fluid img-thumbnail">
                </div>
                <div class="col-md-3 award-img">
                    <img src="{{asset('website/assets/img/awards/award-5.jpg')}}" alt="" class="img-fluid img-thumbnail">
                </div>
            </div>
            <div class="row mb-5">
            </div>
        </div>
      </div>
    </div>

    <!-- Director Content Section End -->
@endsection