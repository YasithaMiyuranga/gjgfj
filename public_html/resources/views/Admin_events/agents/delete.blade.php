<x-auth-validation-errors class="mb-4" :errors="$errors" />
<form action="{{ route('useradmin.events.delete_agent', $id) }}" method="POST" class="d-inline">
    @csrf
    @method('DELETE')
    <p>Are you Sure Delete this agent</p>
    <button type="submit" class="btn btn-sm btn-danger">
        Delete
    </button>
</form>
