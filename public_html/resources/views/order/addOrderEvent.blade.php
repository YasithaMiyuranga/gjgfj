 <x-auth-validation-errors class="mb-4" :errors="$errors" />
 <form id="eventForm" action="{{ route('useradmin.order.event.store') }}" method="post"id="eventForm">
    @csrf
    <x-auth-validation-errors class="mb-4 text-danger" :errors="$errors" />
    <input type="hidden" name="created_by" value="admin">
    <input type="hidden" name="time_slot" value="" id="time_slots">
   <div class="form-group mb-3">
       <label class="form-label" for="new_event_name">{{ ('Event Name   *') }}</label>
       <x-input id="new_event_name" class="form-control" maxlength="100" type="text" name="name" 
           required />
       <span id="nameError" class="text-danger"></span>
   </div>
    <div class="form-group mb-3">
        <label class="form-label" for="customer">{{ ('Customer *') }}</label>
        <select name="customer" id="customer" class="form-control" required>
            <option value="">Select Customer</option>
            @foreach ($customers as $customer)
                <option value="{{ $customer->customer_id }}">{{ $customer->customer_name }}</option>
            @endforeach
        </select>
        <span class="text-danger" id="customerError">{{ $errors->first('customer') }}</span>
    </div>
    <div class="form-group mb-3">
        <label class="form-label" for="start_datetime">{{ ('Event Start Date/Time  *') }}</label>
        <x-input id="start_datetime" class="form-control flatpickr" name="start_datetime" type="text" required />
        <span class="text-danger" id="start_datetimeError">{{ $errors->first('start_datetime') }}</span>
    </div>
    <div class="form-group mb-3">
        <label class="form-label" for="end_datetime">{{ ('Event End Date/Time  *') }}</label>
        <x-input id="end_datetime" class="form-control flatpickr" name="end_datetime" type="text" required />
        <span class="text-danger" id="end_datetimeError">{{ $errors->first('end_datetime') }}</span>
    </div>
    <div class="form-group mb-3">
        <label class="form-label" for="setup_time">Setup Date/Time </label>
        <x-input id="setup_time" class="form-control flatpickr" name="setup_time" type="text" />
        <span class="text-danger" id="setup_timeError"></span>
    </div>
    <div class="form-group mb-3">
        <label class="form-label" for="date">{{ ('Event Date   *') }}</label>
        <x-input id="event_date" class="form-control flatpickr" type="text" name="event_date" required />
        <span class="text-danger" id="event_dateError">{{ $errors->first('event_date') }}</span>
    </div>
    <div class="form-group mb-3">
        <label class="form-label" for="event_location">{{ ('Location *') }}</label>
        <x-input id="event_location" class="form-control field-location" type="text" name="location" maxlength="100"
            required />
        <span class="text-danger" id="locationError">{{ $errors->first('location') }}</span>
    </div>
    <div class="form-group mb-3" id="message-parser">
        <textarea id="event-message" placeholder="Paste event details here" class="form-control" cols="15" rows="5"></textarea>
         <button  class="btn btn-primary mt-2 mb-3" id="parse-btn">Extract Information</button>
     </div>
    <button type="button" class="btn  btn-warning add-time-slot mb-3 ">+ Add Time Slot</button>
   <div class="table-responsive">
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
    </div>
    <div class="d-flex mb-3">
        <div class="d-grid">
            <button class="btn btn-primary btn-block mt-2" type="submit">{{ ('Submit') }}</button>
        </div>
    </div>
