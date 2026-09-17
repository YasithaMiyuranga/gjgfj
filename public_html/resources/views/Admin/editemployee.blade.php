<form action="{{ route('useradmin.emp.updates', $employes->emp_id) }}" method="POST" id="employeeForm">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="emp_id">Emp_Id</label>
                <input type="text" class="form-control" id="emp_id" name="emp_id" value="{{ $employes->emp_id }}"
                    readonly>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="name">Emp_Name*</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $employes->name }}"oninput="checkName()"
                    autofocus>
                <span class="text-danger" id="nameError"></span>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="email">Email*</label>
                    <input type="email" class="form-control" id="email" name="email"
                        value="{{ $employes->email }}" autofocus>
                    <span class="text-danger" id="emailError"></span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="mobile">Mobile*</label>
                    <input type="text" class="form-control" id="mobile" name="mobile"
                        value="{{ $employes->mobile }}" autofocus>
                    <span class="text-danger" id="mobileError"></span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="address">Address*</label>
                    <input type="text" class="form-control" id="address" name="address"
                        value="{{ $employes->address }}" autofocus>
                    <span class="text-danger" id="addressError"></span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="nic">Nic*</label>
                    <input type="text" class="form-control" id="nic" name="nic"
                        value="{{ $employes->nic }}" autofocus>
                    <span class="text-danger" id="nicError"></span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label class="form-label" for="emp_type">{{ __('Employee Type') }}</label>
                    <select id="emp_type" class="form-control" name="emp_type" autofocus>
                        <option value="Day Salary Employee" @if ($employes->emp_type == 'Day Salary Employee') selected @endif>Day Salary
                            Employee</option>
                        <option value="Permanent Employee" @if ($employes->emp_type == 'Permanent Employee') selected @endif>Permanent
                            Employee</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="code">Code*</label>
                    <input type="text" class="form-control" id="code" name="code"
                        value="{{ $employes->code }}" autofocus>
                    <span class="text-danger" id="codeError"></span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="basic_amount">Basic_Amount*</label>
                    <input type="text" class="form-control" id="basic_amount" name="basic_amount"
                        value="{{ $employes->basic_amount }}">
                    <span class="text-danger" id="basic_amountError"></span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="epf">{{ __('EPF(Employer Contribution*)') }}</label>
                    <input type="text" class="form-control" id="epf" name="epf"
                        value="{{ $employes->epf }}">
                    <span class="text-danger" id="epfError"></span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="etf">{{ __('ETF(Employer Contribution*)') }}</label>
                    <input type="text" class="form-control" id="etf" name="etf"
                        value="{{ $employes->etf }}">
                    <span class="text-danger" id="etfError"></span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="epf_employee">{{ __('EPF(Employee Contribution*)') }}</label>
                    <input type="text" class="form-control" id="epf_employee" name="epf_employee"
                        value="{{ $employes->employee_epf }}">
                    <span class="text-danger" id="epf_employeeError"></span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label class="form-label" for="active">{{ __('Active') }}</label>
                    <select id="active" class="form-control" name="active" autofocus>
                        <option value="Active" @if ($employes->active == 'Active') selected @endif>Active</option>
                        <option value="Inactive" @if ($employes->active == 'Inactive') selected @endif>Inactive</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="regdate">Reg_Date</label>
                    <input type="date" class="form-control" id="regdate" name="regdate"
                        value="{{ $employes->regdate }}" autofocus>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="password">Password(Optional)</label>
                    <input type="text" class="form-control" id="password" name="password">
                    <span class="text-danger" id="passwordError"></span>
                </div>
            </div>
        </div>
        <div class="d-flex mb-3 justify-content-end">
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </div>
    </div>
