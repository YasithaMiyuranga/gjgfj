<?php

namespace App\Http\Controllers\events;

use App\Models\Agent;
use App\Models\Agents;
use App\Models\AdminEvent;
use App\Models\AgentEvent;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class agentlistcontroller extends Controller
{
    /**
     * Display a listing of all agents.
     *
     * @return \Illuminate\Http\Response
     */
    function agents_list()
    {
        $agents = Agents::all();
        return view('Admin_events.agents.index', compact('agents'));
    }

    /**
     * Display the add agent view.
     *
     * @return \Illuminate\Http\Response
     * Gets the list of ongoing events and passes it to the add agent view.
     */
    function add_agent()
    {
        // Get the list of events
        $events = AdminEvent::whereNotIn('status', ['cancelled', 'completed'])->get();

        return view('Admin_events.agents.add', compact('events'));
    }

    /**
     * Store a newly created agent in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:agents,email',
            'password' => 'required|string|min:8',
            'phone' => 'required|string|max:20|regex:/^(\+\d{1,3}[- ]?)?\d{10}$/',
            'event_id' => 'nullable|array|max:20',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'zip' => 'nullable|string|max:8|min:4',
            'status' => 'required|string|max:20',
            'type' => 'required|string|max:50',
        ]);

        // Start a transaction
        DB::begintransaction();
        try {
            // Create a new agent
            $agent = new Agents;
            $agent->name = $request->name;
            $agent->email = $request->email;
            $agent->phone = $request->phone;
            $agent->password = Hash::make($request->password);
            $agent->address = $request->address;
            $agent->city = $request->city;
            $agent->state = $request->state;
            $agent->zip = $request->zip;
            $agent->status = $request->status;
            $agent->type = $request->type;

            $agent->save();

            // Check if the agent was created
            if (!$agent) {
                return redirect()->route('useradmin.events.agents_list')->with('error', 'Agent not created.');
            }

            // Get events
            $events = $request->event_id;

            // Checks events array is not null
            if ($events != null) {

                // Iterate over each event ID
                foreach ($events as $event_id) {

                    // Call the function to add the agent to the event
                    if( $event_id == "allevent"){

                        // Get all events in the events table
                        $eventAll = AdminEvent::all();

                        // Iterate over each event
                        foreach ($eventAll as $event) {

                            // create object of agent_event class
                            $agent_event = new AgentEvent;

                            // Call the function to add the agent to the event
                            $agent_event::storeAgentEvent($agent->id, $event->eid);

                        }
                    }
                    // Assign events
                    else if( $event_id != null){

                        // Convert the string of event IDs to an array
                        $selectedEventIds = explode(',', $event_id);
                        // Iterate over each selected event ID
                        foreach ($selectedEventIds as $eventId) {

                            // create object of agent_event class
                            $agent_event = new AgentEvent;
                            // Call the function to add the agent to the event
                            $agent_event::storeAgentEvent($agent->id, $eventId);
                        }
                    }
                }
            }

            // Commit the transaction
            DB::commit();

            // Return a success message
            return redirect()->route('useradmin.events.agents_list')->with('success', 'Agent added successfully.');
        } catch (\Exception $e) {

            // Roll back the transaction
            DB::rollback();
            // Return an error message
            return redirect()->route('useradmin.events.agents_list')->with('error', 'Failed to add Agent.');
        }

    }

    /**
     * Edit an agent and display the edit view.
     *
     * @param int $id The ID of the agent to be edited.
     * @return \Illuminate\View\View The view for editing the agent.
     * Redirects with an error message if the agent is not found.
     */
    function edit_agent($id)
    {
        if( !Agents::find($id)){
            return redirect()->route('useradmin.events.agents_list')->with('error', 'Agent not found.');
        }

        // Get the agent with the  agent_event IDs in the agent_events table
        $agent = Agents::find($id);
        // Get the event ids of the agent_events table that agaent is assigned to
        $event_ids = AgentEvent::where('agent_id', $id)->pluck('event_id')->toArray();
        // Find the event names
        $event_names = AdminEvent::whereIn('eid', $event_ids)->pluck('event_name')->toArray();
        // Get the list of events
        $events= AdminEvent::whereNotIn('status', ['cancelled', 'completed'])->get();

        return view('Admin_events.agents.edit', compact('agent', 'events', 'event_names'));
    }

    /**
     * Update an agent in the agents table
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    function update_agent(Request $request, $id)
    {

        $validateData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255,unique:agents,email,' . $id . ',id',
            'event_id' => 'nullable|array|max:20',
            'phone' => 'required|string|max:20',
            'password' => 'nullable|string|min:8',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'zip' => 'nullable|string|max:8|min:4',
            'status' => 'required|string|max:20',
            'type' => 'required|string|max:50',
        ]);

        // Start a transaction
        DB::begintransaction();
        try {
            // Check if password is not null
            if ($request->password != null) {

                // Hash the password
                $validateData['password'] = Hash::make($request->password);
            }
            else{

                // Get the existing password
                $existingPassword = Agents::find($id)->password;
                // Assign the existing password
                $validateData['password'] = $existingPassword;
            }
            // Find the agent
            $agent = Agents::find($id);

            if (!$agent) {
                return redirect()->route('useradmin.events.agents_list')->with('error', 'Agent not updated.');
            }
            // Updated the agent
            $agent->update($validateData);

            // Get events(Selected)
            $events = $request->input('event_id', []); // Default to an empty array if event_id is not present


            // Checks events array is not null
            if ($events != null) {

                // Iterate over each event ID
                foreach ($events as $event_id) {

                    // Call the function to add the agent to the event
                    if( $event_id == "allevent"){

                        // Get all events in the events table
                        $eventAll = AdminEvent::all();

                        // Iterate over each event
                        foreach ($eventAll as $event) {

                            // create object of agent_event class
                            $agent_event = new AgentEvent;

                            // update or create the agent_event
                            $agent_event::updateOrCreateAgentEvent($agent->id, $event->eid);
                        }
                    }
                    else if( $event_id != null){

                        // create object of agent_event class
                        $agent_event = new AgentEvent;
                        // Call the function to add the agent to the event
                        $agent_event::updateOrCreateAgentEvent($agent->id, $event_id);
                    }
                }
            }

            // Delete the previous agent_events
            $previousAgentEvents = AgentEvent::where('agent_id', $id)
                                    ->whereNotIn('event_id', $events)
                                    ->get();

            if ($previousAgentEvents->count() > 0) {
                // Delete the previous agent events
                foreach ($previousAgentEvents as $event) {
                    $event->delete();
                }
            }


            // Commit the transaction
            DB::commit();

            // Return a success message
            return redirect()->route('useradmin.events.agents_list')->with('success', 'Agent updated successfully.');
        } catch (\Exception $e) {

            // Roll back the transaction
            DB::rollback();
            // Return an error message
            return redirect()->route('useradmin.events.agents_list')->with('error', 'Failed to update Agent.');
        }
    }

    /**
     * Display the delete confirmation view for a specific agent.
     *
     * @param int $id The ID of the agent to be deleted.
     * @return \Illuminate\View\View The view for confirming agent deletion.
     */
    function delete_agent_view($id)
    {
        return view('Admin_events.agents.delete', compact('id'));
    }

    /**
     * Delete an agent and its associated agent_events from the database.
     *
     * @param int $id The ID of the agent to be deleted.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    function delete_agent($id)
    {
        DB::begintransaction();
        try {
            // Find the agent
            $agent = Agents::find($id);

            // Check if the agent exists
            if (!$agent) {
                // Redirect with an error message if the agent is not found
                return redirect()->route('useradmin.events.agents_list')->with('error', 'Agent not found.');
            }

            // Find the agent_events associated with the agents deleted
            $agent_events = AgentEvent::where('agent_id', $id)->delete();

            // Delete the agent
            $agent->delete();

            DB::commit();
            return redirect()->route('useradmin.events.agents_list')->with('success', 'Agent deleted successfully.');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('useradmin.events.agents_list')->with('error', 'Failed to delete Agent.');
        }
    }

      //*** AGENTS TICKETS */

      public function agent_ticket_sale()
      {
        return view('Admin_events.agents.ticketsales.index');

      }

     public function agent_paymants()
     {

     }

     public function agent_commission()
     {


     }
}
