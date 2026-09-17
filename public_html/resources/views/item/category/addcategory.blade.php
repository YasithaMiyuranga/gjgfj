<form method="post" action="{{ route('useradmin.stockcategory.store') }}" enctype="multipart/form-data" id="categoryForm" data-ajax="true">
    @csrf
    <div class="form-group mb-3">
        <label class="form-label" for="name">{{ ('Category Name *') }}</label>
        <x-input id="name" name="name" class="form-control" type="text" required maxlength="255"/>
    </div>
    <div class="form-group mb-3">
        <label class="form-label" for="status">{{ ('Status  *') }}</label>
        <select id="status" name="status" class="form-control" required>
            <option value="active">{{ ('Active') }}</option>
            <option value="inactive">{{ ('Inactive') }}</option>
        </select>
    </div>
    <div class="d-flex mb-3">
        <div class="d-grid">
            <button class="btn btn-primary btn-block mt-2" type="submit">{{ ('Add Category') }}</button>
        </div>
    </div>
</form>
