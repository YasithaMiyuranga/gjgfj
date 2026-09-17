<?php

namespace App\Http\Controllers;

use App\Events\TaskUpdated;
use App\Models\Status;
use App\Models\Task;
use App\Models\Category;
use App\Models\AdminEvent;
use App\Models\TaskTeam;
use App\Models\TaskTemplate;
use Illuminate\Console\Scheduling\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TaskTemplateController extends Controller
{
    /**
     * Display all Tasks templates
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Admin_events.task_management.templates.index', [
            // Only Show templates that do not have v2 in the name
            'taskTemplates' => TaskTemplate::where('template_name', 'not like', '%v2%')->orWhereNull('template_name')->get(),
        ]);
    }
    public function create()
    {
        return view('Admin_events.task_management.templates.create', [
            'eventCategories' => Category::all(),
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'template_name' => 'required|string|max:255',
            'event_category' => 'required|exists:category,id',
            'tasks.*' => 'required|array',
            'tasks.*.name' => 'required|string|max:255',
            'tasks.*.duration' => 'required|string|max:255',
            'tasks.*.status' => 'required|string|max:255',
            'tasks.*.priority' => 'required|string|max:255|in:Low,Medium,High',
            'categoryies' => 'required',
        ]);

        

        Log::info($request->all());

        $categories = array_map('trim', explode(',', $request->input('categoryies')));


        DB::beginTransaction();
        try {

            $tasks = $request->input('tasks');

            // Create task template
            $taskTemplate = TaskTemplate::create([
                'template_name' => $request->input('template_name'),
                'category_id' => $request->input('event_category'),
            ]);


            foreach ($categories as $category) {

                $status = Status::where('name', $category)->first();

                if (!$status) {
                    $status = Status::create([
                        'name' => $category,
                    ]);
                    $status->save();
                }
                DB::table('task_template_status')->insert([
                    'task_template_id' => $taskTemplate->id,
                    'status_id' => $status->id,
                ]);
            }

            if ($taskTemplate && !empty($tasks)) {
                $previousTaskId = null;

                foreach ($tasks as $index => $task) {
                    if (!empty($task['name'])) {
                        // Create the current task

                        $status_name = $task['status'];
                        $taskStatus = Status::where('name', $status_name)->first();

                        $currentTask = Task::create([
                            'task_template_id' => $taskTemplate->id,
                            'task_name' => $task['name'],
                            'task_duration' => $task['duration'],
                            'priority' => $task['priority'],
                            'prev_task_id' => $previousTaskId,
                            'next_task_id' => null,
                            'order_index' => $index, // Assign initial order index based on submitted order
                            'status_id' => $taskStatus->id
                        ]);




                        $currentTask->status()->associate($taskStatus)->save();

                        if ($previousTaskId) {
                            Task::where('id', $previousTaskId)
                                ->update(['next_task_id' => $currentTask->id]);
                        }
                        // The currentTask's prev_task_id is already set above

                        // Set previousTaskId for the next iteration

                        $existing = DB::table('task_template_status')
                            ->where('task_template_id', $taskTemplate->id)
                            ->where('status_id', $taskStatus->id)
                            ->first();

                        if (!$existing) {
                            DB::table('task_template_status')->insert([
                                'task_template_id' => $taskTemplate->id,
                                'status_id' => $taskStatus->id,
                            ]);

                            $existing = DB::table('task_template_status')
                                ->where('task_template_id', $taskTemplate->id)
                                ->where('status_id', $taskStatus->id)
                                ->first();
                        }


                        $previousTaskId = $currentTask->id;
                    }
                }
            }

            DB::commit();

            return redirect()->route('useradmin.task_templates.index')->with('success', 'Task template created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating task template: ' . $e->getMessage());
            return redirect()->route('useradmin.task_templates.index')->with('error', 'An error occurred while creating the task template.');
        }
    }









    public function str_store(Request $request)
    {
        $request->validate([
            'template_name' => 'required|string|max:255',
            'event_category' => 'required|exists:category,id',
            'tasks.*' => 'required|array',
            'tasks.*.name' => 'required|string|max:255',
            'tasks.*.duration' => 'required|string|max:255',
            'tasks.*.status' => 'required|string|max:255',
            'tasks.*.priority' => 'required|string|max:255|in:Low,Medium,High',
            'categoryies' => 'required',
        ]);


        Log::info($request->all());

        $categories = array_map('trim', explode(',', $request->input('categoryies')));


        DB::beginTransaction();
        try {

            $tasks = $request->input('tasks');

            // Create task template
            $taskTemplate = TaskTemplate::create([
                'template_name' => $request->input('template_name'),
                'category_id' => $request->input('event_category'),
            ]);


            foreach ($categories as $category) {

                $status = Status::where('name', $category)->first();

                if (!$status) {
                    $status = Status::create([
                        'name' => $category,
                    ]);
                    $status->save();
                }
                DB::table('task_template_status')->insert([
                    'task_template_id' => $taskTemplate->id,
                    'status_id' => $status->id,
                ]);
            }

            if ($taskTemplate && !empty($tasks)) {
                $previousTaskId = null;

                foreach ($tasks as $index => $task) {
                    if (!empty($task['name'])) {
                        // Create the current task

                        $status_name = $task['status'];
                        $taskStatus = Status::where('name', $status_name)->first();

                        $currentTask = Task::create([
                            'task_template_id' => $taskTemplate->id,
                            'task_name' => $task['name'],
                            'task_duration' => $task['duration'],
                            'priority' => $task['priority'],
                            'prev_task_id' => $previousTaskId,
                            'next_task_id' => null,
                            'order_index' => $index, // Assign initial order index based on submitted order
                            'status_id' => $taskStatus->id
                        ]);




                        $currentTask->status()->associate($taskStatus)->save();

                        if ($previousTaskId) {
                            Task::where('id', $previousTaskId)
                                ->update(['next_task_id' => $currentTask->id]);
                        }
                        // The currentTask's prev_task_id is already set above

                        // Set previousTaskId for the next iteration

                        $existing = DB::table('task_template_status')
                            ->where('task_template_id', $taskTemplate->id)
                            ->where('status_id', $taskStatus->id)
                            ->first();

                        if (!$existing) {
                            DB::table('task_template_status')->insert([
                                'task_template_id' => $taskTemplate->id,
                                'status_id' => $taskStatus->id,
                            ]);

                            $existing = DB::table('task_template_status')
                                ->where('task_template_id', $taskTemplate->id)
                                ->where('status_id', $taskStatus->id)
                                ->first();
                        }


                        $previousTaskId = $currentTask->id;
                    }
                }
            }

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Task template created successfully.',
                'id' => $taskTemplate->id
                // 'redirect_url' => route('useradmin.task_templates.index'), // optional
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating task template: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while creating the task template.',
                'error' => $e->getMessage()
            ], 500);

        }
    }



















    public function edit(TaskTemplate $taskTemplate)
    {
        return view('Admin_events.task_management.templates.edit', [
            'taskTemplate' => TaskTemplate::where('id', $taskTemplate->id)->with('tasks')->first(),
            'eventCategories' => Category::all(),
            'taskTemplateStatus' => DB::select('SELECT statuses.* FROM task_template_status INNER JOIN statuses ON task_template_status.status_id = statuses.id WHERE task_template_status.task_template_id = ?', [$taskTemplate->id]),
        ]);
    }

    // public function update(Request $request, TaskTemplate $taskTemplate)
    // {
    //     $request->validate([
    //         'template_name' => 'required|string|max:255',
    //         'event_category' => 'required|exists:category,id',
    //         'tasks.*' => 'required|array', // Ensure tasks are present if they are being updated
    //         'tasks.*.id' => 'nullable|integer', // Existing tasks might have an ID, new ones won't
    //         'tasks.*.name' => 'required|string|max:255',
    //         'tasks.*.duration' => 'required|string|max:255',
    //         'tasks.*.status' => 'required|string|max:255',
    //         'tasks.*.status_id' => 'nullable|exists:statuses,id',
    //         'tasks.*.priority' => 'required|string|max:255|in:Low,Medium,High',
    //         'deleted_tasks' => 'nullable|array',
    //         'deleted_tasks.*' => 'integer|exists:tasks,id',
    //     ]);

    //     DB::beginTransaction();
    //     try {
    //         // Update the task template
    //         $taskTemplate->update([
    //             'template_name' => $request->input('template_name'),
    //             'category_id' => $request->input('event_category'),
    //         ]);

    //         // Handle deleted tasks
    //         $deletedTaskIds = $request->input('deleted_tasks', []);
    //         if (!empty($deletedTaskIds)) {
    //             // Before deleting, update adjacent tasks' relationships
    //             $deletedTasks = Task::whereIn('id', $deletedTaskIds)->get();

    //             foreach ($deletedTasks as $deletedTask) {
    //                 // Update previous task's next_task_id
    //                 if ($deletedTask->prev_task_id) {
    //                     Task::where('id', $deletedTask->prev_task_id)
    //                         ->update(['next_task_id' => $deletedTask->next_task_id]);
    //                 }

    //                 // Update next task's prev_task_id
    //                 if ($deletedTask->next_task_id) {
    //                     Task::where('id', $deletedTask->next_task_id)
    //                         ->update(['prev_task_id' => $deletedTask->prev_task_id]);
    //                 }
    //             }

    //             // Now delete the tasks
    //             Task::whereIn('id', $deletedTaskIds)->delete();
    //         }

    //         $removedStatuses = explode(',', $request->input('removed_statuses', ''));
    //         foreach ($removedStatuses as $statusName) {
    //             $statusName = trim($statusName);
    //             if ($statusName === '')
    //                 continue;

    //             $status = Status::where('name', $statusName)->first();
    //             if ($status) {
    //                 DB::table('task_template_status')
    //                     ->where('task_template_id', $taskTemplate->id)
    //                     ->where('status_id', $status->id)
    //                     ->delete();
    //             }
    //         }

    //         $allStatuses = explode(',', $request->input('all_statuses', ''));
    //         $allStatuses = array_filter(array_map('trim', $allStatuses));

    //         foreach ($allStatuses as $statusName) {
    //             $status = Status::firstOrCreate(['name' => $statusName]);
    //             DB::table('task_template_status')
    //                 ->updateOrInsert(
    //                     ['task_template_id' => $taskTemplate->id, 'status_id' => $status->id]
    //                 );
    //         }


    //         // Process tasks in order to maintain proper chain and update/create
    //         $tasksData = $request->input('tasks', []);
    //         $previousTaskId = null; // This will hold the actual DB ID of the previously processed task
    //         $taskIdMap = []; // To map temporary negative IDs from frontend to real DB IDs

    //         foreach ($tasksData as $index => $taskData) {
    //             $isNewTask = !isset($taskData['id']) || $taskData['id'] < 0; // Negative ID or no ID means new task
    //             $status_name = $taskData['status'];
    //             $taskStatus = Status::where('name', $status_name)->first();

    //             if (!$taskStatus) {
    //                 $taskStatus = Status::create(['name' => $status_name]);
    //             }
    //             if ($isNewTask) {
    //                 // Create new task
    //                 $task = Task::create([
    //                     'task_template_id' => $taskTemplate->id,
    //                     'task_name' => $taskData['name'],
    //                     'task_duration' => $taskData['duration'],
    //                     // 'status' => $taskData['status'],
    //                     'priority' => $taskData['priority'],
    //                     'prev_task_id' => $previousTaskId,
    //                     'next_task_id' => null,
    //                     'order_index' => $index, // Assign order index based on current position in the submitted array
    //                     'status_id' => $taskStatus->id,
    //                 ]);
    //                 $currentTaskId = $task->id;
    //                 // Map the temporary ID to the real ID for subsequent linkage
    //                 if (isset($taskData['id']) && $taskData['id'] < 0) {
    //                     $taskIdMap[$taskData['id']] = $task->id;
    //                 }
    //             } else {
    //                 // Update existing task
    //                 $currentTaskId = $taskData['id'];
    //                 Task::where('id', $currentTaskId)->update([
    //                     'task_name' => $taskData['name'],
    //                     'task_duration' => $taskData['duration'],
    //                     'prev_task_id' => $previousTaskId,
    //                     'next_task_id' => null,
    //                     // 'status' => $taskData['status'],
    //                     'priority' => $taskData['priority'],
    //                     'order_index' => $index,
    //                     'status_id' => $taskStatus->id,
    //                 ]);
    //             }

    //             // Update previous task's next_task_id to point to this task
    //             if ($previousTaskId) {
    //                 // Use the actual DB ID for previous task
    //                 $prevIdInDb = (isset($taskIdMap[$previousTaskId])) ? $taskIdMap[$previousTaskId] : $previousTaskId;

    //                 Task::where('id', $prevIdInDb)
    //                     ->update(['next_task_id' => $currentTaskId]);
    //             }

    //             $previousTaskId = $currentTaskId; // Update for the next iteration
    //         }

    //         // After processing all tasks, ensure the last task has next_task_id = null
    //         if ($previousTaskId) {
    //             $lastTaskId = (isset($taskIdMap[$previousTaskId])) ? $taskIdMap[$previousTaskId] : $previousTaskId;
    //             Task::where('id', $lastTaskId)->update(['next_task_id' => null]);
    //         }
    //         $newStatuses = collect($tasksData)
    //             ->pluck('status')
    //             ->unique()
    //             ->filter();

    //         foreach ($newStatuses as $statusName) {
    //             $status = Status::firstOrCreate(['name' => $statusName]);
    //             DB::table('task_template_status')
    //                 ->updateOrInsert(
    //                     ['task_template_id' => $taskTemplate->id, 'status_id' => $status->id]
    //                 );
    //         }
    //         if ($request->has('new_statuses')) {
    //             $newStatuses = explode(',', $request->input('new_statuses'));
    //             foreach ($newStatuses as $statusName) {
    //                 $statusName = trim($statusName);
    //                 if ($statusName === '')
    //                     continue;

    //                 // Check if status already exists (avoid duplicates)
    //                 $existing = \App\Models\Status::where('name', $statusName)->first();
    //                 if (!$existing) {
    //                     \App\Models\Status::create([
    //                         'name' => $statusName,
    //                         // Add other default fields if needed (e.g., color)
    //                     ]);
    //                 }
    //             }
    //         }


    //         DB::commit();

    //         return redirect()->route('useradmin.task_templates.index')
    //             ->with('success', 'Task template updated successfully.');
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         Log::error('Error updating task template: ' . $e->getMessage());
    //         return redirect()->route('useradmin.task_templates.index')
    //             ->with('error', 'An error occurred while updating the task template.');
    //     }
    // }



    public function str_update(Request $request, $taskTemplate_id)
    {


        Log::info('Task template update request:', $request->all());
        $request->validate([
            'template_name' => 'required|string|max:255',
            'event_category' => 'required|exists:category,id',
            'tasks' => 'nullable|array',
            'tasks.*.name' => 'nullable|string|max:255',
            'tasks.*.duration' => 'nullable|string|max:255',
            'tasks.*.priority' => 'nullable|string|max:255|in:Low,Medium,High',
            'tasks.*.status' => 'nullable|string|max:255',
            'all_statuses' => 'required|string',
        ]);

        DB::beginTransaction();

        try {
            // Update template info
            $taskTemplate = TaskTemplate::findOrFail($taskTemplate_id);
            $taskTemplate->update([
                'template_name' => $request->template_name,
                'category_id' => $request->event_category,
                'all_statuses' => $request->all_statuses,
            ]);

            // Delete all existing tasks
            Task::where('task_template_id', $taskTemplate->id)->delete();

            // Delete old template-status relations
            DB::table('task_template_status')->where('task_template_id', $taskTemplate->id)->delete();

            // Create/attach all statuses
            $allStatuses = array_filter(array_map('trim', explode(',', $request->all_statuses)));
            $statusMap = [];
            foreach ($allStatuses as $statusName) {
                $status = Status::firstOrCreate(['name' => $statusName]);
                $statusMap[$statusName] = $status->id;

                DB::table('task_template_status')->insert([
                    'task_template_id' => $taskTemplate->id,
                    'status_id' => $status->id,
                ]);
            }

            // Recreate all submitted tasks as NEW with prev/next linking
            $previousTaskId = null;
            if ($request->tasks) {
                foreach ($request->tasks as $index => $taskData) {
                    $statusId = $statusMap[$taskData['status']] ?? Status::firstOrCreate(['name' => $taskData['status']])->id;

                    $task = Task::create([
                        'task_template_id' => $taskTemplate->id,
                        'task_name' => $taskData['name'],
                        'task_duration' => $taskData['duration'],
                        'priority' => $taskData['priority'],
                        'status_id' => $statusId,
                        'prev_task_id' => $previousTaskId,
                        'next_task_id' => null,
                        'order_index' => $index,
                    ]);

                    // Update previous task's next_task_id to link to current task
                    if ($previousTaskId) {
                        Task::where('id', $previousTaskId)->update(['next_task_id' => $task->id]);
                    }

                    $previousTaskId = $task->id;
                }
            }
            DB::commit();





            return response()->json([
                'success' => true,
                'message' => 'Task template update successfully.',
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating task template: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Task template update failed.',
            ]);
        }
    }



    public function update(Request $request, TaskTemplate $taskTemplate)
    {
        $request->validate([
            'template_name' => 'required|string|max:255',
            'event_category' => 'required|exists:category,id',
            'tasks' => 'nullable|array',
            'tasks.*.name' => 'nullable|string|max:255',
            'tasks.*.duration' => 'nullable|string|max:255',
            'tasks.*.priority' => 'nullable|string|max:255|in:Low,Medium,High',
            'tasks.*.status' => 'nullable|string|max:255',
            'all_statuses' => 'required|string',
        ]);

        DB::beginTransaction();


        Log::info('Task template update request:', $request->all());

        try {
            // Update template info
            $taskTemplate->update([
                'template_name' => $request->template_name,
                'category_id' => $request->event_category,
                'all_statuses' => $request->all_statuses,
            ]);

            // Delete all existing tasks
            Task::where('task_template_id', $taskTemplate->id)->delete();

            // Delete old template-status relations
            DB::table('task_template_status')->where('task_template_id', $taskTemplate->id)->delete();

            // Create/attach all statuses
            $allStatuses = array_filter(array_map('trim', explode(',', $request->all_statuses)));
            $statusMap = [];
            foreach ($allStatuses as $statusName) {
                $status = Status::firstOrCreate(['name' => $statusName]);
                $statusMap[$statusName] = $status->id;

                DB::table('task_template_status')->insert([
                    'task_template_id' => $taskTemplate->id,
                    'status_id' => $status->id,
                ]);
            }

            // Recreate all submitted tasks as NEW with prev/next linking
            $previousTaskId = null;


            if ($request->tasks) {
                foreach ($request->tasks as $index => $taskData) {
                    $statusId = $statusMap[$taskData['status']] ?? Status::firstOrCreate(['name' => $taskData['status']])->id;

                    $task = Task::create([
                        'task_template_id' => $taskTemplate->id,
                        'task_name' => $taskData['name'],
                        'task_duration' => $taskData['duration'],
                        'priority' => $taskData['priority'],
                        'status_id' => $statusId,
                        'prev_task_id' => $previousTaskId,
                        'next_task_id' => null,
                        'order_index' => $index,
                    ]);

                    // Update previous task's next_task_id to link to current task
                    if ($previousTaskId) {
                        Task::where('id', $previousTaskId)->update(['next_task_id' => $task->id]);
                    }

                    $previousTaskId = $task->id;
                }
            }
            DB::commit();

            return redirect()->route('useradmin.task_templates.index')
                ->with('success', 'Task template updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating task template: ' . $e->getMessage());

            return redirect()->route('useradmin.task_templates.index')
                ->with('error', 'An error occurred while updating the task template.');
        }
    }

    public function destroy(TaskTemplate $taskTemplate)
    {
        DB::beginTransaction();
        try {
            // Delete associated tasks first
            $taskTemplate->tasks()->delete();
            // Then delete the template
            $taskTemplate->delete();
            DB::commit();
            return redirect()->route('useradmin.task_templates.index')->with('success', 'Task template deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error deleting task template: ' . $e->getMessage());
            return redirect()->route('useradmin.task_templates.index')->with('error', 'An error occurred while deleting the task template.');
        }
    }

    /**
     * Display event tasks for the Kanban board.
     * This method will fetch tasks for a specific event's template, categorized by status.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function eventTasks(Request $request)
    {
        $selectedEventId = $request->input('event_id'); // Get selected event ID from query param or form
        $events = AdminEvent::where('task_template_id', '!=', null)->get(); // For the dropdown

        $pendingTasks = collect();
        $inProgressTasks = collect();
        $completedTasks = collect();
        $selectedEventName = null;

        if ($selectedEventId) {
            $event = AdminEvent::find($selectedEventId);
            if ($event && $event->task_template_id) {
                $selectedEventName = $event->event_name; // Assuming 'event_name' column exists
                $taskTemplateId = $event->task_template_id;

                // Fetch tasks for the selected event's template, ordered by 'order_index'
                $tasks = Task::where('task_template_id', $taskTemplateId)
                    ->orderBy('order_index') // Order by the index within the column
                    ->get();

                $pendingTasks = $tasks->where('status', 'Pending');
                $inProgressTasks = $tasks->where('status', 'In Progress');
                $completedTasks = $tasks->where('status', 'Completed');
            }
        }

        return view('Admin_events.task_management.event_tasks', compact('events', 'pendingTasks', 'inProgressTasks', 'completedTasks', 'selectedEventId', 'selectedEventName'));
    }
    public function getTaskTemplates(Request $request)
    {
        $category = $request->input('category');
        // Retrieve task templates based on the selected category
        $taskTemplates = TaskTemplate::where('category_id', $category)->where('template_name', 'not like', '%v2%')->orWhereNull('template_name')->get();
        return response()->json($taskTemplates);
    }

    public function getEventTaskTemplate(Request $request)
    {
        $eventId = $request->input('eid');
        // find the event
        $event = AdminEvent::find($eventId);
        if (!$event) {
            return response()->json(['error' => 'Event not found'], 404);
        }
        if ($event->task_template_id == null) {
            return response()->json(['error' => 'Event does not have a task template'], 404);
        }
        // Retrieve task templates based on the selected category
        $taskTemplate = TaskTemplate::with(['tasks.status'])
            ->find($event->task_template_id);


        Log::info($taskTemplate);

        return response()->json($taskTemplate);

    }

    public function getTaskTemplateStatus(Request $request)
    {
        $template_id = $request->input('template_id');

        $status = DB::table('task_template_status')
            ->join('statuses', 'task_template_status.status_id', '=', 'statuses.id')
            ->where('task_template_status.task_template_id', $template_id)
            ->select('statuses.*')   // choose the columns you need
            ->get();
        Log::info($status);

        return response()->json($status);
    }

    public function storeEventTask(Request $request)
    {
        // Validate the request data
        $this->validate($request, [
            'event_id' => 'required|exists:events,eid',
            'taskName' => 'required|string|max:255',
            'taskDuration' => 'required|string|max:255',
            'priority' => 'required|in:Low,Medium,High',
            'status' => 'required|string|max:255',
        ]);

        Log::info($request->all());


        $taskTemplate = optional(AdminEvent::where('eid', $request->input('event_id'))->first())
            ->task_template_id
            ? TaskTemplate::find(optional(AdminEvent::where('eid', $request->input('event_id'))->first())->task_template_id)
            : null;

        $status = $taskTemplate
            ? DB::table('task_template_status')
            ->where('task_template_id', $taskTemplate->id)
            ->where('status_id', Status::where('name', $request->input('status'))->first()->id)
            ->first()
            : null;




        DB::beginTransaction();
        try {
            $eventId = $request->input('event_id');
            $taskName = $request->input('taskName');
            $taskDuration = $request->input('taskDuration');
            $priority = $request->input('priority');
            $taskStatus = $status->status_id;

            // Find the event
            $event = AdminEvent::find($eventId);
            if (!$event) {
                return response()->json(['error' => 'Event not found'], 404);
            }
            $eventTaskTemplate = TaskTemplate::find($event->task_template_id);
            if (!$eventTaskTemplate) {
                // If an event doesn't have a template, maybe create one on the fly, or return error
                return response()->json(['error' => 'Event does not have a task template linked.'], 404);
            }

            // Determine the order_index for the new task within the 'Pending' column
            // Find the maximum order_index for 'Pending' tasks in this template

            $status = DB::table('task_template_status')
                ->where('task_template_id', $eventTaskTemplate->id)
                ->first();

            if (!$status) {
                return response()->json(['error' => 'No status found for this task template.'], 404);
            }
            $maxOrderIndex = Task::where('task_template_id', $eventTaskTemplate->id)
                ->where('status_id', $status->status_id)
                ->max('order_index');
            $newOrderIndex = ($maxOrderIndex !== null) ? $maxOrderIndex + 1 : 0; // If no tasks, start at 0

            // Create a new task
            $task = new Task();
            $task->task_template_id = $eventTaskTemplate->id;
            $task->task_name = $taskName;
            $task->task_duration = $taskDuration;
            $task->status_id = $taskStatus;
            $task->priority = $priority;
            $task->order_index = $newOrderIndex;
            $task->prev_task_id = null; // These can be dynamically updated by a separate mechanism if really needed
            $task->next_task_id = null;
            $task->save();


            DB::commit();

            $events = AdminEvent::where('task_template_id', '=', $taskTemplate->id)->get(); // For the dropdown


            Log::info('Task created successfully: ' . json_encode($events));
            broadcast(new TaskUpdated(json_decode($events)))->toOthers();

            return response()->json(['success' => true, 'message' => 'Task created successfully', 'task' => $task]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('An error occurred while creating the event task: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred while creating the task', 'details' => $e->getMessage()], 500);
        }
    }

    /**
     * Handles updates to task status and order within an event's task board.
     * This method will be called via AJAX from the frontend (Sortable.js onEnd event).
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateEventTask(Request $request)
    {
        $validated = $request->validate([
            'task_id' => 'required|exists:tasks,id',
            'status' => 'required|exists:statuses,name', // Expecting lowercase status
            'order_updates' => 'required|array', // Array of {task_id, order_index} for the affected column
            'order_updates.*.task_id' => 'required|exists:tasks,id',
            'order_updates.*.order_index' => 'required|integer|min:0',
        ]);

        try {
            DB::transaction(function () use ($validated) {
                $taskIdToUpdate = $validated['task_id'];
                $newStatusForUpdatedTask = Status::where('name', $validated['status'])->first()->id; // Convert to 'Pending', 'In Progress', 'Completed'


                $originalTask = Task::findOrFail($taskIdToUpdate);
                $existTemplateId = $originalTask->task_template_id;
                $existTemplate = TaskTemplate::findOrFail($existTemplateId);

                // Determine if this is the first time any task in this template is being ordered/status changed
                // This logic is for your specific template versioning system.
                // It checks if all tasks in the template currently have a NULL order_index.
                $tasksWithNullOrderIndexCount = Task::where('task_template_id', $existTemplateId)
                    ->where('order_index', '=', 0)
                    ->count();


                Log::info($tasksWithNullOrderIndexCount);


                $totalTasksInTemplate = Task::where('task_template_id', $existTemplateId)->count();

                $shouldCreateNewTemplateVersion = ($this->isOriginal($existTemplate->template_name));

                $events = [];

                if ($shouldCreateNewTemplateVersion) {
                    // Create a new template version (e.g., v2, v3, etc.)
                    $nextVersion = ($existTemplate->version ?? 1) + 1; // Assuming a 'version' column, default to 1
                    $newTemplateName = $existTemplate->template_name;





                    // Remove existing (vX) suffix if present, then add new one
                    if (preg_match('/ \(v\d+\)$/', $newTemplateName, $matches)) {
                        $newTemplateName = substr($newTemplateName, 0, -strlen($matches[0]));
                    }
                    $newTemplateName .= ' (v' . $nextVersion . ')';

                    $newTemplate = TaskTemplate::create([
                        'template_name' => $newTemplateName,
                        'category_id' => $existTemplate->category_id,
                        'version' => $nextVersion, // Store the version number
                    ]);

                    Status::whereIn('id', $existTemplate->statuses->pluck('id'))
                        ->each(function ($status) use ($newTemplate) {
                            DB::table('task_template_status')->insert([
                                'task_template_id' => $newTemplate->id,
                                'status_id' => $status->id,
                            ]);
                        });


                    $existTasks = Task::where('task_template_id', $existTemplateId)->orderBy('id', 'asc')->get();
                    $oldToNewTaskMap = [];

                    // Duplicate existing tasks for the new template
                    foreach ($existTasks as $oldTask) {
                        $currentTaskStatus = ($oldTask->id == $taskIdToUpdate) ? $newStatusForUpdatedTask : $oldTask->status_id;

                        $newTask = Task::create([
                            'task_template_id' => $newTemplate->id,
                            'task_name' => $oldTask->task_name,
                            'task_duration' => $oldTask->task_duration,
                            'status_id' => $currentTaskStatus,
                            'priority' => $oldTask->priority,
                            'prev_task_id' => null, // These will be re-established by order_index in next step
                            'next_task_id' => null,
                            'order_index' => null, // Will be updated from order_updates
                        ]);
                        $oldToNewTaskMap[$oldTask->id] = $newTask->id;
                    }

                    // Update task teams if there's a team assigned to the event, linking to new task IDs
                    foreach ($oldToNewTaskMap as $oldTaskId => $newTaskId) {
                        TaskTeam::where('task_id', $oldTaskId)->update(['task_id' => $newTaskId]);
                    }

                    // Update any events using the old template to use the new template
                    AdminEvent::where('task_template_id', $existTemplateId)->update(['task_template_id' => $newTemplate->id]);

                    // Now, apply order_index and status for the tasks in the *new* template
                    foreach ($validated['order_updates'] as $update) {
                        $originalOldTaskId = $update['task_id'];
                        if (isset($oldToNewTaskMap[$originalOldTaskId])) {
                            $newTaskId = $oldToNewTaskMap[$originalOldTaskId];
                            $statusToApply = ($originalOldTaskId == $taskIdToUpdate) ? $newStatusForUpdatedTask : Task::find($newTaskId)->status_id; // Get status of the newly created task
                            Task::where('id', $newTaskId)->update([
                                'order_index' => $update['order_index'],
                                'status_id' => $statusToApply,
                            ]);
                        }
                    }


                    $events = AdminEvent::where('task_template_id', $newTemplate->id)->get();



                } else {
                    // No new template version needed. Update tasks in the existing template.

                    // Update the status of the specific task that was changed
                    Task::where('id', $taskIdToUpdate)->update(['status_id' => $newStatusForUpdatedTask]);

                    // Update order_index for all tasks in this template as per order_updates
                    // (This handles reordering within the target column)
                    foreach ($validated['order_updates'] as $update) {
                        Task::where('id', $update['task_id'])
                            ->where('task_template_id', $existTemplateId) // Ensure task belongs to the current template
                            ->update(['order_index' => $update['order_index']]);
                    }

                    $events = AdminEvent::where('task_template_id', $existTemplateId)->get();

                }


                broadcast(new TaskUpdated(json_decode($events)))->toOthers();
            });




            return response()->json(['success' => true, 'message' => 'Task updated successfully.']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating event task: ' . $e->getMessage() . ' Trace: ' . $e->getTraceAsString());
            return response()->json(['error' => 'An error occurred while updating the task.', 'details' => $e->getMessage()], 500);
        }
    }

    function isOriginal($name)
    {
        return !preg_match('/\(v\d+\)/', $name);
    }


    public function updateEventTaskColumn(Request $request)
    {
        $validated = $request->validate([
            'task_template_id' => 'required|exists:task_templates,id',
            'status' => 'required'
        ]);


        Log::info($validated);

        try {
            DB::transaction(function () use ($validated) {

                $tasksWithNullOrderIndexCount = Task::where('task_template_id', $validated['task_template_id'])
                    ->where('order_index', '=', 0)
                    ->count();



                $existTemplateId = $validated['task_template_id'];
                $existTemplate = TaskTemplate::findOrFail($existTemplateId);
                $totalTasksInTemplate = Task::where('task_template_id', $existTemplateId)->count();





                $shouldCreateNewTemplateVersion = ($this->isOriginal($existTemplate->template_name));

                Log::info("shouldCreateNewTemplateVersion " . ($shouldCreateNewTemplateVersion ? 'true' : 'false') . " " . $existTemplate->template_name);
                $events = [];

                if ($shouldCreateNewTemplateVersion) {
                    // Create a new template version (e.g., v2, v3, etc.)
                    $nextVersion = ($existTemplate->version ?? 1) + 1; // Assuming a 'version' column, default to 1
                    $newTemplateName = $existTemplate->template_name;

                    // Remove existing (vX) suffix if present, then add new one
                    if (preg_match('/ \(v\d+\)$/', $newTemplateName, $matches)) {
                        $newTemplateName = substr($newTemplateName, 0, -strlen($matches[0]));
                    }
                    $newTemplateName .= ' (v' . $nextVersion . ')';

                    $newTemplate = TaskTemplate::create([
                        'template_name' => $newTemplateName,
                        'category_id' => $existTemplate->category_id,
                        'version' => $nextVersion, // Store the version number
                    ]);

                    $statuses = Status::whereIn('name', $validated['status'])->get();
                    if ($statuses->isEmpty()) {
                        $statuses = Status::create([
                            'name' => $validated['status'],
                        ]);
                        $statuses->save();
                    }

                    DB::table('task_template_status')->insert([
                        'task_template_id' => $newTemplate->id,
                        'status_id' => $statuses->id,
                    ]);

                    $existTasks = Task::where('task_template_id', $existTemplateId)->orderBy('id', 'asc')->get();
                    $oldToNewTaskMap = [];

                    // Duplicate existing tasks for the new template
                    foreach ($existTasks as $oldTask) {
                        $currentTaskStatus = $oldTask->status_id;

                        $newTask = Task::create([
                            'task_template_id' => $newTemplate->id,
                            'task_name' => $oldTask->task_name,
                            'task_duration' => $oldTask->task_duration,
                            'status_id' => $currentTaskStatus,
                            'priority' => $oldTask->priority,
                            'prev_task_id' => null, // These will be re-established by order_index in next step
                            'next_task_id' => null,
                            'order_index' => null, // Will be updated from order_updates
                        ]);
                        $oldToNewTaskMap[$oldTask->id] = $newTask->id;
                    }

                    // Update task teams if there's a team assigned to the event, linking to new task IDs
                    foreach ($oldToNewTaskMap as $oldTaskId => $newTaskId) {
                        TaskTeam::where('task_id', $oldTaskId)->update(['task_id' => $newTaskId]);
                    }

                    // Update any events using the old template to use the new template
                    AdminEvent::where('task_template_id', $existTemplateId)->update(['task_template_id' => $newTemplate->id]);

                    // Now, apply order_index and status for the tasks in the *new* template
                    foreach ($validated['order_updates'] as $update) {
                        $originalOldTaskId = $update['task_id'];
                        if (isset($oldToNewTaskMap[$originalOldTaskId])) {
                            $newTaskId = $oldToNewTaskMap[$originalOldTaskId];
                            $statusToApply = Task::find($newTaskId)->status_id;
                            Task::where('id', $newTaskId)->update([
                                'order_index' => $update['order_index'],
                                'status_id' => $statusToApply,
                            ]);
                        }
                    }


                    $events = AdminEvent::where('task_template_id', '=', $newTemplate->id)->get(); // For the dropdown

                } else {

                    $statusesList = Status::where('name', '=', $validated['status'])->get();




                    if ($statusesList->isEmpty()) {
                        $statuses = Status::create([
                            'name' => $validated['status'],
                        ]);
                        $statuses->save();
                    } else {
                        $statuses = $statusesList->first();
                    }


                    Log::info("status " . $statuses['id'] . " " . json_encode($statuses));



                    DB::table('task_template_status')->insert([
                        'task_template_id' => $existTemplateId,
                        'status_id' => $statuses->id,
                    ]);
                    $events = AdminEvent::where('task_template_id', '=', $existTemplateId)->get(); // For the dropdown

                }


                broadcast(new TaskUpdated(json_decode($events)))->toOthers();

            });

            return response()->json(['success' => true, 'message' => 'Column Added successfully.']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating event task: ' . $e->getMessage() . ' Trace: ' . $e->getTraceAsString());
            return response()->json(['error' => 'An error occurred while Adding the Column.', 'details' => $e->getMessage()], 500);
        }
    }


    public function deleteColumn(Request $request)
    {
        $validated = $request->validate([
            'task_template_id' => 'required|exists:task_templates,id',
            'status_id' => 'required|exists:statuses,id',
        ]);

        try {
            DB::beginTransaction();

            // Delete the status from the pivot table
            DB::table('task_template_status')
                ->where('task_template_id', $validated['task_template_id'])
                ->where('status_id', $validated['status_id'])
                ->delete();

            DB::commit();

            $events = AdminEvent::where('task_template_id', '=', $validated['task_template_id'])->get(); // For the dropdown

            broadcast(new TaskUpdated(json_decode($events)))->toOthers();


            return response()->json(['success' => true, 'message' => 'Column Deleted successfully.']);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating event task: ' . $e->getMessage() . ' Trace: ' . $e->getTraceAsString());
            return response()->json(['error' => 'An error occurred while Deleting the Column.', 'details' => $e->getMessage()], 500);
        }
    }


    public function deleteTask(Request $request)
    {
        $validated = $request->validate([
            'task_id' => 'required|exists:tasks,id',
        ]);

        try {
            DB::beginTransaction();

            $task = Task::find($validated['task_id']);

            $events = AdminEvent::where('task_template_id', '=', $task->task_template_id)->get(); // For the dropdown


            $task->delete();
            DB::commit();




            broadcast(new TaskUpdated(json_decode($events)))->toOthers();
            return response()->json(['success' => true, 'message' => 'Task Deleted successfully.']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating event task: ' . $e->getMessage() . ' Trace: ' . $e->getTraceAsString());
            return response()->json(['error' => 'An error occurred while Deleting the Task.', 'details' => $e->getMessage()], 500);
        }
    }




    public function updateTask(Request $request)
    {
        Log::alert("ssss");
        $validated = $request->validate([
            'task_id' => 'required|exists:tasks,id',
            'task_name' => 'required|string|max:255',
            'task_duration' => 'required|string|max:255',
            'priority' => 'required|in:Low,Medium,High',
        ]);

        $task = Task::where('id', '=', $validated['task_id'])->first();


        $events = AdminEvent::where('task_template_id', '=', $task->task_template_id)->get(); // For the dropdown

        try {
            DB::beginTransaction();
            Task::where('id', $validated['task_id'])->first()->update($validated);
            DB::commit();



            broadcast(new TaskUpdated(json_decode($events)))->toOthers();

            return response()->json(['success' => true, 'message' => 'Task Updated successfully.']);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating event task: ' . $e->getMessage() . ' Trace: ' . $e->getTraceAsString());
            return response()->json(['error' => 'An error occurred while Updating the Task.', 'details' => $e->getMessage()], 500);
        }

    }



    public function updateColumn(Request $request)
    {
        $validated = $request->validate([
            'task_template_id' => 'required|exists:task_templates,id',
            'status_id' => 'required|exists:statuses,id',
            'status_name' => 'required|string|max:255',
            'event_id' => 'required|exists:events,eid',
        ]);

        try {
            DB::beginTransaction();

            // ✅ Fix: Create or find status by name
            $stat = Status::firstOrCreate(
                ['name' => $validated['status_name']]
            );



            // Count tasks with order_index = 0
            $tasksWithNullOrderIndexCount = Task::where('task_template_id', $validated['task_template_id'])
                ->where('order_index', '=', 0)
                ->count();

            $existTemplateId = $validated['task_template_id'];
            $existTemplate = TaskTemplate::findOrFail($existTemplateId);
            $totalTasksInTemplate = Task::where('task_template_id', $existTemplateId)->count();

            // Determine if new version is needed
            $shouldCreateNewTemplateVersion =
                ($this->isOriginal($existTemplate->template_name));


            $events = [];

            if ($shouldCreateNewTemplateVersion) {
                $nextVersion = ($existTemplate->version ?? 1) + 1;
                $newTemplateName = preg_replace('/ \(v\d+\)$/', '', $existTemplate->template_name) . " (v{$nextVersion})";

                $newTemplate = TaskTemplate::create([
                    'template_name' => $newTemplateName,
                    'category_id' => $existTemplate->category_id,
                    'version' => $nextVersion,
                ]);

                AdminEvent::where('eid', $validated['event_id'])
                    ->update(['task_template_id' => $newTemplate->id]);

                $existTasks = Task::where('task_template_id', $existTemplateId)
                    ->orderBy('id', 'asc')
                    ->get();


                $oldStatus = DB::table('task_template_status')
                    ->where('task_template_id', $existTemplateId)->get();

                foreach ($oldStatus as $status) {
                    DB::table('task_template_status')->insert([
                        'task_template_id' => $newTemplate->id,
                        'status_id' => $status->status_id,
                    ]);
                }


                foreach ($existTasks as $oldTask) {
                    $newTask = Task::create([
                        'task_template_id' => $newTemplate->id,
                        'task_name' => $oldTask->task_name,
                        'task_duration' => $oldTask->task_duration,
                        'status_id' => $oldTask->status_id,
                        'priority' => $oldTask->priority,
                        'prev_task_id' => null,
                        'next_task_id' => null,
                        'order_index' => null, // Will be updated later
                    ]);
                    $oldToNewTaskMap[$oldTask->id] = $newTask->id;
                }

                DB::table('task_template_status')
                    ->where('task_template_id', $newTemplate->id)
                    ->where('status_id', $validated['status_id'])
                    ->update(['status_id' => $stat->id]);

                foreach ($oldToNewTaskMap as $oldTaskId => $newTaskId) {
                    TaskTeam::where('task_id', $oldTaskId)->update(['task_id' => $newTaskId]);
                }

                AdminEvent::where('task_template_id', $existTemplateId)
                    ->update(['task_template_id' => $newTemplate->id]);

                Task::where('task_template_id', $newTemplate->id)->where('status_id', $validated['status_id'])
                    ->update(['status_id' => $stat->id]);


                $events = AdminEvent::where('task_template_id', '=', $newTemplate->id)->get(); // For the dropdown

            } else {

                DB::table('task_template_status')
                    ->where('task_template_id', $validated['task_template_id'])
                    ->where('status_id', $validated['status_id'])
                    ->update(['status_id' => $stat->id]);


                Task::where('task_template_id', $validated['task_template_id'])->where('status_id', $validated['status_id'])
                    ->update(['status_id' => $stat->id]);

                $events = AdminEvent::where('task_template_id', '=', $validated['task_template_id'])->get(); // For the dropdown
            }


            broadcast(new TaskUpdated(json_decode($events)))->toOthers();



            DB::commit();
            return response()->json(['success' => true, 'message' => 'Column Updated successfully.']);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating event task: ' . $e->getMessage() . ' Trace: ' . $e->getTraceAsString());
            return response()->json([
                'error' => 'An error occurred while Updating the Column.',
                'details' => $e->getMessage()
            ], 500);
        }
    }
    public function taskEdit($taskTemplateId, $taskId)
    {
        $taskTemplate = TaskTemplate::findOrFail($taskTemplateId);
        $task = Task::findOrFail($taskId);

        return view('Admin_events.task_management.templates.taskedit', compact('task', 'taskTemplate'));
    }
    public function taskUpdate(Request $request, $taskTemplateId, $taskId)
    {
        $request->validate([
            'task_name' => 'required|string|max:255',
            'task_duration' => 'required|string|max:255',
            'priority' => 'required|in:Low,Medium,High',
        ]);

        $task = Task::findOrFail($taskId);
        $task->update([
            'task_name' => $request->task_name,
            'task_duration' => $request->task_duration,
            'priority' => $request->priority,
        ]);

        return redirect()->back()->with('success', 'Task updated successfully.');
    }
    public function categoryEdit($taskTemplateId, $statusId)
    {
        $taskTemplate = TaskTemplate::findOrFail($taskTemplateId);
        $status = Status::findOrFail($statusId);

        // Return the partial form view for editing
        return view('Admin_events.task_management.templates.categoryedit', compact('taskTemplate', 'status'));
    }
    public function categoryUpdate(Request $request, $taskTemplateId, $statusId)
    {

        Log::info($request->all());

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $status = Status::where('name', $request->name)->first();
        
        $tasktemplateStatus = DB::table('task_template_status')
            ->where('task_template_id', $taskTemplateId)
            ->where('status_id', $statusId)
            ->first();

        if (!$status) {
            $status = Status::create(['name' => $request->name]);
        }

        DB::table('task_template_status')
            ->where('task_template_id', $taskTemplateId)
            ->where('status_id', $statusId)
            ->update([
                'status_id' => $status->id,
            ]);


        return redirect()->back()->with('success', 'Category updated successfully!');
    }

}
