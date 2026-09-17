<x-auth-validation-errors class="mb-4" :errors="$errors" />
<form method="post" action="{{ route('useradmin.events.sponsor_update', [$sponsor->sponsor_id]) }}" enctype="multipart/form-data" id="artistAddForm" data-ajax="true">
    @csrf
    <div class="form-group mb-3">
        <label class="form-label" for="sponsor_name">{{ ('Sponsor Name   *') }}</label>
        <x-input id="sponsor_name" name="sponsor_name" class="form-control" type="text" required  value="{{ old('sponsor_name', $sponsor->sponsor_name) }}" maxlength="255"/>
        @if ($errors->has('sponsor_name'))
            <span class="text-danger">{{ $errors->first('sponsor_name') }}</span>
        @endif
    </div>
    <div class="form-group mb-3">
        <label class="form-label" for="phone_no">{{ ('Phone') }}</label>
        <x-input id="phone_no" name="phone_no" class="form-control" type="text" value="{{ old('phone_no', $sponsor->sponsor_phone) }}"/>
        @if ($errors->has('phone_no'))
            <span class="text-danger">{{ $errors->first('phone_no') }}</span>
        @endif
    </div>
    <div class="form-group mb-3">
        <label class="form-label" for="website_url">{{ ('Website URL') }}</label>
        <x-input id="website_url" name="website_url" class="form-control" type="text" value="{{ old('website_url', $sponsor->sponsor_link) }}" maxlength="255" />
        @if ($errors->has('website_url'))
            <span class="text-danger">{{ $errors->first('website_url') }}</span>
        @endif
    </div>
    <div class="form-group mb-3">
        <label for="album_images" class="form-label">{{ ('Sponsor Logo (Max 5MB)') }}</label>
        <label for="image" class="form-label"><span style="color: rgb(212, 16, 16);">(If you want to update the logo, insert only)</span></label>
        <input class="form-control" name="image" type="file" id="image" accept=".jpeg,.png,.jpg,.gif,.svg,.jfif">
    </div>
    <div class="form-group mb-3">
        <label class="form-label" for="Status">{{ ('Status  *') }}</label>
        <select id="Status" name="status" class="form-control" required value ="{{ old('Status') }}">
            <option value="active" {{ old('status', $sponsor->status) == 'active' ? 'selected' : ''   }}>{{ ('Active') }}</option>
            <option value="inactive" {{ old('status', $sponsor->status) == 'inactive' ? 'selected' : '' }}>{{ ('Inactive') }}</option>
        </select>
        @if ($errors->has('status'))
            <span class="text-danger">{{ $errors->first('status') }}</span>
        @endif
    </div>
    <div class="d-flex mb-3">
        <div class="d-grid">
            <button class="btn btn-primary btn-block mt-2" type="submit">{{ ('Update Sponsor') }}</button>
        </div>
    </div>
</form>
<script>
    document.getElementById('phone_no').addEventListener('input', function (e) {
        const phoneInput = e.target;
        const phonePattern = /^[0-9]{10}$/; // Adjust this pattern based on your phone number format

        if (phoneInput.value === '') {
            phoneInput.setCustomValidity('Phone number is required');
        } else if (phonePattern.test(phoneInput.value)) {
            phoneInput.setCustomValidity(''); // Clear any previous error message
        } else {
            phoneInput.setCustomValidity('Invalid phone number');
        }
    });
</script>

