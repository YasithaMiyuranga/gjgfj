<x-auth-validation-errors class="mb-4" :errors="$errors" />
<form method="post" action="{{ route('useradmin.assign-permissions.store') }}" enctype="multipart/form-data" id="assignPermissionsForm" ajax-popup="true">
@csrf
<input type="hidden" name="emp_id" value="{{ $employe->emp_id }}">
<div class="form-group mb-3">
    <label class="form-label" for="emp_id">{{ ('Employee Name') }}</label>
     <x-input id="name" class="form-control" type="text" name="name" required value="{{ old('name', $employe->name) }}" readonly/>
</div>
<div class="table-responsive">
    <table class="table dataTable">
        <thead>
            <th>Permission Name</th>
            <th>Assign</th>
        </thead>
        <tbody>
          @foreach ($permissions as $permission)
              <tr>
                  <td>{{ $permission->name }}</td>
                  <td>
                      <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" id="permission_{{ $permission->id }}"
                          @if(in_array($permission->id, $assignedPermissions)) checked @endif>
                  </td>
              </tr>
          @endforeach
        </tbody>
    </table>
</div>
<div class="d-flex mb-3">
    <div class="d-grid">
        <button id="submitButton" class="btn btn-primary btn-block mt-2" type="submit"> {{ ('Save') }} </button>
    </div>
</div>
</form>

