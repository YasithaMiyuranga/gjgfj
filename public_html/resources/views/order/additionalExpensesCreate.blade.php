
<form method="POST" action="{{ isset($orderspecific) ? route('employee.emp.order.expenses.store') : route('useradmin.order.expenses.store') }}" id="additionalExpensesForm">
    @csrf
    <div class="form-group mb-3">
        <label for="event_id">{{ ('Event *') }}</label>
        <select id="event_id" name="event_id" class="form-control select2" required>
            <option value="">{{ ('Select Event ') }}</option>
            @if(isset($eventspecific))
                <option value="{{ $eventspecific->eid }}" selected>{{ $eventspecific->eid }}-{{ $eventspecific->event_name }}</option>
            @else
            {{-- Loop through all events if admin is selecting the event --}}
              @if($events)
                    @if ($events->count() == 1)
                        <option selected value="{{ $events[0]->eid }}">{{ $events[0]->eid }}-{{ $events[0]->event_name }}</option>
                    @else
                        @foreach ($events as $event)
                            <option value="{{ $event->eid }}">{{ $event->eid }}-{{ $event->event_name }}</option>
                        @endforeach
                    @endif
                @endif
            @endif
        </select>
    </div>
    <div class="form-group mb-3">
        <label for="order_id">{{ ('Select Order*') }}</label>
        <select id="order_id" name="order_id" class="form-control" required>
            <option value="">{{ ('Select Order') }}</option>
            {{-- If a specific order is passed from the Employee --}}
            @if(isset($orderspecific))
                <option value="{{ $orderspecific->order_id }}" selected>{{ $orderspecific->order_id }}</option>
            @else
                 <!-- Orders will be dynamically populated here -->
            @endif
        </select>
    </div>
    <div class="form-group mb-3">
        <label class="form-label" for="name">{{ ('Expense Name*') }}</label>
        <x-input id="name" name="name" class="form-control" type="text" required />
        <span class="text-danger" id="nameError"></span>
    </div>
    <div class="form-group mb-3">
        <label class="form-label" for="amount">{{ ('Amount*') }}</label>
        <x-input id="amount" name="amount" class="form-control" type="number" required />
    </div>
    <div class="form-group mb-3">
        <label class="form-label" for="date">{{ ('Date*') }}</label>
      <x-input id="date" name="date" class="form-control" type="date" required value="{{ now()->format('Y-m-d') }}"/>
    </div>
    <div class="form-group mb-3">
        <label class="form-label" for="description">{{ ('Description') }}</label>
       <textarea class="form-control" id="description" name="description" rows="2"></textarea>
       <span class="text-danger" id="descriptionError"></span>
    </div>
    <div class="mb-3 form-check">
        <label class="form-label" for="slip_download">{{ ('Slip Download') }}</label>
        <input type="checkbox" name="slip_download" class="form-check-input" id="slip_download">
    </div>
    <div>
         <button type="submit" class="btn btn-primary from-prevent-multiple-submits" >{{ ('Save') }}</button>
    </div>
</form>
<!-- Include Choices.js -->
<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
<script>
    // Initialize Choices.js for the event_id dropdown
    const element = document.getElementById('event_id');
    const choices = new Choices(element);
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

                                // Initialize Choices.js for the order_id dropdown
                                orderIdChoice = new Choices('#order_id', {
                                    placeholder: true,
                                    searchEnabled: true
                                })

                                // Add options to the order_id dropdown
                                orderIdChoice.setChoices(response.map(function(order) {
                                    return {
                                        value: order.order_id,
                                        label: order.order_id,
                                    };
                                }));
                            } else {
                                // Clear the order_id dropdown
                                orderDropdown.empty().append('<option value="">No orders found</option>');
                            }
                        },
                        error: function(error) {
                            console.error('Error fetching orders:', error);
                        }
                    });
                }
            });

            // Disable the submit button to prevent multiple submits
            $('#additionalExpensesForm').on('submit', function(e) {
                var description = $('#description').val();
                var expenseName = $('#name').val();
                var hasErrors = false;

                if (description.length > 255) {
                    $('#descriptionError').text('Description should be less than 255 characters.');
                    hasErrors = true;
                } else {
                    $('#descriptionError').text('');
                }

                if (expenseName.length > 255) {
                    $('#nameError').text('Expense Name should be less than 255 characters.');
                    hasErrors = true;
                } else {
                    $('#nameError').text('');
                }

                if (hasErrors) {
                    e.preventDefault();
                } else {
                    $('.from-prevent-multiple-submits').attr('disabled', 'true');
                    this.submit();
                    $('#commanModel').modal('hide');
                }
            });
        });
</script>

