<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyRawMaterialRequest;
use App\Http\Requests\StoreRawMaterialRequest;
use App\Http\Requests\UpdateRawMaterialRequest;
use App\Models\OutletKitchen;
use App\Models\RawMaterial;
use App\Models\RmCategory;
use App\Models\Order;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RawMaterialController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('raw_material_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $rawMaterials = RawMaterial::with(['category', 'ok'])->get();

        return view('admin.rawMaterials.index', compact('rawMaterials'));
    }

    public function create()
    {
        abort_if(Gate::denies('raw_material_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $categories = RmCategory::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $oks = OutletKitchen::pluck('lokasi', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.rawMaterials.create', compact('categories', 'oks'));
    }

    public function store(StoreRawMaterialRequest $request)
    {
        $rawMaterial = RawMaterial::create($request->all());

        return redirect()->route('admin.raw-materials.index');
    }

    public function edit(RawMaterial $rawMaterial)
    {
        abort_if(Gate::denies('raw_material_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $categories = RmCategory::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $oks = OutletKitchen::pluck('lokasi', 'id')->prepend(trans('global.pleaseSelect'), '');

        $rawMaterial->load('category', 'ok');

        return view('admin.rawMaterials.edit', compact('categories', 'oks', 'rawMaterial'));
    }

    public function update(UpdateRawMaterialRequest $request, RawMaterial $rawMaterial)
    {
        $rawMaterial->update($request->all());

        return redirect()->route('admin.raw-materials.index');
    }

    public function show(RawMaterial $rawMaterial)
    {
        abort_if(Gate::denies('raw_material_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $rawMaterial->load('category', 'ok');

        return view('admin.rawMaterials.show', compact('rawMaterial'));
    }

    public function destroy(RawMaterial $rawMaterial)
    {
        abort_if(Gate::denies('raw_material_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $rawMaterial->delete();

        return back();
    }

    public function massDestroy(MassDestroyRawMaterialRequest $request)
    {
        $rawMaterials = RawMaterial::find(request('ids'));

        foreach ($rawMaterials as $rawMaterial) {
            $rawMaterial->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}