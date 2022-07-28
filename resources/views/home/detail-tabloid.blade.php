<!DOCTYPE html>
<html>

<head>
    <title>Majalah - Berita Bone Bolango</title>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="{{ asset('template/home/assets/css/flipbook.css') }}" />
</head>

<body>
    <div id="app">
        <div role="toolbar" id="toolbar">
            <div id="pager">
                <button data-pager="prev">prev</button>
                <button data-pager="next">next</button>
            </div>
            <div id="page-mode">
                <label>Page Mode <input type="number" value="1" min="1" /></label>
            </div>
        </div>
        <div id="viewport-container">
            <div role="main" id="viewport"></div>
        </div>
    </div>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.0.87/compatibility.js"></script>
    <script src="https://unpkg.com/pdfjs-dist@2.0.489/build/pdf.min.js"></script>
    <script src="{{ asset('template/home/assets/js/flipbook.js') }}"></script>
    <script>
        initPDFViewer("{{ asset('storage/uploads/tabloids/' . $tabloid->file) }}");
    </script>
</body>

</html>
