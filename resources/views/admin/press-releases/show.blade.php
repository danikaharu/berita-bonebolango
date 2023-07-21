@extends('layouts.app')

@section('title', trans('Detail of PressReleases'))

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-8 order-md-1 order-last">
                    <h3>{{ __('Siaran Pers') }}</h3>
                    <p class="text-subtitle text-muted">
                        {{ __('Detail siaran pers.') }}
                    </p>
                </div>

                <x-breadcrumb>
                    <li class="breadcrumb-item">
                        <a href="/">{{ __('Dashboard') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('press-releases.index') }}">{{ __('Siaran Pers') }}</a>
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
                                        <td>{{ $pressRelease->user ? $pressRelease->user->name : '' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Kategori') }}</td>
                                        <td>{{ $pressRelease->category ? $pressRelease->category->title : '' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Judul') }}</td>
                                        <td>{{ isset($pressRelease->title) ? $pressRelease->title : '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Konten') }}</td>
                                        <td>{{ isset($pressRelease->body) ? $pressRelease->body : '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Thumbnail') }}</td>
                                        <td>
                                            @if ($pressRelease->thumbnail == null)
                                                <img src="https://via.placeholder.com/350?text=No+Image+Avaiable"
                                                    alt="Thumbnail" class="rounded" width="200" height="150"
                                                    style="object-fit: cover">
                                            @else
                                                <img src="{{ asset('storage/uploads/thumbnails/' . $pressRelease->thumbnail) }}"
                                                    alt="Thumbnail" class="rounded" width="200" height="150"
                                                    style="object-fit: cover">
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Status') }}</td>
                                        <td>{{ isset($pressRelease->status) ? $pressRelease->status : '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Tanggal Upload') }}</td>
                                        <td>{{ isset($pressRelease->published_at) ? $pressRelease->published_at->format('d/m/Y H:i') : '-' }}
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <a href="{{ url()->previous() }}" class="btn btn-secondary">{{ __('Back') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
