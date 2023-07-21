@extends('layouts.home.app')

@section('title')
    {{ $pressRelease->title }}
@endsection

@push('seo')
    <!-- Facebook Meta Tags -->
    <meta property="og:url" content="{{ route('detailPressRelease', $pressRelease->slug) }}">
    <meta property="og:type" content="article">
    <meta property="og:title" content="{{ $pressRelease->title }}">
    <meta property="og:description" content="{!! Str::limit(strip_tags($pressRelease->body), $limit = 100, $end = '...') !!}">
    <meta property="og:image" content="{{ asset('storage/uploads/press-releases/' . $pressRelease->thumbnail) }}">

    <!-- Twitter Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta property="twitter:domain" content="berita.bonebolangokab.go.id">
    <meta property="twitter:url" content="{{ route('detailPressRelease', $pressRelease->slug) }}">
    <meta name="twitter:title" content="{{ $pressRelease->title }}">
    <meta name="twitter:description" content="{!! Str::limit(strip_tags($pressRelease->body), $limit = 100, $end = '...') !!}">
    <meta name="twitter:image" content="{{ asset('storage/uploads/press-releases/' . $pressRelease->thumbnail) }}">
@endpush

@section('content')
    <div class="container-fluid my-5">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('pressRelease') }}">Siaran Pers</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">{{ $pressRelease->title }}</li>
            </ol>
        </nav>
    </div>

    <section class="detail__news">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8">
                    <div class="detail__news-category">
                        <a href="#">
                            <span>{{ $pressRelease->category->title }}</span>
                        </a>
                    </div>
                    <h5 class="detail__news-title">
                        {{ $pressRelease->title }}
                    </h5>
                    <div class="detail__news-info">
                        <span>By <span style="font-weight: bold;">{{ $pressRelease->user->name }}</span> -
                            {{ $pressRelease->published_at }}</span>
                        <span style="margin-left: 1rem;"><i class="far fa-clock"></i>
                            {{ $pressRelease->published_at->diffForHumans() }}</span>
                    </div>
                    <div class="detail__news-image">
                        <a href="#"><img
                                src="{{ asset('storage/uploads/press-releases/' . $pressRelease->thumbnail) }}"
                                alt="news"></a>
                    </div>
                    <p class="detail__news-caption">
                        {{ $pressRelease->caption }}
                    </p>
                    <div class="detail__news-content">
                        {!! $pressRelease->body !!}
                    </div>
                    <div id="social-links">
                        <p>Share.</p>
                        <ul>
                            {!! Share::currentPage(null, ['id' => 'facebook-button'], '', '')->facebook() !!}
                            {!! Share::currentPage(null, ['id' => 'whatsapp-button'], '', '')->whatsapp() !!}
                            {!! Share::currentPage(null, ['id' => 'twitter-button'], '', '')->twitter() !!}
                            {!! Share::currentPage(null, ['id' => 'telegram-button'], '', '')->telegram() !!}
                        </ul>
                    </div>
                    <hr>
                </div>
                {{-- <div class="col-lg-4 mt-5">
                    <h2 class="section-title">Trending</h2>
                    @forelse($trend as $article)
                        @if ($article)
                            <div class="col-lg-12 mb-4">
                                <div class="row">
                                    <div class="col-lg-5">
                                        <div class="trending__image">
                                            <div class="trending__image-category">
                                                <a href="#">
                                                    <span>{{ $article->category->title }}</span>
                                                </a>
                                            </div>
                                            <a href="{{ route('detailCategory', $article->category->slug) }}"><img
                                                    src="{{ asset('storage/uploads/articles/' . $article->thumbnail) }}"
                                                    alt="highlight"></a>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <h5 class="trending__title">
                                            <a href="#">
                                                {{ $article->title }}
                                            </a>
                                        </h5>
                                        <div class="trending__info">
                                            <span>By <span style="font-weight: bold;">{{ $article->user->name }}</span> -
                                                {{ $article->published_at }}</span>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                            </div>
                        @endif
                    @empty
                        Maaf, belum ada data
                    @endforelse
                </div> --}}
            </div>

            <div class="col-lg-12 mt-4" style="margin-bottom: 6.25rem;">
                <h2 class="section-title">Siaran Pers Terkait</h2>
                <div class="row">
                    @foreach ($relatedPressRelease as $pressRelease)
                        <div class="col-lg-4 mb-4">
                            <div class="highlight__image">
                                <div class="highlight__image-category">
                                    <a href="#">
                                        <span>{{ $pressRelease->category->title }}</span>
                                    </a>
                                </div>
                                <a href="{{ route('detailPressRelease', $pressRelease->slug) }}">
                                    <img src="{{ asset('storage/uploads/press-release/' . $pressRelease->thumbnail) }}"
                                        alt="highlight" style="object-fit: cover; width: 100%; height: 10.5rem;">
                                </a>
                            </div>
                            <h5 class="highlight-title">
                                <a
                                    href="{{ route('detailpressRelease', $pressRelease->slug) }}">{{ $pressRelease->title }}</a>
                            </h5>
                            <div class="highlight-info">
                                <small>By <span style="font-weight: bold;">{{ $pressRelease->user->name }}</span> -
                                    {{ $pressRelease->published_at }}</small>
                                <small style="margin-left: 0.9rem;"><i class="far fa-clock"></i>
                                    {{ $pressRelease->published_at->diffForHumans() }}</small>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endsection

@push('js')
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha256-4+XzXVhsDmqanXGHaHvgh1gMQKX40OUvDEBTu8JcmNs=" crossorigin="anonymous"></script>
    <script src="{{ asset('js/share.js') }}"></script>
@endpush
