<?php

namespace App\Http\Controllers\Admin;

use App\Link;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreLinksRequest;
use App\Http\Requests\Admin\UpdateLinksRequest;
use App\Http\Requests\Admin\CsvImportRequest;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use App\Services\CrawlerService;
use App\ExtractResult;
use DB;

class LinksController extends Controller
{
    private $crawlerService;

    public function __construct(CrawlerService $crawlerService)
    {
        $this->crawlerService = $crawlerService;
    }
    /**
     * Display a listing of Link.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('link_access')) {
            return abort(401);
        }


        if (request('show_deleted') == 1) {
            if (! Gate::allows('link_delete')) {
                return abort(401);
            }
            $links = Link::onlyTrashed()->orderBy("id", "DESC")->get();
        } else {
            $links = Link::all();
        }

        return view('admin.links.index', compact('links'));
    }

    /**
     * Show the form for creating new Link.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('link_create')) {
            return abort(401);
        }
        return view('admin.links.create');
    }

    /**
     * Store a newly created Link in storage.
     *
     * @param  \App\Http\Requests\StoreLinksRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLinksRequest $request)
    {
        if (! Gate::allows('link_create')) {
            return abort(401);
        }
        $data = $request->all();
        $data['status'] = Link::QUEUE_STATUS_OPEN;
        $link = Link::create($data);
        if (isset($data['is_crawl'])) {
            $data = $this->crawlerService->crawler($link->link);
            ExtractResult::updateOrCreate([
                    "link_id" => $link->id
                ],
                $data
            );
            $link->update(['status' => Link::QUEUE_STATUS_COMPLETE]);
        }
        return redirect()->route('admin.links.index');
    }


    /**
     * Show the form for editing Link.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('link_edit')) {
            return abort(401);
        }
        $link = Link::findOrFail($id);

        return view('admin.links.edit', compact('link'));
    }

    /**
     * Update Link in storage.
     *
     * @param  \App\Http\Requests\UpdateLinksRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLinksRequest $request, $id)
    {
        if (! Gate::allows('link_edit')) {
            return abort(401);
        }
        $link = Link::findOrFail($id);
        $link->update($request->all());



        return redirect()->route('admin.links.index');
    }


    /**
     * Display Link.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! Gate::allows('link_view')) {
            return abort(401);
        }
        $link = Link::findOrFail($id);

        return view('admin.links.show', compact('link'));
    }


    /**
     * Remove Link from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('link_delete')) {
            return abort(401);
        }
        $link = Link::findOrFail($id);
        $link->delete();

        return redirect()->route('admin.links.index');
    }

    /**
     * Delete all selected Link at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (! Gate::allows('link_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = Link::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }


    /**
     * Restore Link from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (! Gate::allows('link_delete')) {
            return abort(401);
        }
        $link = Link::onlyTrashed()->findOrFail($id);
        $link->restore();

        return redirect()->route('admin.links.index');
    }

    /**
     * Permanently delete Link from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function perma_del($id)
    {
        if (! Gate::allows('link_delete')) {
            return abort(401);
        }
        $link = Link::onlyTrashed()->findOrFail($id);
        $link->forceDelete();

        return redirect()->route('admin.links.index');
    }

    public function import(CsvImportRequest $request)
    {
        $path = $request->file('csv_file')->getRealPath();
        $data = array_map('str_getcsv', file($path));
        $csv_header_fields = [];
        if ($request->has('header')) {
            $headerFields = config('import.admin.links.header_fields');
            foreach ($headerFields as $value) {
                $csv_header_fields[$value] = array_search($value, $data[0]);
            }
            array_shift($data);
        }
        $dataInsert = [];
        $date = Carbon::now()->toDateTimeString();
        foreach($data as $da) {
            $dataInsert[] = [
                "link"=> $da[0],
                'status' => Link::QUEUE_STATUS_OPEN,
                'created_at' => $date,
                'updated_at' => $date
            ];
        }
        Link::insert($dataInsert);
        return redirect()->route('admin.links.index');
    }

    public function getViewImport()
    {
        return view('admin.links.import');
    }

    public function parseImport(CsvImportRequest $request)
    {
        $path = $request->file('csv_file')->getRealPath();
        $data = array_map('str_getcsv', file($path));
        $csv_data = array_slice($data, 0, 2);
        return view('admin.links.import_fields', compact('csv_data'));
    }
    
    /**
     * Crawler data
     *
     * @param Request $request Request
     * @param int     $id      Links Id
     *
     * @return \Illuminate\Http\Response 
     */
    public function crawler(Request $request, $id)
    {
        $link = Link::findOrFail($id);
        $link->update(['status' => Link::QUEUE_STATUS_PROGRESS]);
        $data = $this->crawlerService->crawler($link->link);
        $extractResult = ExtractResult::updateOrCreate([
                "link_id" => $link->id
            ],
            $data
        );
        $extractResult->features()->delete();
        $extractResult->features()->createMany($data['features']);
        $link->update(['status' => Link::QUEUE_STATUS_COMPLETE]);
        return redirect()->route('admin.links.index');
    }
}
