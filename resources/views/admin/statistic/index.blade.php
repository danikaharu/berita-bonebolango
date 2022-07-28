@extends('layouts.app')

@section('title', 'Statistik Website')

@section('content')

    <div class="page-heading">
        <h3>Statistik Website</h3>
    </div>

    <div class="page-content">
        <section class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Halaman yang sering dikunjungi dalam 1 bulan terakhir</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Judul Halaman</th>
                                        <th>Page Views</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 0;
                                    @endphp
                                    @foreach ($mostVisitedPages as $data)
                                        <tr>
                                            <td>{{ ++$no }}</td>
                                            <td>
                                                <a href=" {{ url($data['url']) }}" target="_blank">
                                                    {{ $data['pageTitle'] }}
                                                </a>
                                            </td>
                                            <td>{{ $data['pageViews'] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h4>Total Pengunjung</h4>
                        </div>
                        <div class="card-body">
                            <ul style="list-style: none;margin:0;padding:0">
                                <li>Kemarin : {{ $totalVisitorYesterday->sum('pageViews') }}</li>
                                <li>Hari Ini : {{ $totalVisitorToday->sum('pageViews') }}</li>
                                <li>Bulan Ini : {{ $totalVisitorMonth->sum('pageViews') }}</li>
                                <li>Tahun Ini : {{ $totalVisitorYear->sum('pageViews') }}</li>
                                <li>Total : {{ $totalVisitor->sum('pageViews') }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
        </section>
    </div>


@endsection
