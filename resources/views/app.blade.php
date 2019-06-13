<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'BLS_API') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div class="container-fluid justify-content-center">
        <h1>BLS-API</h1>
        <h4>Developer: Šarūnas Živila</h4><br>
        <h2>Code:github.com/sarziv - Sorry but its privated and only will be given to BLS staff</h2><br>
        <h4>Front-end: React.js</h4><br>
        <h4>Backend-end: Laravel + Passport</h4><br>
        <h6>Problems with site? Call: +370687020656</h6>
    </div>
</body>
</html>
