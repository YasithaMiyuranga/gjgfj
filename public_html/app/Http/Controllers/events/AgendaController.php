<?php

namespace App\Http\Controllers\events;

use Exception;

use App\Models\Agenda;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\AdminEvent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AgendaController extends Controller
{
    /**
     * Get all agendas and associated event names.
     *
     * @return \Illuminate\Http\Response
     */
    function agenda_list()
    {
        // Get all agendas
        $agendas = Agenda::get();
        // Find events name matching the agendas
        foreach ($agendas as $agenda) {
            $event = AdminEvent::where('eid', $agenda->event_id)->first();
            if ($event) {
                $agenda->event_name = $event->event_name;
            }
        }

        return view('Admin_events.agendas.index', compact('agendas'));

    }

    /**
     * Display the form for creating a new agenda.
     *
     * Fetches all ongoing events and passes them
     * to the view for agenda creation.
     *
     * @return \Illuminate\View\View
     */

    function add_agenda()
    {
        // Fetch all ongoing events
        $events= AdminEvent::whereNotIn('status', ['cancelled', 'completed'])->get();
        return view('Admin_events.agendas.add', compact('events'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    function store_agenda(Request $request)
    {
       // Validate the request data
       $validatedData = Validator::make($request->all(), [
           'event_id' => 'required|exists:events,eid',
           'agenda' => 'required|array',
           'agenda.*.date' => 'required|date',
           'agenda.*.date_name' => 'required|string|max:255',
           'agenda.*.is_active' => 'required|in:active,inactive',
           'agenda.*.details' => 'required|array',
           'agenda.*.details.*.title' => 'required|string|max:255',
           'agenda.*.details.*.description' => 'nullable|string|max:255',
       ]);

        // Check if the validation fails
        if($validatedData->fails()){
           return redirect()->back()->withErrors($validatedData)->withInput();
        }

        try{
            // Find the event
            $event = AdminEvent::find($request->event_id);
            // If event is not found
            if(!$event){
                return redirect()->back()->with('error', 'Event not found');
            }

            // Loop through each agenda
            foreach ($request->agenda as $agenda) {
                // Create a new agenda
                $newAgenda = $event->agendas()->create($agenda);

                // Loop through each detail
                foreach ($agenda['details'] as $detail) {
                    // Create a new detail
                    $newAgenda->agendaDetails()->create($detail);
                }
            }

            // Redirect back with success message
            return redirect()->Route('useradmin.agenda.view')->with('success', 'Agenda created successfully');
        }catch(Exception $e){
            // Redirect back with error message
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified agenda.
     *
     * @param \App\Models\Agenda $agenda
     * @return \Illuminate\Http\Response
     */
    function edit_agenda(Agenda $agenda)
    {
        // Retrieve the agenda with its details
        $agenda = Agenda::with('agendaDetails')->find($agenda->id);

        // Get the event ID associated with the agenda
        $eventId = $agenda->event_id;

        // Find the event using the event ID
        $event = AdminEvent::where('eid', $eventId)->first();

        // If the event is not found, redirect back with an error message
        if (!$event) {

            return redirect()->back()->with('error', 'Event not found');
        }

        // Return the edit view with the agenda and event data
        return view('Admin_events.agendas.edit', compact('agenda', 'event'));
    }

    /**
     * Update the specified agenda in the storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Agenda  $agenda
     * @return \Illuminate\Http\Response
     */
    function update_agenda(Request $request, Agenda $agenda)
    {
        $validatedData = Validator::make($request->all(), [
            'event_id' => 'required|exists:events,eid',
            'agenda' => 'required|array',
            'agenda.*.date' => 'required|date',
            'agenda.*.date_name' => 'required|string|max:255',
            'agenda.*.is_active' => 'required|in:active,inactive',
            'agenda.*.details' => 'required|array',
            'agenda.*.details.*.title' => 'required|string|max:255',
            'agenda.*.details.*.description' => 'nullable|string|max:255',
        ]);

        // Check if the validation fails
        if($validatedData->fails()){
            return redirect()->back()->withErrors($validatedData)->withInput();
        }

        try{
            // Find the event
            $event = AdminEvent::find($request->event_id);
            // If event is not found
            if(!$event){
                return redirect()->back()->with('error', 'Event not found');
            }

            // Find the agenda
            $agenda = Agenda::find($agenda->id);
            // If agenda is not found
            if(!$agenda){
                return redirect()->back()->with('error', 'Agenda not found');
            }

            // Update the agenda
            $agenda->update([
                'event_id' => $request->event_id,
                'date' => $request->agenda[0]['date'],
                'date_name' => $request->agenda[0]['date_name'],
                'is_active' => $request->agenda[0]['is_active'],
            ]);

           // Update the agenda details
           $updatedDetailIds = [];
           foreach ($request->agenda[0]['details'] as $detail) {
               // Update or create the detail
               $existingDetail = $agenda->agendaDetails()->where('time', $detail['time'])->first();
               if ($existingDetail) {
                   $existingDetail->update([
                       'title' => $detail['title'],
                       'description' => $detail['description'],
                   ]);
                   $updatedDetailIds[] = $existingDetail->id;
               } else {
                   $newDetail = $agenda->agendaDetails()->create([
                       'time' => $detail['time'],
                       'title' => $detail['title'],
                       'description' => $detail['description'],
                   ]);
                   $updatedDetailIds[] = $newDetail->id;
               }
           }

           // Delete existing agenda details that are not present in the updated request
           $agenda->agendaDetails()->whereNotIn('id', $updatedDetailIds)->delete();

            // Redirect back with success message
            return redirect()->Route('useradmin.agenda.view')->with('success', 'Agenda updated successfully');
        }catch(Exception $e){
            // Redirect back with error message
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the delete agenda form
     *
     * @param Agenda $agenda
     * @return \Illuminate\Http\Response
     */
    public function delete_agenda_view(Agenda $agenda)
    {
        return view('Admin_events.agendas.delete', compact('agenda'));
    }

    /**
     * Delete an agenda and its associated details.
     *
     * @param Agenda $agenda
     * @return \Illuminate\Http\Response
     */
    public function delete_agenda(Agenda $agenda)
    {
        // Delete all the associated details of the agenda
        $agenda->agendaDetails()->delete();

        // Check if the agenda is deleted successfully
        if($agenda->delete())
        {
            return redirect()->Route('useradmin.agenda.view')->with('success', 'Agenda deleted successfully');
        }
        else{
           return redirect()->Route('useradmin.agenda.view')->with('error', 'Agenda not deleted');
        }
    }


    public function generate_AgendaPDF(AdminEvent $event)
    {
        // Fetch the event with its agendas and agenda details
        $event = AdminEvent::where('eid', $event->eid)
            ->with(['agendas.agendaDetails']) // Ensure relationships are eager-loaded
            ->first();

        // Check if the event exists
        if (!$event) {
            return redirect()->back()->with('error', 'Event not found');
        }

        // Load the view into PDF
        $pdf = Pdf::loadView('PDF.agenda', compact('event'));

        // Return the PDF download
       return $pdf->download($event->event_name . '_Agenda.pdf');
    }

}
