<x-auth-validation-errors class="mb-4" :errors="$errors" />
<form method="post" action="{{ route('useradmin.permissions.store') }}" enctype="multipart/form-data" id="permissionsForm">
    @csrf
    <div class="form-group mb-3">
        <label class="form-label" for="name">{{ ('Name') }}</label>
        <x-input id="name" class="form-control" type="text" name="name" required autofocus maxlength="50" />
    </div>
    <div class="form-group mb-3">
        <label class="form-label" for="description">{{ ('Description') }}</label>
        <textarea id="description" class="form-control" name="description" rows="5" required maxlength="255"></textarea>
    </div>
    <div class="d-flex mb-3">
        <div class="d-grid">
            <button id="submitButton" class="btn btn-primary btn-block mt-2" type="submit"> {{ ('Save') }} </button>
        </div>
    </div>
</form>
