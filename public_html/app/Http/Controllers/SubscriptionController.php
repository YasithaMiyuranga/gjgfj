<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscription;
use Illuminate\Support\Facades\DB;

class SubscriptionController extends Controller
{
    function subscription(Request $request)
    {
        $request->validate([
            'subscriptionInput1' => 'required|email|unique:subscription,email',
        ]);
        if(Subscription::where('email', $request->subscriptionInput1)->exists()){
            return redirect()->back()->with('message', 'Subscription Already Exists');
        }
        DB::table('subscription')->insert([
            'email' => $request->subscriptionInput1,
        ]);
        return redirect()->back()->with('message', 'Subscription Successful');
    }


    function viewsubscribers()
    {
        $subscribers =  Subscription::all();
        return view('subscription.index',['subscribers' => $subscribers]);
    }
}
