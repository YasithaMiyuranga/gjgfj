<x-auth-validation-errors class="mb-4 text-danger" :errors="$errors" />
<form id="wastageAddForm" method="POST" action="{{ route('useradmin.equipment.wastage.store') }}" enctype="multipart/form-data" data-ajax="true" >
    @csrf
    <div class="form-group">
        <label for="equipment_id">Equipment</label>
        <select name="equipment_id" id="equipment_id" class="form-control" required>
            <option value="">Select Equipment</option>
            @foreach($equipments as $item)
                <option value="{{ $item->item_id }}">{{ $item->item_name }}</option>
            @endforeach
        </select>
        @error('equipment_id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="form-group">
        <label for="quantity">Quantity</label>
        <input type="number" name="quantity" class="form-control" min="1" required>
    </div>
    @error('quantity')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
    <div class="form-group">
        <label for="reason">Reason</label>
        <textarea name="reason" class="form-control" cols="5" rows="4"></textarea>
        @error('reason')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
   <div class="form-group">
       <label for="wasted_on">Date of Wastage</label>
       <input type="date" name="wasted_on" class="form-control" value="{{ date('Y-m-d') }}" required>
       @error('wasted_on')
           <span class="invalid-feedback" role="alert">
               <strong>{{ $message }}</strong>
           </span>
       @enderror
   </div>
    <button type="submit" class="btn btn-primary">Submit</button>
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


