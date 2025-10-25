@extends('web_layouts.app')
@section('content')

    <!-- Header Start -->
    <div class="jumbotron jumbotron-fluid page-header position-relative " style="margin-bottom: 50px;">
        <div class="container text-center py-5">
            <h1 class="text-white display-1">School Deatil`s</h1>
            <div class="d-inline-flex text-white mb-5">
                <p class="m-0 text-uppercase"><a class="text-white" href="{{route('web.index')}}">Home</a></p>
                <i class="fa fa-angle-double-right pt-1 px-3"></i>
                <p class="m-0 text-uppercase">School Deatil`s</p>
            </div>
        </div>
    </div>
    <!-- Header End -->


    <!-- School Detail Section Start -->
    <div class="container-fluid">
        <div class="container ">
            <h1 class="about-head text-center mb-5">Our School Deatil`s</h1>
            <div class="row d-flex justify-content-between align-items-center">
                <div class="col-lg-5 mb-5 mb-lg-0">
                    <div class="bg-light p-4" >
                        <div class="d-flex align-items-center ">
                            <div class="btn-icon bg-primary mr-4">
                                <i class="fa fa-2x fa-users text-white"></i>
                            </div>
                            <div class="mt-n1">
                                <h4>All Teacher`s List</h4>
                                <a href="#" class="text-primary font-weight-medium"><i class="fa-solid fa-eye"></i> View List </a>
                            </div>
                        </div>
                    </div>
                </div>
                 <div class="col-lg-5 mb-5 mb-lg-0">
                    <div class="bg-light p-4" >
                        <div class="d-flex align-items-center ">
                            <div class="btn-icon bg-primary mr-4">
                                <i class="fa fa-2x fa-book text-white"></i>
                            </div>
                            <div class="mt-n1">
                                <h4>All Book`s List</h4>
                                <a href="#" class="text-primary font-weight-medium"><i class="fa-solid fa-eye"></i> View List </a>
                            </div>
                        </div>
                    </div>
                </div>
              
            </div>
        </div>
    </div>
    <!-- School Detail Section End -->


    
@endsection