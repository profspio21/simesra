@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.detail') }} {{ trans('cruds.order.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="javascript:history.back()">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.order.fields.id') }}
                        </th>
                        <td>
                            {{ $order->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.order.fields.order_to') }}
                        </th>
                        <td>
                            {{ App\Models\Order::ORDER_TO_SELECT[$order->order_to] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.order.fields.ok') }}
                        </th>
                        <td>
                            {{ $order->ok->lokasi ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.order.fields.user') }}
                        </th>
                        <td>
                            {{ $order->user->username ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.order.fields.keterangan') }}
                        </th>
                        <td>
                            {{ $order->keterangan }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.order.fields.status') }}
                        </th>
                        <td>
                            {{ App\Models\Order::STATUS_SELECT[$order->status] ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <hr>
            List Order
            <hr>
            <table class="table table-bordered table-striped">
                <tbody>
                    
                    <tr>
                        <th>
                            {{trans('cruds.rawMaterial.fields.name')}}
                        </th>
                        <th>
                            {{trans('cruds.rawMaterial.fields.category')}}
                        </th>
                        <th>
                            {{trans('cruds.rawMaterial.fields.qty')}}
                        </th>
                        <th>
                            {{trans('cruds.rawMaterial.fields.approved_qty')}}
                        </th>
                        <th>
                            {{trans('cruds.order.fields.keterangan')}}
                        </th>
                    </tr>
                    @foreach ($order->rms as $item)
                    <tr>
                        <td>
                            {{$item->name}}
                        </td>
                        <td>
                            {{$item->category->name}}
                        </td>
                        <td>
                            {{$item->pivot->qty}}
                        </td>
                        <td>
                            {{$item->pivot->approved_qty}}
                        </td>
                        <td>
                            {{$item->pivot->ket}}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="javascript:history.back()">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection