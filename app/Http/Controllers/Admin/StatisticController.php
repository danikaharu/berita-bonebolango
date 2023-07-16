<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Analytics;
use Carbon\Carbon;
use Spatie\Analytics\Period;

class StatisticController extends Controller
{
    public function index()
    {
        $yesterday = Carbon::yesterday();
        $today = Carbon::today();
        $lastMonth = Carbon::now()->subMonth();

        $mostVisitedPages = Analytics::fetchMostVisitedPages(Period::create($lastMonth, $today), 10);
        $totalVisitorYesterday = Analytics::fetchTotalVisitorsAndPageViews(Period::create($yesterday, $yesterday));
        $totalVisitorToday = Analytics::fetchTotalVisitorsAndPageViews(Period::create($today, $today));

        return view('admin.statistic.index', compact('mostVisitedPages', 'totalVisitorYesterday', 'totalVisitorToday'));
    }
}
