<x-auth-validation-errors class="mb-4" :errors="$errors" />
<form method="post" action="{{ route('useradmin.package.images.store') }}" enctype="multipart/form-data" id="packageForm">
    @csrf
    <input type="hidden" name="created_by" value="admin">
    <input type="hidden" name="packageId" value="{{ $package->package_id }}">
    <div class="form-group">
        <label for="package_images" class="form-label">{{ __('Image *') }}</label>
        <input class="form-control" name="package_images[]" multiple accept="image/*" type="file" id="package_images">
        <span id="packageImageError" style="color: red;"></span> <!-- Error message placeholder -->
    </div>
    <div class="d-flex mb-3">
        <div class="d-grid">
            <button class="btn btn-primary btn-block mt-2" type="submit"> {{ __('Add to Package') }} </button>
        </div>
    </div>
</form>
<script>
    document.getElementById('packageForm').addEventListener('submit', function(e) {
        // Initialize error element and clear previous error messages
        const errorElement = document.getElementById('packageImageError');
        errorElement.textContent = ''; // Clear previous errors
        let errorMessages = [];

        // Variables for validation
        const imageInput = document.getElementById('package_images');
        const maxSize = 5 * 1024 * 1024; // 5MB in bytes
        const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/svg+xml'];

        if (imageInput.files.length > 0) {
            for (let i = 0; i < imageInput.files.length; i++) {
                const imageFile = imageInput.files[i];

                // Check file size
                if (imageFile.size > maxSize) {
                    errorMessages.push(`Image ${i + 1} must be less than 5MB.`);
                }

                // Check file type
                if (!allowedTypes.includes(imageFile.type)) {
                    errorMessages.push(
                        `Image ${i + 1} has an invalid file type. Allowed types: jpeg, png, jpg, gif, svg.`);
                }
            }

            // If there are any error messages, display them
            if (errorMessages.length > 0) {
                errorElement.textContent = errorMessages.join(' '); // Join all error messages with a space
                e.preventDefault(); // Prevent form submission
            }
        } else {
            // If no file is selected, show error
            errorMessages.push('At least one image is required.');
            errorElement.textContent = errorMessages.join(' ');
            e.preventDefault();
        }
    });

    function validateImageSize(file, expectedWidth, expectedHeight, errorElementId) {

        var reader = new FileReader();

        reader.onload = function(e) {
            var img = new Image();
            img.onload = function() {
                if (this.width !== expectedWidth || this.height !== expectedHeight) {
                    document.getElementById(errorElementId).textContent =
                        `Please upload an image with dimensions ${expectedWidth}x${expectedHeight}.`;
                } else {
                    document.getElementById(errorElementId).textContent = '';
                }
            };
            img.src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
</script>
