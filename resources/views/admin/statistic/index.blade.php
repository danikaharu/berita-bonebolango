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
                                                <a href=" {{ url($data['fullPageUrl']) }}" target="_blank">
                                                    {{ $data['pageTitle'] }}
                                                </a>
                                            </td>
                                            <td>{{ $data['screenPageViews'] }}</td>
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
                                <li>Kemarin :
                                    @if ($totalVisitorYesterday->has(0))
                                        {{ $totalVisitorYesterday[0]['screenPageViews'] }}
                                    @else
                                        0
                                    @endif
                                </li>
                                <li>Hari Ini :
                                    @if ($totalVisitorToday->has(0))
                                        {{ $$totalVisitorToday[0]['screenPageViews'] }}
                                    @else
                                        0
                                    @endif
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
        </section>
    </div>


@endsection
