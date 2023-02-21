@extends('layouts.admin')
@section('content')
@can('sale_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.sales.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.sale.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        <h2>
        {{ trans('global.list') }} {{ trans('cruds.sale.title_singular') }} 
        {{$ok->lokasi}}
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
                            {{ trans('cruds.sale.fields.user') }}
                        </th>
                        
                        <th>
                            Dibuat / Diupdate pada
                        </th>
                        
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sales as $key => $sale)
                        <tr data-entry-id="{{ $sale->id }}">
                            <td>

                            </td>
                            
                            <td>
                                {{ $sale->product->name ?? '' }}
                            </td>
                            <td>
                                {{ $sale->qty ?? '' }}
                            </td>
                            <td>
                                {{ $sale->user->username ?? '' }}
                            </td>                            
                            <td>
                                {{ $sale->updated_at ?? '' }}
                            </td>
                            
                            <td>
                                {{-- @can('sale_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.sales.show', $sale->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan --}}

                                @can('sale_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.sales.edit', $sale->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('sale_delete')
                                    <form action="{{ route('admin.sales.destroy', $sale->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                                @endcan

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
  @can('import')
  let table = $('.datatable-Sale:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  @endcan
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection