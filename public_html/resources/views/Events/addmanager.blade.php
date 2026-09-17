<x-auth-validation-errors class="mb-4" :errors="$errors" />
<form method="post" action="{{ route('useradmin.man.addMan') }}" id="managerForm">
    @csrf

    <div class="row">
        <div class="col-md-6">
            <div class="form-group mb-3">
                <label class="form-label" for="name">{{ 'Manager Name*' }}</label>
                <x-input id="name" class="form-control" text="text-capitalize" type="text" name="name"
                    oninput="checkName()" autofocus value="{{ old('name') }}" />
                <span class="text-danger" id="nameError"></span>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group mb-3">
                <label class="form-label" for="email">{{ 'Email*' }}</label>
                <x-input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}"
                    oninput="checkEmail()" autofocus />
                <span class="text-danger" id="emailError"></span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group mb-3">
                <label class="form-label" for="mobile">{{ 'Phone Number*' }}</label>
                <x-input id="mobile" class="form-control" type="text" name="mobile" value="{{ old('mobile') }}"
                    autofocus />
                <span class="text-danger" id="mobileError"></span>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group mb-3">
                <label class="form-label" for="status">{{ 'Status' }}</label>
                <select id="status" class="form-control" name="status" autofocus>
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
                <label class="form-label" for="password">{{ 'Enter Password*' }}</label>
                <x-input id="password" class="form-control" type="text" name="password"
                    value="{{ old('password') }}" />
                <span class="text-danger" id="passwordError"></span>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group mb-3">
                <label class="form-label" for="regdate">{{ 'Register Date' }}</label>
                <x-input id="regdate" class="form-control" type="date" name="regdate" value="{{ old('regdate') }}"
                    autofocus value="{{ now()->format('Y-m-d') }}" />
            </div>
        </div>
    </div>
    <div class="d-flex mb-3 justify-content-end">
        <div class="d-grid">
            <button class="btn btn-primary btn-block mt-2 from-prevent-multiple-submits" type="submit" id="submitBtn">
                {{ 'Add Manager' }} </button>
        </div>
    </div>
    <script>
        function checkName() {
            const nameInput = document.getElementById('name');
            const nameError = document.getElementById('nameError');
            const nameValue = nameInput.value.trim();

            // Find the employee with the same name ajax call
            $.ajax({
                url: "{{ route('useradmin.man.checkmanname') }}",
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

        function checkEmail() {
            const emailInput = document.getElementById('email');
            const emailError = document.getElementById('emailError');
            const emailValue = emailInput.value.trim();

            // Find the employee with the same email ajax call
            $.ajax({
                url: "{{ route('useradmin.man.checkmanemail') }}",
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

            // Form validation on submit
            $('#managerForm').on('submit', function(e) {
                e.preventDefault();
                let isValid = true;
                $('.text-danger').text(''); // Clear previous errors

                // General field validation
                const requiredFields = ['name', 'email', 'mobile','password'];
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


                // manager name limit validation
                const name = $('#name').val().trim();
                const nameMaxLength = 255;
                const addressMaxLength = 255;

                if (name.length > nameMaxLength) {
                    $('#nameError').text(`Employee Name cannot exceed ${nameMaxLength} characters.`);
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