</form>
<script>
    function checkName() {
            const nameInput = document.getElementById('name');
            const nameError = document.getElementById('nameError');
            const nameValue = nameInput.value.trim();

            // Find the employee with the same name ajax call
            $.ajax({
                url: "{{ route('useradmin.emp.checkempname') }}",
                method: "POST",
                data: {
                    name: nameValue,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    if (response.exists) {
                        nameError.textContent = "Name already exists.";

                    } else {
                        nameError.textContent = "";

                    }
                }
            })

    }
    //*** Function to enable/disable basic_amount,etf,epf when load
    function checkEmployeeType() {
        var emp_id = $(emp_type).val();

        if (emp_id == 'Day Salary Employee') {
            $('#basic_amount').prop('disabled', true).closest('.form-group').hide();
            $('#etf').prop('disabled', true).closest('.form-group').hide();
            $('#epf').prop('disabled', true).closest('.form-group').hide();
            $('#epf_employee').prop('disabled', true).closest('.form-group').hide();
        } else {
            $('#basic_amount').prop('disabled', false).closest('.form-group').show();
            $('#etf').prop('disabled', false).closest('.form-group').show();
            $('#epf').prop('disabled', false).closest('.form-group').show();
            $('#epf_employee').prop('disabled', false).closest('.form-group').show();
        }
    }
    $(document).ready(function() {

        //*** Enable/disable basic_amount,etf,epf
        checkEmployeeType();

        // when change employee type
        $('#emp_type').on('change', function() {
            var emp_id = $(this).val();
            if (emp_id == 'Day Salary Employee') {
                $('#basic_amount').prop('disabled', true).closest('.form-group').hide();
                $('#etf').prop('disabled', true).closest('.form-group').hide();
                $('#epf').prop('disabled', true).closest('.form-group').hide();
                $('#epf_employee').prop('disabled', true).closest('.form-group').hide();
            } else {
                $('#basic_amount').prop('disabled', false).closest('.form-group').show();
                $('#etf').prop('disabled', false).closest('.form-group').show();
                $('#epf').prop('disabled', false).closest('.form-group').show();
                $('#epf_employee').prop('disabled', false).closest('.form-group').show();
            }
        });
        $('#employeeForm').on('submit', function(e) {
            e.preventDefault();
            let isValid = true;

            // Clear previous errors
            $('.text-danger').text('');

            // Validate Email
            const email = $('#email').val().trim();
            const emailPattern = /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/;
            if (email === '') {
                $('#emailError').text('Email is required.');
                isValid = false;
            } else if (!emailPattern.test(email)) {
                $('#emailError').text('Please enter a valid email address.');
                isValid = false;
            }

            // Validate Phone Number
            const mobile = $('#mobile').val().trim();
            const mobilePattern = /^[0-9]{10}$/;
            if (mobile === '') {
                $('#mobileError').text('Phone Number is required.');
                isValid = false;
            } else if (!mobilePattern.test(mobile)) {
                $('#mobileError').text('Please enter a valid 10-digit phone number.');
                isValid = false;
            }

            // Validate NIC
            const nic = $('#nic').val().trim();
            const nicPattern = /^(\d{9}[VX]|\d{12})$/; // Pattern for old and new NIC formats
            if (nic === '') {
                $('#nicError').text('NIC is required.');
                isValid = false;
            } else if (!nicPattern.test(nic)) {
                $('#nicError').text('Please enter a valid NIC (9 digits + V/X or 12 digits).');
                isValid = false;
            }

            // Validate other fields
            const fields = ['address', 'nic', 'code'];
            fields.forEach(field => {
                if ($('#' + field).val().trim() === '') {
                    $('#' + field + 'Error').text(field.charAt(0).toUpperCase() + field.slice(
                        1) + ' is required.');
                    isValid = false;
                }
            });

            // Additional validation for Permanent Employees
            if ($('#emp_type').val() === 'Permanent Employee') {
                const requiredPermanentFields = ['basic_amount', 'etf', 'epf', 'epf_employee'];
                requiredPermanentFields.forEach(field => {
                    if ($('#' + field).val().trim() === '') {
                        $('#' + field + 'Error').text(
                            'This field is required for permanent employees.');
                        isValid = false;
                    }
                });
            }

            // Additional validation for Permanent Employees
            if ($('#emp_type').val() === 'Permanent Employee') {
                const requiredPermanentFields = ['basic_amount', 'etf', 'epf', 'epf_employee'];
                requiredPermanentFields.forEach(field => {
                    const fieldValue = $('#' + field).val().trim();

                    // Check if field is empty
                    if (fieldValue === '') {
                        $('#' + field + 'Error').text(
                            'This field is required for permanent employees.');
                        isValid = false;
                    }

                    // Basic Amount validation (double(10,2))
                    if (field === 'basic_amount' && fieldValue) {
                        const basicAmountPattern =
                            /^\d{1,8}(\.\d{1,2})?$/; // Allow up to 10 digits with 2 decimal places
                        if (!basicAmountPattern.test(fieldValue)) {
                            $('#basic_amountError').text(
                                'Basic Amount must be a valid number with up to 8 digits and 2 decimal places.'
                            );
                            isValid = false;
                        }
                    }

                    // etf', 'epf', 'epf_employee can add maxximum 100 and minimum 0
                    if (field === 'etf' || field === 'epf' || field === 'epf_employee') {
                        const amountPattern =
                            /^\d{1,2}(\.\d{1,2})?$/; // Allow up to 3 digits with 2 decimal places
                        if (fieldValue && !amountPattern.test(fieldValue)) {
                            $('#' + field + 'Error').text(
                                'Please enter a valid amount (up to 2 digits and 2 decimal places).'
                            );
                            isValid = false;
                        }
                    }

                });
            }
            // Employee name/address character limit validation
            const name = $('#name').val().trim();
            const address = $('#address').val().trim();
            const nameMaxLength = 255;
            const addressMaxLength = 255;

            if (name.length > nameMaxLength) {
                $('#nameError').text(`Employee Name cannot exceed ${nameMaxLength} characters.`);
                isValid = false;
            }

            if (address.length > addressMaxLength) {
                $('#addressError').text(`Address cannot exceed ${addressMaxLength} characters.`);
                isValid = false;
            }

            // If form is valid, submit it
            if (isValid) {
                this.submit();
            }
        });

    });
</script>
