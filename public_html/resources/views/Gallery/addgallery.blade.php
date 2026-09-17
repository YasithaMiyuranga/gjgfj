<x-auth-validation-errors class="mb-4" :errors="$errors" />

<form id="galleryForm" method="post" action="{{ route('useradmin.gallery.store') }}" enctype="multipart/form-data">
    @csrf

    <input type="hidden" name="created_by" value="admin">

    <div class="form-group mb-3">
        <label class="form-label" for="name">{{ __('Enter Name*') }}</label>
        <x-input id="name" class="form-control" type="text" name="name" autofocus />
        <span id="nameError" class="text-danger"></span>
    </div>

    <div class="form-group mb-3">
        <label class="form-label" for="description">{{ __('Enter Description*') }}</label>
        <x-input id="description" class="form-control" type="text" name="description" autofocus />
        <span id="descriptionError" class="text-danger"></span>
    </div>

    <div class="form-group mb-3">
        <label class="form-label" for="tags">{{ __('Enter Tags*') }}</label>
        <x-input id="tags" class="form-control" type="text" name="tags" autofocus />
        <span id="tagsError" class="text-danger"></span>
    </div>

    <div class="form-group">
        <label for="album_images" class="form-label">{{ __('Image*') }}</label>
        <input class="form-control" name="album_images" type="file"  id="album_images">
        <span id="albumImagesError" class="text-danger"></span>
    </div>

    <div class="form-group mb-3">
        <label class="form-label" for="date">{{ __('Enter Date') }}</label>
        <x-input id="date" class="form-control" type="date" name="date" autofocus />
    </div>

    <div class="form-group mb-3">
        <label class="form-label" for="event">{{ __('Enter Event*') }}</label>
        <x-input id="event" class="form-control" type="text" name="event" autofocus />
        <span id="eventError" class="text-danger"></span>
    </div>

    <div class="d-flex mb-3">
        <div class="d-grid">
            <button class="btn btn-primary btn-block mt-2" type="submit"> {{ __('Add Gallery') }} </button>
        </div>
    </div>
</form>

<script>
    document.getElementById('galleryForm').addEventListener('submit', function(e) {
        e.preventDefault();
        let isValid = true;

        // Clear previous errors
        document.querySelectorAll('.text-danger').forEach(el => el.textContent = '');

        // Required fields
        const requiredFields = [
            { id: 'name', errorId: 'nameError', message: 'Name is required.' },
            { id: 'tags', errorId: 'tagsError', message: 'Tags are required.' },
            { id: 'event', errorId: 'eventError', message: 'Event is required.' }
        ];

        // Validate required fields
        requiredFields.forEach(field => {
            const inputElement = document.getElementById(field.id);
            if (!inputElement.value.trim()) {
                document.getElementById(field.errorId).textContent = field.message;
                isValid = false;
            }
        });

        // Validate description length (max 255 characters)
        const descriptionInput = document.getElementById('description');
        const maxDescriptionLength = 255;
        if (!descriptionInput.value.trim()) {
            document.getElementById('descriptionError').textContent = 'Description is required.';
            isValid = false;
        } else if (descriptionInput.value.length > maxDescriptionLength) {
            document.getElementById('descriptionError').textContent = `Description must be less than ${maxDescriptionLength} characters.`;
            isValid = false;
        }
        // Validate Name length (max 255 characters)
        const nameInput = document.getElementById('name');
        const maxNameLength = 255;
        if (!nameInput.value.trim()) {
            document.getElementById('nameError').textContent = 'Name is required.';
            isValid = false;
        } else if (nameInput.value.length > maxNameLength) {
            document.getElementById('nameError').textContent = `Name must be less than ${maxNameLength} characters.`;
            isValid = false;
        }
        // Validate Tags length (max 255 characters)
        const tagsInput = document.getElementById('tags');
        const maxTagsLength = 255;
        if (!tagsInput.value.trim()) {
            document.getElementById('tagsError').textContent = 'Tags are required.';
            isValid = false;
        } else if (tagsInput.value.length > maxTagsLength) {
            document.getElementById('tagsError').textContent = `Tags must be less than ${maxTagsLength} characters.`;
            isValid = false;
        }

        // Validate Event length (max 255 characters)
        const eventInput = document.getElementById('event');
        const maxEventLength = 255;
        if (!eventInput.value.trim()) {
            document.getElementById('eventError').textContent = 'Event is required.';
            isValid = false;
        } else if (eventInput.value.length > maxEventLength) {
            document.getElementById('eventError').textContent = `Event must be less than ${maxEventLength} characters.`;
            isValid = false;
        }

        // Validate image size and type
        const imageInput = document.getElementById('album_images');
        const maxSize = 5 * 1024 * 1024; // 5MB in bytes
        const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/svg+xml'];

        if (imageInput.files.length > 0) {
            const imageFile = imageInput.files[0];

            // Check file size
            if (imageFile.size > maxSize) {
                document.getElementById('albumImagesError').textContent = 'Image must be less than 5MB.';
                isValid = false;
            }

            // Check file type
            if (!allowedTypes.includes(imageFile.type)) {
                document.getElementById('albumImagesError').textContent = 'Invalid file type. Allowed types: jpeg, png, jpg, gif, svg.';
                isValid = false;
            }
        } else {
            // If no file is selected, show error
            document.getElementById('albumImagesError').textContent = 'Image is required.';
            isValid = false;
        }

        // If the form is valid, submit it
        if (isValid) {
            this.submit();
        }
    });
</script>


