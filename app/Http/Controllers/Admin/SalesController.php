<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroySaleRequest;
use App\Http\Requests\StoreSaleRequest;
use App\Http\Requests\UpdateSaleRequest;
use App\Models\Product;
use App\Models\Sale;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SalesController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('sale_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sales = Sale::with(['product', 'user'])->get();

        return view('admin.sales.index', compact('sales'));
    }

    public function create()
    {
        abort_if(Gate::denies('sale_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $products = Product::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $users = User::pluck('username', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.sales.create', compact('products', 'users'));
    }

    public function store(StoreSaleRequest $request)
    {
        $sale = Sale::create($request->all());

        return redirect()->route('admin.sales.index');
    }

    public function edit(Sale $sale)
    {
        abort_if(Gate::denies('sale_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $products = Product::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $users = User::pluck('username', 'id')->prepend(trans('global.pleaseSelect'), '');

        $sale->load('product', 'user');

        return view('admin.sales.edit', compact('products', 'sale', 'users'));
    }

    public function update(UpdateSaleRequest $request, Sale $sale)
    {
        $sale->update($request->all());

        return redirect()->route('admin.sales.index');
    }

    public function show(Sale $sale)
    {
        abort_if(Gate::denies('sale_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sale->load('product', 'user');

        return view('admin.sales.show', compact('sale'));
    }

    public function destroy(Sale $sale)
    {
        abort_if(Gate::denies('sale_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sale->delete();

        return back();
    }

    public function massDestroy(MassDestroySaleRequest $request)
    {
        $sales = Sale::find(request('ids'));

        foreach ($sales as $sale) {
            $sale->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}