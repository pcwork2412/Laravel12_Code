<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="Smarthr - Bootstrap Admin Template">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>School System - Dashboard</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('pos/images/Logo.png') }}">

    <!-- Google Fonts & Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('pos/assets/css/bootstrap.min.css') }}">

    <!-- Plugins CSS -->
    <link rel="stylesheet" href="{{ asset('pos/assets/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('pos/assets/css/line-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('pos/assets/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('pos/assets/css/bootstrap-datetimepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('pos/assets/plugins/morris/morris.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <!-- ✅ DataTables Buttons CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.min.css">
    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ asset('pos/assets/css/style.css') }}">

    <!-- Custom Style -->
    <link rel="stylesheet" href="{{ asset('pos/assets/css/customcss/inquiretable.css') }}">

    <style>
        .table-bordered td,
        .table-bordered th {
            border: 1px solid #dee2e6;
            vertical-align: middle;
        }

        /* Mini Sidebar (for desktop) */
        .mini-sidebar .sidebar {
            position: fixed;
            left: -260px;
            top: 0;
            height: 100vh;
            background: black;
            /* 90% white */
            backdrop-filter: blur(8px);
            /* glass effect */
            -webkit-backdrop-filter: blur(8px);
            z-index: 999;
            transition: all 0.3s ease;
        }

        .mini-sidebar .sidebar .submenu ul {
            display: none !important;
        }

        /* Mobile Sidebar (for small screens) */
        .sidebar.open {
            left: 0;
            transition: all 0.3s ease;
        }

        @media (max-width: 991px) {
            .sidebar {
                position: fixed;
                left: -260px;
                top: 0;
                height: 100vh;
                width: 260px;
                background: rgba(255, 255, 255, 0.96);
                backdrop-filter: blur(6px);
                -webkit-backdrop-filter: blur(6px);
                box-shadow: 2px 0 15px rgba(0, 0, 0, 0.2);
                z-index: 999;
                transition: all 0.3s ease;
            }

            .sidebar.open {
                left: 0;
            }

            .sidebar-overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.3);
                z-index: 998;
                display: none;
            }

            .sidebar.open~.sidebar-overlay {
                display: block;
            }
        }
    </style>
    @stack('styles')
</head>

<body>
    <div class="main-wrapper">
        @include('School_Dashboard.Admin_Layouts.navbar')
        @include('School_Dashboard.Admin_Layouts.sidebar')
        <div class="page-wrapper">
            <div class="content container-fluid">
                @include('School_Dashboard.Admin_Layouts.flash-message')
                {{-- <button id="smartBackBtn" class="btn btn-outline-secondary btn-sm">
    <i class="fa fa-arrow-left me-1"></i> Back
</button> --}}


                @yield('content')
            </div>
        </div>
    </div>

    <!-- Core JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Feathers Icons --}}
    <script src="https://unpkg.com/feather-icons"></script>

    <!-- Plugins JS -->
    <script src="{{ asset('pos/assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('pos/assets/js/jquery.slimscroll.min.js') }}"></script>
    <script src="{{ asset('pos/assets/js/select2.min.js') }}"></script>
    <script src="{{ asset('pos/assets/js/moment.min.js') }}"></script>
    <script src="{{ asset('pos/assets/js/bootstrap-datetimepicker.min.js') }}"></script>

    <!-- Charts JS -->
    <script src="{{ asset('pos/assets/plugins/raphael/raphael.min.js') }}"></script>
    <script src="{{ asset('pos/assets/plugins/morris/morris.min.js') }}"></script>
    <script src="{{ asset('pos/assets/js/chart.js') }}"></script>

    <!-- Axios (zaroori) -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    {{-- jQuery, DataTables & SweetAlert --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <!-- ✅ DataTables Buttons JS -->
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

    <!-- Toastr & SweetAlert -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

    <!-- CDN: html2canvas + jsPDF (UMD). NOTE: order matters (html2canvas first) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.31/jspdf.plugin.autotable.min.js"></script>
    <script>
        $(document).ready(function() {
            // Desktop sidebar toggle
            $('#toggle_btn').on('click', function(e) {
                e.preventDefault();
                $('body').toggleClass('mini-sidebar');
            });

            // Mobile sidebar toggle
            $('#mobile_btn').on('click', function(e) {
                e.preventDefault();
                $('.sidebar').toggleClass('open');
            });
        });
    </script>

    <!-- Custom App JS -->
    <script src="{{ asset('pos/assets/js/app.js') }}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let currentUrl = window.location.href;
            let historyStack = JSON.parse(sessionStorage.getItem("pageHistory")) || [];

            // ✅ अगर नया पेज है तो stack में जोड़ो
            if (historyStack.length === 0 || historyStack[historyStack.length - 1] !== currentUrl) {
                historyStack.push(currentUrl);
                sessionStorage.setItem("pageHistory", JSON.stringify(historyStack));
            }
            // OR
            //    if (!historyStack.includes(currentUrl)) {
            //     historyStack.push(currentUrl);
            //     sessionStorage.setItem("pageHistory", JSON.stringify(historyStack));
            // }

            // 🔙 जब user back बटन दबाए तो पिछला पेज दिखाओ
            const backButton = document.querySelector("#smartBackBtn");
            if (backButton) {
                backButton.addEventListener("click", function() {
                    let stack = JSON.parse(sessionStorage.getItem("pageHistory")) || [];

                    if (stack.length > 1) {
                        // current URL हटाओ
                        stack.pop();
                        // previous URL निकालो
                        let prevUrl = stack.pop();
                        sessionStorage.setItem("pageHistory", JSON.stringify(stack));
                        window.location.href = prevUrl;
                    } else {
                        // fallback अगर कुछ नहीं है
                        window.location.href = "{{ route('admin.dashboard') }}";
                    }
                });
            }
        });
    </script>


    @stack('scripts')
</body>

</html>
