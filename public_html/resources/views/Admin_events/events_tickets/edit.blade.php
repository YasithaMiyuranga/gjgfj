
<x-auth-validation-errors class="mb-4" :errors="$errors" />
<form method="post" action="{{ route('useradmin.events.ticket_update', [ $ticketDetails->id ]) }}" enctype="multipart/form-data" id="EventTicketForm" data-ajax="true" >
    @csrf
    <div class="form-group mb-3">
        <label for="event_name" class="form-label">{{_('Event Name  *')}}:</label>
        <x-input value="{{ $event->event_name }}" id="event_name" name="event_name" class="form-control" type="text" readonly required />
            <input type="text" name="event_id" value="{{ $event->eid }}"hidden>
    </div>
    <div class="form-group mb-3">
        <label class="form-label" for="currency">{{ ('Currency    *') }}</label>
        <x-input value="{{ $ticketDetails->currency }}" id="currency" name="currency" class="form-control" type="text"
            required />
    </div>
    <div class="form-group mb-3">
        <label class="form-label" for="ticket_name">{{ ('Ticket Name  *') }}</label>
        <x-input value="{{ $ticketDetails->tickets_category }}" id="ticket_name" name="ticket_name" class="form-control" type="text" maxlength="100"
            required />
    </div>
    <div class="form-group mb-3">
        <label class="form-label" for="price">{{ ('Price  *') }}</label>
        <x-input value="{{ $ticketDetails->price }}" id="price" name="price" class="form-control" type="number" min="1"
            required />
    </div>
    <div class="form-group mb-3">
        <label class="form-label" for="no_of_tickets">{{ ('No Of Tickets    *') }}</label>
        <x-input value="{{ $ticketDetails->initial_tickets_count }}" id="no_of_tickets" name="no_of_tickets" class="form-control" type="number" min="1"
            required />
    </div>
    <div class="d-flex mb-3">
        <div class="d-grid">
            <button class="btn btn-primary btn-block mt-2" type="submit">{{ ('Update Ticket Details') }}</button>
        </div>
    </div>
</form>
