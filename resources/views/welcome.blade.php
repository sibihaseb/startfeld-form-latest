<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Fokus Network</title>

    @vite('resources/js/app.ts')
    @vite('resources/js/assets/scss/main.scss')

    <!-- Favicon  -->
    <link rel="icon" sizes="32x32" href="{{ asset('favicon.ico') }}" />


    <!-- Styles -->
    <style>

    </style>
</head>

<body>
    <div id=app></div>
</body>

</html>
