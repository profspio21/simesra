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
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use \DB;
use Alert;

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

    public function create()
    {
        abort_if(Gate::denies('sale_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $products = Product::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $oks = OutletKitchen::whereIn('id', auth()->user()->ok()->pluck('outlet_kitchen_id'))->pluck('lokasi', 'id');

        return view('admin.sales.create', compact('products', 'oks'));
    }

    public function store(StoreSaleRequest $request)
    {
        // $rms = RawMaterial::with('products')->where('id', $request->ok_id)->get();
        $product = Product::with('rms')->where('id', $request->product_id)->first();
        $rms = $product->rms->where('ok_id', $request->ok_id);

        if(empty($rms->first())) {
            return redirect()->route('admin.sales.list')->with('error', 'Stok tidak ada');
        }
        foreach($rms as $rm) {
            if( $rm->category->name != 'Others' && $rm->qty < $request->qty) {
                return redirect()->route('admin.sales.list')->with('error', 'Stok terbatas');
            }
        }
        
        foreach($rms as $rm) {
            if( $rm->category->name != 'Others') {
                RawMaterial::where('id', $rm->id)->where('ok_id',$request->ok_id)->update(['qty' => $rm->qty - $request->qty]);
            }
        }

        $sale = Sale::create($request->all());

        $sale->update(['user_id' => auth()->user()->id]);

        return redirect()->route('admin.sales.list')->with('success', 'Berhasil ditambah');
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
        $rms = $sale->load('product')->product->load('rms')->rms;
        foreach($rms as $rm) {
            if ($rm->category->name != 'Others' && $rm->qty < $request->qty - $sale->qty) {
                return redirect()->route('admin.sales.list')->with('error', 'Stok Terbatas');
            }
        }
        foreach($rms as $rm) {
            if ($rm->category->name != 'Others') {
                RawMaterial::where('id',$rm->id)->where('ok_id', $sale->ok_id)->update(['qty' => $rm->qty + $sale->qty - $request->qty]);
            }
        }
        $sale->update($request->all());
        $sale->update(['user_id' => auth()->user()->id]);

        return redirect()->route('admin.sales.list')->with('success', 'Successfully Updated');
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

        $product = Product::with('rms')->where('id', $sale->product_id)->first();

        foreach($product->rms as $rm) {
            $this_rm = RawMaterial::where('id', $rm->id)->where('ok_id',$sale->ok_id)->first();
            $this_rm->update(['qty' => $this_rm->qty + $sale->qty]);
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