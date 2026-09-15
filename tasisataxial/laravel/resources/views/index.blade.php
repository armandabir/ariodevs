
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>تاسیسات آکسیال</title>

        @viteReactRefresh
        @vite(['resources/css/index.css', 'resources/css/css-bunny-fonts.css', 'resources/js/index.jsx'])

    </head>

    <body>
        <div id="app" data-page="@isset($result){{$result}}@else null @endisset"></div>
    </body>

    @if(session()->has('string'))
         @include('layouts.alert')
    @endif
</html>
