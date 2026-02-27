@extends('layouts.main')

@section('content')
<div class="auth-wrap">
  <div class="container">
    <div class="row g-4 justify-content-center">
      <div class="col-lg-6">
        <div class="card auth-card shadow-sm">
          <div class="card-body p-4 p-lg-5">
            <h4 class="fw-bold mb-1">{{ __('lang.reset_password_title') }}</h4>
            <div class="text-muted mb-4">{{ __('lang.reset_password_desc') }}</div>

            <form method="POST" action="{{ route('password.store') }}">
              @csrf
              <input type="hidden" name="token" value="{{ $request->route('token') }}">

              <div class="mb-3">
                <label for="email" class="form-label">{{ __('lang.email') }}</label>
                <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}"
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

              <button class="btn btn-dark w-100">{{ __('lang.reset_password_button') }}</button>
            </form>

            <div class="text-center text-muted small mt-3">
              <a href="{{ route('login') }}">{{ __('lang.back_to_login') }}</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
