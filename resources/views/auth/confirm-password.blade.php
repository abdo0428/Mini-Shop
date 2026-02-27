@extends('layouts.main')

@section('content')
<div class="auth-wrap">
  <div class="container">
    <div class="row g-4 justify-content-center">
      <div class="col-lg-6">
        <div class="card auth-card shadow-sm">
          <div class="card-body p-4 p-lg-5">
            <h4 class="fw-bold mb-1">{{ __('lang.confirm_password_title') }}</h4>
            <div class="text-muted mb-4">{{ __('lang.confirm_password_desc') }}</div>

            <form method="POST" action="{{ route('password.confirm') }}">
              @csrf

              <div class="mb-3">
                <label for="password" class="form-label">{{ __('lang.password') }}</label>
                <input id="password" type="password" name="password"
                       class="form-control @error('password') is-invalid @enderror"
                       required autocomplete="current-password">
                @error('password')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <button class="btn btn-dark w-100">{{ __('lang.confirm') }}</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
