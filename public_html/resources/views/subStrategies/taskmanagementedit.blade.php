<style>
    .custom-column-container {
        position: relative;
        border: 1px solid rgb(255, 255, 255) !important;
        background-color: transparent !important;
        padding-top: 0.5rem !important;
    }

    .close-column {
        line-height: 1;
        font-weight: bold;
        z-index: 10;
        top: -35px !important;
    }

    .task-column-box {
        min-height: 500px;
        max-height: 500px;
        overflow-y: auto;
        background-color: transparent !important;
    }

    .task-item {
        background-color: #21232b;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        margin-right: 10px;
        position: relative;
    }

    .task-priority-badge {
        position: absolute;
        bottom: 8px;
        right: 8px;
    }

    .buttons {
        display: inline-block;
    }

    .task-edit-icon {
        position: absolute;
        top: 8px;
        right: 8px;
        background: transparent;
        border: 1px solid !important;
        border-radius: 3px;
        font-size: 14px;
        line-height: 1;
        padding: 0;
        cursor: pointer;
        margin-right: 20px;
        border: 1px solid #ffa21d !important;
        color: #ffa21d;
    }

    .task-delete-icon {
        position: absolute;
        top: 8px;
        right: 8px;
        background: transparent;
        border: 1px solid !important;
        border-radius: 3px;
        color: #dc3545;
        font-size: 14px;
        line-height: 1;
        padding: 0;
        cursor: pointer;
    }

    .column-divider {
        margin-top: 20px !important;
        margin-bottom: 15px;
        border-top: 1px solid;
    }

    .column-title {
        font-size: 1.1rem;
        display: flex;
        align-items: center;
    }

    .count {
        font-size: 0.75rem;
        padding: 4px 10px;
    }

    .column-title-indent {
        display: flex;
        align-items: center;
        padding-left: 12px;
    }

    .column-title-wrapper {
        position: relative;
    }

    .column-title-wrapper .count {
        font-size: 0.8rem;
        padding: 5px 8px;
        margin-left: 0.5rem;
    }

    #columns-container {
        display: flex;
        flex-wrap: nowrap;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        gap: 15px;
        padding-bottom: 10px;
    }

    #columns-container {
        scrollbar-color: #6c757d transparent;
        scrollbar-width: bold;
    }

    #columns-container::-webkit-scrollbar {
        height: 8px;
    }

    #columns-container::-webkit-scrollbar-thumb {
        background-color: #6c757d;
        border-radius: 4px;
    }

    #columns-container::-webkit-scrollbar-thumb:hover {
        background-color: #999;
    }

    .kanban-column {
        flex: 0 0 300px;
        max-width: 400px;
        min-width: 400px;
    }

    @media (max-width: 1650px) {
        .kanban-column {
            flex: 0 0 280px;
            max-width: 350px;
            min-width: 280px;
        }
    }


    @media (max-width: 768px) {
        .kanban-column {
            flex: 0 0 250px;
            max-width: 300px;
            min-width: 250px;
        }
    }
