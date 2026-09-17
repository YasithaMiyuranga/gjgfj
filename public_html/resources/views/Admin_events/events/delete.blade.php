<x-auth-validation-errors class="mb-4" :errors="$errors" />
<form action="{{ route('useradmin.events.event_delete', $eid) }}" method="POST" class="d-inline">
    @csrf
    @method('DELETE')
    <p>Are you Sure Delete this Event</p>
    <button type="submit" class="btn btn-sm btn-danger">
        Delete
    </button>
</form>


