<?php

namespace App\Http\Controllers;


use Carbon\Carbon;
use App\Models\User;
use App\Models\Agent;
use App\Models\Order;
use App\Models\Ticket;
use App\Models\Artists;
use App\Models\Manager;
use App\Models\Sponsor;
use App\Models\Category;
use App\Models\JobAmount;
use App\Models\OrderBook;
use App\Models\OrderItem;
use App\Models\AdminEvent;
use App\Http\Helper\Helper;
use App\Models\CreditOrder;
use App\Models\Payment_log;
use App\Models\Transaction;
use App\Models\TaskTemplate;
use Illuminate\Http\Request;
use App\Models\AdditionalExpense;
use App\Models\EventCustomerCare;
use Illuminate\Support\Facades\DB;
use App\Http\Helper\CashFlowHelper;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\Agenda;
use App\Models\AgentEvent;
use App\Models\Agreement;
use App\Models\EventCouponList;
use App\Models\EventDate;
use App\Models\TicketOrderList;
use App\Models\UserTicket;
use App\Models\SoldOutSeats;
use App\Models\TeamCategory;
use App\Models\Team;
use App\Models\AgreementTerm;
use App\Models\AgreementSubTerm;

class AdminEventController extends Controller
{
    function index()
    {
        //  Get Active Events
        $events=AdminEvent::orderBy('eid','desc')->get();
        //  Get Active Total Users
        $activeUsersCount=User::count();
        //  Total Agents
        $totalAgents = Agent::count();
        //  Get Total Artists
        $totalArtists = Artists::count();

        $tickets = Ticket::all();

        return view('Admin_events.dashboard',compact('events','tickets','activeUsersCount','totalAgents','totalArtists'));
    }

    //*** FUNCTION TO CREATE NEW EVENTS */
    public function event_create()
    {
        // Get all categories
        $categoryNames=Category::all();

        // Get all active sponsors
        $sponsors=Sponsor::where('status','active')->get();
        $managers=Manager::where('status','active')->get();
        // Get all artists
        $artists=Artists::all();
       return view('Admin_events.events.add', compact('categoryNames','artists','sponsors','managers'));
    }
    //** FUNCTION TO STORE NEW EVENTS */
   public function store(Request $request)
   {

        $validatedData=$request->validate([
            'event_name' => 'required|string|max:100|unique:events,event_name',
            'phone_no' =>'required|string|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'whatsapp_no' => 'nullable|string|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'task_template_id' => 'nullable|exists:task_templates,id',
            'address' => 'nullable|string',
            'email'=> 'nullable|email',
            'location'  => 'required|string|max:100',
            'margin' => 'nullable|numeric',
            'event_manager_id'=>'required|exists:managers,manager_id',
            'eventdate' => 'required|date',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'event_type'  => 'required|string',
            'category'  => 'required|string',
            'state' => 'required|string|max:20|in:Ongoing,Completed',
            'is_public' => 'required|string|max:20|in:1,0',
            'description' => 'required|string|max:200',
            'Logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg,jfif|max:2048',
            'banner' => 'required|image|mimes:jpeg,png,jpg,gif,svg,jfif|max:2048',
            'details_docs' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,jfif,pdf,docx,doc|max:2048',
            'artistname' => 'nullable|array',
            'artistname.*' => 'exists:artist,artist_name',
            'sponsor' => 'nullable|array',
            'sponsor.*' => 'exists:sponsors,sponsor_id',

        ]);

     DB::beginTransaction();
     try{
        // LOGO fillname
        $fileNameLogo = rand(10, 100) . '_' . time() . "_" . $request->Logo->getClientOriginalName();
        $pathLogo = Helper::getFileUrl($request->Logo, 'uploads/events/logo/');

        // Banner fillname
        $fileNameBanner = rand(10, 100) . '_' . time() . "_" . $request->banner->getClientOriginalName();
        $pathBanner = Helper::getFileBannerUrl($request->banner, 'uploads/events/banner/');

        // Details docs fillname
        $detailsDocsPath = null;
        if ($request->hasFile('details_docs')) {
            $detailsDocs = $request->file('details_docs');
            $detailsDocsName = rand(10, 100) . '_' . time() . "_" . $detailsDocs->getClientOriginalName();
            $detailsDocsPath = $detailsDocs->storeAs('uploads/events/details_docs', $detailsDocsName, 'public');
        }

        $event=new AdminEvent();



        $event->event_name= $request->event_name;
        $event->contact_no=$request->phone_no;
        $event->location=$request->location;
        $event->event_manager_id=$request->event_manager_id;
        $event->task_template_id=$request->task_template_id;
        $event->margin=$request->margin;
        $event->event_date=$request->eventdate;
        $event->start_datetime=$request->start_time;
        $event->end_datetime=$request->end_time;
        $event->type=$request->event_type;
        $event->category_id=$request->category;
        $event->status=$request->state;
        $event->is_public=$request->is_public;
        $event->des=$request->description;
        $event->logo=$pathLogo;
        $event->banner=$pathBanner;
        $event->details_docs = $detailsDocsPath;





        if($event->save())
        {
            // Attach the selected sponsorsId and event_id to the event_sponsors table
            $event->sponsors()->attach($request->sponsor);
            if ($request->has('artistname')) {
                // Attach the selected artists to the event
                $artistIds = Artists::whereIn('artist_name', $request->input('artistname'))->pluck('aid');
                $event->artists()->attach($artistIds);
            }
             // If request has whatsapp_no,address or email
             if($request->has('whatsapp_no') || $request->has('address') || $request->has('email')){
                $customerCare = new EventCustomerCare();
                $customerCare->event_id = $event->eid;
                $customerCare->whatsapp_number = isset($request->whatsapp_no) ? $request->whatsapp_no : null;
                $customerCare->address = isset($request->address) ? $request->address : null;
                $customerCare->email = isset($request->email) ? $request->email : null;
                $customerCare->save();
             }
            // Commit the transaction
            DB::commit();
            return redirect()->route('useradmin.events.events_list')->with('success', 'Event added successfully.');

        }

     }catch(\Exception $e){
        DB::rollBack();
        Log::info($e->getMessage());

        return redirect()->back()->with('error', 'An error occurred while adding the event.'.$e->getMessage());
     }

    }

