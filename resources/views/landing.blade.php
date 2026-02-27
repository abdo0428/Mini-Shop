@extends('layouts.main')

@section('content')
<section class="hero-wrap rounded-4 p-4 p-lg-5 mb-5">
  <div class="row align-items-center g-4">
    <div class="col-lg-7">
      <span class="hero-pill">{{ __('lang.hero_badge') }}</span>
      <h1 class="display-5 fw-bold mt-3">{{ __('lang.hero_title') }}</h1>
      <p class="lead text-muted mt-3 mb-4">
        {{ __('lang.hero_desc') }}
      </p>
      <div class="d-flex flex-wrap gap-2">
        <a href="{{ route('shop.index') }}" class="btn btn-dark btn-lg">{{ __('lang.start_shopping') }}</a>
        <a href="#latest" class="btn btn-outline-dark btn-lg">{{ __('lang.see_whats_new') }}</a>
      </div>
    </div>
    <div class="col-lg-5">
      <div class="hero-card shadow-sm">
        <div class="hero-card-inner">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <div class="text-uppercase text-muted small">{{ __('lang.trending') }}</div>
              <div class="h4 mb-1">{{ __('lang.top_sellers_title') }}</div>
              <div class="text-muted small">{{ __('lang.updated_weekly') }}</div>
            </div>
            <span class="badge bg-dark">{{ __('lang.hot') }}</span>
          </div>
          <div class="mt-3">
            @foreach($topSellers as $p)
              <div class="d-flex align-items-center gap-3 py-2 border-bottom">
                <div class="mini-thumb">
                  @if($p->image_url)
                    <img src="{{ $p->image_url }}" alt="{{ $p->name }}">
                  @else
                    <div class="thumb-placeholder">MS</div>
                  @endif
                </div>
                <div class="flex-grow-1">
                  <div class="fw-semibold">{{ $p->name }}</div>
                    <div class="text-muted small">${{ number_format($p->price,2) }}</div>
                  </div>
                <a href="{{ route('products.show', $p) }}" class="btn btn-sm btn-outline-dark">{{ __('lang.view') }}</a>
              </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section id="top-sellers" class="mb-5">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="section-title mb-0">{{ __('lang.top_sellers_title') }}</h2>
    <a href="{{ route('shop.index') }}" class="link-dark">{{ __('lang.view_all') }}</a>
  </div>
  <div class="row g-3">
    @foreach($topSellers as $p)
      <div class="col-md-6 col-lg-3">
        <div class="card product-card h-100 shadow-sm">
          @if($p->image_url)
            <img src="{{ $p->image_url }}" class="card-img-top product-img" alt="{{ $p->name }}">
          @else
            <div class="card-img-top product-img placeholder-img">{{ __('lang.no_image') }}</div>
          @endif
          <div class="card-body d-flex flex-column">
            <h6 class="fw-semibold">{{ $p->name }}</h6>
            <div class="text-muted small mb-2">{{ $p->description }}</div>
            <div class="mt-auto d-flex justify-content-between align-items-center">
              <div class="fw-bold">${{ number_format($p->price,2) }}</div>
              <a href="{{ route('products.show', $p) }}" class="btn btn-sm btn-dark">{{ __('lang.view') }}</a>
            </div>
          </div>
        </div>
      </div>
    @endforeach
  </div>
</section>

<section id="latest" class="mb-5">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="section-title mb-0">{{ __('lang.latest_arrivals_title') }}</h2>
    <a href="{{ route('shop.index') }}" class="link-dark">{{ __('lang.shop_new') }}</a>
  </div>
  <div class="row g-3">
    @foreach($latestSection as $p)
      <div class="col-md-6 col-lg-3">
        <div class="card product-card h-100 shadow-sm">
          @if($p->image_url)
            <img src="{{ $p->image_url }}" class="card-img-top product-img" alt="{{ $p->name }}">
          @else
            <div class="card-img-top product-img placeholder-img">{{ __('lang.no_image') }}</div>
          @endif
          <div class="card-body d-flex flex-column">
            <h6 class="fw-semibold">{{ $p->name }}</h6>
            <div class="text-muted small mb-2">{{ $p->description }}</div>
            <div class="mt-auto d-flex justify-content-between align-items-center">
              <div class="fw-bold">${{ number_format($p->price,2) }}</div>
              <a href="{{ route('products.show', $p) }}" class="btn btn-sm btn-dark">{{ __('lang.view') }}</a>
            </div>
          </div>
        </div>
      </div>
    @endforeach
  </div>
</section>

