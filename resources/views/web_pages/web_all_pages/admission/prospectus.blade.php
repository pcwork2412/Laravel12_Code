@extends('web_layouts.app')
@section('content')
    <!-- Header Start -->
    <div class="jumbotron jumbotron-fluid page-header position-relative mb-5" style="margin-bottom: 50px">
        <div class="container text-center py-5">
            <h1 class="text-white display-3">School Prospectus</h1>
            <div class="d-inline-flex text-white mb-5">
                <p class="m-0 text-uppercase">
                    <a class="text-white" href="{{ route('web.index') }}">Home</a>
                </p>
                <i class="fa fa-angle-double-right pt-1 px-3"></i>
                <p class="m-0 text-uppercase">School Prospectus</p>
            </div>
        </div>
    </div>
    <!-- Header End -->
    <!-- ===================== -->
    <!-- WHAT WE OFFER SECTION -->
    <!-- ===================== -->
    <section id="what-we-offer" class="container my-5">
        <div class="row align-items-center">
            <!-- LEFT: Image -->
            <div class="col-lg-6 mb-4 mb-lg-0">
                <img src="{{ asset('website/assets/img/school_prospectus.jpg') }}" alt="School Image"
                    class="img-fluid rounded shadow-sm w-100 h-100">
            </div>

            <!-- RIGHT: Content -->
            <div class="col-lg-6">
                <h2 class="mb-3">What We Offer</h2>
                <p class="text-muted">
                    Balanced academics, modern labs, sports and leadership programs to prepare students for the future.
                </p>

                <!-- Custom Accordion Replacement -->
                <div class="custom-accordion">
                    <!-- Curriculum -->
                    <div class="custom-accordion-item mb-2">
                        <div class="custom-accordion-header d-flex align-items-center bg-light p-3 rounded"
                            style="cursor:pointer;" onclick="toggleAccordion('curriculum')">
                            <span class="flex-grow-1">Curriculum (K-12)</span>
                            <span id="icon-curriculum" class="fa fa-chevron-down"></span>
                        </div>
                        <div id="body-curriculum" class="custom-accordion-body"
                            style="display:none;overflow:hidden;transition:max-height 0.5s cubic-bezier(.4,0,.2,1);max-height:0;">
                            <ul class="pl-4 py-2 mb-0">
                                <li><strong>Primary:</strong> Foundation literacy & numeracy</li>
                                <li><strong>Middle:</strong> Science labs + project-based learning</li>
                                <li><strong>Senior:</strong> Streams: Science, Commerce, Arts</li>
                            </ul>
                        </div>
                    </div>
                    <!-- Facilities -->
                    <div class="custom-accordion-item mb-2">
                        <div class="custom-accordion-header d-flex align-items-center bg-light p-3 rounded"
                            style="cursor:pointer;" onclick="toggleAccordion('facilities')">
                            <span class="flex-grow-1">Facilities</span>
                            <span id="icon-facilities" class="fa fa-chevron-down"></span>
                        </div>
                        <div id="body-facilities" class="custom-accordion-body"
                            style="display:none;overflow:hidden;transition:max-height 0.5s cubic-bezier(.4,0,.2,1);max-height:0;">
                            <ul class="pl-4 py-2 mb-0">
                                <li>Smart Classrooms</li>
                                <li>Computer & Science Labs</li>
                                <li>Sports Grounds & Indoor Gym</li>
                                <li>Library & Music Room</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- CTA -->
                <div class="mt-3">
                    <a href="#visit" class="btn btn-secondary btn-lg btn-block">Schedule a Visit</a>
                </div>
            </div>
        </div>
    </section>


    <!-- ===================== -->
    <!-- PROSPECTUS SECTION -->
    <!-- ===================== -->
    <section id="school-prospectus" class="container my-5 pt-5">
        <div class="row">
            <!-- LEFT: Intro + Highlights -->
            <div class="col-lg-6 mb-4 mb-lg-0">
                <div class="p-4 bg-light rounded shadow-sm">
                    <h2 class="mb-2">Sunrise Public School — Prospectus 2025</h2>
                    <p class="text-muted mb-3">
                        A modern learning environment with strong values, experienced faculty and all-round development
                        programmes for students from Nursery to Class 12.
                    </p>

                    <!-- Key Points -->
                    <div class="row mb-3">
                        <div class="col-6 d-flex">
                            <div class="mr-2"><i class="fa fa-award text-primary"></i></div>
                            <div>
                                <strong>Experienced Teachers</strong><br>
                                <small class="text-muted">Qualified & caring staff</small>
                            </div>
                        </div>
                        <div class="col-6 d-flex">
                            <div class="mr-2"><i class="fa fa-book text-success"></i></div>
                            <div>
                                <strong>Holistic Curriculum</strong><br>
                                <small class="text-muted">STEM, Arts & Sports</small>
                            </div>
                        </div>
                    </div>

                    <!-- CTA Buttons -->
                    <div class="mb-3">
                        <button class="btn btn-primary" data-toggle="modal" data-target="#prospectusModal">
                            <i class="fa fa-download mr-2"></i>Download Prospectus (PDF)
                        </button>
                        <a href="#admission-form" class="btn btn-outline-primary">
                            <i class="fa fa-pencil mr-2"></i>Apply Now
                        </a>
                        <a href="#contact-school" class="btn btn-light border">
                            <i class="fa fa-phone mr-2"></i>Contact Us
                        </a>
                    </div>
                </div>

                <!-- Quick facts -->
                <div class="row mt-3">
                    <div class="col-4">
                        <div class="card p-2 text-center border">
                            <div class="h5 font-weight-bold">1500+</div>
                            <small class="text-muted">Students</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="card p-2 text-center border">
                            <div class="h5 font-weight-bold">120</div>
                            <small class="text-muted">Experienced Staff</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="card p-2 text-center border">
                            <div class="h5 font-weight-bold">40+</div>
                            <small class="text-muted">Activities</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- RIGHT: School image -->
            <div class="col-lg-6 d-flex align-items-center">
                <img src="{{ asset('website/assets/img/school_prospectus.jpg') }}" alt="School Building"
                    class="img-fluid rounded shadow-sm w-100 h-100">
            </div>
        </div>
    </section>


    <!-- ===================== -->
    <!-- ADMISSION PROCESS -->
    <!-- ===================== -->
    <section id="admission-process" class="py-5" style="background: linear-gradient(120deg, #f8fafc 60%, #e3f2fd 100%);">
        <div class="container-fluid">
            <div class="row justify-content-center mb-4">
                <div class="col-lg-8 text-center">
                    <h3 class="font-weight-bold text-primary mb-2">Admission Process</h3>
                    <p class="text-muted mb-0">Simple steps to join Sunrise Public School</p>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="d-flex flex-wrap justify-content-center">
                        <div class="text-center p-4 bg-white shadow-sm m-2"
                            style="min-width:180px; border-radius: 0.9rem;">
                            <div class="bg-primary text-white mb-2 mx-auto font-weight-bold"
                                style="width:48px;height:48px;line-height:48px;border-radius:50%;">1</div>
                            <div class="font-weight-semibold mb-1">Enquiry</div>
                            <small class="text-muted">Call or fill form</small>
                        </div>
                        <div class="text-center p-4 bg-white shadow-sm m-2"
                            style="min-width:180px; border-radius: 0.9rem;">
                            <div class="bg-primary text-white mb-2 mx-auto font-weight-bold"
                                style="width:48px;height:48px;line-height:48px;border-radius:50%;">2</div>
                            <div class="font-weight-semibold mb-1">Submit Documents</div>
                            <small class="text-muted">Birth cert, previous marks</small>
                        </div>
                        <div class="text-center p-4 bg-white shadow-sm m-2"
                            style="min-width:180px; border-radius: 0.9rem;">
                            <div class="bg-primary text-white mb-2 mx-auto font-weight-bold"
                                style="width:48px;height:48px;line-height:48px;border-radius:50%;">3</div>
                            <div class="font-weight-semibold mb-1">Interview/Test</div>
                            <small class="text-muted">Assessment or meeting</small>
                        </div>
                        <div class="text-center p-4 bg-white shadow-sm m-2"
                            style="min-width:180px; border-radius: 0.9rem;">
                            <div class="bg-primary text-white mb-2 mx-auto font-weight-bold"
                                style="width:48px;height:48px;line-height:48px;border-radius:50%;">4</div>
                            <div class="font-weight-semibold mb-1">Fee Payment</div>
                            <small class="text-muted">Confirm seat</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- ===================== -->
    <!-- FEE SNAPSHOT -->
    <!-- ===================== -->
    <section class="fee_snapshot py-5">
        <div class="row justify-content-center mb-4">
            <div class="col-lg-8 text-center">
                <h3 class="font-weight-bold text-primary mb-2">Admission Snapshot</h3>
                <p class="text-muted mb-0">Transparent and affordable fee structure for all classes</p>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow border-0 p-4 mb-3" style="border-radius: 1rem;">
                    <div class="card-body">
                        <h4 class="card-title mb-4 text-primary font-weight-bold">
                            <i class="fa fa-money mr-2"></i>Fee Structure Overview
                        </h4>
                        <table class="table table-borderless mb-0">
                            <tbody>
                                <tr>
                                    <td class="font-weight-semibold py-3">
                                        <i class="fa fa-user-plus text-success mr-2"></i>Registration Fee
                                    </td>
                                    <td class="text-right text-primary h5 py-3">₹500</td>
                                </tr>
                                <tr class="bg-light">
                                    <td class="font-weight-semibold py-3">
                                        <i class="fa fa-book text-info mr-2"></i>Tuition (Monthly)
                                    </td>
                                    <td class="text-right text-primary h5 py-3">₹4,500</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-semibold py-3">
                                        <i class="fa fa-calendar text-warning mr-2"></i>Annual Charges
                                    </td>
                                    <td class="text-right text-primary h5 py-3">₹6,000</td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="text-right mt-3">
                            <span class="badge badge-info px-3 py-2 shadow-sm" style="font-size: 0.95rem;">
                                <i class="fa fa-info-circle mr-1"></i>
                                *Detailed fee breakup available on request
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Modal Bootstrap 4 -->
    <div class="modal fade" id="prospectusModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">School Prospectus - Preview</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <iframe src="https://example.com/prospectus.pdf" width="100%" height="600"
                        style="border:none"></iframe>
                </div>
                <div class="modal-footer">
                    <a href="https://example.com/prospectus.pdf" class="btn btn-primary" download>Download PDF</a>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        function toggleAccordion(id) {
            var body = document.getElementById('body-' + id);
            var icon = document.getElementById('icon-' + id);
            var isOpen = body.style.display === 'block' || body.style.maxHeight && body.style.maxHeight !== '0px';

            // Close all
            document.querySelectorAll('.custom-accordion-body').forEach(function(el) {
                el.style.display = 'none';
                el.style.maxHeight = '0';
            });
            document.querySelectorAll('.custom-accordion-header .fa').forEach(function(el) {
                el.classList.remove('fa-chevron-up');
                el.classList.add('fa-chevron-down');
            });

            // Toggle current
            if (!isOpen) {
                body.style.display = 'block';
                body.style.maxHeight = body.scrollHeight + 'px';
                icon.classList.remove('fa-chevron-down');
                icon.classList.add('fa-chevron-up');
            }
        }

        // On page load, reset all accordion bodies
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.custom-accordion-body').forEach(function(el) {
                el.style.display = 'none';
                el.style.maxHeight = '0';
            });
        });
    </script>
@endpush
