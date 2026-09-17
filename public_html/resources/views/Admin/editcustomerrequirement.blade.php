<x-auth-validation-errors class="mb-4" :errors="$errors" />
<form method="post" action="{{ route('useradmin.customer.requirement.update', $customerRequirement->id ) }}" id="customerRequirementEditForm" data-ajax="true" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="created_by" value="admin">
    <div class="form-group mb-3">
        <label class="form-label" for="name">{{ ' Name*' }}</label>
        <x-input id="name" class="form-control" type="text" name="name"
            value="{{ old('name', $customerRequirement->name) }}" autofocus />
        <span class="text-danger" id="nameError"></span>
    </div>
    <div class="form-group mb-3">
        <label class="form-label" for="name">{{ ' Description ' }}</label>
        <textarea id="description" class="form-control" name="description"
            value="{{ old('description') }}" autofocus>{{ $customerRequirement->description }}</textarea>
        <span class="text-danger" id="descriptionError"></span>
    </div>
    <div class="d-flex mb-3">
        <div class="d-grid">
            <button class="btn btn-primary btn-block mt-2 from-prevent-multiple-submits" type="submit">
                {{ ('Update')}} </button>
        </div>
    </div>
</form>
