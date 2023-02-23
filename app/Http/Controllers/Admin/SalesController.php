<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroySaleRequest;
use App\Http\Requests\StoreSaleRequest;
use App\Http\Requests\UpdateSaleRequest;
use App\Models\Product;
use App\Models\Sale;
use App\Models\User;
use App\Models\RawMaterial;
use App\Models\OutletKitchen;
use App\Models\OkRm;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use \DB;

class SalesController extends Controller
{
    public function list(Request $request)
    {
        abort_if(Gate::denies('sale_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $ok_id = $request->id;

        $products = Product::with('sales')->get();

        return view('admin.sales.list', compact('products','ok_id'));
    }
    public function index(Request $request)
    {
        abort_if(Gate::denies('sale_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $ok_id = $request->ok_id;

        $ok = OutletKitchen::where('id', $ok_id)->first();
        
        $sales = Sale::with(['product', 'ok'])->where('product_id', $request->product_id)->where('ok_id', $ok_id)->get();

        return view('admin.sales.index', compact('sales','ok_id','ok'));
    }

    public function create(Request $request)
    {
        abort_if(Gate::denies('sale_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $products = Product::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $oks = OutletKitchen::where('id', $request->ok_id)->pluck('lokasi', 'id');

        return view('admin.sales.create', compact('products', 'oks'));
    }

    public function store(StoreSaleRequest $request)
    {
        $ok_id = $request->ok_id;
        $product_id = $request->product_id;
        $rms = RawMaterial::with('products','ok')->whereHas('products', function ($query) use ($product_id) {
            $query->where('product_id', '=', $product_id);
        })->whereHas('ok', function ($query) use ($ok_id) {
            $query->where('ok_id', '=', $ok_id);
        })->get();

        $okRm = OkRm::with('rm')->where('ok_id', $ok_id)->whereIn('rm_id', $rms->pluck('id'))->get();


        if(empty($rms->first())) {
            return redirect()->route('admin.sales.list', ['id' => $request->ok_id])->with('error', 'Stok tidak ada');
        }
        foreach($okRm as $rm) {
            if( $rm->rm->category->name != 'Others' && $rm->qty < $request->qty) {
                return redirect()->route('admin.sales.list', ['id' => $request->ok_id])->with('error', 'Stok terbatas');
            }
        }

        // dd($okRm->toArray());
        
        foreach($okRm as $rm) {
            if( $rm->rm->category->name != 'Others') {
                $rm->update(['qty' => $rm->qty - $request->qty]);
            }
        }

        $sale = Sale::create($request->all());

        $sale->update(['user_id' => auth()->user()->id]);

        return redirect()->route('admin.sales.list', ['id' => $request->ok_id])->with('success', 'Berhasil ditambah');
    }

    public function edit(Sale $sale)
    {
        abort_if(Gate::denies('sale_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $products = Product::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $sale->load('product', 'user');

        $oks = OutletKitchen::whereIn('id', auth()->user()->ok()->pluck('outlet_kitchen_id'))->pluck('lokasi','id');

        return view('admin.sales.edit', compact('products', 'sale','oks'));
    }

    public function update(UpdateSaleRequest $request, Sale $sale)
    {
        $product_id = $sale->product_id;
        $ok_id = $sale->ok_id;
        $rms = RawMaterial::with('products','ok')->whereHas('products', function ($query) use ($product_id) {
            $query->where('product_id', '=', $product_id);
        })->whereHas('ok', function ($query) use ($ok_id) {
            $query->where('ok_id', '=', $ok_id);
        })->get();

        $okRm = OkRm::with('rm')->where('ok_id', $ok_id)->whereIn('rm_id', $rms->pluck('id'))->get();

        foreach($okRm as $rm) {
            if ($rm->rm->category->name != 'Others' && $rm->qty < $request->qty - $sale->qty) {
                return redirect()->route('admin.sales.list', ['id' => $sale->ok_id])->with('error', 'Stok Terbatas');
            }
        }

        foreach($okRm as $rm) {
            if ($rm->rm->category->name != 'Others') {
                $rm->update(['qty' => $rm->qty + $sale->qty - $request->qty]);
            }
        }

        $sale->update($request->all());
        $sale->update(['user_id' => auth()->user()->id]);

        return redirect()->route('admin.sales.list', ['id' => $sale->ok_id])->with('success', 'Successfully Updated');
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

        $product_id = $sale->product_id;
        $ok_id = $sale->ok_id;
        $rms = RawMaterial::with('products','ok')->whereHas('products', function ($query) use ($product_id) {
            $query->where('product_id', '=', $product_id);
        })->whereHas('ok', function ($query) use ($ok_id) {
            $query->where('ok_id', '=', $ok_id);
        })->get();

        $okRm = OkRm::with('rm')->where('ok_id', $ok_id)->whereIn('rm_id', $rms->pluck('id'))->get();

        foreach($okRm as $rm) {
            $rm->update(['qty' => $rm->qty + $sale->qty]);
        }

        $sale->delete();

        return back()->with('success', 'Successfully Deleted');
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