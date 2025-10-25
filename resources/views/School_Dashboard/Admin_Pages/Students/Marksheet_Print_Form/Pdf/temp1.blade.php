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
        font-size: 0.895rem;
        color: #000000;
    }

    .pading-left {
        padding-left: 60px;
        line-height: 5px;
    }

    .result-card {
        width: 100%;
        height: 1000px;
        /* border: rgb(8, 153, 44) solid 10px; */
        border: rgb(8, 153, 44) solid 4px;
        margin-top: 1rem;
    }

    .header {
        padding: 5px;
        width: 100%;
        height: 16%;
        /* background-color: #f0f0f0; */
        /* border-top: rgb(8, 153, 44) solid 6px; */
        border-bottom: rgb(8, 153, 44) solid 4px;
    }

    .logo {
        width: 18%;
        height: 85%;
        float: left;
        text-align: center;
        padding-top: 20px;
        /* margin-left: 15px; */
        /* border: black solid 1px; */
    }

    .logo img {
        width: 100%;
        height: 100%;
    }

    .title {
        width: 80%;
        height: 100%;
        float: left;
        text-align: center;
        justify-content: center;
        padding-top: 20px;
    }

    .title h2 {
        margin-top: 0;
        padding: 4px;
        color: #d82222;
        text-transform: uppercase;
        letter-spacing: 2px;
        word-spacing: 2px;
        text-align: center;
        font-size: 2.5rem;
        font-weight: bold;
    }

    .title p {
        margin-top: -45px;
        padding: 4px;
        color: #0d8321;
        font-family: Arial, "Helvetica Neue", Helvetica, sans-serif;
        font-size: 1rem;
        font-weight: 500;
        letter-spacing: 0.83px;
        word-spacing: 0.2px;
        text-align: center;
    }

    .title .address {
        margin-top: -20px;
        display: inline-block;
        padding: 4px;
        color: #0d8321;
        font-family: Arial, "Helvetica Neue", Helvetica, sans-serif;
        font-size: 0.9rem;
    }

    .result-card h4 {
        text-align: center;
        margin-bottom: -1px;
        /* margin-top: -1px; */
        font-size: 13px;
        font-weight: 600;
    }

    .student-detials {
        width: 95%;
        height: 9%;
        margin-left: 15px;
        /* border: black solid 1px; */
    }

    .student-detials .sec-1 {
        width: 33%;
        height: 100%;
        float: left;
        font-family: 'Poppins', sans-serif;
        /* border-right: black solid 1px; */
    }

    .student-detials .sec-2 {
        width: 34%;
        height: 100%;
        float: left;
        font-family: 'Poppins', sans-serif;
        /* border-right: black solid 1px; */
        text-align: center;
    }

    .student-detials .sec-2 p {
        padding-top: 35px;
    }

    .student-detials .sec-3 {
        width: 32.5%;
        height: 100%;
        float: left;
        /* border: black solid 1px; */
        text-align: center;
    }

    .student-marks {
        width: 95%;
        height: 30%;
        margin-left: 20px;
        margin-top: 15px;
        font-size: 13px;
        /* border: black solid 1px; */
    }

    .marks-total {
        width: 95%;
        height: 10%;
        margin-left: 20px;
        margin-top: 50px;
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
        width: 45%;
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
        width: 95%;
        height: 20%;
        margin-top: 10px;
        margin-left: 20px;
        /* border: black solid 1px; */
        /* border: rgb(175, 5, 5) solid 1px; */
    }

    .foot-content {
        margin-top: 5px;
        /* border: rgb(175, 5, 5) solid 1px; */
        width: 100%;
    }

    .footer .achive {
        margin-top: -5px;
        /* padding-left: 20px; */
    }

    .footer p {
        font-weight: 400;
        font-family: Arial, "Helvetica Neue", Helvetica, sans-serif;
        font-size: 0.71rem;
        margin-top: -0.1px;
    }

    .footer .promote {
        margin-top: 5px;
    }

    .footer .date {
        weight: 100%;
        height: 10%;
        float: right;
        padding-right: 20px;
        margin-top: 30px;
        /* border: black solid 1px; */
    }

    .footer .signature {
        width: 100%;
        height: 16%;
        margin-top: 40px;
        /* border: black solid 1px; */
    }

    .signature .sign {
        width: 33%;
        height: 100%;
        float: left;
        padding-top: px;
        /* border: black solid 1px; */
    }

    .signature .teacher {
        width: 33%;
        height: 100%;
        float: left;
        padding-top: px;
        /* border: black solid 1px; */
    }

    .signature .teacher p {
        text-align: center;
    }

    .signature .principal {
        width: 33%;
        height: 100%;
        float: left;
        padding-top: px;
        /* border: black solid 1px; */
    }

    .signature .principal p {
        text-align: right;
    }
