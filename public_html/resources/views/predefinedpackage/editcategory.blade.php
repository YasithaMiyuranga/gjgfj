<x-auth-validation-errors class="mb-4" :errors="$errors" />
<form method="POST" action="{{ route('useradmin.update.package.category', $category->category_id) }}" enctype="multipart/form-data" id="predefinedCategoryEditForm" data-ajax="true">
    @csrf
    @method('PUT')
    <?php
    $user = Auth::user();
    ?>
    <input type="hidden" name="package_id" id="package_id" value="{{ $category->category_id }}">

    <div class="form-group-mb-3">
        <label for="name">Category Name *</label>
        <input type="text" class="form-control" id="name" name="categoryName" value="{{ $category->category_name }}" maxlength="100" >
    </div>

    <div class="d-flex mb-3">
        <div class="d-grid">
            <button class="btn btn-primary btn-block mt-2" type="submit">{{ __('Update Category') }}</button>
        </div>
    </div>
</form>
