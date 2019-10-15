<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script type="text/javascript">
        $(function () {
            @yield('js_code')
        });
    </script>
</head>
<body>
    <nav class="navbar navbar-dark bg-dark">
        <section class="container">
            <span class="navbar-brand">G-Tracer</span>
        </section>
    </nav>
    <section class="container mt-5">
        @yield('content_form')
    </section>
    <section class="container mt-5">
        @yield('content_list')
    </section>
</body>
</html>
