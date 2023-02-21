<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRawMaterialRequest;
use App\Http\Requests\UpdateRawMaterialRequest;
use App\Http\Resources\Admin\RawMaterialResource;
use App\Models\RawMaterial;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RawMaterialApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('raw_material_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new RawMaterialResource(RawMaterial::with(['category', 'ok'])->get());
    }

    public function store(StoreRawMaterialRequest $request)
    {
        $rawMaterial = RawMaterial::create($request->all());

        return (new RawMaterialResource($rawMaterial))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(RawMaterial $rawMaterial)
    {
        abort_if(Gate::denies('raw_material_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new RawMaterialResource($rawMaterial->load(['category', 'ok']));
    }

    public function update(UpdateRawMaterialRequest $request, RawMaterial $rawMaterial)
    {
        $rawMaterial->update($request->all());

        return (new RawMaterialResource($rawMaterial))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(RawMaterial $rawMaterial)
    {
        abort_if(Gate::denies('raw_material_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $rawMaterial->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}