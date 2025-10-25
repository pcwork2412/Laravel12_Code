@extends('web_layouts.app')

@section('content')
  
    <!-- Header Start -->
    <div class="jumbotron jumbotron-fluid page-header position-relative mb-5 " style="margin-bottom: 50px;">
        <div class="container text-center py-5">
            <h1 class="text-white display-1">EXAMINATION SYSTEM</h1>
            <div class="d-inline-flex text-white mb-5">
                <p class="m-0 text-uppercase"><a class="text-white" href="{{route('web.index')}}">Home</a></p>
                <i class="fa fa-angle-double-right pt-1 px-3"></i>
                <p class="m-0 text-uppercase">EXAMINATION SYSTEM</p>
            </div>
        </div>
    </div>
    <!-- Header End -->

    <!--Examination-system Section Start -->
     <div class="container">
         <div class="row">
             <div class="col-md-12">
                 <h2 class="about-head">Examination System</h2>
                 <ol>
                    <li class="about-para" >Lorem ipsum dolor sit amet consectetur adipisicing elit. Illo, aut. ipsum dolor sit amet consectetur adipisicing elit. Nesciunt, harum?</li>
                    <li class="about-para" >Lorem ipsum dolor sit amet. ipsum dolor sit amet consectetur adipisicing . Nesciunt, harum?</li>
                    <li class="about-para" >Lorem ipsum dolor sit amet. ipsum dolor sit amet consectetur  elit. Nesciunt, harum?</li>
                    <li class="about-para" >Lorem ipsum dolor sit amet. ipsum dolor sit amet consectetur </li>
                 </ol>
             </div>
         </div>
     </div>

    <!--Examination-system Section End -->

@endsection