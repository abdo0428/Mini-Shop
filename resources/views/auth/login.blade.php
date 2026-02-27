@extends('layouts.main')

@section('content')
<div class="auth-wrap">
  <div class="container">
    <div class="row g-4 align-items-stretch">
      <div class="col-lg-6 d-none d-lg-block">
        <div class="auth-aside p-5 h-100">
          <span class="auth-badge">{{ __('lang.shop') }}</span>
          <h2 class="display-6 fw-bold mt-3">{{ __('lang.login_title') }}</h2>
          <p class="text-white-50 mt-3">
            {{ __('lang.login_desc') }}
          </p>
          <ul class="list-unstyled mt-4 text-white-50">
            <li class="mb-2">• {{ __('lang.login_benefit_1') }}</li>
            <li class="mb-2">• {{ __('lang.login_benefit_2') }}</li>
            <li>• {{ __('lang.login_benefit_3') }}</li>
          </ul>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="card auth-card shadow-sm">
          <div class="card-body p-4 p-lg-5">
            <h4 class="fw-bold mb-1">{{ __('lang.login_button') }}</h4>
            <div class="text-muted mb-4">{{ __('lang.welcome_back') }}</div>

            @if (session('status'))
              <div class="alert alert-success">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('login') }}">
              @csrf

              <div class="mb-3">
                <label for="email" class="form-label">{{ __('lang.email') }}</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}"
                       class="form-control @error('email') is-invalid @enderror"
                       required autofocus autocomplete="username">
                @error('email')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <div class="mb-3">
                <label for="password" class="form-label">{{ __('lang.password') }}</label>
                <input id="password" type="password" name="password"
                       class="form-control @error('password') is-invalid @enderror"
                       required autocomplete="current-password">
                @error('password')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <div class="d-flex align-items-center justify-content-between mb-4">
                <div class="form-check">
                  <input id="remember_me" class="form-check-input" type="checkbox" name="remember">
                  <label class="form-check-label" for="remember_me">{{ __('lang.remember_me') }}</label>
                </div>
                @if (Route::has('password.request'))
                  <a class="small" href="{{ route('password.request') }}">{{ __('lang.forgot_password') }}</a>
                @endif
              </div>

              <button class="btn btn-dark w-100">{{ __('lang.login_button') }}</button>

              <div class="text-center text-muted small mt-3">
                {{ __('lang.no_account') }}
                <a href="{{ route('register') }}">{{ __('lang.register') }}</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
