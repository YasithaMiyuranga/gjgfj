<x-auth-validation-errors class="mb-4" :errors="$errors" />
<form method="post" action="{{ route('useradmin.agreement_categories.update', ['agreementCategory' => $agreementCategory->id]) }}" id="agreementCategoryEditForm" data-ajax="true" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="form-group mb-3">
        <label class="form-label" for="name">{{ ('Category Name') }}</label>
        <x-input id="name" name="name" class="form-control" type="text" maxlength="100" required  value="{{ $agreementCategory->name }}"/>
    </div>
    <div class="form-group mb-3">
        <label class="form-label
            " for="description">{{ ('Category Description') }}</label>
        <textarea id="description" name="description" class="form-control" required rows="4" maxlength="255">{{ $agreementCategory->description }}</textarea>
    </div>
    <div class="d-flex mb-3">
        <div class="d-grid">
            <button class="btn btn-primary btn-block mt-2" type="submit">{{ ('Update') }}</button>
        </div>
    </div>
</form>
