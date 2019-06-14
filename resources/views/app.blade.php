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
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div class="container-fluid justify-content-center">
        <h1>BLS-API</h1>
        <h4>Developer: Šarūnas Živila</h4><br>
        <h4>Open source project</h4><br>
        <h4>Front-end: React.js[Material-UI,CSS3,HTML5,Bootstrap4]</h4><br>
        <h4>Backend-end: Laravel[PHP]</h4><br>
        <h4>Made with <i class="fas fa-heart"></i> and <i class="fas fa-mug-hot"></i></h4><br>
        <h6>Problems with site? Call: +370687020656</h6>
    </div>
</body>
</html>
