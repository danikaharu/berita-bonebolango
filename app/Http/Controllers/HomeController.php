<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use AkkiIo\LaravelGoogleAnalytics\Facades\LaravelGoogleAnalytics;
use AkkiIo\LaravelGoogleAnalytics\Period;
use Google\Analytics\Data\V1beta\Filter\StringFilter\MatchType;

class HomeController extends Controller
{
    public function index()
    {
        $latestArticle = \App\Models\Article::with(['category', 'user'])
            ->where('published_at', '<=', now())
            ->published()
            ->latest()
            ->limit(6)
            ->get();


        $latestAlbum = \App\Models\Album::with(['galleries', 'user'])
            ->latest()
            ->limit(6)
            ->get();

        $articleByCategory1 = \App\Models\Article::with(['user', 'category'])
            ->whereHas('category', function ($query) {
                $query->where('category_id', 1)
                    ->where('published_at', '<=', now())
                    ->where('status', 'Published');
            })
            ->limit(3)
            ->get();

        $articleByCategory2 = \App\Models\Article::with(['user', 'category'])
            ->whereHas('category', function ($query) {
                $query->where('category_id', 2)
                    ->where('published_at', '<=', now())
                    ->where('status', 'Published');
            })
            ->limit(3)
            ->get();

        $articleByCategory3 = \App\Models\Article::with(['user', 'category'])
            ->whereHas('category', function ($query) {
                $query->where('category_id', 3)
                    ->where('published_at', '<=', now())
                    ->where('status', 'Published');
            })
            ->limit(3)
            ->get();

        $tabloidKambungu =  \App\Models\Tabloid::typeTabloid('Kambungu');

        $tabloidSepekan =  \App\Models\Tabloid::typeTabloid('Bonebol Sepekan');

        $mainHighlight = $this->mainHighlight();

        $subHighlight = $this->subHighlight();

        return view('home.index', compact('mainHighlight', 'subHighlight', 'latestArticle', 'latestAlbum', 'articleByCategory1', 'articleByCategory2', 'articleByCategory3', 'tabloidKambungu', 'tabloidSepekan'));
    }

    public function article()
    {
        $articles = \App\Models\Article::with(['user', 'category'])->latest()->paginate(9);
        return view('home.article', compact('articles'));
    }

    public function gallery()
    {
        $albums = \App\Models\Album::with(['user', 'galleries'])
            ->latest()
            ->paginate(12);
        return view('home.gallery', compact('albums'));
    }

    public function detailCategory(\App\Models\Category $category)
    {

        $categories = \App\Models\Article::whereHas('category', function ($query) use ($category) {
            $query->where('category_id', $category->id);
        })
            ->where('published_at', '<=', now())
            ->where('status', 'Published')
            ->with(['user', 'category'])
            ->latest()
            ->paginate(12);

        return view('home.detail-category', compact('categories', 'category'));
    }

    public function detailGallery(\App\Models\Album $album)
    {
        $slug = "/" . $album->slug;

        // Total View Article
        $pageViewGallery = Analytics::performQuery(
            Period::days(7),
            'ga:pageviews',
            [
                'metrics' => 'ga:pageviews',
                'dimensions' => 'ga:pagePathLevel1, ga:pagePathLevel2',
                'filters' => "ga:pagePathLevel2%3D~%5E$slug",
            ]
        );

        return view('home.detail-gallery', compact('album', 'pageViewGallery'));
    }

    public function detailArticle(\App\Models\Article $article)
    {
        $startWeek = Carbon::now()->startOfWeek();
        $endWeek = Carbon::now()->endOfWeek();

        // get the related categories id of the $article
        $related_category_ids = $article->category()->pluck('categories.id');
        $slug = "/" . $article->slug;

        // get the related article of the categories $related_category_ids
        $relatedArticles = \App\Models\Article::whereHas('category', function ($q) use ($related_category_ids) {
            $q->whereIn('category_id', $related_category_ids);
        })
            ->with(['user', 'category'])
            ->where('id', '<>', $article->id)
            ->where('status', 'Published')
            ->take(8)
            ->latest()
            ->get();

        // Total View Article
        $pageViewArticle = $this->pageViewArticle($slug);

        $trend = $this->trendingArticle();

        return view('home.detail-article', compact('article', 'relatedArticles', 'pageViewArticle', 'trend'));
    }

