@extends('web_layouts.app')
@section('content')

    <!-- Header Start -->
    <div
      class="jumbotron jumbotron-fluid page-header position-relative mb-5"
      style="margin-bottom: 50px"
    >
      <div class="container text-center py-5">
        <h1 class="text-white display-3">Activities</h1>
        <div class="d-inline-flex text-white mb-5">
          <p class="m-0 text-uppercase">
            <a class="text-white" href="{{route('web.index')}}">Home</a>
          </p>
          <i class="fa fa-angle-double-right pt-1 px-3"></i>
          <p class="m-0 text-uppercase">Activities</p>
        </div>
      </div>
    </div>
    <!-- Header End -->

    <!-- Sports Section Start -->
    <div class="container ">
      <div class="row">
        <div class="col-md-12">
          <h3 id="sports" class="about-head pt-5 mt-5 ">Sports</h3>
          <p class="about-para">
            "Ms. Geetika Gupta is a future oriented educationalist who believes
            in effective and Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eius itaque iste beatae. Consectetur tempora labore similique. Cumque dignissimos expedita odit. quality education that keeps evolving with the Lorem ipsum dolor sit amet consectetur adipisicing elit. Minima nobis quia repellat ipsa neque, est soluta porro asperiores libero error!
            changing times."
          </p>
        </div>
        <div class="col-md-12">
            <div class="row mb-5">
                <div class="col-md-3 global-fit-img">
                    <img src="{{asset('website/assets/img/awards/award-1.jpg')}} " alt="" class="img-fluid img-thumbnail">
                    <div class="activity-title text-center p-1">Indoor Games</div>
                </div>
                <div class="col-md-3 global-fit-img">
                    <img src="{{asset('website/assets/img/awards/award-2.jpg')}}" alt="" class="img-fluid img-thumbnail">
                    <div class="activity-title text-center p-1">Indoor Games</div>
                </div>
                <div class="col-md-3 global-fit-img">
                    <img src="{{asset('website/assets/img/awards/award-3.jpg')}}" alt="" class="img-fluid img-thumbnail">
                    <div class="activity-title text-center p-1">Indoor Games</div>
                </div>
                <div class="col-md-3 global-fit-img">
                    <img src="{{asset('website/assets/img/awards/award-4.jpg')}} " alt="" class="img-fluid img-thumbnail">
                    <div class="activity-title text-center p-1">Indoor Games</div>
                </div>
            </div>
            <div class="row mb-5">
            </div>
        </div>
      </div>
    </div>
    <!-- Sports Section End -->

    
    <!-- Competitions Section Start -->
    <div class="container ">
      <div class="row">
        <div class="col-md-12">
          <h3 id="competition" class="about-head pt-5 mt-5 ">Competitions</h3>
          <p class="about-para">
            "Ms. Geetika Gupta is a future oriented educationalist who believes
            in effective and Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eius itaque iste beatae. Consectetur tempora labore similique. Cumque dignissimos expedita odit. quality education that keeps evolving with the Lorem ipsum dolor sit amet consectetur adipisicing elit. Minima nobis quia repellat ipsa neque, est soluta porro asperiores libero error!
            changing times."
          </p>
        </div>
        <div class="col-md-12">
            <div class="row mb-5">
                <div class="col-md-3 global-fit-img">
                    <img src="{{asset('website/assets/img/awards/award-1.jpg')}} " alt="" class="img-fluid img-thumbnail">
                    <div class="activity-title text-center p-1">Indoor Games</div>
                </div>
                <div class="col-md-3 global-fit-img">
                    <img src="{{asset('website/assets/img/awards/award-2.jpg')}}" alt="" class="img-fluid img-thumbnail">
                    <div class="activity-title text-center p-1">Indoor Games</div>
                </div>
                <div class="col-md-3 global-fit-img">
                    <img src="{{asset('website/assets/img/awards/award-3.jpg')}}" alt="" class="img-fluid img-thumbnail">
                    <div class="activity-title text-center p-1">Indoor Games</div>
                </div>
                <div class="col-md-3 global-fit-img">
                    <img src="{{asset('website/assets/img/awards/award-4.jpg')}} " alt="" class="img-fluid img-thumbnail">
                    <div class="activity-title text-center p-1">Indoor Games</div>
                </div>
            </div>
            <div class="row mb-5">
            </div>
        </div>
      </div>
    </div>
    <!-- Competitions Section End -->

     <!-- Celebrations Section Start -->
    <div class="container ">
      <div class="row">
        <div class="col-md-12">
          <h3 id="celebration" class="about-head pt-5 mt-5">Celebrations</h3>
          <p class="about-para">
            "Ms. Geetika Gupta is a future oriented educationalist who believes
            in effective and Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eius itaque iste beatae. Consectetur tempora labore similique. Cumque dignissimos expedita odit. quality education that keeps evolving with the Lorem ipsum dolor sit amet consectetur adipisicing elit. Minima nobis quia repellat ipsa neque, est soluta porro asperiores libero error!
            changing times."
          </p>
        </div>
        <div class="col-md-12">
            <div class="row mb-5">
                <div class="col-md-3 global-fit-img">
                    <img src="{{asset('website/assets/img/awards/award-1.jpg')}} " alt="" class="img-fluid img-thumbnail">
                    <div class="activity-title text-center p-1">Indoor Games</div>
                </div>
                <div class="col-md-3 global-fit-img">
                    <img src="{{asset('website/assets/img/awards/award-2.jpg')}}" alt="" class="img-fluid img-thumbnail">
                    <div class="activity-title text-center p-1">Indoor Games</div>
                </div>
                <div class="col-md-3 global-fit-img">
                    <img src="{{asset('website/assets/img/awards/award-3.jpg')}}" alt="" class="img-fluid img-thumbnail">
                    <div class="activity-title text-center p-1">Indoor Games</div>
                </div>
                <div class="col-md-3 global-fit-img">
                    <img src="{{asset('website/assets/img/awards/award-4.jpg')}} " alt="" class="img-fluid img-thumbnail">
                    <div class="activity-title text-center p-1">Indoor Games</div>
                </div>
            </div>
            <div class="row mb-5">
            </div>
        </div>
      </div>
    </div>
    <!-- Celebrations Section End -->


     <!-- Education & Fun Trips Section Start -->
    <div class="container ">
      <div class="row">
        <div class="col-md-12">
          <h3 id="trip" class="about-head pt-5 mt-5">Education & Fun Trips</h3>
          <p class="about-para">
            "Ms. Geetika Gupta is a future oriented educationalist who believes
            in effective and Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eius itaque iste beatae. Consectetur tempora labore similique. Cumque dignissimos expedita odit. quality education that keeps evolving with the Lorem ipsum dolor sit amet consectetur adipisicing elit. Minima nobis quia repellat ipsa neque, est soluta porro asperiores libero error!
            changing times."
          </p>
        </div>
        <div class="col-md-12">
            <div class="row mb-5">
                <div class="col-md-3 global-fit-img">
                    <img src="{{asset('website/assets/img/awards/award-1.jpg')}} " alt="" class="img-fluid img-thumbnail">
                    <div class="activity-title text-center p-1">Indoor Games</div>
                </div>
                <div class="col-md-3 global-fit-img">
                    <img src="{{asset('website/assets/img/awards/award-2.jpg')}}" alt="" class="img-fluid img-thumbnail">
                    <div class="activity-title text-center p-1">Indoor Games</div>
                </div>
                <div class="col-md-3 global-fit-img">
                    <img src="{{asset('website/assets/img/awards/award-3.jpg')}}" alt="" class="img-fluid img-thumbnail">
                    <div class="activity-title text-center p-1">Indoor Games</div>
                </div>
                <div class="col-md-3 global-fit-img">
                    <img src="{{asset('website/assets/img/awards/award-4.jpg')}} " alt="" class="img-fluid img-thumbnail">
                    <div class="activity-title text-center p-1">Indoor Games</div>
                </div>
            </div>
            <div class="row mb-5">
            </div>
        </div>
      </div>
    </div>
    <!-- Education & Fun Trips Section End -->

     <!-- Counselling & Health Checkup Section Start -->
    <div class="container ">
      <div class="row">
        <div class="col-md-12">
          <h3 id="health_camp" class="about-head pt-5 mt-5">Counselling & Health Checkup</h3>
          <p class="about-para">
            "Ms. Geetika Gupta is a future oriented educationalist who believes
            in effective and Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eius itaque iste beatae. Consectetur tempora labore similique. Cumque dignissimos expedita odit. quality education that keeps evolving with the Lorem ipsum dolor sit amet consectetur adipisicing elit. Minima nobis quia repellat ipsa neque, est soluta porro asperiores libero error!
            changing times."
          </p>
        </div>
        <div class="col-md-12">
            <div class="row mb-5">
                <div class="col-md-3 global-fit-img">
                    <img src="{{asset('website/assets/img/awards/award-1.jpg')}} " alt="" class="img-fluid img-thumbnail">
                    <div class="activity-title text-center p-1">Indoor Games</div>
                </div>
                <div class="col-md-3 global-fit-img">
                    <img src="{{asset('website/assets/img/awards/award-2.jpg')}}" alt="" class="img-fluid img-thumbnail">
                    <div class="activity-title text-center p-1">Indoor Games</div>
                </div>
                <div class="col-md-3 global-fit-img">
                    <img src="{{asset('website/assets/img/awards/award-3.jpg')}}" alt="" class="img-fluid img-thumbnail">
                    <div class="activity-title text-center p-1">Indoor Games</div>
                </div>
                <div class="col-md-3 global-fit-img">
                    <img src="{{asset('website/assets/img/awards/award-4.jpg')}} " alt="" class="img-fluid img-thumbnail">
                    <div class="activity-title text-center p-1">Indoor Games</div>
                </div>
            </div>
            <div class="row mb-5">
            </div>
        </div>
      </div>
    </div>
    <!-- Counselling & Health Checkup Section End -->

     <!-- Social Useful Activities Section Start -->
    <div class="container ">
      <div class="row">
        <div class="col-md-12">
          <h3 id="social_work" class="about-head pt-5 mt-5">Social Useful Activities</h3>
          <p class="about-para">
            "Ms. Geetika Gupta is a future oriented educationalist who believes
            in effective and Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eius itaque iste beatae. Consectetur tempora labore similique. Cumque dignissimos expedita odit. quality education that keeps evolving with the Lorem ipsum dolor sit amet consectetur adipisicing elit. Minima nobis quia repellat ipsa neque, est soluta porro asperiores libero error!
            changing times."
          </p>
        </div>
        <div class="col-md-12">
            <div class="row mb-5">
                <div class="col-md-3 global-fit-img">
                    <img src="{{asset('website/assets/img/awards/award-1.jpg')}} " alt="" class="img-fluid img-thumbnail">
                    <div class="activity-title text-center p-1">Indoor Games</div>
                </div>
                <div class="col-md-3 global-fit-img">
                    <img src="{{asset('website/assets/img/awards/award-2.jpg')}}" alt="" class="img-fluid img-thumbnail">
                    <div class="activity-title text-center p-1">Indoor Games</div>
                </div>
                <div class="col-md-3 global-fit-img">
                    <img src="{{asset('website/assets/img/awards/award-3.jpg')}}" alt="" class="img-fluid img-thumbnail">
                    <div class="activity-title text-center p-1">Indoor Games</div>
                </div>
                <div class="col-md-3 global-fit-img">
                    <img src="{{asset('website/assets/img/awards/award-4.jpg')}} " alt="" class="img-fluid img-thumbnail">
                    <div class="activity-title text-center p-1">Indoor Games</div>
                </div>
            </div>
            <div class="row mb-5">
            </div>
        </div>
      </div>
    </div>
    <!-- Social Useful Activities Section End -->

    
@endsection