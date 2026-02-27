@extends('layouts.main')

@section('content')
<div class="mb-3">
  <a href="{{ route('shop.index') }}" class="link-dark">&larr; {{ __('lang.back_to_shop') }}</a>
</div>

<div class="row g-4">
  <div class="col-lg-6">
    <div class="card shadow-sm">
      @if($product->image_url)
        <img src="{{ $product->image_url }}" class="product-hero-img" alt="{{ $product->name }}">
      @else
        <div class="product-hero-img placeholder-img">{{ __('lang.no_image') }}</div>
      @endif
    </div>
  </div>
  <div class="col-lg-6">
    <h2 class="fw-bold">{{ $product->name }}</h2>
    <div class="fs-4 fw-semibold mb-2">${{ number_format($product->price,2) }}</div>
    <div class="text-muted mb-3">
      {{ __('lang.availability') }}:
      @if($product->stock > 0)
        <span class="text-success">{{ __('lang.in_stock') }}</span>
      @else
        <span class="text-danger">{{ __('lang.out_of_stock') }}</span>
      @endif
    </div>
    <p class="text-muted">{{ $product->description }}</p>

    <div class="d-flex gap-2 mt-4">
      <input type="number" id="qtyInput" class="form-control" min="1" value="1" style="max-width:120px">
      <button id="addToCartBtn" class="btn btn-dark"
              data-id="{{ $product->id }}"
              {{ $product->stock <= 0 ? 'disabled' : '' }}>
        {{ __('lang.add_to_cart') }}
      </button>
    </div>
    @if($product->stock <= 0)
      <div class="text-danger mt-2">{{ __('lang.out_of_stock_message') }}</div>
    @endif
  </div>
</div>
@endsection

@push('styles')
<style>
  .product-hero-img {
    width: 100%;
    height: 420px;
    object-fit: cover;
    border-radius: 12px;
  }
  .placeholder-img {
    display: grid;
    place-items: center;
    background: linear-gradient(135deg, #f2f2f2, #e6e6e6);
    color: #666;
    font-weight: 600;
  }
</style>
@endpush

@push('scripts')
<script>
  $('#addToCartBtn').on('click', function(){
    const btn = $(this);
    const qty = parseInt($('#qtyInput').val() || 1);
    btn.prop('disabled', true);

    $.post("{{ route('cart.add') }}", {product_id: btn.data('id'), qty: qty})
      .done(function(res){
        Swal.fire({icon:'success', title: res.message, timer: 900, showConfirmButton:false});
        if (window.refreshCartMini) refreshCartMini();
      })
      .fail(function(xhr){
        Swal.fire({icon:'error', title:'Error', text: xhr.responseJSON?.message || 'Failed'});
      })
      .always(function(){
        btn.prop('disabled', false);
      });
  });
</script>
@endpush
