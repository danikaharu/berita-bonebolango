@extends('layouts.home.app')

@section('title')
    {{ $search }}
@endsection

@section('content')
    <div class="container-fluid my-5">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                <li class="breadcrumb-item active" aria-current="page">Hasil Pencarian - {{ $search }}</li>
            </ol>
        </nav>
    </div>

    <section>
        <div class="container-fluid">
            <h4 class="section__title-sub">Hasil Pencarian : {{ $search }}</h4>
            <div class="row">
                @forelse ($articles as $article)
                    <div class="col-lg-4 mb-4">
                        <div class="highlight__image">
                            <div class="highlight__image-category">
                                <a href="#">
                                    <span>{{ $article->category->title }}</span>
                                </a>
                            </div>
                            <a href="#">
                                <img src="{{ asset('storage/uploads/articles/' . $article->thumbnail) }}" alt="highlight"
                                    style="object-fit: cover; width: 100%; height: 10.5rem;">
                            </a>
                        </div>
                        <h5 class=" highlight-title">
                            <a href="{{ route('detailGallery', $article->slug) }}">{{ $article->title }}</a>
                        </h5>
                        <div class="highlight-info">
                            <small>By <span style="font-weight: bold;">{{ $article->user->name }}</span> -
                                {{ $article->created_at }}</small>
                            <small style="margin-left: 0.9rem;"><i class="far fa-clock"></i>
                                {{ $article->created_at->diffForHumans() }}</small>
                        </div>
                    </div>
                @empty
                    <h5 class="highlight-title">Maaf, artikel yang anda cari tidak ditemukan</h5>
                @endforelse
            </div>
        </div>
    </section>

    {{ $articles->links() }}
@endsection
