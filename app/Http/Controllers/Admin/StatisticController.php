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
        $startDate = Carbon::now()->subYear();
        $endDate = Carbon::now();
        $yesterday = Carbon::yesterday();
        $today = Carbon::today();
        $month = Carbon::now()->month;
        $startWeek = Carbon::now()->startOfWeek();
        $endWeek = Carbon::now()->endOfWeek();

        $mostVisitedPages = Analytics::fetchMostVisitedPages(Period::months(1), 10);
        $totalVisitorYesterday = Analytics::fetchTotalVisitorsAndPageViews(Period::create($yesterday, $yesterday));
        $totalVisitorToday = Analytics::fetchTotalVisitorsAndPageViews(Period::create($today, $today));
        $totalVisitorMonth = Analytics::fetchTotalVisitorsAndPageViews(Period::months($month));
        $totalVisitorYear = Analytics::fetchTotalVisitorsAndPageViews(Period::years(1));
        $totalVisitor = Analytics::fetchTotalVisitorsAndPageViews(Period::create($startDate, $endDate));
        $visitorByCountry = Analytics::performQuery(
            Period::years(1),
            'ga:users',
            [
                'dimensions' => 'ga:country',
            ]
        );


        return view('admin.statistic.index', compact('mostVisitedPages', 'totalVisitorYesterday', 'totalVisitorToday', 'totalVisitorMonth', 'totalVisitorYear', 'totalVisitor', 'visitorByCountry'));
    }
}
