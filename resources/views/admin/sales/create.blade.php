@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        <h2>
            {{ trans('global.add') }} {{ trans('cruds.sale.title_singular') }} {{$ok->lokasi}}
        </h2>
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.sales.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="ok_id">{{ trans('cruds.sale.fields.ok') }}</label>
                <select class="form-control select2 {{ $errors->has('ok') ? 'is-invalid' : '' }}" name="ok_id" id="ok_id">
                    @foreach($oks as $id => $entry)
                        <option value="{{ $id }}" {{ old('ok_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('ok'))
                    <div class="invalid-feedback">
                        {{ $errors->first('ok') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.sale.fields.product_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="product_id">{{ trans('cruds.sale.fields.product') }}</label>
                <select class="form-control select2 {{ $errors->has('product') ? 'is-invalid' : '' }}" name="product_id" id="product_id">
                    @foreach($products as $id => $entry)
                        <option value="{{ $id }}" {{ old('product_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('product'))
                    <div class="invalid-feedback">
                        {{ $errors->first('product') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.sale.fields.product_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="qty">{{ trans('cruds.sale.fields.qty') }}</label>
                <input class="form-control {{ $errors->has('qty') ? 'is-invalid' : '' }}" type="number" name="qty" id="qty" value="{{ old('qty', '') }}" step="1" min="0" required>
                @if($errors->has('qty'))
                    <div class="invalid-feedback">
                        {{ $errors->first('qty') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.sale.fields.qty_helper') }}</span>
            </div>
            
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection