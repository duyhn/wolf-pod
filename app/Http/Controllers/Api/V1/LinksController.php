<?php

namespace App\Http\Controllers\Api\V1;

use App\Link;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreLinksRequest;
use App\Http\Requests\Admin\UpdateLinksRequest;

class LinksController extends Controller
{
    public function index()
    {
        return Link::all();
    }

    public function show($id)
    {
        return Link::findOrFail($id);
    }

    public function update(UpdateLinksRequest $request, $id)
    {
        $link = Link::findOrFail($id);
        $link->update($request->all());
        

        return $link;
    }

    public function store(StoreLinksRequest $request)
    {
        $link = Link::create($request->all());
        

        return $link;
    }

    public function destroy($id)
    {
        $link = Link::findOrFail($id);
        $link->delete();
        return '';
    }
}
