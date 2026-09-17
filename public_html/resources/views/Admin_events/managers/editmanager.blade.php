<form action="{{ route('useradmin.man.updates', $managers->manager_id) }}" method="POST" id="managerForm">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="emp_id">Manager_Id</label>
                <input type="text" class="form-control" id="manager_id" name="manager_id"
                    value="{{ $managers->manager_id }}" readonly>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="name">Manager Name*</label>
                <input type="text" class="form-control" id="name" name="name"
                    value="{{ $managers->name }}"oninput="checkName()" autofocus>
                <span class="text-danger" id="nameError"></span>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="email">Email*</label>
                    <input type="email" class="form-control" id="email" name="email"
                        value="{{ $managers->email }}" autofocus>
                    <span class="text-danger" id="emailError"></span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="mobile">Mobile*</label>
                    <input type="text" class="form-control" id="mobile" name="mobile"
                        value="{{ $managers->mobile }}" autofocus>
                    <span class="text-danger" id="mobileError"></span>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label class="form-label" for="status">{{ __('Status') }}</label>
                    <select id="status" class="form-control" name="status" autofocus>
                        <option value="Active" @if ($managers->status == 'Active') selected @endif>Active</option>
                        <option value="Inactive" @if ($managers->status == 'Inactive') selected @endif>Inactive</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="regdate">Reg_Date</label>
                    <input type="date" class="form-control" id="regdate" name="regdate"
                        value="{{ \Carbon\Carbon::parse($managers->regdate)->format('Y-m-d') }}" autofocus>

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

    $(document).ready(function() {

        $('#managerForm').on('submit', function(e) {





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

            // Employee name character limit validation
            const name = $('#name').val().trim();
            const nameMaxLength = 255;

            if (name.length > nameMaxLength) {
                $('#nameError').text(`Employee Name cannot exceed ${nameMaxLength} characters.`);
                isValid = false;
            }
            // If form is valid, submit it
            if (isValid) {
                this.submit();
            }


            console.log(email, name, mobile);


        });

    });
</script>
