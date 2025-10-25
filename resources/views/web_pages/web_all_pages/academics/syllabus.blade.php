@extends('web_layouts.app')
@section('content')
    <!-- Header Start -->
    <div class="jumbotron jumbotron-fluid page-header position-relative mb-5 " style="margin-bottom: 50px;">
        <div class="container text-center py-5">
            <h1 class="text-white display-3">School Syllabus</h1>
            <div class="d-inline-flex text-white mb-5">
                <p class="m-0 text-uppercase"><a class="text-white" href="{{route('web.index')}}">Home</a></p>
                <i class="fa fa-angle-double-right pt-1 px-3"></i>
                <p class="m-0 text-uppercase">School Syllabus</p>
            </div>
        </div>
    </div>
    <!-- Header End -->

    <!-- Syllabus Section Start -->
    <div class="container mb-5">
        <div class="row">
            <div class="col-md-4">
                <img src="{{asset('website/assets/img/syllabus/syllabus-1.jpg')}}" alt="" class="img-fluid img-thumbnail">
            </div>
            <div class="col-md-8">
                <h3 class="about-head">Academic</h3>
                <p class="about-para">Lorem ipsum dolor sit amet consectetur adipisicing elit. Ullam aliquam architecto
                    placeat facilis voluptatibus nihil beatae est possimus porro, expedita dignissimos ab corrupti. Officiis
                    sed nemo consequatur facere perspiciatis provident! ipsum dolor sit amet, consectetur adipisicing elit.
                    Ab porro neque expedita autem ratione laborum ipsam blanditiis qui, adipisci voluptas voluptate rem
                    voluptates consectetur laudantium hic quo sit repellendus odio? Lorem ipsum dolor sit amet consectetur
                    adipisicing elit. Dolor esse quisquam doloribus! Eligendi, sint saepe.</p>
            </div>
        </div>
    </div>
    <div class="container my-5">
        <div class="row">
            <div class="col-md-4">
                <img src="{{asset('website/assets/img/syllabus/syllabus-2.jpg')}}" alt="" class="img-fluid img-thumbnail">
            </div>
            <div class="col-md-8">
                <h3 class="about-head">Co-Curricular</h3>
                <p class="about-para">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Neque repudiandae nihil
                    aperiam sint, reprehenderit nam ipsa dolorum commodi quam dicta. ipsum dolor sit amet, consectetur
                    adipisicing elit. Ab porro neque expedita autem ratione laborum ipsam blanditiis qui, adipisci voluptas
                    voluptate rem voluptates consectetur laudantium hic quo sit repellendus odio? Lorem ipsum dolor sit amet
                    consectetur adipisicing elit. Dolor esse quisquam doloribus! Eligendi, sint saepe.</p>
            </div>
        </div>
    </div>

    <!-- Syllabus Section End -->
@endsection
