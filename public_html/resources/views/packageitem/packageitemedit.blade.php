<form method="POST" action="{{ route('packageitem.updates', $package->id) }}" method="POST">  
    @csrf
    @method('PUT')
   
    <div class="mb-3">
        <label for="name" class="form-label">{{ __('Name') }}</label>
        <input type="text" class="form-control" id="name" name="name"  value="{{ $package->name }}" required>
    </div>
    <div class="mb-3">
        <label for="qty" class="form-label">{{ __('qty') }}</label>
        <input type="text" class="form-control" id="qty" name="qty" value="{{ $package->qty }}"  required>
    </div>
    
    <div class="mb-3">
        <label for="image" class="form-label">{{ __('Image') }}</label>
        <input type="text" class="form-control" id="image" name="image" value="{{ $package->image }}" required>
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">{{ __('Description') }}</label>
        <input type="text" class="form-control" id="description" name="description" value="{{ $package->description}}" required>
    </div>
    <div class="mb-3">
        <label for="status" class="form-label">{{ __('Status') }}</label>
        <input type="text" class="form-control" id="status" name="status" value="{{ $package->status}}"  required>
    </div>
   
    <button type="submit" class="btn btn-primary">{{ __('Create package') }}</button>
</form>

