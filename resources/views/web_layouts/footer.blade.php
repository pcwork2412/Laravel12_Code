   <!-- Footer Start -->
   <div class="container-fluid position-relative bg-dark text-white-50 py-5" style="margin-top: 90px">
       <div class="container mt-5 pt-5">
           <div class="row">
               <div class="col-md-6 mb-5">
                   <a href="index.html" class="navbar-brand">
                       <h1 class="mt-n2 text-uppercase text-white">
                           <i class="fa fa-book-reader mr-3"></i>Edukate
                       </h1>
                   </a>
                   <p class="m-0">
                       Accusam nonumy clita sed rebum kasd eirmod elitr. Ipsum ea lorem
                       at et diam est, tempor rebum ipsum sit ea tempor stet et
                       consetetur dolores. Justo stet diam ipsum lorem vero clita diam
                   </p>
               </div>
               <div class="col-md-6 mb-5">
                   <h3 class="text-white mb-4">Newsletter</h3>
                   <div class="w-100">
                       <form action="{{ route('news_letter.store') }}" method="post">
                           @csrf

                           <div class="input-group">
                               <input type="text" name="newsletter_email" class="form-control" style="padding: 30px"
                                   placeholder="Your Email Address" value="{{ old('newsletter_email') }}" />

                               <div class="input-group-append">
                                   <button type="submit" class="btn btn-primary px-4">Sign Up</button>
                               </div>
                           </div>

                           {{-- Error message for email --}}
                           @error('newsletter_email')
                               <div class="text-danger mt-1">{{ $message }}</div>
                           @enderror
                           {{-- Success message for email --}}
                           @if (session('success_email'))
                               <div class="text-success mt-1">{{ session('success_email') }}</div>
                           @endif

                       </form>

                   </div>
               </div>
           </div>
           <div class="row g-5 d-flex justify-content-between align-items-center">
               <div class="col-xl-3 col-lg-4 col-md-6 mb-5">
                   <h3 class="text-white mb-4">Get In Touch</h3>
                   <p>
                       <i class="fa fa-map-marker-alt mr-2"></i>2259/ Indra Nagar,<br> Bhrampuri,Meerut 250002,<br>Uttar
                       Pradesh
                   </p>
                   <p><i class="fa fa-phone-alt mr-2"></i>+91 9012863339</p>
                   <p><i class="fa fa-envelope mr-2"></i>info@techrlp.co.in</p>
                   <div class="d-flex justify-content-start mt-4">
                       <a class="text-white mr-4" href="#"><i class="fab fa-2x fa-twitter"></i></a>
                       <a class="text-white mr-4" href="#"><i class="fab fa-2x fa-facebook-f"></i></a>
                       <a class="text-white mr-4" href="#"><i class="fab fa-2x fa-linkedin-in"></i></a>
                       <a class="text-white" href="#"><i class="fab fa-2x fa-instagram"></i></a>
                   </div>
               </div>
               <div class="col-xl-3 col-lg-4 col-md-6 mb-5">
                   <h3 class="text-white mb-4">About Us</h3>
                   <div class="d-flex flex-column justify-content-start">
                       <a class="text-white-50 mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>About Us</a>
                       <a class="text-white-50 mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Founder`s
                           Chairman`s
                           Profile</a>
                       <a class="text-white-50 mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Manager`s
                           Profile</a>
                       <a class="text-white-50 mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Academic
                           Director`s
                           Profile</a>
                       <a class="text-white-50" href="#"><i class="fa fa-angle-right mr-2"></i>Principle`s
                           Profile</a>
                   </div>
               </div>
               <div class="col-xl-3 col-lg-4 col-md-6 mb-5">
                   <h3 class="text-white mb-4">Admission</h3>
                   <div class="d-flex flex-column justify-content-start">
                       <a class="text-white-50 mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Admission
                           Procedure</a>
                       <a class="text-white-50 mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Amdmission
                           Form</a>
                       <a class="text-white-50 mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Prospectus</a>
                       <a class="text-white-50 mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>School Fee</a>
                   </div>
               </div>
               <div class="col-xl-3 col-lg-4 col-md-6 mb-5">
                   <h3 class="text-white mb-4">Facilities</h3>
                   <div class="d-flex flex-column justify-content-start">
                       <a class="text-white-50 mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Library</a>
                       <a class="text-white-50 mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Science
                           Lab</a>
                       <a class="text-white-50 mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Computer
                           Lab</a>
                       <a class="text-white-50 mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Transport</a>
                   </div>
               </div>
           </div>
       </div>
   </div>
   <div class="container-fluid bg-dark text-white-50 border-top py-4"
       style="border-color: rgba(256, 256, 256, 0.1) !important">
       <div class="container">
           <div class="row">
               <div class="col-md-12 text-center mb-3 mb-md-0">
                   <p class="m-0">
                       Copyright &copy;
                       <a class="text-white" href="#">@techrlp.co.in</a>. All Rights
                       Reserved.
                   </p>
               </div>
               {{-- <div class="col-md-6 text-center text-md-right">
                   <p class="m-0">
                       Designed by
                       <a class="text-white" href="https://htmlcodex.com">HTML Codex</a>
                       Distributed by
                       <a href="https://themewagon.com" target="_blank">ThemeWagon</a>
                   </p>
               </div> --}}
           </div>
       </div>
   </div>
   <!-- Footer End -->

   <!-- Back to Top -->
   <a href="#" class=" btn btn-lg btn-primary rounded-1 btn-lg-square back-to-top">
       <i class="fa fa-angle-double-up"></i></a>

   <script>
       < script src = "https://cdn.jsdelivr.net/npm/sweetalert2@11" >
   </>

   </script>
