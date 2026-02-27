@extends('layouts.main')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h3 class="mb-0">{{ __('lang.order') }} #{{ $order->id }}</h3>
  <a class="btn btn-outline-dark" href="{{ route('admin.orders.index') }}">{{ __('lang.back') }}</a>
</div>

<div class="card shadow-sm mb-3">
  <div class="card-body">
    <div class="row g-2">
      <div class="col-md-4"><span class="text-muted">{{ __('lang.user') }}:</span> <strong>{{ $order->user?->name }}</strong></div>
      <div class="col-md-4"><span class="text-muted">{{ __('lang.status') }}:</span> <span class="badge bg-success">{{ __('lang.status_' . $order->status) }}</span></div>
      <div class="col-md-4"><span class="text-muted">{{ __('lang.total') }}:</span> <strong>${{ number_format($order->total,2) }}</strong></div>
    </div>
  </div>
</div>

<div class="card shadow-sm">
  <div class="card-body">
    <div class="table-responsive">
      <table class="table">
        <thead><tr><th>{{ __('lang.product') }}</th><th>{{ __('lang.unit') }}</th><th>{{ __('lang.qty') }}</th><th>{{ __('lang.total') }}</th></tr></thead>
        <tbody>
        @foreach($order->items as $it)
          <tr>
            <td>{{ $it->product?->name }}</td>
            <td>${{ number_format($it->unit_price,2) }}</td>
            <td>{{ $it->qty }}</td>
            <td>${{ number_format($it->line_total,2) }}</td>
          </tr>
        @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
