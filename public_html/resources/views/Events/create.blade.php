<x-auth-validation-errors class="mb-4 text-danger" :errors="$errors" />
<form id="eventForm2" method="POST" action="{{ route('useradmin.events.store') }}" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="created_by" value="admin">
    <input type="hidden" name="time_slot" value="" id="time_slots">
    <div class="form-group mb-3">
        <label class="form-label" for="name">Event Name *</label>
        <x-input id="name" class="form-control field-name" type="text" name="event_name" oninput="checkName()"
            required />
        <span id="nameError" class="text-danger"></span>
    </div>
    <div class="form-group mb-3">
        <label class="form-label" for="customer">{{ 'Customer *' }}</label> 
        <select name="customer_id" id="customer" class="form-control" required>
            <option value="">Select Customer</option>
            @foreach ($customers as $customer)
                <option value="{{ $customer->customer_id }}">{{ $customer->customer_name }}</option>
            @endforeach
        </select>
        <span class="text-danger" id="customerError">{{ $errors->first('customer') }}</span>
    </div>  

    <div class="form-group mb-3">
        <label class="form-label" for="start_datetime">Event Start Date/Time *</label>
        <x-input id="start_datetime" class="form-control flatpickr" name="start_datetime" type="text" required />
        <span class="text-danger" id="start_datetimeError"></span>
    </div>
    <div class="form-group mb-3">
        <label class="form-label" for="end_datetime">Event End Date/Time *</label>
        <x-input id="end_datetime" class="form-control flatpickr" name="end_datetime" type="text" required />
        <span class="text-danger" id="end_datetimeError"></span>
    </div>
    <div class="form-group mb-3">
        <label class="form-label" for="setup_time">Setup Date/Time </label>
        <x-input id="setup_time" class="form-control flatpickr" name="setup_time" type="text" />
        <span class="text-danger" id="setup_timeError"></span>
    </div>
    <div class="form-group mb-3">
        <label class="form-label" for="event_date">Event Date *</label>
        <x-input id="event_date" class="form-control flatpickr" type="text" name="event_date" required />
        <span class="text-danger" id="event_dateError"></span>
    </div>
    <div class="form-group mb-3">
        <label class="form-label" for="location">Location *</label>
        <x-input id="location" class="form-control field-location" type="text" name="location" required />
        <span class="text-danger" id="locationError"></span>
    </div>
    <div class="form-group mb-3">
        <label class="form-label" for="status">Status *</label>
        <select id="status" name="status" class="form-control" required>
            <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="credit" {{ old('status') == 'credit order' ? 'selected' : '' }}>Credit</option>
            <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Complete</option>
            <option value="booking" {{ old('status') == 'booking' ? 'selected' : '' }}> Booking</option>
            <option value="canceled" {{ old('status') == 'canceled' ? 'selected' : '' }}>Canceled</option>
        </select>
    </div>
    <button type="button" class="btn  btn-warning add-time-slot mb-3 ">+ Add Time Slot</button>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Date</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="timeSlotsTable">
            {{-- Time slots will be dynamically added here --}}
        </tbody>
    </table>
    <div class="d-flex mb-3">
        <div class="d-grid">
            <button class="btn btn-primary btn-block mt-2" type="submit">{{ 'Submit' }}</button>
        </div>
    </div>
