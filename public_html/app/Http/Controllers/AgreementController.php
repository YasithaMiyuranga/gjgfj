<?php

namespace App\Http\Controllers;
use App\Models\AdminEvent;
use App\Models\Employe;
use App\Models\Customer;
use App\Models\AgreementCustomersDetail;
use App\Models\AgreementTemplate;
use App\Models\Term;
use App\Models\SubTerm;
use App\Models\Agreement;
use App\Models\AgreementTerm;
use App\Models\AgreementSubTerm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Exists;
use Illuminate\Support\Facades\DB;

class AgreementController extends Controller
{
    /**
     * Returns the view for the agreement index page.
     *
     * @return \Illuminate\View\View
     */
    public function index_records_employees()
    {
        // Get all agreements
        $agreements = Agreement::with('template', 'agreementTerms', 'agreementSubTerms', 'template.agreementCategory')->where('emp_id', '!=', null)->get();
        // Get employee names
        foreach ($agreements as $agreement) {
            $agreement->employee_name = Employe::find($agreement->emp_id)->name;
        }
        return view('Agreement.agreemnetIndex', compact('agreements'));
    }

    /**
     * Show the form for creating a new agreement.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_agreement()
    {
        $employee_details = Employe::all();
        $agreementTemplates = AgreementTemplate::with(['agreementCategory', 'terms.subTerms'])->get();

        return view('Agreement.viewAgreement', ['employee_details' => $employee_details, 'agreementTemplates' => $agreementTemplates, 'downloadable' => true]);
    }

    /**
     * Stores the agreement in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_agreement(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'agreement_template_id' => 'required|exists:agreement_templates,id',
            'agreement_catagory' => 'required',
            'emp_id' => 'nullable|exists:employes,emp_id',
            'topics' => 'required|array',
        ],
        [
            'agreement_template_id.exists' => 'The selected agreement template is invalid.',
            'emp_id.exists' => 'The selected employee is invalid.',
            'agreement_catagory.required' => 'The agreement category is required.',
            'topics.required' => 'At least one topic must be provided.',
            'topics.array' => 'The topics must be an array.',
            'topics.*.title.required' => 'Each topic must have a title.',
            'topics.*.subtopics.*.subtitle.required' => 'Each subtopic must have a subtitle.',
            'topics.*.subtopics.*.description.required' => 'Each subtopic must have a description.'
        ]
    );

        if ($validatedData->fails()) {
            // If the validation fails, redirect back with the errors
            return redirect()->back()->withErrors($validatedData)->withInput();
        }

        DB::beginTransaction();
        try{
            // Get the validated data
            $validated = $validatedData->validated();

            // Create a new Agreement
            $agreement = new Agreement();
            $agreement->emp_id = $validated['emp_id'];
            $agreement->template_id = $validated['agreement_template_id'];
            $agreement->save();

            // Loop through the topics
            foreach ($validated['topics'] as $topic) {

                // Create a new AgreementTerm
                $agreementTerm = new AgreementTerm();
                $agreementTerm->agreement_id = $agreement->id;
                $agreementTerm->order_number = $topic['order'];
                $agreementTerm->title = $topic['title'];
                $agreementTerm->save();

                if (!empty($topic['subtopics']) && is_array($topic['subtopics'])) {
                    foreach ($topic['subtopics'] as $subtopic) {
                        if (empty(trim($subtopic['subtitle'])) && empty(trim($subtopic['description']))) {
                            continue;
                        }

                        $agreementSubTerm = new AgreementSubTerm();
                        $agreementSubTerm->agreement_id = $agreement->id;
                        $agreementSubTerm->agreement_term_id = $agreementTerm->id;
                        $agreementSubTerm->SubTerm_title = $subtopic['subtitle'];
                        $agreementSubTerm->SubTerm_description = $subtopic['description'];
                        $agreementSubTerm->save();
                    }
                }
            }

            DB::commit();
            // Redirect back with a success message
            return redirect()->route('useradmin.show_agreement_employee')->with('success', 'Agreement created successfully!');
        }catch (\Exception $e) {
            DB::rollBack();
            // Redirect back with an error message
            return redirect()->back()->with('error', 'An error occurred while creating the agreement: ' . $e->getMessage());
        }
    }
    /**
     * Show the form for editing the specified agreement.
     *
     * @param  \App\Models\Agreement  $agreement
     * @return \Illuminate\Http\Response
     */
    public function edit(Agreement $agreement) {
        $agreement = Agreement::with([
            'template',
            'agreementTerms' => function ($query) {
                $query->orderBy('order_number', 'asc'); // Sorting agreementTerms by order_id
            },
            'agreementSubTerms',
            'template.agreementCategory',
            'agreementTerms.agreementSubTerms'
        ])->find($agreement->id);

        // Fetch employee details
        $employee = Employe::find($agreement->emp_id);
        $employee_details = Employe::all();

        // Fetch templates
        $agreementTemplates = AgreementTemplate::with(['agreementCategory', 'terms.subTerms'])->get();

        return view('Agreement.editAgreement', [
            'agreement' => $agreement,
            'employee_details' => $employee_details,
            'agreementTemplates' => $agreementTemplates,
            'employee' => $employee,
            'downloadable' => false
        ]);
    }
    /**
     * Update the specified agreement in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Agreement  $agreement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Agreement $agreement) {
        // Validate the request data
        $validatedData = Validator::make($request->all(), [
            'agreement_template_id' => 'required|exists:agreement_templates,id',
            'agreement_catagory' => 'required',
            'emp_id' => [
                'required',
                new Exists('employes', 'emp_id'),
            ],
            'topics' => 'required|array',
        ],
        [
            'agreement_template_id.exists' => 'The selected agreement template is invalid.',
            'emp_id.exists' => 'The selected employee is invalid.',
            'agreement_catagory.required' => 'The agreement category is required.',
            'topics.required' => 'At least one topic must be provided.',
            'topics.array' => 'The topics must be an array.',
            'topics.*.title.required' => 'Each topic must have a title.',
            'topics.*.subtopics.*.subtitle.required' => 'Each subtopic must have a subtitle.',
            'topics.*.subtopics.*.description.required' => 'Each subtopic must have a description.'
        ]
    );

        if ($validatedData->fails()) {
            return redirect()->back()->withErrors($validatedData)->withInput();
        }

        DB::beginTransaction();
        try {
            $validated = $validatedData->validated();

            // Update the agreement
            $agreement->emp_id = $validated['emp_id'];
            $agreement->template_id = $validated['agreement_template_id'];
            $agreement->save();

            // Get Existing agreement terms id and comming terms id
            $existingAgreementTerms = AgreementTerm::where('agreement_id', $agreement->id)->pluck('id')->toArray();
            $commingAgreementTerms = [];
            $commingAgreementSubTerms = [];

            // Collect all agreement_term_ids and agreement_sub_term_ids
            foreach ($validated['topics'] as $topic) {
                if (isset($topic['agreementTerm_id'])) {
                    $commingAgreementTerms[] = $topic['agreementTerm_id'];
                }

                if (isset($topic['subtopics']) && is_array($topic['subtopics'])) {
                    foreach ($topic['subtopics'] as $subtopic) {
                        if (isset($subtopic['agreementSubTerm_id'])) {
                            $commingAgreementSubTerms[] = $subtopic['agreementSubTerm_id'];
                        }
                    }
                }
            }

            // Remove the existing agreement sub terms that are not in the coming list
            $agreementSubTermsToRemove = AgreementSubTerm::where('agreement_id', $agreement->id)
                ->whereNotIn('id', $commingAgreementSubTerms)
                ->get();

            foreach ($agreementSubTermsToRemove as $agreementSubTermToRemove) {
                $agreementSubTermToRemove->delete();
            }

            // Remove the existing agreement terms that are not in the coming list
            $agreementTermsToRemove = AgreementTerm::where('agreement_id', $agreement->id)
                ->whereNotIn('id', $commingAgreementTerms)
                ->get();

            foreach ($agreementTermsToRemove as $agreementTermToRemove) {
                $agreementTermToRemove->delete();
            }

            // Sort topics based on the 'order' parameter
            usort($validated['topics'], function ($a, $b) {
                return $a['order'] <=> $b['order'];
            });

            // Loop through the topics
            foreach ($validated['topics'] as $topic) {
                if (isset($topic['agreementTerm_id'])) {
                    // Update the existing topic
                    $agreementTerm = AgreementTerm::find($topic['agreementTerm_id']);
                    $agreementTerm->order_number = $topic['order'];
                    $agreementTerm->title = $topic['title'];
                    $agreementTerm->save();
                } else {
                    // Create a new topic
                    $agreementTerm = new AgreementTerm();
                    $agreementTerm->agreement_id = $agreement->id;
                    $agreementTerm->order_number = $topic['order'];
                    $agreementTerm->title = $topic['title'];
                    $agreementTerm->save();
                }

                if (!empty($topic['subtopics']) && is_array($topic['subtopics'])) {
                    foreach ($topic['subtopics'] as $subtopic) {
                        if (empty(trim($subtopic['subtitle'])) && empty(trim($subtopic['description']))) {
                            continue;
                        }

                        if (isset($subtopic['agreementSubTerm_id'])) {
                            $agreementSubTerm = AgreementSubTerm::find($subtopic['agreementSubTerm_id']);
                            $agreementSubTerm->SubTerm_title = $subtopic['subtitle'];
                            $agreementSubTerm->SubTerm_description = $subtopic['description'];
                            $agreementSubTerm->save();
                        } else {
                            $agreementSubTerm = new AgreementSubTerm();
                            $agreementSubTerm->agreement_id = $agreement->id;
                            $agreementSubTerm->agreement_term_id = $agreementTerm->id;
                            $agreementSubTerm->SubTerm_title = $subtopic['subtitle'];
                            $agreementSubTerm->SubTerm_description = $subtopic['description'];
                            $agreementSubTerm->save();
                        }
                    }
                }
            }

            DB::commit();
            return redirect()->route('useradmin.show_agreement_employee')->with('success', 'Agreement updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'An error occurred while updating the agreement: ' . $e->getMessage());
        }
    }


           //**   EVENT AGREEMENT  **//
    /**
     * Returns the view for creating a new agreement for an event.
     *
     * @return \Illuminate\View\View
     */
    public function index_records_events()
    {
        $agreements = Agreement::with('template', 'agreementTerms', 'agreementSubTerms', 'template.agreementCategory', 'event')->where('event_id', '!=', null)->get();
        return view('Agreement.agreemnetIndexEvent', compact('agreements'));
    }
    /**
     * Show the form for creating a new agreement for an event.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_agreement_event()
    {
        $agreementTemplates = AgreementTemplate::with(['agreementCategory', 'terms.subTerms'])->get();
        $eventDetails = AdminEvent::with('customer')->get();
        $customers = Customer::all();
        $selectedEventDetails = null;
        // Fetch default agreement template
        $defaultAgreementTemplate = AgreementTemplate::with('terms.subTerms')->where('is_default', 1)->first();

        return view('Agreement.createEventAgreement', [
            'eventDetails' => $eventDetails,
            'selectedEventDetails' => $selectedEventDetails,
            'agreementTemplates' => $agreementTemplates,
            'defaultAgreementTerms' => $defaultAgreementTemplate ? $defaultAgreementTemplate->terms : null,
            'customers' => $customers,
            'downloadable' => true
        ]);
    }
    /**
     * Generates the view for an agreement associated with a specific event.
     *
     * Retrieves the agreement details based on the provided event ID. If an agreement
     * exists for the event, it loads and displays the editable agreement details.
     * Otherwise, it loads the default agreement template for creation.
     *
     * @param int $eid The event ID for which the agreement is to be generated.
     * @return \Illuminate\View\View The view for editing or creating an event agreement.
     */
    public function generateAgreementEvent($eid)
    {
        // Find agreement by event id
        $agreement = Agreement::with('template', 'agreementTerms', 'agreementSubTerms', 'template.agreementCategory')->where('event_id', $eid)->first();
        $eventDetails = AdminEvent::with('customer')->get();
        $selectedEventDetails = AdminEvent::where('eid', $eid)->with('customer')->first();
        $agreementTemplates = AgreementTemplate::with(['agreementCategory', 'terms.subTerms'])->get();
        $customers = Customer::all();
        $defaultAgreementTemplate = AgreementTemplate::with('terms.subTerms')->where('is_default', 1)->first();
        // Check if an agreement exists for the event
        if (isset($agreement)) {
            $agreementCustomerDetail = AgreementCustomersDetail::where('agreement_id', $agreement->id)->first();
            // If an agreement exists, load its details
            $agreementDetails = $agreement->load('template', 'agreementTerms', 'agreementSubTerms');
            return view('Agreement.editEventAgreement', [
                'agreement' => $agreement,
                'eventDetails' => $eventDetails,
                'selectedEventDetails' => $selectedEventDetails,
                'agreementTemplates' => $agreementTemplates,
                'agreementDetails' => $agreementDetails,
                'customers' => $customers,
                'agreementCustomerDetail' => $agreementCustomerDetail,
                'downloadable' => true
            ]);
        } else {
            // If no agreement exists, load the default agreement template
            return view('Agreement.createEventAgreement', [
                'eventDetails' => $eventDetails,
                'selectedEventDetails' => $selectedEventDetails,
                'agreementTemplates' => $agreementTemplates,
                'defaultAgreementTerms' => $defaultAgreementTemplate ? $defaultAgreementTemplate->terms : null,
                'customers' => $customers,
                'downloadable' => true
            ]);
        }
    }

