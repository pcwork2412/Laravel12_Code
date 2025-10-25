@extends('web_layouts.app')
@section('content')
    <!-- Header Start -->
    <div class="jumbotron jumbotron-fluid page-header position-relative mb-5" style="margin-bottom: 50px">
        <div class="container text-center py-5">
            <h1 class="text-white display-3">Inquiry Form</h1>
            <div class="d-inline-flex text-white mb-5">
                <p class="m-0 text-uppercase">
                    <a class="text-white" href="{{ route('web.index') }}">Home</a>
                </p>
                <i class="fa fa-angle-double-right pt-1 px-3"></i>
                <p class="m-0 text-uppercase">Inquiry Form</p>
            </div>
        </div>
    </div>
    <!-- Header End -->

    <!-- Inquiry Form Section Start -->
    <!-- School Inquiry Form Section -->
<section id="school-inquiry" class="py-5 bg-light">
  <div class="container">
    <div class="row justify-content-center mb-4">
      <div class="col-lg-8 text-center">
        <h2 class="fw-bold text-primary">Class Inquiry Form</h2>
        <p class="text-muted">Fill the form below for admissions or general queries</p>
      </div>
    </div>

    <div class="row justify-content-center">
      <div class="col-lg-6">
        <div class="card shadow-sm border-0 rounded-3">
          <div class="card-body p-4">
            <form>
              <!-- Name -->
              <div class="mb-3">
                <label class="form-label">Full Name</label>
                <input type="text" class="form-control" placeholder="Enter your name" required>
              </div>

              <!-- Email -->
              <div class="mb-3">
                <label class="form-label">Email Address</label>
                <input type="email" class="form-control" placeholder="Enter your email" required>
              </div>

              <!-- Phone -->
              <div class="mb-3">
                <label class="form-label">Phone Number</label>
                <input type="tel" class="form-control" placeholder="Enter your phone number" required>
              </div>

              <!-- Class Selection -->
              <div class="mb-3">
                <label class="form-label">Apply for Class</label>
                <select class="form-select form-control">
                  <option selected disabled>Select class</option>
                  <option>Nursery</option>
                  <option>Class 1</option>
                  <option>Class 5</option>
                  <option>Class 9</option>
                  <option>Class 12</option>
                </select>
              </div>

              <!-- Message -->
              <div class="mb-3">
                <label class="form-label">Message</label>
                <textarea class="form-control" rows="3" placeholder="Write your query here"></textarea>
              </div>

              <!-- Submit -->
              <div class="d-grid">
                <button type="submit" class="btn btn-primary btn-lg">Submit Inquiry</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

    <!-- Inquiry Form Section End -->
@endsection
