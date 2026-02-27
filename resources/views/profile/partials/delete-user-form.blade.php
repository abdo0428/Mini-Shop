<section>
  <div class="d-flex justify-content-between align-items-center mb-3">
    <div>
      <h5 class="mb-1 text-danger">{{ __('lang.delete_account') }}</h5>
      <div class="text-muted small">{{ __('lang.delete_account_desc') }}</div>
    </div>
  </div>

  <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
    {{ __('lang.delete_account') }}
  </button>

  <div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">{{ __('lang.delete_account_confirm_title') }}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p class="text-muted">{{ __('lang.delete_account_confirm_desc') }}</p>
          <form method="post" action="{{ route('profile.destroy') }}" id="deleteAccountForm">
            @csrf
            @method('delete')

            <div class="mt-3">
              <label for="password" class="form-label">{{ __('lang.password') }}</label>
              <input id="password" name="password" type="password"
                     class="form-control @if($errors->userDeletion->has('password')) is-invalid @endif"
                     placeholder="{{ __('lang.password') }}">
              @if($errors->userDeletion->has('password'))
                <div class="invalid-feedback">{{ $errors->userDeletion->first('password') }}</div>
              @endif
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('lang.cancel') }}</button>
          <button type="submit" form="deleteAccountForm" class="btn btn-danger">{{ __('lang.delete_account') }}</button>
        </div>
      </div>
    </div>
  </div>
</section>