    /**
     * Stores the agreement in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_agreement_event(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'agreement_template_id' => 'required|exists:agreement_templates,id',
            'event_details.event_id' => 'required|exists:events,eid',
            'customer_details.customer_id' => 'nullable|integer',
            'customer_details.customer_name' => 'required|string',
            'customer_details.nic' => 'required|string',
            'customer_details.location' => 'required|string',
            'customer_details.customer_phone' => 'required|string',
            'customer_details.company_name' => 'nullable|string',
            'topics' => 'required|array',
            'topics.*.title' => 'required|string',
            'topics.*.order' => 'required|integer',
            'topics.*.subtopics' => 'nullable|array',
            'topics.*.subtopics.*.subtitle' => 'required_with:topics.*.subtopics.*.description|string',
            'topics.*.subtopics.*.description' => 'required_with:topics.*.subtopics.*.subtitle|string',
        ], [
            'agreement_template_id.exists' => 'The selected agreement template is invalid.',
            'event_details.event_id.exists' => 'The selected event is invalid.',
            'topics.required' => 'At least one topic must be provided.',
            'topics.array' => 'The topics must be an array.',
            'topics.*.title.required' => 'Each topic must have a title.',
            'topics.*.order.required' => 'Each topic must have an order number.',
            'topics.*.subtopics.array' => 'The subtopics must be an array.',
            'topics.*.subtopics.*.subtitle.required_with' => 'Each subtopic must have a subtitle if a description is provided.',
            'topics.*.subtopics.*.description.required_with' => 'Each subtopic must have a description if a subtitle is provided.',
            'customer_details.customer_name.required' => 'Customer name is required.',
            'customer_details.nic.required' => 'Customer NIC is required.',
            'customer_details.location.required' => 'Customer location is required.',
            'customer_details.customer_phone.required' => 'Customer phone is required.',
            'customer_details.company_name.required' => 'Company name is required.',
        ]);

        if ($validatedData->fails()) {
            return redirect()->back()->withErrors($validatedData)->withInput();
        }

        DB::beginTransaction();
        try {
            $validated = $validatedData->validated();

            // Check that event has agreement
            $eventAgreement = Agreement::where('event_id', $validated['event_details']['event_id'])->first();
            if ($eventAgreement) {
                return redirect()->back()->with('error', 'This event already has an agreement.');
            }

            // Create a new Agreement
            $agreement = new Agreement();
            $agreement->event_id = $validated['event_details']['event_id'];
            $agreement->template_id = $validated['agreement_template_id'];
            $agreement->save();

            // <<< === Insert customer_details into agreement_customers_details
            $customerDetails = $validated['customer_details'];

            \App\Models\AgreementCustomersDetail::create([
                'agreement_id' => $agreement->id,
                'customer_id' => $customerDetails['customer_id'] ?? null,
                'customer_name' => $customerDetails['customer_name'],
                'nic' => $customerDetails['nic'],
                'location' => $customerDetails['location'],
                'company_name' => $customerDetails['company_name'] ?? null,
                'customer_phone' => $customerDetails['customer_phone'],
            ]);

            // Loop through the topics
            foreach ($validated['topics'] as $topic) {
                $agreementTerm = new AgreementTerm();
                $agreementTerm->agreement_id = $agreement->id;
                $agreementTerm->order_number = $topic['order'];
                $agreementTerm->title = $topic['title'];
                $agreementTerm->save();

                if (!empty($topic['subtopics']) && is_array($topic['subtopics'])) {
                    foreach ($topic['subtopics'] as $subtopic) {
                        if (empty(trim($subtopic['subtitle'])) && empty(trim($subtopic['description']))) {
                            continue;
                        }

                        $agreementSubTerm = new AgreementSubTerm();
                        $agreementSubTerm->agreement_id = $agreement->id;
                        $agreementSubTerm->agreement_term_id = $agreementTerm->id;
                        $agreementSubTerm->SubTerm_title = $subtopic['subtitle'];
                        $agreementSubTerm->SubTerm_description = $subtopic['description'];
                        $agreementSubTerm->save();
                    }
                }
            }

            DB::commit();
            return redirect()->route('useradmin.show_agreement_event')->with('success', 'Agreement created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'An error occurred while creating the agreement: ' . $e->getMessage());
        }
    }

    /**
     * Displays the form for editing an event-specific agreement.
     *
     * Retrieves and prepares all necessary data, including the agreement details, associated terms,
     * and customer information, to populate the edit agreement view. The agreement terms are ordered
     * by their order number for clarity. This function also fetches related templates and default
     * agreement terms for the selected agreement category.
     *
     * @param int $agreement The ID of the agreement to be edited.
     * @return \Illuminate\View\View The view for editing the event agreement.
     */
        public function edit_agreement_event($agreement){
            $agreement = Agreement::find($agreement);
            // Fetch the agreement_terms and agreement_sub_terms
            $agreement = Agreement::with([
                'template',
                'agreementTerms' => function ($query) {
                    $query->orderBy('order_number', 'asc'); // Sorting agreementTerms by order_id
                },
                'agreementSubTerms',
                'template.agreementCategory',
                'agreementTerms.agreementSubTerms',
                'event'

            ])->find($agreement->id);
            $eventDetails = AdminEvent::with('customer')->get();
            $event = AdminEvent::find($agreement->event_id);
            $customers = Customer::all();
            $agreementTemplates = AgreementTemplate::with(['agreementCategory', 'terms.subTerms'])->get();
            $defaultAgreementTemplate = AgreementTemplate::where('agreement_category_id', $agreement->template->agreement_category_id)->first();
            $agreementCustomerDetail = AgreementCustomersDetail::where('agreement_id', $agreement->id)->first();
            return view('Agreement.editEventAgreement', [
                'agreement' => $agreement,
                'event' => $event,
                'eventDetails' => $eventDetails,
                'customers' => $customers,
                'agreementTemplates' => $agreementTemplates,
                'defaultAgreementTerms' => $defaultAgreementTemplate ? $defaultAgreementTemplate->terms : null,
                'agreementCustomerDetail' => $agreementCustomerDetail,
                'downloadable' => false
            ]);

        }

