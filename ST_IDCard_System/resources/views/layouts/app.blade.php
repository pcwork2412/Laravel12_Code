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
    {{-- <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.min.css"> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

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
    </style>
    @stack('styles')
</head>

<body>
    <div class="main-wrapper">
        @include('layouts.navbar')
        @include('layouts.sidebar')
        <div class="page-wrapper">
            <div class="content container-fluid">
                @include('layouts.flash-message')
                @yield('content')
            </div>
        </div>
    </div>
    @vite(['resources/js/app.js', 'resources/js/bootstrap.js', 'resources/css/app.css'])
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
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

    <!-- Toastr & SweetAlert -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Custom App JS -->
    <script src="{{ asset('pos/assets/js/app.js') }}"></script>

    @stack('scripts')
</body>

</html>
