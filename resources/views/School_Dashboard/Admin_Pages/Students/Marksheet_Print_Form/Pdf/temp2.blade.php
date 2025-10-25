<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Resullt Card</title>
</head>
<style>
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

    .text-bold-2 {
        font-weight: 400;
        font-size: 1rem;
        color: #000000;
    }

    .text-bold {
        font-weight: 400;
        font-size: 1.1rem;
        color: #000000;
    }

    .text-bold-head {
        font-weight: 600;
        font-size: 1.1rem;
        color: #000000;
    }

    .pading-left {
        padding-left: 60px;
        line-height: 5px;
    }

    .result-card {
        width: 100%;
        height: 1300px;
        /* border: rgb(8, 153, 44) solid 10px; */
        border: rgb(8, 153, 44) solid 4px;
        margin-top: 1rem;
    }

    .header {
        padding: 5px;
        width: 100%;
        min-height: 14%;
        max-height: 15%;
        /* background-color: #f0f0f0; */
        /* border-top: rgb(8, 153, 44) solid 6px; */
        border-bottom: rgb(8, 153, 44) solid 4px;
    }

    .logo {
        width: 21%;
        height: 11%;
        float: left;
        text-align: center;
        padding-top: 20px;
        /* margin-left: 15px; */
        /* border: black solid 1px; */
    }

    .logo img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    .title {
        width: 75%;
        min-height: 75%;
        float: right;
        text-align: center;
        /* padding-top: 5px; */
        margin-right: 10px;
        /* border: black solid 1px; */
    }

    .title h2 {
        margin-top: 5px;
        padding: 4px;
        color: #d82222;
        text-transform: uppercase;
        letter-spacing: 2px;
        word-spacing: 2px;
        text-align: center;
        font-size: 2.3rem;
        font-weight: bold;
        /* border: #000000 solid 1px; */
    }

    .title p {
        margin-top: -30px;
        padding: 4px;
        color: #0d8321;
        font-family: Arial, "Helvetica Neue", Helvetica, sans-serif;
        font-size: 1.4rem;
        font-weight: 500;
        letter-spacing: 0.83px;
        word-spacing: 0.2px;
        text-align: center;
    }

    .title .address {
        margin-top: -20px;
        display: inline-block;
        padding: 2px;
        color: #0d8321;
        font-family: Arial, "Helvetica Neue", Helvetica, sans-serif;
        font-size: 1.2rem;
    }

    .result-card h4 {
        text-align: center;
        margin-bottom: -15px;
        /* margin-top: -10px; */
        font-size: 22px;
        letter-spacing: 0.1rem;
        font-weight: 700;
    }

    .student-detials {
        width: 95%;
        min-height: 10%;
        max-height: 11%;
        margin-left: 20px;
        margin-top: 32px;
        /* border: black solid 1px; */
    }

    .student-detials .sec-1 {
        width: 36%;
        height: 100%;
        float: left;
        padding: 5px;
        font-family: 'Poppins', sans-serif;
        /* border-right: black solid 1px; */
    }

    .student-detials .sec-2 {
        width: 18%;
        height: 100%;
        float: left;
        font-family: 'Poppins', sans-serif;
        /* border-right: black solid 1px; */
        text-align: center;
    }

    .student-detials .sec-2 p {
        padding-top: 35px;
        /* border: black solid 1px; */
    }

    .student-detials .sec-3 {
        width: 32.5%;
        height: 100%;
        float: right;
        padding-right: 5px;
        /* border: black solid 1px; */
        text-align: center;
    }


    .student-detials .sec-1 table .row-gap,
    .student-detials .sec-3 table .row-gap {
        line-height: 35px;
    }

    .student-detials .sec-3 table {
        float: right;
        /* border: black solid 1px; */
        /* text-align: center; */
    }

    .student-marks {
        width: 95%;
        min-height: 30%;
        max-height: 30%;
        margin-left: 20px;
        margin-top: 20px;
        font-size: 13px;
        /* border: black solid 1px; */
    }

    .marks-total {
        width: 95%;
        height: 10%;
        margin-left: 20px;
        margin-top: 40px;
        /* border: black solid 1px; */
    }

    .student-grade {
        width: 45%;
        /* height: 100%; */
        float: right;
        /* text-align: center; */
        /* border: black solid 1px; */
        background: #f5f0f0;
    }

    .student-percentage {
        width: 50%;
        height: 100%;
        float: left;
        text-align: center;
        /* border: black solid 1px; */
    }

    .student-attendance {
        width: 45%;
        height: 10%;
        margin-left: 20px;
        float: right;
        /* border: black solid 1px; */
    }

    .footer {
        width: 100%;
        height: 15%;
        margin-top: 20px;
        padding-left: 20px;
        padding-right: 20px;
        border-top: #0d8321 solid 4px;
        /* border: rgb(175, 5, 5) solid 1px; */
    }

    .foot-content {
        width: 90%;
        /* border: rgb(175, 5, 5) solid 1px; */
    }

    .footer .remark {
        font-size: 1rem;
        font-weight: 500;
        letter-spacing: 0.08rem;
        font-family: Arial, "Helvetica Neue", Helvetica, sans-serif;
    }

    .footer-content .achive-list {
        font-weight: 500;
        font-size: 0.69rem;
        word-spacing: 0.14rem;
        letter-spacing: 0.49rem;
    }

    .footer p {}

    .footer .promote {
        margin-top: 5px;
    }

    .footer .date {
        weight: 40%;

        height: 10%;
        margin: auto;
        text-align: center;
        /* padding-right: 20px; */
        margin-top: 30px;
        border: black solid 1px;
    }

 .footer .signature {
    width: 100%;
    height: 30%;
    display: block;
    margin-top: 40px;
    overflow: visible; /* Float handling */
    /* border: #000000 solid 1px; */
}