    /**
     * Generates the view for editing an agreement associated with a specific event.
     *
     * Retrieves the agreement details including its template, terms, and sub-terms,
     * based on the provided agreement ID. It also fetches relevant event details,
     * customer information, and available agreement templates to populate the
     * edit agreement view. The function ensures that the agreement is linked to
     * both an employee and an event. If a default agreement template exists for
     * the selected agreement category, its terms are also included in the view.
     *
     * @param int $agreement The ID of the agreement to be edited.
     * @return \Illuminate\View\View The view for editing the event agreement.
     */
    public function generateAgreementEdit($agreement){
        $agreement = Agreement::with('template', 'agreementTerms', 'agreementSubTerms', 'template.agreementCategory')->where('emp_id', '!=', null)->where('event_id', $agreement)->first();
        $eventDetails = AdminEvent::with('customer')->get();
        $event = AdminEvent::find($agreement->event_id);
        $customers = Customer::all();
        $agreementTemplates = AgreementTemplate::with(['agreementCategory', 'terms.subTerms'])->get();
        $defaultAgreementTemplate = AgreementTemplate::where('agreement_category_id', $agreement->template->agreement_category_id)->first();
        $agreementCustomerDetail = AgreementCustomersDetail::where('agreement_id', $agreement->id)->first();

        dd($agreementCustomerDetail);
        return view('Agreement.editEventAgreement', [
            'agreement' => $agreement,
            'event' => $event,
            'eventDetails' => $eventDetails,
            'customers' => $customers,
            'agreementTemplates' => $agreementTemplates,
            'defaultAgreementTerms' => $defaultAgreementTemplate ? $defaultAgreementTemplate->terms : null,
            'agreementCustomerDetail' => $agreementCustomerDetail,
            'downloadable' => false
        ]);
    }

