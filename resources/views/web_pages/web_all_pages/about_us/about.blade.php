@extends('web_layouts.app')
@section('content')
    
    <!-- Header Start -->
    <div class="jumbotron jumbotron-fluid page-header position-relative mb-5 " style="margin-bottom: 50px;">
        <div class="container text-center py-5">
            <h1 class="text-white display-1">About</h1>
            <div class="d-inline-flex text-white mb-5">
                <p class="m-0 text-uppercase"><a class="text-white" href="{{route('web.index')}}">Home</a></p>
                <i class="fa fa-angle-double-right pt-1 px-3"></i>
                <p class="m-0 text-uppercase">About</p>
            </div>
        </div>
    </div>
    <!-- Header End -->

    <!-- About Section Start -->
     <div class="container">
         <div class="row">
             <div class="col-md-12">
                 <h2 class="about-head">About Our School</h2>
                 <p class="about-para">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab porro neque expedita autem ratione laborum ipsam blanditiis qui, adipisci voluptas voluptate rem voluptates consectetur laudantium hic quo sit repellendus odio? Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolor esse quisquam doloribus! Eligendi, sint saepe.</p>
                 <p class="about-para">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab porro neque expedita autem ratione laborum ipsam blanditiis qui? Lorem ipsum dolor sit, amet consectetur adipisicing elit. Culpa, quisquam?</p>
             </div>
             <hr>
             <div class="col-md-6">
                 <h2 class="about-head">Our Vision</h2>
                 <p class="about-para">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab porro neque expedita autem ratione laborum ipsam blanditiis qui, adipisci voluptas voluptate rem voluptates consectetur laudantium hic quo sit repellendus odio? Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolor esse quisquam doloribus! Eligendi, sint saepe.</p>
             </div>
                <div class="col-md-6">
                    <h2 class="about-head">Our Mission</h2>
                    <p class="about-para">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab porro neque expedita autem ratione laborum ipsam blanditiis qui, adipisci voluptas voluptate rem voluptates consectetur laudantium hic quo sit repellendus odio? Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolor esse quisquam doloribus! Eligendi, sint saepe.</p>
                </div>
         </div>
     </div>

    <!-- About Section End -->
@endsection