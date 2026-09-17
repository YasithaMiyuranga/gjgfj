<x-auth-validation-errors class="mb-4" :errors="$errors" />
<form method="post" action="{{ route('useradmin.events.store_artist') }}" enctype="multipart/form-data" id="artistAddForm" data-ajax="true">
    @csrf
    <div class="form-group mb-3">
        <label class="form-label" for="artist_name">{{ __('Name *') }}</label>
        <x-input id="artist_name" name="artist_name" class="form-control" type="text" required  value="{{ old('artist_name') }}" maxlength="255"/>
        @if ($errors->has('artist_name'))
            <span class="text-danger">{{ $errors->first('artist_name') }}</span>
        @endif
    </div>
    <div class="form-group mb-3">
        <label class="form-label" for="phone_no">{{ __('Phone   *') }}</label>
        <x-input id="phone_no" name="phone_no" class="form-control" type="number" required />
        @if ($errors->has('phone_no'))
            <span class="text-danger">{{ $errors->first('phone_no') }}</span>
        @endif
    </div>
    <div class="form-group mb-3">
        <label class="form-label" for="visible">{{ __('Visible  *') }}</label>
        <select id="visible" name="visible" class="form-control" required value ="{{ old('visible') }}">
            <option value="yes" {{ old('visible') == 'yes' ? 'selected' : '' }}>{{ __('Yes') }}</option>
            <option value="no" {{ old('visible') == 'no' ? 'selected' : '' }}>{{ __('No') }}</option>
        </select>
        </select>
        @if ($errors->has('visible'))
            <span class="text-danger">{{ $errors->first('visible') }}</span>
        @endif
    </div>
    <div class="form-group mb-3">
        <label class="form-label" for="status">{{ __('Status    *') }}</label>
        <select id="status" name="status" class="form-control" required value ="{{ old('status') }}">
            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>{{ __('Active') }}</option>
            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>{{ __('Inactive') }}</option>
        </select>
        @if ($errors->has('status'))
            <span class="text-danger">{{ $errors->first('status') }}</span>
        @endif
    </div>
    <div class="form-group">
        <label for="album_images" class="form-label">{{ __('Image   *') }}</label><br>
        <span style="color:rgb(207, 208, 218);">Size(450x600)</span></label>
        <input class="form-control" name="image" type="file" id="image" accept=".jpeg,.png,.jpg,.gif,.svg,.jfif" required>
        <div id="imageError" class="error-message"style="color: #ec0a0a;"></div>
    </div>
    <div class="d-flex mb-3">
        <div class="d-grid">
            <button class="btn btn-primary btn-block mt-2" type="submit">{{ __('Add Artist') }}</button>
        </div>
    </div>
</form>
<script>
    document.getElementById('image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const reader = new FileReader();

        reader.onload = function(e) {
            const img = new Image();
            img.onload = function() {
                const width = this.width;
                const height = this.height;
                if (width !== 450 || height !== 600) {
                    document.getElementById('imageError').textContent =
                        `Please upload an image with dimensions 450x600.`;
                }
                else{
                    document.getElementById('imageError').textContent = '';
                }
            };
            img.src = e.target.result;
        };
        reader.readAsDataURL(file);
    });
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

