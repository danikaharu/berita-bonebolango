@extends('layouts.app')

@section('title', trans('Detail of Articles'))

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-8 order-md-1 order-last">
                    <h3>{{ __('Artikel') }}</h3>
                    <p class="text-subtitle text-muted">
                        {{ __('Detail artikel.') }}
                    </p>
                </div>

                <x-breadcrumb>
                    <li class="breadcrumb-item">
                        <a href="/">{{ __('Dashboard') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('articles.index') }}">{{ __('Artikel') }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        {{ __('Detail') }}
                    </li>
                </x-breadcrumb>
            </div>
        </div>

        <section class="section">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-striped">
                                    <tr>
                                        <td class="fw-bold">{{ __('Author') }}</td>
                                        <td>{{ $article->user ? $article->user->name : '' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Kategori') }}</td>
                                        <td>{{ $article->category ? $article->category->title : '' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Tag') }}</td>
                                        <td>
                                            @foreach ($article->tags as $tag)
                                                <span class="badge bg-primary">{{ $tag ? $tag->name : '' }}</span>
                                            @endforeach
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Judul') }}</td>
                                        <td>{{ isset($article->title) ? $article->title : '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Konten') }}</td>
                                        <td>{!! isset($article->body) ? $article->body : '-' !!}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Thumbnail') }}</td>
                                        <td>
                                            @if ($article->thumbnail == null)
                                                <img src="https://via.placeholder.com/350?text=No+Image+Avaiable"
                                                    alt="Thumbnail" class="rounded" width="200" height="150"
                                                    style="object-fit: cover">
                                            @else
                                                <img src="{{ asset('storage/uploads/articles/' . $article->thumbnail) }}"
                                                    alt="Thumbnail" class="rounded" width="200" height="150"
                                                    style="object-fit: cover">
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Caption') }}</td>
                                        <td>{{ isset($article->caption) ? $article->caption : '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Status') }}</td>
                                        <td>{{ isset($article->status) ? $article->status : '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Tanggal Upload') }}</td>
                                        <td>{{ isset($article->published_at) ? $article->published_at->format('d/m/Y H:i') : '-' }}
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <a href="{{ url()->previous() }}" class="btn btn-secondary">{{ __('Kembali') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
