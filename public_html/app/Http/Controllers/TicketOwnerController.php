<?php

namespace App\Http\Controllers;

use App\Models\TicketOwner;
use Illuminate\Http\Request;

class TicketOwnerController extends Controller
{
   
   //***  RETRIVES A LIST OF TICKETS OWNERS*/
   public function ticket_owner_list()
   {
     $ticketOwners=TicketOwner::all();
     return view('',compact('ticketOwners'));
   }

  //*** FUNCTION TO  CREATE A TICKET OWNER */
   public function  ticket_owner_create()
   {
        return view();
   }

   //*** FUNCTION TO STORE A  TICKET OWNER */
   public function ticket_owner_store(Request $request)
   {
      
       //check validate
       $request->validate([
        'user_id' => 'required',
        'event_id' => 'required',
        'event_name' =>'required|string',
        'email' =>'required|string',
        'name' =>'required|string',
        'phone_number' =>'required|string',
        'nic' =>'required|string',
        'city' =>'required|string', 
        'zipcode' =>'required|string',
        'total' =>'nullable|numeric',
    ]);
         
    }

     //*** FUNCTION TO EDIT A SPECIFIC TICKET OWNER */
   public function ticket_owner_edit($id)
   {
     
    
      
   }

   //*** FUNCTI0N TO UPDATE A SPECIFIC TICKET OWNER */
   public function ticket_owner_update(Request $request,$id)
   {
     
     //check validate
     $request->validate([
        'user_id' => 'required|string',
        'event_id' => 'required|string',
        'event_name' =>'required|string',
        'email' =>'required|string',
        'name' =>'required|string',
        'phone_number' =>'required|string',
        'nic' =>'required|string',
        'city' =>'required|string', 
        'zipcode' =>'required|string',
        'total' =>'nullable|numeric',
    ]);

       
      
      
   }

     //*** FUNCTION TO DELETE  OWNER TICKET IN THE SYSTEM ***/
     function ticket_owner_delete($id)
     {
     
      
     }
}
