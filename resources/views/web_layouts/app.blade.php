<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Edukate - Online Education Website Template</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="Free HTML Templates" name="keywords" />
    <meta content="Free HTML Templates" name="description" />

    <!-- ========== Favicon ========== -->
    <link href="img/favicon.ico" rel="icon" />

    <!-- ========== Google Web Fonts ========== -->
    <link rel="preconnect" href="https://fonts.gstatic.com" />
    <link
        href="https://fonts.googleapis.com/css2?family=Jost:wght@500;600;700&family=Open+Sans:wght@400;600&display=swap"
        rel="stylesheet" />

    <!-- ========== Font Awesome (Latest Version) ========== -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" rel="stylesheet" />

    <!-- ========== CSS Libraries (Carousel, Bootstrap etc.) ========== -->
    <link href="{{ asset('website/assets/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet" />
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">

    
    <!-- ========== Custom Stylesheets ========== -->
    <link href="{{ asset('website/assets/css/responsive.css') }}" rel="stylesheet" />
    <link href="{{ asset('website/assets/css/custom.css') }}" rel="stylesheet" />

    <!-- ========== Lightbox (BaguetteBox) CSS ========== -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.10.0/baguetteBox.min.css" />
</head>

<body>
    <div class="main_wrapper">
        {{-- ========== Navbar Include ========== --}}
        @include('web_layouts.navbar')

        {{-- ========== Page Content ========== --}}
        @yield('content')

        {{-- ========== Footer Include ========== --}}
        @include('web_layouts.footer')
    </div>

    <!-- ========== Lightbox (Fancybox) ========== -->
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css"
        media="screen">
    <script src="//cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js"></script>

    <!-- ========== JavaScript Libraries ========== -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('website/assets/lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('website/assets/lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ asset('website/assets/lib/counterup/counterup.min.js') }}"></script>
    <script src="{{ asset('website/assets/lib/owlcarousel/owl.carousel.min.js') }}"></script>

    <!-- ========== Template Custom JS ========== -->
    <script src="{{ asset('website/assets/js/main.js') }}"></script>

    <!-- ========== Lightbox (BaguetteBox) JS ========== -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.10.0/baguetteBox.min.js"></script>
    <script>
        baguetteBox.run('.compact-gallery', {
            animation: 'slideIn'
        });
    </script>
    @stack('styles')
    @stack('scripts')
</body>

</html>