<section id="why-us" class="mb-5">
  <h2 class="section-title mb-3">{{ __('lang.why_title') }}</h2>
  <div class="row g-3">
    <div class="col-md-4">
      <div class="card h-100 shadow-sm">
        <div class="card-body">
          <div class="h5">{{ __('lang.why_1_title') }}</div>
          <p class="text-muted mb-0">{{ __('lang.why_1_desc') }}</p>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card h-100 shadow-sm">
        <div class="card-body">
          <div class="h5">{{ __('lang.why_2_title') }}</div>
          <p class="text-muted mb-0">{{ __('lang.why_2_desc') }}</p>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card h-100 shadow-sm">
        <div class="card-body">
          <div class="h5">{{ __('lang.why_3_title') }}</div>
          <p class="text-muted mb-0">{{ __('lang.why_3_desc') }}</p>
        </div>
      </div>
    </div>
  </div>
</section>

<section id="testimonials" class="mb-5">
  <h2 class="section-title mb-3">{{ __('lang.testimonials_title') }}</h2>
  <div class="row g-3">
    <div class="col-md-4">
      <div class="card h-100 shadow-sm">
        <div class="card-body">
          <p class="mb-2">{{ __('lang.testimonial_1_text') }}</p>
          <div class="text-muted small">{{ __('lang.testimonial_1_author') }}</div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card h-100 shadow-sm">
        <div class="card-body">
          <p class="mb-2">{{ __('lang.testimonial_2_text') }}</p>
          <div class="text-muted small">{{ __('lang.testimonial_2_author') }}</div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card h-100 shadow-sm">
        <div class="card-body">
          <p class="mb-2">{{ __('lang.testimonial_3_text') }}</p>
          <div class="text-muted small">{{ __('lang.testimonial_3_author') }}</div>
        </div>
      </div>
    </div>
  </div>
</section>

<section id="faq" class="mb-5">
  <h2 class="section-title mb-3">{{ __('lang.faq_title') }}</h2>
  <div class="accordion shadow-sm" id="faqAccordion">
    <div class="accordion-item">
      <h2 class="accordion-header" id="faq1">
        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1-body">
          {{ __('lang.faq1_q') }}
        </button>
      </h2>
      <div id="faq1-body" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
        <div class="accordion-body text-muted">{{ __('lang.faq1_a') }}</div>
      </div>
    </div>
    <div class="accordion-item">
      <h2 class="accordion-header" id="faq2">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2-body">
          {{ __('lang.faq2_q') }}
        </button>
      </h2>
      <div id="faq2-body" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
        <div class="accordion-body text-muted">{{ __('lang.faq2_a') }}</div>
      </div>
    </div>
    <div class="accordion-item">
      <h2 class="accordion-header" id="faq3">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3-body">
          {{ __('lang.faq3_q') }}
        </button>
      </h2>
      <div id="faq3-body" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
        <div class="accordion-body text-muted">{{ __('lang.faq3_a') }}</div>
      </div>
    </div>
  </div>
</section>

<section id="featured" class="mb-5">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="section-title mb-0">{{ __('lang.featured_title') }}</h2>
    <a href="{{ route('shop.index') }}" class="link-dark">{{ __('lang.view_all') }}</a>
  </div>
  <div class="row g-3">
    @foreach($latestProducts as $p)
      <div class="col-md-6 col-lg-3">
        <div class="card product-card h-100 shadow-sm">
          @if($p->image_url)
            <img src="{{ $p->image_url }}" class="card-img-top product-img" alt="{{ $p->name }}">
          @else
            <div class="card-img-top product-img placeholder-img">{{ __('lang.no_image') }}</div>
          @endif
          <div class="card-body d-flex flex-column">
            <h6 class="fw-semibold">{{ $p->name }}</h6>
            <div class="text-muted small mb-2">{{ $p->description }}</div>
            <div class="mt-auto d-flex justify-content-between align-items-center">
              <div class="fw-bold">${{ number_format($p->price,2) }}</div>
              <a href="{{ route('products.show', $p) }}" class="btn btn-sm btn-dark">{{ __('lang.view') }}</a>
            </div>
          </div>
        </div>
      </div>
    @endforeach
  </div>
</section>
@endsection

@push('styles')
<style>
  .hero-wrap {
    background: radial-gradient(120% 120% at 10% 10%, #f7d9c4 0%, #f1f5ff 45%, #e8f7f3 100%);
    border: 1px solid rgba(0,0,0,0.05);
  }
  .hero-pill {
    display: inline-block;
    padding: 0.35rem 0.75rem;
    border-radius: 999px;
    background: #111;
    color: #fff;
    font-size: 0.8rem;
    letter-spacing: 0.04em;
  }
  .hero-card {
    background: #fff;
    border-radius: 18px;
  }
  .hero-card-inner {
    padding: 1.5rem;
  }
  .mini-thumb {
    width: 46px;
    height: 46px;
    border-radius: 10px;
    overflow: hidden;
    background: #f2f2f2;
    display: grid;
    place-items: center;
  }
  .mini-thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }
  .thumb-placeholder {
    font-size: 0.8rem;
    color: #555;
  }
  .section-title {
    font-weight: 700;
  }
  .product-card .product-img {
    height: 180px;
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
