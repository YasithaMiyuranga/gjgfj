<style>
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
        top: -30px !important;
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
        width: 25px;
        height: 25px;
        text-align: center;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
    }


    .edit-task {

        position: absolute;
        top: 6px;
        right: 6px;
        background-color: #fff;
        border: 1px solid #ec780b;
        border-radius: 3px;
        color: #ec780b;
        font-size: 16px;
        line-height: 1;
        width: 25px;
        height: 25px;
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
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <form method="POST" id="task-template-form" action="{{ route('useradmin.str_task_templates.store') }}">
                <input type="hidden" name="categoryies" id="categoryInput" />
                @csrf
                <div class="card-header mb-3">
                    <h3>Create Task Templates</h3>
                </div>
                <div class="card-body table-border-style p-15">
                    <div class="add-task-form mb-4">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="template_name" class="form-label">Template Name*</label>
                                <input type="text" class="form-control" name="template_name" required
                                    id="template_name" placeholder="Enter Template Name"
                                    value="{{ old('template_name') }}">
                                @error('template_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 ">
                                <label for="event_category" class="form-label">Event Category*</label>
                                <div style="display: flex; flex-direction: row;gap: 10px;">
                                    <select class="form-control" id="event_category" name="event_category" required>
                                        <option value="" disabled selected>Select Event Category</option>
                                        @foreach ($eventCategories as $category_type)
                                            <option value="{{ $category_type->id }}"
                                                {{ old('event_category') == $category_type->id ? 'selected' : '' }}>
                                                {{ $category_type->category_name }}</option>
                                        @endforeach
                                    </select>
                                    <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#addEventCategoryModal">
                                        +
                                    </button>
                                </div>
                                @error('event_category')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-4 d-flex justify-content-between align-items-center">
                        <button style="display: none;" disabled type="button" id="add-but"
                            class="btn btn-success btn-sm add-task">
                            <i class="ti ti-plus"></i> Add Task
                        </button>
                        <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal"
                            data-bs-target="#addCategoryModal">
                            + Add Column
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

                        $columns = [
                            'Pending' => ['titleColor' => '#0d6efd'],
                            'In Progress' => ['titleColor' => '#b78f00'],
                            'Completed' => ['titleColor' => '#198754'],
                        ];
                    @endphp

                    <div class="row mb-3 flex-nowrap overflow-auto" id="columns-container">
                        @foreach ($columns as $name => $style)
                        @endforeach
                    </div>
                    <div class="d-flex justify-content-end mt-4">
                        <button hidden id="save-and-next" type="submit" class="btn btn-primary">Save Template</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


{{-- add event catrgory model --}}

<div class="modal fade" id="addEventCategoryModal" tabindex="-1" aria-labelledby="addEventCategoryModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCategoryModalLabel">Add New Event Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="new-category-name">Category Name*</label>
                    <input type="text" id="new-event-category-name" class="form-control"
                        placeholder="Enter category name">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="add-event-category-btn">Add Category</button>
            </div>
        </div>
    </div>
</div>



<!-- Add Category Modal -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCategoryModalLabel">Add New Column</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="new-category-name">Status Name*</label>
                    <input type="text" id="new-category-name" class="form-control" placeholder="Enter status name">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="add-category-btn">Add Column</button>
            </div>
        </div>
    </div>
</div>

<!-- Add Task Modal -->
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
                    <input type="text" required id="modal-task-name" class="form-control">
                </div>
                <div class="form-group mb-3">
                    <label for="modal-task-duration">Duration*</label>
                    <input type="text" required id="modal-task-duration" class="form-control">
                </div>
                <div class="form-group mb-3">
                    <label for="modal-task-priority">Priority*</label>
                    <select id="modal-task-priority" required class="form-control">
                        <option value="" selected>Select Priority</option>
                        <option value="Low">Low</option>
                        <option value="Medium">Medium</option>
                        <option value="High">High</option>
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

{{-- Include jQuery library --}}
<!-- jQuery -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    let taskIndex = 1;
    const priorityClasses = {
        'High': 'bg-danger',
        'Medium': 'bg-warning',
        'Low': 'bg-success'
    };

    function createTaskCard(index, name, duration, priority, column) {

        return `







<div class="modal fade" id="addTaskModal${taskIndex}" tabindex="-1" aria-labelledby="addTaskModalLabel${taskIndex}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addTaskModalLabel${taskIndex}">Add New Task</h5>
                    <button type="button" onclick="hideEditTask(${taskIndex})" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="modal-task-name">Task Name*</label>
                        <input value="${name}" id="modal-task-name${taskIndex}" type="text" required class="form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="modal-task-duration">Duration*</label>
                        <input value="${duration}" id="modal-task-duration${taskIndex}" type="text" required class="form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="modal-task-priority">Priority*</label>
                        <select id="modal-task-priority${taskIndex}" required class="form-control">
                            <option value="" selected>Select Priority</option>
                            <option ${priority == 'Low' ? 'selected' : ''} value="Low">Low</option>
                            <option ${priority == 'Medium' ? 'selected' : ''} value="Medium">Medium</option>
                            <option ${priority == 'High' ? 'selected' : ''} value="High">High</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="hideEditTask(${taskIndex})" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" onclick="editTask(${taskIndex})" class="btn btn-success" id="confirm-add-task">Edit Task</button>
                </div>
            </div>
        </div>
    </div>








                <div class="task-item border rounded p-1 ps-3 mb-1  d-flex flex-column position-relative" data-task-index="${index}" draggable="true">
                    <div style="display: flex;justify-content: end;gap: 5px;">
                        <button onclick="showEditTask(${index})" style="position: relative;background-color:#21232b;" type="button" class="edit-task btn-outline-info" title="Edit Task"><i class="ti ti-pencil"></i></button>
                        <button style="position: relative;background-color:#21232b;" type="button" class="delete-task btn-outline-warning" title="Delete Task">&times;</button>
                    </div>
                    <input type="hidden" id=tColumn${index} name="tasks[${index}][column]" class="task-column" value="${column}">
                    <input type="hidden" id=tName${index} name="tasks[${index}][name]" value="${name}">
                    <input type="hidden" id=tDuration${index} name="tasks[${index}][duration]" value="${duration}">
                    <input type="hidden" id=tPriority${index} name="tasks[${index}][priority]" value="${priority}">
                    <input type="hidden" id=tStatus${index} name="tasks[${index}][status]" value="${column}">
                    <div class="mb-2"><strong id="tdname${index}" style="color:white">${name}</strong></div>
                    <span class="text-muted"><i class="ti ti-clock"><span id="tdduration${index}" style="color:white">${duration}</span></i></span>
                    <div class="task-priority-badge">
                        <span class="badge ${priorityClasses[priority]}" id="tdpriority${index}" text-white">${priority}</span>
                    </div>
                </div>`;
    }

    $(document).on('click', '.add-task', function() {
        $('#addTaskModal').modal('show');
    });

    $(document).on('click', '.delete-task', function() {
        $(this).closest('.task-item').remove();
        updateCounts();
    });


    function showEditTask(index) {
        const modal = document.getElementById(`addTaskModal${index}`);

        const modalEl = new bootstrap.Modal(modal);
        modalEl.show();
    }


    function editTask(index) {


        document.getElementById(`tdname${index}`).innerText = $(`#modal-task-name${index}`).val();
        document.getElementById(`tdduration${index}`).innerText = $(`#modal-task-duration${index}`).val();
        document.getElementById(`tdpriority${index}`).innerText = $(`#modal-task-priority${index}`).val();

        document.getElementById(`tdpriority${index}`).className =
            `badge ${priorityClasses[$(`#modal-task-priority${index}`).val()]}`;

        document.getElementById(`tName${index}`).value = $(`#modal-task-name${index}`).val();
        document.getElementById(`tDuration${index}`).value = $(`#modal-task-duration${index}`).val();
        document.getElementById(`tPriority${index}`).value = $(`#modal-task-priority${index}`).val();



        hideEditTask(index);


    }

    function hideEditTask(index) {
        const modalElem = document.getElementById(`addTaskModal${index}`);

        if (modalElem) {
            // Get the instance that Bootstrap is using
            const modal = bootstrap.Modal.getInstance(modalElem);

            if (modal) {
                modal.hide(); // ✅ this will close the open modal
            } else {
                console.warn("No modal instance found for:", modalElem.id);
            }
        }
    }

    function addTask(catName) {
        const name = $(`#modal-task-name${catName}`);
        const duration = $(`#modal-task-duration${catName}`);
        const priority = $(`#modal-task-priority${catName}`);

        if (name.val() === '') {
            name[0].setCustomValidity('Name is required');
            name[0].reportValidity();
            return;
        } else {
            name[0].setCustomValidity('');
        }
        if (duration.val() === '') {
            duration[0].setCustomValidity('Duration is required');
            duration[0].reportValidity();
            return;
        } else {
            duration[0].setCustomValidity('');
        }
        if (priority.val() === '') {
            priority[0].setCustomValidity('Priority is required');
            priority[0].reportValidity();
            return;
        } else {
            priority[0].setCustomValidity('');
        }


            const input = $('#categoryInput');
            let current = input.val();

            let categories = current ? current.split(',') : [];
            if (categories.length == 0) {
                return;
            }



            const html = createTaskCard(taskIndex, name.val(), duration.val(), priority.val(), catName);
            $(`.tasks-column[data-column="${catName}"]`).append(html);
            taskIndex++;
            // $('#addTaskModal').modal('hide');
            name.val('');
            duration.val('');
            priority.val('Low');
            updateCounts();
        
    }



    $('#confirm-add-task').on('click', function() {
        const name = $('#modal-task-name');
        const duration = $('#modal-task-duration');
        const priority = $('#modal-task-priority');

        if (!name.val() === '') {
            name[0].setCustomValidity('Name is required');
            name[0].reportValidity();
        } else if (!duration.val() === '') {
            duration[0].setCustomValidity('Duration is required');
            duration[0].reportValidity();
        } else if (!priority.val() === '') {
            priority[0].setCustomValidity('Priority is required');
            priority[0].reportValidity();
        } else {
            priority[0].setCustomValidity('');
            const input = $('#categoryInput');
            let current = input.val();

            let categories = current ? current.split(',') : [];
            if (categories.length == 0) {
                return;
            }



            const html = createTaskCard(taskIndex, name.val(), duration.val(), priority.val(), categories[0]);
            $(`.tasks-column[data-column="${categories[0]}"]`).append(html);
            taskIndex++;
            // $('#addTaskModal').modal('hide');
            name.val('');
            duration.val('');
            priority.val('Low');
            updateCounts();
        }
    });

    let placeholder = document.createElement('div');
    placeholder.className = 'task-placeholder';

    // Style for placeholder (you can move this into CSS)
    Object.assign(placeholder.style, {
        height: '40px',
        background: 'rgba(0, 0, 0, 0.1)',
        border: '2px dashed #999',
        margin: '5px 0'
    });

    $(document).on('dragstart', '.task-item', function(e) {
        window.draggedTask = this;
        $(this).addClass('dragging').css('opacity', '0.5');
        e.originalEvent.dataTransfer.effectAllowed = 'move';
    });

    $(document).on('dragover', '.tasks-column', function(e) {
        e.preventDefault();
        const afterElement = getDragAfterElement(this, e.clientY);

        if (!window.draggedTask) return;

        if (!this.contains(placeholder)) {
            this.appendChild(placeholder);
        }

        if (afterElement == null) {
            this.appendChild(placeholder);
        } else {
            this.insertBefore(placeholder, afterElement);
        }
    });

    $(document).on('drop', '.tasks-column', function(e) {
        e.preventDefault();
        if (placeholder.parentNode) {
            this.insertBefore(window.draggedTask, placeholder);
            placeholder.remove();
        }
    });

    $(document).on('dragend', '.task-item', function() {
        $(this).removeClass('dragging').css('opacity', '1');
        placeholder.remove();
        window.draggedTask = null;
    });

    function getDragAfterElement(container, y) {
        const draggableElements = [...container.querySelectorAll('.task-item:not(.dragging)')];

        return draggableElements.reduce((closest, child) => {
            const box = child.getBoundingClientRect();
            const offset = y - box.top - box.height / 2;

            if (offset < 0 && offset > closest.offset) {
                return {
                    offset: offset,
                    element: child
                };
            } else {
                return closest;
            }
        }, {
            offset: Number.NEGATIVE_INFINITY
        }).element;
    }



    // Drag & drop
    $(document).on('dragstart', '.task-item', function(e) {
        window.draggedTask = this;
    });

    $(document).on('dragover', '.tasks-column', function(e) {
        e.preventDefault();
    });

    $(document).on('drop', '.tasks-column', function(e) {
        e.preventDefault();
        if (window.draggedTask) {
            $(this).append(window.draggedTask);
            const newColumn = $(this).data('column');
            $(window.draggedTask).find('.task-column').val(newColumn);
            $(window.draggedTask).find('input[name$="[status]"]').val(newColumn);


            window.draggedTask = null;
            updateCounts();

        }
    });

    function updateCounts() {
        $('.custom-column-container').each(function() {
            const count = $(this).find('.tasks-column .task-item').length;
            $(this).find('.count').text(count);
        });
    }

    $(document).ready(function() {
        updateCounts();
    });

    $(document).on('click', '.close-column', function() {
        const column = $(this).closest('.kanban-column'); // the full column wrapper
        const container = column.find('.custom-column-container'); // where data-column is
        const colName = container.data('column'); // get the correct column name

        column.remove(); // remove the whole column block

        const input = $('#categoryInput');
        let current = input.val();
        let categories = current ? current.split(',') : [];

        // remove the column name
        categories = categories.filter(cat => cat !== colName);

        input.val(categories.join(','));
        if (categories.length == 0) {
            $('#add-but').prop('disabled', true);
        } else {
            $('#add-but').prop('disabled', false);
        }
    });


    $('#add-event-category-btn').on('click', function() {

        const name = $('#new-event-category-name').val().trim();
        if (!name) return;

        fetch('{{ route('useradmin.events.category_store_and_get_recent') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                body: JSON.stringify({
                    category_name: name
                })
            })
            .then(async response => {
                // Always try to parse JSON, even on errors
                let data;
                try {
                    data = await response.json();
                } catch (e) {
                    throw new Error("Invalid JSON response from server");
                }

                if (!response.ok) {
                    // Handle validation errors (422) or server errors
                    if (response.status === 422 && data.errors) {
                        // Show validation errors (example: show first error)
                    } else {

                    }




                    // $('#addEventCategoryModal').modal('hide');

                    return;
                }

                // ✅ Success case
                if (data.success) {
                    // $('#addEventCategoryModal').modal('hide');
                    console.log("Category added:", data);

                    // Add the new option & select it
                    $('#event_category').append(
                        new Option(data.category_name, data.id, true, true)
                    );
                } else {
                    // $('#addEventCategoryModal').modal('hide');

                }
            })
            .catch(error => {
                console.error("Fetch error:", error);
            });
    });



    $('#add-category-btn').on('click', function() {
        const name = $('#new-category-name').val().trim();
        if (!name) return;

        const input = $('#categoryInput');
        let current = input.val();

        let categories = current ? current.split(',') : [];

        if (!categories.includes(name)) {
            categories.push(name);
            input.val(categories.join(','));
        } else {
            return;
        }

        // $('#addCategoryModal').modal('hide');




        const color = '#' + Math.floor(Math.random() * 16777215).toString(16);
        const icon = '<i class="fas fa-tag me-2"></i>';
        const html = `
                
            
            
            
            
            
            <div class="modal fade" id="addCategoryModal${name}" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCategoryModalLabel">Add New Category</h5>
                    <button type="button" onclick="hideEditColumn('${name}')" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="new-category-name">Status Name*</label>
                        <input value="${name}" type="text" id="new-category-name${name}" class="form-control" placeholder="Enter status name">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="hide-category${name}" onclick="hideEditColumn('${name}')" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" onclick="updateCategory('${name}')" class="btn btn-primary" id="add-category-btn${name}">Update Category</button>
                </div>
            </div>
        </div>
    </div>
            
            


<div class="modal fade" id="addTaskModal${name}" tabindex="-1" aria-labelledby="addTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addTaskModalLabel">Add New Task</h5>
                <button type="button" onclick="closeTaskModel('${name}')" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group mb-3">
                    <label for="modal-task-name">Task Name*</label>
                    <input type="text"  id="modal-task-name${name}" class="form-control">
                </div>
                <div class="form-group mb-3">
                    <label for="modal-task-duration">Duration*</label>
                    <input type="text"  id="modal-task-duration${name}" class="form-control">
                </div>
                <div class="form-group mb-3">
                    <label for="modal-task-priority">Priority*</label>
                    <select id="modal-task-priority${name}"  class="form-control">
                        <option value="" selected>Select Priority</option>
                        <option value="Low">Low</option>
                        <option value="Medium">Medium</option>
                        <option value="High">High</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="closeTaskModel('${name}')" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" id="confirm-add-task-t" onclick="addTask('${name}')">Add Task</button>
            </div>
        </div>
    </div>
</div>


            
            
            
            
            <div class="kanban-column">
                    <div class="border rounded p-2 mb-3 border-white custom-column-container" data-column="${name}">
                        <div class="column-header text-start mb-3">
                            <div class="column-title-wrapper position-relative mb-1">
                                




                                <div style="display:flex;justify-content: end;gap:5px">
                                    <button onclick="opentaskModel('${name}')" type="button" class="btn btn-sm btn-outline-success top-0 end-0 "  title="Add Task"><i class="fas fa-plus"></i></button>
                                    <button id="show-but${name}" type="button" onclick="showEditColumn('${name}')" class="btn btn-sm btn-outline-warning  top-0 end-0 " title="Edit Column"><i class="fas fa-pen"></i></button>   
                                    <button type="button" class="btn btn-sm btn-outline-danger close-column top-0 end-0 "  title="Remove Column">&times;</button>
                                </div>
                                <div class="d-flex align-items-center justify-content-start ps-2">
                                    <h3 class="column-title m-0 me-2" style="color: ${color};">
                                        ${icon}<span id="name-${name}">${name}</span>
                                    </h3>
                                    <span class="count badge bg-secondary rounded-pill">0</span>
                                </div>
                            </div>
                            <hr class="column-divider">
                        </div>
                        <div class="tasks-column  task-column-box" id="tasks-column-${name}" data-column="${name}">

                        </div>
                    </div>
                </div>`;
        $('#columns-container').append(html);
        $('#new-category-name').val('');










        $('#add-but').prop('disabled', false);
    });



    function opentaskModel(name) {
        const modalElem = document.getElementById(`addTaskModal${name}`);

        if (modalElem) {
            const modal = new bootstrap.Modal(modalElem);
            modal.show();
        }
    }


    function closeTaskModel(name) {
        const modalElem = document.getElementById(`addTaskModal${name}`);

        if (modalElem) {
            const modal = new bootstrap.Modal(modalElem);
            modal.hide();
        }
    }



    function updateCategory(name) {
        const newName = $(`#new-category-name${name}`).val().trim();
        if (!newName) return;

        const input = $('#categoryInput');
        let current = input.val();
        let categories = current ? current.split(',') : [];

        // Update the category name in the array
        categories = categories.map(cat => (cat === name ? newName : cat));
        input.val(categories.join(','));

        // Update the column title
        $(`.custom-column-container[data-column="${name}"] .column-title span`).text(newName);
        $(`.custom-column-container[data-column="${name}"]`).data('column', newName);
        $(`.custom-column-container[data-column="${name}"] .column-title-wrapper`).attr('id',
            `column-title-wrapper-${newName}`);
        $(`#new-category-name${name}`).attr('id', `new-category-name${newName}`);
        $(`#edit-category-modal${name}`).attr('id', `edit-category-modal${newName}`);
        $(`#addCategoryModal${name}`).attr('id', `addCategoryModal${newName}`);
        $(`#edit-category-modal${name} .modal-body`).attr('id', `modal-body-${newName}`);
        $(`#addCategoryModal${name} .modal-body`).attr('id', `modal-body-${newName}`);
        $(`#modal-body-${name} .category-input`).val(newName);
        $(`#modal-body-${name} .category-input`).attr('name', `category-input-${newName}`);
        $(`#modal-body-${name} .category-input`).attr('id', `category-input-${newName}`);

        $(`#tasks-column-${name}`).attr('data-column', `${newName}`);

        $(`#tasks-column-${name}`).attr('id', `tasks-column-${newName}`);

        $(`#new-category-name${name}`).attr('value', `${newName}`);

        $(`#show-but${name}`).attr('onclick', `showEditColumn('${newName}')`);

        $(`#show-but${name}`).attr('id', `show-but${newName}`);

        $(`#hide-category${name}`).attr('onclick', `hideEditColumn('${newName}')`);
        $(`#hide-category${name}`).attr('id', `hide-category${newName}`);

        $(`#add-category-btn${name}`).attr('onclick', `updateCategory('${newName}')`);
        $(`#add-category-btn${name}`).attr('id', `add-category-btn${newName}`);

        $(`#name-${name}`).text(`${newName}`);
        $(`#name-${name}`).attr('id', `name-${newName}`);


        $(window.draggedTask).find('.task-column').val(newName);
        $(window.draggedTask).find('input[name$="[status]"]').val(newName);


        const inputs = document.querySelectorAll('input[id^="tColumn"], input[id^="tStatus"]');

        inputs.forEach(input => {
            if (input.value === name) {
                input.value = newName;
            }
        });



        // Hide the modal
        hideEditColumn(newName);
    }


    function showEditColumn(name) {
        const modalElem = document.getElementById(`addCategoryModal${name}`);

        if (modalElem) {
            const modal = new bootstrap.Modal(modalElem);
            modal.show();
        }
    }

    function hideEditColumn(name) {
        const modalElem = document.getElementById(`addCategoryModal${name}`);

        if (modalElem) {
            // Get the instance that Bootstrap is using
            const modal = bootstrap.Modal.getInstance(modalElem);

            if (modal) {
                modal.hide(); // ✅ this will close the open modal
            } else {
                console.warn("No modal instance found for:", modalElem.id);
            }
        }
    }


    function save(formId) {
        $('#save-and-next').click();
    
        document.getElementById(formId).submit();
    }


    let id = '';

    document.getElementById('task-template-form').addEventListener('submit', function(e) {
        e.preventDefault(); // Prevent default form submission

        const form = this;
        const url = form.action; // The form's action URL
        const formData = new FormData(form); // Collect all form data including hidden inputs

        fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                        'content')
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {

                } else if (data.errors) {
                    // Handle validation errors
                    console.log(data.errors);
                } else {}
            })
            .catch(error => {
                console.error('Error submitting the form:', error);
            });
    });
</script>
