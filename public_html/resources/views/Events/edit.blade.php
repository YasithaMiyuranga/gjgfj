<x-auth-validation-errors class="mb-4 text-danger" :errors="$errors" />
<form id="eventForm2" method="POST" action="{{ route('useradmin.events.update', $event->eid) }}" enctype="multipart/form-data" >
    @csrf
    @method('PUT')
    <input type="hidden" name="created_by" value="admin">
    <input type="hidden" name="time_slot" value="" id="time_slots">
    <div class="form-group mb-3">
        <label class="form-label" for="name">Event Name *</label>
        <x-input id="name" class="form-control field-name" type="text" name="event_name" required value="{{ old('event_name', $event->event_name) ?? $event->event_name }}"/>
        <span id="nameError" class="text-danger"></span>
    </div>
    <div class="form-group mb-3">
        <label class="form-label" for="customer">{{ __('Customer *') }}</label>
        <select name="customer_id" id="customer" class="form-control" required >
            <option value="">Select Customer</option>
            @foreach ($customers as $customer)
                <option value="{{ $customer->customer_id }}" {{ $customer->customer_id == $event->customer_id ? 'selected' : '' }}>{{ $customer->customer_name }}</option>
            @endforeach
        </select>
        <span class="text-danger" id="customerError">{{ $errors->first('customer_id') }}</span>
    </div>



    <div class="form-group mb-3">
        <label class="form-label" for="start_datetime">Event Start Date/Time *</label>
        <x-input id="start_datetime" class="form-control" name="start_datetime" type="text" required value="{{ old('start_datetime', $event->start_datetime) ?? $event->start_datetime }}"/>
        <span class="text-danger" id="start_datetimeError"></span>
    </div>
    <div class="form-group mb-3">
        <label class="form-label" for="end_datetime">Event End Date/Time *</label>
        <x-input id="end_datetime" class="form-control" name="end_datetime" type="text" required value="{{ old('end_datetime', $event->end_datetime) ?? $event->end_datetime }}"/>
        <span class="text-danger" id="end_datetimeError"></span>
    </div>
    <div class="form-group mb-3">
        <label class="form-label" for="setup_time">Setup Date/Time </label>
        <x-input id="setup_time" class="form-control" name="setup_time" type="text" value="{{ old('setup_time', $event->setup_time) ?? $event->setup_time }}"/>
        <span class="text-danger" id="setup_timeError"></span>
    </div>
    <div class="form-group mb-3">
        <label class="form-label" for="event_date">Event Date *</label>
        <x-input id="event_date" class="form-control flatpickr" type="text" name="event_date" required value="{{ old('event_date', $event->event_date) ?? $event->event_date }}"/>
        <span class="text-danger" id="event_dateError"></span>
    </div>
    <div class="form-group mb-3">
        <label class="form-label" for="location">Location *</label>
        <x-input id="location" class="form-control field-location" type="text" name="location"  required value="{{ old('location', $event->location) ?? $event->location }}" />
        <span class="text-danger" id="locationError"></span>
    </div>
    <div class="form-group mb-3">
        <label class="form-label" for="status">Status *</label>
        <select id="status" name="status" class="form-control" required>
          <option value="pending" {{ old('status', $event->status) == 'pending' ? 'selected' : '' }}>
              {{ old('status', $event->status) == 'pending' || old('status', $event->status) == 'Ongoing' ? 'pending' : 'pending' }}
          </option>
            <option value="credit" {{ old('status', $event->status) == 'credit' ? 'selected' : '' }}>Credit
            </option>
            <option value="completed" {{ old('status', $event->status) == 'completed' ? 'selected' : '' }}>Complete
            </option>
            <option value="booking" {{ old('status',$event->status) == 'booking' ? 'selected' : '' }}>Booking
            </option>
            <option value="canceled" {{ old('status',$event->status) == 'canceled' ? 'selected' : ''}}>Canceled
            </option>
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
          @if($eventDates)
            @foreach ($eventDates as $eventDate)
                <tr>
                    <td><input type="date" name="date[]" class="form-control" value="{{ $eventDate->date }}" ></td>
                    <td><input type="time" name="start_time[]" class="form-control" value="{{ $eventDate->start_time }}"></td>
                    <td><input type="time" name="end_time[]" class="form-control" value="{{ $eventDate->end_time }}"></td>
                    <td>
                        <button type="button" class="btn btn-danger remove-time-slot">Remove</button>
                    </td>
                </tr>
            @endforeach
          @endif
        </tbody>
    </table>
    <div class="d-flex mb-3">
        <div class="d-grid">
            <button class="btn btn-primary btn-block mt-2" type="submit">{{ ('Submit') }}</button>
        </div>
    </div>
