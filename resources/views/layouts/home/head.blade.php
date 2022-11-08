<!doctype html>
<html lang="en">

<head>
    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') - Berita Bone Bolango</title>
    <meta name="description" itemprop="description"
        content="Berita Bone Bolango adalah Website Berita Resmi Pemkab Bone Bolango">
    <meta name="keywords" content="Berita Bone Bolango, Bone Bolango,  Website Berita Resmi Pemkab Bone Bolango" />
    <meta name="author" content="Berita Bone Bolango">

    @stack('seo')

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180"
        href="{{ asset('template/home') }} /assets/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32"
        href="{{ asset('template/home') }}/assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16"
        href="{{ asset('template/home') }}/assets/favicon/favicon-16x16.png">
    <link rel="manifest" href="{{ asset('template/home') }}/assets/favicon/site.webmanifest">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
        integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    @stack('style')

    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ asset('template/home') }}/assets/css/main.css">


</head>

<body>
