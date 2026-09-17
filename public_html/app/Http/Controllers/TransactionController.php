<?php

namespace App\Http\Controllers;

use App\Models\AdminEvent;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Log;

class TransactionController extends Controller
{
    
    //*** TRANSACTION */

    public function transaction_list()
    {
       
       $events=AdminEvent::with('transactions.user','transactions.agent')->get();
       return view('Admin_events.transactions.index',compact('events'));
    }


    public function show($id)
{
    $event = AdminEvent::with('transactions')->where("eid",$id)->first();
    return view('Admin_events.transactions.show', compact('event'));
}

}
