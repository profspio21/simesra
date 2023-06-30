@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.order.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.orders.update", [$order->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            @if($order->order_to != null)
            <div class="form-group">
                <label class="required">{{ trans('cruds.order.fields.order_to') }}</label>
                <select class="form-control {{ $errors->has('order_to') ? 'is-invalid' : '' }}" name="order_to" id="order_to" required >
                    <option value="{{$order->order_to}}">{{ App\Models\Order::ORDER_TO_SELECT[$order->order_to] }}</option>
                </select>
                @if($errors->has('order_to'))
                    <div class="invalid-feedback">
                        {{ $errors->first('order_to') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.order.fields.order_to_helper') }}</span>
            </div>
            @endif
            <div class="form-group">
                <label class="required">{{ trans('cruds.order.fields.type') }}</label>
                <select class="form-control {{ $errors->has('type') ? 'is-invalid' : '' }}" name="type" id="type" required >
                    <option value="{{ $order->type }}">{{ App\Models\Order::TYPE_SELECT[$order->type] }}</option>
                </select>
                @if($errors->has('order_type'))
                    <div class="invalid-feedback">
                        {{ $errors->first('order_type') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.order.fields.order_to_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="ok_id">{{ trans('cruds.order.fields.ok') }}</label>
                <select class="form-control select2 {{ $errors->has('ok') ? 'is-invalid' : '' }}" name="ok_id" id="ok_id" required >
                    <option value="{{ $order->ok_id }}">{{ $order->ok->lokasi }}</option>
                </select>
                @if($errors->has('ok'))
                    <div class="invalid-feedback">
                        {{ $errors->first('ok') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.order.fields.ok_helper') }}</span>
            </div>
            
            <div class="form-group">
                <label for="keterangan">{{ trans('cruds.order.fields.keterangan') }}</label>
                <input class="form-control {{ $errors->has('keterangan') ? 'is-invalid' : '' }}" type="text" name="keterangan" id="keterangan" value="{{ old('keterangan', $order->keterangan) }}" disabled>
                @if($errors->has('keterangan'))
                    <div class="invalid-feedback">
                        {{ $errors->first('keterangan') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.order.fields.keterangan_helper') }}</span>
            </div>
            @foreach ($order->rms as $item)
            <div class="form-group row product">
                <div class="cloneable col rms">
                    <label for="bahan">{{ trans('cruds.rawMaterial.fields.name') }}</label>
                    <select class="form-control select2 {{ $errors->has('ok') ? 'is-invalid' : '' }}" name="rm_id[]" required>
                        <option value="{{ $item->id }}">{{ $item->name }} : {{$item->category->name}}</option>
                    </select>
                </div>
                <div class="cloneable col">
                    <label for="bahan">{{ trans('cruds.rawMaterial.fields.qty') }}</label>
                    <input class="form-control" type="number" min="0" step="1" name="qty[]" value="{{$item->pivot->qty}}" disabled>
                </div>
                <div class="cloneable col">
                    <label for="bahan">{{ trans('cruds.rawMaterial.fields.approved_qty') }}</label>
                    <input class="form-control" type="number" step="1" min="0" name="approved_qty[]" value="{{$item->pivot->approved_qty ?? $item->pivot->qty}}" >
                </div>
                <div class="cloneable col">
                    <label for="ket">{{ trans('cruds.rawMaterial.fields.ket') }}</label>
                    <input class="form-control {{ $errors->has('ket') ? 'is-invalid' : '' }}" type="text" name="ket[]" value="">
                </div>
            </div>
            @endforeach
            <hr>
            <div class="form-group" style="font-size: larger">
                Confirm<br><br>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="confirm" id="approve" value="approve">
                    <label class="form-check-label" for="approve">Approve</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="confirm" id="reject" value="reject">
                    <label class="form-check-label" for="reject">Reject</label>
                  </div>
                @if($errors->has('confirm'))
                    <div class="invalid-feedback">
                        {{ $errors->first('confirm') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.order.fields.confirm_helper') }}</span>
            </div>
            <hr><br>
            <div class="form-group">
                <button class="btn btn-info" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
            <div class="form-group">
                <a class="btn btn-primary" href="{{ route('admin.orders.index') }}">
                    {{ trans('global.back') }}
                </a>
            </div>
        </form>
    </div>
</div>



@endsection