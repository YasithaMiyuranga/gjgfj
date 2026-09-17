<?php

namespace App\Http\Controllers\events;

use App\Http\Controllers\Controller;
use App\Models\AdminEvent;
use App\Models\SoldOutSeats;
use App\Models\Ticket;
use App\Models\TicketOrderList;
use App\Models\TicketOwner;
use App\Models\UserTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Log;
use Vinkla\Hashids\Facades\Hashids;


class TicketController extends Controller
{

    /**
     * Display a listing of the event tickets.
     *
     * @return \Illuminate\Http\Response
     */
    public function events_ticket_list()
    {
        // Retrieve all events
        $events = AdminEvent::all();

        // Retrieve all tickets
        $tickets = Ticket::all();

        // Pass the tickets and events to the view
        return view('Admin_events.events_tickets.index', compact('tickets', 'events'));
    }

    /**
     * Display the create event ticket view.
     *
     * @return \Illuminate\Http\Response
     * Retrieves all events and passes them to the create ticket view.
     */
    public function events_ticket_create()
    {
        // Retrieve all events
        $events = AdminEvent::all();

        // Select event null
        $selectedEvent = null;

        // Pass the events to the view
        return view('Admin_events.events_tickets.add', compact('events', 'selectedEvent'));
    }
    public function ticket_create($eid)
    {

        // Retrieve event details
        $selectedEvent = AdminEvent::where('eid', '=', $eid)->first();
        // Check that events has tickets
        $existingTickets = Ticket::where('eid', '=', $eid)->get();

        // Retrieve all events
        $events = AdminEvent::all();

        // Check if the event exists
        if (!$selectedEvent) {
            return redirect()->route('useradmin.events.ticket.list')->with('error', 'Event not found!');
        }

        // Pass the events to the view
        return view('Admin_events.events_tickets.add', compact('selectedEvent', 'events', 'existingTickets'));
    }


    public function ticket_summary($eid)
    {
        $event = AdminEvent::where('eid', $eid)->first();
        $ticketOwners = TicketOwner::where('event_id', $eid)->get();

        foreach ($ticketOwners as $owner) {
            $tickets = [];

            $ticketOrderList = TicketOrderList::where('owner_id', $owner->oid)->get();

            foreach ($ticketOrderList as $ticketorder) {
                $userTickets = UserTicket::where('ticket_order_list_id', $ticketorder->id)->get();

                foreach ($userTickets as $userTicket) {
                    $ticket = Ticket::find($userTicket->ticket_id);

                    if ($ticket) {
                        $tickets[] = [
                            'name' => $ticket->tickets_category,
                            'qr_code' => asset('storage/' . $userTicket->qr_code),
                            'bar_code' => asset('storage/' . $userTicket->bar_code),
                            'ticket_status' => $userTicket->ticket_status,
                            'buy_date' => $userTicket->buy_date,
                        ];
                    }
                }
            }

            // Attach JSON directly to the model instance
            $owner->tickets_json = json_encode($tickets);
        }

        return view('Admin_events.events_tickets.ticket_summary', compact('event', 'ticketOwners'));
    }


    //seat booking
    public function seat_summery($eid)
    {
        $event = AdminEvent::where('eid', $eid)->first();
        $tickets = Ticket::where('eid', $eid)->get();

        foreach ($tickets as $ticket) {
            $soldOutSeats = SoldOutSeats::where('ticket_id', $ticket->id)->pluck('seat_number')->toArray();
            $ticket->sold_out_seats = $soldOutSeats; // Dynamically attach it
        }

        return view('Admin_events.events_tickets.seat_summary', compact('tickets', 'event'));
    }



    public function qr($eid)
    {


        $query = UserTicket::
            with('ticket')->
            where('event_id', $eid);

        if (request()->has('search') && request('search') !== '') {
            $search = request('search');
            $query->where(function ($q) use ($search) {
                $q->where('seat_number', 'LIKE', "%$search%")
                    ->orWhere('user_name', 'LIKE', "%$search%")
                    ->orWhere('user_phone_number', 'LIKE', "%$search%");
            });
        }


        $user_tickets = $query->orderBy('created_at', 'desc')->paginate(10);





        if (request()->ajax()) {
            return view('Admin_events.events_tickets.qr', compact('user_tickets'))->render();
        }

        return view('Admin_events.events_tickets.qr', compact('user_tickets'));
    }


    /**
     * Store a newly created ticket in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     *
     * Validates the incoming request data and checks if the ticket details arrays match in length.
     * If validation fails, returns errors in JSON format for AJAX requests.
     * If the arrays do not match in length, rolls back the transaction and returns an error message.
     * If any error occurs during the saving process, rolls back the transaction and returns an error message.
     * If all ticket entries are saved successfully, commits the transaction and returns a success message.
     */
    public function events_ticket_store(Request $request)
    {
        DB::beginTransaction();

        try {
            // Validate the incoming request data
            $validator = Validator::make($request->all(), [
                'event_id' => 'required|string|exists:events,eid',
                'currency' => 'required|string|max:100',
                'ticket_name' => 'required|array|max:100',
                'price' => 'required|array',
                'no_of_tickets' => 'required|array',
            ]);

            // Check if validation fails
            if ($validator->fails()) {
                if ($request->ajax()) {
                    // Return errors in JSON format for AJAX requests
                    return response()->json([
                        'errors' => $validator->errors()
                    ], 422);
                }
            }

            //Extract array from the request
            $ticketNames = $request->ticket_name;
            $ticketPrices = $request->price;
            $initialTicketCount = $request->no_of_tickets;
            $NoOfTickets = $initialTicketCount;

            // Existing added ticket check and delete
            if (isset($request->ticket_id)) {
                $commingTicketsId = $request->ticket_id;
                $existTicketsId = Ticket::where('eid', '=', $request->event_id)
                    ->whereNotIn('id', $commingTicketsId)
                    ->pluck('id')
                    ->toArray();

                Ticket::whereIn('id', $existTicketsId)->delete();
            }

            // Ensure all arrays have the same length
            if (count($ticketNames) === count($ticketPrices) && count($ticketPrices) === count($NoOfTickets)) {

                // Loop through each item and create a new ticket entry
                for ($i = 0; $i < count($ticketNames); $i++) {
                    $ticket = Ticket::updateOrInsert(
                        ['eid' => $request->event_id, 'tickets_category' => $ticketNames[$i]],
                        [
                            'currency' => $request->currency,
                            'price' => $ticketPrices[$i],
                            'number_of_tickets' => $NoOfTickets[$i],
                            'initial_tickets_count' => $initialTicketCount[$i],
                        ]
                    );
                }

                // Commit the transaction if all ticket entries are saved successfully
                DB::commit();

                if ($request->ajax()) {
                    return response()->json(['message' => 'Tickets Added Successfully'], 200);
                }
            } else {
                // Rollback the transaction if the ticket details arrays do not match in length
                DB::rollback();

                if ($request->ajax()) {
                    return response()->json(['error' => 'The ticket details arrays do not match in length'], 500);
                }
            }
        } catch (\Exception $e) {
            // Rollback the transaction if any error occurs during the saving process
            DB::rollback();

            if ($request->ajax()) {
                return response()->json(['error' => 'An error occurred while saving the tickets'], 500);
            }
        }
    }

    /**
     * Edit a specific event ticket.
     *
     * @param int $id The ID of the ticket to be edited.
     * @return \Illuminate\View\View The view for editing the ticket.
     */
    public function events_ticket_edit($id)
    {
        // Retrieve the ticket details to be edited
        $ticketDetails = Ticket::where('id', '=', $id)->first();
        // Retrieve the event details of the ticket
        $event = AdminEvent::where('eid', '=', $ticketDetails->eid)->first();

        // Pass the ticket and event details to the edit view
        return view('Admin_events.events_tickets.edit', compact('ticketDetails', 'event'));
    }

    /**
     * Update a specific event ticket in the database.
     *
     * @param \Illuminate\Http\Request $request The request object containing ticket update data.
     * @param int $id The ID of the ticket to be updated.
     * @return \Illuminate\Http\JsonResponse A JSON response indicating success or failure of the operation.
     *
     * Validates the incoming request data and checks for the existence of the ticket.
     * If validation fails, returns errors in JSON format for AJAX requests.
     * If the ticket is not found, returns an error message.
     * Updates the ticket details and commits the transaction if successful.
     * Rolls back the transaction and returns an error message if any exception occurs.
     */
    public function events_ticket_update(Request $request, $id)
    {
        // Start a database transaction
        DB::beginTransaction();

        try {
            // Validate the incoming request data
            $validator = Validator::make($request->all(), [
                'event_id' => 'required|string|exists:events,eid',
                'currency' => 'required|string|max:100',
                'ticket_name' => 'required|string|max:100',
                'price' => 'required',
                'no_of_tickets' => 'required',
            ]);

            // Check if validation fails
            if ($validator->fails()) {
                if ($request->ajax()) {
                    // Return errors in JSON format for AJAX requests
                    return response()->json([
                        'errors' => $validator->errors()
                    ], 422);
                }
            }

            // Retrieve the Ticket record from the database
            $ticket = Ticket::where('id', '=', $id)->first();

            if (!$ticket) {
                return response()->json(['error' => 'Ticket not found'], 422);
            }

            $data = [
                'currency' => $request->currency,
                'tickets_category' => $request->ticket_name,
                'price' => $request->price,
                'eid' => $request->event_id,
            ];

            $ticket->update($data);

            // If new number of tickets > initial count, update ticket counts
            if ($request->no_of_tickets > $ticket->initial_tickets_count) {
                $ticket->update([
                    'initial_tickets_count' => $request->no_of_tickets,
                    'number_of_tickets' => $request->no_of_tickets - $ticket->baught_tickets_count,
                ]);
            }

            if ($request->no_of_tickets < $ticket->initial_tickets_count) {
                if ($request->no_of_tickets < $ticket->baught_tickets_count) {
                    return response()->json(['error' => 'Number of tickets cannot be less than Sold Tickets'], 422);
                } else {
                    $ticket->update([
                        'initial_tickets_count' => $request->no_of_tickets,
                        'number_of_tickets' => $request->no_of_tickets - $ticket->baught_tickets_count,
                    ]);
                }
            }




            // Commit the transaction if all ticket entries are saved successfully
            DB::commit();

            if ($request->ajax()) {
                return response()->json(['message' => 'Ticket Updated Successfully'], 200);
            }
        } catch (\Exception $e) {
            // Rollback the transaction if any error occurs during the saving process
            DB::rollback();

            if ($request->ajax()) {
                return response()->json(['error' => 'An error occurred while saving the tickets'], 500);
            }
        }
    }