</form>
<script>
    const customers = @json($customers);
    let orderIdChoice;
    // Initialize Choices for the order_id dropdown
    if (typeof orderIdChoice === 'undefined') {
        orderIdChoice = new Choices('#customer', {
            placeholder: true,
            searchEnabled: true,
        });
    }
    $('#parse-btn').click(function(event) {
            event.preventDefault();
            const message = document.getElementById('event-message').value;

           $.ajax({
               type: 'POST',
               url: '/useradmin/parse/event/details',
               headers: {
                   'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
               },
               data: JSON.stringify({ message: message }),
               contentType: 'application/json',
               dataType: 'json',
               success: function(data) {
                // console.log(data.event_name);

                 // Clear existing fields
                 const fieldsToClear = ['new_event_name', 'customer', 'start_datetime' , 'end_datetime' , 'setup_time' , 'event_date' , 'event_location'];
                 // Clear the selected fields values
                 fieldsToClear.forEach((field) => {
                   document.getElementById(field).value = '';
                 });
                   if (data.event_name) {
                            document.getElementById('new_event_name').value = data.event_name;
                    }
                   if (data.customer_id) {
                        const customerSelect = document.getElementById('customer');
                        customerSelect.innerHTML = '';
                        customers.forEach((customer) => {
                            const option = document.createElement("option");
                            option.value = customer.customer_id;
                            option.text = customer.customer_name;

                            if (customer.customer_id == data.customer_id) {
                                if (orderIdChoice) {
                                    orderIdChoice.destroy();
                                            }

                                option.selected = true;
                            }

                            customerSelect.appendChild(option);
                        })

                   }
                   if (data.event_start_datetime) {
                       document.getElementById('start_datetime').value = data.event_start_datetime;
                   }
                   if (data.event_end_datetime) {
                       document.getElementById('end_datetime').value = data.event_end_datetime;
                   }
                   if (data.setup_date) {
                       document.getElementById('setup_time').value = data.setup_date;
                   }
                   if (data.event_date) {
                       document.getElementById('event_date').value = data.event_date;
                   }
                   if (data.event_location) {
                       document.getElementById('event_location').value = data.event_location;
                   }

               },
               error: function(xhr, status, error) {
                    showCustomAlert(error);
               }
           });
    });
    // Initialize Flatpickr start_datetime
    flatpickr("#start_datetime", {
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        minuteIncrement: 15,
        disableMobile: true,
        onClose: function(selectedDates, dateStr, instance) {
            updateEndTimePicker(dateStr);
            updateBookingDate(selectedDates[0]);
            updateSetupDateTime(selectedDates[0]);
        }
    });
    // Initialize Flatpickr end_datetime
    flatpickr("#end_datetime", {
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        minuteIncrement: 15,
        disableMobile: true,
    });
    // Initialize Flatpickr event_date
    flatpickr("#event_date", {
         enableTime: false,
         dateFormat: "Y-m-d",
         readonly: true,
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
    // Update Event End Time
    function updateEndTimePicker(minTime) {
         flatpickr("#end_datetime", {
             enableTime: true,
             dateFormat: "Y-m-d H:i",
             defaultDate: minTime,
             minuteIncrement: 15,
             disableMobile: true
         });
     }
    // Update Event Date
    function updateBookingDate(startTime) {
        // Extract the date part from the start time
        var eventDate = startTime.toISOString().split('T')[0];
        // Set the event date input value
        document.getElementById('event_date').value = eventDate;
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
    // Add event listener to the form
    $(document).ready(function() {
        // Add event listener to the input field
        $('.field-name').on('keyup', function() {
            $('#nameError').text('');
        });

        $('#eventForm').on('submit', function(event) {
            event.preventDefault(); // Prevent default form submission

            var form = this; // Reference to the form element
            var url ="{{ route('useradmin.order.event.store') }}";

            // Check if event_date matches start_datetime
            var startDatetime = $('#start_datetime').val().split(' ')[0];
            var eventDate = $('#event_date').val();
            if (eventDate !== startDatetime) {
                // Display an error message
                $('#event_dateError').text('Event Date should match Start Date/Time.');
                return;
            }

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

            $.ajax({
                url: url,
                method: 'POST',
                data: new FormData(form),
                dataType: 'json',
                processData: false, // Prevent jQuery from processing the data
                contentType: false, // Prevent jQuery from overriding content type
                success: function(response) {
                   // Handle successful response
                    if (response.status === 200) {
                        var selectArea = document.getElementById("event_name");

                        // Remove all existing options
                        selectArea.innerHTML = '';

                        // Add the default "Select Event" option
                        var defaultOption = document.createElement("option");
                        defaultOption.value = "";
                        defaultOption.text = "Select Event";
                        selectArea.appendChild(defaultOption);

                        // Add new options based on the response
                        response.events.forEach(function(event) {
                            var option = document.createElement("option");
                            option.value = event.eid;
                            option.text = event.event_name;
                            selectArea.appendChild(option);
                        });

                        // Close the modal
                        $('#commanModel').modal('hide');

                        // Get the last created event
                        var lastEvent = response.events[response.events.length - 1];

                        // Call the order.createByEvent routes with the last created event's eid
                        window.location.href = "{{ route('useradmin.order.createByEvent', ['eid' => ':eid']) }}".replace(':eid', lastEvent.eid);
                        
                        showCustomAlert(response.message);
                        // Optionally reload the page to reflect changes elsewhere
                        // location.reload();
                    } else {
                        // Display an alert for errors
                        showCustomAlert(response.message);
                    }
                },
                error: function(xhr) {
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        // Display validation errors if available
                        $.each(xhr.responseJSON.errors, function(key, value) {
                            var errorSpan = $('#' + key + 'Error');
                            errorSpan.text(value);
                        });
                    } else {
                        // Handle other errors
                        showCustomAlert('An error occurred. Please try again.');

                    }
                }
            });
        });
    });
</script>
