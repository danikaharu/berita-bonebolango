<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Carbon;
use AkkiIo\LaravelGoogleAnalytics\Facades\LaravelGoogleAnalytics;
use AkkiIo\LaravelGoogleAnalytics\Period;

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
            $startDate = Carbon::createFromFormat('Y-m-d', '2022-11-07');
            $endDate = Carbon::now();
            $yesterday = Carbon::yesterday();
            $today = Carbon::today();

            $totalVisitor = LaravelGoogleAnalytics::getTotalUsers(Period::create($startDate, $endDate));
            $totalVisitorYesterday = LaravelGoogleAnalytics::getTotalUsers(Period::create($yesterday, $yesterday));
            $totalVisitorToday = LaravelGoogleAnalytics::getTotalUsers(Period::create($today, $today));
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
            'layouts.home.header',
        ], function ($view) {
            return $view->with(
                'dprd',
                \App\Models\Category::select('title', 'slug')->where('slug', 'dprd')->first()
            );
        });

        View::composer([
            'layouts.home.header',
        ], function ($view) {
            return $view->with(
                'bumd',
                \App\Models\Category::select('title', 'slug')->where('slug', 'bumd')->first()
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
            'admin.articles.create',
            'admin.articles.edit',
        ], function ($view) {
            return $view->with(
                'users',
                \App\Models\User::select('id', 'name')->get()
            );
        });

        View::composer([
            'admin.articles.create',
            'admin.articles.edit',
        ], function ($view) {
            return $view->with(
                'categories',
                \App\Models\Category::select('id', 'title')->get()
            );
        });

        View::composer([
            'admin.tabloids.create',
            'admin.tabloids.edit',
        ], function ($view) {
            return $view->with(
                'users',
                \App\Models\User::select('id', 'name')->get()
            );
        });

        View::composer([
            'admin.tabloids.create',
            'admin.tabloids.edit',
        ], function ($view) {
            return $view->with(
                'categories',
                \App\Models\Category::select('id', 'title')->get()
            );
        });

        View::composer([
            'admin.galleries.create',
            'admin.galleries.edit',
        ], function ($view) {
            return $view->with(
                'users',
                \App\Models\User::select('id', 'name')->get()
            );
        });

        View::composer([
            'admin.press-releases.create',
            'admin.press-releases.edit',
        ], function ($view) {
            return $view->with(
                'categories',
                \App\Models\Category::select('id', 'title')->get()
            );
        });

        // don`t remove this comment, it will generate view composer
    }
}
