<!DOCTYPE html>
<html lang="{{ $locale }}" dir="{{ $dir }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ isset($title) ? $title.' | '.$t['meta']['name'] : $t['meta']['title'] }}</title>
    <meta name="description" content="{{ $t['meta']['description'] }}">
    <meta name="theme-color" content="#151719">
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="32x32">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="alternate" hreflang="en" href="{{ route(Route::currentRouteName(), ['locale' => 'en']) }}">
    <link rel="alternate" hreflang="ar" href="{{ route(Route::currentRouteName(), ['locale' => 'ar']) }}">
    @stack('head')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    @include('partials.header', ['light' => $headerLight ?? false])

    <main>
        @yield('content')
    </main>

    @include('partials.footer')
</body>
</html>
