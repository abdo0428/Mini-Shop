@extends('layouts.main')

@section('content')
<div class="auth-wrap">
  <div class="container">
    <div class="row g-4 justify-content-center">
      <div class="col-lg-7">
        <div class="card auth-card shadow-sm">
          <div class="card-body p-4 p-lg-5">
            <h4 class="fw-bold mb-2">{{ __('lang.verify_email_title') }}</h4>
            <p class="text-muted mb-4">{{ __('lang.verify_email_desc') }}</p>

            @if (session('status') == 'verification-link-sent')
              <div class="alert alert-success">{{ __('lang.verification_sent') }}</div>
            @endif

            <div class="d-flex flex-wrap gap-2">
              <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button class="btn btn-dark">{{ __('lang.resend_verification_button') }}</button>
              </form>

              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-outline-dark">{{ __('lang.logout') }}</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
