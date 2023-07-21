@extends('layouts.home.app')

@section('title')
    Beranda
@endsection

@push('style')
    <!-- Swiper -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />
@endpush


@section('content')
    <section class="highlight">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-7">
                    @forelse($mainHighlight as $article)
                        <div class="highlight__image">
                            <div class="highlight__image-category">
                                <a href="{{ route('detailCategory', $article->category->slug) }}">
                                    <span>{{ $article->category->title }}</span>
                                </a>
                            </div>
                            <a href="#"><img src="{{ asset('storage/uploads/articles/' . $article->thumbnail) }}"
                                    alt="highlight"
                                    style="object-fit:cover;object-position:center;width: 100%; height: 22rem;"></a>
                        </div>
                        <h5 class="highlight-title">
                            <a href="{{ route('detailArticle', $article->slug) }}">
                                {{ $article->title }}
                            </a>
                        </h5>
                        <div class="highlight-info">
                            <span>By <span style="font-weight: bold;">{{ $article->user->name }}</span> -
                                {{ $article->published_at }}</span>
                            <span style="margin-left: 1rem;"><i class="far fa-clock"></i>
                                {{ $article->published_at->diffForHumans() }}</span>
                        </div>
                        {{-- <p class="highlight-content">{!! Str::limit($article->body, 10) !!}</p> --}}
                    @empty
                        <h5 class="highlight-title">Maaf, belum ada data</h5>
                    @endforelse
                </div>
                <div class="col-lg-5">
                    @forelse($subHighlight as $article)
                        <div class="col-lg-12" style="margin-bottom: 3.5rem;">
                            <div class="row">
                                <div class="col-lg-5">
                                    <div class="highlight__image">
                                        <div class="highlight__image-category__sub">
                                            <a href="{{ route('detailCategory', $article->category->slug) }}">
                                                <span>{{ $article->category->title }}</span>
                                            </a>
                                        </div>
                                        <a href="{{ route('detailArticle', $article->slug) }}"><img class="img-fluid"
                                                src="{{ asset('storage/uploads/articles/' . $article->thumbnail) }}"
                                                alt="highlight" style="width: 100%; object-fit: cover;"></a>
                                    </div>
                                </div>
                                <div class="col-lg-7">
                                    <h5 class="highlight__title-sub">
                                        <a href="{{ route('detailArticle', $article->slug) }}">
                                            {{ $article->title }}
                                        </a>
                                    </h5>
                                    <div class="highlight__info-sub">
                                        <span>By <span style="font-weight: bold;">{{ $article->user->name }}</span> -
                                            {{ $article->published_at }}</span>
                                        <span style="margin-left: 0.5rem;"><i class="far fa-clock"></i>
                                            {{ $article->published_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <h5 class="highlight-title">Maaf, belum ada data</h5>
                    @endforelse
                </div>
            </div>
            <hr>
        </div>
    </section>


    <section class="news">
        <div class="container-fluid">
            <h2 class="section-title">Berita Terbaru</h2>
            <div class="row mb-4">
                @forelse ($latestArticle as $article)
                    <div class="col-lg-4">
                        <div class="highlight__image">
                            <div class="highlight__image-category">
                                <a href="{{ route('detailCategory', $article->category->slug) }}">
                                    <span>{{ $article->category->title }}</span>
                                </a>
                            </div>
                            <a href="{{ route('detailArticle', $article->slug) }}">
                                <img src="{{ asset('storage/uploads/articles/' . $article->thumbnail) }} " alt="article"
                                    style="object-fit:cover;object-position:center;height:200px;width:100%">
                            </a>
                        </div>
                        <h5 class=" highlight-title">
                            <a href="{{ route('detailArticle', $article->slug) }}">{{ $article->title }}</a>
                        </h5>
                        <div class="highlight-info">
                            <small>By <span style="font-weight: bold;">{{ $article->user->name }}</span> -
                                {{ $article->published_at }}</small>
                            <small style="margin-left: 0.9rem;"><i class="far fa-clock"></i>
                                {{ \Carbon\Carbon::parse($article->published_at)->diffForHumans() }}</small>
                        </div>
                    </div>
                @empty
                    <h5 class="highlight-title">Maaf, belum ada data</h5>
                @endforelse
            </div>
            <hr>
        </div>
    </section>


    <section class="news">
        <div class="container-fluid">
            <div class="row mb-4">
                <div class="col-lg-4">
                    <h2 class="section-title">Pemerintahan</h2>
                    @forelse ($articleByCategory1 as $article)
                        <div class="row news-category__row">
                            <div class="col-lg-5">
                                <div class="highlight__image">
                                    <a href="{{ route('detailArticle', $article->slug) }}">
                                        <img src="{{ asset('storage/uploads/articles/' . $article->thumbnail) }} "
                                            alt="article image" class="highlight__image-thumbnail" loading="lazy">
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-7">
                                <h5 class="highlight__title-sub">
                                    <a href="{{ route('detailArticle', $article->slug) }}">
                                        {{ $article->title }}
                                    </a>
                                </h5>
                                <div class="highlight__info-sub">
                                    <span>By <span style="font-weight: bold;">{{ $article->user->name }}</span> -
                                        {{ $article->published_at }}</span>
                                    <span style="margin-left: 0.5rem;"><i class="far fa-clock"></i>
                                        {{ \Carbon\Carbon::parse($article->published_at)->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>
                        <hr>
                    @empty
                        <h5 class="highlight-title">Maaf,belum ada data</h5>
                    @endforelse
                </div>
                <div class="col-lg-4">
                    <h2 class="section-title">Ekonomi</h2>
                    @forelse ($articleByCategory2 as $article)
                        <div class="row news-category__row">
                            <div class="col-lg-5">
                                <div class="highlight__image">
                                    <a href="{{ route('detailArticle', $article->slug) }}">
                                        <img src="{{ asset('storage/uploads/articles/' . $article->thumbnail) }} "
                                            alt="article image" class="highlight__image-thumbnail" loading="lazy">
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-7">
                                <h5 class="highlight__title-sub">
                                    <a href="{{ route('detailArticle', $article->slug) }}">
                                        {{ $article->title }}
                                    </a>
                                </h5>
                                <div class="highlight__info-sub">
                                    <span>By <span style="font-weight: bold;">{{ $article->user->name }}</span> -
                                        {{ $article->published_at }}</span>
                                    <span style="margin-left: 0.5rem;"><i class="far fa-clock"></i>
                                        {{ \Carbon\Carbon::parse($article->published_at)->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>
                        <hr>
                    @empty
                        <h5 class="highlight-title">Maaf,belum ada data</h5>
                    @endforelse
                </div>
                <div class="col-lg-4">
                    <h2 class="section-title">Pembangunan</h2>
                    @forelse ($articleByCategory3 as $article)
                        <div class="row news-category__row">
                            <div class="col-lg-5">
                                <div class="highlight__image">
                                    <a href="{{ route('detailArticle', $article->slug) }}">
                                        <img src="{{ asset('storage/uploads/articles/' . $article->thumbnail) }} "
                                            alt="article image" class="highlight__image-thumbnail" loading="lazy">
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-7">
                                <h5 class="highlight__title-sub">
                                    <a href="{{ route('detailArticle', $article->slug) }}">
                                        {{ $article->title }}
                                    </a>
                                </h5>
                                <div class="highlight__info-sub">
                                    <span>By <span style="font-weight: bold;">{{ $article->user->name }}</span> -
                                        {{ $article->published_at }}</span>
                                    <span style="margin-left: 0.5rem;"><i class="far fa-clock"></i>
                                        {{ \Carbon\Carbon::parse($article->published_at)->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>
                        <hr>
                    @empty
                        <h5 class="highlight-title">Maaf,belum ada data</h5>
                    @endforelse
                </div>
            </div>
        </div>
    </section>

    <section class="gallery">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-9">
                    <h2 class="section-title">Potret Bonebol</h2>
                </div>
                <div class="col-lg-3">
                    <a href="{{ route('gallery') }}" class="btn gallery__button" target="_blank">
                        Selengkapnya
                        <span class="fa-stack">
                            <i class="far fa-circle fa-stack-2x fa-inverse"></i>
                            <i class="fas fa-arrow-right fa-stack-1x"></i>
                        </span>
                    </a>
                </div>
            </div>
            <div class="row mb-4">
                @forelse ($latestAlbum as $album)
                    <div class="col-lg-4">
                        <a href="{{ route('detailGallery', $album->slug) }}">
                            <img src="{{ asset('storage/uploads/galleries/' . $album->galleries->first()->file) }} "
                                alt="highlight" loading="lazy"
                                style="object-fit:cover;object-position:center;height:300px;width:100%">
                        </a>
                        <h5 class="highlight-title">
                            <a href="{{ route('detailGallery', $album->slug) }}">{{ $album->title }}</a>
                        </h5>
                        <div class="highlight-info">
                            <small>By <span style="font-weight: bold;">{{ $album->user->name }}</span> -
                                {{ $album->created_at }}</small>
                            <small style="margin-left: 0.9rem;"><i class="far fa-clock"></i>
                                {{ $album->created_at->diffForHumans() }}</small>
                        </div>
                    </div>
                @empty
                    <h5 class="highlight-title">Maaf,belum ada data</h5>
                @endforelse
            </div>
        </div>
    </section>

    <section class="slider-tabloid">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6 slider-tabloid__sepekan">
                    <h4 class="section__title-sub">Bonebol Sepekan</h4>
                    <div class="swiper tabloid">
                        <div class="swiper-wrapper">
                            @foreach ($tabloidSepekan as $tabloid)
                                <div class="swiper-slide">
                                    <a href="{{ route('detailTabloid', $tabloid->slug) }}" target="_blank">
                                        <img src='{{ asset('storage/uploads/tabloids/thumbnail/' . $tabloid->thumbnail) }}'
                                            loading="lazy" style="width: 8.75rem;">
                                    </a>
                                </div>
                            @endforeach
                        </div>
                        <div class="swiper-pagination"></div>
                    </div>
                </div>
                <div class="col-lg-6 slider-tabloid__kambungu">
                    <h4 class="section__title-sub">Kambungu</h4>
                    <div class="swiper tabloid">
                        <div class="swiper-wrapper">
                            @foreach ($tabloidKambungu as $tabloid)
                                <div class="swiper-slide">
                                    <a href="{{ route('detailTabloid', $tabloid->slug) }}" target="_blank">
                                        <img src='{{ asset('storage/uploads/tabloids/thumbnail/' . $tabloid->thumbnail) }}'
                                            loading="lazy" style="width: 8.75rem;">
                                    </a>
                                </div>
                            @endforeach
                        </div>
                        <div class="swiper-pagination"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <hr>

    @include('layouts.home.include.related-link')
@endsection

@push('js')
    <!-- Swiper -->
    <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
    <script>
        // Swiper Tabloid
        var swiper = new Swiper(".tabloid", {
            slidesPerView: 3,
            grid: {
                rows: 2,
            },
            spaceBetween: 30,
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
                renderBullet: function(index, className) {
                    return '<span class="' + className + '">' + "</span>";
                },
            },
        });
        // End Swiper Tabloid
    </script>
@endpush
