<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- icon browser -->
        <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
        <link rel="icon" type="image/png" sizes="16x16" href="/icons/favicon-16x16.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/icons/favicon-32x32.png">        
        <link rel="icon" type="image/png" sizes="96x96" href="/icons/favicon-96x96.png">

        <!-- icon apple -->
        <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon-180x180.png">

        <!-- icon android -->
        <link rel="manifest" href="/android-manifest.json">
        <link rel="icon" type="image/png" sizes="192x192" href="/icons/android-icon-192x192.png">

        <!-- icon windows -->
        <meta name="msapplication-config" content="/ms-browserconfig.xml" />
        <meta name="msapplication-square310x310logo" content="/icons/mstile-310x310.png">
        
        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">

        <!-- Scripts -->
        @routes
        <script src="{{ mix('js/app.js') }}" defer></script>
    </head>
    <body class="font-sans antialiased">
        @inertia
    </body>
</html>
