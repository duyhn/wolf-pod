<?php

namespace App\Http\Controllers\Api\V1;

use App\ExtractManager;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreExtractManagersRequest;
use App\Http\Requests\Admin\UpdateExtractManagersRequest;
use App\Http\Controllers\Traits\FileUploadTrait;

class ExtractManagersController extends Controller
{
    use FileUploadTrait;

    public function index()
    {
        return ExtractManager::all();
    }

    public function show($id)
    {
        return ExtractManager::findOrFail($id);
    }

    public function update(UpdateExtractManagersRequest $request, $id)
    {
        $request = $this->saveFiles($request);
        $extract_manager = ExtractManager::findOrFail($id);
        $extract_manager->update($request->all());
        

        return $extract_manager;
    }

    public function store(StoreExtractManagersRequest $request)
    {
        $request = $this->saveFiles($request);
        $extract_manager = ExtractManager::create($request->all());
        

        return $extract_manager;
    }

    public function destroy($id)
    {
        $extract_manager = ExtractManager::findOrFail($id);
        $extract_manager->delete();
        return '';
    }
}
