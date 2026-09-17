<x-auth-validation-errors class="mb-4 text-danger" :errors="$errors" />
<form id="wastageAddForm" method="POST" action="{{ route('useradmin.equipment.wastage.update', $wastage->id) }}" enctype="multipart/form-data" data-ajax="true" >
    @csrf
    @method('PUT')
    <div class="form-group mb-3">
        <label class="form-label" for="name">{{ __('Equipment *') }}</label>
       <select name="equipment_id" id="equipment_id" class="form-control" required>
            <option value="">Select Equipment</option>
            @foreach($equipments as $item)
                <option value="{{ $item->item_id }}" {{ $item->item_id == $wastage->item_id || old('equipment_id') == $item->item_id ? 'selected' : '' }}>{{ $item->item_name }}</option>
            @endforeach
        </select>
        @error('equipment_id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="form-group mb-3">
        <label class="form-label" for="name">{{ __('Quantity *') }}</label>
        <input type="number" name="quantity" class="form-control" min="1" value="{{ old('quantity', $wastage->quantity) ?? $wastage->quantity }}" required>
        @error('quantity')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="form-group mb-3">
        <label class="form-label" for="name">{{ __('Reason *') }}</label>
        <textarea name="reason" class="form-control" cols="5" rows="4" required>{{ old('reason', $wastage->reason) ?? $wastage->reason }}</textarea>
        @error('reason')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="form-group mb-3">
        <label class="form-label" for="name">{{ __('Date of Wastage *') }}</label>
        <input type="date" name="wasted_on" class="form-control" value="{{ old('wasted_on', $wastage->wasted_on) ?? $wastage->wasted_on }}" required>
        @error('wasted_on')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="d-flex mb-3">
        <div class="d-grid">
            <button class="btn btn-primary btn-block mt-2" type="submit">{{ __('Update Wastage') }}</button>
        </div>
    </div>
</form>
<script>
 $(document).ready(function() {
    // Initialize Choices for the equipment_id dropdown
    const orderIdChoice = new Choices('#equipment_id', {
        placeholder: true,
        searchEnabled: true,
    });
})
</script>
