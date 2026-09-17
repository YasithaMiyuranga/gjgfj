<?php

namespace App\Http\Controllers;

use App\Models\Order;
use  App\Models\Employe;
use App\Models\Customer;
use App\Models\EventDate;
use App\Models\JobAmount;
use App\Models\OrderBook;
use App\Models\OrderItem;
use App\Models\AdminEvent;
use App\Models\CreditOrder;
use App\Models\Payment_log;
use Illuminate\Http\Request;
use App\Models\AdditionalExpense;
use Illuminate\Support\Facades\DB;
use App\Http\Helper\CashFlowHelper;
use App\Http\Requests\EventUpdateRequest;
use App\Models\Manager;
use App\Models\Agenda;
use App\Models\AgentEvent;
use App\Models\Agreement;
use App\Models\EventCouponList;
use App\Models\Ticket;
use App\Models\Transaction;
use App\Models\UserTicket;
use App\Models\SoldOutSeats;
use App\Models\TicketOrderList;
use App\Models\TeamCategory;
use App\Models\Team;
use App\Models\EventCustomerCare;
use App\Models\AgreementTerm;
use App\Models\AgreementSubTerm;

class EventsController extends Controller
{
    /**
     * Display a listing of all events.
     *
     * @return \Illuminate\View\View The view displaying the list of events.
     */
    public function viewEvents()
    {   // Get all events
        $events = AdminEvent::orderby('eid', 'desc')->get();
        // Get all active customers
        $customers = Customer::where('status', 'active')->get();
        return view('Events.index', compact('events', 'customers'));
    }

    /**
     * Show the form for creating a new event.
     *
     * @return \Illuminate\View\View The view to create a new event.
     */
    public function addEventForm()
    {
        // Get all active customers
        $customers = Customer::where('status', 'active')->get();
        return view('Events.create', compact('customers'));
    }

    /**
     * Store a newly created event in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeEvent(Request $request)
    {
        $validatedData = $request->validate([
            'customer_id' => 'required|exists:customer,customer_id',
            'event_name' => 'required|string|max:255',
            'start_datetime' => 'nullable|date',
            'setup_time' => 'required|date',
            'event_date' => 'required|date',
            'end_datetime' => 'required|date|after:start_datetime',
            'location' => 'required|string|max:255',
            'status' => 'required|string|in:pending,completed,booking,canceled,credit',
        ]);

        DB::BeginTransaction();
        try {
            // Create a new event
            $event = AdminEvent::create($validatedData);
            //  Get time slots
            $timeSlots = json_decode($request->input('time_slot'), true);
            if($timeSlots){
                // Create time slots for the event
                foreach ($timeSlots as $timeSlot) {
                    EventDate::create([
                        'event_id' => $event->eid,
                        'date' => $timeSlot['date'],
                        'start_time' => $timeSlot['start_time'],
                        'end_time' => $timeSlot['end_time'],
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('useradmin.events.view')->with('success', 'Event added successfully!');
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->route('useradmin.events.view')->with('error', 'Event added failed!'. $e->getMessage());
        }
    }


    /**
     * Display the specified event.
     *
     * @param  \App\Models\AdminEvent  $event
     * @return \Illuminate\Http\Response
     */
    public function editEvent(AdminEvent $event)
    {
        // Find Customer name in customer table
        $customer = Customer::where('customer_id', $event->customer_id)->first();
        $customerName = $customer ? $customer->customer_name : '';
        // Get Date Events in EventDate table
        $eventDates = EventDate::where('event_id', $event->eid)->get();

        // Get all active customers
        $customers = Customer::where('status', 'open')->orWhere('status', 'active')->get();



        return view('Events.edit', compact('event', 'customerName', 'customers', 'eventDates'));
    }


    /**
     * Update an existing event in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AdminEvent  $event
     * @return \Illuminate\Http\Response
     */
    public function updateEvent(Request $request, AdminEvent $event)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'customer_id' => 'required|exists:customer,customer_id',
            'event_name' => 'required|string|max:255',
            'start_datetime' => 'required|date',
            'setup_time' => 'nullable|date',
            'event_date' => 'required|date',
            'end_datetime' => 'required|date|after:start_datetime',
            'location' => 'required|string|max:255',
            'status' => 'required|string|in:pending,completed,booking,canceled,credit',
        ]);

        // Prepare the data to be updated
        $data = [
            'customer_id' => $validatedData['customer_id'],
            'event_name' => $validatedData['event_name'],
            'start_datetime' => $validatedData['start_datetime'],
            'event_date' => $validatedData['event_date'],
            'setup_time' => $validatedData['setup_time'],
            'end_datetime' => $validatedData['end_datetime'],
            'location' => $validatedData['location'],
            'status' => $validatedData['status'],
        ];

        // Start a transaction
        DB::BeginTransaction();

        try {

            // Update the event
            $event->update($data);

            // Delete existing time slots
            EventDate::where('event_id', $event->eid)->delete();

            // Get time slots
            $timeSlots = json_decode($request->input('time_slot'), true);
            if($timeSlots){
                // Create time slots for the event
                foreach ($timeSlots as $timeSlot) {
                    EventDate::create([
                        'event_id' => $event->eid,
                        'date' => $timeSlot['date'],
                        'start_time' => $timeSlot['start_time'],
                        'end_time' => $timeSlot['end_time'],
                    ]);

                }
            }

            // Commit the transaction
            DB::commit();

            // Redirect back to the view page with a success message
            return redirect()->route('useradmin.events.view')->with('success', 'Event updated successfully!');

        } catch (\Throwable $e) {

            // Roll back the transaction
            DB::rollBack();

            // Redirect back to the view page with an error message
            return redirect()->route('useradmin.events.view')->with('error', 'Event updated failed!'. $e->getMessage());

        }


    }

    /**
     * Delete an existing event in the database.
     *
     * @param  \App\Models\AdminEvent  $event
     * @return \Illuminate\Http\Response
     */
    public function deleteEvent(AdminEvent $event)
    {
        DB::beginTransaction();

        try {
            $event->delete();

            // Commit the transaction
            DB::commit();

            // Redirect back to the view page with a success message
            return redirect()->route('useradmin.events.view')->with('success', 'Event deleted successfully!');

        } catch (\Throwable $e) {
            // Roll back the transaction
            DB::rollBack();

            // Redirect back to the view page with an error message
            return redirect()->route('useradmin.events.view')->with('error', 'Event Cannot be deleted!');
        }
    }

    public function event_salary_view(){
        // Get events status without cancelled and deleted
        $events = AdminEvent::where('status', '!=', 'canceled')->where('status', '!=', 'deleted')->orderby('eid', 'desc')->get();
        return view('employee.event_base_salary_view' , ['events' => $events], ['downloadable' => true]);

    }
    public function getEventBaseSalaryData($eventId)
    {
        $data = Employe::join('job_amount', 'employes.emp_id', '=', 'job_amount.emp_id')
        ->where('job_amount.event_id', $eventId)
        ->groupBy('employes.emp_id')
        ->get([
            'employes.emp_id',
            'employes.name',
            'employes.emp_type',
            DB::raw('SUM(job_amount.job_amount) as total_job_amount')
        ]);

        return response()->json(['data' => $data]);
    }
}