    //**FUNCTION TO VIEW EVENTS LIST */
    public function events_list()
    {
        // Retrieve all events with their associated artists
        $events = AdminEvent::with('artists','sponsors','manager')->orderBy('eid', 'desc')->get();
         // Calculate Total Earnings
         foreach($events as $event){
            // Check event has margin
            if( isset($event->margin)){
                 // Get  tickets details
                 $tickets = Ticket::where('eid','=',$event->eid)->get();
                 $totalCurrentProfit = 0;
                 $totalProfit = 0;
                 foreach($tickets as $ticket){
                     $totalCurrentProfit = $totalCurrentProfit+($ticket->price * $ticket->baught_tickets_count);
                     $totalProfit = $totalProfit+($ticket->price * $ticket->initial_tickets_count);
                 }
                 // Our current Profit
                 $event->ourCurrentCommission = ($totalCurrentProfit * $event->margin ) /100;
                 // Our Total Profit
                 $event->ourTotalCommission = ($totalProfit * $event->margin ) /100;

            }else{
                 $event->ourCurrentCommission = 0;
                 $event->ourTotalCommission = 0;

            }
         }
        return view('Admin_events.events.list', ['events' => $events], ['downloadable' => true]);
    }

    //** Method to download the PDF */
   public function downloadPdf($eid)
   {
       // Fetch the event details based on $eid
       $event = AdminEvent::findOrFail($eid);

       // Get the file path from the event details
       $filePath = $event->details_docs;

       // Check if the file exists
       if (!Storage::disk('public')->exists($filePath)) {
           return response()->json(['error' => 'File not found'], 404);
       }

        // Return the file as a download response
        $fileName = $event->event_name . '.' . pathinfo($filePath, PATHINFO_EXTENSION);
        return Storage::disk('public')->download($filePath, $fileName, [
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ]);
   }

