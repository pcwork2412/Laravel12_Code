@extends('web_layouts.app')
@section('content')
    <!-- Header Start -->
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active"
                style="background-image: url('{{ asset('website/assets/img/banner/banner-3.jpg') }}')"></div>
            <div class="carousel-item"
                style="background-image: url('{{ asset('website/assets/img/banner/banner-4.jpg') }}')"></div>
            <div class="carousel-item"
                style="background-image: url('{{ asset('website/assets/img/banner/banner-1.jpg') }}')"></div>
        </div>

        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>

    <!-- Header End -->

    <!-- Quick Access Section Start -->
    <div class="container">
        <div class="row">
            <!-- Card 1 -->
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="quick-card h-100 text-center p-4">
                    <div class="icon-wrapper mb-3">
                        <i class="fa-solid fa-pen-to-square fa-2x"></i>
                    </div>
                    <h5 class="fw-bold">Admission Form</h5>
                    <p class="text-muted small mb-3">Apply for new admission online.</p>
                    <a href="#" class="btn btn-gradient w-100">
                        Download Now <i class="fa-solid fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="quick-card h-100 text-center p-4">
                    <div class="icon-wrapper mb-3">
                        <i class="fa-solid fa-building fa-2x"></i>
                    </div>
                    <h5 class="fw-bold">Prospectus</h5>
                    <p class="text-muted small mb-3">
                        Know more about our institution.
                    </p>
                    <a href="{{route('admission.prospectus')}}" class="btn btn-gradient w-100">
                        View Prospectus <i class="fa-solid fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="quick-card h-100 text-center p-4">
                    <div class="icon-wrapper mb-3">
                        <i class="fa-solid fa-camera-retro fa-2x"></i>
                    </div>
                    <h5 class="fw-bold">Photo Gallery</h5>
                    <p class="text-muted small mb-3">Explore memorable moments.</p>
                    <a href="{{route('gallery.photo_gallery')}}" class="btn btn-gradient w-100">
                        View Gallery <i class="fa-solid fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>

            <!-- Card 4 -->
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="quick-card h-100 text-center p-4">
                    <div class="icon-wrapper mb-3">
                        <i class="fa-solid fa-envelope fa-2x"></i>
                    </div>
                    <h5 class="fw-bold">Inquiry Form</h5>
                    <p class="text-muted small mb-3">Get in touch with us today.</p>
                    <a href="{{route('admission.inquiry_form')}}" class="btn btn-gradient w-100">
                        Fill Form <i class="fa-solid fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- Quick Access Section End -->

    <!-- Introduction Section Start -->
    <div class="container-fluid mt-5 p-5 bg-dark">
        <div class="row justify-content-center align-items-center">
            <!-- Left Column -->
            <div class="col-sm-12 col-md-12 col-lg-9 col-xl-7 p-4">
                <h3 class="mb-3 text-white">OUR INTRODUCTION</h3>
                <p class="text-white cap-text">
                    Lorem ipsum dolor, sit amet consectetur adipisicing elit. Facere
                    pariatur ipsa harum architecto? Nisi magnam, eaque laudantium
                    adipisci inventore doloribus! Pariatur minus tempora perspiciatis
                    aliquid illo non possimus Lorem ipsum dolor sit amet, consectetur
                    adipisicing elit. Vitae quidem omnis eaque dolores laudantium cumque
                    quas modi ipsam repellendus voluptates!.
                </p>
                <p class="text-white pt-3 cap-text">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolores
                    doloribus minus explicabo odit repellat officia assumenda dicta
                    nulla, eius aliquid! Lorem ipsum dolor sit amet consectetur
                    adipisicing elit. Totam, veritatis.
                </p>
            </div>

            <!-- Right Column -->
            <div class="col-sm-12 col-md-8 col-lg-9 col-xl-5 p-4">
                <h3 class="mb-3 text-white">SCHOOL NOTICE BOARD</h3>

                <div class="notice-board bg-white shadow rounded overflow-hidden">
                    <h3 class="text-secondary p-1 border-bottom">Important Notice</h3>

                    <!-- Scrollable Notice List -->
                    <div class="notice-list">
                        <ul class="list-unstyled mb-0">
                            <li>
                                <strong>Teacher’s Day:</strong> Celebration in auditorium
                                lorem20
                                <small class="text-muted d-block">
                                    <i class="fa-solid fa-calendar-days text-success"></i> 05
                                    Sep 2025 |
                                    <i class="fa-solid fa-clock text-success"></i> 10:00
                                    AM</small>
                            </li>
                            <li>
                                <i class="bi bi-trophy text-success me-2"></i>
                                <strong>Sports Day:</strong> Annual sports meet
                                <small class="text-muted d-block">
                                    <i class="fa-solid fa-calendar-days text-success"></i> 05
                                    Sep 2025 |
                                    <i class="fa-solid fa-clock text-success"></i> 10:00
                                    AM</small>
                            </li>
                            <li>
                                <i class="bi bi-mic text-danger me-2"></i>
                                <strong>Annual Function:</strong> Chief guest arrival
                                <small class="text-muted d-block">
                                    <i class="fa-solid fa-calendar-days text-success"></i> 05
                                    Sep 2025 |
                                    <i class="fa-solid fa-clock text-success"></i> 10:00
                                    AM</small>
                            </li>
                            <li>
                                <i class="bi bi-bell text-warning me-2"></i>
                                <strong>Holiday Notice:</strong> School closed tomorrow
                                <small class="text-muted d-block">
                                    <i class="fa-solid fa-calendar-days text-success"></i> 05
                                    Sep 2025 |
                                    <i class="fa-solid fa-clock text-success"></i> 10:00
                                    AM</small>
                            </li>
                            <li>
                                <i class="bi bi-book text-info me-2"></i>
                                <strong>Exam Schedule:</strong> Mid-term exams start
                                <small class="text-muted d-block">
                                    <i class="fa-solid fa-calendar-days text-success"></i> 05
                                    Sep 2025 |
                                    <i class="fa-solid fa-clock text-success"></i> 10:00
                                    AM</small>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Introduction Section End -->

    <!-- Our Facilities Section Start -->
    {{-- <div class="container-fluid">
        <div class="container">
            <div class="section-title text-center position-relative mt-5">
                <h6 class="d-inline-block position-relative text-secondary text-uppercase pb-2">
                    FACILITIES
                </h6>
                <h1 class="display-4">See Our Facilities</h1>
            </div>
        </div>
    </div>
    <div class="container d-flex justify-content-center align-items-center mb-5">
        <div class="owl-carousel facilities-carousel" style="padding: 5px; margin: 10px 25px">
            <!-- Iteam 1 -->
            <div class="facilities-item rounded overflow-visible text-white">
                <div class="row h-100">
                    <!-- Content Left Side -->
                    <div class="col-md-7 d-flex align-items-center">
                        <div class="facility-content">
                            <h5 class="text-danger">Library</h5>
                            <p class="facility-text text-dark">
                                Lorem ipsum, dolor sit amet consectetur adipisicing elit.
                                Consequuntur aperiam, eveniet magnam reiciendis repellat quam
                                est amet delectus deleniti nemo et maiores hic ab blanditiis
                                nulla similique, eaque harum placeat?
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Image Right Side Overflow -->
                <div class="facility-img">
                    <img class="img-fluid" src="{{asset('website/assets/img/facility/library.jpg')}}" alt="Libarary" />
                </div>
                <!-- Button bottom Side Overflow -->
                <div class="facility-btn">
                    <button type="button" class="btn btn-primary">
                        Read More <i class="fa-solid fa-arrow-right"></i>
                    </button>
                </div>
            </div>
            <!-- Iteam 2 -->
            <div class="facilities-item rounded overflow-visible text-white">
                <div class="row h-100">
                    <!-- Content Left Side -->
                    <div class="col-md-7 d-flex align-items-center">
                        <div class="facility-content">
                            <h5 class="text-danger">School Transport</h5>
                            <p class="facility-text text-dark">
                                Lorem ipsum, dolor sit amet consectetur adipisicing elit.
                                Consequuntur aperiam, eveniet magnam reiciendis repellat quam
                                est amet delectus deleniti nemo et maiores hic ab blanditiis
                                nulla similique, eaque harum placeat?
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Image Right Side Overflow -->
                <div class="facility-img">
                    <img class="img-fluid w-100" src="{{asset('website/assets/img/facility/schoolbus.jpg')}}" alt="School Transport" />
                </div>
                <!-- Button bottom Side Overflow -->
                <div class="facility-btn">
                    <button type="button" class="btn btn-primary">
                        Read More <i class="fa-solid fa-arrow-right"></i>
                    </button>
                </div>
            </div>
            <!-- Iteam 3 -->
            <div class="facilities-item rounded overflow-visible text-white">
                <div class="row h-100">
                    <!-- Content Left Side -->
                    <div class="col-md-7 d-flex align-items-center">
                        <div class="facility-content">
                            <h5 class="text-danger">Computer Lab</h5>
                            <p class="facility-text text-dark">
                                Lorem ipsum, dolor sit amet consectetur adipisicing elit.
                                Consequuntur aperiam, eveniet magnam reiciendis repellat quam
                                est amet delectus deleniti nemo et maiores hic ab blanditiis
                                nulla similique, eaque harum placeat?
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Image Right Side Overflow -->
                <div class="facility-img">
                    <img class="img-fluid w-100" src="{{asset('website/assets/img/facility/computerroom.jpg')}}" alt="Computer Lab" />
                </div>
                <!-- Button bottom Side Overflow -->
                <div class="facility-btn">
                    <button type="button" class="btn btn-primary">
                        Read More <i class="fa-solid fa-arrow-right"></i>
                    </button>
                </div>
            </div>
            <!-- Iteam 4 -->
            <div class="facilities-item rounded overflow-visible text-white">
                <div class="row h-100">
                    <!-- Content Left Side -->
                    <div class="col-md-7 d-flex align-items-center">
                        <div class="facility-content">
                            <h5 class="text-danger">Science Lab</h5>
                            <p class="facility-text text-dark">
                                Lorem ipsum, dolor sit amet consectetur adipisicing elit.
                                Consequuntur aperiam, eveniet magnam reiciendis repellat quam
                                est amet delectus deleniti nemo et maiores hic ab blanditiis
                                nulla similique, eaque harum placeat?
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Image Right Side Overflow -->
                <div class="facility-img">
                    <img class="img-fluid w-100" src="{{asset('website/assets/img/facility/sciencelab.jpg')}}" alt="Science Lab" />
                </div>
                <!-- Button bottom Side Overflow -->
                <div class="facility-btn">
                    <button type="button" class="btn btn-primary">
                        Read More <i class="fa-solid fa-arrow-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </div> --}}
    <!-- Our Facilities Section End -->

    <!-- Teacher Section Start -->
    <div class="container-fluid py-1">
        <div class="container py-5">
            <div class="section-title text-center position-relative mb-5">
                <h6 class="d-inline-block position-relative text-secondary text-uppercase pb-2">
                    Teachers
                </h6>
                <h1 class="display-4">Meet Our Teachers</h1>
            </div>
            <div class="owl-carousel team-carousel position-relative" style="padding: 0 30px">
                <div class="team-item">
                    <img class="img-fluid w-100" src="{{ asset('website/assets/img/teacher/team-1.jpg') }}"
                        alt="" />
                    <div class="bg-light text-center p-4">
                        <h5 class="mb-3">Instructor Name</h5>
                        <p class="mb-2">Web Design & Development</p>
                        <div class="d-flex justify-content-center">
                            <a class="mx-1 p-1" href="#"><i class="fab fa-twitter"></i></a>
                            <a class="mx-1 p-1" href="#"><i class="fab fa-facebook-f"></i></a>
                            <a class="mx-1 p-1" href="#"><i class="fab fa-linkedin-in"></i></a>
                            <a class="mx-1 p-1" href="#"><i class="fab fa-instagram"></i></a>
                            <a class="mx-1 p-1" href="#"><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>
                </div>
                <div class="team-item">
                    <img class="img-fluid w-100" src="{{ asset('website/assets/img/teacher/team-2.jpg') }}"
                        alt="" />
                    <div class="bg-light text-center p-4">
                        <h5 class="mb-3">Instructor Name</h5>
                        <p class="mb-2">Web Design & Development</p>
                        <div class="d-flex justify-content-center">
                            <a class="mx-1 p-1" href="#"><i class="fab fa-twitter"></i></a>
                            <a class="mx-1 p-1" href="#"><i class="fab fa-facebook-f"></i></a>
                            <a class="mx-1 p-1" href="#"><i class="fab fa-linkedin-in"></i></a>
                            <a class="mx-1 p-1" href="#"><i class="fab fa-instagram"></i></a>
                            <a class="mx-1 p-1" href="#"><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>
                </div>
                <div class="team-item">
                    <img class="img-fluid w-100" src="{{ asset('website/assets/img/teacher/team-3.jpg') }}"
                        alt="" />
                    <div class="bg-light text-center p-4">
                        <h5 class="mb-3">Instructor Name</h5>
                        <p class="mb-2">Web Design & Development</p>
                        <div class="d-flex justify-content-center">
                            <a class="mx-1 p-1" href="#"><i class="fab fa-twitter"></i></a>
                            <a class="mx-1 p-1" href="#"><i class="fab fa-facebook-f"></i></a>
                            <a class="mx-1 p-1" href="#"><i class="fab fa-linkedin-in"></i></a>
                            <a class="mx-1 p-1" href="#"><i class="fab fa-instagram"></i></a>
                            <a class="mx-1 p-1" href="#"><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>
                </div>
                <div class="team-item">
                    <img class="img-fluid w-100" src="{{ asset('website/assets/img/teacher/team-4.jpg') }}"
                        alt="" />
                    <div class="bg-light text-center p-4">
                        <h5 class="mb-3">Instructor Name</h5>
                        <p class="mb-2">Web Design & Development</p>
                        <div class="d-flex justify-content-center">
                            <a class="mx-1 p-1" href="#"><i class="fab fa-twitter"></i></a>
                            <a class="mx-1 p-1" href="#"><i class="fab fa-facebook-f"></i></a>
                            <a class="mx-1 p-1" href="#"><i class="fab fa-linkedin-in"></i></a>
                            <a class="mx-1 p-1" href="#"><i class="fab fa-instagram"></i></a>
                            <a class="mx-1 p-1" href="#"><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Teacher Section End -->
@endsection
