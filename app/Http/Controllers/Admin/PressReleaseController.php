<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PressRelease;
use App\Http\Requests\{StorePressReleaseRequest, UpdatePressReleaseRequest};
use Yajra\DataTables\Facades\DataTables;
use Image;

class PressReleaseController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view pressrelease')->only('index', 'show');
        $this->middleware('permission:create pressrelease')->only('create', 'store');
        $this->middleware('permission:edit pressrelease')->only('edit', 'update');
        $this->middleware('permission:delete pressrelease')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $pressReleases = PressRelease::with('user:id,name', 'category:id,title');

            return Datatables::of($pressReleases)

                ->addColumn('user', function ($row) {
                    return $row->user ? $row->user->name : '-';
                })

                ->addColumn('action', 'admin.press-releases.include.action')
                ->toJson();
        }

        return view('admin.press-releases.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.press-releases.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePressReleaseRequest $request)
    {
        $attr = $request->validated();

        if ($request->file('thumbnail') && $request->file('thumbnail')->isValid()) {

            $path = storage_path('app/public/uploads/press-releases/');
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

        PressRelease::create($attr);

        return redirect()
            ->route('press-releases.index')
            ->with('success', __('PressRelease created successfully.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PressRelease $pressRelease
     * @return \Illuminate\Http\Response
     */
    public function show(PressRelease $pressRelease)
    {
        $pressRelease->load('user:id,name', 'category:id,title');

        return view('admin.press-releases.show', compact('pressRelease'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PressRelease $pressRelease
     * @return \Illuminate\Http\Response
     */
    public function edit(PressRelease $pressRelease)
    {
        $pressRelease->load('user:id,name', 'category:id,title');

        return view('admin.press-releases.edit', compact('pressRelease'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PressRelease $pressRelease
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePressReleaseRequest $request, PressRelease $pressRelease)
    {
        $attr = $request->validated();

        if ($request->file('thumbnail') && $request->file('thumbnail')->isValid()) {

            $path = storage_path('app/public/uploads/press-releases/');
            $filename = $request->file('thumbnail')->hashName();

            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            Image::make($request->file('thumbnail')->getRealPath())->resize(500, 500, function ($constraint) {
                $constraint->upsize();
                $constraint->aspectRatio();
            })->save($path . $filename);

            // delete old thumbnail from storage
            if ($pressRelease->thumbnail != null && file_exists($path . $pressRelease->thumbnail)) {
                unlink($path . $pressRelease->thumbnail);
            }

            $attr['thumbnail'] = $filename;
        }

        $pressRelease->update($attr);

        return redirect()
            ->route('press-releases.index')
            ->with('success', __('PressRelease updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PressRelease $pressRelease
     * @return \Illuminate\Http\Response
     */
    public function destroy(PressRelease $pressRelease)
    {
        try {
            $path = storage_path('app/public/uploads/press-releases/');

            if ($pressRelease->thumbnail != null && file_exists($path . $pressRelease->thumbnail)) {
                unlink($path . $pressRelease->thumbnail);
            }

            $pressRelease->delete();

            return redirect()
                ->route('press-releases.index')
                ->with('success', __('PressRelease deleted successfully.'));
        } catch (\Throwable $th) {
            return redirect()
                ->route('press-releases.index')
                ->with('error', __('The PressRelease can`t be deleted because it is related to another table.'));
        }
    }
}
