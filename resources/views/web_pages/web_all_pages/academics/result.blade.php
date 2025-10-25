@extends('web_layouts.app')
@section('content')
    <!-- Header Start -->
    <div class="jumbotron jumbotron-fluid page-header position-relative mb-5" style="margin-bottom: 50px">
        <div class="container text-center py-5">
            <h1 class="text-white display-1">Result</h1>
            <div class="d-inline-flex text-white mb-5">
                <p class="m-0 text-uppercase">
                    <a class="text-white" href="{{route('web.index')}}">Home</a>
                </p>
                <i class="fa fa-angle-double-right pt-1 px-3"></i>
                <p class="m-0 text-uppercase">Result</p>
            </div>
        </div>
    </div>
    <!-- Header End -->

    <!-- Result Section Start -->
    <div class="result-section">
        <h3 class="result-title">EXAMINATION RESULT</h3>

        <!-- Class X -->
        <table class="result-table">
            <thead>
                <tr>
                    <th colspan="6" class="sub-title">Class : X</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong>Year</strong></td>
                    <td>2019-20</td>
                    <td>2020-21</td>
                    <td>2021-22</td>
                    <td>2022-23</td>
                    <td>2023-24</td>
                </tr>
                <tr>
                    <td><strong>Pass Percentage</strong></td>
                    <td>100%</td>
                    <td>100%</td>
                    <td>100%</td>
                    <td>100%</td>
                    <td>100%</td>
                </tr>
            </tbody>
        </table>

        <!-- Class XII -->
        <table class="result-table">
            <thead>
                <tr>
                    <th colspan="6" class="sub-title">Class : XII</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong>Year</strong></td>
                    <td>2019-20</td>
                    <td>2020-21</td>
                    <td>2021-22</td>
                    <td>2022-23</td>
                    <td>2023-24</td>
                </tr>
                <tr>
                    <td><strong>Pass Percentage</strong></td>
                    <td>100%</td>
                    <td>100%</td>
                    <td>100%</td>
                    <td>95.74%</td>
                    <td>100%</td>
                </tr>
            </tbody>
        </table>
        <!-- Topper Section-1 -->
        <div class="toppers-section">
            <h3 class="toppers-title">TOPPERS - 2023-24</h3>
            <div class="row toppers-row">
                <!-- Class X -->
                <div class="col class-box class-10">
                    <h4 class="class-title">CLASS : X</h4>
                    <div class="students">
                        <div class="student mb-5">
                            <img src="{{asset('website/assets/img/teacher/team-1.jpg')}}" alt="Kanak Bhardwaj" />
                            <p class="name">Kanak Bhardwaj</p>
                            <p class="percent">96.6%</p>
                        </div>
                        <div class="student mb-5">
                            <img src="{{asset('website/assets/img/teacher/team-4.jpg')}}" alt="Daksh Sharma" />
                            <p class="name">Daksh Sharma</p>
                            <p class="percent">96.2%</p>
                        </div>
                        <div class="student mb-5">
                            <img src="{{asset('website/assets/img/teacher/team-2.jpg')}}" alt="Radhika" />
                            <p class="name">Radhika</p>
                            <p class="percent">92.8%</p>
                        </div>
                    </div>
                </div>
                <div class="middle-line"></div>
                <!-- Class XII -->
                <div class="col class-box class-12">
                    <h4 class="class-title">CLASS : XII</h4>
                    <div class="students">
                        <div class="student mb-5">
                            <img src="{{asset('website/assets/img/teacher/team-1.jpg')}}" alt="Natasha" />
                            <p class="name">Natasha</p>
                            <p class="percent">97.5%</p>
                        </div>
                        <div class="student mb-5">
                            <img src="{{asset('website/assets/img/teacher/team-2.jpg')}}" alt="Riya Rani" />
                            <p class="name">Riya Rani</p>
                            <p class="percent">95.5%</p>
                        </div>
                        <div class="student mb-5">
                            <img src="{{asset('website/assets/img/teacher/team-3.jpg')}}" alt="Dolly" />
                            <p class="name">Dolly</p>
                            <p class="percent">95.25%</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Topper Section-2 -->
        <div class="toppers-section">
            <h3 class="toppers-title">TOPPERS - 2022-23</h3>
            <div class="row toppers-row">
                <!-- Class X -->
                <div class="col class-box class-10">
                    <h4 class="class-title">CLASS : X</h4>
                    <div class="students">
                        <div class="student mb-5">
                            <img src="{{asset('website/assets/img/teacher/team-1.jpg')}}" alt="Kanak Bhardwaj" />
                            <p class="name">Kanak Bhardwaj</p>
                            <p class="percent">96.6%</p>
                        </div>
                        <div class="student mb-5">
                            <img src="{{asset('website/assets/img/teacher/team-4.jpg')}}" alt="Daksh Sharma" />
                            <p class="name">Daksh Sharma</p>
                            <p class="percent">96.2%</p>
                        </div>
                        <div class="student mb-5">
                            <img src="{{asset('website/assets/img/teacher/team-2.jpg')}}" alt="Radhika" />
                            <p class="name">Radhika</p>
                            <p class="percent">92.8%</p>
                        </div>
                    </div>
                </div>
                <div class="middle-line"></div>
                <!-- Class XII -->
                <div class="col class-box class-12">
                    <h4 class="class-title">CLASS : XII</h4>
                    <div class="students">
                        <div class="student mb-5">
                            <img src="{{asset('website/assets/img/teacher/team-1.jpg')}}" alt="Natasha" />
                            <p class="name">Natasha</p>
                            <p class="percent">97.5%</p>
                        </div>
                        <div class="student mb-5">
                            <img src="{{asset('website/assets/img/teacher/team-2.jpg')}}" alt="Riya Rani" />
                            <p class="name">Riya Rani</p>
                            <p class="percent">95.5%</p>
                        </div>
                        <div class="student mb-5">
                            <img src="{{asset('website/assets/img/teacher/team-3.jpg')}}" alt="Dolly" />
                            <p class="name">Dolly</p>
                            <p class="percent">95.25%</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Result Section End -->
@endsection
