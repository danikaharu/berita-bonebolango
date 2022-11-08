<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Http\Requests\{StoreArticleRequest, UpdateArticleRequest};
use Yajra\DataTables\Facades\DataTables;
use Image;

class ArticleController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view article')->only('index', 'show');
        $this->middleware('permission:create article')->only('create', 'store');
        $this->middleware('permission:edit article')->only('edit', 'update');
        $this->middleware('permission:delete article')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $articles = Article::with('user')
                ->select('articles.*')
                ->where('status', 'Published')
                ->latest();

            if (auth()->user()->roles->first()->id != 1) {
                $articles
                    ->where('status', 'Published')
                    ->where('user_id', auth()->user()->id);
            }

            return Datatables::of($articles)
                ->addColumn('body', function ($row) {
                    return str($row->body)->limit(200);
                })
                ->addColumn('user', function ($row) {
                    return $row->user ? $row->user->name : '-';
                })
                ->addColumn('action', 'admin.articles.include.action')
                ->toJson();
        }

        return view('admin.articles.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.articles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreArticleRequest $request)
    {
        $attr = $request->validated();

        $dom = new \DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($request->body, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $images = $dom->getElementsByTagName('img');

        foreach ($images as $img) {
            $src = $img->getAttribute('src');
            if (preg_match('/data:image/', $src)) {
                // preg_match('/data:image\/(?.*?)\;/',$src,$groups);
                preg_match('/data:image\/(?<mime>.*?)\;/', $src, $groups);
                $mimetype = $groups['mime'];
                $filename = uniqid() . '.' . $mimetype;
                $filepath =  'storage/uploads/summernote/articles/' . $filename;

                $image = Image::make($src)->encode($mimetype, 100)->save($filepath);

                $new_src = asset($filepath);
                $img->removeAttribute('src');
                $img->setAttribute('src', $new_src);
            }
        }
        $attr['body'] = $dom->saveHTML();

        if ($request->file('thumbnail') && $request->file('thumbnail')->isValid()) {

            $path = storage_path('app/public/uploads/articles/');
            $filename = $request->file('thumbnail')->hashName();

            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            Image::make($request->file('thumbnail')->getRealPath())->resize(500, 500, function ($constraint) {
                $constraint->upsize();
                $constraint->aspectRatio();
            })->save($path . $filename);

            $attr['thumbnail'] = $filename;
        }

        $tags = explode(",", $attr['tags']);

        $article = Article::create($attr);
        $article->tag($tags);

        return redirect()
            ->route('articles.index')
            ->with('success', __('Artikel berhasil dibuat.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Article $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        $article->load('user:id,name', 'category:id,title');

        return view('admin.articles.show', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Article $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        $article->load('user:id,name', 'category:id,title');

        return view('admin.articles.edit', compact('article'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Article $article
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateArticleRequest $request, Article $article)
    {
        $attr = $request->validated();

        if ($request->file('thumbnail') && $request->file('thumbnail')->isValid()) {

            $path = storage_path('app/public/uploads/articles/');
            $filename = $request->file('thumbnail')->hashName();

            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            Image::make($request->file('thumbnail')->getRealPath())->resize(500, 500, function ($constraint) {
                $constraint->upsize();
                $constraint->aspectRatio();
            })->save($path . $filename);

            // delete old thumbnail from storage
            if ($article->thumbnail != null && file_exists($path . $article->thumbnail)) {
                unlink($path . $article->thumbnail);
            }

            $attr['thumbnail'] = $filename;
        }

        $tags = explode(",", $attr['tags']);
        $article->update($attr);
        $article->retag($tags);

        return redirect()
            ->route('articles.index')
            ->with('success', __('Article berhasil diupdate.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        try {
            // determine path thumbnail
            $path = storage_path('app/public/uploads/articles/');
            // if thumbnail exist remove file from directory
            if ($article->thumbnail != null && file_exists($path . $article->thumbnail)) {
                unlink($path . $article->thumbnail);
            }

            // summernote 
            $dom = new \DOMDocument();
            $dom->loadHTML($article->body, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
            $images = $dom->getElementsByTagName('img');
            foreach ($images as $img) {
                $src = $img->getAttribute('src');

                // if summernote image exist remove file from directory
                if ($src) {
                    $len = strlen("http://127.0.0.1:8000/storage/uploads/summernote/articles/");
                    $fileName = substr($src, $len, strlen($src) - $len);
                    unlink(public_path('storage/uploads/summernote/articles/' . $fileName));
                }
            }

            $article->delete();

            return redirect()
                ->route('articles.index')
                ->with('success', __('Artikel berhasil dihapus.'));
        } catch (\Throwable $th) {
            return redirect()
                ->route('articles.index')
                ->with('error', __('Artikel tidak bisa dihapus karena berelasi dengan data lain.' . $th->getMessage()));
        }
    }

    /**
     * Display a listing draft articles .
     *
     * @return \Illuminate\Http\Response
     */
    public function draft()
    {
        if (request()->ajax()) {
            $articles = Article::with('user')
                ->select('articles.*')
                ->where('status', 'Draft')
                ->latest();

            if (auth()->user()->roles->first()->id != 1) {
                $articles
                    ->where('status', 'Draft')
                    ->where('user_id', auth()->user()->id);
            }

            return Datatables::of($articles)
                ->addColumn('body', function ($row) {
                    return str($row->body)->limit(200);
                })
                ->addColumn('user', function ($row) {
                    return $row->user ? $row->user->name : '-';
                })
                ->addColumn('action', 'admin.articles.include.action')
                ->toJson();
        }

        return view('admin.articles.draft');
    }
}
