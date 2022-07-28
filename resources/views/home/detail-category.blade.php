@extends('layouts.home.app')

@section('title')
    {{ $category->title }}
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
                <li class="breadcrumb-item"><a href="#">Indeks</a></li>
                <li class="breadcrumb-item active" aria-current="page"> {{ $category->title }}</li>
            </ol>
        </nav>
    </div>

    <section>
        <div class="container-fluid">
            <h4 class="section__title-sub">INDEKS : {{ $category->title }}</h4>
            <div class="row">
                @foreach ($categories as $article)
                    <div class="col-lg-4 mb-4">
                        <div class="highlight__image">
                            <a href="{{ route('detailArticle', $article->slug) }}">
                                <img src="{{ asset('storage/uploads/articles/' . $article->thumbnail) }}" alt="article"
                                    style="object-fit: cover; width: 100%; height: 10.5rem;">
                            </a>
                        </div>
                        <h5 class=" highlight-title">
                            <a href="{{ route('detailArticle', $article->slug) }}">{{ $article->title }}</a>
                        </h5>
                        <div class="highlight-info">
                            <small>By <span style="font-weight: bold;">{{ $article->user->name }}</span> -
                                {{ $article->created_at }}</small>
                            <small style="margin-left: 0.9rem;"><i class="far fa-clock"></i>
                                {{ $article->created_at->diffForHumans() }}</small>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{ $categories->links() }}
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
