@extends('layouts.admin')
@section('content')
@can('sale_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.sales.create', ['ok_id' => $ok_id]) }}">
                {{ trans('global.add') }} {{ trans('cruds.sale.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        <h2>
            {{ trans('global.list') }} {{ trans('cruds.sale.title_singular') }} {{$ok->lokasi}}
        </h2>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Sale">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        
                        <th>
                            {{ trans('cruds.sale.fields.product') }}
                        </th>
                        <th>
                            {{ trans('cruds.sale.fields.qty') }}
                        </th>
                        
                        
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $key => $product)
                    @if($product->sales->where('ok_id', $ok_id)->sum('qty') > 0)
                        <tr data-entry-id="{{ $product->id }}">
                            <td>

                            </td>
                            
                            <td>
                                {{ $product->name ?? '' }}
                            </td>
                            <td>
                                {{ $product->sales->where('ok_id', $ok_id)->sum('qty') ?? '' }}
                            </td>
                            
                            <td>
                                @can('sale_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.sales.index', ['product_id' => $product->id, 'ok_id' => $ok_id]) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                            </td>

                        </tr>
                        @endif
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
@can('sale_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.sales.massDestroy') }}",
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
  @can('export')
  let table = $('.datatable-Sale:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  @else
  let table = $('.datatable-Sale:not(.ajaxTable)').DataTable({ buttons: [] })
  @endcan
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection