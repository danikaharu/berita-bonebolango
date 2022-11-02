<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tabloid;
use App\Http\Requests\{StoreTabloidRequest, UpdateTabloidRequest};
use Yajra\DataTables\Facades\DataTables;
use Image;

class TabloidController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view tabloid')->only('index', 'show');
        $this->middleware('permission:create tabloid')->only('create', 'store');
        $this->middleware('permission:edit tabloid')->only('edit', 'update');
        $this->middleware('permission:delete tabloid')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $tabloids = Tabloid::latest();

            return Datatables::of($tabloids)
                ->addColumn('action', 'admin.tabloids.include.action')
                ->toJson();
        }

        return view('admin.tabloids.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.tabloids.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTabloidRequest $request)
    {
        $attr = $request->validated();

        if ($request->file('thumbnail') && $request->file('thumbnail')->isValid()) {
            $path = storage_path('app/public/uploads/tabloids/thumbnail/');
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

        if ($request->file('file') && $request->file('file')->isValid()) {

            $filename = $request->file('file')->hashName();
            $request->file('file')->storeAs('uploads/tabloids', $filename, 'public');

            $attr['file'] = $filename;
        }

        Tabloid::create($attr);

        return redirect()
            ->route('tabloids.index')
            ->with('success', __('Majalah berhasil dibuat.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tabloid $tabloid
     * @return \Illuminate\Http\Response
     */
    public function show(Tabloid $tabloid)
    {
        $tabloid->load('user:id,name');

        return view('admin.tabloids.show', compact('tabloid'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tabloid $tabloid
     * @return \Illuminate\Http\Response
     */
    public function edit(Tabloid $tabloid)
    {
        $tabloid->load('user:id,name');

        return view('admin.tabloids.edit', compact('tabloid'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tabloid $tabloid
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTabloidRequest $request, Tabloid $tabloid)
    {
        $attr = $request->validated();

        if ($request->file('thumbnail') && $request->file('thumbnail')->isValid()) {
            $path = storage_path('app/public/uploads/tabloids/thumbnail/');
            $filename = $request->file('thumbnail')->hashName();

            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            // delete old file from storage
            if ($tabloid->thumbnail != null && file_exists($path . $tabloid->thumbnail)) {
                unlink($path . $tabloid->thumbnail);
            }

            Image::make($request->file('thumbnail')->getRealPath())->resize(500, 500, function ($constraint) {
                $constraint->upsize();
                $constraint->aspectRatio();
            })->save($path . $filename);

            $attr['thumbnail'] = $filename;
        }

        if ($request->file('file') && $request->file('file')->isValid()) {

            $path = storage_path('app/public/uploads/tabloids/');
            $filename = $request->file('file')->hashName();

            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            // delete old file from storage
            if ($tabloid->file != null && file_exists($path . $tabloid->file)) {
                unlink($path . $tabloid->file);
            }

            $request->file('file')->storeAs('uploads/tabloids', $filename, 'public');

            $attr['file'] = $filename;
        }

        $tabloid->update($attr);

        return redirect()
            ->route('tabloids.index')
            ->with('success', __('Tabloid updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tabloid $tabloid
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tabloid $tabloid)
    {
        try {
            $thumbnailPath = storage_path('app/public/uploads/tabloids/thumbnail/');
            $path = storage_path('app/public/uploads/tabloids/');

            if ($tabloid->thumbnail != null && file_exists($thumbnailPath . $tabloid->thubmnail)) {
                unlink($thumbnailPath . $tabloid->thumbnail);
            }

            if ($tabloid->file != null && file_exists($path . $tabloid->file)) {
                unlink($path . $tabloid->file);
            }

            $tabloid->delete();

            return redirect()
                ->route('tabloids.index')
                ->with('success', __('Majalah berhasil dihapus.'));
        } catch (\Throwable $th) {
            return redirect()
                ->route('tabloids.index')
                ->with('error', __('Majalah tidak bisa dihapus karena berelasi dengan data lain.'));
        }
    }
}
