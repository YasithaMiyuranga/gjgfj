<x-auth-validation-errors class="mb-4" :errors="$errors" />
<form method="post" action="{{ route('useradmin.events.update_user_status', ['id' => $userDetails->id]) }}"
    enctype="multipart/form-data">
    @csrf
    <div class="form-group mb-3">
        <label class="form-label" for="status">{{ __('User Status') }}</label>
        <select id="status" name="status" class="form-control" required>
            <option value="Active" {{ $userDetails->status == 'Active' ? 'selected' : '' }}>Active</option>
            <option value="Inactive" {{ $userDetails->status == 'Inactive' ? 'selected' : '' }}>Inactive
            </option>
        </select>
    </div>
    <div class="d-flex mb-3">
        <div class="d-grid">
            <button class="btn btn-primary btn-block mt-2" type="submit">{{ __('Update User Status') }}</button>
        </div>
    </div>
</form>


   