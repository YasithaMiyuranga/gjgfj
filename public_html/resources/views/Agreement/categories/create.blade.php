<x-auth-validation-errors class="mb-4" :errors="$errors" />
<form method="post" action="{{ route('useradmin.agreement_categories.store') }}" id="agreementCategoryAddForm" data-ajax="true" enctype="multipart/form-data">
    @csrf
    <div class="form-group mb-3">
        <label class="form-label" for="name">{{ ('Category Name') }}</label>
        <x-input id="name" name="name" class="form-control" type="text" maxlength="100" required />
    </div>
    <div class="form-group mb-3">
        <label class="form-label
            " for="description">{{ ('Category Description') }}</label>
        <textarea id="description" name="description" class="form-control" required rows="4" maxlength="255"></textarea>
    </div>
    <div class="d-flex mb-3">
        <div class="d-grid">
            <button class="btn btn-primary btn-block mt-2" type="submit">{{ ('Add Category') }}</button>
        </div>
    </div>
</form>
