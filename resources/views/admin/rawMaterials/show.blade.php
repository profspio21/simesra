@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.rawMaterial.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.raw-materials.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.rawMaterial.fields.id') }}
                        </th>
                        <td>
                            {{ $rawMaterial->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.rawMaterial.fields.name') }}
                        </th>
                        <td>
                            {{ $rawMaterial->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.rawMaterial.fields.category') }}
                        </th>
                        <td>
                            {{ $rawMaterial->category->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.rawMaterial.fields.ok') }}
                        </th>
                        <td>
                            {{ $rawMaterial->ok->lokasi ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.raw-materials.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection