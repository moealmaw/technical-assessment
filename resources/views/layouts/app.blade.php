<!doctype html>
<html lang="{{ app()->getLocale() }}" class="bg-white antialiased h-full relative">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet" type="text/css">
    <link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500">

</head>
<body class="font-source-sans font-normal text-black leading-normal h-full relative">
<div id="app" class="h-full relative">
    @yield('content')
</div>
<script src="{{ mix('js/app.js') }}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD7dKISLlbFBBiIyOpIOVjYqDBykD432LM&libraries=places&callback=app.GoogleMapsLibLoaded" async defer></script>
</body>
</html>
