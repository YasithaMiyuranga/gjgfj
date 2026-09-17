<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Rent;
use App\Models\Order;
use App\Models\Employe;
use App\Models\Customer;
use App\Models\RentItem;
use App\Models\Agreement;
use App\Models\DamageItem;
use App\Models\MissingItem;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\RentItemSupplier;
use App\Models\AdditionalExpense;
use App\Models\AgreementCustomersDetail;
use App\Models\AdminEvent;
use Illuminate\Support\Facades\DB;
use function Laravel\Prompts\alert;

class PdfController extends Controller
{
    //** * Function TO GENERATE A SPECIFIC SENT ITEMS PDF ***//
    public function generatePdf($id)
    {
        $rent = Rent::findOrFail($id);
        $rentitems = RentItem::where('rent_id', $id)->get();

        foreach ($rentitems as $rentitem) {
            $item = DB::table('item')->where('item_id', $rentitem->item_id)->first();
            $rentitem->item_name = $item->item_name ?? 'Unknown Item';
             // Get all suppliers for the item
             $suppliers = RentItemSupplier::where('rent_item_id', $rentitem->rent_item_id)
             ->join('suppliers', 'rent_item_supplier.supplier_id', '=', 'suppliers.id')
             ->select('suppliers.*', 'rent_item_supplier.quantity as rent_quantity', 'rent_item_supplier.price as rent_price')
             ->get();
             $rentitem->suppliers = $suppliers;
        }

        $pdf = PDF::loadView('PDF.downloadfile', ['rent' => $rent, 'rentitems' => $rentitems]);

        return response($pdf->output())
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="Rent_Item_Report_' . $rent->created_at->format('Y-m-d') . '.pdf"');
    }


    //*** FUNCTION TO GENERATE MISSING ITEMS PDF */
    public function generateMissingPdf($id)
    {
        $missingitems =MissingItem::where('rent_id',$id)->get();
        $rent = DB::table('rent')->where('rent_id', $id)->first();

        foreach ($missingitems as $missingitem) {
            $item = DB::table('item')->where('item_id', $missingitem->item_id)->first();
            $missingitem->item_name = $item->item_name;
        }

        // Generate the PDF with missing items data
        $pdf = PDF::loadView('PDF.downloadmissingfile', [
            'rent' =>$rent,
            'missingitems' => $missingitems,
        ]);

        // Return the generated PDF response
        return response($pdf->output())
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="Missing_Item_Report_'  . '.pdf"');
    }

    // *** FUNCTION TO  DISPLAY RECEIVED ITEM PDF DOWNLOAD ***//
    public function generateViewPdf($id)
    {
        // Fetch Rent Details
        $rent = Rent::findOrFail($id);

        // Fetch Rent Items
        $rentitems = RentItem::where('rent_id', $id)->get();


        // Fetch Missing Items
        $missingitems = MissingItem::where('rent_id', $id)->get();

        // Get damage items
        $damageitems = DamageItem::where('rent_id', $id)->get();


        // Check items missing or not
        if ($missingitems != null)
        {
            foreach($missingitems as $missingitem )
            {
                // Get missing items names
                $item = DB::table('item')->where('item_id', $missingitem->item_id)->first();
                $missingitem->item_name = $item->item_name;
                $missingitem->item_quantity = $missingitem->quantity;
            }
        }
        else
        {
            $missingitems=null;
        }

        // Check items damage or not
        if ($damageitems != null)
        {
            foreach($damageitems as $damageitem )
            {
                // Get damage items names
                $item = DB::table('damage_items')->where('rent_id', $damageitem->rent_id)
                ->get();

                // Rent_item_id to get item name
                $rentitem = DB::table('rent_items')->where('rent_item_id', $damageitem->rent_item_id)->first();
                $item = DB::table('item')->where('item_id', $rentitem->item_id)->first();
                // Get item name
                $damageitem->rent_item = $damageitem->rent_item_id;
                $damageitem->item_quantity = $damageitem->quantity;
                $damageitem->item_name = $item->item_name;


            }
        }
        else
        {
            $damageitems=null;
        }


        //Get a specific rent recieved items
        foreach ($rentitems as $rentitem) {
            $item = DB::table('item')->where('item_id', $rentitem->item_id)->first();
            $rentitem->item_name = $item->item_name;
        }

        $pdf = PDF::loadView('PDF.downloadreceivedfile', ['rent' => $rent, 'rentitems' => $rentitems,'missingitems' => $missingitems,'damageitems' => $damageitems]);

        return response($pdf->output())
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="Rent_Received_Item_Report_' . $rent->created_at . '.pdf"');
    }


