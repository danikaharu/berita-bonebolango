<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <meta charset="UTF-8" />
    <title>{{ $tabloid->title }} - Berita Bone Bolango</title>

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('template/home') }} /assets/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32"
        href="{{ asset('template/home') }}/assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16"
        href="{{ asset('template/home') }}/assets/favicon/favicon-16x16.png">
    <link rel="manifest" href="{{ asset('template/home') }}/assets/favicon/site.webmanifest">

    <!-- Facebook Meta Tags -->
    <meta property="og:url" content="{{ route('detailTabloid', $tabloid->slug) }}">
    <meta property="og:type" content="article">
    <meta property="og:title" content="{{ $tabloid->title }}">
    <meta property="og:description" content="{{ $tabloid->title }}">
    <meta property="og:image" content="{{ asset('storage/uploads/tabloids/thumbnail/' . $tabloid->thumbnail) }}">

    <!-- Twitter Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta property="twitter:domain" content="berita.bonebolangokab.go.id">
    <meta property="twitter:url" content="{{ route('detailTabloid', $tabloid->slug) }}">
    <meta name="twitter:title" content="{{ $tabloid->title }}">
    <meta name="twitter:description" content="{{ $tabloid->title }}">
    <meta name="twitter:image" content="{{ asset('storage/uploads/tabloids/thumbnail/' . $tabloid->thumbnail) }}">

    <link rel="stylesheet" href="{{ asset('template/home/assets/css/jquery.touchPDF.css') }}" />
    <style>
        body,
        html {
            background-color: #404040;
            height: 100%;
            padding: 0;
            margin: 0;
        }
    </style>
</head>

<body>
    <div id="myPDF" style="height: 100%; width: 100%; margin: auto;"></div>

    <script src="{{ asset('template/home/assets/js') }}/pdf.compatibility.js"></script>
    <script src="{{ asset('template/home/assets/js') }}/pdf.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="{{ asset('template/home/assets/js') }}/jquery.touchSwipe.js"></script>
    <script src="{{ asset('template/home/assets/js') }}/jquery.touchPDF.js"></script>
    <script src="{{ asset('template/home/assets/js') }}/jquery.panzoom.js"></script>
    <script src="{{ asset('template/home/assets/js') }}/jquery.mousewheel.js"></script>
    <script>
        $(function() {
            $("#myPDF").pdf({
                source: "{{ asset('storage/uploads/tabloids/' . $tabloid->file) }}",
                title: "{{ $tabloid->title }}"
            });
        });
    </script>
</body>

</html>