    //** FUNCTION TO EDIT SPECIFIC EVENT */
    public function edit_event($eid)
    {
        // Get all categories
        $categoryNames=Category::all();
        // Get event associate artists and sponsors
        $event = AdminEvent::with('artists','sponsors')->find($eid);
        // Get all artists
        $artists = Artists::all();
        // Get all active sponsors
        $sponsors = Sponsor::all();
        // Retrieve task templates based on the selected category
        $taskTemplates = TaskTemplate::where('category_id', $event->category_id)->get();

        //Get all active managers
        $managers=Manager::where('status','active')->get();
        // Get that event customer care details
        $customerCare = EventCustomerCare::where('event_id', $eid)->first();


        return view('Admin_events.events.edit', compact('event','categoryNames','artists','sponsors','managers', 'customerCare','taskTemplates'));
    }

    //*** FUNCTION TO UPDATE A SPECIFIC EVENT */
    public function update_event(Request $request,$eid)
    {
        //  Validate the form data
        $request->validate([
            'event_name' => 'required|string|max:100|unique:events,event_name,'.$eid.',eid',
            'phone_no' =>'required|string|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'whatsapp_no' => 'nullable|string|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'task_template_id' => 'nullable|exists:task_templates,id',
            'address' => 'nullable|string|max:255',
            'email'=> 'nullable|email|regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
            'margin' => 'nullable|numeric',
            'location'  => 'required|string|max:100',
            'event_manager_id'  => 'required|exists:managers,manager_id',
            'event_date' => 'required|date',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'event_type'  => 'required|string',
            'category'  => 'required|string',
            'status' => 'required|string|max:20|in:Ongoing,Completed',
            'is_public' => 'required|string|max:20|in:1,0',
            'description' => 'required|string|max:200',
            'Logo' => 'image|mimes:jpeg,png,jpg,gif,svg,jfif|max:2048',
            'banner' => 'image|mimes:jpeg,png,jpg,gif,svg,jfif|max:2048',
            'details_docs' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,jfif,pdf,docx,doc|max:2048',

        ]);
        DB::beginTransaction();
        try {

        // Get this event details
        $event =AdminEvent::where('eid','=',$eid)->first();

        // Handle image upload if a new logo is provided
        if ($request->hasFile('Logo')) {
            // Check logo included in logo column
            if($event->logo){

                $image_path_logo = public_path($event->logo);
                //  Check include exist  logo
                if (file_exists($image_path_logo)) {

                    //  Remove exist logo
                    unlink($image_path_logo);
                }

            }
            $imageLogo = $request->file('Logo');
            $name = time() . '.' . $imageLogo->getClientOriginalExtension();
            $pathLogo = Helper::getFileUrl($request->Logo, 'uploads/events/logo/');
            $event->logo = $pathLogo ;
        }

        // Handle image upload if a new banner is provided
        if ($request->hasFile('banner')) {
            //  Check banner included in banner column
            if($event->banner){

                $image_path_banner = public_path($event->banner);
                // Check include exist  banner
                if (file_exists($image_path_banner)) {

                    // Remove exist banner
                    unlink($image_path_banner);
                }

            }
            // Create the new banner path
            $imageBanner = $request->file('banner');
            $nameLogo = time() . '.' . $imageBanner->getClientOriginalExtension();
            $pathBanner = Helper::getFileBannerUrl($request->banner, 'uploads/events/banner/');
            $event->banner = $pathBanner ;
        }
        // Handle the details_docs upload
        if ($request->hasFile('details_docs')) {
            $detailsDocs = $request->file('details_docs');
            $detailsDocsName = rand(10, 100) . '_' . time() . "_" . $detailsDocs->getClientOriginalName();
            $detailsDocsPath = $detailsDocs->storeAs('uploads/events/details_docs', $detailsDocsName, 'public');
            $event->details_docs = $detailsDocsPath;
        }

        // Update the artist record with the validated data
        $event->event_name = $request->event_name;
        $event->contact_no = $request->phone_no;
        $event->location = $request->location;
        $event->event_manager_id = $request->event_manager_id;
        $event->task_template_id=$request->task_template_id;
        $event->margin = $request->margin;
        $event->event_date = $request->event_date;
        $event->start_datetime = $request->start_time;
        $event->end_datetime = $request->end_time;
        $event->is_public = $request->is_public;
        $event->type = $request->event_type;
        $event->category_id = $request->category;
        $event->status = $request->status;
        $event->des = $request->description;

        // Save the event
        if ($event->save()) {
            if ($request->has('artistname')) {
                // Attach the selected artists to the event
                $artistIds = Artists::whereIn('artist_name', $request->input('artistname'))->pluck('aid');
                $event->artists()->sync($artistIds);
            }

            // Attach the selected sponsors to the event
            $event->sponsors()->sync($request->input('sponsor'));

        }

        // Check if the update was successful
        if ($event) {
            // If request has whatsapp_no,address or email
            if($request->has('whatsapp_no') || $request->has('address') || $request->has('email')){
                $existCustomerCare = EventCustomerCare::where('event_id','=',$event->eid)->first();
                if($existCustomerCare){
                    $existCustomerCare->whatsapp_number = isset($request->whatsapp_no) ? $request->whatsapp_no : null;
                    $existCustomerCare->address = isset($request->address) ? $request->address : null;
                    $existCustomerCare->email = isset($request->email) ? $request->email : null;
                    $existCustomerCare->save();
                }
                else{
                    $customerCare = new EventCustomerCare();
                    $customerCare->event_id = $event->eid;
                    $customerCare->whatsapp_number = isset($request->whatsapp_no) ? $request->whatsapp_no : null;
                    $customerCare->address = isset($request->address) ? $request->address : null;
                    $customerCare->email = isset($request->email) ? $request->email : null;
                    $customerCare->save();
                }

            }
            DB::commit();
            return redirect()->route('useradmin.events.events_list')->with('success', 'Event updated successfully.');
        }

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('useradmin.events.events_list')->with('error', $e->getMessage());
        }

    }
    public function delete_event_view($eid)
    {
        return view('Admin_events.events.delete', compact('eid'));
    }

