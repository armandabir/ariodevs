<!DOCTYPE html>
<html lang="fa" dir="rtl" data-theme="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>آرمان دبیرمقدم | برنامه نویس وب و طراح سیستم های هوشمند</title>
        <link rel="icon" href="{{ asset('assets/images/snake.png') }}">

        @viteReactRefresh
        @vite(['resources/css/index.css', 'resources/css/css-bunny-fonts.css', 'resources/js/index.jsx', 'resources/sass/app.scss'])
    </head>

    <body data-theme="dark">
        <div id="app"></div>
    </body>
</html>
