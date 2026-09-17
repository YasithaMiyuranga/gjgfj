<!-- Edit Task Modal Content -->
<form action="{{ route('useradmin.task_templates.taskUpdate', ['taskTemplate' => $taskTemplate->id, 'task' => $task->id]) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="modal-header">
        <h5 class="modal-title">Edit Task</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>

    <div class="modal-body">
        <div class="form-group mb-3">
            <label for="modal-task-name">Task Name*</label>
            <input type="text" required id="modal-task-name" name="task_name" class="form-control"
                   value="{{ old('task_name', $task->task_name) }}">
        </div>

        <div class="form-group mb-3">
            <label for="modal-task-duration">Duration*</label>
            <input type="text" required id="modal-task-duration" name="task_duration" class="form-control"
                   value="{{ old('task_duration', $task->task_duration) }}">
        </div>

        <div class="form-group mb-3">
            <label for="modal-task-priority">Priority*</label>
            <select id="modal-task-priority" name="priority" required class="form-control">
                <option value="Low" {{ old('priority', $task->priority) == 'Low' ? 'selected' : '' }}>Low</option>
                <option value="Medium" {{ old('priority', $task->priority) == 'Medium' ? 'selected' : '' }}>Medium</option>
                <option value="High" {{ old('priority', $task->priority) == 'High' ? 'selected' : '' }}>High</option>
            </select>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-success"> Update Task </button>
    </div>
</form>
