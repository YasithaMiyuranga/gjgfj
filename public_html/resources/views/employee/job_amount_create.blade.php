@extends('layouts.app')
@section('page-title', ('Job Amount'))
@section('action-button')
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('useradmin.emp.job.amount.view') }}">{{ ('Emp Job Amount') }}</a>
    </li>
    <li class="breadcrumb-item active">{{ ('Add Job Amount') }}</li>
@endsection
@section('content')
    @php
        $errors = $errors ?? [];
    @endphp
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h5></h5>
                        <h3>Add Job Amount</h3>
                    </div>
                    <hr>
                    <div class="card-body table-border-style">
                        <form method="post" action="{{ route('useradmin.emp.job.amount.store') }}" id="jobAmountForm"
                            enctype="multipart/form-data" class="form-submit-click">
                            @csrf
                            <input type="hidden" name="created_by" value="admin">
                            <div class="form-group mb-3">
                                <label class="form-label" for="event_id">{{ ('Event ID   *') }}</label>
                                <select class="form-control" name="event_id" id="event_id" required>
                                    <option value="">Select event id</option>
                                        @foreach ($events as $event)
                                                <!-- when calendar is selected event id will be selected-->
                                                @if($specificEvent != null)
                                                    @if($event->eid == $specificEvent->eid)
                                                        <option value="{{ $event->eid }}" selected>{{ $event->eid }}-{{ $event->event_name }}</option>
                                                    @endif
                                                @else
                                                    <option value="{{ $event->eid }}">{{ $event->eid }}-{{ $event->event_name }}</option>
                                                @endif
                                        @endforeach
                                </select>
                                @if ($errors->has('event_id'))
                                    <div class="invalid-feedback">{{ $errors->first('event_id') }}</div>
                                @endif
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label" for="order_id">{{ ('Order ID *') }}</label>
                                <select class="form-control" name="order_id" id="order_id" required>
                                    <option value="">Select order id</option>
                                    <!-- Orders will be dynamically populated here -->
                                    <!--when calendar is selected event matching orders -->
                                    @if($orders)
                                        @foreach ($orders as $order)
                                            <option value="{{ $order->order_id }}">{{ $order->order_id }}-{{ $order->event_name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                @if ($errors->has('order_id'))
                                    <div class="invalid-feedback">{{ $errors->first('order_id') }}</div>
                                @endif
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label" for="event_name">{{ ('Event Name') }}</label>
                                <input type="text" class="form-control" name="event_name" id="event_name" readonly>
                                @if ($errors->has('event_name'))
                                    <div class="invalid-feedback">{{ $errors->first('event_name') }}</div>
                                @endif
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label" for="booking_date">{{ ('Booking Date') }}</label>
                                <input type="text" class="form-control" name="booking_date" id="booking_date" readonly>
                                @error('booking_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <br>

                        <div>
                            <div class="table-responsive overflow-hidden">
                                </div>
                              <div class="row align-items-center ">
                                  <div class="col-md-3 mb-3">
                                      <select class="form-control" name="new_selected_employees" id="new_selected_employees">
                                          <option value="">Select Employee</option>
                                          <!-- Employees will be dynamically populated here -->
                                      </select>
                                  </div>
                                  <div class="col-md-3 mb-3">
                                      <input type="number" name="job_amount_new" id="job_amount_new" class="form-control" placeholder="Enter Job Amount" min="0">
                                  </div>
                                    <div class="col-md-3 mb-3">
                                        <input type="text" name="payment_status_new" id="payment_status_new" class="form-control" value="Not paid" readonly>
                                    </div>
                                    <div class="col-md-2 mb-3">
                                        <button type="button" class="btn btn-warning" id="addEmployeeBtn">
                                            <i class="fas fa-plus"></i> Add
                                        </button>
                                    </div>
                                    <div class="col-md-2 align-self-end mb-3" style="margin:15px 5px; display: none; width:100%;" id="permanentDiv">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" name="permanent" id="permanent" value="1"
                                                {{ old('permanent') == '1' ? 'checked' : '' }}>
                                            <label for="permanent" class="form-check-label">Permanent Employees</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive mt-3">
                                <table class="table " >
                                    <thead>
                                        <tr>
                                            <th>{{ ('Employee Name') }}</th>
                                            <th>{{ ('Job Amount') }}</th>
                                            <th>{{ ('Status') }}</th>
                                            <th>{{ ('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody id="employee_info_body">
                                    </tbody>
                                </table>
                                </div>
                            </div>
                        </div>
                            <input type="text" id="jobAmountArrayInput" name="jobAmountArrayInput" value="[]" hidden>
                        <div class="d-flex justify-content-end mt-3" style="padding: 15px;margin 40px;">
                            <button type="submit" class="btn btn-primary" id="confirm">Submit</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Choices.js -->
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>

    <script>
        // Initilize selectedEmployeesArray
        var selectedEmployeesArray = [];
        var allEmployees = @json($employees);
        // Initialize addNewEmpDropdown
        let addNewEmpDropdown;

        const eventIdChoice = new Choices('#event_id', {
            placeholder: true,
            searchEnabled: true,
        });

        // Function to toggle permanent employee checkbox
        function togglePermanentEmployeesCheckbox() {
            const checkbox = document.getElementById('permanent');
            var dropdown = $('#new_selected_employees');

            // Clear existing options and add a default one
            dropdown.empty().append('<option value="">Select Employee</option>');

            checkbox.addEventListener('change', function() {
            if (this.checked) {
                // Destroy existing Choices instance
                if (addNewEmpDropdown) {
                addNewEmpDropdown.destroy();
                }
                addNewEmpDropdown = new Choices('#new_selected_employees', {
                placeholder: true,
                searchEnabled: true,
                choices: allEmployees.filter(function(employee) {
                    return employee.emp_type === 'Permanent Employee';
                }).map(function(employee) {
                    return {
                    value: employee.name,
                    label: employee.name,
                    };
                }),
                });
            } else {
                // Destroy existing Choices instance
                if (addNewEmpDropdown) {
                addNewEmpDropdown.destroy();
                }
                // Show all employees in the dropdown
                addNewEmpDropdown = new Choices('#new_selected_employees', {
                placeholder: true,
                searchEnabled: true,
                choices: allEmployees.map(function(employee) {
                    return {
                    value: employee.name,
                    label: employee.name,
                    };
                }),
                });
            }
            });
        }
        // Call togglePermanentEmployeesCheckbox function
        togglePermanentEmployeesCheckbox();

        // Function to delete row
        function deleteRow(button) {
            var row = button.parentNode.parentNode;
            row.parentNode.removeChild(row);
            // add removed employee to allEmployees array
            var employeeName = row.cells[0].textContent;
            allEmployees.push({ name: employeeName });
            // call add new employee dropdown
            addNewEmployeeDropdown();

        }
        // Reinitialize Choices for dynamically added employee dropdowns
        function addEmployeeRow() {
            var employeeName = document.getElementById('new_selected_employees').value;
            var jobAmount = document.getElementById('job_amount_new').value;
            var paymentStatus = document.getElementById('payment_status_new').value;

            // Check if employee name and job amount are not empty
            if (!employeeName) {
                showCustomAlert("Please select an employee.");
                return;
            }

            var newRow = document.createElement('tr');
            newRow.innerHTML = `
            <td>${employeeName}</td>
            <td><input type="number" name="new_job_amount[]" class="form-control job-amount-input" value="${jobAmount}" placeholder="Enter Job Amount"></td>
            <td><span class="text-center payment_status">Not paid</span></td>
            <td><button type="button" class="btn btn-danger btn-sm" onclick="deleteRow(this)">Delete</button></td>
            `;

            // Append the new row to the table body
            document.getElementById('employee_info_body').appendChild(newRow);

            // select employee remove from allemployees array
            allEmployees = allEmployees.filter(function(emp) {
                return emp.name !== employeeName;
            });

            // Clear the job amount input field
            document.getElementById('job_amount_new').value = '';

            // call add new employee dropdown
            addNewEmployeeDropdown();
        }
        // Add employee row
        $('#addEmployeeBtn').click(function() {
            addEmployeeRow();
        });

        $(document).ready(function() {
            // Initialize Choices.js for the order_id dropdown
            let orderIdChoice;

            // Event change listener for the event_id dropdown
            $('#event_id').on('change', function() {
                var eventId = $(this).val();
                var orderDropdown = $('#order_id');

                // Clear existing options and add a default one
                orderDropdown.empty().append('<option value="">Select order id</option>');

                if (eventId) {
                    $.ajax({
                        url: '/useradmin/event/orders/' + eventId,
                        method: 'GET',
                        success: function(response) {

                            // Ensure response is an array
                            if (Array.isArray(response) && response.length > 0) {
                                // Destroy existing Choices instance
                                if (orderIdChoice) {
                                    orderIdChoice.destroy();
                                }

                              orderIdChoice = new Choices('#order_id', {
                                placeholder: true,
                                searchEnabled: true,
                                choices: response.map(order => {
                                  return {
                                    value: order.order_id,
                                    label: order.order_id + ' - ' + order.event_name,
                                    data: {
                                      event_name: order.event_name,
                                      booking_date: order.booking_date
                                    }
                                  };
                                })
                              });
                            } else {
                                // Destroy existing Choices instance
                                if (orderIdChoice) {
                                    orderIdChoice.destroy();
                                }

                                // Show an empty dropdown
                                orderDropdown.empty().append('<option value="">No orders found</option>');

                                // Remove event name and booking date from the data object
                                $('#event_name').val('');
                                $('#booking_date').val('');
                                var employeeInfoBody = $('#employee_info_body');
                                employeeInfoBody.empty();
                            }
                        },
                        error: function(error) {
                            console.error('Error fetching orders:', error);
                            orderDropdown.empty().append('<option value="">Error loading orders</option>');
                        }
                    });
                } else {
                    // Show an empty dropdown when no event is selected
                    orderDropdown.empty().append('<option value="">Select order id</option>');
                }
            });

            // Order change listener for the order_id dropdown
            $('#order_id').on('change', function() {
                var selectedOption = $(this).find(':selected');
                var orderId = selectedOption.val();
                if (orderId) {
                    fetchEmployeeData(orderId);
                }
            });

            // Function to fetch employee data
            function fetchEmployeeData(orderId) {
                var employeeInfoBody = $('#employee_info_body');
                employeeInfoBody.empty();

                $.ajax({
                    url: '/useradmin/employee/job_amount_create/' + orderId,
                    method: 'GET',
                    success: function(response) {
                        if(response.order){
                            $('#booking_date').val(response.order.formatted_date);
                            $('#event_name').val(response.order.event_name);
                        }

                        if (response.jobAmounts && response.jobAmounts.length > 0) {

                            response.jobAmounts.forEach(function(jobAmount) {
                                var isEditable = jobAmount.payment_status !== "Paid";
                                var readonlyAttribute = isEditable ? "" : "readonly";

                                var row = `<tr>
                                    <td>${jobAmount.name}</td>
                                    <td><input type="number" class="form-control job-amount-input"
                                            value="${jobAmount.job_amount}" placeholder="Enter Job Amount" ${readonlyAttribute}></td>
                                    <td><span class="text-center payment_status">${jobAmount.payment_status}</span></td>
                                    <td><button type="button" class="btn btn-danger btn-sm"
                                                onclick="deleteRow(this)" ${isEditable ? "" : "disabled"}>Delete</button></td>
                                </tr>`;
                                employeeInfoBody.append(row);

                                  // select employee remove from allemployees array
                                  allEmployees = allEmployees.filter(function(emp) {
                                      return emp.name !== jobAmount.name;
                                  })
                            });
                        }
                        if (response.employees && response.employees.length > 0) {

                            response.employees.forEach(function(employee) {
                                var row = `<tr>
                                    <td>${employee.name}</td>
                                    <td><input type="number" class="form-control job-amount-input"
                                            value="${employee.job_amount}" placeholder="Enter Job Amount"></td>
                                    <td><span class="text-center payment_status">${employee.payment_status}</span></td>
                                    <td><button type="button" class="btn btn-danger btn-sm" onclick="deleteRow(this)">Delete</button></td>
                                </tr>`;
                                employeeInfoBody.append(row);

                                // select employee remove from allemployees array
                                allEmployees = allEmployees.filter(function(emp) {
                                    return emp.name !== employee.name;
                                });


                            });

                        }
                        // call add new employee dropdown
                        addNewEmployeeDropdown();
                        // Show the permanent div
                        document.getElementById('permanentDiv').style.display = 'block';
                    },
                    error: function() {
                        showCustomAlert('Error fetching employee data. Please try again.');
                    }
                });
            }
        });
        // Function to add new employee dropdown
        function addNewEmployeeDropdown() {
            var newEmpselect= $('#new_selected_employees');

            // Clear existing options and add a default one
            newEmpselect.empty().append('<option value="">Select Employee</option>');

            // Destroy existing Choices instance
            if (addNewEmpDropdown) {
                addNewEmpDropdown.destroy();
            }

            addNewEmpDropdown = new Choices('#new_selected_employees', {
                placeholder: true,
                searchEnabled: true,
                choices: allEmployees.map(function(employee) {
                    return {
                        value: employee.name,
                        label: employee.name,
                    };
                }),

            });
        }

        // Function to check validation
        function checkValidation() {
            // Check if an order ID is selected
            if ($('#order_id').val() === '') {
                showCustomAlert('Please select an order ID');
                return false;
            }


            let isValid = true; // Flag to determine overall validation
            $('#employee_info_body tr').each(function () {
                const jobAmount = $(this).find('.job-amount-input').val();

                // Validate job amount for empty, non-numeric, or invalid values
                if (!jobAmount || isNaN(jobAmount) || parseFloat(jobAmount) <= 0) {
                    showCustomAlert('Please enter a valid job amount in each row');
                    isValid = false;
                    return false; // Break out of the loop
                }
                // Job Amount Validation
                const jobAmountInput = $(this).find('.job-amount-input');
                // Max Job Amount Validation 7 characters
                if (jobAmountInput.val().length > 7) {
                    showCustomAlert('Job amount cannot exceed 7 characters');
                    isValid = false;
                    return false;
                }



            });
            // employee info body has any rows
            if ($('#employee_info_body tr').length == 0) {
                    showCustomAlert('Please add at least one employee');
                    isValid = false;

                }

            return isValid;
        }
        // Initialize jobAmountArray
        let jobAmountArray = [];

        // Event listener for the "Confirm" button
        $('#confirm').click(function() {
            if (!checkValidation())
            {
                return false;
            }

            $('#employee_info_body tr').each(function() {
                var employeeName = $(this).find('td').eq(0).text();
                var jobAmount = $(this).find('.job-amount-input').val();
                var paymentStatus = $(this).find('.payment_status').text();
                jobAmountArray.push({
                    'name': employeeName,
                    'job_amount': jobAmount,
                    'payment_status': paymentStatus
                });



            });
            document.getElementById('jobAmountArrayInput').value = JSON.stringify(jobAmountArray);
        });
    </script>
@endsection
