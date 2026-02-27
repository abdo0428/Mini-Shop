@extends('layouts.main')

@section('content')
<div class="page-hero p-4 p-lg-5 mb-4">
  <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3">
    <div>
      <div class="text-uppercase text-muted small">{{ __('lang.profile') }}</div>
      <h2 class="fw-bold mb-1">{{ __('lang.profile_settings') }}</h2>
      <div class="text-muted">{{ __('lang.profile_desc') }}</div>
    </div>
    <div class="d-flex align-items-center gap-2">
      <span class="badge bg-dark">{{ auth()->user()->is_admin ? __('lang.admin_panel') : __('lang.my_orders') }}</span>
      <a href="{{ route('shop.index') }}" class="btn btn-outline-dark btn-sm">{{ __('lang.shop') }}</a>
    </div>
  </div>
</div>

<div class="row g-3">
  <div class="col-lg-6">
    <div class="card shadow-sm h-100">
      <div class="card-body">
        @include('profile.partials.update-profile-information-form')
      </div>
    </div>
  </div>

  <div class="col-lg-6">
    <div class="card shadow-sm h-100">
      <div class="card-body">
        @include('profile.partials.update-password-form')
      </div>
    </div>
  </div>

  <div class="col-12">
    <div class="card shadow-sm border-danger-subtle">
      <div class="card-body">
        @include('profile.partials.delete-user-form')
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
@if($errors->userDeletion->isNotEmpty())
<script>
  const modalEl = document.getElementById('deleteAccountModal');
  if (modalEl) new bootstrap.Modal(modalEl).show();
</script>
@endif
@endpush