.signature .teacher,
.signature .principal {
    /* width: 55%; float layout */
    display: block;
    float: left;
    font-weight: 500;
    text-align: center;
    margin: 0 2.5%;
}

.signature .principal {
    float: right;
}

.sign {
    width: 100%;
    margin-top: -80px; /* negative margin for overflow */
    /* padding-top: 5px; */
    position: relative;
}

.sign img {
    width: 150px; /* fixed width for PDF */
    height: auto;
    display: block;
    margin: 0 auto;
    position: relative;
    top: -20px; /* move image up */
}

</style>

<body>
    @foreach ($students as $stdData)
        {{-- @student->foreach ($marksData as $index => $stdMark) --}}
        <div class="result-card">
            <div class="header">
                <div class="logo">
                   @if(file_exists(public_path('storage/' . $school_logo)))
    <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('storage/' . $school_logo))) }}" alt="Signature">
@endif
                </div>
                <div class="title">
                    {{-- <h2>PGM INTERNATIONAL SCHOOL</h2> --}}
                    <h2>{{$school_name}}</h2>
                    <p>
                        {{$school_tagline}}
                    </p>
                    {{-- <p>
                        An English Medium Co-educational School
                        Affiliated to <br> CBSE, New Delhi <br>
                    </p> --}}
                    <div class="address">
                        {{ $school_address }}
                        {{-- <span>Garh Road, Meerut - 250004 (U.P) PH: 012-3548-5561</span><br>
                        <span>E-mail: pgmis@live.com, Web: www.pgmischool.com</span> --}}
                    </div>
                </div>
            </div>
            <h4>Progress Card: ({{$school_session}})</h4>
            <div class="student-detials">
                <div class="sec-1">
                    <table>
                        <tr class="row-gap">
                            <td class="text-bold-head">Student Name</td>
                            <td>:</td>
                            <td class="text-bold-head"">{{ $stdData->student_name }}</td>
                        </tr>
                        <tr class="row-gap">
                            <td class="text-bold-head">Father`s Name</td>
                            <td>:</td>
                            <td class="text-bold-head">{{ $stdData->father_name }}</td>
                        </tr>

                        <tr class="row-gap">
                            <td class="text-bold-head">Student ID</td>
                            <td>:</td>
                            <td class="text-bold-head">{{ $stdData->student_uid }}</td>
                        </tr>

                    </table>
                </div>
                <div class="sec-2">
                    {{-- <adm_nop class="text-bold"> Adm. No: {{$stdData->}}</adm_nop> --}}
                </div>
                <div class="sec-3">
                    <table>
                        <tr class="row-gap">
                            <td class="text-bold-head">DOB</td>
                            <td>:</td>
                            <td class="text-bold-head">{{ $stdData->dob }}</td>
                        </tr>

                        <tr class="row-gap">
                            <td class="text-bold-head">Class</td>
                            <td>:</td>
                            <td class="text-bold-head">
                                {{ $stdData->promoted_class_name }}</td>
                        </tr>
                        <tr class="row-gap">
                            <td class="text-bold-head">Section </td>
                            <td>:</td>
                            <td class="text-bold-head">{{ $stdData->section }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="student-marks">
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <th style="border: 1px solid black; padding: 12px; font-size:17px;">Scholastic Areas:
                        </th>
                        {{-- <th colspan="5" style="border: 1px solid black; padding: 1px; font-size:13px;">
                                Term-1(100 Marks)
                            </th> --}}
                        <th colspan="10"
                            style="border: 1px solid black; padding: 12px;  font-size:19px; letter-spacing:0.08rem;">
                            Acadmic Performance
                        </th>
                        <th style="border: 1px solid black; padding: 12px; font-size:17px;">Grand Total</th>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; padding: 5px; font-size:17px;" class="text-bold-2">
                            Subject Name
                        </td>
                        {{-- Term-1 --}}
                        <td
                            style="border: 1px solid black; padding: 5px; font-size:16px; text-align:center;"class="text-bold-2">
                            Max. Mark</td>
                        <td
                            style="border: 1px solid black; padding: 5px; font-size:16px;text-align:center;"class="text-bold-2">
                            Theory Marks</td>
                        <td
                            style="border: 1px solid black; padding: 5px; font-size:16px; text-align:center;"class="text-bold-2">
                            Practical Marks</td>
                        <td
                            style="border: 1px solid black; padding: 5px; font-size:16px;text-align:center;"class="text-bold-2">
                            Grade</td>
                        {{-- Term-1 Total --}}
                        <td
                            style="border: 1px solid black; padding: 5px; font-size:16px; text-align:center;"class="text-bold-2">
                            Total T1(100)</td>



                        {{-- Term-2 --}}
                        <td
                            style="border: 1px solid black; padding: 5px; font-size:16px; text-align:center;"class="text-bold-2">
                            Max. Mark</td>
                        <td
                            style="border: 1px solid black; padding: 5px; font-size:16px;text-align:center;"class="text-bold-2">
                            Theory Marks</td>
                        <td
                            style="border: 1px solid black; padding: 5px; font-size:16px; text-align:center;"class="text-bold-2">
                            Practical Marks</td>
                        <td
                            style="border: 1px solid black; padding: 5px; font-size:16px;text-align:center;"class="text-bold-2">
                            Grade</td>
                        {{-- Term-2 Total --}}
                        <td
                            style="border: 1px solid black; padding: 5px; font-size:16px; text-align:center;"class="text-bold-2">
                            Total T2(100)</td>
                        {{-- Grand T1+T2 Total --}}
                        <td
                            style="border: 1px solid black; padding: 5px; font-size:16px; text-align:center;"class="text-bold-2">
                            Grand Total T1+T2(200)</td>

                    </tr>

                    @foreach ($stdData->marks as $markData)
                        <tr>
                            <td style="border: 1px solid black; padding: 5px;  font-size:16px;">
                                {{ ucfirst(str_replace('_', ' ', $markData->subject_name)) }}
                            </td>
                            @php
                                $max = 100;
                                $obt = $markData->obtained_marks;
                                $theory = $markData->obtained_marks;
                                $per = $obt ? round(($obt / $max) * 100, 2) : 0;
                                $t1 = $obt + $theory;
                                // $t1TheoryTotal = $stdData->marks->sum('obtained_marks_theory');
                                $t1Total = $stdData->marks->sum('obtained_marks');

                                $grade = match (true) {
                                    $per >= 90 => 'A+',
                                    $per >= 80 => 'A',
                                    $per >= 70 => 'B+',
                                    $per >= 60 => 'B',
                                    $per >= 50 => 'C',
                                    $per >= 33 => 'D',
                                    default => 'F',
                                };

                                $gradeColor = $grade == 'F' ? 'color:red;' : '';
                            @endphp

                            <td style="border:1px solid black; text-align: center; padding:5px;  font-size:16px;">
                                {{ $max }}
                            </td>
                            <td style="border:1px solid black; text-align: center; padding:5px;  font-size:16px;">
                                {{ $obt }}
                            </td>
                            <td style="border:1px solid black; text-align: center; padding:5px;  font-size:16px;">
                                {{ $obt }}
                            </td>
                            <td
                                style="border:1px solid black; text-align: center; padding:5px;  font-size:16px; {{ $gradeColor }}">
                                {{ $grade }}
                            </td>
                            {{-- Term-1 Total --}}
                            <td style="border: 1px solid black; text-align: center; padding: 5px;  font-size:16px;">
                                {{ $t1 }}</td>

                            {{-- TERM-2 --}}
                            <td style="border:1px solid black; text-align: center; padding:5px;  font-size:16px;">
                                {{ $max }}
                            </td>
                            <td style="border:1px solid black; text-align: center; padding:5px;  font-size:16px;">
                                {{ $obt }}
                            </td>
                            <td style="border:1px solid black; text-align: center; padding:5px;  font-size:16px;">
                                {{ $obt }}
                            </td>
                            <td
                                style="border:1px solid black; text-align: center; padding:5px;  font-size:16px; {{ $gradeColor }}">
                                {{ $grade }}
                            </td>
                            {{-- Term-2 Total --}}
                            <td style="border: 1px solid black; text-align: center; padding: 5px;  font-size:16px;">
                                {{ $t1 }}</td>
                            {{-- Grand Total --}}
                            <td style="border: 1px solid black; text-align: center; padding: 5px;  font-size:16px;">
                                {{ $t1 + $t1 }}</td>
                        </tr>
                        {{-- <td style="border: 1px solid black; padding: 1px; font-size:13px;">{{$t1+$t1}}</td> --}}

                        <!-- Add more subjects as needed -->
                    @endforeach
                    {{-- <th colspan="5" style="border: 1px solid black; padding: 1px; font-size:13px; text-align:left;">
                        Total Term-1 Marks
                    </th>
                    <th colspan="1"
                        style="border: 1px solid black; padding: 1px; font-size:13px; text-align:center;">
                        500
                    </th>
                    <th colspan="4" style="border: 1px solid black; padding: 1px; font-size:13px; text-align:left;">
                        Total Term-2 Marks
                    </th>
                    <th colspan="1"
                        style="border: 1px solid black; padding: 1px; font-size:13px; text-align:center;">
                        508
                    </th>
                    <th colspan="1"
                        style="border: 1px solid black; padding: 1px; font-size:13px; text-align:center;">
                        708
                    </th> --}}
                </table>
            </div>
            <div class="marks-total">

                <div class="student-percentage">
                    <table style="width: 100%; border-collapse: collapse;">
                        <tr>
                            <th style="border: 1px solid black; padding: 8px; font-size:17px;">Scholastic
                                Areas:</th>
                            <th style="border: 1px solid black; padding: 8px; font-size:17px;">Term-1</th>
                            <th style="border: 1px solid black; padding: 8px; font-size:17px;">Term-2</th>
                            <th style="border: 1px solid black; padding: 8px; font-size:17px;">Term-3</th>
                        </tr>
                        <tr>
                            <td style="border: 1px solid black; padding: 5px; font-size:17px;">Marks Obtained
                            </td>
                            <td style="border: 1px solid black; padding: 5px; font-size:17px; text-align:center;">
                                248.00
                            </td>
                            <td style="border: 1px solid black; padding: 5px; font-size:17px; text-align:center;">
                                356.00
                            </td>
                            <td style="border: 1px solid black; padding: 5px; font-size:17px; text-align:center;">
                                604.00
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid black; padding: 5px; font-size:17px;">Maximum Marks
                            </td>
                            <td style="border: 1px solid black; padding: 5px; font-size:17px; text-align:center;">
                                248.00
                            </td>
                            <td style="border: 1px solid black; padding: 5px; font-size:17px; text-align:center;">
                                356.00
                            </td>
                            <td style="border: 1px solid black; padding: 5px; font-size:17px; text-align:center;">
                                604.00
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid black; padding: 5px; font-size:17px;">Percentage</td>
                            <td style="border: 1px solid black; padding: 5px; font-size:17px; text-align:center;">
                                35.15%
                            </td>
                            <td style="border: 1px solid black; padding: 5px; font-size:17px; text-align:center;">
                                50.86%
                            </td>
                            <td style="border: 1px solid black; padding: 5px; font-size:17px; text-align:center;">
                                43.14%
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="student-attendance">
                    <table style="width: 100%; border-collapse: collapse;">
                        <tr>
                            <th style="border: 1px solid black; letter-spacing:0.07rem;
                            padding: 6px; font-size:18px; text-align:center;"
                                colspan="2">
                                Attendance Table
                            </th>
                        </tr>
                        <tr>
                            <td style="border: 1px solid black; padding: 5px; font-size:17px;">Total
                                Attendance</td>
                            <td style="border: 1px solid black; padding: 5px; font-size:17px; text-align:center;">
                                340
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid black; padding: 5px; font-size:17px;">No. of
                                Working Days</td>
                            <td style="border: 1px solid black; padding: 5px; font-size:17px; text-align:center;">
                                432
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="footer">
                <div class="foot-content">
                    <p class="remark">Remark: He has a well-developed sense of humour</p>
                    <p class="remark">Achiements:</p>
                    <ol class="achive-head">
                        <li class="achive-list">Secured 1st position in Rang Manch from Shourya House.</li>
                        <li class="achive-list">Played in CBSE Cluster XIX Kho-Kho Boys !</li>
                        <li class="achive-list">Participated in Boat Race From Shourya House !</li>
                    </ol>
                </div>

    <div class="signature">

        <!-- Teacher Signature -->
        <div class="teacher">
            <p>Teacher <br>(signature)</p>
            <div class="sign">
                {{-- <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('pos/images/Nishant.png'))) }}"> --}}
            </div>
        </div>

        <!-- Principal Signature -->
        <div class="principal">
            <p>Principal <br>(signature)</p>
            <div class="sign">
@if(file_exists(public_path('storage/' . $school)))
    <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('storage/' . $school))) }}" alt="Signature">
@endif
            </div>
        </div>

    </div>

                {{-- <div class="date">
                    <p style="font-size: 10px; font-weight: 500;">Date: {{ \Carbon\Carbon::now()->format('d-m-Y') }}</p>
                </div> --}}
            </div>
        </div>
        {{-- @endforeach --}}
        @if (!$loop->last)
            <div style="page-break-after: always;"></div>
        @endif
    @endforeach
</body>

</html>
