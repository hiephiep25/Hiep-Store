<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ env('APP_NAME', 'HiepStore') }}</title>

    {{-- favicon --}}
    <link rel="shortcut icon" href="{{ asset('/images/icon.png') }}" />
    <link rel="apple-touch-icon" sizes="128x128" href="{{ asset('/images/icon.png') }}">
    <link rel="icon" type="image/png" sizes="128x128" href="{{ asset('/images/icon.png') }}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{ asset('/images/icon.png') }}">

    <!-- Font Awesome -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="q-app"></div>
</body>
</html>
