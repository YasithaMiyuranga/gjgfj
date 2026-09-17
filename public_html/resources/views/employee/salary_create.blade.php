<x-auth-validation-errors class="mb-4" :errors="$errors" />
<form method="post" action="{{ route('useradmin.emp.salary.store') }}" enctype="multipart/form-data" id="salaryForm">
    @csrf
    <div class="form-group mb-3">
        <label class="form-label" for="emp_id">{{ (' Employee Name  *') }}</label>
       <select class="form-control" name="emp_id" id="emp_id" required
               onchange="populateEmployeeDetails(this)">
               <option value="">Select employee name</option>
           @foreach ($employees as $employee)
               <option value="{{ $employee->emp_id }}">
                   {{ $employee->name }}
               </option>
           @endforeach
       </select>
       <div id="emp_id_error" style="color: red; font-size: 0.9em; display: none;"></div>
    </div>
    <input type="hidden" id="name" name="name" value="">
    <div class="form-group mb-3">
        {{-- employee Type --}}
        <label class="form-label" for="employee type">{{ ('Employee Type    *') }}</label>
        <x-input id="emp_type" name="emp_type" class="form-control" type="text" required readonly />
    </div>
    <div class="form-group mb-3">
        <label class="form-label" for="name">{{ ('Basic Amount  *') }}</label>
        <x-input id="basic_amount" name="basic_amount" class="form-control" type="text" required readonly />
    </div>
    <div class="form-group mb-3">
        <label class="form-label" for="name">{{ ('Net Amount    *') }}</label>
        <x-input id="net_amount" name="net_amount" class="form-control" type="text" required readonly />
    </div>
    <div class="form-group mb-3">
        <label class="form-label" for="epf">{{ ('EPF(Employer Contribution) *') }}</label>
        <x-input id="epf" name="epf" class="form-control" type="text" required readonly />
    </div>
    <div class="form-group mb-3">
        <label class="form-label" for="etf">{{ ('ETF(Employer Contribution) *') }}</label>
        <x-input id="etf" name="etf" class="form-control" type="text" required readonly />
    </div>
    <div class="form-group mb-3">
        <label class="form-label" for="employee_epf">{{ ('EPF(Employee Contribution)    *') }}</label>
        <x-input id="employee_epf" name="employee_epf" class="form-control" type="text" readonly/>
    </div>
    <div class="form-group mb-3">
        <label class="form-label" for="job_amount">{{ ('Job Amount  *') }}</label>
        <x-input id="job_amount" name="job_amount" class="form-control" type="text" required readonly />
    </div>
    <div class="form-group mb-3">
        <label class="form-label" for="start_date">{{ ('Start Date  *') }}</label>
        <x-input id="start_date" name="start_date" class="form-control" type="date" required  onChange="checkDate()" />
    </div>
    <div class="form-group mb-3">
        <label class="form-label" for="end_date">{{ ('End Date  *') }}</label>
        <x-input id="end_date" name="end_date" class="form-control" type="date" required onchange="checkDate()"/>
        <div id="end_date_error" style="color: red; font-size: 0.9em; display: none;"></div>
    </div>
    <div class="form-group mb-3">
        <label class="form-label" for="credit_amount">{{ ('Credit Amount') }}</label>
        <x-input id="credit_amount" name="credit_amount" class="form-control" type="number" min="0" required readonly />
    </div>
    <div class="form-group mb-3">
        <label class="form-label" for="salary_status">{{ ('Status   *') }}</label>
        <select class="form-control select2" name="salary_status" id="salary_status" required>
            <option value="NotPay">NotPay</option>
            <option value="Pending">Pending</option>
        </select>
    </div>
    <div class="d-flex mb-3">
        <div class="d-grid">
            <button id="submitButton" class="btn btn-primary btn-block mt-2" type="submit"> {{ ('Add Salary') }} </button>
        </div>
    </div>
