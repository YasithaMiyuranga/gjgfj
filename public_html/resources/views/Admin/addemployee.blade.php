<x-auth-validation-errors class="mb-4" :errors="$errors" />
<form method="post" action="{{ route('useradmin.emp.store') }}" id="employeeForm">
    @csrf
    <input type="hidden" name="created_by" value="admin">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group mb-3">
                <label class="form-label" for="name">{{ ('Employee Name*') }}</label>
                <x-input id="name" class="form-control" text="text-capitalize" type="text" name="name" oninput="checkName()"
                    autofocus value="{{ old('name') }}" />
                <span class="text-danger" id="nameError"></span>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group mb-3">
                <label class="form-label" for="email">{{ ('Email*') }}</label>
                <x-input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}" oninput="checkEmail()"
                    autofocus />
                <span class="text-danger" id="emailError"></span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group mb-3">
                <label class="form-label" for="mobile">{{ ('Phone Number*') }}</label>
                <x-input id="mobile" class="form-control" type="text" name="mobile" value="{{ old('mobile') }}"
                    autofocus />
                <span class="text-danger" id="mobileError"></span>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group mb-3">
                <label class="form-label" for="address">{{ ('Address*') }}</label>
                <x-input id="address" class="form-control" type="text" name="address" value="{{ old('address') }}"
                    autofocus />
                <span class="text-danger" id="addressError"></span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group mb-3">
                <label class="form-label" for="nic">{{ ('Nic*') }}</label>
                <x-input id="nic" class="form-control" type="text" name="nic" value="{{ old('nic') }}"
                    autofocus />
                <span class="text-danger" id="nicError"></span>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group mb-3">
                <label class="form-label" for="emp_type">{{ ('Employee Type') }}</label>
                <select id="emp_type" class="form-control" name="emp_type" autofocus>
                    <option value="Permanent Employee" {{ old('emp_type') == 'Permanent Employee' ? 'selected' : '' }}>
                        Permanent Employee</option>
                    <option value="Day Salary Employee"
                        {{ old('emp_type') == 'Day Salary Employee' ? 'selected' : '' }}>Day Salary Employee</option>
                </select>
                <span class="text-danger" id="empTypeError"></span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group mb-3" style="display: show">
                <label class="form-label" for="basic_amount">{{ ('Basic Amount*') }}</label>
                <x-input id="basic_amount" name="basic_amount" class="form-control" type="text"
                    value="{{ old('basic_amount') }}" autofocus />
                <span class="text-danger" id="basic_amountError"></span>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group mb-3" style="display: show">
                <label class="form-label" for="epf">{{ ('EPF(Employer Contribution)*') }}</label>
                <x-input id="epf" name="epf" class="form-control" type="text" value="{{ old('epf') }}"
                    autofocus />
                <span class="text-danger" id="epfError"></span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group mb-3" style="display: show">
                <label class="form-label" for="etf">{{ ('ETF(Employer Contribution)*') }}</label>
                <x-input id="etf" name="etf" class="form-control" type="text"
                    value="{{ old('etf') }}" autofocus />
                <span class="text-danger" id="etfError"></span>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group mb-3" style="display: show">
                <label class="form-label" for="epf_employee">{{ ('EPF(Employee Contribution)*') }}</label>
                <x-input id="epf_employee" name="epf_employee" class="form-control" type="text"
                    value="{{ old('epf_employee') }}" autofocus />
                <span class="text-danger" id="epf_employeeError"></span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group mb-3">
                <label class="form-label" for="code">{{ ('Enter Code*') }}</label>
                <x-input id="code" class="form-control" type="text" name="code"
                    value="{{ old('code') }}" autofocus />
                <span class="text-danger" id="codeError"></span>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group mb-3">
                <label class="form-label" for="active">{{ ('Status') }}</label>
                <select id="active" class="form-control" name="active" autofocus>
                    <option value="Active" {{ old('active') == 'Active' ? 'selected' : '' }}>Active</option>
                    <option value="Inactive" {{ old('active') == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
                <span class="text-danger" id="statusError"></span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group mb-3">
                <label class="form-label" for="password">{{ ('Enter Password*') }}</label>
                <x-input id="password" class="form-control" type="text" name="password"
                    value="{{ old('password') }}" />
                <span class="text-danger" id="passwordError"></span>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group mb-3">
                <label class="form-label" for="regdate">{{ ('Register Date') }}</label>
                <x-input id="regdate" class="form-control" type="date" name="regdate"
                    value="{{ old('regdate') }}" autofocus value="{{ now()->format('Y-m-d') }}" />
            </div>
        </div>
    </div>
    <div class="d-flex mb-3 justify-content-end">
        <div class="d-grid">
            <button class="btn btn-primary btn-block mt-2 from-prevent-multiple-submits" type="submit"
                id="submitBtn"> {{ ('Add Employee') }} </button>
        </div>
    </div>
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

        function checkEmail () {
            const emailInput = document.getElementById('email');
            const emailError = document.getElementById('emailError');
            const emailValue = emailInput.value.trim();

            // Find the employee with the same email ajax call
            $.ajax({
                url: "{{ route('useradmin.emp.checkempemail') }}",
                method: "POST",
                data: {
                    email: emailValue,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    if (response.exists) {
                        emailError.textContent = "Email already exists.";

                    } else {
                        emailError.textContent = "";

                    }
                }
            })
        }
        $(document).ready(function() {

            // Toggle fields based on Employee Type
            $('#emp_type').on('change', function() {
                const empType = $(this).val();
                if (empType === 'Day Salary Employee') {
                    $('#basic_amount, #etf, #epf, #epf_employee')
                        .prop('disabled', true)
                        .closest('.form-group')
                        .hide();
                } else {
                    $('#basic_amount, #etf, #epf, #epf_employee')
                        .prop('disabled', false)
                        .closest('.form-group')
                        .show();
                }
            });

            // Form validation on submit
            $('#employeeForm').on('submit', function(e) {
                e.preventDefault();
                let isValid = true;
                $('.text-danger').text(''); // Clear previous errors

                // General field validation
                const requiredFields = ['name', 'email', 'mobile', 'nic', 'address', 'code', 'password'];
                requiredFields.forEach(field => {
                    if ($('#' + field).val().trim() === '') {
                        $('#' + field + 'Error').text(field.charAt(0).toUpperCase() + field.slice(
                            1) + ' is required.');
                        isValid = false;
                    }
                });

                // Email validation
                const email = $('#email').val().trim();
                const emailPattern = /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/;
                if (email && !emailPattern.test(email)) {
                    $('#emailError').text('Please enter a valid email address.');
                    isValid = false;
                }

                // Phone number validation
                const mobile = $('#mobile').val().trim();
                const mobilePattern = /^[0-9]{10}$/; // Validates exactly 10 digits
                if (mobile && !mobilePattern.test(mobile)) {
                    $('#mobileError').text('Please enter a valid 10-digit phone number.');
                    isValid = false;
                }

                // NIC validation
                const nic = $('#nic').val().trim();
                const nicPattern =
                /^(\d{9}[VX]|\d{12})$/; // Pattern for old (9 digits + V/X) or new (12 digits) NIC formats
                if (nic && !nicPattern.test(nic)) {
                    $('#nicError').text('Please enter a valid NIC (9 digits + V/X or 12 digits).');
                    isValid = false;
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

                // Final submission if valid
                if (isValid) {
                    $('.from-prevent-multiple-submits').attr('disabled', 'true');
                    this.submit();
                }
            });
        });
    </script>
</form>
