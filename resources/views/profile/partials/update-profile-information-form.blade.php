<section>
  <div class="d-flex justify-content-between align-items-center mb-3">
    <div>
      <h5 class="mb-1">{{ __('lang.profile_info') }}</h5>
      <div class="text-muted small">{{ __('lang.profile_info_desc') }}</div>
    </div>
  </div>

  <form id="send-verification" method="post" action="{{ route('verification.send') }}">
    @csrf
  </form>

  <form method="post" action="{{ route('profile.update') }}">
    @csrf
    @method('patch')

    <div class="mb-3">
      <label for="name" class="form-label">{{ __('lang.name') }}</label>
      <input id="name" name="name" type="text"
             class="form-control @error('name') is-invalid @enderror"
             value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
      @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <div class="mb-3">
      <label for="email" class="form-label">{{ __('lang.email') }}</label>
      <input id="email" name="email" type="email"
             class="form-control @error('email') is-invalid @enderror"
             value="{{ old('email', $user->email) }}" required autocomplete="username">
      @error('email')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror

      @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
        <div class="mt-2 text-muted small">
          {{ __('lang.email_unverified') }}
          <button form="send-verification" class="btn btn-link p-0 align-baseline">
            {{ __('lang.resend_verification') }}
          </button>
        </div>

        @if (session('status') === 'verification-link-sent')
          <div class="alert alert-success py-2 px-3 mt-2">
            {{ __('lang.verification_sent') }}
          </div>
        @endif
      @endif
    </div>

    <div class="d-flex align-items-center gap-2">
      <button class="btn btn-dark">{{ __('lang.save') }}</button>

      @if (session('status') === 'profile-updated')
        <span class="text-success small">{{ __('lang.saved') }}</span>
      @endif
    </div>
  </form>
</section>
