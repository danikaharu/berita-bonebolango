@extends('layouts.app')

@section('title', trans('Detail of Tabloids'))

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-8 order-md-1 order-last">
                    <h3>{{ __('Majalah') }}</h3>
                    <p class="text-subtitle text-muted">
                        {{ __('Detail majalah.') }}
                    </p>
                </div>

                <x-breadcrumb>
                    <li class="breadcrumb-item">
                        <a href="/">{{ __('Dashboard') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('tabloids.index') }}">{{ __('Majalah') }}</a>
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
                                        <td class="fw-bold">{{ __('Kategori') }}</td>
                                        <td>{{ isset($tabloid->type) ? $tabloid->type : '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Judul') }}</td>
                                        <td>{{ isset($tabloid->title) ? $tabloid->title : '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('File') }}</td>
                                        <td>
                                            @if ($tabloid->thumbnail == null)
                                                <img src="https://via.placeholder.com/350?text=Image+Not+Found"
                                                    alt="File" class="rounded" width="200" height="150"
                                                    style="object-fit: cover">
                                            @else
                                                <a href="{{ asset('storage/uploads/tabloids/' . $tabloid->file) }}"
                                                    target="pdf_frame">
                                                    <img src="{{ asset('storage/uploads/tabloids/thubmnail/' . $tabloid->thumbnail) }}"
                                                        alt="Thumbnail" class="rounded" width="200" height="150"
                                                        style="object-fit: cover">
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Tanggal Dibuat') }}</td>
                                        <td>{{ $tabloid->created_at->format('d/m/Y H:i') }}</td>
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
