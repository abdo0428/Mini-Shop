@extends('layouts.main')

@section('content')
<h3 class="mb-3">{{ __('lang.my_orders') }}</h3>

<div class="card shadow-sm">
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-striped align-middle">
        <thead>
          <tr>
            <th>#</th>
            <th>{{ __('lang.status') }}</th>
            <th>{{ __('lang.items') }}</th>
            <th>{{ __('lang.total') }}</th>
            <th>{{ __('lang.date') }}</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
        @foreach($orders as $o)
          <tr>
            <td>{{ $o->id }}</td>
            <td><span class="badge bg-success">{{ $o->status }}</span></td>
            <td>{{ $o->items_count }}</td>
            <td>${{ number_format($o->total,2) }}</td>
            <td>{{ $o->created_at->format('Y-m-d H:i') }}</td>
            <td class="text-end">
              <a class="btn btn-sm btn-dark" href="{{ route('orders.show',$o) }}">{{ __('lang.view') }}</a>
            </td>
          </tr>
        @endforeach
        </tbody>
      </table>
    </div>

    <div class="mt-3">
      {{ $orders->links() }}
    </div>
  </div>
</div>
@endsection