    //** FUNCTION TO SPECIFIC EVENT DELETE */
    public function delete_event($eid)
    {

        DB::beginTransaction();

        try {
            // Find event details
            $data = AdminEvent::find($eid);

            if (!$data) {
                return redirect()->route('useradmin.events.events_list')->with('error', 'Event not found.');
            }

            // Handle logo and banner deletion
            if ($data->logo) {
                $logoPath = public_path($data->logo);
                if (file_exists($logoPath)) {
                    unlink($logoPath);
                }
            }

            if ($data->banner) {
                $bannerPath = public_path($data->banner);
                if (file_exists($bannerPath)) {
                    unlink($bannerPath);
                }
            }

            // Delete event record
            $data->delete();

            // Commit transaction
            DB::commit();

            return redirect()->route('useradmin.events.events_list')->with('success', 'Event deleted successfully!');

        } catch (\Exception $e) {
            // Rollback on error
            DB::rollback();

            return redirect()->route('useradmin.events.events_list')->with('error', 'Event Cannot be deleted!');
        }
    }

    // ** FUNCTION TO CHECK EVENT NAME */
    public function checkEventName(Request $request)
    {
        $nameExists = AdminEvent::where('event_name', $request->name)->exists();
        return response()->json(['exists' => $nameExists]);
    }


    //* USERS */

     public function user_list()
     {
        // GET ALL USERS
        $users=User::all();

        return view ('Admin_events.users.index',compact('users'));
     }

     public function edit_user($id)
     {
        //Get a specific user details
        $userDetails=User::find($id);

        return view ('Admin_events.users.edit',compact('userDetails'));
     }

     public function update_user_status(Request $request,$id)
     {
        $request->validate([
            'status' => 'required|string|max:255',
        ]);

         // Retrieve the artist record from the database
         $serDetails = User::where('id', '=', $id)->first();


        // Update the artist record with the validated data
        $serDetails->update([
            'status' => $request->status,
        ]);
         return redirect()->route('useradmin.events.user_list')->with('success', 'User Status Updated successfully!');
     }

