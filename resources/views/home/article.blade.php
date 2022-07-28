@extends('layouts.home.app')

@section('title')
    Potret Bonebol
@endsection

@section('content')
    <div class="container-fluid my-5">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                <li class="breadcrumb-item active" aria-current="page">Pencarian</li>
            </ol>
        </nav>
    </div>

    <section>
        <div class="container-fluid">
            <h4 class="section__title-sub">POTRET BONEBOL</h4>
            <div class="row">
                @foreach ($articles as $article)
                    <div class="col-lg-4 mb-4">
                        <div class="highlight__image">
                            <a href="{{ route('detailGallery', $article->slug) }}">
                                <img src="{{ 'storage/uploads/galleries/' . $article->thumbnail()->file }}" alt="article"
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
                @endforeach
            </div>
        </div>
    </section>

    {{ $articles->links() }}
@endsection
