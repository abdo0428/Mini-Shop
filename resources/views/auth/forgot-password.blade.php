@extends('layouts.main')

@section('content')
<div class="auth-wrap">
  <div class="container">
    <div class="row g-4 justify-content-center">
      <div class="col-lg-6">
        <div class="card auth-card shadow-sm">
          <div class="card-body p-4 p-lg-5">
            <h4 class="fw-bold mb-1">{{ __('lang.forgot_password_title') }}</h4>
            <div class="text-muted mb-4">{{ __('lang.forgot_password_desc') }}</div>

            @if (session('status'))
              <div class="alert alert-success">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
              @csrf
              <div class="mb-3">
                <label for="email" class="form-label">{{ __('lang.email') }}</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}"
                       class="form-control @error('email') is-invalid @enderror"
                       required autofocus>
                @error('email')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <button class="btn btn-dark w-100">{{ __('lang.send_reset_link') }}</button>
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
