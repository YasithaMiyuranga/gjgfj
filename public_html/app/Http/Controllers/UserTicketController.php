<?php

namespace App\Http\Controllers;

use App\Mail\InvoiceEmail;
use App\Mail\RefundMail;
use App\Models\SoldOutSeats;
use App\Models\Transaction;
use App\Models\User;
use DB;
use Carbon\Carbon;
use App\Models\Ticket;
use App\Mail\QrCodeMail;
use App\Models\AdminEvent;
use App\Models\UserTicket;
use App\Models\TicketOwner;
use Vinkla\Hashids\Facades\Hashids;
use Illuminate\Http\Request;
use App\Models\EventCouponList;
use App\Models\TicketOrderList;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Console\Scheduling\Event;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Milon\Barcode\DNS1D;

class UserTicketController extends Controller
{

    //***  RETRIVES A LIST OF USER TICKETS */
    public function user_ticket_list()
    {
        $UserTickets = UserTicket::all();
        return view('', compact());
    }

    //*** FUNCTION TO  CREATE A USER TICKET */
    public function userTicketCreate(Request $request, $eid)
    {


        // Decode the JSON data from the hidden input fields
        $categories = json_decode($request->input('categories'), true);
        $quantities = json_decode($request->input('quantities'), true);
        $seats = json_decode($request->input('seats'), true);
        // Initialize arrays for easier processing
        $categoryNames = [];
        $quantityValues = [];
        $ticketPrice = [];
        $subtotals = [];



        // Check if the ticket categories and quantities are valid arrays
        if (is_array($categories) && is_array($quantities)) {
            // Process the categories
            foreach ($categories as $category) {
                $categoryNames[$category['id']] = $category['category'];
                // Unique price of selected ticket
                $ticketPrice[$category['id']] = Ticket::where('id', $category['id'])->value('price');
            }

            // Process the quantities
            foreach ($quantities as $quantity) {
                $quantityValues[$quantity['id']] = $quantity['quantity'];
            }



            // Calculate subtotals
            foreach ($categoryNames as $categoryId => $categoryName) {

                $price = $ticketPrice[$categoryId];

                $quantity = $quantityValues[$categoryId] ?? 0; // Default to 0 if not found
                $subtotals[$categoryId] = $price * $quantity;
            }


            // Calculate total
            $total = array_sum($subtotals);

            return view('User.billing', compact('total', 'eid', 'categoryNames', 'quantityValues', 'seats'));
        } else {
            return redirect()->back()->with('error', 'Invalid ticket categories or quantities');
        }
    }

    //*** FUNCTION TO STORE A USER TICKET */
    public function user_ticket_store(Request $request)
    {

        //    //check validate
        $request->validate([
            'ticket_id' => 'required|string',
            'event_id' => 'required|string',
            'event_name' => 'required|string',
            'user_id' => 'required|string',
            'user_name' => 'required|string',
            'user_phone_number' => 'required|string',
            'qr_code' => 'required|string',
            'buy_date' => 'required|date',
            'ticket_status' => 'required|string',
        ]);
    }


    //*** FUNCTION TO EDIT A SPECIFIC USER TICKET */
    public function user_ticket_edit($id)
    {
    }

    //*** FUNCTI0N TO UPDATE A SPECIFIC USER TICKET */
    public function user_ticket_update(Request $request, $id)
    {


        //check validate
        $request->validate([
            'ticket_id' => 'required|string',
            'event_id' => 'required|string',
            'event_name' => 'required|string',
            'user_id' => 'required|string',
            'user_name' => 'required|string',
            'user_phone_number' => 'required|string',
            'qr_code' => 'required|string',
            'buy_date' => 'required|date',
            'ticket_status' => 'required|string',
        ]);
    }

    //*** FUNCTION TO DELETE USER TICKET IN THE SYSTEM ***/
    function user_ticket_delete($id)
    {
    }

