<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge,chrome=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Favicon -->
    <link rel="icon" href="https://fomantic-ui.com/examples/assets/images/logo.png">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('semantic/dist/semantic.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">

    <!-- Scripts -->
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/moment.min.js') }}"></script>
    <script src="{{ asset('semantic/dist/semantic.min.js') }}"></script>
    <script src="{{ asset('js/load-image.all.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
</head>
<body>
    @yield('nav')
    @yield('content')
    @yield('js_code')
</body>
</html>
