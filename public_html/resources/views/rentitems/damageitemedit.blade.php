<x-auth-validation-errors class="mb-4" :errors="$errors" />
<form method="post" action="{{ route('useradmin.damageitem.update') }}" id="sendForm">
    @method('PUT')
    @csrf
    <input type="hidden" name="damage_id" id="damage_id" value="{{ $damageItem->id }}">
    <div class="form-group-mb-3">
        <label for="name">Item Name</label>
        <input type="text" class="form-control" id="name" name="itemName" value="{{ $damageItem->item_name }}" readonly>
    </div>
    <div class="form-group-mb-3">
        <label  for="quantity">Quantity</label>
        <input type="number" class="form-control" id="quantity" name="quantity" value="{{ $damageItem->quantity }}" max={{ $damageItem->quantity }} >
        <p class="text-danger" id="quantityError"></p>
    </div>
    <div class="form-group mb-3">
        <label for="status">Status</label>
        <select class="form-control" id="damage_status" name="damage_status">
            <option value="Fixing" {{ $damageItem->status == 'Fixing' ? 'selected' : '' }}>Fixing</option>
            <option value="Fixed" {{ $damageItem->status == 'Fixed' ? 'selected' : '' }}>Fixed</option>
        </select>
    </div>
    <div class="form-group-mb-3">
        <label for="description">Damage  Note</label>
        <textarea class="form-control" id="damage_note" name="damage_note" rows="3" maxlength="255" >{{ $damageItem->damage }}</textarea>
        @if($errors->has('damage_note'))
            <span class="text-danger">{{ $errors->first('damage_note') }}</span>
        @endif
        <p id="error-message" class="text-danger"></p>
    </div>
    <div class="d-flex mb-3">
        <div class="d-grid">
            <button class="btn btn-primary btn-block mt-2 from-prevent-multiple-submits" id="updateButton" type="submit">Update</button>
        </div>
    </div>
</form>
<script>
    function checkQuantity(validationMessageId) {
        var quantity = document.getElementById('quantity');
        var validationMessage = document.getElementById(validationMessageId);

        if (quantity.value <= 0) {
            validationMessage.textContent = "Minimum value should be 1.";
            quantity.setCustomValidity("Minimum value should be 1.");
            return true;
        }
        else if (quantity.value > quantity.max) {
            validationMessage.textContent = "Maximum value should be " + quantity.max + ".";
            quantity.setCustomValidity("Maximum value should be " + quantity.max + ".");
            return true;
        }
    }
    $(document).ready(function() {
       // Submit form on button click
       $('#updateButton').click(function() {
            // Before check validation in damage note character limit
            var damage_note = $('#damage_note').val();
            var damage_note_length = damage_note.length;
            var damage_note_limit = 255;
            if(damage_note_length > damage_note_limit) {
                $('#error-message').text('Damage Note character limit is 255');
                return false;
            }
            if( checkQuantity ('quantityError') ) {
                return false;
            }
            else {
                $('#error-message').text('');
                $('.from-prevent-multiple-submits').attr('disabled', 'true');
                $('#sendForm').submit();
            }
       })
    });
</script>


