<x-auth-validation-errors class="mb-4" :errors="$errors" />

<form id="termsConditionForm" method="POST" action="{{ route('useradmin.terms.update', $termsCondition->id) }}" enctype="multipart/form-data" data-ajax="true">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label for="title" class="form-label">Edit Title*</label>
        <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $termsCondition->title) }}">
        @error('title')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="description" class="form-label">Edit Description*</label>
        <textarea id="description" class="form-control" name="description">{{ old('description', $termsCondition->description) }}</textarea>
        @error('description')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary from-prevent-multiple-submits">Update</button>
</form>

<script>
    document.getElementById("termsConditionForm").addEventListener("submit", function(e) {
        let title = document.getElementById("title").value.trim();
        let description = document.getElementById("description").value.trim();

        if (title === '' || description === '') {
            alert("Please fill in all fields."); // Or a nicer alert
            e.preventDefault();
        }
    });
</script>