   public function cashflowByEvent($eventId)
   {
        $orders = Order::where('event_id', $eventId)->get();
        $cashFlows = [];

        foreach ($orders as $order) {
           // Calculate cash flow for each order
           $transport = $order->transport;
           $advanced = $order->tax;

           $finalAmount = $order->final_amount;
           $payAmount = $order->pay_amount;

           $eventBudget = 0;
           ($finalAmount == 0) ? $eventBudget = $payAmount : $eventBudget = $finalAmount;

           // Get additional expenses
           $additionalExpenses = AdditionalExpense::where('order_id', $order->order_id)->get();

           $additionalExpensesTotal = 0;
           foreach ($additionalExpenses as $additionalExpense) {
               $additionalExpensesTotal += $additionalExpense->amount;
           }

           // Add Grand Total
           array_push($cashFlows, [
               'date' => $order->booking_date->format('Y-m-d'),
               'name' => 'Order - '. $order->order_id . ' Total Budget',
               'amount' => $eventBudget,
               'is_income' => 1,
               'is_expense' => 0,
               'type' => '',
           ]);

           // Add Transport
           array_push($cashFlows, [
               'date' => $order->booking_date->format('Y-m-d'),
               'name' => 'Order - '. $order->order_id . ' Transport',
               'amount' => $transport,
               'is_income' => 0,
               'is_expense' => 1,
               'type' => '',
           ]);

           // Jobs Amount
           $jobs = JobAmount::where('order_id', $order->order_id)->get();

           foreach ($jobs as $job) {
               array_push($cashFlows, [
                   'date' => $order->booking_date->format('Y-m-d'),
                   'name' => 'Order - '. $order->order_id . ' Job Amount - ' . $job->name,
                   'amount' => $job->job_amount,
                   'is_income' => 0,
                   'is_expense' => 1,
                   'type' => '',
               ]);
           }

           // Add Additional Expenses
           foreach ($additionalExpenses as $additionalExpense) {
               array_push($cashFlows, [
                   'date' => $additionalExpense->expense_date,
                   'name' => 'Order - '. $order->order_id . ' - ' . $additionalExpense->expense_name . ' - ' . $additionalExpense->description,
                   'amount' => $additionalExpense->amount,
                   'is_income' => 0,
                   'is_expense' => 1,
                   'type' => 'additional_expense',
                   'additional_expense_id' => $additionalExpense->id
               ]);
           }
        }

       //  Total Income
       $totalIncome = 0.00;
       $totalExpense = 0.00;

       foreach ($cashFlows as $cashFlow) {
           if ($cashFlow['is_income'] == 1) {
               $totalIncome += floatval($cashFlow['amount']);
           } elseif ($cashFlow['is_expense'] == 1) {
               $totalExpense += $cashFlow['amount'];
           }
       }

       $profitOrLoss = $totalIncome - $totalExpense;
       $title = 'Cash Flow For '. AdminEvent::find($eventId)->event_name . ' Event';

       return view('cash_flow.view_order_wise', compact('cashFlows', 'totalIncome', 'totalExpense', 'profitOrLoss', 'title'));
    }

    /**
     * Display a calendar view of all ongoing and completed events.
     *
     * Fetches all events that have not been cancelled or completed,
     * as well as events that have been completed, from the database.
     * Passes this data to the calendar view for rendering.
     *
     * @return \Illuminate\View\View
     */

    public function eventCalender()
    {
        // All events
        $events =  AdminEvent::whereNotIn('status', ['cancelled', 'completed'])->get();
        // Completed events
        $completedData = AdminEvent::whereIn('status', ['completed'])->get();
        return view('Admin_events.calendar.calendarview', compact('completedData', 'events'));
    }

    // Generate Users Report
    public function user_report()
    {
    // GET ALL USERS
    $users=User::all();
    $reportDate = Carbon::now()->format('d/m/Y H:i');

    return view ('Admin_events.users.report',compact('users', 'reportDate'));
    }

    // Update Event Status View
    public function updateEventStatusView($id)
    {
        // Get specific event
        $event = AdminEvent::where('eid','=',$id)->first();
        if(!$event){
            return redirect()->back()->with('error', 'Invalid event ID');
        }
        return view('Admin_events.events.statusChange', compact('event'));
    }

    // Update Event Status
    public function updateEventStatus(Request $request,$id)
    {
        $request->validate([
            'status' => 'required|string|max:255|in:pending,canceled,completed,booking,credit',
        ]);
        $event = AdminEvent::find($id);
        if( !$event){
            return response()->json(['message' => 'Event not found!'], 500);
        }
        $event->status = $request->input('status');
        if($event->save()){
            return response()->json(['message' => 'Event status updated successfully!'], 200);
        }
    }
}
