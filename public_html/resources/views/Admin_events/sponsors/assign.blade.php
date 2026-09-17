<x-auth-validation-errors class="mb-4" :errors="$errors" />
<form method="post" action="{{ route('useradmin.events.sponsor_assign_store', ['eid' => $event->eid]) }}" enctype="multipart/form-data" id="sponsorAssignForm" data-ajax="true">
@csrf

<div class="form-group mb-3">
    <label class="form-label" for="name">{{ ('Event *') }}</label>
    <input class="form-control" name="event_id" type="text" id="event_name" value="{{ $event->event_name }}" readonly>
    @if ($errors->has('event_id'))
        <span class="text-danger">{{ $errors->first('event_id') }}</span>
    @endif
</div>
<div class="form-group mb-3">
    <label class="form-label" for="name">{{ ('Assign Sponsor To Event *') }}</label>
    <select class="form-control" name="sponsor_id" id="sponsor_id" required>
        <option value="">Select Sponsor</option>
        @foreach ($sponsors as $sponsor)
            <option value="{{ $sponsor->sponsor_id }}">{{ $sponsor->sponsor_name }}</option>
        @endforeach
    </select>
    @if ($errors->has('sponsor_id'))
        <span class="text-danger">{{ $errors->first('sponsor_id') }}</span>
    @endif
</div>
<div class="d-flex mb-3">
    <div class="d-grid">
        <button class="btn btn-primary btn-block mt-2" type="submit">{{ ('Assign Sponsor') }}</button>
    </div>
</div>
</form>

