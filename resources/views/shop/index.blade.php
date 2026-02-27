@extends('layouts.main')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h3 class="mb-0">{{ __('lang.products') }}</h3>
  <a href="{{ route('cart.show') }}" class="btn btn-dark">{{ __('lang.go_to_cart') }}</a>
</div>

<div class="row g-3">
  @foreach($products as $p)
    <div class="col-md-4">
      <div class="card shadow-sm h-100 product-card">
        @if($p->image_url)
          <img src="{{ $p->image_url }}" class="card-img-top product-img" alt="{{ $p->name }}">
        @else
          <div class="card-img-top product-img placeholder-img">{{ __('lang.no_image') }}</div>
        @endif
        <div class="card-body d-flex flex-column">
          <h5 class="card-title">{{ $p->name }}</h5>
          <p class="text-muted small">{{ $p->description }}</p>
          <div class="d-flex justify-content-between">
            <div class="fw-bold">${{ number_format($p->price, 2) }}</div>
          </div>

          <div class="mt-3 d-flex gap-2">
            <input type="number" class="form-control form-control-sm qty" min="1" value="1">
            <button class="btn btn-primary btn-sm addToCart"
                    data-id="{{ $p->id }}"
                    {{ $p->stock <= 0 ? 'disabled' : '' }}>
              {{ __('lang.add') }}
            </button>
            <a class="btn btn-outline-dark btn-sm" href="{{ route('products.show', $p) }}">{{ __('lang.view') }}</a>
          </div>
        </div>
      </div>
    </div>
  @endforeach
</div>

<div class="mt-4">
  {{ $products->links() }}
</div>
@endsection

@push('styles')
<style>
  .product-card .product-img {
    height: 200px;
    object-fit: cover;
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
  $(document).on('click', '.addToCart', function(){
    const btn = $(this);
    const card = btn.closest('.card-body');
    const qty = parseInt(card.find('.qty').val() || 1);
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
