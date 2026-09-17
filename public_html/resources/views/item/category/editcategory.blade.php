<x-auth-validation-errors class="mb-4" :errors="$errors" />
<form method="post" action="{{ route('useradmin.stockcategory.update', ['id' => $category->id]) }}"id="categoryForm" data-ajax="true"
    enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="form-group mb-3">
        <label class="form-label" for="name">{{ __('Category Name') }}</label>
        <x-input value="{{ $category->name }}" id="name" name="name" class="form-control" type="text" required />
    </div>
    <div class="form-group mb-3">
        <label class="form-label" for="status">{{ __('Status') }}</label>
        <select id="status" name="status" class="form-control" required>
            <option value="active" {{ $category->status == 'active' ? 'selected' : '' }}>Active</option>
            <option value="inactive" {{ $category->status == 'inactive' ? 'selected' : '' }}>Inactive
            </option>
        </select>
    </div>
    <div class="d-flex mb-3">
        <div class="d-grid">
            <button class="btn btn-primary btn-block mt-2" type="submit">{{ __('Update Category') }}</button>
        </div>
    </div>
</form>
