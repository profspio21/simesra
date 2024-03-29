@extends('layouts.admin')
@section('content')
@can('order_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            @if($type == 'pengurangan')
            {{-- <a class="btn btn-success" href="{{ route('admin.orders.create', ['type' => $type]) }}">
                {{ trans('global.add') }} {{ trans('cruds.order.title_singular') }}
            </a> --}}
            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModal">
                {{ trans('global.add') }} {{ trans('cruds.order.title_singular') }}
            </button>
            @endif
            @if($type == 'penambahan')
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                {{ trans('global.add') }} {{ trans('cruds.order.title_singular') }}
            </button>
            @endif
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        <h2>
            {{ trans('global.list') }} {{ trans('cruds.order.title_singular') }} {{App\Models\Order::TYPE_SELECT[$type]}}
        </h2>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Order">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.order.fields.created_at') }}
                        </th>
                        @if($type == 'penambahan')
                        <th>
                            {{ trans('cruds.order.fields.order_to') }}
                        </th>
                        @endif
                        <th>
                            {{ trans('cruds.order.fields.keterangan') }}
                        </th>
                        <th>
                            {{ trans('cruds.order.fields.ok') }}
                        </th>
                        <th>
                            {{ trans('cruds.order.fields.rm') }}
                        </th>
                        <th>
                            {{ trans('cruds.order.fields.status') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $key => $order)
                        <tr data-entry-id="{{ $order->id }}">
                            <td>

                            </td>
                            <td>
                                @if(isset($order->created_at))
                                {{ date_format($order->created_at,"Y-m-d H:i") }}
                                @endif
                            </td>
                            @if($type == 'penambahan')
                            <td>
                                {{ App\Models\Order::ORDER_TO_SELECT[$order->order_to] ?? '' }}
                            </td>
                            @endif
                            <td>
                                {{ $order->keterangan }}
                            </td>
                            <td>
                                {{ $order->ok->lokasi ?? '' }}
                            </td>
                            <td>
                                @foreach($order->rms as $rm)
                                <span class="badge">{{ $rm->name ?? '' }} ({{ $rm->category->name ?? '' }}) : {{ $rm->pivot->qty }}</span><br>
                                @endforeach
                            </td>
                            <td>
                                {{ App\Models\Order::STATUS_SELECT[$order->status] ?? '' }}
                            </td>
                            <td>
                                @can('order_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.orders.show', $order->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can($order->status)
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.orders.edit', $order->id) }}">
                                        {{ trans('global.approve') }}
                                    </a>
                                @endcan
                                
                                @can('order_delete')
                                    <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        @if ($type == 'penambahan')
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"> Order Ke Mana ? </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body" style="font-size: larger">
            <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="order_to" id="ck" value="ck">
                    <label class="form-check-label" for="ck">Central Kitchen</label>
            </div>
            <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="order_to" id="inventory" value="inventory">
                    <label class="form-check-label" for="inventory">Inventory</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="order_to" id="purchasing" value="purchasing">
                <label class="form-check-label" for="purchasing">Purchasing</label>
            </div>  
                        
        </div>
        @endif
        
        @if($type == 'pengurangan')
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"> Pilih Outlet Kitchen </h5>
        </div>
        <div class="modal-body" style="font-size: larger">
            <div class="form-group">
                <select class="col-form-label select2" name="ok_id" id="ok_id">
                    @foreach ($oks as $id => $entry)
                        <option value="{{$entry->id}}">{{$entry->lokasi}}</option>
                    @endforeach
                </select>
              </div>      
        </div>
        @endif
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button id="next" type="button" class="btn btn-primary">Next</button>
        </div>
      </div>
    </div>
  </div>


@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('order_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.orders.massDestroy') }}",
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
  let table = $('.datatable-Order:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  @else
  let table = $('.datatable-Order:not(.ajaxTable)').DataTable({ buttons: [] })
  @endcan
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

  $('#next').on("click", function() {
      var checked = $('input[name="order_to"]:checked').val();
      var type = <?php echo json_encode($type) ?>;
      var selected = $('select[name="ok_id"]').find(':selected').val();
      console.log(selected)

      if(type == 'penambahan' && typeof checked !== 'undefined') {
          let url = "/admin/orders/create?type="+type+"&order_to="+checked
          console.log(url);
          window.location.href = url;
      }

      if(type == 'pengurangan' && typeof selected !== 'undefined') {
          let url = "/admin/orders/create?type="+type+"&ok_id="+selected
          console.log(url);
          window.location.href = url;
      }
  })
  
})

</script>
@endsection