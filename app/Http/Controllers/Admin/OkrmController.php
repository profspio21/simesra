<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OkRm;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OkrmController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('raw_material_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $okrm = OkRm::all();

        return view('admin.okrm.index', compact('okrm'));
    }

    public function create()
    {
        abort_if(Gate::denies('raw_material_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.okrm.create');
    }

    public function store(Request $request)
    {
        $raw_material = OkRm::create($request->all());

        return redirect()->route('admin.okrm.index');
    }

    public function edit(OkRm $raw_material)
    {
        abort_if(Gate::denies('raw_material_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.okrm.edit', compact('raw_material'));
    }

    public function update(Request $request, OkRm $raw_material)
    {
        $raw_material->update($request->all());

        return redirect()->route('admin.okrm.index');
    }

    public function show(OkRm $raw_material)
    {
        abort_if(Gate::denies('raw_material_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.okrm.show', compact('raw_material'));
    }

    public function destroy(OkRm $raw_material)
    {
        abort_if(Gate::denies('raw_material_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $raw_material->delete();

        return back();
    }

    public function massDestroy(Request $request)
    {
        $okrm = OkRm::find(request('ids'));

        foreach ($okrm as $raw_material) {
            $raw_material->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}