@extends('layouts.home.app')

@section('title')
    {{ $article->title }}
@endsection

@push('seo')
    <link rel="canonical" href="{{ route('detailArticle', $article->slug) }}">

    <!-- Facebook Meta Tags -->
    <meta property="og:url" content="{{ route('detailArticle', $article->slug) }}">
    <meta property="og:type" content="article">
    <meta property="og:title" content="{{ $article->title }}">
    <meta property="og:description" content="{!! Str::limit(strip_tags($article->body), $limit = 100, $end = '...') !!}">
    <meta property="og:image" content="{{ asset('storage/uploads/articles/' . $article->thumbnail) }}">

    <!-- Twitter Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta property="twitter:domain" content="berita.bonebolangokab.go.id">
    <meta property="twitter:url" content="{{ route('detailArticle', $article->slug) }}">
    <meta name="twitter:title" content="{{ $article->title }}">
    <meta name="twitter:description" content="{!! Str::limit(strip_tags($article->body), $limit = 100, $end = '...') !!}">
    <meta name="twitter:image" content="{{ asset('storage/uploads/articles/' . $article->thumbnail) }}">
@endpush

@section('content')
    <div class="container-fluid my-5">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                <li class="breadcrumb-item"><a
                        href="{{ route('detailCategory', $article->category->slug) }}">{{ $article->category->title }}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">{{ $article->title }}</li>
            </ol>
        </nav>
    </div>

    <section class="detail__news">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8">
                    <div class="detail__news-category">
                        <a href="{{ route('detailCategory', $article->category->slug) }}">
                            <span>{{ $article->category->title }}</span>
                        </a>
                    </div>
                    <h5 class="detail__news-title">
                        {{ $article->title }}
                    </h5>
                    <div class="detail__news-info">
                        <span>By <span style="font-weight: bold;">{{ $article->user->name }}</span> -
                            {{ $article->published_at }}</span>
                        <span style="margin-left: 1rem;"><i class="far fa-clock"></i>
                            {{ $article->published_at->diffForHumans() }}</span>
                        <span style="margin-left: 1rem;"><i class="fas fa-eye"></i>
                            {{ $pageViewArticle[0]['screenPageViews'] ?? 0 }}
                            view</span>
                    </div>
                    <div class="detail__news-image">
                        <a href="#"><img src="{{ asset('storage/uploads/articles/' . $article->thumbnail) }}"
                                alt="news"></a>
                    </div>
                    <p class="detail__news-caption">
                        {{ $article->caption }}
                    </p>
                    <div class="detail__news-content">
                        {!! $article->body !!}
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
                    <div class="detail__news-tag">
                        @foreach ($article->tags as $tag)
                            <a href="#"><span>{{ $tag->name }}</span></a>
                        @endforeach
                    </div>
                    <hr>
                </div>
                <div class="col-lg-4 mt-5">
                    <h2 class="section-title">Trending</h2>
                    @forelse($trend as $article)
                        @if ($article)
                            <div class="col-lg-12 mb-4">
                                <div class="row">
                                    <div class="col-lg-5">
                                        <div class="trending__image">
                                            <div class="trending__image-category">
                                                <a href="{{ route('detailCategory', $article->category->slug) }}">
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
                                            <a href="{{ route('detailArticle', $article->slug) }}">
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
                </div>
            </div>

            <div class="col-lg-12 mt-4" style="margin-bottom: 6.25rem;">
                <h2 class="section-title">Berita Terkait</h2>
                <div class="row">
                    @foreach ($relatedArticles as $article)
                        <div class="col-lg-3 mb-4">
                            <div class="highlight__image">
                                <div class="highlight__image-category">
                                    <a href="{{ route('detailCategory', $article->category->slug) }}">
                                        <span>{{ $article->category->title }}</span>
                                    </a>
                                </div>
                                <a href="{{ route('detailArticle', $article->slug) }}">
                                    <img src="{{ asset('storage/uploads/articles/' . $article->thumbnail) }}"
                                        alt="highlight" style="object-fit: cover; width: 100%; height: 10.5rem;">
                                </a>
                            </div>
                            <h5 class="highlight-title">
                                <a href="{{ route('detailArticle', $article->slug) }}">{{ $article->title }}</a>
                            </h5>
                            <div class="highlight-info">
                                <small>By <span style="font-weight: bold;">{{ $article->user->name }}</span> -
                                    {{ $article->published_at }}</small>
                                <small style="margin-left: 0.9rem;"><i class="far fa-clock"></i>
                                    {{ $article->published_at->diffForHumans() }}</small>
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
