<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Http\Requests\{StoreAlbumRequest, UpdateAlbumRequest};
use App\Models\Album;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;
use Image;

class AlbumController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view album')->only('index', 'show');
        $this->middleware('permission:create album')->only('create', 'store');
        $this->middleware('permission:edit album')->only('edit', 'update');
        $this->middleware('permission:delete album')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if (request()->ajax()) {
            $albums = Album::with('galleries')->latest();

            return Datatables::of($albums)
                ->addColumn('action', 'admin.albums.include.action')
                ->toJson();
        }

        return view('admin.albums.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.albums.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAlbumRequest $request)
    {
        $attr = $request->validated();

        try {
            DB::beginTransaction();
            // Create Album
            $album = new Album();
            $album->user_id = auth()->user()->id;
            $album->title = $attr['title'];
            $album->slug = Str::slug($attr['title']);
            $album->body =  $attr['body'];
            $album->save();

            if ($request->hasFile('file')) {
                $images = $request->file('file');
                foreach ($images as $image) {

                    if ($image->isValid()) {
                        $path = storage_path('app/public/uploads/galleries/');
                        $filename = $image->hashName();

                        if (!file_exists($path)) {
                            mkdir($path, 0777, true);
                        }

                        Image::make($image->getRealPath())->resize(500, 500, function ($constraint) {
                            $constraint->upsize();
                            $constraint->aspectRatio();
                        })->save($path . $filename);

                        $attr['file'] = $filename;
                    }
                    // Create Gallery
                    Gallery::create([
                        'album_id' => $album->id,
                        'file' => $attr['file'],
                    ]);
                }
                DB::commit();

                return redirect()
                    ->route('albums.index')
                    ->with('success', __('Gallery created successfully.'));
            }
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('albums.index')
                ->with('error', __('Something went wrong.'));
        }
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Album $album
     * @return \Illuminate\Http\Response
     */
    public function show(Album $album)
    {
        return view('admin.albums.show', compact('album'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Album $album
     * @return \Illuminate\Http\Response
     */
    public function edit(Album $album)
    {
        return view('admin.albums.edit', compact('album'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAlbumRequest $request, Album $album)
    {

        $attr = $request->validated();

        try {
            DB::beginTransaction();

            // Update Album
            $album->update($attr);

            if ($request->file('file')) {
                if ($request->hasFile('file')) {
                    $images = $request->file('file');
                    foreach ($images as $image) {

                        if ($image->isValid()) {
                            $path = storage_path('app/public/uploads/galleries/');
                            $filename = $image->hashName();

                            if (!file_exists($path)) {
                                mkdir($path, 0777, true);
                            }

                            Image::make($image->getRealPath())->resize(500, 500, function ($constraint) {
                                $constraint->upsize();
                                $constraint->aspectRatio();
                            })->save($path . $filename);

                            $attr['file'] = $filename;
                        }
                        // Tambah Gallery
                        Gallery::create([
                            'album_id' => $album->id,
                            'file' => $attr['file'],
                        ]);
                    }

                    DB::commit();

                    return redirect()
                        ->route('albums.index')
                        ->with('success', __('Album updated successfully.'));
                }
            } else {
                DB::commit();
                return redirect()
                    ->route('albums.index')
                    ->with('success', __('Album updated successfully.'));
            }
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('albums.index')
                ->with(
                    'error',
                    __('Something went wrong.')
                );
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Album $album
     * @return \Illuminate\Http\Response
     */
    public function destroy(Album $album)
    {
        try {
            $path = storage_path('app/public/uploads/galleries/');

            foreach ($album->galleries as $gallery) {
                if ($gallery->file != null && file_exists($path . $gallery->file)) {
                    unlink($path . $gallery->file);
                    $gallery->delete();
                    $album->delete();
                }
            }

            return redirect()
                ->route('albums.index')
                ->with('success', __('Album deleted successfully.'));
        } catch (\Throwable $th) {
            return redirect()
                ->route('albums.index')
                ->with('error', __('The Album can`t be deleted because it is related to another table.'));
        }
    }

    /**
     * Remove the specified image from storage.
     *
     * @param  \App\Models\Gallery $gallery
     * @return \Illuminate\Http\Response
     */
    public function removeImage($id)
    {
        $gallery = Gallery::findOrFail($id);

        $path = storage_path('app/public/uploads/galleries/');

        if (!$gallery) abort(404);
        unlink($path . $gallery->file);
        $gallery->delete();
        return back()->with('success', 'Image deleted succesfully');
    }

    /**
     * Update the specified image from storage.
     *
     * @param  \App\Models\Gallery $gallery
     * @return \Illuminate\Http\Response
     */
    public function updateImage($id)
    {
        $gallery = Gallery::findOrFail($id);
        $attr = request()->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5000',
        ]);


        $image = request()->file('image');

        if ($image && $image->isValid()) {
            $path = storage_path('app/public/uploads/galleries/');
            $filename = Str::random(40) . '.jpg';

            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            Image::make($image->getRealPath())->resize(500, 500, function ($constraint) {
                $constraint->upsize();
                $constraint->aspectRatio();
            })->save($path . $filename);

            // delete old file from storage
            if ($gallery->file != null && file_exists($path . $gallery->file)) {
                unlink($path . $gallery->file);
            }

            $attr['image'] = $filename;
        }
        $gallery->update([
            'file' => $attr['image']
        ]);
        return back()->with('success', 'Image updated succesfully');
    }
}