    function getToken(Request $request)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => env('PAYHERE_ACCESS_TOKEN_ENDPOINT'),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => 'grant_type=client_credentials',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Basic ' . env('PAYHERE_AUTHORIZATION_CODE'),
                'Content-Type: application/x-www-form-urlencoded'
            ),
            CURLOPT_SSL_VERIFYPEER => false, // Only for local
        ));

        $response = curl_exec($curl);

        if (curl_errno($curl)) {
            Log::error('cURL Error (Access Token): ' . curl_error($curl));
        } else {
            Log::info('PayHere Access Token Response: ' . $response);

            $result = json_decode($response, true);
            return $result;
        }
    }

    public function getPaymentDetails(Request $request)
    {
        $orderId = $request->input('order_id');
        $authHeader = $request->header('Authorization');

        if (!$authHeader || !str_starts_with($authHeader, 'Bearer ')) {
            return response()->json(['error' => 'Missing or invalid Authorization header'], 401);
        }

        $access_token = trim(str_replace('Bearer', '', $authHeader));
        Log::alert("orderId : " . $orderId);
        Log::alert("access_token : " . $access_token);

        if (!$orderId) {
            return response()->json(['error' => 'Missing order_id'], 400);
        }

        $url = env('PAYHERE_PAYMENT_VALIDATE_ENDPOINT') . '?order_id=' . urlencode($orderId);

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . $access_token,
                'Content-Type: application/json'
            ),
            CURLOPT_SSL_VERIFYPEER => false,
        ));

        $response = curl_exec($curl);

        if (curl_errno($curl)) {
            Log::error('cURL Error (Payment Search): ' . curl_error($curl));
            return response()->json(['error' => 'cURL error'], 500);
        }

        curl_close($curl);

        $result = json_decode($response, true);
        return response()->json($result);
    }


    /**
     * Billing Functions
     *
     * This section contains functions related to billing.
     */

    //** Function to view user Billing View*/
    public function viewBillingDetails($eid)
    {
        return view('User.billing', compact($eid));
    }

    //** Function to store user Billing Details*/
    public function userbillingDetailsStore(Request $request, $eid, $uid)
    {







        $user = User::find($uid);

        if ($user && empty($user->address)) {
            $user->address = $request->address;
            $user->postal_code = $request->postalCode;
            $user->city = $request->city;
            $user->save();
        }


        $transaction = Transaction::create([
            "event_id" => $eid,
            'user_id' => $uid,
            'transaction_id' => $request->payment_id,
            'amount' => $request->total,
            'buyer_phone_number' => $request->phone_no,
            'nic' => $request->nicNumber
        ]);
        $transaction->save();




        // Validate the user registration request
        $validatedData = Validator::make($request->all(), [
            'total' => 'required|numeric',
            'firstName' => 'required|string|max:30',
            'lastName' => 'required|string|max:30',
            'nicNumber' => 'required|string',
            'email' => 'required|string',
            'phone_no' => 'required|numeric|regex:/^0[0-9]{9}$/',
            'address' => 'required|string|max:150',
            'city' => 'required|string|max:30',
            'postalCode' => 'required|string|max:10',
            'categoryNames' => 'required|string',
            'quantityValues' => 'required|string',
            'couponId' => 'string|nullable',
            'couponDiscount' => 'string|nullable',
            'couponCode' => 'string|nullable',
            'seats' => 'string',
        ]);

        $payment_id = $request->payment_id;



        $categoryNames = json_decode($request->input('categoryNames'), true);
        $quantity_values = json_decode($request->input('quantityValues'), true);
        $seats = json_decode($request->input('seats'), true);

        $total = 0;
        $netTotal = 0;


        foreach ($categoryNames as $categoryId => $categoryName) {
            $ticket = Ticket::where('id', $categoryId)->first();
            $qty = $quantity_values[$categoryId];

            $souldout = SoldOutSeats::where('ticket_id', $categoryId);
            $bookedSeat = $seats[$categoryId];


            $soldOutSeats = $souldout->pluck('seat_number')->toArray();

            $conflicts = array_intersect($bookedSeat, $soldOutSeats);

            if ($ticket->number_of_tickets < $qty || !empty($conflicts)) {

                //refund logic

                $curl = curl_init();

                curl_setopt_array($curl, array(
                    CURLOPT_URL => env('PAYHERE_ACCESS_TOKEN_ENDPOINT'),
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => 'grant_type=client_credentials',
                    CURLOPT_HTTPHEADER => array(
                        'Authorization: Basic ' . env('PAYHERE_AUTHORIZATION_CODE'),
                        'Content-Type: application/x-www-form-urlencoded'
                    ),
                    CURLOPT_SSL_VERIFYPEER => false, // Only for local
                ));

                $response = curl_exec($curl);

                if (curl_errno($curl)) {
                    Log::error('cURL Error (Access Token): ' . curl_error($curl));
                } else {
                    Log::info('PayHere Access Token Response: ' . $response);

                    $result = json_decode($response, true);

                    if (isset($result['access_token'])) {
                        $access_token = $result['access_token'];

                        // 👇 Now start refund call
                        $refundPayload = json_encode([
                            'payment_id' => $payment_id,
                            'description' => 'Insufficient Tickets',
                            'authorization_token' => env('PAYHERE_AUTHORIZATION_CODE'), // Or access token, depending on PayHere's API
                        ]);

                        $curl2 = curl_init();

                        curl_setopt_array($curl2, array(
                            CURLOPT_URL => env('PAYHERE_REFUND_ENDPOINT'),
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => '',
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => 'POST',
                            CURLOPT_POSTFIELDS => $refundPayload,
                            CURLOPT_HTTPHEADER => array(
                                'Authorization: Bearer ' . $access_token,
                                'Content-Type: application/json'
                            ),
                            CURLOPT_SSL_VERIFYPEER => false, // Only for dev
                        ));

                        $refund_response = curl_exec($curl2);

                        if (curl_errno($curl2)) {
                            Log::error('cURL Error (Refund): ' . curl_error($curl2));
                        } else {


                            $transaction = Transaction::create([
                                "event_id" => $eid,
                                'user_id' => $uid,
                                'transaction_id' => $request->payment_id,
                                'amount' => -$request->total,
                                'buyer_phone_number' => $request->phone_no,
                                'nic' => $request->nicNumber
                            ]);
                            $transaction->save();

                            $event = AdminEvent::where('eid', $eid)->first();
                            $tickets = Ticket::where('eid', $eid)->get();

                            foreach ($tickets as $ticket) {
                                $soldOutSeats = SoldOutSeats::where('ticket_id', $ticket->id)->pluck('seat_number')->toArray();
                                $ticket->sold_out_seats = $soldOutSeats; // Dynamically attach it
                            }

                            Mail::to($request->email)->send(new RefundMail($event, $tickets));

                            Log::info('PayHere Refund Response: ' . $refund_response);
                        }

                        curl_close($curl2);
                    } else {
                        Log::warning('Unexpected PayHere Token Response:', $result);
                    }
                }

                curl_close($curl);



                return response()->json([
                    'error' => 'Transaction Failed: Insufficient tickets'
                ], 422);
            }

            $total += $ticket->price * $qty;
        }



        $netTotal = $total;

        // Return errors if any
        if ($validatedData->fails()) {
            return redirect()->back()->withErrors($validatedData)->withInput();
        }

        if ($request->couponId) {
            // Find a coupon code
            $coupon = EventCouponList::where('id', $request->couponId)->first();
            // Get the coupon code
            if ($coupon->coupon_no) {
                $couponCode = $coupon->coupon_no;
                $coupon_ID = $request->couponId;
            } else {
                $couponCode = null;   //no coupon column not it fix
            }

            $discount_presentage = $coupon->discount_percentage;
            $discount = ($discount_presentage / 100) * $total;
            $total -= $discount;
        } else {
            $couponCode = null;
            $coupon_ID = $request->couponId;
            $coupon_ID = null;
        }


        if ($total != $request->total) {
            return response()->json([
                'error' => 'Total Price Mismatch!'
            ], 422);
        }


        // Begin transaction
        DB::beginTransaction();

        try {
            // Create a new ticket owner
            $ticketOwner = TicketOwner::create([
                'event_id' => $eid,
                'user_id' => $uid,
                'email' => $request->email,
                'name' => $request->firstName . ' ' . $request->lastName,
                'nic' => $request->nicNumber,
                'phone_number' => $request->phone_no,
                'address' => $request->address,
                'city' => $request->city,
                'zipcode' => $request->postalCode,
                'total' => $total,
            ]);




            // Decode the JSON strings into associative arrays
            $categoryNames = json_decode($request->input('categoryNames'), true);
            $quantityValues = json_decode($request->input('quantityValues'), true);

            // Find a event Name
            $event = AdminEvent::where('eid', $eid)->first();
            $event_name = $event->event_name;

            // Get today date
            $now = Carbon::now();
            $now = $now->toDateTimeString();

            // Iterate through the category names
            foreach ($categoryNames as $categoryId => $categoryName) {
                // Create ticket order list
                $ticketOrderList = TicketOrderList::create([
                    'owner_id' => $ticketOwner->oid,
                    'coupon_id' => $coupon_ID,
                    'name' => $request->firstName . ' ' . $request->lastName,
                    'quantity' => $quantityValues[$categoryId],
                    'discount' => $request->couponDiscount ? $request->couponDiscount : 0, //coupon discount  all for one discount
                    'amount' => $total,
                    'coupon_code' => $couponCode,
                ]);

                // Create QR codes array for the category
                $qrCodesForCategory = [];

                for ($i = 0; $i < $quantityValues[$categoryId]; $i++) {

                    $ticket = Ticket::where('id', $categoryId)->first();

                    // Create user ticket
                    $userTicket = new UserTicket();
                    $userTicket->ticket_id = $categoryId;
                    $userTicket->event_id = $eid;
                    $userTicket->ticket_order_list_id = $ticketOrderList->id;
                    $userTicket->event_name = $event_name;
                    $userTicket->user_id = $uid;
                    $userTicket->user_name = $request->firstName . ' ' . $request->lastName;
                    $userTicket->user_phone_number = $request->phone_no;
                    $userTicket->buy_date = $now;
                    $userTicket->price = $ticket->price;
                    $userTicket->ticket_status = 'active';
                    $userTicket->seat_number = $seats[$categoryId][$i];
                    // Save first to get the ID
                    $userTicket->save();



                    $soldOutSeat = new SoldOutSeats();
                    $soldOutSeat->user_id = $uid;
                    $soldOutSeat->ticket_id = $categoryId;
                    $soldOutSeat->seat_number = $seats[$categoryId][$i];
                    $soldOutSeat->baught_date = $now;
                    $soldOutSeat->save();

                    // Generate a unique code
                    $uniqueCode = rand(100000, 999999);

                    // Prepare the data to encode in the QR code
                    $qrData = " " . Hashids::encode($userTicket->id);

                    // Build the QR Code
                    $qrCode = Builder::create()
                        ->writer(new PngWriter())
                        ->data($qrData)
                        ->build();

                    // Define the path to save the QR code
                    $path = 'qr_codes/' . $ticketOwner->oid . '_' . $ticketOrderList->id . '_' . $userTicket->id . '.png';
                    Storage::disk('public')->put($path, $qrCode->getString());

                    // Generate the barcode PNG as base64
                    $barcodeData = " " . Hashids::encode($userTicket->id);
                    $barCode = new DNS1D();
                    $barCode->setStorPath(storage_path('framework/barcodes/'));
                    $barcodeBase64 = $barCode->getBarcodePNG($barcodeData, 'C128');
                    $barcodeImage = base64_decode($barcodeBase64);

                    // Define the path to save the barcode
                    $bcpath = 'bar_codes/' . $ticketOwner->oid . '_' . $ticketOrderList->id . '_' . $userTicket->id . '.png';
                    Storage::disk('public')->put($bcpath, $barcodeImage);

                    // Update ticket with QR and barcode paths
                    $userTicket->bar_code = $bcpath;
                    $userTicket->qr_code = $path;
                    $userTicket->save();

                    $qrCodesForCategory[] = [
                        'ticket_id' => $userTicket->id,
                        'qr_code_path' => $path,
                        'qr_code_cid' => 'qr_code_' . $userTicket->id,
                        'bar_code_path' => $bcpath,
                        'bar_code_cid' => 'bar_code_' . $userTicket->id,
                        'seat' => $userTicket->seat_number
                    ];
                }

                $ticket = Ticket::where('id', $categoryId)->first();
                $qrCodeDetails[] = [
                    'category_name' => $categoryName,
                    'quantity' => $quantityValues[$categoryId],
                    'qr_codes' => $qrCodesForCategory,
                ];


                $invoiceDetails[] = [
                    'category_name' => $categoryName,
                    'quantity' => $quantityValues[$categoryId],
                    'price_per_ticket' => $ticket->price,
                    'total' => $ticket->price * $quantityValues[$categoryId]
                ];
            }

            foreach ($categoryNames as $categoryId => $categoryName) {
                $ticket = Ticket::where('id', $categoryId)->first();
                $qty = $quantity_values[$categoryId];

                $ticket->number_of_tickets -= $qty;
                $ticket->baught_tickets_count += $qty;
                $ticket->save();
            }


            Mail::to($request->email)->send(new QrCodeMail($event_name, $qrCodeDetails));
            Mail::to($request->email)->send(new InvoiceEmail($event_name, $invoiceDetails, $netTotal, $netTotal - $total));




            // Commit the transaction
            DB::commit();
        } catch (\Exception $e) {
            Log::alert($e);
            // Rollback the transaction if something goes wrong
            DB::rollBack();
        }
    }

    public function sendMail(Request $request)
    {
        $eventId = $request->input('event_id');
        $ownerId = $request->input('owner_id');
        $userEmail = $request->input('user_email');

        $event = AdminEvent::where('eid', $eventId)->first();


        $ticket_order_list = TicketOrderList::where('owner_id', $ownerId)->get();
        $qrCodeDetails = [];

        foreach ($ticket_order_list as $ticket_order) {
            $user_tickets = UserTicket::with('ticket')
                ->where('ticket_order_list_id', $ticket_order->id)
                ->get();

            foreach ($user_tickets as $user_ticket) {
                $category = $user_ticket->ticket->tickets_category;

                // Initialize if not set
                if (!isset($qrCodeDetails[$category])) {
                    $qrCodeDetails[$category] = [
                        'category_name' => $category,
                        'quantity' => 0,
                        'qr_codes' => [],
                    ];
                }

                // Add this ticket's QR/Bar code to the category group
                $qrCodeDetails[$category]['qr_codes'][] = [
                    'ticket_id' => $user_ticket->id,
                    'qr_code_path' => $user_ticket->qr_code,
                    'qr_code_cid' => 'qr_code_' . $user_ticket->id,
                    'bar_code_path' => $user_ticket->bar_code,
                    'bar_code_cid' => 'bar_code_' . $user_ticket->id,
                ];

                // Increase quantity
                $qrCodeDetails[$category]['quantity'] += 1;
            }
        }

        // Re-index the result if needed (optional)
        $qrCodeDetails = array_values($qrCodeDetails);
        Mail::to($userEmail)->send(new QrCodeMail($event->event_name, $qrCodeDetails));


    }


    //payment process

    public function paymentProcess(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'categoryNames' => 'required|string',
            'quantityValues' => 'required|string',
            'couponId' => 'string|nullable',
            'currency' => 'required|string',
            'seats' => 'required|string',
        ]);




        $quantityValues = json_decode($request->input('quantityValues'), true);
        $categoryNames = json_decode($request->input('categoryNames'), true);
        $seats = json_decode($request->input('seats'), true);
        $currency = '';

        $categoryKeys = array_keys($categoryNames);
        $seatKeys = array_keys($seats);

        if ($categoryKeys !== $seatKeys) {
            return response()->json(['error' => 'Seat categories do not match category names'], 422);
        }


        $total = 0;

        $items = '';

        foreach ($categoryNames as $categoryId => $categoryName) {
            $ticket = Ticket::find($categoryId);
            $qty = $quantityValues[$categoryId];
            $event = AdminEvent::find($ticket->eid);



            if ($ticket && $ticket->number_of_tickets < $qty) {
                return response()->json([
                    'error' => 'Transaction Failed: Insufficient tickets'
                ], 400);
            }

            if ($items == "") {
                $items .= "Event : " . $event->event_name . "; Ticket : " . $ticket->tickets_category . " ; Quantity : " . $qty;
            } else {
                $items .= " , Event : " . $event->event_name . "; Ticket : " . $ticket->tickets_category . " ; Quantity : " . $qty;
            }

            $currency = $ticket->currency;
            $total += $ticket->price * $qty;
        }
        foreach ($seats as $key => $value) {
            $soldOut = SoldOutSeats::where('ticket_id', $key)
                ->where('seat_number', $value)
                ->exists();
            if ($soldOut) {
                return response()->json(['error' => 'Some Seats You Selected are already sold out.'], 400);
            }
        }

        if ($request->cuponId) {
            $coupon = EventCouponList::find($request->cuponId);
            if ($coupon && $coupon->coupon_no) {
                $discountPercentage = $coupon->discount_percentage;
                $discount = ($discountPercentage / 100) * $total;
                $total -= $discount;
            }
        }


        $merchant_id = env('PAYHERE_MERCHANT_ID');
        $merchant_secret = env('PAYHERE_MERCHANT_SECRET');
        $order_id = bin2hex(random_bytes(16));
        $notify_link = env('PAYHERE_NOTIFY_LINK');



        $hash = strtoupper(
            md5(
                $merchant_id .
                $order_id .
                number_format($total, 2, '.', '') .
                $currency .
                strtoupper(md5($merchant_secret))
            )
        );

        return response()->json([
            'total' => $total,
            'hash' => $hash,
            'merchant_id' => $merchant_id,
            'merchant_secret' => $merchant_secret,
            'order_id' => $order_id,
            'items' => $items,
            'currency' => $currency,
            'notify_link' => $notify_link
        ]);
    }






    public function payhereNotify(Request $request)
    {
        $merchant_secret = env('PAYHERE_MERCHANT_SECRET');

        $merchant_id = $request->merchant_id;
        $order_id = $request->order_id;
        $payhere_amount = $request->payhere_amount;
        $payhere_currency = $request->payhere_currency;
        $status_code = $request->status_code;
        $md5sig = $request->md5sig;
        $payment_id = $request->payment_id;

        $custom_data = json_decode($request->custom_1);

        $local_md5sig = strtoupper(
            md5(
                $merchant_id .
                $order_id .
                $payhere_amount .
                $payhere_currency .
                $status_code .
                strtoupper(md5($merchant_secret))
            )
        );

        if (($local_md5sig === $md5sig) and ($status_code == 2)) {



            $data = [
                'total' => $request->captured_amount,
                'firstName' => $custom_data->firstname,
                'lastName' => $custom_data->lastName,
                'nicNumber' => $custom_data->nic,
                'email' => $custom_data->email,
                'phone_no' => $custom_data->phone_no,
                'address' => $custom_data->address,
                'city' => $custom_data->city,
                'postalCode' => $custom_data->postal_code,
                'categoryNames' => json_encode($custom_data->catrgory_names),
                'quantityValues' => json_encode($custom_data->quantity_values),
                'couponId' => $custom_data->coupon_id,
                'couponDiscount' => $custom_data->coupon_discount,
                'couponCode' => $custom_data->couponCode,
                'payment_id' => $payment_id,
                'seats' => $custom_data->seats,
            ];

            $fakeRequest = Request::create('/fake-endpoint', 'POST', parameters: $data);

            $this->userbillingDetailsStore($fakeRequest, $custom_data->event_id, $custom_data->user_id);
        }
    }
}
