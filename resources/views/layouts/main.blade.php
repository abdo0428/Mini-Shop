<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name') }}</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css" rel="stylesheet">

  <style>
    :root {
      --brand-dark: #111111;
      --brand-accent: #f4b942;
    }
    body {
      font-family: "Sora", system-ui, -apple-system, "Segoe UI", sans-serif;
    }
    .navbar .nav-link {
      font-weight: 500;
    }
    .mini-cart {
      width: 320px;
    }
    .mini-cart-item {
      display: flex;
      gap: 0.75rem;
      align-items: center;
      padding: 0.5rem 0;
    }
    .mini-cart-thumb {
      width: 44px;
      height: 44px;
      border-radius: 10px;
      overflow: hidden;
      background: #f2f2f2;
      display: grid;
      place-items: center;
    }
    .mini-cart-thumb img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
  .mini-cart-placeholder {
    font-size: 0.75rem;
    color: #666;
  }
  .auth-wrap {
    min-height: calc(100vh - 120px);
    display: flex;
    align-items: center;
  }
  .auth-card {
    border-radius: 20px;
    border: 1px solid rgba(0,0,0,0.06);
  }
  .auth-aside {
    border-radius: 20px;
    background: linear-gradient(135deg, #111111 0%, #232323 45%, #3a3a3a 100%);
    color: #fff;
    min-height: 100%;
  }
  .auth-badge {
    display: inline-block;
    padding: 0.35rem 0.65rem;
    background: rgba(255,255,255,0.12);
    border-radius: 999px;
    font-size: 0.8rem;
    letter-spacing: 0.03em;
  }
  .page-hero {
    border-radius: 18px;
    background: linear-gradient(120deg, #f1f5ff 0%, #fcefe6 45%, #edf7f3 100%);
    border: 1px solid rgba(0,0,0,0.05);
  }
</style>

  @stack('styles')
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-bold" href="{{ route('landing') }}">Mini Shop</a>

    <div class="d-none d-lg-flex align-items-center gap-3">
      <a class="nav-link text-white-50" href="{{ route('shop.index') }}">{{ __('lang.shop') }}</a>
      @auth
        @if(auth()->user()->is_admin)
          <a class="nav-link text-white-50" href="{{ route('admin.orders.index') }}">{{ __('lang.admin_panel') }}</a>
        @else
          <a class="nav-link text-white-50" href="{{ route('orders.index') }}">{{ __('lang.my_orders') }}</a>
        @endif
        <a class="nav-link text-white-50" href="{{ route('profile.edit') }}">{{ __('lang.profile') }}</a>
      @endauth
    </div>

    <div class="d-flex align-items-center gap-3">
      <div class="dropdown">
        <button class="btn btn-outline-light btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
          {{ strtoupper(app()->getLocale()) }}
        </button>
        <ul class="dropdown-menu dropdown-menu-end">
          <li><a class="dropdown-item" href="{{ route('lang.switch', 'en') }}">{{ __('lang.lang_en') }}</a></li>
          <li><a class="dropdown-item" href="{{ route('lang.switch', 'ar') }}">{{ __('lang.lang_ar') }}</a></li>
          <li><a class="dropdown-item" href="{{ route('lang.switch', 'tr') }}">{{ __('lang.lang_tr') }}</a></li>
        </ul>
      </div>

      @auth
        @if(auth()->user()->is_admin)
          <div class="dropdown">
            <button class="btn btn-outline-light btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
              {{ __('lang.admin_panel') }}
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item" href="{{ route('admin.products.index') }}">{{ __('lang.admin_products') }}</a></li>
              <li><a class="dropdown-item" href="{{ route('admin.orders.index') }}">{{ __('lang.admin_orders') }}</a></li>
            </ul>
          </div>
        @endif
      @endauth

      <div class="dropdown">
        <button class="btn btn-outline-light btn-sm position-relative" data-bs-toggle="dropdown" aria-expanded="false">
          {{ __('lang.cart') }} <span id="cartCount" class="badge bg-warning text-dark">0</span>
        </button>
        <div class="dropdown-menu dropdown-menu-end p-3 mini-cart">
          <div id="miniCartItems" class="mini-cart-items">
            <div class="text-muted small">{{ __('lang.loading') }}</div>
          </div>
          <div class="d-flex justify-content-between align-items-center mt-2 pt-2 border-top">
            <span class="text-muted">{{ __('lang.subtotal') }}</span>
            <strong id="miniCartSubtotal">$0.00</strong>
          </div>
          <div class="d-grid gap-2 mt-3">
            <a class="btn btn-dark btn-sm" href="{{ route('cart.show') }}">{{ __('lang.cart') }}</a>
            <a class="btn btn-success btn-sm" href="{{ route('checkout.confirm') }}">{{ __('lang.checkout') }}</a>
          </div>
        </div>
      </div>

      @auth
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button class="btn btn-danger btn-sm">{{ __('lang.logout') }}</button>
        </form>
      @else
        <a class="btn btn-success btn-sm" href="{{ route('login') }}">{{ __('lang.login') }}</a>
        <a class="btn btn-primary btn-sm" href="{{ route('register') }}">{{ __('lang.register') }}</a>
      @endauth
    </div>
  </div>
</nav>

<main class="container py-4">
  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif
  @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
  @endif

  @yield('content')
</main>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>

<script>
  $.ajaxSetup({
    headers: {'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content}
  });

  function renderMiniCart(items){
    if(!items || items.length === 0){
      return '<div class="text-muted small">{{ __('lang.cart_empty') }}</div>';
    }
    return items.map(function(row){
      const img = row.image_url
        ? `<img src="${row.image_url}" alt="${row.name}">`
        : `<div class="mini-cart-placeholder">No Image</div>`;
      return `
        <div class="mini-cart-item border-bottom">
          <div class="mini-cart-thumb">${img}</div>
          <div class="flex-grow-1">
            <div class="fw-semibold small">${row.name}</div>
            <div class="text-muted small">${row.qty} x $${row.unit_price.toFixed(2)}</div>
          </div>
          <div class="fw-semibold small">$${row.line_total.toFixed(2)}</div>
        </div>
      `;
    }).join('');
  }

  function refreshCartMini(){
    $.get("{{ route('cart.mini') }}", function(res){
      $("#cartCount").text(res.count);
      $("#miniCartSubtotal").text('$' + res.subtotal);
      $("#miniCartItems").html(renderMiniCart(res.items));
    });
  }
  window.refreshCartMini = refreshCartMini;
  refreshCartMini();
</script>

@stack('scripts')
</body>
</html>
