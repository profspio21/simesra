<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyOrderRequest;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Order;
use App\Models\OutletKitchen;
use App\Models\User;
use App\Models\RawMaterial;
use App\Models\OkRm;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('order_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $ok_id = auth()->user()->ok()->pluck('outlet_kitchen_id');

        $orders = Order::with(['ok', 'user'])->where('type', $request->type)->whereHas('ok', function ($query) use ($ok_id) {
            $query->whereIn('ok_id', $ok_id);
        })->get();

        $oks = OutletKitchen::whereIn('id', $ok_id)->get();

        $type = $request->type;

        return view('admin.orders.index', compact('orders', 'type', 'oks'));
    }

    public function create(Request $request)
    {
        abort_if(Gate::denies('order_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $type = $request->type;

        $order_to = $request->order_to;

        if($type == 'penambahan') {
            $oks = OutletKitchen::pluck('lokasi', 'id');
            $rms = RawMaterial::with('category')->whereHas('category', function ($query) use ($order_to) {
                $query->where('type', $order_to);
            })->get();
        }
        
        if($type == 'pengurangan') {
            $ok_id = $request->ok_id;
            $oks = OutletKitchen::where('id', $ok_id)->pluck('lokasi','id');
            $rms = RawMaterial::with(['category', 'ok'])->whereHas('ok', function ($query) use ($ok_id) {
                $query->where('ok_id', $ok_id);
            })->get();
        }

        return view('admin.orders.create', compact('oks','rms', 'type', 'order_to'));
    }

    public function store(StoreOrderRequest $request)
    {
        $order = Order::create($request->all());

        $order->update(['user_id' => auth()->user()->id]);
        
        if($request->order_to == 'ck') {
            $order->update(['status' => 'approve_reject_ck']);
        }
        if($request->order_to == 'purchasing') {
            foreach ($request->rm_id as $key => $value) {
                $okrm = OkRm::where('rm_id', $value)->where('ok_id', $request->ok_id)->first();
                if(!empty($okrm)) {
                    $okrm->update(['qty' => $okrm->qty + $request->qty[$key]]);
                }
                else {
                    OkRm::create(['rm_id' => $value, 'ok_id' => $request->ok_id ,'qty' => $request->qty[$key], 'approved_qty' => $request->qty[$key]]);
                }
            }
            $order->update(['status' => 'selesai']);
        }

        if($request->order_to == null) {
            $order->update(['status' => 'approve_om']);
        }
        
        foreach ($request->rm_id as $key => $value) {
            $order->rms()->attach($value, ['qty' => $request->qty[$key]]);
        }

        $type = $order->type;

        return redirect()->route('admin.orders.index', compact('type'));
    }

    public function edit(Order $order)
    {
        abort_if(Gate::denies('order_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $oks = OutletKitchen::pluck('lokasi', 'id');

        $rms = RawMaterial::with('category')->get();

        $order->load('rms');

        return view('admin.orders.edit', compact('order', 'oks', 'rms'));
    }

    public function update(UpdateOrderRequest $request, Order $order)
    {
        if($request->confirm == 'reject') {
            $order->update(['status' => 'batal']);
            return redirect()->route('admin.orders.index')->with('success','Rejected');
        }

        if($request->confirm == 'approve') {
            $order->update($request->all());
            if($order->status == 'confirm_ok_om') {
                foreach ($request->rm_id as $key => $value) {
                    $this_rm = OkRm::where('rm_id', $value)->where('ok_id', $order->ok_id)->first();
                    // dd(empty($this_rm));
                    if(!empty($this_rm))  {
                        $this_rm->update(['qty' => $this_rm->qty + $request->qty[$key]]);
                    }
                    if(empty($this_rm)) {
                        $this_rm = OkRm::create(['ok_id' => $order->ok_id, 'rm_id' => $value, 'qty' => $request->qty[$key]]);
                    }                    
                    $order->rms()->syncWithoutDetaching([$value => ['qty' => $request->qty[$key], 'ket' => $request->ket[$key]]]);
                }
                $order->update(['status' => 'selesai']);
            }
            if($order->status == 'approve_reject_ck') {
                foreach ($request->rm_id as $key => $value) {
                    $order->rms()->syncWithoutDetaching([$value => ['qty' => $request->qty[$key], 'ket' => $request->ket[$key]]]);
                }
                $order->update(['status' => 'confirm_ok_om']);
            }
            
            if($order->status == 'approve_sa') {
                foreach ($request->rm_id as $key => $value) {
                    $this_rm = OkRm::where('rm_id', $value)->where('ok_id', $order->ok_id)->first();
                    if(!empty($this_rm))  {
                        $this_rm->update(['qty' => $this_rm->qty - $request->qty[$key]]);
                    }
                }                
                $order->update(['status' => 'selesai']);
            }
            if($order->status == 'approve_om') {
                $order->update(['status' => 'approve_sa']);
            }
        }

        $type = $order->type;

        return redirect()->route('admin.orders.index', compact('type'));
    }

    public function show(Order $order)
    {
        abort_if(Gate::denies('order_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $order->load('ok', 'user','rms');

        return view('admin.orders.show', compact('order'));
    }

    public function destroy(Order $order)
    {
        abort_if(Gate::denies('order_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $order->delete();

        return back();
    }

    public function massDestroy(MassDestroyOrderRequest $request)
    {
        $orders = Order::find(request('ids'));

        foreach ($orders as $order) {
            $order->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function approve(Request $request, Order $order)
    {
        abort_if(Gate::denies('approve_ck' || 'approve_om' || 'approve_ok' ), Response::HTTP_FORBIDDEN, '403 Forbidden');


    }
}