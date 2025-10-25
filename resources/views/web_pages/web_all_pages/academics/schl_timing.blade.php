@extends('web_layouts.app')
@section('content')
    <!-- Header Start -->
    <div class="jumbotron jumbotron-fluid page-header position-relative mb-5 " style="margin-bottom: 50px;">
        <div class="container text-center py-5">
            <h1 class="text-white display-1">School Timings</h1>
            <div class="d-inline-flex text-white mb-5">
                <p class="m-0 text-uppercase"><a class="text-white" href="{{route('web.index')}}">Home</a></p>
                <i class="fa fa-angle-double-right pt-1 px-3"></i>
                <p class="m-0 text-uppercase">School Timings</p>
            </div>
        </div>
    </div>
    <!-- Header End -->

    <!-- School Timing Section Start -->
  <div class="container my-5">

    <!-- Student Timings -->
    <div class="mb-5">
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle text-center">
                <thead class="table-primary">
                    <tr>
                        <th colspan="2" class="fs-5 py-3 text-uppercase">Timing For Students</th>
                    </tr>
                    <tr class="table-light ">
                        <th colspan="2" class="text-dark py-2">Summer Session Timing</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Class (I–XII)</td>
                        <td>7:20 AM – 1:00 PM</td>
                    </tr>
                    <tr>
                        <td>Classes (Nursery, LKG, UKG)</td>
                        <td>7:20 AM – 12:00 PM</td>
                    </tr>
                    <tr class="table-light ">
                        <th colspan="2" class="text-dark py-2">Winter Session Timing</th>
                    </tr>
                    <tr>
                        <td>Class (I–XII)</td>
                        <td>8:20 AM – 2:00 PM</td>
                    </tr>
                    <tr>
                        <td>Classes (Nursery, LKG, UKG)</td>
                        <td>8:20 AM – 1:00 PM</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <ul class="mt-3 list-unstyled">
            <li><i class="fa-solid fa-circle-chevron-right"></i> Summer Session: 1st April – 30th September</li>
            <li><i class="fa-solid fa-circle-chevron-right"></i> Winter Session: 1st October – 31st March</li>
            <li><i class="fa-solid fa-circle-chevron-right"></i> Timings may change as per Govt. Guidelines</li>
            <li><i class="fa-solid fa-circle-chevron-right"></i> Last working day of every month will be a holiday</li>
            <li><i class="fa-solid fa-circle-chevron-right"></i> Saturday will be a full working day</li>
            <li><i class="fa-solid fa-circle-chevron-right"></i> Subject to weather conditions & District Administration orders</li>
        </ul>
    </div>

    <!-- Teacher Timings -->
    <div class="mb-5">
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle text-center">
                <thead class="table-success">
                    <tr>
                        <th colspan="2" class="fs-5 py-3 text-uppercase">Timings To Meet Teachers</th>
                    </tr>
                    <tr class="table-light ">
                        <th colspan="2" class="text-dark py-2">Office Timing</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Summer Session</td>
                        <td>8:00 AM – 2:00 PM</td>
                    </tr>
                    <tr>
                        <td>Winter Session</td>
                        <td>8:00 AM – 2:30 PM</td>
                    </tr>
                    <tr>
                        <td>Summer Vacation</td>
                        <td>8:00 AM – 2:00 PM</td>
                    </tr>
                    <tr>
                        <td>Winter Vacation</td>
                        <td>8:00 AM – 2:30 PM</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Principal Timings -->
    <div class="mb-5">
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle text-center">
                <thead class="table-warning">
                    <tr>
                        <th colspan="2" class="fs-5 py-3 text-uppercase">Timings To Meet Principal</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>All Working Days</td>
                        <td>09:30 AM – 10:30 AM</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>

    <!-- School Timing Section End -->
@endsection