</style>

<body>
    {{-- @foreach ($students as $stdData) --}}
    {{-- @student->foreach ($marksData as $index => $stdMark) --}}
    <div class="result-card">
        <div class="header">
            <div class="logo">
                <img
                    src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('pos/images/school-logo.png'))) }}">
            </div>
            <div class="title">
                <h2>PGM INTERNATIONAL SCHOOL</h2>`
                <p>
                    An English Medium Co-educational School
                    Affiliated to <br> CBSE, New Delhi <br>
                </p>
                <div class="address">
                    <span>Garh Road, Meerut - 250004 (U.P) PH: 012-3548-5561</span><br>
                    <span>E-mail: pgmis@live.com, Web: www.pgmischool.com</span>
                </div>
            </div>
        </div>
        <h4>Progress Card: (2024-2025)</h4>
        <div class="student-detials">
            <div class="sec-1">
                <table>
                    <tr>
                        <td class="text-bold">Student Name</td>
                        <td>:</td>
                        <td style="font-size: 0.78rem">{{ $studentName }}</td>
                    </tr>
                    <tr>
                        <td class="text-bold">Father`s Name</td>
                        <td>:</td>
                        <td style="font-size: 0.78rem">{{ $fatherName }}</td>
                    </tr>

                    <tr>
                        <td class="text-bold">Date of Birth</td>
                        <td>:</td>
                        <td style="font-size: 0.78rem">{{ $dob }}</td>
                    </tr>

                </table>
            </div>
            <div class="sec-2">
                {{-- <adm_nop class="text-bold"> Adm. No: 0952</adm_nop> --}}
            </div>
            <div class="sec-3">
                <table>
                    <tr>
                        <td class="text-bold">Roll No. </td>
                        <td>:</td>
                        <td style="font-size: 0.78rem">24</td>
                    </tr>
                    <tr>
                        <td class="text-bold">Class & Sec</td>
                        <td>:</td>
                        <td style="font-size: 0.78rem">
                            {{ $class }} , {{ $section }}
                        @foreach ($students->marks as $item)
                            {{ $item->max_marks }}
                        @endforeach
                        </td>
                    </tr>

                </table>
            </div>
        </div>
        <div class="student-marks">
            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    <th style="border: 1px solid black; padding: 1px; font-size:13px;">Scholastic Areas:
                    </th>
                    {{-- <th colspan="5" style="border: 1px solid black; padding: 1px; font-size:13px;">
                                Term-1(100 Marks)
                            </th> --}}
                    <th colspan="10" style="border: 1px solid black; padding: 1px; font-size:13px;">
                        Acadmic Performance
                    </th>
                    <th style="border: 1px solid black; padding: 1px; font-size:13px;">Grand Total</th>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 3px; font-size:13px;" class="text-bold-2">
                        Subject Name
                    </td>
                    {{-- Term-1 --}}
                    <td
                        style="border: 1px solid black; padding: 1px; font-size:12px; text-align:center;"class="text-bold-2">
                        Max. Mark</td>
                    <td
                        style="border: 1px solid black; padding: 1px; font-size:12px;text-align:center;"class="text-bold-2">
                        Theory Marks</td>
                    <td
                        style="border: 1px solid black; padding: 1px; font-size:12px; text-align:center;"class="text-bold-2">
                        Practical Marks</td>
                    <td
                        style="border: 1px solid black; padding: 1px; font-size:12px;text-align:center;"class="text-bold-2">
                        Grade</td>
                    {{-- Term-1 Total --}}
                    <td
                        style="border: 1px solid black; padding: 1px; font-size:12px; text-align:center;"class="text-bold-2">
                        Total T1(100)</td>



                    {{-- Term-2 --}}
                    <td
                        style="border: 1px solid black; padding: 1px; font-size:12px; text-align:center;"class="text-bold-2">
                        Max. Mark</td>
                    <td
                        style="border: 1px solid black; padding: 1px; font-size:12px;text-align:center;"class="text-bold-2">
                        Theory Marks</td>
                    <td
                        style="border: 1px solid black; padding: 1px; font-size:12px; text-align:center;"class="text-bold-2">
                        Practical Marks</td>
                    <td
                        style="border: 1px solid black; padding: 1px; font-size:12px;text-align:center;"class="text-bold-2">
                        Grade</td>
                    {{-- Term-2 Total --}}
                    <td
                        style="border: 1px solid black; padding: 1px; font-size:12px; text-align:center;"class="text-bold-2">
                        Total T2(100)</td>
                    {{-- Grand T1+T2 Total --}}
                    <td
                        style="border: 1px solid black; padding: 1px; font-size:12px; text-align:center;"class="text-bold-2">
                        Grand Total T1+T2(200)</td>

                </tr>

              
                <th colspan="5" style="border: 1px solid black; padding: 1px; font-size:13px; text-align:left;">
                    Total Term-1 Marks
                </th>
                <th colspan="1" style="border: 1px solid black; padding: 1px; font-size:13px; text-align:center;">
                    500
                </th>
                <th colspan="4" style="border: 1px solid black; padding: 1px; font-size:13px; text-align:left;">
                    Total Term-2 Marks
                </th>
                <th colspan="1" style="border: 1px solid black; padding: 1px; font-size:13px; text-align:center;">
                    508
                </th>
                <th colspan="1" style="border: 1px solid black; padding: 1px; font-size:13px; text-align:center;">
                    708
                </th>
            </table>
        </div>
        <div class="marks-total">

            <div class="student-percentage">
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <th style="border: 1px solid black; padding: 1px; font-size:13px;">Scholastic
                            Areas:</th>
                        <th style="border: 1px solid black; padding: 1px; font-size:13px;">Term-1</th>
                        <th style="border: 1px solid black; padding: 1px; font-size:13px;">Term-2</th>
                        <th style="border: 1px solid black; padding: 1px; font-size:13px;">Term-3</th>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; padding: 3px; font-size:13px;">Marks Obtained
                        </td>
                        <td style="border: 1px solid black; padding: 1px; font-size:13px; text-align:center;">
                            248.00
                        </td>
                        <td style="border: 1px solid black; padding: 1px; font-size:13px; text-align:center;">
                            356.00
                        </td>
                        <td style="border: 1px solid black; padding: 1px; font-size:13px; text-align:center;">
                            604.00
                        </td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; padding: 3px; font-size:13px;">Maximum Marks
                        </td>
                        <td style="border: 1px solid black; padding: 1px; font-size:13px; text-align:center;">
                            248.00
                        </td>
                        <td style="border: 1px solid black; padding: 1px; font-size:13px; text-align:center;">
                            356.00
                        </td>
                        <td style="border: 1px solid black; padding: 1px; font-size:13px; text-align:center;">
                            604.00
                        </td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; padding: 3px; font-size:13px;">Percentage</td>
                        <td style="border: 1px solid black; padding: 1px; font-size:13px; text-align:center;">
                            35.15%
                        </td>
                        <td style="border: 1px solid black; padding: 1px; font-size:13px; text-align:center;">
                            50.86%
                        </td>
                        <td style="border: 1px solid black; padding: 1px; font-size:13px; text-align:center;">
                            43.14%
                        </td>
                    </tr>
                </table>
            </div>
            <div class="student-attendance">
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <th style="border: 1px solid black; padding: 1px; font-size:13px; text-align:center;"
                            colspan="2">
                            Attendance
                        </th>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; padding: 3px; font-size:13px;">Total
                            Attendance</td>
                        <td style="border: 1px solid black; padding: 1px; font-size:13px; text-align:center;">
                            340
                        </td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; padding: 3px; font-size:13px;">No. of
                            Working Days</td>
                        <td style="border: 1px solid black; padding: 1px; font-size:13px; text-align:center;">
                            432
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="footer">
            <div class="foot-content">
                <p>Remark: He has a well-developed sense of humour</p>
                <p class="achive">Achievements: Secured 1st position in Rang Manch from Shourya House.</p>
                <p class="pading-left">Played in CBSE Cluster XIX Kho-Kho Boys !</p>
                <p class="pading-left">Participated in Boat Race From Shourya House !</p>
            </div>

            {{-- <div class="promote">
                        <p>Promoted to Class : __________________</p>
                    </div> --}}
            <div class="signature">
                <div class="sign">
                    <p>Signature:-</p>
                </div>
                <div class="teacher">
                    <p>Class Teacher</p>
                </div>
                <div class="principal">
                    <p>Principal</p>
                </div>
            </div>
            <div class="date">
                <p>Date: {{ \Carbon\Carbon::now()->format('d/m/Y') }}</p>
            </div>
        </div>
    </div>
    {{-- @endforeach --}}
    {{-- @if (!$loop->last)
        <div style="page-break-after: always;"></div>
    @endif
    @endforeach --}}
</body>

</html>
