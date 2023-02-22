@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.order.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.orders.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required">{{ trans('cruds.order.fields.type') }}</label>
                <select class="form-control select2 {{ $errors->has('type') ? 'is-invalid' : '' }}" name="type" id="type" required>
                        <option value="{{ $type }}">{{ App\Models\Order::TYPE_SELECT[$type] }}</option>
                </select>
                @if($errors->has('type'))
                    <div class="invalid-feedback">
                        {{ $errors->first('type') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.order.fields.type_helper') }}</span>
            </div>
            @if($type == 'penambahan')
            <div class="form-group">
                <label class="required">{{ trans('cruds.order.fields.order_to') }}</label>
                <select class="form-control select2 {{ $errors->has('order_to') ? 'is-invalid' : '' }}" name="order_to" id="order_to" required>
                        <option value="{{ $order_to }}" >{{ App\Models\Order::ORDER_TO_SELECT[$order_to] }}</option>
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
                <label class="required" for="ok_id">{{ trans('cruds.order.fields.ok') }}</label>
                <select class="form-control select2 {{ $errors->has('ok') ? 'is-invalid' : '' }}" name="ok_id" id="ok_id" required>
                    <option value disabled {{ old('type', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach($oks as $id => $entry)
                        <option value="{{ $id }}" {{ old('ok_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
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
                <input class="form-control {{ $errors->has('keterangan') ? 'is-invalid' : '' }}" type="text" name="keterangan" id="keterangan" value="{{ old('keterangan', '') }}">
                @if($errors->has('keterangan'))
                    <div class="invalid-feedback">
                        {{ $errors->first('keterangan') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.order.fields.keterangan_helper') }}</span>
            </div>
            <div class="form-group row product">
                <div class="cloneable col rms">
                    <label for="bahan">{{ trans('cruds.rawMaterial.fields.name') }}</label>
                    <select class="form-control select2 {{ $errors->has('ok') ? 'is-invalid' : '' }}" name="rm_id[]" required>
                        @foreach($rms as $rm)
                            <option value="{{ $rm->id }}" {{ old('rm_id') == $rm->id ? 'selected' : '' }}>{{ $rm->name }} : {{$rm->category->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="cloneable col">
                    <label for="bahan">{{ trans('cruds.rawMaterial.fields.qty') }}</label>
                    <input class="form-control" type="number" step="1" name="qty[]" value="{{ old('qty', '') }}">
                </div>
                <div class="cloneable col" style="align-self: self-end;">
                    <button class="btnaction btn btn-primary add" name="add" type="button">
                        <i class="fa fa-plus" aria-hidden="true"></i></button>                       
                    <button class="btnaction btn btn-secondary remove" name="remove"  type="button">
                        <i class="fa fa-minus" aria-hidden="true"></i></button>
                </div>
            </div>
            <div class="form-group save">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            const rms = <?php echo $rms ?>;
            $('.card-body').on("click",' .add', function() {
                var html = $('<div class="form-group row product">'+
'<div class="cloneable col rms">'+
'<label for="bahan">Bahan</label>'+
'<select class="form-control select2" name="rm_id[]" id="rm_id[]" required></select></div>'+
'<div class="cloneable col"><label for="bahan">Qty</label>'+
'<input class="form-control" type="number" step="1" name="qty[]" value=""></div>'+
'<div class="cloneable col" style="align-self: self-end;">'+
'<button class="btnaction btn btn-primary add" name="add" type="button">'+
'<i class="fa fa-plus" aria-hidden="true"></i></button>'+
'<button class="btnaction btn btn-secondary remove" name="remove"  type="button">'+
'<i class="fa fa-minus" aria-hidden="true"></i></button></div></div>');
                var cloned = html.clone(true)
                var parents = cloned.children('.rms').children('select[name="rm_id[]"]');
                $.each(rms, function(index,value) {
                    parents.append('<option value ="'+value.id+'">'+value.name+' : '+value.category.name+'</option>');
                });
                console.log(parents);
                parents.select2();
                cloned.insertBefore(".save")
            })
            $('.card-body').on("click",' .remove', function() {
                $(this).parent().parent().remove();
            })
        })
    </script>
@endsection