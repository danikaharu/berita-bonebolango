@extends('layouts.app')

@section('title', trans('Detail of Albums'))

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-8 order-md-1 order-last">
                    <h3>{{ __('Albums') }}</h3>
                    <p class="text-subtitle text-muted">
                        {{ __('Detail of album.') }}
                    </p>
                </div>

                <x-breadcrumb>
                    <li class="breadcrumb-item">
                        <a href="/">{{ __('Dashboard') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('albums.index') }}">{{ __('Albums') }}</a>
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
                                        <td class="fw-bold">{{ __('Album') }}</td>
                                        <td>{{ $album->title ? $album->title : '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Deskripsi') }}</td>
                                        <td>{{ $album->body ? $album->body : '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('File') }}</td>
                                        <td>
                                            @foreach ($album->galleries as $gallery)
                                                @if ($gallery->file == null)
                                                    <img src="https://via.placeholder.com/350?text=No+Image+Avaiable"
                                                        alt="File" class="rounded" width="200" height="150"
                                                        style="object-fit: cover">
                                                @else
                                                    <img src="{{ asset('storage/uploads/galleries/' . $gallery->file) }}"
                                                        alt="File" class="rounded mx-3 my-3" width="200"
                                                        height="150" style="object-fit: cover">
                                                @endif
                                            @endforeach
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Created at') }}</td>
                                        <td>{{ $album->created_at->format('d/m/Y H:i') }}</td>
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
