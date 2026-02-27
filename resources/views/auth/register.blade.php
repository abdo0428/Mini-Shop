@extends('layouts.main')

@section('content')
<div class="auth-wrap">
  <div class="container">
    <div class="row g-4 align-items-stretch">
      <div class="col-lg-6 d-none d-lg-block">
        <div class="auth-aside p-5 h-100">
          <span class="auth-badge">{{ __('lang.shop') }}</span>
          <h2 class="display-6 fw-bold mt-3">{{ __('lang.register_title') }}</h2>
          <p class="text-white-50 mt-3">
            {{ __('lang.register_desc') }}
          </p>
          <ul class="list-unstyled mt-4 text-white-50">
            <li class="mb-2">• {{ __('lang.register_benefit_1') }}</li>
            <li class="mb-2">• {{ __('lang.register_benefit_2') }}</li>
            <li>• {{ __('lang.register_benefit_3') }}</li>
          </ul>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="card auth-card shadow-sm">
          <div class="card-body p-4 p-lg-5">
            <h4 class="fw-bold mb-1">{{ __('lang.register') }}</h4>
            <div class="text-muted mb-4">{{ __('lang.register_cta') }}</div>

            <form method="POST" action="{{ route('register') }}">
              @csrf

              <div class="mb-3">
                <label for="name" class="form-label">{{ __('lang.name') }}</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}"
                       class="form-control @error('name') is-invalid @enderror"
                       required autofocus autocomplete="name">
                @error('name')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <div class="mb-3">
                <label for="email" class="form-label">{{ __('lang.email') }}</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}"
                       class="form-control @error('email') is-invalid @enderror"
                       required autocomplete="username">
                @error('email')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <div class="mb-3">
                <label for="password" class="form-label">{{ __('lang.password') }}</label>
                <input id="password" type="password" name="password"
                       class="form-control @error('password') is-invalid @enderror"
                       required autocomplete="new-password">
                @error('password')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <div class="mb-3">
                <label for="password_confirmation" class="form-label">{{ __('lang.confirm_password') }}</label>
                <input id="password_confirmation" type="password" name="password_confirmation"
                       class="form-control @error('password_confirmation') is-invalid @enderror"
                       required autocomplete="new-password">
                @error('password_confirmation')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <button class="btn btn-dark w-100">{{ __('lang.register') }}</button>

              <div class="text-center text-muted small mt-3">
                {{ __('lang.have_account') }}
                <a href="{{ route('login') }}">{{ __('lang.login_button') }}</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
