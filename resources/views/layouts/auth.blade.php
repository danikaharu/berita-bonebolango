<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - {{ config('app.name', 'Laravel') }}</title>
    <link rel="stylesheet" href="{{ asset('mazer') }}/css/main/app.css">
    @stack('css')
    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('template/home') }} /assets/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32"
        href="{{ asset('template/home') }}/assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16"
        href="{{ asset('template/home') }}/assets/favicon/favicon-16x16.png">
    <link rel="manifest" href="{{ asset('template/home') }}/assets/favicon/site.webmanifest">
</head>
</head>

<body>
    <div id="auth">
        @yield('content')
    </div>

    <script src="{{ asset('mazer') }}/js/app.js"></script>
</body>

</html>
