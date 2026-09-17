<x-auth-validation-errors class="mb-4" :errors="$errors" />
<form method="post" action="{{ route('useradmin.strategies.events.team_category.store') }}" id="teamNameForm">
    @csrf

    <div class="row">
        <div class="form-group">
            <label for="event_name" class="form-label">Event: *</label>
            <select class="form-control select1" name="event_id" id="event_name_pop" required>
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
            <input type="text" class="form-control" name="team_name" id="team_name_pop" required
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


<script>
    document.getElementById('teamNameForm').addEventListener('submit', function(e) {
        e.preventDefault();
        //form submit ajax
        var formData = new FormData(this);
        fetch("{{ route('useradmin.strategies.events.team_category.store') }}", {
                method: "POST",
                body: formData,
                headers: {
                    "X-Requested-With": "XMLHttpRequest"
                }
            })
            .then(response => response.json())
            .then(data => {

                if (data.success) {

                    console.log(data);

                    //clear the fields
                    document.getElementById('event_name_pop').value = '';
                    document.getElementById('team_name_pop').value = '';
                    //close the modal if any
                    var modal = document.querySelector('.modal');
                    if (modal) {
                        modal.classList.remove('show');
                        modal.style.display = 'none';
                        modal.setAttribute('aria-hidden', 'true');
                    }
                } else {
                    // Handle validation errors
                    for (const [field, messages] of Object.entries(data.errors)) {
                        const errorElement = document.getElementById(field + 'Error');
                        if (errorElement) {
                            errorElement.innerText = messages.join(', ');
                        }
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    });
</script>
