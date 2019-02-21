<?php

namespace App\Http\Controllers\Admin;

use App\ExtractResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreExtractManagersRequest;
use App\Http\Requests\Admin\UpdateExtractManagersRequest;
use App\Http\Controllers\Traits\FileUploadTrait;
use App\Services\CrawlerService;

class ExtractResultController extends Controller
{
    use FileUploadTrait;

    private $crawlerService;

    /**
     * Constructor function
     *
     * @param CrawlerService $crawlerService
     *
     * @return void
     */
    public function __construct(CrawlerService $crawlerService)
    {
        $this->crawlerService = $crawlerService;
    }
    /**
     * Display a listing of ExtractManager.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('extract_manager_access')) {
            return abort(401);
        }
        $data = $this->crawlerService->crawler("https://www.amazon.com/dp/B0714PH4QZ");
        if (request('show_deleted') == 1) {
            if (! Gate::allows('extract_manager_delete')) {
                return abort(401);
            }
            $extract_managers = ExtractResult::onlyTrashed()->get();
        } else {
            $extract_managers = ExtractResult::all();
        }

        return view('admin.extract_managers.index', compact('extract_managers'));
    }

    /**
     * Show the form for creating new ExtractManager.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('extract_manager_create')) {
            return abort(401);
        }
        return view('admin.extract_managers.create');
    }

    /**
     * Store a newly created ExtractManager in storage.
     *
     * @param  \App\Http\Requests\StoreExtractManagersRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreExtractManagersRequest $request)
    {
        if (! Gate::allows('extract_manager_create')) {
            return abort(401);
        }
        $request = $this->saveFiles($request);
        $extract_manager = ExtractResult::create($request->all());


        foreach ($request->input('images_id', []) as $index => $id) {
            $model          = config('medialibrary.media_model');
            $file           = $model::find($id);
            $file->model_id = $extract_manager->id;
            $file->save();
        }


        return redirect()->route('admin.extract_managers.index');
    }


    /**
     * Show the form for editing ExtractManager.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('extract_manager_edit')) {
            return abort(401);
        }
        $extract_manager = ExtractResult::findOrFail($id);

        return view('admin.extract_managers.edit', compact('extract_manager'));
    }

    /**
     * Update ExtractManager in storage.
     *
     * @param  \App\Http\Requests\UpdateExtractManagersRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateExtractManagersRequest $request, $id)
    {
        if (! Gate::allows('extract_manager_edit')) {
            return abort(401);
        }
        $request = $this->saveFiles($request);
        $extract_manager = ExtractResult::findOrFail($id);
        $extract_manager->update($request->all());


        $media = [];
        foreach ($request->input('images_id', []) as $index => $id) {
            $model          = config('medialibrary.media_model');
            $file           = $model::find($id);
            $file->model_id = $extract_manager->id;
            $file->save();
            $media[] = $file->toArray();
        }
        $extract_manager->updateMedia($media, 'images');


        return redirect()->route('admin.extract_managers.index');
    }


    /**
     * Display ExtractManager.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! Gate::allows('extract_manager_view')) {
            return abort(401);
        }
        $extract_manager = ExtractResult::findOrFail($id);

        return view('admin.extract_managers.show', compact('extract_manager'));
    }


    /**
     * Remove ExtractManager from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('extract_manager_delete')) {
            return abort(401);
        }
        $extract_manager = ExtractResult::findOrFail($id);
        $extract_manager->deletePreservingMedia();

        return redirect()->route('admin.extract_managers.index');
    }

    /**
     * Delete all selected ExtractManager at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (! Gate::allows('extract_manager_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = ExtractResult::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->deletePreservingMedia();
            }
        }
    }


    /**
     * Restore ExtractManager from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (! Gate::allows('extract_manager_delete')) {
            return abort(401);
        }
        $extract_manager = ExtractResult::onlyTrashed()->findOrFail($id);
        $extract_manager->restore();

        return redirect()->route('admin.extract_managers.index');
    }

    /**
     * Permanently delete ExtractManager from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function perma_del($id)
    {
        if (! Gate::allows('extract_manager_delete')) {
            return abort(401);
        }
        $extract_manager = ExtractResult::onlyTrashed()->findOrFail($id);
        $extract_manager->forceDelete();

        return redirect()->route('admin.extract_managers.index');
    }
}
