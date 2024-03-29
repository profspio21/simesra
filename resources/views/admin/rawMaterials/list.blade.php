@extends('layouts.admin')
@section('content')
@can('raw_material_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.stock.create', ['ok_id' => $ok_id]) }}">
                {{ trans('global.add') }} Stock
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        <h2>
        {{ trans('cruds.stock.title') }} {{$ok->lokasi}}
        </h2>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-RawMaterial">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        
                        <th>
                            {{ trans('cruds.rawMaterial.fields.name') }}
                        </th>
                        <th>
                            {{ trans('cruds.rawMaterial.fields.category') }}
                        </th>
                        <th>
                            {{ trans('cruds.rawMaterial.fields.qty') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rawMaterials as $key => $rawMaterial)
                        <tr data-entry-id="{{ $rawMaterial->id }}">
                            <td>

                            </td>
                            
                            <td>
                                {{ $rawMaterial->rm->name ?? '' }}
                            </td>
                            <td>
                                {{ $rawMaterial->rm->category->name ?? '' }}
                            </td>
                            <td>
                                {{ $rawMaterial->qty ?? '' }}
                            </td>
                            <td>
                                @if($rawMaterial->rm->category->name == 'Others')
                                @can('stock_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.stocks.edit', ['id' => $rawMaterial->id]) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan
                                @endif

                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>



@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('raw_material_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.okrms.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  @can('import')
  let table = $('.datatable-RawMaterial:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  @endcan
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection