<!DOCTYPE html>
<html lang="en">

<head>
    {{-- Aadhar Layout --}}
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ID Card PDF</title>
    @php
        // $path = public_path('pos/images/idcard.svg');
        $path = public_path('pos/assets/img/idcard_pdf/idcard-front.png');
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64BgImgFront = 'data:image/' . $type . ';base64,' . base64_encode($data);
        // Id Card Back Layout Img
        $path = public_path('pos/assets/img/idcard_pdf/idcard-back.png');
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64BgImgBack = 'data:image/' . $type . ';base64,' . base64_encode($data);
        // Profile Image
        $path = public_path('pos/assets/img/profiles/user.jpg');
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64Profile = 'data:image/' . $type . ';base64,' . base64_encode($data);
    @endphp
    @php
        // Id Card Front Layout Img in SVG
        // $path = public_path('pos/images/idcard-front.svg');
        // $svgData = file_get_contents($path);
        // $base64BgImgFront = 'data:image/svg+xml;base64,' . base64_encode($svgData);
    @endphp

    <style>
        @page {
            margin: 15px;
        }

        @font-face {
            font-family: 'Poppins';
            font-style: normal;
            font-weight: 400;
            src: url(asset('pos/fonts/Poppins-Regular.ttf') format('truetype'));
            /* src: url('file://{{ public_path('pos/fonts/Poppins-Regular.ttf') }}') format('truetype'); */
        }

       

        /*
        @font-face {
            font-family: 'Poppins';
            font-style: normal;
            font-weight: 700;
            src: url('file://{{ public_path('pos/fonts/Poppins-bold.ttf') }}') format('truetype');
        } */

        body {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
        }

        .size-box-height {
            height: 20px;
        }

        .main-box {
            width: 70%;
            height: 220px;
            margin: auto;
            padding: 10px;
            /* border: #ff0202 solid 1px; */
        }

        .idcardfront {
            margin: 5px;
            align-content: center;

            float: left;
            height: 211px;
            width: 327.36px;
            border: #1D57AE solid 1px;
            background-image: url({{ $base64BgImgFront }});
            /* background-image: url('{{ asset('pos/images/idcard-front.svg') }}'); */
            background-size: 100% 100%;
            background-repeat: no-repeat;
            background-position: center center;
            display: inline-block;
            overflow: hidden;
        }


        .idcardback {
            margin: 5px;
            align-content: center;
            float: left;
            height: 211px;
            width: 327.36px;
            border: #1D57AE solid 1px;
            background-image: url({{ $base64BgImgBack }});
            background-size: 100% 100%;
            background-repeat: no-repeat;
            background-position: center center;
            display: inline-block;
            overflow: hidden;
        }



        .header {
            width: 100%;
            min-height: 62px;
            overflow: hidden;
            /* border: #000 solid 1px; */
        }


        .logo-head {
            min-width: 138px;
            max-width: 140px;
            min-height: 46px;
            max-height: 48px;
            float: left;
            text-align: center;
            padding-top: 12px;
            /* padding-right: 10px;
            padding-left: 10px; */
            /* padding: 5px; */
            /* border: #000 solid 1px; */
            /* background-image: url({{ $base64Profile }}); */
            /* background-size: 100% 100%;
            background-repeat: no-repeat;
            background-position: top center; */
            overflow: hidden;
        }

        .logo-head img {
            min-width: 85%;
            max-width: 90%;
            min-height: 20%;
            max-height: 21%;
            object-fit: contain;
        }


        .headline {
            min-width: 170px;
            max-width: 180px;
            min-height: 33px;
            max-height: 35px;
            /* border: #000 solid 1px; */
            padding-top: 10px;
            font-size: 13px;
            float: right;
            font-weight: 600;
            /* letter-spacing: 0.1rem; */
            color: #ffffff;
            text-transform: uppercase;
            text-align: center;
            overflow: hidden;
        }



        .subheadline {

            padding-top: 3px;
            font-size: 8px;
            font-weight: 500;
            /* letter-spacing: 0.1rem; */
            color: #ffffff;
            text-transform: uppercase;
            text-align: center;
        }

        .address {
            max-width: 50%;
            min-height: 42px;
            max-height: 42px;
            margin-top: 3px;
            float: left;
            /* border: #000 1px solid; */
            font-size: 8px;
            /* letter-spacing: 0.07rem; */
            color: #ffffff;
            text-transform: capitalize;
            text-align: center;
            overflow: hidden;
        }
        
        .detail-section {
            max-width: 100%;
            min-height: 98px;
            max-height: 98px;
            margin-top: 5px;
            /* border: #000 solid 1px; */
            overflow: hidden;
        }
        .profile {
            /* border: #000 1px solid; */
            float: left;
            padding: 15px;
            padding-right: 15px;
            padding-left: 20px;
            border-radius: 5px;
            min-width: 22%;
            max-width: 23%;
            min-height: 50px;
            max-height: 52px;
            /* border: #1D57AE solid 1px; */
            /* background-image: url({{ $base64Profile }});
            background-size: 100% 100%;
            background-repeat: no-repeat;
            background-position: center center; */
            overflow: hidden;
        }

        .profile img {
           min-width: 100%;
            max-width: 100%;
            min-height: 30%;
            max-height: 30%;
            object-fit: contain;
            border-radius: 5px;
        }


        .detail-section table {
            width: 60%;
            font-size: 12px;
            /* letter-spacing: 0.09rem; */
            /* text-align: start; */
            float: right;
            /* border: #000 solid 1px; */
            overflow: hidden;
        }

        .detail-section table .table-head {
            width: 43%;
            font-weight: 500;
            font-size: 10px;
            /* letter-spacing: 0.09rem; */
            color: #000000;
            text-transform: capitalize;
            text-align: start;
            /* border: #000 solid 1px; */
        }

        .detail-section table .table-body {
            font-size: 10px;
            color: #525252;
            /* font-weight: 600; */
            /* letter-spacing: 0.09rem; */
            text-transform: capitalize;
            text-align: start;
        }

        .sign {
            float: right;
            width: 40%;
            height: 40px;
            /* border:#000 solid 1px; */
        }

        .sign .signature {
            max-width: 50%;
            min-width: 50%;
            height: 20px;
            /* border: #000 solid 1px; */
            margin: auto;
            /* float: left; */
        }

        .sign .signature p {
            font-size: 8px;
            font-family: 'poppins', sans-serif;
            font-weight: 700;
            margin-top: -5px;
            /* letter-spacing: 0.07rem; */
            color: #000000;
            text-transform: capitalize;
            text-align: center;
        }

        .sign .signature img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }


        .headline-back {
            width: 177px;
            /* border: #000 solid 1px; */
            margin-top: 16px;
            font-size: 13px;
            float: left;
            font-family: 'poppins', sans-serif;
            font-weight: 700;
            /* letter-spacing: 0.1rem; */
            color: #ffffff;
            text-transform: uppercase;
            text-align: center;
        }


        .header-right-back {
            width: 38%;
            height: auto;
            float: right;
            /* border:#000 solid 1px; */
            padding-top: 18px;
        }

        .header-right-back span {
            color: #525252;
        }

        .header-right-back p {
            /* border:#ff0000 solid 1px; */
            width: 100%;
            /* float: right; */
            font-size: 9px;

            font-family: 'poppins', sans-serif;
            font-weight: 700;
            color: #242424;
            margin: 1px;
            /* letter-spacing: 0.067rem; */
            text-transform: capitalize;
            text-align: center;
        }

        /* .header-right-back table {
            margin-top: 10px;
            width: 100%;
            float: right;
            
        }
        
        .header-right-back table .table-head-back {
            width: 44%;
            height: auto;
            font-family: 'poppins', sans-serif;
            font-weight: 700;
            font-size: 8px;
            color: #000000;
            text-align: end;
        }
        
        .header-right-back table .table-body-back {
            width: 43%;
            height: auto;
            font-size: 8px;
             font-family: 'poppins', sans-serif;
            font-weight: 700;
            color: #3f3f3f;
            letter-spacing: 0.09rem;
            text-transform: capitalize;
            text-align: start;
        } */

        .terms-back {
            width: 100%;
            margin-top: 55px;
            /* border: #000 solid 1px; */
        }

        .terms-back ul {
            margin: 0;
            padding: 2px;
            /* list-style-type: none; */
            text-align: start;
            margin-left: 20px;
        }

        .terms-back ul li {
            font-size: 9px;
            color: #5e5e5e;
            padding: 2px;
            font-family: 'popins', sans-serif;
            font-weight: 700;
            text-transform: capitalize;
            text-align: start;
            line-height: 0.9rem;
            /* border: #000 solid 1px; */
        }


        .school-detail-back {
            margin-top: 30px;
            /* min-width: 100%; */
            max-width: 100%;
            height: 58px;
            /* border: #000 solid 1px; */
            font-size: 7px;
            font-family: 'poppins', sans-serif;
            font-weight: 700;
            /* letter-spacing: 0.09rem; */
            /* color: #000000; */
            text-transform: capitalize;
            text-align: start;
        }

        .back-detail-bottomleft {
            float: left;
            /* border: #000 solid 1px; */
            max-width: 47%;
            min-width: 47%;

        }

        .back-detail-bottomright {
            max-height: 55px;
            min-height: 52px;
            min-width: 50%;
            max-width: 50%;
            /* border: #000 solid 1px; */
            float: right;
            overflow: hidden;
        }

        .school-table-back {
            width: 50%;
            float: left;
            margin-left: 5px;
            /* border: #ff0000 solid 1px; */

        }

        .school-table-back .table-head-back {
            /* font-weight: 500; */
            width: auto;
            font-size: 8px;
            /* letter-spacing: 0.06rem; */
            color: #000000;
            text-transform: capitalize;
            text-align: start;
            /* border: #000 solid 1px;   */
        }

        .school-table-back .table-body-back {
            /* border: #000 solid 1px;   */
            width: auto;
            font-size: 7.5px;
            color: #525252;
            /* font-weight: 600; */
            /* letter-spacing: 0.06rem; */
            text-transform: capitalize;
            text-align: start;
        }

        .logo-back {
            float: left;
            width: 90px;
            height: 40px;
            margin-top: 15px;
            /* border: #000 solid 1px; */
            background-size: 100% 100%;
            background-repeat: no-repeat;
            background-position: center center;
            overflow: hidden;
        }

        .logo-back img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .logo-back p {
            font-size: 9px;
            font-weight: 700;
            /* letter-spacing: 0.09rem; */
            color: #ffffff;
            text-transform: uppercase;
            text-align: center;
        }

        .logo-back p:nth-child(2) {
            font-size: 7px;
            font-weight: 700;
            /* letter-spacing: 0.09rem; */
            color: #ffffff;
            text-transform: uppercase;
            text-align: center;
        }

        .QR-back {
            float: right;
            width: 70px;
            height: 38px;
            margin-top: 21px;
            /* border: #000 solid 1px; */

        }

        .QR-code {
            width: 35px;
            height: 35px;
            margin: auto;
            z-index: 999;
            background: #ffffff;
            background-image: url({{ $base64Qr }});
            background-size: 85% 85%;
            background-repeat: no-repeat;
            background-position: center center;
            overflow: hidden;
            /* border: #000 solid 1px; */
        }
    </style>