    public function detailTabloid(\App\Models\Tabloid $tabloid)
    {
        return view('home.detail-tabloid', compact('tabloid'));
    }

    public function search(Request $request)
    {
        $search = clean($request->search);

        if ($search) {
            $articles = \App\Models\Article::with(['user', 'category'])
                ->where('title', 'LIKE', '%' . trim($search) . '%')
                ->latest()
                ->paginate(9);
        } else {
            abort(404);
        }

        return view('home.search', compact('articles', 'search'));
    }

    public function pressRelease()
    {
        $pressReleases = \App\Models\PressRelease::with(['user', 'category'])->latest()->paginate(9);
        return view('home.pressRelease', compact('pressReleases'));
    }

    public function detailPressRelease(\App\Models\PressRelease $pressRelease)
    {
        // get the related categories id of the $pressRelease
        $related_category_ids = $pressRelease->category()->pluck('categories.id');

        // get the related press release of the categories $related_category_ids
        $relatedPressRelease = \App\Models\PressRelease::whereHas('category', function ($q) use ($related_category_ids) {
            $q->whereIn('category_id', $related_category_ids);
        })
            ->with(['user', 'category'])
            ->where('id', '<>', $pressRelease->id)
            ->where('status', 'Published')
            ->take(6)
            ->latest()
            ->get();

        return view('home.detail-pressRelease', compact('pressRelease', 'relatedPressRelease'));
    }

    private function mainHighlight()
    {
        // Main Highlight Article
        $startDate = now()->subMonth()->startOfDay();
        $endDate = now()->endOfDay();
        $period = Period::create($startDate, $endDate);

        $trendingArticle = LaravelGoogleAnalytics::dateRanges($period)
            ->metrics('screenPageViews')
            ->dimensions('pagePath')
            ->whereDimension('pagePath', MatchType::CONTAINS, 'berita')
            ->limit(1)
            ->get();

        $data = str_replace("/berita/", '', $trendingArticle->table[0]['pagePath']);

        $mainHighlight = \App\Models\Article::where('slug', $data)
            ->published()
            ->with(['user', 'category'])
            ->get();

        return $mainHighlight;
        // End Main Highlight Article
    }

    private function subHighlight()
    {
        // Sub Highlight Article
        $startDate = now()->subMonth()->startOfDay();
        $endDate = now()->endOfDay();
        $period = Period::create($startDate, $endDate);

        $trendingArticle = LaravelGoogleAnalytics::dateRanges($period)
            ->metrics('screenPageViews')
            ->dimensions('pagePath')
            ->whereDimension('pagePath', MatchType::CONTAINS, 'berita')
            ->limit(4)
            ->get();

        $array = array();

        foreach ($trendingArticle->table as $row) {
            $array = array_merge(
                $array,
                array($row['pagePath'])
            );
        }

        // Deleting first array item
        array_shift($array);

        // Remove slash in array
        $data = str_replace("/berita/", '', $array);


        $subHighlight = \App\Models\Article::whereIn('slug', $data)
            ->published()
            ->with(['user', 'category'])
            ->get();

        return $subHighlight;
        // End Sub Highlight Article
    }

    private function trendingArticle()
    {
        $startDate = now()->subMonth()->startOfDay();
        $endDate = now()->endOfDay();
        $period = Period::create($startDate, $endDate);

        $trendingArticle = LaravelGoogleAnalytics::dateRanges($period)
            ->metrics('screenPageViews')
            ->dimensions('pagePath')
            ->whereDimension('pagePath', MatchType::CONTAINS, 'berita')
            ->limit(6)
            ->get();

        $array = array();

        foreach ($trendingArticle->table as $row) {
            $array = array_merge(
                $array,
                array($row['pagePath'])
            );
        }
        // Remove slash in array
        $data = str_replace("/berita/", '', $array);


        $trend = \App\Models\Article::whereIn('slug', $data)
            ->published()
            ->with(['user', 'category'])
            ->get();

        return $trend;
    }

    public function pageViewArticle($slug)
    {
        $startDate = Carbon::createFromFormat('Y-m-d', '2022-11-07');
        $endDate = Carbon::now();
        $period = Period::create($startDate, $endDate);

        $pageViewArticle = LaravelGoogleAnalytics::dateRanges($period)
            ->metrics('screenPageViews')
            ->dimensions('pagePath')
            ->whereDimension('pagePath', MatchType::CONTAINS, $slug)
            ->get();

        return $pageViewArticle->table;
    }
}
