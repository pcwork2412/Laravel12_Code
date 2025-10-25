@extends('web_layouts.app')
@section('content')
    <!-- Header Start -->
    <div class="jumbotron jumbotron-fluid page-header position-relative mb-5 " style="margin-bottom: 50px;">
        <div class="container text-center py-5">
            <h1 class="text-white display-1">Media Gallery</h1>
            <div class="d-inline-flex text-white mb-5">
                <p class="m-0 text-uppercase"><a class="text-white" href="{{ route('web.index') }}">Home</a></p>
                <i class="fa fa-angle-double-right pt-1 px-3"></i>
                <p class="m-0 text-uppercase">Media Gallery</p>
            </div>
        </div>
    </div>
    <!-- Header End -->

    <!-- Media Gallery Section Start -->
   <section class="gallery-block compact-gallery py-5">
    <div class="container">
        <div class="row g-3 justify-content-evenly">
            @foreach([
                'facility/schoolbus.jpg',
                'facility/library.jpg',
                'about.jpg',
                'admission_procedure.jpg',
                'school_prospectus.jpg',
                'banner/header.jpg',
            ] as $img)
            <div class="col-sm-6 col-md-4 col-lg-3 item img-box">
                <a class="lightbox d-block position-relative " href="{{ asset('website/assets/img/'.$img) }}">
                    <img class="img-thumbnail image " src="{{ asset('website/assets/img/'.$img) }}" alt="Gallery Image">
                    <div class="overlay position-absolute w-100 h-100 top-0 start-0 d-flex flex-column justify-content-center align-items-center text-white text-center p-3">
                        <h5 class="mb-2">Lorem Ipsum</h5>
                        <p class="small">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc quam urna.</p>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>
    <!-- Media Gallery Section End -->
@endsection
