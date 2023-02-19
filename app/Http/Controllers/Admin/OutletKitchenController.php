<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyOutletKitchenRequest;
use App\Http\Requests\StoreOutletKitchenRequest;
use App\Http\Requests\UpdateOutletKitchenRequest;
use App\Models\OutletKitchen;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OutletKitchenController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('outlet_kitchen_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $outletKitchens = OutletKitchen::with(['users'])->get();

        return view('admin.outletKitchens.index', compact('outletKitchens'));
    }

    public function create()
    {
        abort_if(Gate::denies('outlet_kitchen_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('username', 'id');

        return view('admin.outletKitchens.create', compact('users'));
    }

    public function store(StoreOutletKitchenRequest $request)
    {
        $outletKitchen = OutletKitchen::create($request->all());
        $outletKitchen->users()->sync($request->input('users', []));

        return redirect()->route('admin.outlet-kitchens.index');
    }

    public function edit(OutletKitchen $outletKitchen)
    {
        abort_if(Gate::denies('outlet_kitchen_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('username', 'id');

        $outletKitchen->load('users');

        return view('admin.outletKitchens.edit', compact('outletKitchen', 'users'));
    }

    public function update(UpdateOutletKitchenRequest $request, OutletKitchen $outletKitchen)
    {
        $outletKitchen->update($request->all());
        $outletKitchen->users()->sync($request->input('users', []));

        return redirect()->route('admin.outlet-kitchens.index');
    }

    public function show(OutletKitchen $outletKitchen)
    {
        abort_if(Gate::denies('outlet_kitchen_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $outletKitchen->load('users');

        return view('admin.outletKitchens.show', compact('outletKitchen'));
    }

    public function destroy(OutletKitchen $outletKitchen)
    {
        abort_if(Gate::denies('outlet_kitchen_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $outletKitchen->delete();

        return back();
    }

    public function massDestroy(MassDestroyOutletKitchenRequest $request)
    {
        $outletKitchens = OutletKitchen::find(request('ids'));

        foreach ($outletKitchens as $outletKitchen) {
            $outletKitchen->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}