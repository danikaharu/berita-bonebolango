@extends('layouts.home.app')

@section('title')
    {{ $album->title }}
@endsection

@push('style')
    <!-- Lightbox -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/AlexEmashev/lsb-lightbox@master/dist/lsb.css">
@endpush

@section('content')
    <div class="container-fluid my-5">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Potret Bonebol</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $album->title }}</li>
            </ol>
        </nav>
    </div>

    <section class="detail__gallery">
        <div class="container-fluid">
            <span class="border-title"></span>
            <h2>{{ $album->title }}</h2>
            <p>{{ $album->body }}</p>
            <div class="detail__gallery-info">
                <span>By <b style="font-weight: bold;">{{ $album->user->name }}</b> - {{ $album->created_at }}</span>
                <span><i class="fas fa-clock"></i> {{ $album->created_at->diffForHumans() }}</span>
                <span><i class="fas fa-eye"></i> {{ $pageViewGallery['rows'][0][2] ?? 0 }}
                    view</span>
            </div>
            <div class="detail__gallery-image">
                <div class="row">
                    @foreach ($album->galleries as $gallery)
                        @if ($gallery->file == null)
                            <img src="https://via.placeholder.com/350?text=No+Image+Avaiable" alt="File" class="rounded"
                                width="200" height="150" style="object-fit: cover">
                        @else
                            <div class="col-lg-3">
                                <a href="{{ asset('storage/uploads/galleries/' . $gallery->file) }}" class="lsb-preview"
                                    data-lsb-group="gallery1">
                                    <img src="{{ asset('storage/uploads/galleries/' . $gallery->file) }}"
                                        alt="{{ $gallery->caption }}">
                                    <span><i class="fas fa-search-plus"></i> Perbesar</span>
                                </a>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endsection

@push('js')
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-2.2.4.min.js"
        integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
    <!-- Lightbox -->
    <script src="https://cdn.jsdelivr.net/gh/AlexEmashev/lsb-lightbox@master/dist/lsb.min.js"></script>
    <script>
        $(window).load(function() {
            $.fn.lightspeedBox();
        });
    </script>
@endpush
