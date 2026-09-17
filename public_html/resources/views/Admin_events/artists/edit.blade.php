<x-auth-validation-errors class="mb-4" :errors="$errors" />
<form method="post" action="{{ route('useradmin.events.update_artist', [ $artist->aid ]) }}"
    enctype="multipart/form-data"id="artistEditForm" data-ajax="true">
    @csrf
    <div class="form-group mb-3">
        <label class="form-label" for="artist_name">{{ __('Artist Name  *') }}</label>
        <x-input value="{{ $artist->artist_name }}" id="artist_name" name="artist_name" class="form-control" type="text" required  maxlength="255"/>
    </div>
    <div class="form-group mb-3">
        <label class="form-label" for="phone_no">{{ __('Phone   *') }}</label>
        <x-input value="{{ $artist->phone_no }}" id="phone_no" name="phone_no" class="form-control" type="text"
            required />
    </div>
    <div class="form-group mb-3">
        <label class="form-label" for="visible">{{ __('Visible  *') }}</label>
        <select id="visible" name="visible" class="form-control" required>
            <option value="yes" {{ $artist->visible == 'yes' ? 'selected' : '' }}>Yes</option>
            <option value="no" {{ $artist->visible == 'no' ? 'selected' : '' }}>No
            </option>
        </select>
    </div>
    <div class="form-group mb-3">
        <label class="form-label" for="status">{{ __('State *') }}</label>
        <select id="status" name="status" class="form-control" required>
            <option value="active" {{$artist->status == 'Active' ? 'selected' : '' }}>Active</option>
            <option value="inactive" {{ $artist->status == 'Inactive' ? 'selected' : '' }}>Inactive
            </option>
        </select>
    </div>
    <div class="form-group mb-3">
        <label for="image" class="form-label">{{ __('Image  *') }}</label><br>
        <label for="image" class="form-label"><span style="color: rgb(235, 20, 20);">If you want to update the image, insert only<br>Size(450x600)</span></label>
        <x-input value="{{ asset('public/uploads/artists' . $artist->image) }}" id="image" name="image" class="form-control" type="file" accept=".jpeg,.png,.jpg,.gif,.svg,.jfif"/>
        <div id="imageError" class="error-message"style="color: #ec0a0a;"></div>
    </div>

    <div class="d-flex mb-3">
        <div class="d-grid">
            <button class="btn btn-primary btn-block mt-2" type="submit">{{ __('Update Artist') }}</button>
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
                } else {
                    document.getElementById('imageError').textContent = '';
                }
            };
            img.src = e.target.result;
        };
        reader.readAsDataURL(file);
    });
    document.getElementById('phone_no').addEventListener('input', function (e) {
        const phoneInput = e.target;
        const phonePattern = /^[0-9]{10}$/; // Adjust this pattern based  phone number format

        if (phonePattern.test(phoneInput.value)) {
            phoneInput.setCustomValidity('');
        } else {
            phoneInput.setCustomValidity('Invalid phone number');
        }
    });
    </script>

