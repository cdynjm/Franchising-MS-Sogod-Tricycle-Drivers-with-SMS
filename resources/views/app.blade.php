<!doctype html>
<html lang="en">
<head>

    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="token" content="{{ Session::get('token') }}">

    <title>Franchising-MS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesdesign" name="author" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('storage/logo/logo-sogod.png') }}">

    <!-- plugin css -->
    <link href="/assets/libs/jsvectormap/css/jsvectormap.min.css" rel="stylesheet" type="text/css" />

    <!-- Bootstrap Css -->
    <link href="/assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <!-- App Css-->
    <link href="/assets/css/app.min.css?3" id="app-style" rel="stylesheet" type="text/css" />

    <!-- datepicker css -->
    <link rel="stylesheet" href="assets/libs/flatpickr/flatpickr.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.min.css'
        data-navigate-once>
        
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <script src="/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.all.min.js" data-navigate-once></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js" data-navigate-once></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.3.5/js/swiper.min.js" data-navigate-once></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js" data-navigate-once></script>
    <script type="text/javascript" src="https://html2canvas.hertzen.com/dist/html2canvas.js" data-navigate-once></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js" data-navigate-once></script>
    <script src="https://cdn.lordicon.com/lordicon.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js" data-navigate-once></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs" defer></script>

    @if (Auth::check())
        <script src="{{ asset('assets/js/signout.js?id=04062024') }}" data-navigate-once></script>
        @if (Auth::user()->role == 1)
            <script src="{{ asset('assets/js/admin.js?id=071824') }}" data-navigate-once></script>
        @endif
        @if (Auth::user()->role == 2)
            <script src="{{ asset('assets/js/user.js?id=07182024') }}" data-navigate-once></script>
        @endif
    @else
        <script src="{{ asset('assets/js/signin.js?id=0718024') }}" data-navigate-once></script>
        <script src="{{ asset('assets/js/register.js?id=0712024') }}" data-navigate-once></script>
    @endif


    <script>
        window.onpopstate = function(event) {
            window.location.reload(true);
        };
    </script>

    @livewireStyles
</head>

<body>

    @yield('content')

    <!-- JAVASCRIPT -->
    <script src="/assets/libs/metismenujs/metismenujs.min.js"></script>
    <script src="/assets/libs/simplebar/simplebar.min.js"></script>
    <script src="/assets/libs/eva-icons/eva.min.js"></script>

    <!-- Vector map-->
    <script src="/assets/libs/jsvectormap/js/jsvectormap.min.js"></script>
    <script src="/assets/libs/jsvectormap/maps/world-merc.js"></script>

    <script src="/assets/js/pages/dashboard.init.js"></script>

    <!-- form wizard init -->
    <script src="/assets/js/pages/form-wizard.init.js"></script>

    @if (Auth::check())
        <script src="/assets/js/pages/form-wizard-renew.init.js"></script>
    @endif

    <script src="/assets/js/pages/dashboard-sales.init.js"></script>

    <script src="/assets/js/app.js"></script>

    @livewireScripts
</body>
</html>
