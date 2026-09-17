<x-auth-validation-errors class="mb-4" :errors="$errors" />
<form action="{{ route('useradmin.stockitem.add') }}" method="post" enctype="multipart/form-data" data-ajax="true">
    @csrf
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="item_name" class="form-label">{{ ('Item Name*') }}</label>
                <x-input id="item_name" class="form-control" type="text" name="item_name"
                    onkeypress="validateInputLength(this, 40)" required value="{{ old('item_name') }}" />
                    <p id="nameError" style="color: red;"></p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="total_stock" class="form-label">{{ ('Total Stock*') }}</label>
                <x-input id="total_stock" class="form-control" type="number" max=10000 min=0 name="total_stock"
                    pattern="\d*" oninput="validateQuantity(this, 'totalValidationMessage')"
                    onkeypress="validateInputLength(this, 5)" required  value="{{ old('total_stock') }}"/>
                <p id="totalValidationMessage" style="color: red;"></p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="in_stock" class="form-label">{{ ('In Stock*') }}</label>
                <x-input id="in_stock" class="form-control" type="number" max=10000 min=0 name="in_stock"
                    pattern="\d*" oninput="validateQuantity(this, 'instockValidationMessage')"
                    onkeypress="validateInputLength(this, 4)" required  value="{{ old('in_stock') }}"/>
                <p id="instockValidationMessage" style="color: red;"></p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="out_stock" class="form-label">{{ ('Out Stock*') }}</label>
                <x-input id="out_stock" class="form-control" type="number" max=10000 min=0 name="out_stock"
                    pattern="\d*" oninput="validateQuantity(this, 'outstockValidationMessage')"
                    onkeypress="validateInputLength(this, 4)" required value="{{ old('out_stock') }}" />
                <p id="outstockValidationMessage" style="color: red;"></p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="rent_price" class="form-label">{{ ('Rent Price*') }}</label>
                <x-input id="rent_price" class="form-control" type="number" max=1000000 min=0 name="rent_price"
                    pattern="\d*" oninput="validateQuantity(this, 'rentValidationMessage')"
                    onkeypress="validateInputLength(this, 6)" required  value="{{ old('rent_price') }}"/>
                <p id="rentValidationMessage" style="color: red;"></p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="product_amount" class="form-label">{{ ('Product Price*') }}</label>
                <x-input id="product_amount" class="form-control" type="number" max=10000000 min=0
                    name="product_amount" pattern="\d*" oninput="validateQuantity(this, 'amountValidationMessage')"
                    onkeypress="validateInputLength(this, 7)" required  value="{{ old('product_amount') }}"/>
                <p id="amountValidationMessage" style="color: red;"></p>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="category" class="form-label">{{ ('Category*') }}</label>
                <select id="category" class="form-control" name="category" required >
                    @foreach( $categories as $category)
                    <option value="{{ $category->name }}" {{ (old('category') == $category->name) ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="status" class="form-label">{{ ('Status*') }}</label>
                <select id="status" class="form-control" name="status" required >
                    <option value="Available" {{ old('status') == 'Available' ? 'selected' : ''}}>Available</option>
                    <option value="Unavailable" {{ old('status') == 'Unavailable' ? 'selected' : ''}}>Unavailable</option>
                    <option value="Damaged" {{ old('status') == 'Damaged' ? 'selected' : ''}}>Damaged</option>
                </select>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="visible_to_customer" class="form-label">{{ ('Visible to Customer*') }}</label>
                <select id="visible_to_customer" class="form-control" name="visible_to_customer" required>
                    <option value="No" {{ old('visible_to_customer') == 'No' ? 'selected' : ''}}>No</option>
                    <option value="Yes" {{ old('visible_to_customer') == 'Yes' ? 'selected' : ''}}>Yes</option>
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="item_type" class="form-label">{{ ('Item Type*') }}</label>
                <select id="item_type" class="form-control" name="item_type" required>
                    <option value="internal" {{ old('item_type') == 'internal' ? 'selected' : ''}}>Internal</option>
                    <option value="external" {{ old('item_type') == 'external' ? 'selected' : ''}}>External</option>
                </select>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="description" class="form-label">{{ ('Description') }}</label>
                <textarea id="description" class="form-control" name="description" rows="3" value="{{ old('description') }}" ></textarea>
                <p id="descriptionValidationMessage" style="color: red;"></p>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="image" class="form-label">{{ ('Image (Max 5MB)') }}</label>
                <input type="file" class="form-control" name="image" value="{{ old('image') }}" accept="jpeg,png,webp,jpg,gif,svg"/>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id="closeModal" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="submitBtn">Add Item</button>
    </div>
</form>
<script>
   //Validate Description
   function validateLength() {
        var maxLength = 255;

        // Get current lengths
        var descriptionLength = document.getElementById('description').value.length;
        var nameLength = document.getElementById('item_name').value.length;

        // Reset error messages
        document.getElementById('descriptionValidationMessage').innerHTML = '';
        document.getElementById('nameError').innerHTML = '';

        // Validate description length
        if (descriptionLength > maxLength) {
            document.getElementById('descriptionValidationMessage').innerHTML = 'Maximum length of 255 characters exceeded';
            return false;
        }

        // Validate item name length
        if (nameLength > maxLength) {
            document.getElementById('nameError').innerHTML = 'Maximum length of 255 characters exceeded';
            return false;
        }

        return true; // All validations passed
    }

    //Close modal when click close button
    $('#closeModal').click(function() {
        $('#commanModel').modal('hide');
    });

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

    $('#total_stock').change(function() {
        var total_stock = $('#total_stock').val();
        total_stock = parseInt(total_stock);
        $('#in_stock').val(total_stock);
        $('#out_stock').val(0);
    });

    $('#in_stock').change(function() {
        var in_stock = $('#in_stock').val();
        in_stock = parseInt(in_stock);
        var total_stock = $('#total_stock').val();
        total_stock = parseInt(total_stock);
        if (in_stock < 0) {
            $('#in_stock').val(0);
            $('#out_stock').val(total_stock);
        }
        if (total_stock == '') {
            $('#total_stock').val(in_stock);
            total_stock = in_stock;
        }
        if (in_stock > total_stock) {
            $('#in_stock').val(total_stock);
            $('#out_stock').val(0);
        } else {
            $('#out_stock').val(total_stock - in_stock);
        }
    });

    $('#out_stock').change(function() {
        var out_stock = $('#out_stock').val();
        out_stock = parseInt(out_stock);
        var total_stock = $('#total_stock').val();
        total_stock = parseInt(total_stock);
        if (out_stock < 0) {
            $('#out_stock').val(0);
            $('#in_stock').val(total_stock);
        }
        if (total_stock == '') {
            $('#total_stock').val(out_stock);
            total_stock = out_stock;
        }
        if (out_stock > total_stock) {
            $('#out_stock').val(total_stock);
            $('#in_stock').val(0);
        }
        else {
            $('#in_stock').val(total_stock - out_stock);
        }
    });

    // Check before submit description
    $('#submitBtn').click(function() {
        if(validateLength())
        {
            return true;
        }
        else
        {
            return false;
        }
    });
</script>
