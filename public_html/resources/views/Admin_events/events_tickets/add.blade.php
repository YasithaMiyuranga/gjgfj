<x-auth-validation-errors class="mb-4" :errors="$errors" />
<form method="post" action="{{ route('useradmin.events.ticket_store') }}" enctype="multipart/form-data" id="EventTicketForm" data-ajax="true">
    @csrf
    <div class="form-group mb-3">
        <label for="event_name" class="form-label">Event Name:  *</label>
        <select class="form-control" name="event_id" id="event_id" required>
            <option value="">Select Event Name</option>
          @foreach ($events as $event)
              <option id="{{ $event->eid }}" value="{{ $event->eid }}"
                  {{ ($selectedEvent && $selectedEvent->eid == $event->eid) || old('event_name') == $event->event_name ? 'selected' : '' }}>
                  {{ $event->event_name }}
              </option>
          @endforeach
        </select>
    </div>
    <div class="form-group mb-3">
        <label class="form-label" for="currency">{{ __('Currency    *') }}</label>
        <x-input id="currency" name="currency" class="form-control" value="{{ old('currency', $existingTickets[0]->currency?? '') }}"   type="text" required />
    </div>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>
                        {{ __('Ticket Name') }}
                        <button type="button" class="btn btn-warning mb-3" id="addTicketTypeBtn"><i
                                class="fas fa-plus"></i> Add</button>
                    </th>
                    <th>{{ __('price') }}</th>
                    <th>{{ __('No Of Tickets') }}</th>
                    <th>{{ __('Action') }}</th>
                </tr>
            </thead>
            @if( isset( $existingTickets ))
                <!-- existing tickets -->
                <tbody id="existing_ticket_info_body">
                    @foreach ($existingTickets as $ticket)
                        <tr>
                            <input type="hidden" name="ticket_id[]" id="ticket_id" value="{{ $ticket->id }}">
                            <td>
                                <div class="form-group mb-3">
                                    <input type="text" class="form-control" name="ticket_name[]"
                                        value="{{ $ticket->tickets_category }}" maxlength="100" required>
                                </div>
                            </td>
                            <td>
                                <div class="form-group mb-3">
                                    <input type="number" class="form-control" name="price[]"
                                        value="{{ $ticket->price }}" min="1" required>
                                </div>
                            </td>
                            <td>
                                <div class="form-group mb-3">
                                    <input type="number" class="form-control" name="no_of_tickets[]"
                                        value="{{ $ticket->number_of_tickets }}" min="1" required>
                                </div>
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger btn-md" onclick="deleteExistTicketRow(this,{{ $ticket->id }})">Delete</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            @endif
            <tbody id="ticket_info_body">
            </tbody>
        </table>
    </div>
    <div class="d-flex mb-3">
        <div class="d-grid">
            <button class="btn btn-primary btn-block mt-2" type="submit">{{ __('Add Tickets') }}</button>
        </div>
    </div>
</form>
<script>
    $removeIds = [];
    $(document).ready(function() {
        // Initialize Choices for the order_id dropdown
        const orderIdChoice = new Choices('#event_id', {
            placeholder: true,
            searchEnabled: true,
        });
    })
    //Delete row in tickets table
    function deleteRow(button) {
        var row = button.parentNode.parentNode;
        row.parentNode.removeChild(row);
    }
    // Delete exist added tickets
    function deleteExistTicketRow(button, ticketId) {
        // remove in ticket_id array
        var ticketIds = document.getElementsByName('ticket_id[]');
        for (var i = 0; i < ticketIds.length; i++) {
            if (ticketIds[i].value == ticketId) {
                $removeIds.push(ticketIds[i].value);
                break;
            }
        }
        // Remove the row from the table
        var row = button.parentNode.parentNode;
        row.parentNode.removeChild(row);
    }
    //Add new row for  tickets
    function  addTicketsRow(){
        var newRow = document.createElement('tr');
        newRow.innerHTML = `
            <td> <input type="text" class="form-control" name="ticket_name[]" ></td>
            <td><input type="text" class="form-control" name="price[]" ></td>
            <td><input type="number" class="form-control" name="no_of_tickets[]"><td>
                <button type="button" class="btn btn-danger btn-md" onclick="deleteRow(this)">Delete</button>
            </td>
        `;
        document.getElementById('ticket_info_body').appendChild(newRow);
    }
    // Add event listner to add new ticket type
    addTicketTypeBtn.addEventListener('click', function() {
        addTicketsRow();
    });
</script>