</head>

<body>
    @foreach ($teachers as $index => $stdData)
        <div class="size-box-height"></div>
        <div class="main-box">
            <div class="idcardfront">
                <div class="header">
                    {{-- <div class="logo-head"></div> --}}
                    <div class="logo-head">
                        <img src="{{ $schoolData['school_logo'] }}">
                    </div>
                    <div class="headline">
                        {{ $schoolData['school_name'] }}
                        {{-- <div class="subheadline">Slogoan Here</div> --}}
                    </div>
                </div>
                @php
                    // Default Profile Image
                    $path = public_path('pos/assets/img/profiles/user.jpg');
                    if (file_exists($path)) {
                        $type = pathinfo($path, PATHINFO_EXTENSION);
                        $data = file_get_contents($path);
                        $base64DProfile = 'data:image/' . $type . ';base64,' . base64_encode($data);
                    }

                    $base64Profile = null;

                    if (!empty($stdData->image)) {
                        $fullPath = storage_path('app/public/' . $stdData->image);

                        if (file_exists($fullPath)) {
                            $type = pathinfo($fullPath, PATHINFO_EXTENSION);
                            $data = file_get_contents($fullPath);
                            $base64Profile = 'data:image/' . $type . ';base64,' . base64_encode($data);
                        }
                    }
                @endphp


