<form action="{{ route('useradmin.supplier.update') }}" method="post" id="supplierForm">
    @csrf
    @method('PUT')
    <input type="hidden" id="supplier_id" name="supplier_id" value="{{ $supplier->id }}">
    <div class="form-group">
        <label for="supplier_name">Supplier Name*</label>
        <input type="text" class="form-control" id="supplier_name" name="supplier_name"
             value="{{ $supplier->supplier_name }}" required >
        <span class="text-danger" id="nameError"></span>
    </div>
    <div class="form-group">
        <label for="supplier_contact">Contact Number*</label>
        <input type="text" class="form-control" id="supplier_contact" name="supplier_contact" maxlength="10"
             value="{{ $supplier->contact_number }}">
        <span class="text-danger" id="phoneError"></span>
    </div>
    <div class="form-group">
        <label for="supplier_city">City*</label>
        <input type="text" class="form-control" id="supplier_city" name="supplier_city"
            value="{{ $supplier->city }}">
        <span class="text-danger" id="cityError"></span>
    </div>
    <div class="form-group">
        <label for="supplier_address">Supplier Address*</label>
        <textarea class="form-control" id="supplier_address" name="supplier_address"
            >{{ $supplier->address }}</textarea>
        <span class="text-danger" id="addressError" ></span>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id="closeModal" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Update Supplier</button>
    </div>
</form>

<script>
    // Close modal when clicking the close button
    $('#closeModal').click(function() {
        $('#commanModel').modal('hide');
    });

    // Form validation
    document.getElementById('supplierForm').addEventListener('submit', function(e) {
        e.preventDefault();
        let isValid = true;

        // Clear previous error messages
        document.querySelectorAll('.text-danger').forEach(el => el.textContent = '');

        // Validate each field
        const fields = [{
                id: 'supplier_name',
                errorId: 'nameError',
                message: 'Supplier name is required.'
            },
            {
                id: 'supplier_contact',
                errorId: 'phoneError',
                message: 'Contact number is required.'
            },
            {
                id: 'supplier_city',
                errorId: 'cityError',
                message: 'City is required.'
            },
            {
                id: 'supplier_address',
                errorId: 'addressError',
                message: 'Address is required.'
            }
        ];

        fields.forEach(field => {
            const inputElement = document.getElementById(field.id);
            if (!inputElement.value.trim()) {
                document.getElementById(field.errorId).textContent = field.message;
                isValid = false;
            }
        });

        // Additional validation for Contact Number
        const contactNumber = document.getElementById('supplier_contact').value.trim();
        const phonePattern = /^[0-9]{10}$/;
        if (contactNumber && !phonePattern.test(contactNumber)) {
            document.getElementById('phoneError').textContent = 'Please enter a valid 10-digit phone number.';
            isValid = false;
        }

        //supplier_name  validation for max length  255
        const supplierName = document.getElementById('supplier_name').value.trim();
        if (supplierName.length > 255 ) {
            document.getElementById('nameError').textContent = 'Supplier name  should not exceed 255 characters.';
            isValid = false;
        }

        // supplier_city validation for max length  255
        const supplierCity = document.getElementById('supplier_city').value.trim();
        if (supplierCity.length > 255) {
            document.getElementById('cityError').textContent = 'Supplier city should not exceed 255 characters.';
            isValid = false;
        }

        //adress validation for max length 255
        const supplierAddress = document.getElementById('supplier_address').value.trim();
        if (supplierAddress.length > 255) {
            document.getElementById('addressError').textContent =
                'Supplier address should not exceed 255 characters.';
            isValid = false;
        }

        // If all validations pass, submit the form
        if (isValid) {
            this.submit();
        }
    });
</script>
