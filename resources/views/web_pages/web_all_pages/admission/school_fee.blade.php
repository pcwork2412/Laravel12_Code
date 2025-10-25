@extends('web_layouts.app')
@section('content')
    <!-- Header Start -->
    <div class="jumbotron jumbotron-fluid page-header position-relative mb-5" style="margin-bottom: 50px">
        <div class="container text-center py-5">
            <h1 class="text-white display-3">School Fee Structure</h1>
            <div class="d-inline-flex text-white mb-5">
                <p class="m-0 text-uppercase">
                    <a class="text-white" href="{{ route('web.index') }}">Home</a>
                </p>
                <i class="fa fa-angle-double-right pt-1 px-3"></i>
                <p class="m-0 text-uppercase">School Fee Structure</p>
            </div>
        </div>
    </div>
    <!-- Header End -->

    <!-- School Fee Table Section Start -->
    <div class="container">
        <header>
            <h1>SCHOOL FEE STRUCTURE</h1>
            <h2>2025-26 Academic Year (New Admissions)</h2>
        </header>
        
        {{-- <div class="download-section">
            <button id="downloadBtn" class="btn">
                <i class="fas fa-download"></i> Download as PDF
            </button>
            <p class="instructions">Click the button above to download the fee structure as a PDF file</p>
        </div> --}}
        
        <div class="card">
            <div class="section">
                <h2 class="section-title">Installment Schedule</h2>
                <p>The Composite Annual Fee and Exam Fee has to be paid in TEN installments as follows:</p>
                
                <table>
                    <thead>
                        <tr>
                            <th>Installment No.</th>
                            <th>Due Date / Month</th>
                            <th>Nursery/LKG/UKG</th>
                            <th>I-II-III</th>
                            <th>IV-VI</th>
                            <th>VII-VIII</th>
                            <th>IX-X</th>
                            <th>XI-XII</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>10th April (April+Exam)</td>
                            <td>3300</td>
                            <td>3850</td>
                            <td>4200</td>
                            <td>4450</td>
                            <td>5350</td>
                            <td>5550</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>10th May (May+June)</td>
                            <td>4200</td>
                            <td>4900</td>
                            <td>5600</td>
                            <td>6100</td>
                            <td>7500</td>
                            <td>7900</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>10th July</td>
                            <td>2100</td>
                            <td>2450</td>
                            <td>2800</td>
                            <td>3050</td>
                            <td>3750</td>
                            <td>3950</td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>10th August</td>
                            <td>2100</td>
                            <td>2450</td>
                            <td>2800</td>
                            <td>3050</td>
                            <td>3750</td>
                            <td>3950</td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>10th September</td>
                            <td>2100</td>
                            <td>2450</td>
                            <td>2800</td>
                            <td>3050</td>
                            <td>3750</td>
                            <td>3950</td>
                        </tr>
                        <tr>
                            <td>6</td>
                            <td>10th October</td>
                            <td>2100</td>
                            <td>2450</td>
                            <td>2800</td>
                            <td>3050</td>
                            <td>3750</td>
                            <td>3950</td>
                        </tr>
                        <tr>
                            <td>7</td>
                            <td>10th November</td>
                            <td>2100</td>
                            <td>2450</td>
                            <td>2800</td>
                            <td>3050</td>
                            <td>3750</td>
                            <td>3950</td>
                        </tr>
                        <tr>
                            <td>8</td>
                            <td>10th December</td>
                            <td>2100</td>
                            <td>2450</td>
                            <td>2800</td>
                            <td>3050</td>
                            <td>3750</td>
                            <td>3950</td>
                        </tr>
                        <tr>
                            <td>9</td>
                            <td>10th January</td>
                            <td>2100</td>
                            <td>2450</td>
                            <td>2800</td>
                            <td>3050</td>
                            <td>3750</td>
                            <td>3950</td>
                        </tr>
                        <tr>
                            <td>10</td>
                            <td>10th February (Feb+March)</td>
                            <td>4200</td>
                            <td>4900</td>
                            <td>5600</td>
                            <td>6100</td>
                            <td>7500</td>
                            <td>7900</td>
                        </tr>
                        <tr class="total-row">
                            <td colspan="2">Total</td>
                            <td>26,400</td>
                            <td>30,800</td>
                            <td>35,000</td>
                            <td>38,000</td>
                            <td>46,600</td>
                            <td>49,000</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div class="section">
                <h2 class="section-title">Fee Breakdown</h2>
                
                <table>
                    <thead>
                        <tr>
                            <th>Fee Head</th>
                            <th>Nursery/LKG/UKG</th>
                            <th>I-II-III</th>
                            <th>IV-VI</th>
                            <th>VII-VIII</th>
                            <th>IX-X</th>
                            <th>XI-XII</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Registration Fee</td>
                            <td>500</td>
                            <td>500</td>
                            <td>500</td>
                            <td>500</td>
                            <td>500</td>
                            <td>500</td>
                        </tr>
                        <tr>
                            <td>Admission Fee</td>
                            <td>10000</td>
                            <td>10000</td>
                            <td>11000</td>
                            <td>13000</td>
                            <td>13000</td>
                            <td>13000</td>
                        </tr>
                        <tr>
                            <td>Composite Annual Fee</td>
                            <td>25200</td>
                            <td>29400</td>
                            <td>33600</td>
                            <td>36600</td>
                            <td>45000</td>
                            <td>47400</td>
                        </tr>
                        <tr>
                            <td>Examination Fee</td>
                            <td>1200</td>
                            <td>1400</td>
                            <td>1400</td>
                            <td>1400</td>
                            <td>1600</td>
                            <td>1600</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div class="notes">
                <h3>Important Notes:</h3>
                <ol>
                    <li>Parents depositing Full Term fee by <span class="highlight">15th April</span> can avail <span class="highlight">4% rebate</span> in Composite Annual Fee for the year.</li>
                    <li>Fee has to be deposited by <span class="highlight">10th of due month</span>. Further 5 days will be grace period.</li>
                    <li>Late Fee fine will be applicable from <span class="highlight">16th of due month</span> @ Rs 80/- p.m. for each month of delay.</li>
                    <li>Fee can be deposited through Online Bank Transfer / Paytm / Debit or Credit card or by cash in Fee Office. <span class="highlight">Cheques are not accepted</span>.</li>
                    <li>The academic & co-curricular activities of the student will be suspended if fee is pending for two consecutive instalments.</li>
                    <li>Third child of a parent can avail <span class="highlight">20% discount</span> on Composite Annual Fee.</li>
                    <li>Admission will be considered complete only after dues have been paid and all documents submitted.</li>
                    <li>Board Registration/Examination Fee (for IX, X, XI, XII) will be charged extra as per CBSE.</li>
                </ol>
            </div>
            
            {{-- <div class="declaration">
                <h3>Declaration by Parents:</h3>
                <p>I/we have read and understood the fee structure for 2025-26 session for new students. I have no objection to the same. I promise to pay the fee on time. I have received a copy of the fee structure for my reference.</p>
                
                <div class="form-fields">
                    <div class="form-field">
                        <label>Name of Student:</label>
                        <div class="dotted-line"></div>
                    </div>
                    <div class="form-field">
                        <label>Class Admitted:</label>
                        <div class="dotted-line"></div>
                    </div>
                    <div class="form-field">
                        <label>Father's Name:</label>
                        <div class="dotted-line"></div>
                    </div>
                    <div class="form-field">
                        <label>Father's Signature:</label>
                        <div class="dotted-line"></div>
                    </div>
                    <div class="form-field">
                        <label>Mother's Name:</label>
                        <div class="dotted-line"></div>
                    </div>
                    <div class="form-field">
                        <label>Mother's Signature:</label>
                        <div class="dotted-line"></div>
                    </div>
                    <div class="form-field">
                        <label>Date:</label>
                        <div class="dotted-line" style="max-width: 150px;"></div>
                        <label style="width: 70px; margin-left: 20px;">Place:</label>
                        <div class="dotted-line" style="max-width: 150px;"></div>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
    <!-- School Fee Table Section End -->
@endsection
