@extends('layouts.home.app')

@section('title')
    Halaman Tidak Ditemukan
@endsection

@section('content')
    <section class="not-found">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <h2>404</h2>
                    <p>Halaman tidak ditemukan</p>
                    <a href="{{ route('home') }}" class="btn not-found__button">
                        <span class="fa-stack">
                            <i class="far fa-circle fa-stack-2x fa-inverse"></i>
                            <i class="fas fa-arrow-left fa-stack-1x"></i>
                        </span>
                        <span class="not-found__button-text">Kembali ke Halaman Utama</span>
                    </a>
                </div>
                <div class="col-lg-6">
                </div>
            </div>
        </div>
        <div class="vector d-none d-lg-block">
            <img src="{{ asset('template/home/assets/img/vector/vector-kiri.svg') }}" alt="vector"
                class="vector-img-left">
            <img src="{{ asset('template/home/assets/img/vector/vector-centerpoint.svg') }}" class="vector-img-right first"
                alt="vector">
            <img src="{{ asset('template/home/assets/img/vector/vector-tanaman-kanan.svg') }}" class="vector-img-right"
                alt="vector">
        </div>
    </section>
@endsection
