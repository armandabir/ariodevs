<!DOCTYPE html>
<html lang="{{ app()->currentLocale() }}" dir="rtl" data-theme="light">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>آرمان دبیرمقدم | ArioDevs — وب دولوپر و سیستم‌های هوشمند</title>
        <link rel="icon" href="{{ asset('assets/images/snake.png') }}">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inconsolata:wght@400;500;600;700;800&display=swap" rel="stylesheet">

        @viteReactRefresh
        @vite(['resources/css/index.css', 'resources/css/css-bunny-fonts.css', 'resources/js/index.jsx', 'resources/sass/app.scss'])
    </head>

    <body data-theme="light">
        <div id="app"></div>
        <script>
            (function () {
                try {
                    if (sessionStorage.getItem('vl_sent')) return;
                    sessionStorage.setItem('vl_sent', '1');
                    fetch('/visitor-location', {
                        method: 'POST',
                        credentials: 'same-origin',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({ timezone: Intl.DateTimeFormat().resolvedOptions().timeZone })
                    });
                } catch (e) {}
            })();
        </script>
    </body>
</html>
