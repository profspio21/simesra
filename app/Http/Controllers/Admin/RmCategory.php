<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyRmCategoryRequest;
use App\Http\Requests\StoreRmCategoryRequest;
use App\Http\Requests\UpdateRmCategoryRequest;
use App\Models\RmCategory;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RmCategoryController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('rm_category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $rmCategories = RmCategory::all();

        return view('admin.rmCategories.index', compact('rmCategories'));
    }

    public function create()
    {
        abort_if(Gate::denies('rm_category_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.rmCategories.create');
    }

    public function store(StoreRmCategoryRequest $request)
    {
        $rmCategory = RmCategory::create($request->all());

        return redirect()->route('admin.rm-categories.index');
    }

    public function edit(RmCategory $rmCategory)
    {
        abort_if(Gate::denies('rm_category_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.rmCategories.edit', compact('rmCategory'));
    }

    public function update(UpdateRmCategoryRequest $request, RmCategory $rmCategory)
    {
        $rmCategory->update($request->all());

        return redirect()->route('admin.rm-categories.index');
    }

    public function show(RmCategory $rmCategory)
    {
        abort_if(Gate::denies('rm_category_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.rmCategories.show', compact('rmCategory'));
    }

    public function destroy(RmCategory $rmCategory)
    {
        abort_if(Gate::denies('rm_category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $rmCategory->delete();

        return back();
    }

    public function massDestroy(MassDestroyRmCategoryRequest $request)
    {
        $rmCategories = RmCategory::find(request('ids'));

        foreach ($rmCategories as $rmCategory) {
            $rmCategory->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}