@extends('web_layouts.app')
@section('content')
    <!-- Header Start -->
    <div class="jumbotron jumbotron-fluid page-header position-relative mb-5 " style="margin-bottom: 50px;">
        <div class="container text-center py-5">
            <h1 class="text-white display-1">Video Gallery</h1>
            <div class="d-inline-flex text-white mb-5">
                <p class="m-0 text-uppercase"><a class="text-white" href="{{ route('web.index') }}">Home</a></p>
                <i class="fa fa-angle-double-right pt-1 px-3"></i>
                <p class="m-0 text-uppercase">Video Gallery</p>
            </div>
        </div>
    </div>
    <!-- Header End -->

    <!-- Video Gallery Section Start -->
   <section class="gallery-block compact-gallery py-5">
    <div class="container">
        <div class="row g-3 justify-content-evenly">
            <div class="col-sm-6 col-md-4 col-lg-3 item img-box">
            
            </div>
        </div>
    </div>
</section>
    <!-- Video Gallery Section End -->
@endsection
