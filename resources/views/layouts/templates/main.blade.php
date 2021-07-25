<!-- 
* Bootstrap Simple Admin Template
* Version: 2.1
* Author: Alexis Luna
* Website: https://github.com/alexis-luna/bootstrap-simple-admin-template
-->
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>GIS Project</title>
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- template style -->
    <link href="{{ asset('assets/vendor/fontawesome/css/fontawesome.min.css'); }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/fontawesome/css/solid.min.css'); }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/fontawesome/css/brands.min.css'); }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css'); }}" rel="stylesheet">
    <link href="{{ asset('assets/css/master.css'); }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/chartsjs/Chart.min.css'); }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/flagiconcss/css/flag-icon.min.css'); }}" rel="stylesheet">

    <!-- custom style -->
    @stack('custom-style')
</head>

<body>
    <div class="wrapper">
        
        <!-- sidebar -->
        @include('layouts.sidebar.index')
        <!-- end of sidebar -->

        <div id="body" class="active">
            <!-- navbar -->
            @include('layouts.navbar.index')
            <!-- end of navbar -->

            <!-- content -->
            <div class="content">
                @yield('content')
            </div>
            <!-- end of content -->
        </div>
    </div>

    <!-- template scripts -->
    <script src="{{ asset('assets/vendor/jquery/jquery.min.js'); }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js'); }}"></script>
    <script src="{{ asset('assets/vendor/chartsjs/Chart.min.js'); }}"></script>
    <script src="{{ asset('assets/js/dashboard-charts.js'); }}"></script>
    <script src="{{ asset('assets/js/script.js'); }}"></script>
    <!-- custom script -->
    @stack('custom-script')
</body>

</html>