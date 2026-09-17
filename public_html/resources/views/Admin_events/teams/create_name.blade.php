<x-auth-validation-errors class="mb-4" :errors="$errors" />
<form method="post" action="{{ route('useradmin.events.team_category.store') }}" id="teamNameForm">
    @csrf

    <div class="row">
        <div class="form-group">
            <label for="event_name" class="form-label">Event: *</label>
            <select class="form-control select1" name="event_id" id="event_name" required>
            <option value="">Select Event</option>
            @foreach ($events as $event)
                <option value="{{ $event->eid }}"
                    {{ old('event_id', $selectedEventId ?? '') == $event->eid ? 'selected' : '' }}>
                    {{ $event->event_name }}
                </option>
            @endforeach
            </select>
        </div>
        <div class="form-group mb-3">
            <label for="team_name" class="form-label">Team Name: *</label>
            <input type="text" class="form-control" name="team_name" id="team_name" required
                value="{{ old('team_name') }}">
            <div id="teamNameError" class="text-danger mt-1"></div> 
        </div>

    </div>
    <div class="d-flex mb-3 justify-content-end">
        <div class="d-grid">
            <button class="btn btn-primary" type="submit" id="submitBtn">
                Add Name
            </button>
        </div>
    </div>
</form>

