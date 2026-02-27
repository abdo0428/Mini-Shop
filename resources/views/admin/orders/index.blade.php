@extends('layouts.main')

@section('content')
<h3 class="mb-3">{{ __('lang.admin_orders_title') }}</h3>

<div class="card shadow-sm">
  <div class="card-body">
    <table id="ordersTable" class="table table-striped w-100">
      <thead>
        <tr>
          <th>{{ __('lang.id') }}</th>
          <th>{{ __('lang.user') }}</th>
          <th>{{ __('lang.status') }}</th>
          <th>{{ __('lang.items') }}</th>
          <th>{{ __('lang.total') }}</th>
          <th>{{ __('lang.date') }}</th>
          <th></th>
        </tr>
      </thead>
    </table>
  </div>
</div>
@endsection

@push('scripts')
<script>
  $(function(){
    const statusMap = @json([
      'pending' => __('lang.status_pending'),
      'completed' => __('lang.status_completed'),
      'cancelled' => __('lang.status_cancelled'),
    ]);

    $('#ordersTable').DataTable({
      ajax: "{{ route('admin.orders.datatable') }}",
      columns: [
        {data:'id'},
        {data:'user'},
        {data:'status', render:(v)=> `<span class="badge bg-success">${statusMap[v] || v}</span>`},
        {data:'items_count'},
        {data:'total', render:(v)=> '$' + parseFloat(v).toFixed(2)},
        {data:'created_at'},
        {data:null, orderable:false, render:(row)=> `
          <div class="text-end">
            <a class="btn btn-sm btn-dark" href="{{ url('admin/orders') }}/${row.id}">{{ __('lang.view') }}</a>
          </div>
        `}
      ]
    });
  });
</script>
@endpush
