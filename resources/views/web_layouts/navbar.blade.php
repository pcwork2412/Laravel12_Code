<!-- Topbar Start -->
<div class="container-fluid bg-dark">
    <div class="d-flex flex-wrap justify-content-between align-items-center py-2 px-3 px-lg-5">
        <div class="col-auto text-white small d-flex align-items-center mb-2 mb-md-0">
            <i class="fa fa-phone-alt me-2"></i> +91 9012863339
            <span class="px-2">|</span>
            <i class="fa fa-envelope me-2"></i> info@techrlp.co.in
        </div>
        <div class="col-auto">
            {{-- <a href="{{ route('student.register') }}" class="btn btn-outline-primary btn-sm me-2">Register</a> --}}
            <a href="{{ route('admin.login') }}" class="btn btn-primary btn-sm">Login</a>
        </div>
    </div>
</div>
<!-- Topbar End -->

<!-- Topbar End -->

<!-- Navbar Start -->
<div class="container-fluid p-0">
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm py-3 py-lg-0 px-3 px-lg-5">
        <a href="{{ route('web.index') }}" class="navbar-brand d-flex align-items-center">
            <i class="fa fa-book-reader me-2 text-primary"></i>
            <h1 class="m-0 h5 text-uppercase text-primary">Edukate</h1>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarCollapse">
            <ul class="navbar-nav ms-auto py-2 py-lg-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="aboutDropdown" role="button" data-bs-toggle="dropdown">About Us</a>
                    <ul class="dropdown-menu" aria-labelledby="aboutDropdown">
                        <li><a class="dropdown-item" href="{{ route('about_us.about') }}">About Us</a></li>
                        <li><a class="dropdown-item" href="{{ route('about_us.founder') }}">Founder Chairman's Profile</a></li>
                        <li><a class="dropdown-item" href="{{ route('about_us.manager') }}">Manager's Profile</a></li>
                        <li><a class="dropdown-item" href="{{ route('about_us.director') }}">Academic Director's Profile</a></li>
                        <li><a class="dropdown-item" href="{{ route('about_us.principle') }}">Principle's Profile</a></li>
                        <li><a class="dropdown-item" href="{{ route('about_us.schl_detail') }}">School Detail</a></li>
                        <li><a class="dropdown-item" href="{{ route('about_us.contact') }}">Contact Detail</a></li>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="academicsDropdown" role="button" data-bs-toggle="dropdown">Academics</a>
                    <ul class="dropdown-menu" aria-labelledby="academicsDropdown">
                        <li><a class="dropdown-item" href="{{ route('academics.schl_timing') }}">School Timings</a></li>
                        <li><a class="dropdown-item" href="{{ route('academics.rules_regulation') }}">Rules And Regulations</a></li>
                        <li><a class="dropdown-item" href="{{ route('academics.result') }}">Results</a></li>
                        <li><a class="dropdown-item" href="{{ route('academics.syllabus') }}">Syllabus</a></li>
                        <li><a class="dropdown-item" href="{{ route('academics.exam_system') }}">Examination System</a></li>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="activitiesDropdown" role="button" data-bs-toggle="dropdown">Activities</a>
                    <ul class="dropdown-menu" aria-labelledby="activitiesDropdown">
                        <li><a class="dropdown-item" href="{{ route('activities.activity') }}#sports">Sports</a></li>
                        <li><a class="dropdown-item" href="{{ route('activities.activity') }}#competition">Competitions</a></li>
                        <li><a class="dropdown-item" href="{{ route('activities.activity') }}#celebration">Celebrations</a></li>
                        <li><a class="dropdown-item" href="{{ route('activities.activity') }}#trip">Education and Fun Trips</a></li>
                        <li><a class="dropdown-item" href="{{ route('activities.activity') }}#health_camp">Counselling and Health Checkup</a></li>
                        <li><a class="dropdown-item" href="{{ route('activities.activity') }}#social_work">Social Useful Activities</a></li>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="admissionDropdown" role="button" data-bs-toggle="dropdown">Admission</a>
                    <ul class="dropdown-menu" aria-labelledby="admissionDropdown">
                        <li><a class="dropdown-item" href="{{ route('admission.admission_procedure') }}">Admission Procedure</a></li>
                        <li><a class="dropdown-item" href="{{ route('admission.inquiry_form') }}">Inquiry Form</a></li>
                        <li><a class="dropdown-item" href="{{ route('admission.admission_form') }}">Admission Form</a></li>
                        <li><a class="dropdown-item" href="{{ route('admission.prospectus') }}">Prospectus</a></li>
                        <li><a class="dropdown-item" href="{{ route('admission.school_fee') }}">School Fee Structure</a></li>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="facilitiesDropdown" role="button" data-bs-toggle="dropdown">Facilities</a>
                    <ul class="dropdown-menu" aria-labelledby="facilitiesDropdown">
                        <li><a class="dropdown-item" href="{{ route('facilities.facility') }}#computer_lab">Computer Lab</a></li>
                        <li><a class="dropdown-item" href="{{ route('facilities.facility') }}#library">Library</a></li>
                        <li><a class="dropdown-item" href="{{ route('facilities.facility') }}#science_lab">Science Lab</a></li>
                        <li><a class="dropdown-item" href="{{ route('facilities.facility') }}#transport">Transport</a></li>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="galleryDropdown" role="button" data-bs-toggle="dropdown">Gallery</a>
                    <ul class="dropdown-menu" aria-labelledby="galleryDropdown">
                        <li><a class="dropdown-item" href="{{route('gallery.photo_gallery')}}">Photo Gallery</a></li>
                        {{-- <li><a class="dropdown-item" href="{{route('gallery.media_gallery')}}">Media Gallery</a></li> --}}
                        <li><a class="dropdown-item" href="{{route('gallery.video_gallery')}}">Video Gallery</a></li>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="downloadsDropdown" role="button" data-bs-toggle="dropdown">Downloads</a>
                    <ul class="dropdown-menu" aria-labelledby="downloadsDropdown">
                        <li><a class="dropdown-item" href="{{route('downloads.transfer_certificate')}}">Transfer Certificate</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</div>
<!-- Navbar End -->

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
