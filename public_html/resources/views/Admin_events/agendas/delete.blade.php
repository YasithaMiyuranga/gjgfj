<x-auth-validation-errors class="mb-4" :errors="$errors" />
<form action="{{ route('useradmin.agenda.delete', $agenda->id) }}" method="POST" class="d-inline">
    @csrf
    @method('DELETE')
    <p>Are you Sure Delete This Agenda With Agenda Details</p>
    <button type="submit" class="btn btn-sm btn-danger">
        Delete
    </button>
</form>
