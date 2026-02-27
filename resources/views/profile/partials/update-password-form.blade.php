<section>
  <div class="d-flex justify-content-between align-items-center mb-3">
    <div>
      <h5 class="mb-1">{{ __('lang.password_update') }}</h5>
      <div class="text-muted small">{{ __('lang.password_update_desc') }}</div>
    </div>
  </div>

  <form method="post" action="{{ route('password.update') }}">
    @csrf
    @method('put')

    <div class="mb-3">
      <label for="update_password_current_password" class="form-label">{{ __('lang.current_password') }}</label>
      <input id="update_password_current_password" name="current_password" type="password"
             class="form-control @if($errors->updatePassword->has('current_password')) is-invalid @endif"
             autocomplete="current-password">
      @if($errors->updatePassword->has('current_password'))
        <div class="invalid-feedback">{{ $errors->updatePassword->first('current_password') }}</div>
      @endif
    </div>

    <div class="mb-3">
      <label for="update_password_password" class="form-label">{{ __('lang.new_password') }}</label>
      <input id="update_password_password" name="password" type="password"
             class="form-control @if($errors->updatePassword->has('password')) is-invalid @endif"
             autocomplete="new-password">
      @if($errors->updatePassword->has('password'))
        <div class="invalid-feedback">{{ $errors->updatePassword->first('password') }}</div>
      @endif
    </div>

    <div class="mb-3">
      <label for="update_password_password_confirmation" class="form-label">{{ __('lang.confirm_password') }}</label>
      <input id="update_password_password_confirmation" name="password_confirmation" type="password"
             class="form-control @if($errors->updatePassword->has('password_confirmation')) is-invalid @endif"
             autocomplete="new-password">
      @if($errors->updatePassword->has('password_confirmation'))
        <div class="invalid-feedback">{{ $errors->updatePassword->first('password_confirmation') }}</div>
      @endif
    </div>

    <div class="d-flex align-items-center gap-2">
      <button class="btn btn-dark">{{ __('lang.save') }}</button>

      @if (session('status') === 'password-updated')
        <span class="text-success small">{{ __('lang.saved') }}</span>
      @endif
    </div>
  </form>
</section>