    //**  FUNATION TO GENERATE CUSTPMER PACKAGE ITEMS PDF ** */
    public function generateCmPackagePdf($package_id)
    {

        $customer_package = DB::table('customer_packages')->where('package_id', $package_id)->first();
        $customer_package_items = DB::table('customer_package_item')->where('package_id', $package_id)->get();
        $pdf = PDF::loadView('PDF.downloadcmPackage', ['customer_package' => $customer_package, 'customer_package_items' => $customer_package_items]);
        return response($pdf->output())
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="Customer_Package_Item_Quatation_' . $customer_package->customer_name . '.pdf"');

    }

    //** FUNCTION TO GENERATE EVENT BASE SALARY PDF */
    public function generateEventBaseSalaryPdf($event_id)
    {
        $event = DB::table('events')->where('eid', $event_id)->first();
        $event_base_salary =  Employe::join('job_amount', 'employes.emp_id', '=', 'job_amount.emp_id')
        ->where('job_amount.event_id', $event_id)
        ->groupBy('employes.emp_id')
        ->get([
            'employes.emp_id',
            'employes.name',
            'employes.emp_type',
            DB::raw('SUM(job_amount.job_amount) as total_job_amount')
        ]);
        $pdf = PDF::loadView('PDF.downloadeventbasesalary', ['event' => $event, 'event_base_salary' => $event_base_salary]);
        return response($pdf->output())
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="Event_Base_Salary_Report_' . $event->event_name . '.pdf"');
    }

    //** FUNCTION TO GENERATE PAYMENT CONFIRMATION PDF */
    public function generatePaymentPdf($id)
    {
        // Get order details,bank details that related to payment
        $paymentLogDetails = DB::table('payment_logs')
            ->join('order', 'payment_logs.order_id', '=', 'order.order_id')
            ->join('bank_accounts', 'order.bank_id' , '=', 'bank_accounts.id')
            ->where('payment_logs.payment_log_id', $id)
            ->first();

        $pdf = PDF::loadView('PDF.downloadpaymentconfirmation', ['paymentLogDetails' => $paymentLogDetails]);

        return response($pdf->output())
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="Payment_Confirmation_' . $paymentLogDetails->paid_date . '.pdf"');
    }

    public function generateAgreement($id)
    {
        // Get agreement id
        $idParts = explode(',', $id);
        $id = trim($idParts[0]);
        $agreement = Agreement::where('id', $id)
            ->with([
                'template',
                'agreementTerms' => function ($query) {
                    $query->orderBy('order_number', 'asc');
                },
                'agreementTerms.agreementSubTerms',
                'agreementSubTerms'
            ])
            ->first();
        // Get employee details
        $agreement->employee = Employe::where('emp_id', $agreement->emp_id)->first();
        // Get today date
        $agreement->date = date('Y-m-d');
        $pdf = PDF::loadView('PDF.agreementPdf', ['agreement' => $agreement]);
        return response($pdf->output())
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="Agreement_' . $agreement->employee->name . '.pdf"');

    }

    public function downloadExpencePdf($id)
    {
        // Get additional expence
        $expence = AdditionalExpense::findOrFail($id);
        $pdf = PDF::loadView('PDF.downloadExpenceSlip', ['expence' => $expence]);
        return response($pdf->output())
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="Expence_' . $expence->expense_name . '.pdf"');

    }

    public function generateAgreementEvent($id)
    {
        // Get agreement id
        $idParts = explode(',', $id);
        $id = trim($idParts[0]);
        $agreement = Agreement::where('id', $id)
            ->with([
                'template',
                'agreementTerms' => function ($query) {
                    $query->orderBy('order_number', 'asc');
                },
                'agreementTerms.agreementSubTerms',
                'agreementSubTerms'
            ])
            ->first();
            //get event details
            $agreement->event = AdminEvent::where('eid', $agreement->event_id)->first();
            // Get agreement customers details
            $agreement->agreementCustomersDetail = AgreementCustomersDetail::where('agreement_id', $id)->get();
            //get customer details
            $agreement->customer = Customer::where('customer_id', $agreement->agreementCustomersDetail[0]->customer_id)->first();
            // Get today date
            $agreement->date = date('Y-m-d');
        $pdf = PDF::loadView('PDF.eventAgreementPdf', ['agreement' => $agreement]);

        return response($pdf->output())
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="Agreement_' . $agreement->agreementCustomersDetail[0]->customer_name. '.pdf"');

    }

}
