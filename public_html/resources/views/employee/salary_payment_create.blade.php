@extends('layouts.app')

@section('page-title', 'Employees')

@section('action-button')
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('useradmin.emp.salary_pauments_view') }}">{{ __('Emp Payments') }}</a>
    </li>
    <li class="breadcrumb-item active">{{ __('Add Salary Payment') }}</li>
@endsection

@section('content')
    <x-auth-validation-errors class="mb-4" :errors="$errors" />
    <div class="row justify-content-center">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h5></h5>
                    <h3>Add Salary Payment</h3>
                </div>
                <hr>
                <div class="card-body">
                    <form method="post" action="{{ route('useradmin.emp.salary.payment.store') }}"
                        enctype="multipart/form-data" class="form-submit-click">
                        @csrf
                        <input type="hidden" name="created_by" value="admin">
                        <input type="hidden" id="jobsId" name="jobsId" value="">

                        <div class="form-group mb-3">
                            <label class="form-label" for="employee_id">{{ __('Enter Employee Name  *') }}</label>
                            <select class="form-control select2" name="employee_id" id="employee_id" required
                                onchange="populateEmployeeDetails(this)">
                                <option value="">Select employee name</option>
                                @foreach ($employees as $employee)
                                    <option value="{{ $employee->emp_id }}" data-emp_type="{{ $employee->emp_type }}"
                                        data-emp_id="{{ $employee->emp_id }}"
                                        data-credit_amount="{{ $employee->credit_amount }}"
                                        data-net_salary="{{ $employee->net_salary }}" data-name="{{ $employee->name }}">
                                        {{ $employee->emp_id }}-{{ $employee->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label" for="available_amount">{{ __('Available Amount    *') }}</label>
                            <x-input id="available_amount" name="available_amount" class="form-control" type="text"
                                required readonly />
                        </div>

                        {{-- <div class="form-group mb-3">
                            <label class="form-label" for="allowance_amt">{{ __('Allowance Amount') }}</label>
                            <x-input id="allowance_amt" name="allowance_amt" class="form-control" type="text" />
                        </div> --}}

                        <div class="form-group mb-3">
                            <label class="form-label" for="credit_amt">{{ __('Credit Amount *') }}</label>
                            <x-input id="credit_amt" name="credit_amt" class="form-control" type="text" readonly />
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label" for="pay_type">{{ __('Payment Type    *') }}</label>
                            <select class="form-control select2" name="pay_type" id="pay_type" required>
                                <option value="Cash">Cash</option>
                                <option value="Bank">Bank</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>

                        <div class="d-flex mb-3">
                            <div class="d-grid">
                                <button class="btn btn-primary btn-block mt-2" type="submit"
                                    id="btn_submit">{{ __('Add Salary') }}</button>
                            </div>
                        </div>
                    </form>
                    <div class="modal fade" id="descriptionModal" tabindex="-1" aria-labelledby="descriptionModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="descriptionModalLabel">Description</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" id="btn-close"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p id="description">Are you sure you want to deduct the credit Amount from the available
                                        balance?</p>
                                    <p id="displayMsg" class="text-danger" style="display:none">
                                        You have not insufficient balance.credit amount is greater than or equal to available amount
                                    </p>


                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" id ="btn-no"
                                        data-bs-dismiss="modal">No</button>
                                    <button type="button" class="btn btn-primary" id="btn-yes">Yes</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script>
        $('#employee_id').select2({
            placeholder: "Select an Employee",
            required: true,
            position: 'bottom'
        });
        function populateEmployeeDetails(selectElement) {
            var selectedOption = selectElement.options[selectElement.selectedIndex];
            var empId = selectedOption.getAttribute('data-emp_id');
            var netSalary = selectedOption.getAttribute('data-net_salary');
            var creditAmt = selectedOption.getAttribute('data-credit_amount');

            var totalJobAmount = 0;
            let jobIds = [];

            @foreach ($jobs as $job)
                if (empId == "{{ $job->emp_id }}") {
                    totalJobAmount += parseFloat("{{ $job->job_amount }}") || 0;
                    jobIds.push("{{ $job->id }}");
                }
            @endforeach

            document.getElementById('jobsId').value = jobIds.join(',');

            var totalAvailableSalary = 0;
            var netSalary = parseFloat(netSalary);

            if (netSalary != "") {
                totalAvailableSalary = totalJobAmount + netSalary;
            }
            if (isNaN(netSalary)) {
                totalAvailableSalary = totalJobAmount;
            }

            document.getElementById('available_amount').value = totalAvailableSalary.toFixed(2);

            var creditAmountInput = document.getElementById('credit_amt');
            creditAmountInput.value = parseFloat(creditAmt).toFixed(2);
        }


        $(document).ready(function() {
            $('#btn_submit').on('click', function(event) {
                var creditAmt = parseFloat(document.getElementById('credit_amt').value);
                var availableAmt = parseFloat(document.getElementById('available_amount').value);

                // Prevent form submission initially
                event.preventDefault();

                // Check employee selected
                if (!document.getElementById('employee_id').value) {
                    showCustomAlert("Please select an employee");
                    return;
                }

                // Check if available amount is valid
                if (availableAmt === 0) {
                    showCustomAlert("This employee has no available amount");
                } else {
                    // Check if credit amount is greater than 0
                    if (creditAmt > 0) {
                        $('#descriptionModal').modal('show');
                    } else {
                        // Directly submit form if no credit amount
                        $('#btn_submit').closest('form').submit();
                    }
                }
            });

            // Add click event handler for the "Yes" button inside the modal
            $('#btn-yes').on('click', function(event) {
                var creditAmt = parseFloat(document.getElementById('credit_amt').value);

                // Add canDeduct variable to query to url
                var can_deduct = true;
                var url = "{{ route('useradmin.emp.salary.payment.store') }}?can_deduct=" + can_deduct;

                // replace the action in the form
                $('#btn_submit').closest('form').attr('action', url);

                $('#descriptionModal').modal('hide');
                $('#btn_submit').closest('form').submit(); // Submit the form

            });

            // Add click event handler for the "No" button inside the modal
            $('#btn-no').on('click', function() {

                // Add canDeduct variable to query to url
                var can_deduct = false;
                var url = "{{ route('useradmin.emp.salary.payment.store') }}?can_deduct=" + can_deduct;

                // replace the action in the form
                $('#btn_submit').closest('form').attr('action', url);
                $('#btn_submit').closest('form').submit(); // Submit the form

                $('#descriptionModal').modal('hide');
            });

            // Add click event handler for the "Close" button
            $('#btn-close').on('click', function() {
                $('#descriptionModal').modal('hide');
            });


        });
    </script>
@endsection
