<form action="{{ route('useradmin.stockitem.update', $items->item_id) }}" method="POST" enctype="multipart/form-data" data-ajax="true">
    @csrf
    @method('PUT')

    @php
    $user = Auth::user();
    @endphp
    <input type="hidden" id="item_id" name="item_id" value="{{ $items->item_id }}">
    <input type="hidden" id="previous_total_stock" name="previous_total_stock" value="{{ $items->total_stock }}">
    <input type="hidden" id="updated_by" name="updated_by" value="{{$user->id}}">
    <input type="hidden" id="updated_at" name="updated_at" value="{{ date('Y-m-d H:i:s') }}">
    <div class="form-group">
        <label for="item_name">Item Name*</label>
        <input type="text" class="form-control" id="item_name" name="item_name" value="{{ $items->item_name }}"
            onkeypress="validateInputLength(this, 40)" required>
    </div>
    <div class="form-group">
        <label for="total_stock">Total Stock*</label>
        <input type="number" max=10000 min=0 class="form-control" id="total_stock" name="total_stock"
            value="{{ $items->total_stock }}" pattern="\d*" oninput="validateQuantity(this, 'totalValidationMessage')"
            onkeypress="validateInputLength(this, 5)" required>
        <p id="totalValidationMessage" style="color: red;"></p>
    </div>
    <div class="form-group">
        <label for="in_stock">In Stock*</label>
        <input type="number" max=10000 min=0 class="form-control" id="in_stock" name="in_stock"
            value="{{ $items->in_stock }}" pattern="\d*" oninput="validateQuantity(this, 'instockValidationMessage')"
            onkeypress="validateInputLength(this, 4)" required readonly>
        <p id="instockValidationMessage" style="color: red;"></p>
    </div>
    <div class="form-group">
        <label for="out_stock">Out Stock*</label>
        <input type="number" max=10000 min=0 class="form-control" id="out_stock" name="out_stock"
            value="{{ $items->out_stock }}" pattern="\d*" oninput="validateQuantity(this, 'outstockValidationMessage')"
            onkeypress="validateInputLength(this, 4)" required readonly>
        <p id="outstockValidationMessage" style="color: red;"></p>
    </div>
    <div class="form-group">
        <label for="rent_price">Rent Price*</label>
        <input type="number" max=1000000 min=0 class="form-control" id="rent_price" name="rent_price"
            value="{{ $items->rent_price }}" pattern="\d*" oninput="validateQuantity(this, 'rentValidationMessage')"
            onkeypress="validateInputLength(this, 6)" required>
        <p id="rentValidationMessage" style="color: red;"></p>
    </div>
    <div class="form-group">
        <label for="product_amount">Product Price*</label>
        <input type="number" max=1000000 min=0 class="form-control" id="product_amount" name="product_amount"
            value="{{ $items->product_amount }}" pattern="\d*"
            oninput="validateQuantity(this, 'amountValidationMessage')" onkeypress="validateInputLength(this, 7)"
            required>
        <p id="amountValidationMessage" style="color: red;"></p>
    </div>
    <div class="form-group">
        <label for="category">Category*</label>
        <select class="form-control" id="category" name="category" required>
            <option value="">Select Category</option>
            @foreach( $categories as $category)
            <option value="{{ $category->name }}" {{ ($items->category == $category->name || old('category') == $category->name )? 'selected' : ''}}>{{ $category->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="status">Status*</label>
        <select class="form-control" id="status" name="status" required>
            <option value="Available" {{ $items->status == 'Available' ? 'selected' : '' }}>Available</option>
            <option value="Unavailable" {{ $items->status == 'Unavailable' ? 'selected' : '' }}>Unavailable</option>
        </select>
    </div>

    <div class="form-group">
        <label for="description">Description</label>
        <textarea class="form-control" id="description" name="description" rows="3" maxlength="255"
            onkeypress="validateInputLength(this, 255)">{{ $items->description }}</textarea>
    </div>

    <div class="form-group">
        <label for="visible_to_customer">Visible to Customer*</label>
        <select class="form-control" id="visible_to_customer" name="visible_to_customer" required>
            <option value="Yes" {{ $items->visible_to_customer == 'Yes' ? 'selected' : '' }}>Yes</option>
            <option value="No" {{ $items->visible_to_customer == 'No' ? 'selected' : '' }}>No</option>
        </select>
    </div>

    <div class="form-group">
        <label for="item_type">Item Type*</label>
        <select class="form-control" id="item_type" name="item_type" required>
            <option value="internal" {{ $items->item_type == 'internal' ? 'selected' : '' }}>Internal</option>
            <option value="external" {{ $items->item_type == 'external' ? 'selected' : '' }}>External</option>
        </select>
    </div>

    <div class="form-group">
        <label for="image">Image (Max 5MB)</label>
        <input type="file" class="form-control" id="image" name="image" value="{{ $items->image }}" accept="jpeg,png,webp,jpg,gif,svg">
        <img src="{{ asset($items->image) }}" alt="Image" width="150" height="150">
    </div>


    <button type="submit" class="btn btn-primary">Update</button>
</form>

<script>
    //Validate Input Length
    function validateInputLength(input, maxLength) {
        var inputValue = input.value.toString();
        if (inputValue.length > maxLength) {
            input.value = inputValue.slice(0, maxLength);
        }
    }

    //Validate Quantity
    function validateQuantity(input, validationMessageId) {
        var quantity = input.value;
        var validationMessage = document.getElementById(validationMessageId);

        if (quantity < 0) {
            validationMessage.textContent = "Minimum value should be 0.";
            input.setCustomValidity("Minimum value should be 0.");
            input.value = '';
        } else {
            validationMessage.textContent = "";
            input.setCustomValidity("");
        }
        if (quantity > 10000000) {
            input.value = 10000000;
            validationMessage.textContent = "Maximum value should be 10000000.";
            input.setCustomValidity("Maximum value should be 10000000.");
        }
    }

    var initial_stock = $('#in_stock').val();
    initial_stock = parseInt(initial_stock);

    $('#total_stock').on('input', function() {
        var total_stock = $(this).val();
        total_stock = parseInt(total_stock);
        var in_stock = $('#in_stock').val();
        in_stock = parseInt(in_stock);
        var out_stock = $('#out_stock').val();
        out_stock = parseInt(out_stock);

        $('#in_stock').val(total_stock - out_stock);
    });
</script>
