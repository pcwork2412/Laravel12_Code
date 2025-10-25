<!DOCTYPE html>
<html lang="en">
<head>
    {{-- Aadhar Layout --}}
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ID Card PDF</title>
    @php
    $path = public_path('pos/assets/img/idcard_pdf/idcardfront2.png');
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);
    $base64BgImgFront = 'data:image/' . $type . ';base64,' . base64_encode($data);

    $path = public_path('pos/assets/img/profiles/avatar-01.jpg');
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);
    $base64Profile = 'data:image/' . $type . ';base64,' . base64_encode($data);
@endphp

<style>
     @page {
        margin: 15px;
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

    .size-box-height {
        height: 100px;
    }
    .main-box {
        width: 95%;
        height: 570px;
        margin: auto;
        padding: 10px;
        border: #ff0202 solid 1px;
    }
    .idcardfront {
        margin: 5px;
        align-content: center;
        /* float: left; */
        height: 211px;
        width: 327.36px;
        border: #000 solid 1px;
        background-image: url({{ $base64BgImgFront }});
        background-size: 100% 100%;
        background-repeat: no-repeat;
        background-position: center center;
        display: inline-block;
        overflow: hidden;
    }
    .idcardback {
        margin: 5px;
        align-content: center;
        float: right;
        width: 380px;
        height: 550px;
        border: #000 solid 1px;
        background-image: url({{ $base64BgImgFront }});
        background-size: 100% 100%;
        background-repeat: no-repeat;
        background-position: center center;
        display: inline-block;
        overflow: hidden;
    }
  
    .header {
        width: 100%;
        height: 42px;
        /* border: #000 solid 1px; */
    }
      .logo img{
        width: 100%;
        height: 100%;
        object-fit: contain;
      }
      .logo-head {
        float: left;
        /* margin-top: 15px;
        margin-right: 15px;
        margin-left: 15px; */
        /* margin: 5px; */
        width: 27px;
        margin: 4px;
        height: 32px;
        border: #000 solid 1px;
        background-image: url({{ $base64Profile }});
        background-size: 100% 100%;
        background-repeat: no-repeat;
        background-position: center center;
        overflow: hidden;
    }
      .logo {
        float: left;
        margin-top: 15px;
        margin-right: 15px;
        margin-left: 15px;
        /* margin: 5px; */
        width: 67px;
        height: 82px;
        border: #000 solid 1px;
             background-image: url({{ $base64Profile }});
        background-size: 100% 100%;
        background-repeat: no-repeat;
        background-position: center center;
        overflow: hidden;
    }
    .headline {
        /* border: #000 solid 1px; */
        margin-top: 10px;
        font-size: 26px;
        /* float: right; */
        font-weight: bolder;
        letter-spacing: 0.175rem;
        color: #009141;
        text-transform: uppercase;
        text-align: center;
    }
    .subheadline {
        /* float: right; */
        /* width: 67%; */
        /* height: 100px; */
        /* border: #000 solid 1px; */
        padding: 0px;
        font-size: 13px;
        font-weight: bold;
        /* letter-spacing: 0.0rem; */
        color: #009141;
        text-transform: uppercase;
        text-align: center;
    }
    .address {
        margin-top: 5px;
        font-size: 11px;
        letter-spacing: 0.08rem;
        color: #000000;
        font-weight: bold;  
        text-transform: uppercase;
        text-align: center;
    }
    .main-line {
      margin-top: 7px;
        font-size: 15px;
        font-weight: bolder;
        letter-spacing: 0.09rem;
        color: #009141;
        text-transform: capitalize;
        /* text-align: center; */
    }
    .detail-section{
        width: 100%;
        height: 140px;
        margin: auto;
        /* border: #000 solid 1px; */
        /* margin-top: 10px; */
        /* padding: 10px; */
    }
    .profile{
        width: 120px;
        height: 140px;
        float: left;
        margin-left: 10px;
        border-radius: 10px;
        /* border: #000 solid 1px; */
        background-image: url({{ $base64Profile }});
        background-size: 100% 100%;
        background-repeat: no-repeat;
        background-position: center center;
        overflow: hidden;
    }
    .detail-section table{
        padding-left: 20px;
        font-size: 12px;
        letter-spacing: 0.09rem;
        text-align: center;
        
    }
    .detail-section table .table-head{
        font-weight: bold;
        font-size: 12px;
        letter-spacing: 0.09rem;
        color: #00265f;
        text-transform: capitalize;
        text-align: start;
    }
    .detail-section table .table-body{
        font-size: 12px;
        /* font-weight: 600; */
        letter-spacing: 0.09rem;
        text-transform: capitalize;
        text-align: start;
    }
    .name{
        color: #00265f;
        font-size: 20px;
        font-weight: bolder;
        text-align: start;
        padding-left: 10px;
    }
</style>


</head>

<body>
    <div class="size-box-height"></div>
    <div class="main-box">
        <div class="idcardfront">
            <div class="header">
                <div class="logo-head"></div>
                <div class="headline">
                    SHRINATHJI</div>
            </div>
            <div class="logo"></div>
            <div class="main-line">
                Student Identity Card
            </div>
            <div class="detail-section">
                {{-- <div class="profile"></div> --}}
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
                        <td class="table-head">Name:</td>
                        <td class="table-body">John Doe</td>
                    </tr>
                    <tr>
                        <td class="table-head">Name:</td>
                        <td class="table-body">John Doe</td>
                    </tr>
                </table>
            </div>
            {{-- <div class="detail-section"> --}}
            {{-- <div class="logo">
                  <img
                        src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('pos/images/school-logo.png'))) }}">
            </div>
            <div class="header">
                <div class="headline">SHRINATHJI</div>
                <div class="subheadline">Institute Of Technology Education</div>
                <div class="address">Approved By Aject Mhrd Govt. of India & Affiliated To JNTUH, Hyderabad</div>
            </div>
            <div class="main-line">
                Student Identity Card
            </div>
            <div class="detail-section">
                <div class="profile"></div>
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
            <div class="name">Amit Kumar</div> --}}
        </div>
        <div class="idcardfront">
            <div class="header">
                <div class="logo-head"></div>
                <div class="headline">
                    SHRINATHJI</div>
            </div>
            <div class="logo"></div>
            <div class="main-line">
                Student Identity Card
            </div>
            <div class="detail-section">
                {{-- <div class="profile"></div> --}}
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
                        <td class="table-head">Name:</td>
                        <td class="table-body">John Doe</td>
                    </tr>
                    <tr>
                        <td class="table-head">Name:</td>
                        <td class="table-body">John Doe</td>
                    </tr>
                </table>
            </div>
            {{-- <div class="detail-section"> --}}
            {{-- <div class="logo">
                  <img
                        src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('pos/images/school-logo.png'))) }}">
            </div>
            <div class="header">
                <div class="headline">SHRINATHJI</div>
                <div class="subheadline">Institute Of Technology Education</div>
                <div class="address">Approved By Aject Mhrd Govt. of India & Affiliated To JNTUH, Hyderabad</div>
            </div>
            <div class="main-line">
                Student Identity Card
            </div>
            <div class="detail-section">
                <div class="profile"></div>
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
            <div class="name">Amit Kumar</div> --}}
        </div>
    </div>
</body>
</html>