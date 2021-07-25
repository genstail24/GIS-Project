<!doctype html>
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

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Gis Project</title>
    
    <!-- styles -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css'); }}" rel="stylesheet">
    <link href="{{ asset('assets/css/auth.css'); }}" rel="stylesheet">
</head>

<body>
    <div class="wrapper">
        <div class="auth-content">
            <div class="card">
                @yield('content')
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/vendor/jquery/jquery.min.js'); }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.min.js'); }}"></script>
</body>

</html>