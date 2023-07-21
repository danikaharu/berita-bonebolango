@extends('layouts.home.app')

@section('title')
    Siaran Pers
@endsection

@section('content')
    <div class="container-fluid my-5">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                <li class="breadcrumb-item active" aria-current="page">Siaran Pers</li>
            </ol>
        </nav>
    </div>

    <section>
        <div class="container-fluid">
            <h4 class="section__title-sub">SIARAN PERS</h4>
            <div class="row">
                @foreach ($pressReleases as $data)
                    <div class="col-lg-4 mb-4">
                        <div class="highlight__image">
                            <a href="{{ route('detailPressRelease', $data->slug) }}">
                                <img src="{{ 'storage/uploads/press-releases/' . $data->thumbnail }}" alt="data"
                                    style="object-fit: cover; width: 100%; height: 10.5rem;">
                            </a>
                        </div>
                        <h5 class=" highlight-title">
                            <a href="{{ route('detailPressRelease', $data->slug) }}">{{ $data->title }}</a>
                        </h5>
                        <div class="highlight-info">
                            <small>By <span style="font-weight: bold;">{{ $data->user->name }}</span> -
                                {{ $data->created_at }}</small>
                            <small style="margin-left: 0.9rem;"><i class="far fa-clock"></i>
                                {{ $data->created_at->diffForHumans() }}</small>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{ $pressReleases->links() }}
@endsection