    /**
     * Display the delete confirmation view for a specific event ticket.
     *
     * @param int $id The ID of the ticket to be deleted.
     * @return \Illuminate\View\View The view for confirming ticket deletion.
     */
    public function events_ticket_delete_view($id)
    {
        if (!Ticket::where('id', '=', $id)->exists()) {
            return redirect()->route('useradmin.events.ticket.list')->with('error', 'Event Ticket not found!');
        }
        // Pass the ticket ID to the delete view
        return view('Admin_events.events_tickets.delete', compact('id'));
    }

    /**
     * Delete a specific event ticket.
     *
     * @param int $id The ID of the ticket to be deleted.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function events_ticket_delete($id)
    {
        // Check if the ticket exists
        if (!Ticket::where('id', '=', $id)->exists()) {
            return redirect()->route('useradmin.events.ticket.list')->with('error', 'Event Ticket not found!');
        }

        // Delete the ticket
        $ticket = Ticket::where('id', '=', $id)->delete();

        // Redirect with a success message
        return redirect()->route('useradmin.events.ticket.list')->with('success', 'Event Ticket deleted successfully!');
    }

    //Generate report of ticket
    public function report_generate()
    {
        return view('Admin_events.events_tickets.report_generate');
    }

    //Create generate report form
    public function report_form()
    {
        // Retrieve all events
        $events = AdminEvent::all();

        // Retrieve distinct ticket categories
        $ticketCategories = Ticket::select('tickets_category')->distinct()->pluck('tickets_category');

        $tickets = Ticket::all();

        // Select event null
        $selectedEvent = null;

        // Pass the events to the view
        return view('Admin_events.events_tickets.report_generate', compact('events', 'ticketCategories', 'selectedEvent', 'tickets'));
    }

    //Get report of sales tickets
    public function getReport(Request $request)
    {
        // Get input values from the request
        $eventId = $request->input('eid');
        $category = $request->input('tickets_category');

        // Initialize the query to fetch tickets based on event ID
        $query = Ticket::where('eid', $eventId);

        // If a category is provided, add a condition to filter by tickets category
        if ($category) {
            $query->where('tickets_category', $category);
        }

        // Execute the query and transform the results
        $tickets = $query->get()->map(function ($ticket) {
            return [
                'eid' => $ticket->eid,
                'event_name' => $ticket->event->event_name,
                'tickets_category' => $ticket->tickets_category,
                'price' => $ticket->price,
                'totalTickets' => $ticket->initial_tickets_count,
                'soldTickets' => $ticket->baught_tickets_count,
                'remainingTickets' => $ticket->number_of_tickets
            ];
        });
        // Return the results as a JSON response
        return response()->json($tickets);
    }

    //Download report of ticket
    public function report(Request $request)
    {
        $eventId = $request->input('eid');

        // Fetch ticket data logic here...
        $tickets = Ticket::where('eid', $eventId);

        $reportData = $tickets->get(); // Or format it as needed
        $event = AdminEvent::find($eventId);
        $reportDate = Carbon::now()->format('d/m/Y H:i');

        return view('Admin_events.events_tickets.report', [
            'reportData' => $reportData,
            'event' => $event,
            'reportDate' => $reportDate
        ]);
    }
    public function totalreport(Request $request)
    {
        $events = AdminEvent::all();
        $tickets = Ticket::all();

        $reportDate = Carbon::now()->format('d/m/Y H:i');

        return view('Admin_events.events_tickets.total_report', compact('events', 'tickets', 'reportDate'));
    }

    public function profit_report()
    {
        $events = AdminEvent::all();
        $tickets = Ticket::all();

        if (!count($events) > 0) {
            return back()->with('error', 'No Events Found!');
        }

        // Calculate Total Earnings
        foreach ($events as $event) {
            // Check event has margin
            // Get  tickets details
            $tickets = Ticket::where('eid', '=', $event->eid)->get();
            $event->tickets = $tickets;

        }
        $reportDate = Carbon::now()->format('d/m/Y H:i');
        return view('Admin_events.events_tickets.profit_report', compact('events', 'reportDate', 'tickets'));
    }


}