</form>
<script>
    function checkName() {
        var name = document.getElementById('name').value;
        var nameError = document.getElementById('nameError');

        // Find the employee with the same name ajax call
        $.ajax({
            url: "{{ route('useradmin.events.checkeventname') }}",
            method: "POST",
            data: {
                name: name,
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                if (response.exists) {
                    nameError.textContent = "Event Name already exists.";

                } else {
                    nameError.textContent = "";
                }
            }
        })
    }
    $(document).ready(function() {
        // Initialize Choices for the order_id dropdown
        const orderIdChoice = new Choices('#customer', {
            placeholder: true,
            searchEnabled: true,
        });
    })
    // Initialize Flatpickr for start_datetime
    flatpickr("#start_datetime", {
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        minuteIncrement: 15,
        disableMobile: true,
        onClose: function(selectedDates, dateStr) {
            updateEndTimePicker(dateStr);
            updateBookingDate(selectedDates[0]);
            updateSetupDateTime(selectedDates[0]);
        }
    });
    // Initialize Flatpickr for end_datetime
    flatpickr("#end_datetime", {
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        minuteIncrement: 15,
        disableMobile: true,
    });
    // Initialize Flatpickr for event_date
    flatpickr("#event_date", {
        enableTime: false,
        dateFormat: "Y-m-d",
        disableMobile: true,
    });
    // Initialize Flatpickr for setup_time
    flatpickr("#setup_time", {
        enableTime: true,
        dateFormat: "Y-m-d H:i",

    })
    // Update setup_time picker based on start_datetime
    function updateSetupDateTime(startTime) {
        if (startTime) {
            flatpickr("#setup_time", {
                enableTime: true,
                dateFormat: "Y-m-d H:i",
                defaultDate: startTime,
                disableMobile: true
            })
        }
    }
    // Update end_datetime picker based on start_datetime
    function updateEndTimePicker(minTime) {
        flatpickr("#end_datetime", {
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            defaultDate: minTime,
            minuteIncrement: 15,
            disableMobile: true,
        });
    }

    // Automatically set event_date based on start_datetime
    function updateBookingDate(startTime) {
        if (startTime) {
            const eventDate = startTime.toISOString().split('T')[0];
            document.getElementById("event_date").value = eventDate;
        }
    }
    // Get the add time slot button
    const addTimeSlotButton = document.querySelector('.add-time-slot');
    // Get the time slots table body
    const timeSlotsTableBody = document.querySelector('#timeSlotsTable');

    // Add event listener to the add time slot button
    addTimeSlotButton.addEventListener('click', () => {
        // create a new time slot row
        const newRow = document.createElement('tr');

        // create the date cell
        const dateCell = document.createElement('td');
        dateCell.innerHTML = '<input type="date" name="date[]" class="form-control" required>';

        // create the start time cell
        const startTimeCell = document.createElement('td');
        startTimeCell.innerHTML = '<input type="time" name="start_time[]" class="form-control required">';

        // create the end time cell
        const endTimeCell = document.createElement('td');
        endTimeCell.innerHTML = '<input type="time" name="end_time[]" class="form-control required">';

        // create the actions cell
        const actionsCell = document.createElement('td');
        actionsCell.innerHTML = '<button type="button" class="btn btn-danger remove-time-slot">Remove</button>';

        // add the cells to the new row
        newRow.appendChild(dateCell);
        newRow.appendChild(startTimeCell);
        newRow.appendChild(endTimeCell);
        newRow.appendChild(actionsCell);

        // add the new row to the time slots table body
        timeSlotsTableBody.appendChild(newRow);
    });

    // Add event listener to the remove time slot buttons
    timeSlotsTableBody.addEventListener('click', (e) => {
        if (e.target.classList.contains('remove-time-slot')) {
            // remove the time slot row
            e.target.parentNode.parentNode.remove();
        }
    });
    // Form validation
    function checkValidation() {
        let isValid = true;
        // Clear previous errors
        ['nameError', 'start_datetimeError', 'end_datetimeError', 'event_dateError', 'locationError'].forEach(id => {
            document.getElementById(id).textContent = '';
        });

        // Check if name is valid
        const name = document.getElementById('name').value.trim();
        if (name.length > 255) {
            // If name is too long, show an error message
            document.getElementById('nameError').textContent = 'Name cannot exceed 255 characters.';
            isValid = false;
        }

        // Check if start date/time is valid
        const startDatetime = document.getElementById('start_datetime').value;
        if (!startDatetime) {
            // If start date/time is not set, show an error message
            document.getElementById('start_datetimeError').textContent = 'Start Date/Time is required.';
            isValid = false;
        }

        // Check if end date/time is valid
        const endDatetime = document.getElementById('end_datetime').value;
        if (!endDatetime) {
            // If end date/time is not set, show an error message
            document.getElementById('end_datetimeError').textContent = 'End Date/Time is required.';
            isValid = false;
        }

        // Check if event date is valid
        const eventDate = document.getElementById('event_date').value;
        if (!eventDate) {
            // If event date is not set, show an error message
            document.getElementById('event_dateError').textContent = 'Event Date is required.';
            isValid = false;
        }

        // Check if location is valid
        const location = document.getElementById('location').value.trim();
        if (location.length > 255) {
            // If location is too long, show an error message
            document.getElementById('locationError').textContent = 'Location cannot exceed 255 characters.';
            isValid = false;
        }

        // Check the dates
        if (startDatetime && endDatetime) {
            const startDate = new Date(startDatetime);
            const endDate = new Date(endDatetime);
            if (endDate <= startDate) {
                // If end date/time is not after Start Date/Time, show an error message
                document.getElementById('end_datetimeError').textContent =
                    'End Date/Time should be after Start Date/Time.';
                isValid = false;
            }
        }

        // Check if event_date matches start_datetime
        var startDate = $('#start_datetime').val().split(' ')[0];
        if (eventDate !== startDate) {
            // Display an error message
            $('#event_dateError').text('Event Date should match Start Date/Time.');
            isValid = false;
        }
        return isValid;
    }

    // Attach a submit event listener to the form with ID 'eventForm2'
    document.getElementById('eventForm2').addEventListener('submit', function(event) {
        // Prevent the default form submission
        event.preventDefault();

        // Check if all validations are successful
        if (checkValidation()) {
            // Get the time slots table body
            var timeSlotsTableBody = $('#timeSlotsTable');

            // Get the time slots data
            var timeSlots = [];
            timeSlotsTableBody.find('tr').each(function() {
                var date = $(this).find('input[name="date[]"]').val();
                var startTime = $(this).find('input[name="start_time[]"]').val();
                var endTime = $(this).find('input[name="end_time[]"]').val();
                timeSlots.push({
                    date: date,
                    start_time: startTime,
                    end_time: endTime
                });
            });

            // Add the time slots data to the time_slots field
            if (timeSlots.length > 0) {
                $('#time_slots').val(JSON.stringify(timeSlots));
            }

            // Submit the form if validation passes
            this.submit();
        }
    });
</script>
