@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} Stock Others
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.stock.update", [$okrm->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="rm_id"> {{ trans('cruds.rawMaterial.fields.name') }} </label>
                <select class="form-control select2 {{ $errors->has('rm_id') ? 'is-invalid' : '' }}" name="rm_id" id="rm_id">
                        <option value="{{  $okrm->rm_id }}">{{ $okrm->rm->name }}</option>
                </select>
                
                @if($errors->has('rm_id'))
                    <div class="invalid-feedback">
                        {{ $errors->first('rm_id') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.rawMaterial.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="ok_id">{{ trans('cruds.rawMaterial.fields.ok') }}</label>
                <select class="form-control select2 {{ $errors->has('ok_id') ? 'is-invalid' : '' }}" name="ok_id" id="ok_id">
                        <option value="{{  $okrm->ok_id }}">{{ $okrm->ok->lokasi }}</option>
                </select>
                
                @if($errors->has('ok_id'))
                    <div class="invalid-feedback">
                        {{ $errors->first('ok_id') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.rawMaterial.fields.ok_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="qty">{{ trans('cruds.rawMaterial.fields.qty') }}</label>
                <input class="form-control {{ $errors->has('qty') ? 'is-invalid' : '' }}" type="number" name="qty" min="0" id="qty" value="{{ old('qty', $okrm->qty) }}" required>
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