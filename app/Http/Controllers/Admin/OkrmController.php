<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OkRm;
use App\Models\RawMaterial;
use App\Models\RmCategory;
use App\Models\OutletKitchen;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OkrmController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('stock_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $okrm = OkRm::with(['ok', 'rm'])->get();

        return view('admin.okrms.index', compact('okrm'));
    }

    public function create(Request $request)
    {
        abort_if(Gate::denies('stock_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $ok_id = $request->ok_id;

        $rawMaterials = RawMaterial::with(['category', 'ok'])->get();
        $oks = OutletKitchen::where('id', $request->ok_id)->get();

        return view('admin.okrms.create', compact('rawMaterials', 'oks'));
    }

    public function store(Request $request)
    {
        $okrm = OkRm::where('rm_id', $request->rm_id)->where('ok_id', $request->ok_id)->first();
        if(!empty($okrm)) {
            $okrm->update(['qty' => $okrm->qty + $request->qty]);
        }
        else {
            $okrm = OkRm::create($request->all());
        }

        return redirect()->route('admin.stock.list', ['id' => $okrm->ok_id]);
    }

    public function edit(Request $request, OkRm $okrm)
    {
        dd($request->all());
        abort_if(Gate::denies('stock_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $okrm->load(['ok','rm']);

        if($okrm->rm->catergory_id != '99') {
            return view('admin.stock.list', ['id' => $okrm->ok_id])->with('error', 'Not Allowed');
        }
        

        return view('admin.okrms.edit', compact('okrm'));
    }
    
    public function editStock(Request $request)
    {
        // dd($request->all());
        abort_if(Gate::denies('stock_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $okrm = OkRm::with(['ok','rm'])->where('id', $request->id)->first();

        if($okrm->rm->category->name != 'Others') {
            return redirect()->route('admin.stock.list', ['id' => $okrm->ok_id])->with('error', 'Not Allowed');

        }
        
        return view('admin.okrms.edit', compact('okrm'));
    }

    public function update(Request $request)
    {
        $okrm = OkRm::where('rm_id', $request->rm_id)->where('ok_id', $request->ok_id)->first()->update(['qty' => $request->qty]);
        
        return redirect()->route('admin.stock.list', ['id' => $request->ok_id])->with('success','Successfully Updated');
    }

    public function show(OkRm $okrm)
    {
        abort_if(Gate::denies('stock_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.okrm.show', compact('okrm'));
    }

    public function destroy(OkRm $okrm)
    {
        abort_if(Gate::denies('stock_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $okrm->delete();

        return back();
    }

    public function massDestroy(Request $request)
    {
        $okrm = OkRm::find(request('ids'));

        foreach ($okrm as $okrm) {
            $okrm->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}