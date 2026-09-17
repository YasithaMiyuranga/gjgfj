<?php

namespace App\Http\Controllers;

use App\Models\TicketOrderList;
use App\Models\UserTicket;
use Illuminate\Http\Request;
use Validator;
use Vinkla\Hashids\Facades\Hashids;

class TicketOrderListController extends Controller
{

  //***  RETRIVES A LIST OF TICKETS ORDER */
  public function ticket_order_list()
  {
    $ticketOrderList = TicketOrderList::all();
    return view('', compact('ticketOrderList'));
  }

  //*** FUNCTION TO  CREATE A TICKET ORDER */
  public function ticket_order_create()
  {
    return view();
  }

  //*** FUNCTION TO STORE  A TICKET ORDER*/
  public function ticket_order_store(Request $request)
  {

    //check validate
    $request->validate([
      'order_id' => 'required',
      'ticket_user_id' => 'required',
      'coupon_id' => 'required',
      'name' => 'required|string',
      'quantity' => 'required|numeric',
      'discount' => 'required|numeric',
      'amount' => 'required|numeric',
      'coupon_code' => 'required|string',

    ]);

  }

  //*** FUNCTION TO EDIT A SPECIFIC TICKET ORDER */
  public function ticket_order_edit($id)
  {



  }

  //*** FUNCTI0N TO UPDATE A SPECIFIC TICKET ORDER */
  public function ticket_order_update(Request $request, $id)
  {

    //check validate
    $request->validate([
      'order_id' => 'required',
      'ticket_user_id' => 'required',
      'coupon_id' => 'required',
      'name' => 'required|string',
      'quantity' => 'required|numeric',
      'discount' => 'required|numeric',
      'amount' => 'required|numeric',
      'coupon_code' => 'required|string',

    ]);




  }

  //*** FUNCTION TO DELETE  A SPECIFIC TICKET ORDER ***/
  function ticket_order_delete($id)
  {


  }



  function markView()
  {
    return view('Admin_events.tickets.mark');
  }



  function mark(Request $request)
  {
    $validatedData = Validator::make($request->all(), [
      'id' => 'required|string'
    ]);

    if ($validatedData->fails()) {
      return redirect()->back()->withErrors($validatedData)->withInput();
    }

    $decoded = Hashids::decode($request->id);

    if (empty($decoded)) {
      return response()->json(['error' => 'Invalid ID.'], 400);
    }

    $id = $decoded[0];

    $userTicket = UserTicket::where('id', $id)->first();
    if (empty($userTicket)) {
      return response()->json(['error' => 'No Ticket Found'], 400);
    }

    if ($userTicket->ticket_status == 'marked') {
      return response()->json(['error' => 'Ticket Alredy marked'], 400);
    }
    $userTicket->ticket_status = 'marked';

    $userTicket->save();

    return response()->json(['success' => 'Ticket Mark Success.']);


  }
}
