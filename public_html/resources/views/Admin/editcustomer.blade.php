<x-auth-validation-errors class="mb-4" :errors="$errors" />
<form action="{{ route('useradmin.customer.updates', $customer->customer_id) }}" method="POST" id="customerForm">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-md-6">
            <div class="form-group mb-3">
                <label for="customer_id">Customer_Id</label>
                <input type="text" class="form-control" id="customer_id" name="customer_id" value="{{ $customer->customer_id }}" readonly>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group mb-3">
                <label for="customer_name">Customer_Name*</label>
                <input type="text" class="form-control" id="customer_name" name="customer_name" value="{{ $customer->customer_name }}" >
                <span class="text-danger" id="nameError"></span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group mb-3">
                <labe for="company_name">{{ 'Company Name' }}</label>
                <input type="text" class="form-control" id="company_name" name="company_name" value="{{ $customer->company_name }}" >
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group mb-3">
                <label for="customer_phone">Phone Number*</label>
                <input type="text" class="form-control" id="customer_phone" name="customer_phone" value="{{ $customer->customer_phone }}">
                <span class="text-danger" id="phoneError"></span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group mb-3">
                <label for="location">Location</label>
                <input type="text" class="form-control" id="location" name="location" value="{{ $customer->location }}" >
                <span class="text-danger" id="locationError"></span>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group m,b-3">
                <label for="nic">NIC</label>
                <input type="text" class="form-control" id="nic" name="nic" value="{{ $customer->nic }}" >
                <span class="text-danger" id="nicError"></span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group mb-3">
                <label for="address">Address</label>
                <input type="text" class="form-control" id="address" name="address" value="{{ $customer->address}}" >
                <span class="text-danger" id="addressError"></span>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="city">City</label>
                <input type="text" class="form-control" id="city" name="city" value="{{ $customer->city }}" >
                <span class="text-danger" id="cityError"></span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group mb-3">
                <label for="status">Status</label>
                <select class="form-control" id="status" name="status">
                    <option value="active" {{ $customer->status == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ $customer->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="points">Points</label>
                <input type="text" class="form-control" id="points" name="points" value="{{ $customer->points }}">
                <span class="text-danger" id="pointsError"></span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group mb-3">
                <label for="register_date">Register Date</label>
                <input type="date" class="form-control" id="register_date" name="register_date" value="{{ $customer->register_date }}">
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-primary from-prevent-multiple-submits">Update</button>
</form>
<script>
    $('#customerForm').on('submit', function(e) {
        e.preventDefault();
        let isValid = true;

        // Clear previous errors
        $('.text-danger').text('');

        // Validate Customer Name
        if ($('#customer_name').val().trim() === '') {
            $('#nameError').text('Customer Name is required.');
            isValid = false;
        }
        // Character validation customer name
        const name = $('#customer_name').val().trim();
        const nameMaxLength = 255;
        if (name.length > nameMaxLength) {
            $('#nameError').text(`Customer Name cannot exceed ${nameMaxLength} characters.`);
            isValid = false;
        }
        // Character validation location
        const location = $('#location').val().trim();
        const locationMaxLength = 255;
        if (location.length > locationMaxLength) {
            $('#locationError').text(`Location cannot exceed ${locationMaxLength} characters.`);
            isValid = false;
        }

        // Character validation address
        const address = $('#address').val().trim();
        const addressMaxLength = 255;
        if (address.length > addressMaxLength) {
            $('#addressError').text(`Address cannot exceed ${addressMaxLength} characters.`);
            isValid = false;
        }

        // Character validation city
        const city = $('#city').val().trim();
        const cityMaxLength = 255;
        if (city.length > cityMaxLength) {
            $('#cityError').text(`City cannot exceed ${cityMaxLength} characters.`);
            isValid = false;
        }

        // Character validation points
        const points = $('#points').val().trim();
        const pointsMaxLength = 255;
        if (points.length > pointsMaxLength) {
            $('#pointsError').text(`Points cannot exceed ${pointsMaxLength} characters.`);
            isValid = false;
        }

        // Validate Phone Number
        const mobile = $('#customer_phone').val().trim();
        const mobilePattern = /^[0-9]{10}$/;
        if (mobile === '') {
            $('#phoneError').text('Phone Number is required.');
            isValid = false;
        } else if (!mobilePattern.test(mobile)) {
            $('#phoneError').text('Please enter a valid 10-digit phone number.');
            isValid = false;
        }

        // Validate NIC
        const nic = $('#nic').val().trim();
        const nicPattern = /^(\d{9}[VX]|\d{12})$/; // Pattern for old and new NIC formats
        if( nic ) {

            if (!nicPattern.test(nic)) {
                $('#nicError').text('Please enter a valid NIC (9 digits + V/X or 12 digits).');
                isValid = false;
            }
        }

        // If form is valid, submit it
        if (isValid) {
            $('.from-prevent-multiple-submits').attr('disabled', 'true');
            this.submit();
        }
    });
</script>
