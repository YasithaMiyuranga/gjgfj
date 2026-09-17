<x-auth-validation-errors class="mb-4" :errors="$errors" />
<form method="post" action="{{ route('useradmin.emp.salary.update') }}" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="id" name="id" value="{{ $details->id }}" value="admin">
    <input type="hidden" name="created_by" value="admin">
   <input type="hidden" id="emp_id" name="emp_id" value="{{ $details->emp_id }}">
    <div class="form-group mb-3">
        <label class="form-label" for="name">{{ __('Employee Name   *') }}</label>
        <x-input value="{{ old('name') ? old('name') : $details->name }}" id="name" name="name" class="form-control" type="text" required readonly
            autofocus />
        <div id="emp_id_error" style="color: red; font-size: 0.9em; display: none;"></div>
    </div>
    <div class="form-group mb-3">
        <label class="form-label" for="name">{{ __('Basic Amount    *') }}</label>
        <x-input value="{{ old('basic_amount') ? old('basic_amount') : $details->basic_amount }}" id="basic_amount" name="basic_amount" class="form-control"
            type="text" required readonly />
        </div>
    <div class="form-group mb-3">
        <label class="form-label
        " for="epf">{{ __('EPF(Employer Contribution)   *') }}</label>
        <x-input value="{{ old('epf') ? old('epf') : $details->epf }}" id="epf" name="epf" class="form-control" type="text" required readonly
            autofocus />
    </div>
    <div class="form-group mb-3">
        <label class="form-label" for="etf">{{ __('ETF(Employer Contribution)   *') }}</label>
        <x-input value="{{ old('etf') ? old('etf') : $details->etf }}" id="etf" name="etf" class="form-control" type="text" required
            readonly />
    </div>
    <div>
        <label class="form-label" for="employee_epf">{{ __('EPF(Employee Contribution)  *') }}</label>
        <x-input value="{{ old('employee_epf') ? old('employee_epf') : $details->employee_epf }}" id="employee_epf" name="employee_epf" class="form-control" type="text" readonly
            autofocus />
    </div>
    <div class="form-group mb-3">
        <label class="form-label
        " for="job_amount">{{ __('Job Amount    *') }}</label>
        <x-input value="{{ old('job_amount') ? old('job_amount') : $details->job_amount }}" id="job_amount" name="job_amount" class="form-control"
            type="number" required autofocus readonly />
    </div>
    <div class="form-group mb-3">
        <label class="form-label" for="start_date">{{ __('Start_date    *') }}</label>
        <x-input value="{{ $details->start_date ? $details->start_date->format('Y-m-d') : '' }}" id="start_date"
            name="start_date" class="form-control" type="date" required autofocus onChange="checkDate()" />
    </div>
    <div class="form-group mb-3">
        <label class="form-label" for="end_date">{{ __('End_date    *') }}</label>
        <x-input value="{{ $details->end_date ? $details->end_date->format('Y-m-d') : '' }}" id="end_date"
            name="end_date" class="form-control" type="date" required autofocus onChange="checkDate()" />
            <div id="end_date_error" style="color: red; font-size: 0.9em; display: none;"></div>
    </div>
    <div class="form-group mb-3">
        <label class="form-label
        " for="loan_amount">{{ __('Credit Amount') }}</label>
        <x-input value="{{ old('credit_amount') ? old('credit_amount') : $details->loan_amount }}" id="credit_amount" name="credit_amount" class="form-control"
            type="text" required readonly />
    </div>
    <div class="form-group mb-3">
        <label class="form-label" for="salary_status">{{ __('Status   *') }}</label>
        <select class="form-control select2" name="salary_status" id="salary_status" required {{ $details->salary_status == 'Paid' ? 'disabled' : '' }}>
            @if ($details->salary_status == 'Paid')
                <option value="Paid" {{ old('salary_status', $details->salary_status) == 'Paid' ? 'selected' : 'selected' }}>Paid</option>
            @endif
            <option value="NotPay"  {{ old('salary_status', $details->salary_status) == 'NotPay' ? 'selected' : '' }}>NotPay</option>
            <option value="Pending" {{ old('salary_status', $details->salary_status) == 'Pending' ? 'selected' : '' }}>Pending</option>
        </select>
    </div>
    <div class="d-flex mb-3">
        <div class="d-grid">
            @if ($details->salary_status == 'Paid')
                <button class="btn btn-primary btn-block mt-2" type="submit" disabled> {{ __('Update') }}</button>
            @else
                <button class="btn btn-primary btn-block mt-2" type="submit"> {{ __('Update') }} </button>
            @endif
        </div>
    </div>

</form>
<script>
    // Check end date should be after start date
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
</script>
