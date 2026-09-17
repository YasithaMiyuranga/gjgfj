
<form method="POST" action="{{ route('packageitem.store') }}"  enctype="multipart/form-data">
    @csrf

    <div class="mb-3">
        <label for="package_id" class="form-label">{{ __('Package Id') }}</label>
        <select name="package_id" id="package_id" class="form-control">
            <option value="" selected disabled>Select Location</option>
            @foreach ($package as $package)
                <option value="{{ $package->package_id }}">{{ $package->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label for="name" class="form-label">{{ __('Name') }}</label>
        <input type="text" class="form-control custom-width" id="name" name="name" required>
    </div>
    <div class="mb-3">
        <label for="qty" class="form-label">{{ __('qty') }}</label>
        <input type="text" class="form-control custom-width" id="qty" name="qty" required>
    </div>

    <div class="mb-3">
        <label for="description" class="form-label">{{ __('Description') }}</label>
        <textarea class="form-control custom-width" id="description" name="description" required></textarea>
    </div>
    <div class="mb-3">
        <label for="status" class="form-label">{{ __('Status') }}</label>
        <input type="text" class="form-control custom-width" id="status" name="status" required>
    </div>
    <div class="form-group">
        <label for="image" class="form-label">{{ __('Image') }}</label>
        <input class="form-control" name="image" type="file" id="image">
    </div>


    {{-- <div class="form-group">
        <label for="image" class="form-label">{{ __('Image') }}</label>
        <input class="form-control" name="image" type="file" id="image">
    </div> --}}
    <button type="submit" class="btn btn-primary">{{ __('Create package item') }}</button>
</form>