</style>
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <form method="POST" id="task-template-form"
                action="{{ route('useradmin.str_task_templates.update', $taskTemplate->id) }}">
                @csrf
                @method('PUT')
                <div class="card-header mb-3">
                    <h3>Edit Task Template</h3>
                </div>
                <div class="card-body table-border-style p-15">
                    <div class="add-task-form mb-4">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="template_name" class="form-label">Template Name*</label>
                                <input type="text" class="form-control" name="template_name" required
                                    id="template_name" placeholder="Enter Template Name"
                                    value="{{ old('template_name', $taskTemplate->template_name) }}">
                                @error('template_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="event_category" class="form-label">Event Category*</label>
                                <select class="form-control" id="event_category" name="event_category" required>
                                    <option value="" disabled>Select Event Category</option>
                                    @foreach ($eventCategories as $category_type)
                                        <option value="{{ $category_type->id }}"
                                            {{ old('event_category', $taskTemplate->event_category_id) == $category_type->id ? 'selected' : '' }}>
                                            {{ $category_type->category_name }}</option>
                                    @endforeach
                                </select>
                                @error('event_category')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="new_statuses" id="new_statuses_input" value="">
                    <input type="hidden" name="removed_statuses" id="removed_statuses_input" value="">
                    <input type="hidden" name="all_statuses" id="all_statuses_input" value="">

                    <div class="mb-4 d-flex justify-content-between align-items-center">
                        <button type="button" style="display: none;" id="add-task"
                            class="btn btn-success btn-sm add-task">
                            <i class="ti ti-plus"></i> Add Task
                        </button>
                        <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal"
                            data-bs-target="#addCategoryModal">
                            + Add Category
                        </button>
                    </div>

                    @php
                        function getStatusIcon($status)
                        {
                            switch ($status) {
                                case 'Pending':
                                    return '<i class="fas fa-hourglass-start me-2"></i>';
                                case 'In Progress':
                                    return '<i class="fas fa-spinner me-2"></i>';
                                case 'Completed':
                                    return '<i class="fas fa-check me-2"></i>';
                                default:
                                    return '<i class="fas fa-tag me-2"></i>';
                            }
                        }

                        // Only use existing columns (remove default ones)
                        $allColumns =
                            $taskTemplate->columns
                                ?->keyBy('column_name')
                                ->map(function ($column) {
                                    return ['titleColor' => $column->color]; // Assuming 'color' field exists for custom columns
                                })
                                ->toArray() ?? [];
                    @endphp

                    <div class="row mb-3 flex-nowrap overflow-auto" id="columns-container">
                        @foreach ($taskTemplateStatus as $status)
                            <div class="modal fade" id="addTaskModal{{ $status->name }}" tabindex="-1"
                                aria-labelledby="addTaskModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="addTaskModalLabel">Add New Task</h5>
                                            <button type="button" onclick="closeAddTaskModal('{{ $status->name }}')"
                                                class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group mb-3">
                                                <label for="modal-task-name">Task Name*</label>
                                                <input type="text" id="modal-task-name{{ $status->name }}"
                                                    class="form-control">
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="modal-task-duration">Duration*</label>
                                                <input type="text" id="modal-task-duration{{ $status->name }}"
                                                    class="form-control">
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="modal-task-priority">Priority*</label>
                                                <select id="modal-task-priority{{ $status->name }}"
                                                    class="form-control">
                                                    <option value="High">High</option>
                                                    <option value="Medium">Medium</option>
                                                    <option value="Low" selected>Low</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                                                onclick="closeAddTaskModal('{{ $status->name }}')">Cancel</button>
                                            <button type="button" onclick="addTask('{{ $status->name }}')"
                                                class="btn btn-success">Add
                                                Task</button>
                                        </div>
                                    </div>
                                </div>
                            </div>








                            <div class="kanban-column">
                                <div class="border rounded p-2 mb-3 border-white custom-column-container"
                                    data-column="${name}">
                                    <div class="column-header text-start mb-3">
                                        <div class="column-title-wrapper position-relative">
                                            <div class="d-flex justify-content-end mb-2">
                                                <div class="d-flex gap-1">

                                                    <button type="button"
                                                        onclick="openAddTaskModal('{{ $status->name }}')"
                                                        class="btn btn-sm btn-outline-success" title="add task">
                                                        <i class="ti ti-plus"></i>
                                                    </button>

                                                    <button type="button"
                                                        class="btn btn-sm btn-outline-warning edit-column"
                                                        data-url="{{ route('useradmin.task_templates.categoryedit', [$taskTemplate->id, $status->id]) }}"
                                                        title="Edit Category">
                                                        <i class="ti ti-pencil"></i>
                                                    </button>
                                                    <button type="button"
                                                        class="btn btn-sm btn-outline-danger close-column"
                                                        title="Remove Column">
                                                        &times;
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-start mt-4 ps-2">
                                                <h3 class="column-title m-0 me-2" style="color: ${color};">
                                                    <span id="status-name-{{ $status->id }}">{{ $status->name }}</span>
                                                </h3>
                                                <span class="count badge bg-secondary rounded-pill">0</span>
                                            </div>
                                        </div>
                                        <hr class="column-divider">
                                    </div>
                                    <div class="tasks-column task-column-box" id="tasks-column-{{ $status->name }}"
                                        data-column="{{ $status->name }}">
                                        @foreach ($taskTemplate->tasks as $task)
                                            @if ($task->status_id == $status->id)
                                                <div style="margin-right: 0px !important;"
                                                    class="task-item border rounded p-3 mb-1 d-flex flex-column"
                                                    data-task-index="{{ $task->id }}" draggable="true">
                                                    <input type="hidden" name="tasks[{{ $task->id }}][id]"
                                                        value="{{ $task->id }}">
                                                    <input type="hidden" name="tasks[{{ $task->id }}][name]"
                                                        value="{{ $task->task_name }}">
                                                    <input type="hidden" name="tasks[{{ $task->id }}][duration]"
                                                        value="{{ $task->task_duration }}">
                                                    <input type="hidden" name="tasks[{{ $task->id }}][priority]"
                                                        value="{{ $task->priority }}">
                                                    <input type="hidden" name="tasks[{{ $task->id }}][status]"
                                                        value="{{ $status->name }}" class="task-column">
                                                    <div class="d-flex flex-column">
                                                        <strong>{{ $task->task_name }}</strong>
                                                        <small class="text-muted mt-2"><i
                                                                class="ti ti-clock me-1"></i>{{ $task->task_duration }}</small>
                                                    </div>
                                                    @php
                                                        $priorityClasses = [
                                                            'High' => 'bg-danger',
                                                            'Medium' => 'bg-warning',
                                                            'Low' => 'bg-success',
                                                        ];
                                                    @endphp
                                                    <span
                                                        class="badge {{ $priorityClasses[$task->priority] ?? 'bg-secondary' }} text-white task-priority-badge">{{ $task->priority }}</span>

                                                    <div class="buttons" style="display: inline-block;">
                                                        <button type="button" class="task-edit-icon edit-task"
                                                            data-url="{{ route('useradmin.task_templates.taskedit', [$taskTemplate->id, $task->id]) }}"
                                                            title="Edit Task">
                                                            <i class="ti ti-pencil"></i>
                                                        </button>
                                                        <button type="button" class="task-delete-icon delete-task"
                                                            data-task-id="{{ $task->id }}" title="Delete Task">
                                                            <i class="ti ti-x"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" id="updateTemplateBtn" class="btn btn-primary" hidden>Update
                            Template</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCategoryModalLabel">Add New Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="new-category-name">Status Name*</label>
                    <input type="text" id="new-category-name" class="form-control"
                        placeholder="Enter status name">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="add-category-btn">Add Category</button>
            </div>
        </div>
    </div>
</div>





<div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCategoryModalLabel">Edit Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="edit-category-name">Status Name*</label>
                    <input type="text" id="edit-category-name" class="form-control"
                        placeholder="Enter status name">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="edit-category-btn">Save Changes</button>
            </div>
        </div>
    </div>
</div>

{{-- <div class="modal fade" id="addTaskModal" tabindex="-1" aria-labelledby="addTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addTaskModalLabel">Add New Task</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group mb-3">
                    <label for="modal-task-name">Task Name*</label>
                    <input type="text" id="modal-task-name" class="form-control">
                </div>
                <div class="form-group mb-3">
                    <label for="modal-task-duration">Duration*</label>
                    <input type="text" id="modal-task-duration" class="form-control">
                </div>
                <div class="form-group mb-3">
                    <label for="modal-task-priority">Priority*</label>
                    <select id="modal-task-priority" class="form-control">
                        <option value="High">High</option>
                        <option value="Medium">Medium</option>
                        <option value="Low" selected>Low</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" id="confirm-add-task">Add Task</button>
            </div>
        </div>
    </div>
</div> --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Popper.js (required for Bootstrap 4 tooltips/modals) -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<!-- Bootstrap 4 JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.6.2/js/bootstrap.min.js"></script>
{{-- Include jQuery library --}}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    let taskIndex = {{ $taskTemplate->tasks->max('id') ? $taskTemplate->tasks->max('id') + 1 : 1 }};
    let deletedTasks = [];


    function addTask(statusName) {
        const name = $('#modal-task-name' + statusName).val();
        const duration = $('#modal-task-duration' + statusName).val();
        const priority = $('#modal-task-priority' + statusName).val();

        if (name && duration && priority) {
            const firstColumn = $(`.tasks-column[data-column="${statusName}"]`).data('column');
            const html = createTaskCard(taskIndex, name, duration, priority, firstColumn);
            $(`.tasks-column[data-column="${firstColumn}"]`).append(html);
            taskIndex++;
            $('#addTaskModal' + statusName).modal('hide');
            $('#modal-task-name' + statusName).val('');
            $('#modal-task-duration' + statusName).val('');
            $('#modal-task-priority' + statusName).val('Low');
            updateCounts();
        }
    }



    function openAddTaskModal(statusName) {
        $('#addTaskModal' + statusName).modal('show');
    }

    function closeAddTaskModal(statusName) {
        $('#addTaskModal' + statusName).modal('hide');
    }





    // Hidden input for deleted tasks
    if ($('#deleted-tasks').length === 0) {
        $('#task-template-form').append('<input type="hidden" name="deleted_tasks[]" id="deleted-tasks">');
    }

    function createTaskCard(index, name, duration, priority, column = 'Pending', taskId = null) {
        const priorityClasses = {
            'High': 'bg-danger',
            'Medium': 'bg-warning',
            'Low': 'bg-success'
        };
        const taskIdInput = taskId ? `<input type="hidden" name="tasks[${index}][id]" value="${taskId}">` : '';
        const deleteButton =
            `<button type="button" class="task-delete-icon delete-task" data-task-id="${taskId || 'new-' + index}" title="Delete Task"><i class="ti ti-x"></i></button>`;

        return `
                <div style="margin-right: 0px !important;" class="task-item border rounded p-3 mb-1 d-flex flex-column" data-task-index="${index}" draggable="true">
                ${taskId ? `<input type="hidden" name="tasks[${index}][id]" value="${taskId}">` : ''}
                    <input type="hidden" name="tasks[${index}][name]"     value="${name}">
                    <input type="hidden" name="tasks[${index}][duration]" value="${duration}">
                    <input type="hidden" name="tasks[${index}][priority]" value="${priority}">
                    <input type="hidden" name="tasks[${index}][status]"   value="${column}" class="task-column">
                    <div class="d-flex flex-column">
                        <strong style="color: white;">${name}</strong>
                        <small class="text-muted mt-2" style="color: white;"><i class="ti ti-clock me-1"></i>${duration}</small>
                    </div>
                    <span class="badge ${priorityClasses[priority]} text-white task-priority-badge">${priority}</span>
                    <div class="buttons" style="display: inline-block;">
                        <button type="button" class="task-edit-icon edit-task"
                            data-url="{{ route('useradmin.task_templates.taskedit', [$taskTemplate->id, $task->id ?? '']) }}" title="Edit Task">
                            <i class="ti ti-pencil"></i>
                        </button>
                        <button type="button" class="task-delete-icon delete-task"
                            data-task-id="{{ $task->id ?? '' }}" title="Delete Task">
                            <i class="ti ti-x"></i>
                        </button>
                    </div>
                </div>`;
    }

    $(document).on('click', '.add-task', function() {
        $('#addTaskModal').modal('show');
    });

    $('#confirm-add-task').on('click', function() {                  
        const name = $('#modal-task-name').val();
        const duration = $('#modal-task-duration').val();
        const priority = $('#modal-task-priority').val();

        if (name && duration && priority) {
            const firstColumn = $('.tasks-column[data-column]').first().data('column');
            const html = createTaskCard(taskIndex, name, duration, priority, firstColumn);
            $(`.tasks-column[data-column="${firstColumn}"]`).append(html);
            taskIndex++;
            $('#addTaskModal').modal('hide');
            $('#modal-task-name').val('');
            $('#modal-task-duration').val('');
            $('#modal-task-priority').val('Low');
            updateCounts();
        }
    });

    // Delete task
    $(document).on('click', '.delete-task', function() {
        const taskId = $(this).data('task-id');

        // Only track existing tasks (numeric IDs) for backend deletion
        if (!isNaN(taskId)) {
            deletedTasks.push(taskId);
            $('#deleted-tasks').val(deletedTasks.join(','));
        }

        // Remove task from DOM
        $(this).closest('.task-item').remove();
        updateCounts();
    });

    // Drag & drop
    // $(document).on('dragstart', '.task-item', function(e) {
    //     window.draggedTask = this;
    // });

    // $(document).on('dragover', '.tasks-column', function(e) {
    //     e.preventDefault();
    // });

    // $(document).on('drop', '.tasks-column', function(e) {
    //     e.preventDefault();
    //     if (window.draggedTask) {
    //         $(this).append(window.draggedTask);
    //         const newColumn = $(this).data('column');
    //         $(window.draggedTask).find('.task-column').val(newColumn);
    //         $(window.draggedTask).find('input[name$="[status]"]').val(newColumn); // Update status hidden input
    //         window.draggedTask = null;
    //         updateCounts();
    //     }
    // });

    let $placeholder = $('<div class="task-placeholder border rounded mb-3"></div>')
        .css({
            height: '40px',
            background: 'rgba(0, 0, 0, 0.1)',
            border: '2px dashed #999',
            margin: '5px 0'
        })
        .hide();



    $(document).on('dragstart', '.task-item', function(e) {
        window.draggedTask = this;
        $placeholder.height($(this).outerHeight());
        $(this).after($placeholder);
        setTimeout(() => {
            $(this).hide(); // hide dragged task until drop
        }, 0);
    });

    $(document).on('dragover', '.tasks-column', function(e) {
        e.preventDefault();
        const $tasks = $(this).children('.task-item').not(window.draggedTask);
        let placed = false;

        $tasks.each(function() {
            const offset = $(this).offset();
            const height = $(this).outerHeight();
            if (e.pageY < offset.top + height / 2) {
                $(this).before($placeholder.show());
                placed = true;
                return false; // break
            }
        });

        if (!placed) {
            $(this).append($placeholder.show());
        }
    });

    $(document).on('drop', '.tasks-column', function(e) {
        e.preventDefault();
        if (window.draggedTask) {
            $(window.draggedTask).show();
            $placeholder.replaceWith(window.draggedTask);

            const newColumn = $(this).data('column');
            $(window.draggedTask).find('.task-column').val(newColumn);
            $(window.draggedTask).find('input[name$="[status]"]').val(newColumn);

            window.draggedTask = null;
            updateCounts();
        }
    });

    $(document).on('dragend', '.task-item', function() {
        $placeholder.hide();
        $(window.draggedTask).show();
        window.draggedTask = null;
    });



    function updateCounts() {
        $('.custom-column-container').each(function() {
            const count = $(this).find('.tasks-column .task-item').length;
            $(this).find('.count').text(count);
        });
    }

    // $('#task-template-form').on('submit', function(e) {

    //     const currentColumns = [];
    //     $('.custom-column-container').each(function() {
    //         currentColumns.push($(this).find('.column-title span').text().trim());
    //     });
    //     $('#all_statuses_input').val(currentColumns.join(','));
    // });

    $(document).ready(function() {
        updateCounts();

    });

    $(document).on('click', '.close-column', function() {
        const column = $(this).closest('.kanban-column');
        const name = column.find('.column-title span').text().trim();

        removedStatuses.push(name); // <-- new
        $('#removed_statuses_input').val(removedStatuses.join(',')); // <-- new

        column.remove();
        updateCounts();
    });
    let newStatuses = [];
    let removedStatuses = [];

    $(document).on('click', '.edit-task', function() {
        let url = $(this).data('url');

        $.get(url, function(html) {
            $('#addTaskModal .modal-content').html(html);

            $('#addTaskModal').modal('show');
        }).fail(function() {
            alert('Unable to load task details.');
        });
    });


    $('#edit-category-btn').on('click', function() {
        const newName = $('#edit-category-name').val().trim();
        $('#status-name-{{$status->id }}').modal('hide');
    })


    $(document).on('click', '.edit-column', function() {
        let url = $(this).data('url');

        $('#editCategoryModal').modal('show');

    });

    $('#add-category-btn').on('click', function() {
        const name = $('#new-category-name').val().trim();
        if (!name) return;

        // Prevent duplicates
        if (newStatuses.includes(name)) {
            return;
        }

        newStatuses.push(name);
        $('#new_statuses_input').val(newStatuses.join(','));


        console.log(newStatuses);

        const color = '#' + Math.floor(Math.random() * 16777215).toString(16);
        const icon = '<i class="fas fa-tag me-2"></i>';
        const html = `





<div class="modal fade" id="addTaskModal${name}" tabindex="-1"
                                aria-labelledby="addTaskModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="addTaskModalLabel">Add New Task</h5>
                                            <button type="button" onclick="closeAddTaskModal('${name}')"
                                                class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group mb-3">
                                                <label for="modal-task-name">Task Name*</label>
                                                <input type="text" id="modal-task-name${name}"
                                                    class="form-control">
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="modal-task-duration">Duration*</label>
                                                <input type="text" id="modal-task-duration${name}"
                                                    class="form-control">
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="modal-task-priority">Priority*</label>
                                                <select id="modal-task-priority${name}"
                                                    class="form-control">
                                                    <option value="High">High</option>
                                                    <option value="Medium">Medium</option>
                                                    <option value="Low" selected>Low</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                                                onclick="closeAddTaskModal('${name}')">Cancel</button>
                                            <button type="button" onclick="addTask('${name}')"
                                                class="btn btn-success">Add
                                                Task</button>
                                        </div>
                                    </div>
                                </div>
                            </div>








                <div class="kanban-column">
                    <div class="border rounded p-2 mb-3 border-white custom-column-container" data-column="${name}">
                        <div class="column-header text-start mb-3">
                            <div class="column-title-wrapper position-relative" >
                                <div class="d-flex justify-content-end mb-2">
                                    <div class="d-flex gap-1">

                                         <button type="button"
                                                        onclick="openAddTaskModal('${name}')"
                                                        class="btn btn-sm btn-outline-success" title="add task">
                                                        <i class="ti ti-plus"></i>
                                                    </button>
                                        <button type="button"
                                            class="btn btn-sm btn-outline-warning edit-column"
                                            data-url="{{ route('useradmin.task_templates.categoryedit', [$taskTemplate->id, $status->id]) }}"
                                            title="Edit Category">
                                            <i class="ti ti-pencil"></i>
                                        </button>
                                        <button type="button"
                                            class="btn btn-sm btn-outline-danger close-column"
                                            title="Remove Column">
                                            &times;
                                        </button>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center justify-content-start mt-4 ps-2">
                                    <h3 class="column-title m-0 me-2" style="color: ${color};">
                                        ${icon}<span>${name}</span>
                                    </h3>
                                    <span class="count badge bg-secondary rounded-pill">0</span>
                                </div>
                            </div>
                            <hr class="column-divider" >
                        </div>
                        <div class="tasks-column task-column-box" data-column="${name}"></div>
                    </div>
                </div>`;
        $('#columns-container').append(html);
        $('#new-category-name').val('');
        // $('#addCategoryModal').modal('hide');
        updateCounts();
    });
    $(document).ready(function() {
        updateCounts();
    });


    $('#task-template-form').on("submit", async function(e) {
        const form = this;

        const currentColumns = [];
        $('.custom-column-container').each(function() {
            currentColumns.push($(this).find('.column-title span').text().trim());
        });
        $('#all_statuses_input').val(currentColumns.join(','));

        e.preventDefault(); // stop normal submit

        const formData = new FormData(form);

        try {
            const res = await fetch(form.action, {
                method: "POST", // still POST, because @method('PUT') hidden input handles spoofing
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
                        .content
                },
                body: formData
            });

            const data = await res.json().catch(() => null);

            if (res.ok) {
                alert("Template updated successfully!");
                console.log("Response:", data);
                // Optionally reload or update UI here:
                // location.reload();
            } else {
                alert("Something went wrong while updating.");
                console.error("Error:", data);
            }
        } catch (err) {
            console.error("Fetch error:", err);
            alert("Network error, please try again.");
        }
    });


    // document.addEventListener("DOMContentLoaded", () => {



    //     const form = document.getElementById("task-template-form");

    //     form.
    // });

    function save() {
        $("#updateTemplateBtn").click();
    }
</script>
