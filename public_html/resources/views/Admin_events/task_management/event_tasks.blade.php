@extends('layouts.events')
@section('page-title', 'Event Tasks')
@section('action-button')
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('useradmin.events.task.index') }}">{{ __('Event Tasks') }}</a>
    </li>
@endsection
@section('content')
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 1900px !important;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .event-selector {
            padding: 8px 12px;
            border-radius: 4px;
            border: 1px solid #ddd;
            font-size: 16px;
        }

        .search-box {
            padding: 8px 12px;
            border-radius: 4px;
            border: 1px solid #ddd;
            font-size: 16px;
        }

        .column-content {
            max-height: 700px;
            overflow-y: auto;

        }

        .column {
            border: 0.25px solid #6b6969;
            border-radius: 10px;
            padding: 15px;
            width: 500px;
            min-height: 500px;
        }

        .column-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .task {
            background-color: #22242b;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            position: relative;
        }

        #add-task {
            border-radius: 50%;
            padding: 10px;
        }

        #add-task:hover::after {
            content: "Add Task";
            position: absolute;
            background-color: #050505;
            border: 1px solid #ddd;
            padding: 5px;
            margin-top: 20px;
            margin-left: -50px;
            font-size: 12px;
        }

        .count {
            background: #e0e0e0;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 15px;
            color: blue;
        }

        .task:hover {
            background: #272931ad;
        }

        .task-name {
            white-space: normal;
            word-wrap: break-word;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .task-duration {
            color: #666;
            font-size: 12px;
        }

        .placeholder {
            height: 60px;
            border: 2px dashed #007bff;
            border-radius: 5px;
            margin: 8px 0;
            background: rgba(0, 123, 255, 0.05);
        }

        .add-task {
            margin-top: 15px;
            padding: 10px;
            text-align: center;
            color: #007bff;
            cursor: pointer;
            border: 1px dashed #007bff;
            border-radius: 6px;
        }

        .add-task:hover {
            background: rgba(0, 123, 255, 0.1);
        }

        #taskDetailModalLabel {
            white-space: normal;
            word-wrap: break-word;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        #assignUserModalLabel {
            white-space: normal;
            word-wrap: break-word;
            overflow: hidden;
            text-overflow: ellipsis;
            text-align: center;
        }

        #taskSearch {
            width: 300px;
            margin-right: 10px;
            border-radius: 5px;
            padding: 5px;
            font-size: 14px;
            background-color: #22242c;
            color: #808191;
            border: 1px solid #808191;
        }


        .custom-column-container {
            position: relative;
            border: 1px solid white !important;
            background-color: transparent !important;
            padding-top: 0.5rem !important;
        }

        .close-column {
            line-height: 1;
            font-weight: bold;
            z-index: 10;
        }

        .task-column-box {
            min-height: 500px;
            max-height: 500px;
            overflow-y: auto;
            background-color: transparent !important;
        }

        .task-item {
            background-color: #ffffff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            margin-right: 10px;
            position: relative;
        }

        .delete-task {

            position: absolute;
            top: 6px;
            right: 6px;
            background-color: #fff;
            border: 1px solid #dc3545;
            border-radius: 3px;
            color: #dc3545;
            font-size: 16px;
            line-height: 1;
            width: 15px;
            height: 15px;
            text-align: center;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }


        .task-priority-badge {
            position: absolute;
            bottom: 10px;
            right: 10px;
        }

        .column-divider {
            margin-top: 15px !important;
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
    <div class="col-xl-12">




        <div id="messageBox" class="alert d-none alert-dismissible fade show mt-3" role="alert">
            <span id="messageContent"></span>
            <button type="button" class="btn-close" aria-label="Close"
                style="filter: invert(1) grayscale(1) brightness(0) contrast(100%);" onclick="hideMessageBox()">
            </button>
        </div>


        <input type="hidden" id="taskTemplateId" name="taskColumnData">

        <div class="card px-4 ">
            <div class="card-header card-body table-border-style">
                <div class="col-xl-12">
                    <form id="taskForm" method="POST" action="{{ route('useradmin.events.task.template') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group w-100 mb-3">
                                    <label for="event_name" class="form-label">Event Name: *</label>

                                    <select class="form-control select2" name="event_id" id="event_id" required
                                        onchange="loadTasksData()">
                                        <option value="">Select Event Name</option>
                                        @foreach ($events as $event)
                                            <option value="{{ $event->eid }}"
                                                {{ old('event_id') == $event->eid ? 'selected' : '' }}>
                                                {{ $event->event_name }}
                                            </option>
                                        @endforeach
                                    </select> {{-- <button class="btn btn-primary" id="task-btn" type="submit">
                                            {{ 'Task Section' }}
                                        </button> --}}
                                </div>
                                @error('event_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>   
                        </div>
                        <div class="col-md-6 d-flex align-items-center justify-content-end button-container">
                            {{-- <input type="text" id="taskSearch" placeholder="Search by name, status, priority..."> --}}
                            <button class="btn btn-primary d-flex align-items-center" style="display: none !important;"
                                id="add-task" type="button" data-toggle="modal" data-target="#taskModal">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-plus" viewBox="0 0 16 16">
                                    <path
                                        d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
                                </svg>
                            </button>
                        </div>
                </div>
                <div class="mb-4 d-flex justify-content-end align-items-center">

                    <button onclick="showCatDialog()" type="button" class="btn btn-primary">
                        + Add Column
                    </button>
                </div>
                <!-- Dynamic Task Columns Will Be Injected Here -->
                <div class="container mt-4" id="taskContainer">

                </div>
                </form>

                {{-- columns add modal --}}
                <div class="modal fade" id="addCategoryModal1" tabindex="-1" aria-labelledby="addCategoryModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addCategoryModalLabel">Add New Category</h5>
                                <button type="button" onclick="hideCatDialog()" class="btn-close" data-bs-dismiss="modal1"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="new-category-name">Status Name*</label>
                                    <input type="text" id="new-category-name" class="form-control"
                                        placeholder="Enter status name">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" onclick="hideCatDialog()"
                                    data-bs-dismiss="modal">Cancel</button>
                                <button onclick="updateTaskColumnsAdd()" type="button" class="btn btn-primary"
                                    id="add-category-btn">Add
                                    Column</button>
                            </div>
                        </div>
                    </div>
                </div>



                {{-- Task Modal --}}
                <div class="modal fade" id="taskModal" tabindex="-1" role="dialog" aria-labelledby="taskModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="taskModalLabel">Add Task</h5>
                                <button type="button" id="taskModalClose" class="btn-close" data-dismiss="modal"
                                    aria-label="Close">
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="newTaskForm">
                                    <div class="form-group">
                                        <label for="taskName">Task Name *</label>
                                        <input type="text" class="form-control" id="taskName" name="taskName"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <label for="taskDuration">Duration *</label>
                                        <input type="text" class="form-control" id="taskDuration" name="taskDuration"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <label for="priority">Priority *</label>
                                        <select class="form-control" id="priority" name="priority" required>
                                            <option value="Low">Low</option>
                                            <option value="Medium">Medium</option>
                                            <option value="High">High</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Add Task</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class='modal fade' id='taskDetailModal' tabindex='-1' aria-labelledby='taskDetailModalLabel'
                    aria-hidden='true'>
                    <div class='modal-dialog modal-lg modal-dialog-centered'>
                        <div class='modal-content'>
                            <div class='modal-header'>
                                <h5 class='modal-title' id='taskDetailModalLabel'>Task Details</h5>
                                <button type='button' class='btn-close' data-bs-dismiss='modal'
                                    aria-label='Close'></button>
                            </div>
                            <div class='modal-body'>
                                <dl class='row'>
                                    <dt class='col-sm-3'>Priority:</dt>
                                    <dd class='col-sm-9' id='modalTaskPriority'></dd>
                                    <dt class='col-sm-3'>Duration:</dt>
                                    <dd class='col-sm-9' id='modalTaskDuration'></dd>
                                    <dt class='col-sm-3'>Status:</dt>
                                    <dd class='col-sm-9' id='modalTaskStatus'></dd>
                                    <dt class='col-sm-3'>Assigned By:</dt>
                                    <dd class='col-sm-9' id='modalTaskAssignedBy'>{{ Auth::user()->name }}</dd>
                                    <dt class='col-sm-3'>Assigned To:</dt>
                                    <dd class='col-sm-9' id='modalTaskAssignedToUsers'>
                                        <span class='text-muted'>No one assigned yet.</span>
                                    </dd>
                                </dl>
                                <div class='mt-3'>
                                    <button type='button' class='btn btn-sm btn-outline-primary'
                                        id='openAssignUserModalBtn' data-bs-toggle='modal'
                                        data-bs-target='#assignUserModal'>
                                        <i class='fas fa-users me-1'></i> Assign / Manage Users
                                    </button>
                                </div>
                            </div>
                            <div class='modal-footer'>
                                <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Assign User Modal -->
                <div class='modal fade' id='assignUserModal' tabindex='-1' aria-labelledby='assignUserModalLabel'
                    aria-hidden='true'>
                    <div class='modal-dialog modal-lg modal-dialog-centered'>
                        <div class='modal-content'>
                            <div class='modal-header'>
                                <h5 class='modal-title' id='assignUserModalLabel'>Assign Team Members</h5>
                                <button type='button' class='btn-close' data-bs-dismiss='modal'
                                    aria-label='Close'></button>
                            </div>
                            <div class='modal-body'>
                                <div class='mb-3'>
                                    <label for='assignUserTaskId' class='form-label'>Task ID</label>
                                    <input type='text' class='form-control' id='assignUserTaskId' readonly>
                                </div>
                                <div class='mb-3'>
                                    <label for='assignUserTaskName' class='form-label'>Task Name</label>
                                    <input type='text' class='form-control' id='assignUserTaskName' readonly>
                                </div>
                                <div class='mb-3'>
                                    <label for='teamCategorySelect' class='form-label'>Select Team Category *</label>
                                    <select class='form-select' id='teamCategorySelect'>
                                        <option value=''>Select a category...</option>
                                    </select>
                                </div>
                                <div class='mb-3'>
                                    <label class='form-label'>Team Members</label>
                                    <div id='teamMembersContainer' class='border rounded p-3'>
                                        <!-- Team members will be populated here -->
                                    </div>
                                    <div id="assignedMembersContainer" class="mt-3">
                                        <!-- Assigned members will be displayed here -->
                                    </div>
                                </div>
                            </div>
                            <div class='modal-footer'>
                                <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>
                                <button type='button' class='btn btn-primary' id='saveTaskAssignmentsBtn'>Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>


    <!-- Include in your Blade view -->
    <div class="modal fade" id="confirmRemoveModal" tabindex="-1" aria-labelledby="confirmRemoveLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmRemoveLabel">Confirm Team Member Removal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to remove this team member?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger"
                        onclick="removeTeamMember(confirmTaskId, confirmTeamMemberId)"data-bs-dismiss="modal">Yes,
                        Remove</button>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>





    <!-- Pusher JS -->
    <script src="https://cdn.jsdelivr.net/npm/pusher-js@7.2.0/dist/web/pusher.min.js"></script>

    <!-- Laravel Echo -->
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.11.3/dist/echo.iife.js"></script>

    <script>
        // Pusher is already in window.Pusher
        window.Echo = new Echo({
            broadcaster: 'pusher',
            key: '473dbc0a8415d7558e56',
            cluster: 'ap1',
            forceTLS: true
        });

        window.Echo.channel('tasks')
            .listen('TaskUpdated', (e) => {

                e.events.forEach(event => {
                    if (event.eid == document.getElementById('event_id').value) {
                        // console.log(event);
                        loadTasks(event.eid);
                        updateCounts();
                    }
                });


                // loadTasks(e.events.eid);
                // updateCounts();
                // update UI here
            });
    </script>










    <script>
        function showMessage(type, message) {
            const box = document.getElementById('messageBox');
            const content = document.getElementById('messageContent');

            // Set the alert type and message
            box.className = 'alert alert-' + type + ' alert-dismissible fade show';
            content.textContent = message;

            // Show the alert
            box.classList.remove('d-none');
        }

        function hideMessageBox() {
            const box = document.getElementById('messageBox');
            box.classList.add('d-none');
        }


        function showCatDialog() {
            const modal = new bootstrap.Modal(document.getElementById('addCategoryModal1'));
            modal.show();
        }

        function hideCatDialog() {
            const modal = bootstrap.Modal.getInstance(document.getElementById('addCategoryModal1'));
            modal.hide();
        }

        let confirmTaskId = null;
        let confirmTeamMemberId = null;

        function confirmRemoveTeamMember(taskId, teamMemberId) {
            confirmTaskId = taskId;
            confirmTeamMemberId = teamMemberId;
            const modal = new bootstrap.Modal(document.getElementById('confirmRemoveModal'));
            modal.show();
        }

        // Team member removal function - defined before any page elements
        function removeTeamMember(taskId, teamMemberId) {



            fetch(`/useradmin/tasks/${taskId}/team-members/${teamMemberId}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {

                        showMessage('success', 'Team member removed successfully');
                        // Model hide
                        $('#assignUserModal').modal('hide');
                    } else {
                        showMessage('success', data.message);
                    }
                })
                .catch(error => {
                    showMessage('warning', 'Error removing team member. Please try again.');
                });
        }

        let draggedItem = null;
        let placeholder = document.createElement('div');
        placeholder.className = 'placeholder';

        // Function to initialize drag and drop
        function initializeDragAndDrop() {
            // Initialize draggable tasks
            document.querySelectorAll('.task').forEach(task => {
                task.addEventListener('dragstart', handleDragStart);
                task.addEventListener('dragend', handleDragEnd);
                task.addEventListener('dragover', handleDragOver);
            });

            // Set up drop zones for columns
            document.querySelectorAll('.column').forEach(column => {
                column.addEventListener('dragover', handleColumnDragOver);
                column.addEventListener('drop', handleColumnDrop);
                column.addEventListener('dragleave', handleColumnDragLeave);
            });
        }

        // Drag event handlers
        function handleDragStart(e) {
            draggedItem = e.target;
            e.dataTransfer.effectAllowed = 'move';
            setTimeout(() => {
                e.target.style.opacity = '0.4';
            }, 0);
        }

        function handleDragEnd(e) {
            e.target.style.opacity = '1';
            placeholder && placeholder.remove();
        }

        function handleDragOver(e) {
            e.preventDefault();
            const bounding = e.target.getBoundingClientRect();
            const parent = e.target.parentNode;

            if (e.clientY - bounding.y < bounding.height / 2) {
                parent.insertBefore(placeholder, e.target);
            } else {
                parent.insertBefore(placeholder, e.target.nextSibling);
            }
        }

        // Column event handlers
        function handleColumnDragOver(e) {
            e.preventDefault();
            const columnDiv = e.currentTarget;
            const columnContentDiv = columnDiv.querySelector('.column-content');

            if (columnContentDiv) {
                if (!columnContentDiv.contains(placeholder)) {
                    columnContentDiv.appendChild(placeholder);
                }
            }
        }

        function handleColumnDrop(e) {
            e.preventDefault();
            if (draggedItem && placeholder.parentNode) {
                placeholder.parentNode.insertBefore(draggedItem, placeholder);
                updateTaskStatus(draggedItem, e.currentTarget.id);
                updateCounts();
            }
            placeholder && placeholder.remove();
        }

        function handleColumnDragLeave(e) {
            if (!e.currentTarget.contains(e.relatedTarget)) {
                placeholder && placeholder.remove();
            }
        }

        // Update task status and order when moved
        function updateTaskStatus(taskElement, columnId) {
            const taskId = taskElement.dataset.id;
            const newStatus = columnId.replace('-', ' ');

            const newColumnTasks = Array.from(taskElement.parentNode.children)
                .filter(el => el.classList.contains('task'));

            const orderUpdates = newColumnTasks.map((task, index) => ({
                task_id: task.dataset.id,
                order_index: index
            }));

            const updateData = {
                task_id: taskId,
                status: newStatus,
                order_updates: orderUpdates
            };

            console.log('Update Data:', updateData);

            fetch("{{ route('useradmin.events.task.update') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json', // Explicitly request JSON
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(updateData)
                })
                .then(async response => {
                    // First check if the response is JSON
                    const contentType = response.headers.get('content-type');
                    if (!contentType || !contentType.includes('application/json')) {
                        const text = await response.text();
                        throw new Error(`Expected JSON but got: ${text.substring(0, 100)}...`);
                    }

                    return response.json();
                })
                .then(data => {
                    if (!data?.success) {
                        showMessage('danger', 'Backend update failed: ' + (data?.message || 'Unknown error') +
                            '. The UI might be inconsistent. Please consider refreshing.');

                        return;
                    }

                    // The task element is already visually moved by SortableJS.


                    // if(data.data){
                    //     console.log(data.data);

                    // }
                    const eventId = document.getElementById('event_id').value;
                    loadTasks(eventId)
                    updateCounts();

                })
                .catch(error => {
                    // Show user-friendly error message
                    showMessage('danger', 'Failed to update task. Please try again.');

                    // Optionally revert the UI change

                });
        }






        function updateTaskColumnsAdd() {
            const task_template_id = document.getElementById('taskTemplateId').value;
            const status = document.getElementById('new-category-name').value;


            const updateData = {
                task_template_id: task_template_id,
                status: status,
            };


            fetch("{{ route('useradmin.events.task.update.column') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json', // Explicitly request JSON
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(updateData)
                })
                .then(async response => {
                    // First check if the response is JSON
                    const contentType = response.headers.get('content-type');
                    if (!contentType || !contentType.includes('application/json')) {
                        const text = await response.text();
                        throw new Error(`Expected JSON but got: ${text.substring(0, 100)}...`);
                    }

                    return response.json();
                })
                .then(data => {
                    if (!data?.success) {
                        showMessage('danger', 'Backend update failed: ' + (data?.message || 'Unknown error') +
                            '. The UI might be inconsistent. Please consider refreshing.');

                        return;
                    }

                    // The task element is already visually moved by SortableJS.


                    // if(data.data){
                    //     console.log(data.data);

                    // }
                    const eventId = document.getElementById('event_id').value;
                    loadTasks(eventId)
                    updateCounts();

                    hideCatDialog();

                    document.getElementById('new-category-name').value = '';
                })
                .catch(error => {
                    // Show user-friendly error message
                    showMessage('danger', 'Failed to update task. Please try again.');

                    // Optionally revert the UI change

                });
        }









        // Update task counts
        function updateCounts() {
            document.querySelectorAll('.column').forEach(column => {
                const countElement = column.querySelector('.count');
                if (countElement) {
                    countElement.textContent = column.querySelectorAll('.task').length;
                }
            });
        }

        // Add new task functionality
        document.getElementById('add-task').addEventListener('click', () => {
            $('#taskModal').modal('show');
        });
        // task model close button
        document.getElementById('taskModalClose').addEventListener('click', () => {
            $('#taskModal').modal('hide');
        });

        // Handle new task form submission
        document.getElementById('newTaskForm').addEventListener('submit', function(event) {
            event.preventDefault();

            // Check selected event
            if (document.getElementById('event_id').value == '') {
                showMessage('warning', 'Please select an event');
                return;
            }

            const formData = new FormData(this);
            formData.append('event_id', document.getElementById('event_id').value);


            console.log(JSON.stringify(Object.fromEntries(formData)));

            fetch("{{ route('useradmin.events.task.store') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(Object.fromEntries(formData))
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        $('#taskModal').modal('hide');
                        loadTasks(document.getElementById('event_id').value);
                    }
                })
                .catch(error => {
                    showMessage('danger', 'Failed to create task. Please try again.');
                });


        });

        function addTask(name) {
            if (document.getElementById('event_id').value == '') {
                showMessage('warning', 'Please select an event');
                return;
            }


            const form = document.getElementById(`newTaskForm${name}`);



            const formData = new FormData();
            formData.append('taskName', document.getElementById(`addtaskName${name}`).value);
            formData.append('taskDuration', document.getElementById(`addtaskDuration${name}`).value);
            formData.append('priority', document.getElementById(`addpriority${name}`).value);
            formData.append('event_id', document.getElementById('event_id').value);
            formData.append('status', name);


            console.log(JSON.stringify(Object.fromEntries(formData)));

            fetch("{{ route('useradmin.events.task.store') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(Object.fromEntries(formData))
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {

                        loadTasks(document.getElementById('event_id').value);
                    }
                })
                .catch(error => {
                    showMessage('danger', 'Failed to create task. Please try again.');
                });

            hideAddModal(name);
        }



        function loadTasks(eventId) {
            fetch("{{ route('useradmin.events.task.template') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        eid: eventId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    const tasks = data.tasks || [];
                    const container = document.getElementById('taskContainer');

                    console.log('tasks:', tasks);
                    if (tasks.length == 0) {
                        return;
                    }

                    const taskTempId = tasks[0].task_template_id;
                    document.getElementById('taskTemplateId').value = taskTempId;


                    fetch("{{ route('useradmin.events.task.status') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                template_id: tasks[0].task_template_id
                            })
                        })
                        .then(response => response.json())
                        .then(data => {


                            const grouped = {};

                            data.forEach(status => {
                                grouped[status.name] = [];
                            });

                            tasks.forEach(task => {
                                const status = task.status.name;
                                if (grouped[status]) {
                                    grouped[status].push(task);
                                }
                            });
                            if (Object.keys(grouped).length === 0) {
                                $('#add-task').prop('disabled', true);
                            } else {
                                $('#add-task').prop('disabled', false);
                            }


                            // Sort tasks within each status by order_index
                            Object.keys(grouped).forEach(status => {
                                grouped[status].sort((a, b) => a.order_index - b.order_index);
                            });


                            console.table(tasks);

                            // Generate HTML for each status column

                            const renderColumn = (status) => {

                                const taskItems = grouped[status.name].map((task, index) => `
                        
                        <div class="task border rounded p-3 mb-1 d-flex flex-column position-relative" draggable="true" 
                        data-id="${task.id}" 
                        data-order-index="${index}" 
                        
                        >
                            <div class="d-flex justify-content-between align-items-center mb-2">
    <span class="task-name fw-bold" style="margin-right:10px;color:white">${task.task_name}</span>

    <span class=" badge ${getPriorityBadgeClass(task.priority)}">
        ${task.priority}
    </span>


<div class="modal fade" id="taskModal${task.id}" tabindex="-1" role="dialog" aria-labelledby="taskModalLabel${task.id}"
                        aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="taskModalLabel${task.id}">Edit Task</h5>
                                    <button type="button" onclick="closeTaskModal(${task.id})" id="taskModalClose${task.id}" class="btn-close" data-dismiss="modal"
                                        aria-label="Close">
                                    </button>
                                </div>
                                <div class="modal-body">
                                        <div class="form-group">
                                            <label for="taskName">Task Name *</label>
                                            <input value="${task.task_name}" type="text" class="form-control" id="taskName${task.id}" name="taskName"
                                                required>
                                        </div>
                                        <div class="form-group">
                                            <label for="taskDuration">Duration *</label>
                                            <input value="${task.task_duration}" type="text" class="form-control" id="taskDuration${task.id}"
                                                name="taskDuration" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="priority">Priority *</label>
                                            <select class="form-control" id="priority${task.id}" name="priority" required>
                                                <option ${task.priority == 'Low' ? 'selected' : ''} value="Low">Low</option>
                                                <option ${task.priority == 'Medium' ? 'selected' : ''} value="Medium">Medium</option>
                                                <option ${task.priority == 'High' ? 'selected' : ''} value="High">High</option>
                                            </select>
                                        </div>
                                        <button type="submit" onclick="updateTask(${task.id})" class="btn btn-primary">Update Task</button>
                                </div>
                            </div>
                        </div>
                    </div>






    <div class="ms-auto d-flex gap-1">
        <button onclick="showEditTask(${task.id})" type="button" class="btn btn-sm btn-outline-warning close-column" title="Edit Task">
            <i class="fas fa-pen"></i>
        </button>
        <button onclick="removeTask(${task.id})" type="button" class="btn btn-sm btn-outline-danger close-column" title="Remove Column">
            &times;
        </button>
    </div>
</div>

                            <div class="d-flex justify-content-between align-items-center">
                                <small class="task-duration text-muted">
                                    <i class="fas fa-clock me-1" style="color:white"></i> <span style= "color:white">${task.task_duration}</span>
                                </small>
                            </div>
                            <div id="taskTeams${task.id}">
                            </div>
                            <div style="display:flex;justify-content:end">
                            <div class="show-task-modal"
                                style="cursor: pointer; color: #808191;" 
                                data-bs-toggle="modal" 
                                data-bs-target="#taskDetailModal" 
                                data-task-id="${task.id}" 
                                data-task-name="${task.task_name}" 
                                data-task-description="${task.task_description}" 
                                data-task-priority="${task.priority}" 
                                data-task-status="${task.status.name}" 
                                data-task-duration="${task.task_duration}"
                            >
                                
                                <i class="align-self-end fas fa-users me-2" style="color:white"></i>
                            </div>
</div>
                        </div>
                    `).join('');


                                return `





<div class="modal fade" id="editCategoryModal${status.id}" tabindex="-1" aria-labelledby="addCategoryModalLabel${status.id}"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addCategoryModalLabel${status.id}">Edit Category</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="new-category-name">Status Name*</label>
                                        <input value="${status.name}" type="text" id="new-category-name${status.id}" class="form-control"
                                            placeholder="Enter status name">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button onclick="updateTaskColumns(${status.id},${taskTempId})" type="button" class="btn btn-primary"
                                        id="add-category-btn">Update
                                        Column</button>
                                </div>
                            </div>
                        </div>
                    </div>






<div class="modal fade" id="addTaskModal${status.name}" tabindex="-1" role="dialog" aria-labelledby="taskModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                
                                <div class="modal-header">
                                    <h5 class="modal-title" id="taskModalLabel">Add Task</h5>
                                    <button type="button" onclick="hideAddModal('${status.name}')"  class="btn-close">
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form id="newTaskForm${status.name}">
                                        <div class="form-group">
                                            <label for="taskName">Task Name *</label>
                                            <input type="text" class="form-control" id="addtaskName${status.name}" name="taskName"
                                                required>
                                        </div>
                                        <div class="form-group">
                                            <label for="taskDuration">Duration *</label>
                                            <input type="text" class="form-control" id="addtaskDuration${status.name}"
                                                name="taskDuration" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="priority">Priority *</label>
                                            <select class="form-control" id="addpriority${status.name}" name="priority" required>
                                                <option value="Low">Low</option>
                                                <option value="Medium">Medium</option>
                                                <option value="High">High</option>
                                            </select>
                                        </div>
                                        <button type="button" onclick="addTask('${status.name}')" class="btn btn-primary">Add Task</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>













                        <div class="kanban-column column me-3" id="${status.name.toLowerCase().replace(' ', '-')}">
                            <div class="column-header">
                                <h3  class="d-flex align-items-center" style="color: #808191;margin-top:0 !important;">
                                    ${status.name}
                                </h3>
                                <span  class="count badge bg-secondary rounded-pill" style="margin-left: 5px;">${grouped[status.name].length}</span>
                                
                                 <div class="ms-auto d-flex gap-1">



    <button onclick="showAddModal('${status.name}')" type="button" class="btn btn-sm btn-outline-success" title="Add Task">
            <i class="fas fa-plus"></i>
        </button>





        <button onclick="showEditColumn(${status.id})" type="button" class="btn btn-sm btn-outline-warning close-column" title="Edit Task">
            <i class="fas fa-pen"></i>
        </button>
                                      <button onclick="removeColumn(${status.id},${taskTempId})" type="button"  class="btn btn-sm btn-outline-danger close-column " title="Remove Column">&times;</button>

    </div>
                                
                                
                                </div>
                            <hr class="my-2">
                            <div class=" column-content mt-3">
                                ${taskItems}
                            </div>
                        </div>
                    `;
                            };








                            // Helper function for priority badge styling
                            function getPriorityBadgeClass(priority) {

                                switch (priority) {
                                    case 'High':
                                        return 'bg-danger';
                                    case 'Medium':
                                        return 'bg-warning';
                                    case 'Low':
                                        return 'bg-success';
                                    default:
                                        return 'bg-secondary';
                                }
                            }




                            function getStatusIcon(status) {
                                switch (status) {
                                    case 'Pending':
                                        return '<i class="fas fa-hourglass-start"></i>';
                                    case 'In_progress':
                                        return '<i class="fas fa-spinner"></i>';
                                    case 'Completed':
                                        return '<i class="fas fa-check"></i>';
                                    default:
                                        return '';
                                }
                            }

                            const column = data.map((key, status) => key).map((status) => {
                                return renderColumn(status);
                            });

                            container.innerHTML = `
                            

                            <div class="row mb-3 flex-nowrap overflow-auto" id="columns-container">
                             ${column.join('')}
                        </div>
                        `;

                            // Reinitialize drag and drop for the new elements
                            initializeDragAndDrop();
                        });




                    // Group and sort tasks by status and order_index

                })
                .catch(error => {
                    showMessage('danger', 'Failed to load tasks. Please try again.');
                });
        }



        function showAddModal(statusName) {
            const modalEl = document.getElementById(`addTaskModal${statusName}`);

            if (modalEl) {
                const modal = new bootstrap.Modal(modalEl);
                modal.show();
            }
        }

        function hideAddModal(statusName) {

            $(`#addTaskModal${statusName}`).modal('hide');
        }




        // Event form submission
        // document.getElementById('taskForm').addEventListener('submit', function(event) {
        //     event.preventDefault();
        //     const eventId = document.getElementById('event_id').value;


        //     if (eventId) {
        //         loadTasks(eventId);
        //     }
        // });


        function loadTasksData() {
            event.preventDefault();
            const eventId = document.getElementById('event_id').value;


            if (eventId) {
                loadTasks(eventId);
            }
        }

        function showEditTask(task_id) {

            const modalEl = document.getElementById(`taskModal${task_id}`);
            if (modalEl) {
                const modal = new bootstrap.Modal(modalEl);
                modal.show();
            }
        }


        function showEditColumn(status_id) {

            const modalEl = document.getElementById(`editCategoryModal${status_id}`);
            if (modalEl) {
                const modal = new bootstrap.Modal(modalEl);
                modal.show();
            }
        }

        function updateTask(task_id) {


            const taskName = document.getElementById(`taskName${task_id}`).value;
            const taskDuration = document.getElementById(`taskDuration${task_id}`).value;
            const priority = document.getElementById(`priority${task_id}`).value;

            const updateData = {
                task_id: task_id,
                task_name: taskName,
                task_duration: taskDuration,
                priority: priority
            };




            fetch("{{ route('useradmin.events.task.update.task') }}", {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json', // Explicitly request JSON
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(updateData)
                })
                .then(async response => {
                    // First check if the response is JSON
                    const contentType = response.headers.get('content-type');
                    if (!contentType || !contentType.includes('application/json')) {
                        const text = await response.text();
                        throw new Error(`Expected JSON but got: ${text.substring(0, 100)}...`);
                    }

                    return response.json();
                })
                .then(data => {
                    if (!data?.success) {
                        showMessage('danger', 'Backend update failed: ' + (data?.message || 'Unknown error') +
                            '. The UI might be inconsistent. Please consider refreshing.');

                        return;
                    }

                    // The task element is already visually moved by SortableJS.


                    // if(data.data){
                    //     console.log(data.data);

                    // }
                    const eventId = document.getElementById('event_id').value;
                    loadTasks(eventId)
                    updateCounts();

                    closeTaskModal(task_id);


                    document.getElementById(`taskName${task_id}`).value = '';
                    document.getElementById(`taskDuration${task_id}`).value = '';
                    document.getElementById(`priority${task_id}`).value = '';

                })
                .catch(error => {
                    // Show user-friendly error message
                    showMessage('danger', 'Failed to Delete Task. Please try again.');

                    // Optionally revert the UI change

                });

        }


        function updateTaskColumns(status_id, taskTempId) {

            const statusName = document.getElementById(`new-category-name${status_id}`).value;

            const updateData = {
                task_template_id: taskTempId,
                status_id: status_id,
                status_name: statusName,
                event_id: document.getElementById('event_id').value
            };



            fetch("{{ route('useradmin.events.task.update.column') }}", {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json', // Explicitly request JSON
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(updateData)
                })
                .then(async response => {
                    // First check if the response is JSON
                    const contentType = response.headers.get('content-type');
                    if (!contentType || !contentType.includes('application/json')) {
                        const text = await response.text();
                        throw new Error(`Expected JSON but got: ${text.substring(0, 100)}...`);
                    }

                    return response.json();
                })
                .then(data => {
                    if (!data?.success) {
                        showMessage('danger', 'Backend update failed: ' + (data?.message || 'Unknown error') +
                            '. The UI might be inconsistent. Please consider refreshing.');

                        return;
                    }

                    // The task element is already visually moved by SortableJS.


                    // if(data.data){
                    //     console.log(data.data);

                    // }
                    const eventId = document.getElementById('event_id').value;
                    loadTasks(eventId)
                    updateCounts();

                    closeColumnModal(status_id);
                    document.getElementById(`new-category-name${status_id}`).value = '';
                })
                .catch(error => {
                    // Show user-friendly error message
                    console.log(error);
                    showMessage('danger', 'Failed to Delete Task. Please try again.');
                    // Optionally revert the UI change
                });

        }


        function closeTaskModal(task_id) {
            const modalEl = document.getElementById(`taskModal${task_id}`);
            if (modalEl) {
                const modal = bootstrap.Modal.getInstance(modalEl);
                if (modal) {
                    modal.hide();
                }
            }
        }

        function closeColumnModal(status_id) {
            const modalEl = document.getElementById(`editCategoryModal${status_id}`);
            if (modalEl) {
                const modal = bootstrap.Modal.getInstance(modalEl);
                if (modal) {
                    modal.hide();
                }
            }
        }


        function removeColumn(status_id, taskTempId) {

            const updateData = {
                task_template_id: taskTempId,
                status_id: status_id,
            };




            fetch("{{ route('useradmin.events.task.delete.column') }}", {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json', // Explicitly request JSON
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(updateData)
                })
                .then(async response => {
                    // First check if the response is JSON
                    const contentType = response.headers.get('content-type');
                    if (!contentType || !contentType.includes('application/json')) {
                        const text = await response.text();
                        throw new Error(`Expected JSON but got: ${text.substring(0, 100)}...`);
                    }

                    return response.json();
                })
                .then(data => {
                    if (!data?.success) {
                        showMessage('danger', 'Backend update failed: ' + (data?.message || 'Unknown error') +
                            '. The UI might be inconsistent. Please consider refreshing.');

                        return;
                    }

                    // The task element is already visually moved by SortableJS.


                    // if(data.data){
                    //     console.log(data.data);

                    // }
                    const eventId = document.getElementById('event_id').value;
                    loadTasks(eventId)
                    updateCounts();

                    let modalElement = document.getElementById('addCategoryModal');
                    let modalInstance = bootstrap.Modal.getInstance(modalElement);

                    if (modalInstance) {
                        modalInstance.hide();
                    }


                })
                .catch(error => {
                    // Show user-friendly error message
                    showMessage('danger', 'Failed to Delete Column. Please try again.');

                    // Optionally revert the UI change

                });
        }

        function removeTask(task_id) {

            const updateData = {
                task_id: task_id,
            };


            fetch("{{ route('useradmin.events.task.delete.task') }}", {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json', // Explicitly request JSON
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(updateData)
                })
                .then(async response => {
                    // First check if the response is JSON
                    const contentType = response.headers.get('content-type');
                    if (!contentType || !contentType.includes('application/json')) {
                        const text = await response.text();
                        throw new Error(`Expected JSON but got: ${text.substring(0, 100)}...`);
                    }

                    return response.json();
                })
                .then(data => {
                    if (!data?.success) {
                        showMessage('danger', 'Backend update failed: ' + (data?.message || 'Unknown error') +
                            '. The UI might be inconsistent. Please consider refreshing.');

                        return;
                    }

                    // The task element is already visually moved by SortableJS.


                    // if(data.data){
                    //     console.log(data.data);

                    // }
                    const eventId = document.getElementById('event_id').value;
                    loadTasks(eventId)
                    updateCounts();

                    let modalElement = document.getElementById('addCategoryModal');
                    let modalInstance = bootstrap.Modal.getInstance(modalElement);

                    if (modalInstance) {
                        modalInstance.hide();
                    }


                })
                .catch(error => {
                    // Show user-friendly error message
                    showMessage('danger', 'Failed to Delete Task. Please try again.');

                    // Optionally revert the UI change

                });
        }

        $(document).ready(function() {
            // $('.select2').select2(); // This line was here, ensure it's still needed or placed appropriately

            // Dummy data and logic for assignUserModal
            const assignUserModal = document.getElementById('assignUserModal');
            let currentTaskIdForAssignment = null;
            let currentTaskNameForAssignment = null;
            let currentEventIdForAssignment = null;
            let currentCategoryMembers = [];

            // Load team categories when modal opens
            $('#assignUserModal').on('show.bs.modal', function(event) {
                // Get event ID from task
                currentEventIdForAssignment = document.getElementById('event_id').value;

                // Update modal content
                document.getElementById('assignUserTaskId').value = currentTaskIdForAssignment;
                document.getElementById('assignUserTaskName').value = currentTaskNameForAssignment;

                // Load team categories and existing assignments
                loadTeamCategoriesWithAssignments();

                // Load existing team members for the task
                loadExistingTeamMembers();
            });

            function loadTeamCategoriesWithAssignments() {
                if (!currentEventIdForAssignment || !currentTaskIdForAssignment) return;

                fetch(
                        `/useradmin/events/${currentEventIdForAssignment}/team-categories/${currentTaskIdForAssignment}`
                    )
                    .then(response => response.json())
                    .then(data => {
                        const select = document.getElementById('teamCategorySelect');
                        select.innerHTML = '<option value="">Select a category...</option>';

                        data.data.forEach(category => {
                            const option = document.createElement('option');
                            option.value = category.id;
                            option.textContent = category.team_name;


                            // Check if this category is already assigned to the task
                            if (category.assigned) {

                                option.selected = true;
                                // Load team members for this category

                                // Load existing members for this category
                                loadTeamMembers();
                            }
                            select.appendChild(option);
                        });
                    })
                    .catch(error => console.error('Error loading team categories:', error));
            }

            function loadExistingTeamMembers() {
                if (!currentTaskIdForAssignment) return;

                fetch(`/useradmin/tasks/${currentTaskIdForAssignment}/assigned-team/members`)
                    .then(response => response.json())
                    .then(data => {

                        const assignedMembersContainer = document.getElementById(
                            'assignedMembersContainer');
                        assignedMembersContainer.innerHTML = '';

                        data.team_members.forEach(member => {

                            const memberDiv = document.createElement('div');
                            memberDiv.className = 'assigned-member';
                            memberDiv.innerHTML = `
                              <div style="display: flex; align-items: center;">
                                <span>${member.name}</span>
                                <span class="member-role ms-2">(${member.role})</span>


<button onclick="confirmRemoveTeamMember(${currentTaskIdForAssignment}, ${member.id})" style="width: 20px; height: 20px; display: flex; justify-content: center; align-items: center; margin-left: 2px;" class="btn btn-sm btn-danger">
    X
</button>




                              </div>
                            `;
                            assignedMembersContainer.appendChild(memberDiv);
                        });
                    })
                    .catch(error => console.error('Error loading assigned members:', error));
            }

            function loadTeamMembers() {

                const categoryId = document.getElementById('teamCategorySelect').value;
                if (!categoryId) {
                    document.getElementById('teamMembersContainer').innerHTML = '';
                    return;
                }
                fetch(`/useradmin/events/${currentEventIdForAssignment}/team-members/${categoryId}`)
                    .then(response => response.json())
                    .then(data => {
                        currentCategoryMembers = data.data;

                        const container = document.getElementById('teamMembersContainer');
                        container.innerHTML = ''; // Clear existing data

                        data.data.forEach(member => {
                            if (member.status === 'Active') {
                                const memberDiv = document.createElement('div');
                                memberDiv.className = 'form-check mb-2';

                                const checkbox = document.createElement('input');
                                checkbox.type = 'checkbox';
                                checkbox.className = 'form-check-input';
                                checkbox.id = `member-${member.id}`;
                                checkbox.value = member.id;

                                const label = document.createElement('label');
                                label.className = 'form-check-label';
                                label.htmlFor = `member-${member.id}`;
                                label.textContent = `${member.member_name} (${member.role})`;

                                memberDiv.innerHTML = `
                        <input type="checkbox" class="form-check-input" id="member-${member.id}" value="${member.id}">
                        <label class="form-check-label" for="member-${member.id}">${member.member_name} (${member.role})</label>
                        `;
                                container.appendChild(memberDiv);
                            }
                        });
                    })
                    .catch(error => console.error('Error loading team members:', error));
            }

            // Event listener for team category change
            document.getElementById('teamCategorySelect').addEventListener('change', function() {
                loadTeamMembers();
            });

            // Event listener for save button(Assign team members)
            document.getElementById('saveTaskAssignmentsBtn').addEventListener('click', function() {
                const taskId = document.getElementById('assignUserTaskId').value;
                const selectedMemberIds = [];

                // Get selected member IDs
                currentCategoryMembers.forEach(member => {
                    const checkbox = document.getElementById(`member-${member.id}`);
                    if (checkbox && checkbox.checked) {
                        selectedMemberIds.push({
                            task_id: taskId,
                            id: member.id,
                            member_name: member.member_name,
                            role: member.role,
                            team_category_id: member.team_category_id
                        });

                    }
                });

                if (selectedMemberIds.length === 0) {
                    showMessage('warning', 'Please select at least one team member');

                    return;
                }

                // Send assignment request
                fetch(`/useradmin/tasks/${taskId}/assign-team`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .content
                        },
                        body: JSON.stringify({
                            memberDetails: selectedMemberIds
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showMessage('success', 'Team members assigned successfully');

                            $('#assignUserModal').modal('hide');
                            // Refresh task display
                            loadTasks(currentEventIdForAssignment);
                        } else {
                            showMessage('danger', "Error assigning team members:" + data.message);

                        }
                    })
                    .catch(error => {
                        showMessage('danger', 'Error assigning team members');

                    });
            });
            let currentTaskPriorityForAssignment = null;
            let currentTaskStatusForAssignment = null;
            let currentTaskDurationForAssignment = null;


            // Task detail modal show event
            $('#taskDetailModal').on('show.bs.modal', function(event) {
                const button = $(event.relatedTarget);

                // If the modal was triggered by a task item, update stored details
                if (button.data('task-id') !== undefined) {
                    currentTaskIdForAssignment = button.data('task-id');
                    currentTaskNameForAssignment = button.data('task-name');
                    currentTaskPriorityForAssignment = button.data('task-priority');
                    currentTaskStatusForAssignment = button.data('task-status');
                    currentTaskDurationForAssignment = button.data('task-duration');
                }

                const modal = $(this);
                modal.find('#taskDetailModalLabel').text(currentTaskNameForAssignment ||
                    'Task Details');
                modal.find('#modalTaskPriority').text(currentTaskPriorityForAssignment || 'N/A');
                modal.find('#modalTaskStatus').text(currentTaskStatusForAssignment || 'N/A');
                modal.find('#modalTaskDuration').text(currentTaskDurationForAssignment || 'N/A');
                modal.find('#modalTaskAssignedBy').text('{{ Auth::user()->name }}');

                // Display assigned team members
                if (currentTaskIdForAssignment) {

                    fetch(`/useradmin/tasks/${currentTaskIdForAssignment}/assigned-team/members`)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {

                            if (data.team_members && data.team_members.length > 0) {
                                const teamMembersList = data.team_members.map(member =>
                                    `<div class="mb-2">
                                        <strong>${member.name}</strong> - ${member.role}
                                    </div>`
                                ).join('');

                                modal.find('#modalTaskAssignedToUsers').html(teamMembersList);
                            } else {
                                modal.find('#modalTaskAssignedToUsers').html(
                                    '<div class="text-muted">No team members assigned</div>');
                            }
                        })
                        .catch(error => {
                            modal.find('#modalTaskAssignedToUsers').html(
                                '<div class="text-muted">Error loading team members</div>');
                        });
                }
            });

        });


        function getTeamsByTaskId(taskId) {
            const div = document.createElement('div');

            fetch(`/useradmin/tasks/${taskId}/assigned-team/members`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.team_members && data.team_members.length > 0) {
                        const teamMembersList = data.team_members.map(member =>
                            `<div class="mb-2">
                                        <strong>${member.name}</strong> - ${member.role}
                                    </div>`
                        ).join('');

                        div.innerHTML = teamMembersList;
                    }

                    console.log(div);
                    return div;
                })
                .catch(error => {

                });


        }

        // Task Search Functionality
        $('#taskSearch').on('keyup', function() {
            // Check if event_id is set
            const eventId = document.getElementById('event_id').value;
            if (!eventId) {
                return;
            }
            const searchTerm = $(this).val().toLowerCase();
            $('#taskContainer .task').each(function() {
                const task = $(this);
                const taskName = (task.data('taskName') || '').toLowerCase();
                const taskPriority = (task.data('taskPriority') || '').toLowerCase();
                const taskStatus = (task.data('taskStatus') || '').toLowerCase();

                if (taskName.includes(searchTerm) ||
                    taskPriority.includes(searchTerm) ||
                    taskStatus.includes(searchTerm)) {
                    task.show();
                } else {
                    task.hide();
                }
            });
        });
    </script>
@endsection