</form>
  <!-- Flatpickr Script -->
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
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

     // add event listener to the add time slot button
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

     // add event listener to the remove time slot buttons
     timeSlotsTableBody.addEventListener('click', (e) => {
         if (e.target.classList.contains('remove-time-slot')) {
             // remove the time slot row
             e.target.parentNode.parentNode.remove();
         }
     });

    /**
     * Function to check all validations on the form and return true/false
     *
     * @returns {boolean} true if all validations pass, false otherwise
     */
    function checkValidation() {
        let isValid = true;

        // Clear previous errors for each field
        ['nameError', 'start_datetimeError', 'end_datetimeError', 'event_dateError', 'locationError'].forEach(id => {
            document.getElementById(id).textContent = '';
        });

        // Validate Event Name
        const name = document.getElementById('name').value.trim();
        if (name.length > 255) {
            // Display error if name exceeds 255 characters
            document.getElementById('nameError').textContent = 'Name cannot exceed 255 characters.';
            isValid = false;
        }

        // Check customer
        const customer = document.getElementById('customer').value;
        if (!customer) {
            // Display error if customer is not selected
            document.getElementById('customerError').textContent = 'Customer is required.';
            isValid = false;
        }

        // Validate Start Date/Time
        const startDatetime = document.getElementById('start_datetime').value;
        if (!startDatetime) {
            // Display error if start date/time is not set
            document.getElementById('start_datetimeError').textContent = 'Start Date/Time is required.';
            isValid = false;
        }

        // Validate End Date/Time
        const endDatetime = document.getElementById('end_datetime').value;
        if (!endDatetime) {
            // Display error if end date/time is not set
            document.getElementById('end_datetimeError').textContent = 'End Date/Time is required.';
            isValid = false;
        }

        // Validate Event Date
        const eventDate = document.getElementById('event_date').value;
        if (!eventDate) {
            // Display error if event date is not set
            document.getElementById('event_dateError').textContent = 'Event Date is required.';
            isValid = false;
        }

        // Validate Location
        const location = document.getElementById('location').value.trim();
        if (location.length > 255) {
            // Display error if location exceeds 255 characters
            document.getElementById('locationError').textContent = 'Location cannot exceed 255 characters.';
            isValid = false;
        }

        // Validate that End Date/Time is after Start Date/Time
        if (startDatetime && endDatetime) {
            const startDate = new Date(startDatetime);
            const endDate = new Date(endDatetime);
            if (endDate <= startDate) {
                // Display error if end date/time is not after start date/time
                document.getElementById('end_datetimeError').textContent = 'End Date/Time should be after Start Date/Time.';
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
    /**
     * Attach a submit event listener to the form with ID 'eventForm2'.
     * The event listener will prevent the default form submission, check if all validations are successful,
     * and submit the form if validation passes.
     */
    document.getElementById('eventForm2').addEventListener('submit', function(event) {
        event.preventDefault();
        // Check if all validations are successful, and submit the form if validation passes
        if (checkValidation()) {

            // Get the time slots table body
            var timeSlotsTableBody = $('#timeSlotsTable');

            // Get the time slots data
            var timeSlots = [];
            timeSlotsTableBody.find('tr').each(function() {
                var date = $(this).find('input[name="date[]"]').val();
                var startTime = $(this).find('input[name="start_time[]"]').val();
                var endTime = $(this).find('input[name="end_time[]"]').val();
                timeSlots.push({ date: date, start_time: startTime, end_time: endTime });
            });

            // Add the time slots data to the time_slots field
            if(timeSlots.length > 0){
                $('#time_slots').val(JSON.stringify(timeSlots));
            }
            // Submit the form
            this.submit();
        }
    });
</script>

