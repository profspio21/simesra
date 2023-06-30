@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        <h2>{{ trans('global.add') }} {{ trans('cruds.stock.title') }} {{ $oks->first()->lokasi}}
        </h2>
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.stock.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="ok_id">{{ trans('cruds.rawMaterial.fields.ok') }}</label>
                <select class="form-control select2 {{ $errors->has('ok') ? 'is-invalid' : '' }}" name="ok_id" id="ok_id">
                    @foreach($oks as $id => $entry)
                        <option value="{{ $entry->id }}" {{ old('ok_id') == $id ? 'selected' : '' }}>{{ $entry->lokasi }}</option>
                    @endforeach
                </select>
                @if($errors->has('ok'))
                    <div class="invalid-feedback">
                        {{ $errors->first('ok') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.rawMaterial.fields.category_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="rm_id">{{ trans('cruds.rawMaterial.fields.rm') }}</label>
                <select class="form-control select2 {{ $errors->has('rm') ? 'is-invalid' : '' }}" name="rm_id" id="rm_id">
                    @foreach($rawMaterials as $id => $entry)
                        <option value="{{ $entry->id }}" {{ old('rm_id') == $id ? 'selected' : '' }}>{{ $entry->name }} - {{$entry->category->name}}</option>
                    @endforeach
                </select>
                @if($errors->has('rm'))
                    <div class="invalid-feedback">
                        {{ $errors->first('rm') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.rawMaterial.fields.category_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="qty">{{ trans('cruds.rawMaterial.fields.qty') }}</label>
                <input class="form-control {{ $errors->has('qty') ? 'is-invalid' : '' }}" type="number" min="0" name="qty" id="qty" value="{{ old('qty', '') }}">
                @if($errors->has('qty'))
                    <div class="invalid-feedback">
                        {{ $errors->first('qty') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.rawMaterial.fields.qty_helper') }}</span>
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