@extends('layouts.main')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h3 class="mb-0">{{ __('lang.cart_title') }}</h3>
  <a href="{{ route('shop.index') }}" class="btn btn-outline-dark">{{ __('lang.continue_shopping') }}</a>
</div>

@if(count($cart) === 0)
  <div class="alert alert-info">{{ __('lang.cart_empty') }}</div>
@else
  <div class="card shadow-sm">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table align-middle">
          <thead>
          <tr>
            <th>{{ __('lang.product') }}</th>
            <th style="width:140px">{{ __('lang.unit') }}</th>
            <th style="width:160px">{{ __('lang.qty') }}</th>
            <th style="width:140px">{{ __('lang.total') }}</th>
            <th style="width:120px"></th>
          </tr>
          </thead>
          <tbody>
          @foreach($cart as $row)
            <tr data-id="{{ $row['product_id'] }}">
              <td class="fw-semibold">{{ $row['name'] }}</td>
              <td>${{ number_format($row['unit_price'],2) }}</td>
              <td>
                <input class="form-control form-control-sm qtyInput" type="number" min="0" value="{{ $row['qty'] }}">
              </td>
              <td class="lineTotal">
                ${{ number_format($row['unit_price'] * $row['qty'],2) }}
              </td>
              <td class="text-end">
                <button class="btn btn-outline-danger btn-sm removeItem">{{ __('lang.remove') }}</button>
              </td>
            </tr>
          @endforeach
          </tbody>
        </table>
      </div>

      <div class="d-flex justify-content-between align-items-center mt-3">
        <button class="btn btn-danger" id="clearCart">{{ __('lang.clear_cart') }}</button>

        <div class="text-end">
          <div class="fs-5">{{ __('lang.subtotal') }}: <span id="subtotal">${{ number_format($subtotal,2) }}</span></div>
          <a href="{{ route('checkout.confirm') }}" class="btn btn-success mt-2">{{ __('lang.checkout') }}</a>
        </div>
      </div>
    </div>
  </div>
@endif
@endsection

@push('scripts')
<script>
  function updateRowTotal(tr){
    const unit = parseFloat(tr.find('td:nth-child(2)').text().replace('$',''));
    const qty = parseInt(tr.find('.qtyInput').val() || 0);
    tr.find('.lineTotal').text('$' + (unit * qty).toFixed(2));
  }

  function refreshTotals(res){
    $("#cartCount").text(res.count);
    $("#subtotal").text('$' + res.subtotal);
    if (window.refreshCartMini) refreshCartMini();
  }

  $(document).on('change', '.qtyInput', function(){
    const tr = $(this).closest('tr');
    const id = tr.data('id');
    const qty = parseInt($(this).val() || 0);

    $.post("{{ route('cart.update') }}", {product_id: id, qty: qty})
      .done(function(res){
        if(qty <= 0) tr.remove();
        else updateRowTotal(tr);
        refreshTotals(res);

        if($('tbody tr').length === 0){
          location.reload();
        }
      })
      .fail(function(){
        Swal.fire({icon:'error', title:'Error', text:'{{ __('lang.update_failed') }}'});
      });
  });

  $(document).on('click', '.removeItem', function(){
    const tr = $(this).closest('tr');
    const id = tr.data('id');

    Swal.fire({
      icon:'warning',
      title:'{{ __('lang.remove_item_confirm') }}',
      showCancelButton:true,
      confirmButtonText:'{{ __('lang.yes_remove') }}'
    }).then((r)=>{
      if(!r.isConfirmed) return;

      $.post("{{ route('cart.remove') }}", {product_id: id})
        .done(function(res){
          tr.remove();
          refreshTotals(res);
          if($('tbody tr').length === 0) location.reload();
        });
    });
  });

  $('#clearCart').on('click', function(){
    Swal.fire({
      icon:'warning',
      title:'{{ __('lang.clear_cart_confirm') }}',
      showCancelButton:true,
      confirmButtonText:'{{ __('lang.yes') }}'
    }).then((r)=>{
      if(!r.isConfirmed) return;

      $.post("{{ route('cart.clear') }}")
        .done(()=> location.reload());
    });
  });
</script>
@endpush
