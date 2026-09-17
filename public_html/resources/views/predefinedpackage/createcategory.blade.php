
<form method="post" action="{{ route('useradmin.store.package.category') }}" enctype="multipart/form-data" id="predefinedCategoryForm" data-ajax="true">
    @csrf
    <input type="hidden" name="created_by" value="admin">
    <div class="form-group mb-3">
        <label class="form-label" for="name">{{ ('Enter Category Name   *') }}</label>
        <x-input id="categoryName" class="form-control" text="text-capitalize" type="text" name="categoryName" required
            autofocus maxlength="100" />
    </div>

    <div class="d-flex mb-3">
        <div class="d-grid">
            <button class="btn btn-primary btn-block mt-2" type="submit">{{ __('Add Category') }}</button>
        </div>
    </div>
</form>
