<x-auth-validation-errors class="mb-4" :errors="$errors" />
<form method="post" action="{{ route('useradmin.termsAndConditions.store') }}" id="CreateTermsCondition" data-ajax="true" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="created_by" value="admin">
    <div class="form-group mb-3">
        <label class="form-label" for="name">{{ 'Enter Title*' }}</label>
        <x-input id="title" class="form-control" type="text" name="title"
            value="{{ old('title') }}" autofocus />
        <span class="text-danger" id="titleError"></span>
    </div>
    <div class="form-group mb-3">
        <label for="description" class="form-label">{{ ('Enter Description*') }}</label>
        <textarea id="description" class="form-control" name="description"
            value="{{ old('description') }}"></textarea>
        <span class="text-danger" id="descriptError"></span>
    </div>
    <div class="d-flex mb-3">
        <div class="d-grid">
            <button class="btn btn-primary btn-block mt-2 from-prevent-multiple-submits" type="submit">
             {{ ('Add Terms & Conditions')}} </button>
        </div>
    </div>
</form>

<script>
    document.getElementById("CreateTermsCondition").addEventListener("submit", function(e) {
        let isValid = true;
        let title = document.getElementById("title").value.trim();
        let description = document.getElementById("description").value.trim();

        // Clear previous errors
        document.getElementById("titleError").textContent = "";
        document.getElementById("descriptError").textContent = "";

        if (title === '') {
            document.getElementById("titleError").textContent = "Title is required";
            isValid = false;
        } else if (title.length > 255) {
            document.getElementById("titleError").textContent = "Title must be at most 255 characters";
            isValid = false;
        }

        if (description === '') {
            document.getElementById("descriptError").textContent = "Description is required";
            isValid = false;
        }

        if (!isValid) {
            e.preventDefault(); // Prevent form submission
        }
    });
</script>
