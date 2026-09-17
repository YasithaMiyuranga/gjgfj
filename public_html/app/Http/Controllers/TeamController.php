<?php

namespace App\Http\Controllers;

use App\Events\TaskUpdated;
use App\Models\Admin;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\AdminEvent;
use App\Models\Team;
use App\Models\TaskTeam;
use App\Models\Task;
use App\Models\TeamCategory;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class TeamController extends Controller
{
    public function getTeamMembers(Request $request, $eventId, $categoryId)
    {
        try {
            $members = Team::where('event_id', $eventId)
                ->where('team_category_id', $categoryId)
                ->where('status', 'Active')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $members
            ]);
        } catch (\Exception $e) {
            Log::error('Error loading team members: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error loading team members'
            ], 500);
        }
    }

    public function getAssignedTeamMembers($taskId)
    {
        try {
            $taskId = intval($taskId);

            $task = Task::findOrFail($taskId);

            $teamMembers = $task->teamAssignments->map(function ($assignment) {
                return [
                    'id' => $assignment->team_member_id,
                    'name' => $assignment->member_name,
                    'role' => $assignment->role
                ];
            });
            return response()->json([
                'success' => true,
                'team_members' => $teamMembers
            ]);
        } catch (\Exception $e) {
            Log::error('Error getting team members: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error getting team members: ' . $e->getMessage()
            ], 500);
        }
    }

    public function assignTeamToTask(Request $request)
    {

        // CREATE TASK_TEAM MIGRATION TABLE AND SAVE PARTS CHECK NEXT DAY
        try {
            $taskId = $request->memberDetails[0]['task_id'];

            $teamMembers = $request->get('memberDetails', []);

            // Delete existing assignments
            TaskTeam::where('task_id', $taskId)->delete();

            // Create new assignments
            $assignments = array_map(function ($member) use ($taskId) {
                return [
                    'task_id' => $taskId,
                    'team_category_id' => $member['team_category_id'],
                    'team_member_id' => $member['id'],
                    'member_name' => $member['member_name'],
                    'role' => $member['role'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }, $teamMembers);

            if (!empty($assignments)) {
                TaskTeam::insert($assignments);
            }



            $task = Task::where('id', $taskId)->first();

            $events = AdminEvent::where('task_template_id', $task->task_template_id)
                ->get();

            broadcast(new TaskUpdated(json_decode($events)))->toOthers();

            return response()->json([
                'success' => true,
                'message' => 'Team members assigned successfully'
            ]);










        } catch (\Exception $e) {
            Log::error('Error assigning team members: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error assigning team members'
            ], 500);
        }
    }
    public function loadTeamCategories($eventId, $taskId)
    {
        try {
            // Get all team categories for the event
            $teamCategories = TeamCategory::where('event_id', $eventId)
                ->with([
                    'teams' => function ($query) {
                        $query->where('status', 'Active');
                    }
                ])
                ->get();

            // Get existing assignments for the task
            $existingAssignments = TaskTeam::where('task_id', $taskId)
                ->pluck('team_category_id')
                ->toArray();

            // Format the response with assignment status
            $formattedCategories = $teamCategories->map(function ($category) use ($existingAssignments) {
                return [
                    'id' => $category->id,
                    'team_name' => $category->team_name,
                    'assigned' => in_array($category->id, $existingAssignments),
                    'teams' => $category->teams,
                    'members' => $category->teams->map(function ($team) {
                        return [
                            'id' => $team->id,
                            'name' => $team->team_name,
                            'status' => $team->status
                        ];
                    })
                ];
            });

            return response()->json([
                'success' => true,
                'data' => $formattedCategories
            ]);
        } catch (\Exception $e) {
            Log::error('Error loading team categories: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error loading team categories'
            ], 500);
        }
    }
    public function team_list()
    {
        $teams = Team::select('event_id', 'team_category_id', 'team_name')
            ->distinct()
            ->with('event')
            ->get()
            ->groupBy('event_id');

        return view('Admin_events.teams.index', compact('teams'));
    }

    function add_team()
    {
        $events = AdminEvent::all();
        $team_categories = TeamCategory::all();
        return view('Admin_events.teams.add', compact('events', 'team_categories'));
    }

    public function getMembersByCategory(Request $request)
    {
        $category = $request->get('category');

        switch ($category) {
            case 'manager':
                $members = DB::table('managers')->select('manager_id as id', 'name')->get();
                break;
            case 'artist':
                $members = DB::table('artist')->select('aid as id', 'artist_name as name')->get();
                break;
            default:
                $members = collect();
        }

        return response()->json($members);
    }

    public function removeTeamMemberFromTask(Request $request, $taskId, $teamMemberId)
    {

        try {
            // Delete the specific team member assignment
            $deleted = TaskTeam::where('task_id', $taskId)
                ->where('team_member_id', $teamMemberId)
                ->delete();

            $task = Task::where('id', $taskId)->first();

            $events = AdminEvent::where('task_template_id', $task->task_template_id)
                ->get();

            broadcast(new TaskUpdated(json_decode($events)))->toOthers();

            if ($deleted) {
                return response()->json([
                    'success' => true,
                    'message' => 'Team member removed successfully'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Team member not found in this task'
                ], 404);
            }






        } catch (\Exception $e) {
            Log::error('Error removing team member: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error removing team member: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getMemberDetails(Request $request)
    {
        $id = $request->get('id');
        $category = $request->get('category');

        switch ($category) {
            case 'manager':
                $member = DB::table('managers')
                    ->where('manager_id', $id)
                    ->select('mobile', 'status')
                    ->first();
                break;
            case 'artist':
                $member = DB::table('artist')
                    ->where('aid', $id)
                    ->select('phone_no as mobile', 'status')
                    ->first();
                break;
            default:
                $member = null;
        }

        return response()->json($member);
    }

    public function store_team(Request $request)
    {
        $request->validate([
            'teams_data' => 'required|json',
        ]);

        $teamsData = json_decode($request->teams_data, true);

        $teamDataToInsert = [];

        foreach ($teamsData as $team) {
            $eventId = $team['eventId'] ?? null;
            $teamId = $team['teamId'] ?? null;
            $teamName = $team['teamName'] ?? null;

            if (!empty($team['members']) && is_array($team['members'])) {
                foreach ($team['members'] as $member) {
                    $teamDataToInsert[] = [
                        'event_id' => $eventId,
                        'team_category_id' => $teamId,
                        'team_name' => $teamName,
                        'role' => $member['role'] ?? null,
                        'member_name' => $member['memberName'] ?? null,
                        'mobile' => $member['mobile'] ?? null,
                        'status' => $member['status'] ?? null,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }
        }

        try {
            if (!empty($teamDataToInsert)) {
                DB::table('teams')->insert($teamDataToInsert);
            }

            return redirect()->route('useradmin.events.team')->with('success', 'Teams created successfully!');
        } catch (\Exception $e) {
            return redirect()->route('useradmin.events.create_team')->with('failed', 'Failed to create team members.');
        }
    }


    public function st_store_team(Request $request)
    {
        $request->validate([
            'teams_data' => 'required|json',
        ]);

        $teamsData = json_decode($request->teams_data, true);

        $teamDataToInsert = [];

        foreach ($teamsData as $team) {
            $eventId = $team['eventId'] ?? null;
            $teamId = $team['teamId'] ?? null;
            $teamName = $team['teamName'] ?? null;

            if (!empty($team['members']) && is_array($team['members'])) {
                foreach ($team['members'] as $member) {
                    $teamDataToInsert[] = [
                        'event_id' => $eventId,
                        'team_category_id' => $teamId,
                        'team_name' => $teamName,
                        'role' => $member['role'] ?? null,
                        'member_name' => $member['memberName'] ?? null,
                        'mobile' => $member['mobile'] ?? null,
                        'status' => $member['status'] ?? null,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }
        }

        try {
            if (!empty($teamDataToInsert)) {
                DB::table('teams')->insert($teamDataToInsert);
            }
            return response()->json(['success' => true, 'message' => 'Teams created successfully!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to create teams.']);
        }
    }

    public function edit($team_id)
    {
        // Get a single team with its event details
        $team = DB::table('teams')
            ->join('events', 'teams.event_id', '=', 'events.eid')
            ->select('teams.team_category_id', 'teams.team_name', 'teams.event_id', 'events.event_name', 'events.eid')
            ->where('teams.team_category_id', $team_id)
            ->first();

        if (!$team) {
            return redirect()->back()->with('error', 'Team not found.');
        }

        // Get all team members with the same team_id
        $teamMembers = DB::table('teams')->where('team_category_id', $team_id)->get();

        return view('Admin_events.teams.edit_team', [
            'team' => $team,
            'teamMembers' => $teamMembers,
        ]);
    }

    public function destroy($team_id)
    {
        // Get the team  category
        $teamCategory = TeamCategory::where('id', $team_id)->first();

        if (!$teamCategory) {
            return redirect()->back()->with('error', 'Team not found.');
        }
        Team::where('team_category_id', $team_id)->delete();
        TeamCategory::where('id', $team_id)->delete();

        return redirect()->route('useradmin.events.team')->with('success', 'Team deleted successfully.');
    }

    public function destroyMember($id)
    {
        $member = Team::findOrFail($id);
        if (!$member) {
            return redirect()->back()->with('error', 'Member not found.');
        }
        $member->delete();
        Team::where('id', $id)->delete();

        return redirect()->back()->with('success', 'Member deleted successfully.');
    }


    public function create_team_name()
    {
        $events = AdminEvent::all();
        return view('Admin_events.teams.create_name', compact('events'));
    }


        public function str_create_team_name()
    {
        $events = AdminEvent::all();
        return view('Admin_events.teams.str_create_name', compact('events'));
    }

    public function store_team_name(Request $request)
    {
        try {
            // Validate the request data
            $validator = Validator::make($request->all(), [
                'event_id' => 'required|exists:events,eid',
                'team_name' => [
                    'required',
                    Rule::unique('team_categories')->where(function ($query) use ($request) {
                        return $query->where('event_id', $request->event_id);
                    }),
                ],
            ]);

            // If validation fails, redirect back with errors and input
            if ($validator->fails()) {
                return redirect()->route('useradmin.events.create_team')->withErrors($validator)->withInput()->with('failed', 'Team name already exists for the selected event.');
            }

            // Create the team name
            TeamCategory::create([
                'event_id' => $request->event_id,
                'team_name' => $request->team_name,
            ]);

            return redirect()->route('useradmin.events.create_team')->with('success', 'Team name added successfully!');
        } catch (\Exception $e) {
            return redirect()->route('useradmin.events.create_team')->with('failed', 'An error occurred while creating the team name.');
        }
    }





    public function str_store_team_name(Request $request)
    {
        try {
            // Validate the request data
            $validator = Validator::make($request->all(), [
                'event_id' => 'required|exists:events,eid',
                'team_name' => [
                    'required',
                    Rule::unique('team_categories')->where(function ($query) use ($request) {
                        return $query->where('event_id', $request->event_id);
                    }),
                ],
            ]);

            // If validation fails, redirect back with errors and input
            if ($validator->fails()) {
                return response()->json(['success' => false, 'errors' => $validator->errors()]);
            }

            // Create the team name
            TeamCategory::create([
                'event_id' => $request->event_id,
                'team_name' => $request->team_name,
            ]);
            return response()->json(['success' => true, 'message' => 'Team name added successfully!']);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'An error occurred while adding the team name.']);
        }
    }

    public function update_team(Request $request, $team_id)
    {
        $request->validate([
            'new_members' => 'array',

        ]);

        try {
            $teamName = Team::where('team_category_id', $team_id)->value('team_name');
            $eventId = Team::where('team_category_id', $team_id)->value('event_id');

            foreach ($request->new_members as $member) {
                Team::insert([
                    'team_category_id' => $team_id,
                    'team_name' => $teamName,
                    'event_id' => $eventId,
                    'role' => $member['role'],
                    'member_name' => $member['member_name'],
                    'mobile' => $member['mobile'],
                    'status' => $member['status'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            return redirect()->route('useradmin.events.team')->with('success', 'Team updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update team. Error: ' . $e->getMessage());
        }
    }

    public function checkTeamName(Request $request)
    {
        $exists = TeamCategory::where('event_id', $request->event_id)
            ->where('team_name', $request->team_name)
            ->exists();

        return response()->json(['exists' => $exists]);
    }

    public function getTeamsName(Request $request)
    {
        $eventId = $request->query('eventId');
        $teamsName = TeamCategory::where('event_id', $eventId)->get(['id', 'team_name']);

        return response()->json($teamsName);
    }

}
