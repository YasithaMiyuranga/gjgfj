<x-auth-validation-errors class="mb-4" :errors="$errors" />
<form method="post" action="{{ route('useradmin.events.update_event_status' ,['id' => $event->eid]) }}" enctype="multipart/form-data" id="eventStatusForm" data-ajax="true">
    @csrf
    <div class="form-group mb-3">
        <label class="form-label" for="artist_name">{{ ('Event Name *') }}</label>
        <x-input id="artist_name" name="event_name" class="form-control" type="text" required  value="{{ old('event_name', $event->event_name) }}" maxlength="255" readonly/>
        @if ($errors->has('event_name'))
            <span class="text-danger">{{ $errors->first('event_name') }}</span>
        @endif
    </div>
    <div class="form-group mb-3">
        <label class="form-label" for="phone_no">{{ ('Event Status *') }}</label>
        <select class="form-control" name="status" id="status" required>
            <option value="pending" {{  old('status', $event->order_status) == 'pending' ? 'selected' : '' }}>Pending Event
            </option>
            <option value="credit" {{ old('status', $event->status) == 'credit' ? 'selected' : '' }}>Credit Event
            </option>
            <option value="completed" {{ old('status', $event->status) == 'completed' ? 'selected' : '' }}>Complete Event
            </option>
            <option value="booking" {{ old('status',$event->status) == 'booking' ? 'selected' : '' }}>Booking Event
            </option>
            <option value="canceled" {{ old('status',$event->status) == 'canceled' ? 'selected' : ''}}>Canceled Event
            </option>

        </select>
        @if ($errors->has('event_status'))
            <span class="text-danger">{{ $errors->first('event_status') }}</span>
        @endif
    </div>
    <div class="d-flex mb-3">
        <div class="d-grid">
            <button class="btn btn-primary btn-block mt-2" type="submit">{{ ('Update Event Status') }}</button>
        </div>
    </div>
</form>
