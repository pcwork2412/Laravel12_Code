<!DOCTYPE html>
<html lang="en">
    
{{-- @php  
        if ($template) {
            // Agar URL se template aaya hai
            $path = public_path($template);
        } else {
            // Agar URL me nahi mila to ek default path de do
            $path = public_path('pos/assets/img/flags/de.png');
        }

        // Ab $path hamesha defined rahega
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
    @endphp --}}
@php
    $path = public_path('pos/assets/img/idcard_pdf/idcardfront1.png');
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);
    $base64BgImgFront = 'data:image/' . $type . ';base64,' . base64_encode($data);

    $path = public_path('pos/assets/img/profiles/avatar-01.jpg');
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);
    $base64Profile = 'data:image/' . $type . ';base64,' . base64_encode($data);
@endphp


<meta charset="UTF-8">
<title>ID Card PDF</title>
<style>
    @page {
        margin: 0px;
    }

    @font-face {
        font-family: 'Poppins';
        font-style: normal;
        font-weight: 400;
        src: url('file://{{ public_path('pos/fonts/Poppins-Regular.ttf') }}') format('truetype');
    }

    @font-face {
        font-family: 'Poppins';
        font-style: normal;
        font-weight: 700;
        src: url('file://{{ public_path('pos/fonts/Poppins-bold.ttf') }}') format('truetype');
    }

    body {
        font-family: 'Poppins', sans-serif;
    }

    .main-box {
        width: 100%;
        height: 330px;
        align-content: center;
        margin: auto;
        /* border: #ff0202 solid 1px; */
    }

    .idcard-box-front {
        width: 211px;
        height: 327.4px;
        float: left;
        border: #000 solid 1px;
        background-image: url('{{ $base64BgImgFront }}');
        background-size: cover;
        background-image: width 100%;
        background-position: center center;
        background-repeat: no-repeat;
        display: inline-block;
        overflow: hidden;
    }

    .idcard-box-back {
          width: 211px;
        height: 327.4px;
        float: left;
        margin-left: 10px;
        border: #000 solid 1px;
        background-image: url('{{ $base64BgImgFront }}');
        background-size: cover;
        background-position: center center;
        background-repeat: no-repeat;
        display: inline-block;
        overflow: hidden;
    }

    .size-box-height {
        height: 50px;
    }

    .header {
        text-align: center;
        font-size: 15px;
        font-weight: bold;
        color: antiquewhite;
        /* border: #ff0202 solid 1px; */
        margin-top: 15px;
    }

    .header span {
        /* font-size: 25px; */
        /* font-weight: bold; */
        color: #009130;

    }

    .sub-header {
        text-align: center;
        font-size: 10px;
        /* letter-spacing: 0.48rem; */
        color: antiquewhite;
        /* border: #ff0202 solid 1px; */
    }

    .profile {
        width: 70px;
        height: 70px;
        border: #009130 solid 2px;
        border-radius: 50%;
        margin: 0 auto;
        margin-top: 30px;
        background-image: url('{{ $base64Profile }}');
        background-size: contain;
        background-position: center center;
        background-repeat: no-repeat;
    }

    .name {
        color: #009130;
        font-size: 15px;
        font-weight: 700;
        /* letter-spacing: 0.085rem; */
        text-align: center;
        margin-top: 8px;
    }

    .profession {
        color: #000000;
        font-size: 10px;
        font-weight: 400;
        /* letter-spacing: 0.098rem; */
        text-align: center;
        /* margin-top: 10px; */
    }

    .detail-section {
        width: 60%;
        margin: auto;
        /* border: #000 solid 1px; */
        margin-top: 6px;
    }
    
    .detail-table {
        margin: auto;
        width: 80%;
        /* border: #000 solid 1px; */
        padding-left: 8px;
        /* margin: auto; */
        /* float: right; */
        font-size: 8px;
        /* letter-spacing: 0.09rem; */
    }

    .detail-table .table-head {
        text-align: start;
    }

    /********  ID CARD BACK  **********/
    .terms {
        margin-top: 30px;
        margin-left: 5px;
        font-size: 1rem;
        font-weight: 500;
        /* letter-spacing: 0.08rem; */
        font-family: Arial, "Helvetica Neue", Helvetica, sans-serif;
    }

    .detail-table-back {
        width: 80%;
        /* border: #000 solid 1px; */
        /* padding-left: 8px; */
        margin: auto;
        /* float: center; */
        font-size: 18px;
        /* letter-spacing: 0.08rem; */
    }
</style>
</head>

<body>
    @foreach ($students as $index => $stdData)
    <div class="size-box-height"></div>
        <div class="main-box">
            <div class="idcard-box-front">
                <div class="header"><span>Elite</span> Academy</div>
                <div class="sub-header">Elite Academy</div>
                <div class="profile"></div>
                <div class="name">{{ $stdData->student_name }}</div>
                <div class="profession">Graphic Desginer</div>
                <div class="detail-section">
                    <table class="detail-table">
                        <tr>
                            <td class="table-head">ID No:</td>
                            <td class="table-body">123456</td>
                        </tr>
                        <tr>
                            <td class="table-head">DOB:</td>
                            <td class="table-body">24-01-2006</td>
                        </tr>
                        <tr>
                            <td class="table-head">Phone:</td>
                            <td class="table-body">9528634062</td>
                        </tr>
                        <tr>
                            <td class="table-head">E-mail:</td>
                            <td class="table-body">jeannyspara23</td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="idcard-box-back">
                {{-- <div class="header"><span>Elite</span> Academy</div>
                <div class="sub-header">Elite Academy</div>
                <div class="terms">
                    <ul>
                        <li>Lorem ipsum dolor sit amet </li>
                        <li>Lorem ipsum dolor sit amet </li>
                        <li>Lorem ipsum dolor sit amet </li>
                        <li>Lorem ipsum dolor sit amet </li>
                    </ul>
                </div>
                <div class="parent-section">
                    <table class="detail-table-back">
                        <tr>
                            <td class="table-head">Father:</td>
                            <td class="table-body">Jhon Doe</td>
                        </tr>
                        <tr>
                            <td class="table-head">Mother:</td>
                            <td class="table-body">Jane Doe</td>
                        </tr>
                        <tr>
                            <td class="table-head">Father No:</td>
                            <td class="table-body">Jane Doe</td>
                        </tr>
                        <tr>
                            <td class="table-head">Address:</td>
                            <td class="table-body">Jane Doe</td>
                        </tr>

                    </table>
                </div>
            </div> --}}
        </div>
        <div class="size-box-height"></div>
        {{-- Page break after every 2 students --}}
        @if (($index + 1) % 2 == 0 && !$loop->last)
            <div style="page-break-after: always;"></div>
        @endif
    @endforeach
    
</body>

</html>
