<x-auth-validation-errors class="mb-4" :errors="$errors" />
<form method="post" action="{{ route('useradmin.events.category_update', ['id' =>$category->id]) }}"
    enctype="multipart/form-data" id="categoryEditForm" data-ajax="true">
    @csrf
    <div class="form-group mb-3">
        <label class="form-label" for="name">{{ __('Category Name *') }}</label>
        <x-input value="{{ $category->category_name }}" id="name" name="category_name" class="form-control" type="text"  maxlength="100" required />
    </div>
    <div class="d-flex mb-3">
        <div class="d-grid">
            <button class="btn btn-primary btn-block mt-2" type="submit">{{ __('Update Category') }}</button>
        </div>
    </div>
</form>
