@extends('layouts.main')

@section('content')
<h3 class="mb-3">{{ __('lang.checkout_title') }}</h3>

<div class="row g-3">
  <div class="col-lg-8">
    <div class="card shadow-sm">
      <div class="card-body">
        <h5 class="mb-3">{{ __('lang.items') }}</h5>
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th>{{ __('lang.product') }}</th><th>{{ __('lang.unit') }}</th><th>{{ __('lang.qty') }}</th><th>{{ __('lang.total') }}</th>
              </tr>
            </thead>
            <tbody>
            @foreach($cart as $row)
              <tr>
                <td>{{ $row['name'] }}</td>
                <td>${{ number_format($row['unit_price'],2) }}</td>
                <td>{{ $row['qty'] }}</td>
                <td>${{ number_format($row['unit_price']*$row['qty'],2) }}</td>
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-4">
    <div class="card shadow-sm">
      <div class="card-body">
        <h5>{{ __('lang.summary') }}</h5>
        <div class="d-flex justify-content-between mt-2">
          <span>{{ __('lang.subtotal') }}</span>
          <span class="fw-bold">${{ number_format($subtotal,2) }}</span>
        </div>
        <hr>
        <form method="POST" action="{{ route('checkout.place') }}">
          @csrf
          <button class="btn btn-success w-100">{{ __('lang.place_order') }}</button>
        </form>
        <a class="btn btn-outline-dark w-100 mt-2" href="{{ route('cart.show') }}">{{ __('lang.back_to_cart') }}</a>
      </div>
    </div>
  </div>
</div>
@endsection
