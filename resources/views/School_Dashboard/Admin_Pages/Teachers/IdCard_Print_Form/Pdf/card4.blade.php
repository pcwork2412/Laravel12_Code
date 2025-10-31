<!DOCTYPE html>
<html lang="en">

<head>
    {{-- Aadhar Layout --}}
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ID Card PDF</title>
    @php
        // Front Background
        $path = public_path('pos/assets/img/idcard_pdf/idcard-front.png');
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64BgImgFront = 'data:image/' . $type . ';base64,' . base64_encode($data);

        // Back Background
        $path = public_path('pos/assets/img/idcard_pdf/idcard-back.png');
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64BgImgBack = 'data:image/' . $type . ';base64,' . base64_encode($data);

        // Default Profile
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
            size: A4;
            margin: 5mm;
        }

        body {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
        }

        .size-box-height {
            height: 5.29mm;
        }

        .main-box {
            width: 70%;
            height: 58.23mm;
            margin: auto;
            padding: 2.65mm;
        }

        .idcardfront {
            margin: 1.32mm;
            align-content: center;
            float: left;
            height: 55.83mm;
            width: 86.16mm;
            border: #1D57AE solid 0.26mm;
            background-image: url({{ $base64BgImgFront }});
            background-size: 100% 100%;
            background-repeat: no-repeat;
            background-position: center center;
            display: inline-block;
            overflow: hidden;
        }

        .idcardback {
            margin: 1.32mm;
            align-content: center;
            float: left;
            height: 55.83mm;
            width: 86.16mm;
            border: #1D57AE solid 0.26mm;
            background-image: url({{ $base64BgImgBack }});
            background-size: 100% 100%;
            background-repeat: no-repeat;
            background-position: center center;
            display: inline-block;
            overflow: hidden;
        }

        .header {
            width: 100%;
            min-height: 16.40mm;
            overflow: hidden;
        }

        .logo-head {
            min-width: 36.51mm;
            max-width: 37.04mm;
            min-height: 12.17mm;
            max-height: 12.70mm;
            float: left;
            text-align: center;
            padding-top: 3.17mm;
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
            min-width: 44.88mm;
            max-width: 47.63mm;
            min-height: 8.73mm;
            max-height: 9.26mm;
            padding-top: 2.65mm;
            font-size: 3.44mm;
            float: right;
            font-weight: 600;
            color: #ffffff;
            text-transform: uppercase;
            text-align: center;
            overflow: hidden;
        }

        .subheadline {
            padding-top: 0.79mm;
            font-size: 2.12mm;
            font-weight: 500;
            color: #ffffff;
            text-transform: uppercase;
            text-align: center;
        }

        .address {
            max-width: 50%;
            min-height: 11.11mm;
            max-height: 11.11mm;
            margin-top: 0.79mm;
            float: left;
            font-size: 2.12mm;
            color: #ffffff;
            text-transform: capitalize;
            text-align: center;
            overflow: hidden;
        }

        .detail-section {
            max-width: 100%;
            min-height: 25.93mm;
            max-height: 25.93mm;
            margin-top: 1.32mm;
            overflow: hidden;
        }

        .profile {
            float: left;
            padding: 3.97mm;
            padding-right: 3.97mm;
            padding-left: 5.29mm;
            border-radius: 1.32mm;
            min-width: 22%;
            max-width: 23%;
            min-height: 13.23mm;
            max-height: 13.76mm;
            overflow: hidden;
        }

        .profile img {
            min-width: 100%;
            max-width: 100%;
            min-height: 30%;
            max-height: 30%;
            object-fit: contain;
            border: #1D57AE solid 0.26mm;
            border-radius: 1.32mm;
        }

        .detail-section table {
            width: 60%;
            font-size: 3.17mm;
            float: right;
            overflow: hidden;
            margin: 0px;
            padding: 0px ;
            /* border: #000000 1px solid; */
            border-collapse: collapse;
            border-spacing: 0px;
            /* display: block; */
        }

        .detail-section table .table-head {
            width: 43%;
            font-weight: 500;
            font-size: 2.65mm;
            color: #000000;
            text-transform: capitalize;
            text-align: start;
            /* border: #000000 1px solid; */
            margin: 0px;
        }
        
        .detail-section table .table-body {
            /* border: #000000 1px solid; */
            font-size: 2.65mm;
            color: #525252;
            text-transform: capitalize;
            text-align: start;
            margin: 0px;
        }

        .sign {
            float: right;
            width: 40%;
            height: 9.5mm;
            /* border: #000000 1px solid; */
            overflow: hidden;
        }

        .sign .signature {
            max-width: 50%;
            min-width: 50%;
            height: 5.29mm;
            margin: auto;
        }

        .sign .signature img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            display: block;
            /* border: #000000 1px solid; */
        }

        .sign .signature p {
            font-size: 2mm;
            /* margin-top: -0.5mm; */
            color: #000000;
            text-transform: capitalize;
            text-align: center;
            margin: 0;
            padding: 0;
            /* line-height: 1; */
        }

        .headline-back {
            width: 46.86mm;
            margin-top: 4.23mm;
            font-size: 3.44mm;
            float: left;
            color: #ffffff;
            text-transform: uppercase;
            text-align: center;
        }

        .header-right-back {
            width: 38%;
            float: right;
            padding-top: 4.76mm;
        }

        .header-right-back p {
            width: 100%;
            font-size: 2.38mm;
            font-weight: 700;
            margin: 0.26mm;
            text-transform: capitalize;
            text-align: center;
        }

        .terms-back {
            width: 100%;
            margin-top: 14.55mm;
        }

        .terms-back ul {
            margin: 0;
            padding: 0.53mm;
            margin-left: 5.29mm;
        }

        .terms-back ul li {
            font-size: 2.38mm;
            padding: 0.53mm;
            line-height: 0.9rem;
        }

        .school-detail-back {
            margin-top: 7.94mm;
            height: 14.5mm;
            font-size: 1.85mm;
            text-align: start;
            /* border: #000000 1px solid; */
            overflow: hidden;
        }

        .back-detail-bottomleft {
            max-height: 13mm;
            min-height: 12.5mm;
            min-width: 46%;
            max-width: 47%;
            float: left;
            overflow: hidden;
            /* border: #000000 1px solid; */
        }
         .back-detail-bottomleft .school-table-back {
            /* width: 50%; */
            /* font-size: 3mm; */
            /* float: right; */
            overflow: hidden;
            margin: 0px;
            padding: 0px ;
            /* border: #000000 1px solid; */
            border-collapse: collapse;
            border-spacing: 0px;
            /* display: block; */
        }

        .back-detail-bottomleft .school-table-back .table-head-back {
            margin: 0px;
            padding-left: 3mm;
            width: 41%;
            font-weight: 500;
            font-size: 2mm;
            color: #000000;
            text-transform: capitalize;
            text-align: start;
            /* border: #000000 1px solid; */
        }
        
        .detail-section table .table-body-back {
            /* border: #000000 1px solid; */
            font-size: 2mm;
            color: #525252;
            text-transform: capitalize;
            text-align: start;
            margin: 0px;
        }
        .back-detail-bottomright {
            max-height: 14.55mm;
            min-height: 13.76mm;
            min-width: 50%;
            max-width: 50%;
            float: right;
            overflow: hidden;
            /* border: #000000 1px solid; */
        }

        .logo-back {
            float: left;
            width: 23.81mm;
            height: 10mm;
            margin-top: 3.97mm;
            background-size: 100% 100%;
            background-repeat: no-repeat;
            background-position: center center;
            overflow: hidden;
        }
        .logo-back img{
             width: 100%;
            height: 100%;
            object-fit: contain;
            display: block;
            overflow: hidden;
            /* border: #000000 1px solid; */
        }

        .QR-back {
            float: right;
            width: 18.52mm;
            height: 10.05mm;
            margin-top: 5.55mm;
        }

        .QR-code {
            width: 9mm;
            height: 9mm;
            margin: auto;
            background: #ffffff;
            background-image: url({{ $base64Qr }});
            background-size: 85% 85%;
            background-repeat: no-repeat;
            background-position: center center;
            overflow: hidden;
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
                        <li>Lorem ipsum dolor sit amet. ipsum dolor sit amet consectetur adipisicing elit.Lorem ipsum
                            dolor sit amet
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
