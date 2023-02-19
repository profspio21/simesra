@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.outletKitchen.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.outlet-kitchens.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.outletKitchen.fields.id') }}
                        </th>
                        <td>
                            {{ $outletKitchen->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.outletKitchen.fields.lokasi') }}
                        </th>
                        <td>
                            {{ $outletKitchen->lokasi }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.outletKitchen.fields.user') }}
                        </th>
                        <td>
                            @foreach($outletKitchen->users as $key => $user)
                                <span class="label label-info">{{ $user->username }}</span>
                            @endforeach
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.outlet-kitchens.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection