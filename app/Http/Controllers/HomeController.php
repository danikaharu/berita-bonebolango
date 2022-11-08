<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Analytics;
use Carbon\Carbon;
use Spatie\Analytics\Period;

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
                    ->where('status', 'Published');
            })
            ->limit(3)
            ->get();

        $articleByCategory2 = \App\Models\Article::with(['user', 'category'])
            ->whereHas('category', function ($query) {
                $query->where('category_id', 2)
                    ->where('status', 'Published');
            })
            ->limit(3)
            ->get();

        $articleByCategory3 = \App\Models\Article::with(['user', 'category'])
            ->whereHas('category', function ($query) {
                $query->where('category_id', 3)
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
            ->where('status', 'Published')
            ->with(['user', 'category'])
            ->latest()
            ->paginate(9);

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
            ->take(6)
            ->latest()
            ->get();

        // Total View Article
        $pageViewArticle = Analytics::performQuery(
            Period::days(7),
            'ga:pageviews',
            [
                'metrics' => 'ga:pageviews',
                'dimensions' => 'ga:pagePathLevel1, ga:pagePathLevel2',
                'filters' => "ga:pagePathLevel2%3D~%5E$slug",
            ]
        );

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

    private function mainHighlight()
    {
        // Main Highlight Article
        $startWeek = Carbon::now()->startOfWeek();
        $endWeek = Carbon::now()->endOfWeek();
        $trendingArticle = Analytics::performQuery(
            Period::create($startWeek, $endWeek),
            'ga:pageviews',
            [
                'metrics' => 'ga:pageviews',
                'dimensions' => 'ga:pagePath, ga:pagePathLevel1, ga:pagePathLevel2',
                'filters' => 'ga:pagePathLevel1%3D~%5E/berita/',
                'sort' => '-ga:pageviews',
                'max-results' => 1
            ]
        );

        $array = array();
        $string = '';
        foreach ($trendingArticle as $key => $row) {
            $array = array_merge(
                $array,
                array($row[2])
            );

            $lastArray = end($array);
            $string != "" && $string .= ",";
            $string .= $lastArray;
        }
        $data = str_replace("/", '', $string);

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
        $startWeek = Carbon::now()->startOfWeek();
        $endWeek = Carbon::now()->endOfWeek();
        $trendingArticle = Analytics::performQuery(
            Period::create($startWeek, $endWeek),
            'ga:pageviews',
            [
                'metrics' => 'ga:pageviews',
                'dimensions' => 'ga:pagePath, ga:pagePathLevel1, ga:pagePathLevel2',
                'filters' => 'ga:pagePathLevel1%3D~%5E/berita/',
                'sort' => '-ga:pageviews',
                'max-results' => 4
            ]
        );

        $array = array();

        foreach ($trendingArticle as $row) {
            $array = array_merge(
                $array,
                array($row[2])
            );
        }

        // Deleting first array item
        array_shift($array);

        // Remove slash in array
        $data = str_replace("/", '', $array);


        $subHighlight = \App\Models\Article::whereIn('slug', $data)
            ->published()
            ->with(['user', 'category'])
            ->get();

        return $subHighlight;
        // End Sub Highlight Article
    }

    private function trendingArticle()
    {
        $startWeek = Carbon::now()->startOfWeek();
        $endWeek = Carbon::now()->endOfWeek();
        $trendingArticle = Analytics::performQuery(
            Period::create($startWeek, $endWeek),
            'ga:pageviews',
            [
                'metrics' => 'ga:pageviews',
                'dimensions' => 'ga:pagePath, ga:pagePathLevel1, ga:pagePathLevel2',
                'filters' => 'ga:pagePathLevel1%3D~%5E/berita/',
                'sort' => '-ga:pageviews',
                'start-date' => '7daysAgo',
                'end-date' => 'today',
                'max-results' => 6
            ]
        );

        $array = array();

        foreach ($trendingArticle as $row) {
            $array = array_merge(
                $array,
                array($row[2])
            );
        }
        // Remove slash in array
        $data = str_replace("/", '', $array);


        $trend = \App\Models\Article::whereIn('slug', $data)
            ->published()
            ->with(['user', 'category'])
            ->get();

        return $trend;
    }
}