    /**
     * Updates an existing agreement for an event.
     *
     * Validates the request data, ensuring that the agreement template and event exist,
     * and that topics and subtopics are correctly structured. The function updates the
     * agreement and its associated terms and sub-terms based on the provided data.
     * It removes any existing terms and sub-terms not included in the update, and
     * creates new ones as needed. The function commits the changes to the database
     * at the end of the process or rolls back in case of an error.
     *
     * @param \Illuminate\Http\Request $request The request object containing agreement data.
     * @param \App\Models\Agreement $agreement The agreement to be updated.
     * @return \Illuminate\Http\Response Redirects to the agreement event view on success, or back with errors on failure.
     */
    public function update_agreement_event(Request $request, Agreement $agreement)
    {
        // Validation rules for the request data
        $validatedData = Validator::make($request->all(), [
            'agreement_template_id' => 'required|exists:agreement_templates,id',
            'event_details.event_id' => 'required|exists:events,eid',
            'customer_details.customer_id' => 'nullable|integer',
            'customer_details.customer_name' => 'required|string',
            'customer_details.nic' => 'required|string',
            'customer_details.location' => 'required|string',
            'customer_details.customer_phone' => 'required|string',
            'customer_details.company_name' => 'nullable|string',
            'topics' => 'required|array',
            'topics.*.title' => 'required|string',
            'topics.*.order' => 'required|integer',
            'topics.*.subtopics' => 'nullable|array',
            'topics.*.agreementTerm_id' => 'required|exists:agreement_terms,id',
            'topics.*.subtopics.*.agreementSubTerm_id'=> 'required|exists:agreement_sub_terms,id',
            'topics.*.subtopics.*.subtitle' => 'required_with:topics.*.subtopics.*.description|string',
            'topics.*.subtopics.*.description' => 'required_with:topics.*.subtopics.*.subtitle|string',
        ], [
            'agreement_template_id.exists' => 'The selected agreement template is invalid.',
            'event_id.exists' => 'The selected event is invalid.',
            'customer_details.customer_name.required' => 'Customer name is required.',
            'customer_details.nic.required' => 'Customer NIC is required.',
            'customer_details.location.required' => 'Customer location is required.',
            'customer_details.customer_phone.required' => 'Customer phone is required.',
            'customer_details.company_name.required' => 'Company name is required.',
            'topics.required' => 'At least one topic must be provided.',
            'topics.array' => 'The topics must be an array.',
            'topics.*.title.required' => 'Each topic must have a title.',
            'topics.*.order.required' => 'Each topic must have an order number.',
            'topics.*.subtopics.array' => 'The subtopics must be an array.',
            'topics.*.subtopics.*.subtitle.required_with' => 'Each subtopic must have a subtitle if a description is provided.',
            'topics.*.subtopics.*.description.required_with' => 'Each subtopic must have a description if a subtitle is provided.',
        ]);

        if ($validatedData->fails()) {
            return redirect()->back()->withErrors($validatedData)->withInput();
        }

        DB::beginTransaction();
        try {
            $validated = $validatedData->validated();

            // Update the agreement
            $agreement->event_id = $validated['event_details']['event_id'];
            $agreement->template_id = $validated['agreement_template_id'];
            $agreement->save();

            // Update Agreement Customer Details
            $customerDetails = $validated['customer_details'];

            $agreementCustomerDetail = AgreementCustomersDetail::where('agreement_id', $agreement->id)->first();

            if ($agreementCustomerDetail) {
                // Update existing AgreementCustomerDetail
                $agreementCustomerDetail->customer_id = $customerDetails['customer_id'] ?? null;
                $agreementCustomerDetail->customer_name = $customerDetails['customer_name'];
                $agreementCustomerDetail->nic = $customerDetails['nic'];
                $agreementCustomerDetail->location = $customerDetails['location'];
                $agreementCustomerDetail->company_name = $customerDetails['company_name'] ?? null;
                $agreementCustomerDetail->customer_phone = $customerDetails['customer_phone'];
                $agreementCustomerDetail->save();
            } else {
                // If no AgreementCustomerDetail found, create one
                AgreementCustomersDetail::create([
                    'agreement_id' => $agreement->id,
                    'customer_id' => $customerDetails['customer_id'] ?? null,
                    'nic' => $customerDetails['nic'],
                    'customer_name' => $customerDetails['customer_name'],
                    'location' => $customerDetails['location'],
                    'company_name' => $customerDetails['company_name'] ?? null,
                    'customer_phone' => $customerDetails['customer_phone'],
                ]);
            }

            // Get Existing agreement terms id and incoming terms ids
            $existingAgreementTerms = AgreementTerm::where('agreement_id', $agreement->id)->pluck('id')->toArray();
            $commingAgreementTerms = [];
            $commingAgreementSubTerms = [];

            // Collect all agreement_term_ids and agreement_sub_term_ids
            foreach ($validated['topics'] as $topic) {
                if (isset($topic['agreementTerm_id'])) {
                    $commingAgreementTerms[] = $topic['agreementTerm_id'];
                }

                if (isset($topic['subtopics']) && is_array($topic['subtopics'])) {
                    foreach ($topic['subtopics'] as $subtopic) {
                        if (isset($subtopic['agreementSubTerm_id'])) {
                            $commingAgreementSubTerms[] = $subtopic['agreementSubTerm_id'];
                        }
                    }
                }
            }

            // Remove the existing agreement subterms that are not in the incoming list
            $agreementSubTermsToRemove = AgreementSubTerm::where('agreement_id', $agreement->id)
                ->whereNotIn('id', $commingAgreementSubTerms)
                ->get();
            foreach ($agreementSubTermsToRemove as $agreementSubTermToRemove) {
                $agreementSubTermToRemove->delete();
            }

            // Remove the existing agreement terms that are not in the incoming list
            $agreementTermsToRemove = AgreementTerm::where('agreement_id', $agreement->id)
                ->whereNotIn('id', $commingAgreementTerms)
                ->get();
            foreach ($agreementTermsToRemove as $agreementTermToRemove) {
                $agreementTermToRemove->delete();
            }

            // Sort topics based on the 'order' parameter
            usort($validated['topics'], function ($a, $b) {
                return $a['order'] <=> $b['order'];
            });

            // Loop through the topics and update or create terms and subterms
            foreach ($validated['topics'] as $topic) {
                if (isset($topic['agreementTerm_id'])) {
                    // Update existing term
                    $agreementTerm = AgreementTerm::find($topic['agreementTerm_id']);
                    $agreementTerm->order_number = $topic['order'];
                    $agreementTerm->title = $topic['title'];
                    $agreementTerm->save();
                } else {
                    // Create new term
                    $agreementTerm = new AgreementTerm();
                    $agreementTerm->agreement_id = $agreement->id;
                    $agreementTerm->order_number = $topic['order'];
                    $agreementTerm->title = $topic['title'];
                    $agreementTerm->save();
                }

                if (!empty($topic['subtopics']) && is_array($topic['subtopics'])) {
                    foreach ($topic['subtopics'] as $subtopic) {
                        if (empty(trim($subtopic['subtitle'])) && empty(trim($subtopic['description']))) {
                            continue;
                        }

                        if (isset($subtopic['agreementSubTerm_id'])) {
                            $agreementSubTerm = AgreementSubTerm::find($subtopic['agreementSubTerm_id']);
                            $agreementSubTerm->SubTerm_title = $subtopic['subtitle'];
                            $agreementSubTerm->SubTerm_description = $subtopic['description'];
                            $agreementSubTerm->save();
                        } else {
                            $agreementSubTerm = new AgreementSubTerm();
                            $agreementSubTerm->agreement_id = $agreement->id;
                            $agreementSubTerm->agreement_term_id = $agreementTerm->id;
                            $agreementSubTerm->SubTerm_title = $subtopic['subtitle'];
                            $agreementSubTerm->SubTerm_description = $subtopic['description'];
                            $agreementSubTerm->save();
                        }
                    }
                }
            }

            DB::commit();
            return redirect()->route('useradmin.show_agreement_event')->with('success', 'Agreement updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'An error occurred while updating the agreement: ' . $e->getMessage());
        }
    }

}
