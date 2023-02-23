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
            <div class="form-group">
                <label class="required">{{ trans('cruds.order.fields.order_to') }}</label>
                <select class="form-control {{ $errors->has('order_to') ? 'is-invalid' : '' }}" name="order_to" id="order_to" >
                    <option value disabled {{ old('order_to', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Order::ORDER_TO_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('order_to', $order->order_to) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('order_to'))
                    <div class="invalid-feedback">
                        {{ $errors->first('order_to') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.order.fields.order_to_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="ok_id">{{ trans('cruds.order.fields.ok') }}</label>
                <select class="form-control select2 {{ $errors->has('ok') ? 'is-invalid' : '' }}" name="ok_id" id="ok_id" required >
                    @foreach($oks as $id => $entry)
                        <option value="{{ $id }}" {{ (old('ok_id') ? old('ok_id') : $order->ok->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
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
                <input class="form-control {{ $errors->has('keterangan') ? 'is-invalid' : '' }}" type="text" name="keterangan" id="keterangan" value="{{ old('keterangan', $order->keterangan) }}">
                @if($errors->has('keterangan'))
                    <div class="invalid-feedback">
                        {{ $errors->first('keterangan') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.order.fields.keterangan_helper') }}</span>
            </div>
            {{-- <div class="form-group">
                <label class="required">{{ trans('cruds.order.fields.status') }}</label>
                <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" id="status" required>
                    <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Order::STATUS_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('status', $order->status) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('status'))
                    <div class="invalid-feedback">
                        {{ $errors->first('status') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.order.fields.status_helper') }}</span>
            </div> --}}
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection