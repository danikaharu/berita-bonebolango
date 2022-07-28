<?php

namespace App\Providers;

use Carbon\Carbon;
use Analytics;
use Spatie\Analytics\Period;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Spatie\Permission\Models\Role;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer([
            'layouts.home.footer',
        ], function ($view) {
            $startDate = Carbon::now()->subYear();
            $endDate = Carbon::now();
            $yesterday = Carbon::yesterday();
            $today = Carbon::today();

            $totalVisitor = Analytics::fetchTotalVisitorsAndPageViews(Period::create($startDate, $endDate));
            $totalVisitorYesterday = Analytics::fetchTotalVisitorsAndPageViews(Period::create($yesterday, $yesterday));
            $totalVisitorToday = Analytics::fetchTotalVisitorsAndPageViews(Period::create($today, $today));
            return $view->with(
                [
                    'totalVisitor' => $totalVisitor,
                    'totalVisitorYesterday' => $totalVisitorYesterday,
                    'totalVisitorToday' => $totalVisitorToday,
                ],
            );
        });

        View::composer([
            'layouts.home.header',
        ], function ($view) {
            return $view->with(
                'categories',
                \App\Models\Category::select('title', 'slug')->limit(5)->get()
            );
        });

        View::composer([
            'users.create',
            'users.edit',
        ], function ($view) {
            return $view->with(
                'roles',
                Role::get()
            );
        });

        View::composer([
            'articles.create',
            'articles.edit',
        ], function ($view) {
            return $view->with(
                'users',
                \App\Models\User::select('id', 'name')->get()
            );
        });

        View::composer([
            'articles.create',
            'articles.edit',
        ], function ($view) {
            return $view->with(
                'categories',
                \App\Models\Category::select('id', 'title')->get()
            );
        });

        View::composer([
            'tabloids.create',
            'tabloids.edit',
        ], function ($view) {
            return $view->with(
                'users',
                \App\Models\User::select('id', 'name')->get()
            );
        });

        View::composer([
            'tabloids.create',
            'tabloids.edit',
        ], function ($view) {
            return $view->with(
                'categories',
                \App\Models\Category::select('id', 'title')->get()
            );
        });

        View::composer([
            'galleries.create',
            'galleries.edit',
        ], function ($view) {
            return $view->with(
                'users',
                \App\Models\User::select('id', 'name')->get()
            );
        });

        // don`t remove this comment, it will generate view composer
    }
}