</form>
<!-- Toastr CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    $(document).ready(function() {
        // Initialize Choices for the order_id dropdown
        const orderIdChoice = new Choices('#emp_id', {
            placeholder: true,
            searchEnabled: true,
        });
    })
    function populateEmployeeDetails(selectElement) {
        var errorMessageElement = document.getElementById('emp_id_error');
        var selectedOption = selectElement.options[selectElement.selectedIndex];
        var empId = selectedOption.value;

        if(errorMessageElement) {
            errorMessageElement.innerText = "";
            errorMessageElement.style.display = 'none';
        }

        // Initialize total job amount
        var totalJobAmount = 0;

        // Iterate over the jobs array obtained from the server-side
        @foreach ($jobs as $job)
            // Check  selected employee id matches the job's employee id
            if (empId == "{{ $job->emp_id }}") {
                // Add each job amount to the Amount
                totalJobAmount += parseFloat("{{ $job->job_amount }}") || 0;

            }
        @endforeach


        // Set the total job amount in the job_amount input field
        document.getElementById('job_amount').value = totalJobAmount.toFixed(2);

        // Get input elements
        var basicAmountInput = document.getElementById('basic_amount');
        var etfInput = document.getElementById('etf');
        var epfInput = document.getElementById('epf');
        var employeeEpfInput = document.getElementById('employee_epf');
        var netAmountInput = document.getElementById('net_amount');
        var nameInput = document.getElementById('name');
        var empTypeInput = document.getElementById('emp_type');

        // AJAX call to fetch additional employee details
        $.ajax({
            url: "{{ route('useradmin.emp.salary.get-employee-details') }}",
            method: 'GET',
            data: { emp_id: empId },
            success: function(response) {
                if (response.success) {
                  empTypeInput.value = response.emp_type || '';
                  basicAmountInput.value = parseFloat(response.basic_amount || 0).toFixed(2);
                  etfInput.value = parseFloat(response.etf || 0).toFixed(2);
                  epfInput.value = parseFloat(response.epf || 0).toFixed(2);
                  employeeEpfInput.value = parseFloat(response.employee_epf || 0).toFixed(2);
                  netAmountInput.value = parseFloat(response.net_amount || 0).toFixed(2);
                  nameInput.value = response.name || '';
                } else {
                    showCustomAlert('Error fetching employee details. Please try again.');
                }
            },
            error: function(xhr, status, error) {
                showCustomAlert('Error fetching employee details. Please try again.');
            }
        });

        // Start Date,End Date and Credit Amount Reset
        document.getElementById('start_date').value = document.getElementById('end_date').value = document.getElementById('credit_amount').value = "";

    }

    //  Check end date should be after start date
    function checkDate() {
        var startTime = document.getElementById('start_date').value;
        var startDateTime = new Date(startTime);
        var errorMessage = document.getElementById('end_date_error');

        // Calculate the last day of the month
        var lastDayOfMonth = new Date(startDateTime.getFullYear(), startDateTime.getMonth() + 1, 0);

        // Format the last day of the month correctly
        var endTime = lastDayOfMonth.getFullYear() + '-' +
                    String(lastDayOfMonth.getMonth() + 1).padStart(2, '0') + '-' +
                    String(lastDayOfMonth.getDate()).padStart(2, '0');
        // Set the end date
        document.getElementById('end_date').value = endTime;

        if (endTime <= startTime) {

            errorMessage.innerText = "End Date should be after start Date.";
            errorMessage.style.display = 'block';
            (document.getElementById('end_date')).value = '';

        } else {
            errorMessage.innerText = "";
            errorMessage.style.display = 'none';
            // Employee id
            var empId = document.getElementById('emp_id').value;
            var errorMessageElement = document.getElementById('emp_id_error');
            // Not select employee show error message
            if (!empId) {
                errorMessageElement.innerText = "Please select employee name.";
                errorMessageElement.style.display = 'block';
            }
            else{
                if (errorMessageElement) {
                    errorMessageElement.innerText = "";
                    errorMessageElement.style.display = 'none';
                }

                // AJAX call to fetch selected employee's credit amount
                $.ajax({
                    url: "{{ route('useradmin.emp.salary.get-credit-amount') }}",
                    method: 'GET',
                    data: {
                        emp_id: empId,
                        startTime: startTime,
                        endTime: endTime
                    },
                    success: function(response) {
                        var creditAmount = parseFloat(response.credit_amount);
                        document.getElementById('credit_amount').value = creditAmount.toFixed(2);
                    },
                    error: function(xhr, status, error) {
                        showCustomAlert('Error fetching credit amount. Please try again.');
                    }
                });
            }

        }
    }
    document.getElementById('salaryForm').addEventListener('submit', function(event) {
        var submitButton = document.getElementById('submitButton');

        // Disable the submit button to prevent multiple clicks
        submitButton.disabled = true;

        // Allow form submission
        event.currentTarget.submit();
    });

</script>