<div class="detail-section">
                    <div class="profile">
                        @if ($base64Profile)
                            <img src="{{ $base64Profile }}" alt="Profile">
                        @else
                            <img src="{{ $base64DProfile }}" alt="Default">
                        @endif
                    </div>
                    {{-- <div class="profile"></div> --}}
                    <table class="detail-table">

                        <tr>
                            <td class="table-head">Teacher ID</td>
                            <td>:</td>
                            <td class="table-body">{{ $stdData->teacher_id }}</td>
                        </tr>

                        <tr>
                            <td class="table-head">Teacher Name</td>
                            <td>:</td>
                            <td class="table-body">{{ $stdData->teacher_name }}</td>
                        </tr>
                          <tr>
                            <td class="table-head">Dob</td>
                            <td>:</td>
                            <td class="table-body">{{ $stdData->dob }}</td>
                        </tr>
                        <tr>
                            <td class="table-head">Mobile No.</td>
                            <td>:</td>
                            <td class="table-body">{{ $stdData->mobile }}</td>
                        </tr>
                        <tr>
                            <td class="table-head">Experience</td>
                            <td>:</td>
                            <td class="table-body">{{ $stdData->experience }}</td>
                        </tr>

                    </table>
                </div>
                <div class="address">
                    <p>{{ $schoolData['school_address'] }}</p>
                    {{-- <p>School Address,Street,State,1252 <br>Phone No - 9528634062
                    </p> --}}
                </div>
                <div class="sign">
                    {{-- <p>Principal</p> --}}
                    <div class="signature">
                        <img src="{{ $schoolData['school_principal_sign'] }}">
                        <p>Principal Sign</p>
                    </div>
                </div>

            </div>
            <div class="idcardback">
                <div class="header-back">
                    {{-- Header Left --}}
                    <div class="headline-back">
                        Terms & Conditions
                    </div>
                    {{-- Header RIght --}}
                    <div class="header-right-back ">
                        <p>Session : <span>{{ $schoolData['school_session'] }}</span></p>
                        <p>Print Date : <span>{{ date('d-m-Y') }}</span></p>
                    </div>
                </div>
                <div class="terms-back">
                    <ul>
                        <li>Lorem ipsum dolor sit amet. ipsum dolor sit amet consectetur adipisicing elit. Ut, placeat.
                            </li>
                        <li>Lorem ipsum dolor sit amet. ipsum dolor sit amet consectetur adipisicing elit.Lorem ipsum dolor sit amet
                             </li>
                        
                    </ul>
                </div>
                <div class="school-detail-back">
                    <div class="back-detail-bottomleft">
                        <table class="school-table-back">
                            <tr>
                                <td class="table-head-back">Mail</td>
                                <td>:</td>
                                <td class="table-body-back">info@techrlp.co.in

</td>
                            </tr>
                            <tr>
                                <td class="table-head-back">Phone</td>
                                <td>:</td>
                                <td class="table-body-back">+91 9012863339</td>
                            </tr>

                            <tr>
                                <td class="table-head-back">Website</td>
                                <td>:</td>
                                <td class="table-body-back">https://techrlp.co.in</td>
                            </tr>

                        </table>
                    </div>
                    <div class="back-detail-bottomright">
                        <div class="logo-back">
                            <img src="{{ $schoolData['school_logo'] }}">

                            {{-- <p>Logo Here</p>
                            <p>Slogoan Here</p> --}}
                        </div>
                        <div class="QR-back">
                            <div class="QR-code"></div>
                        </div>
                    </div>
                </div>



            </div>
        </div>
        @if ($loop->iteration % 5 == 0 && !$loop->last)
            <div style="page-break-after: always;"></div>
        @endif
    @endforeach
</body>

</html>
