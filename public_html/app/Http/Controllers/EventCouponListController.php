<?php

namespace App\Http\Controllers;

use App\Models\AdminEvent;
use App\Models\EventCouponList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EventCouponListController extends Controller
{

    //***  RETRIVES A LIST OF TICKETS COUPON*/
    public function coupon_list()
    {
      $couponList = EventCouponList::with('event')->get();
        return view('Admin_events.coupons.index',compact('couponList'));
    }

    //*** FUNCTION TO  CREATE A COUPON */
    public function  coupon_create()
    {
       //get all events id
       $eventsIds=AdminEvent::whereNotIn('status', ['cancelled', 'completed'])->get();
       return view('Admin_events.coupons.add',compact('eventsIds'));
    }

   //*** FUNCTION TO STORE  A COUPON */
   public function coupon_store(Request $request)
   {

       //check validate
       $validator = Validator::make($request->all(), [
            'event_id' => 'required|exists:events,eid',
            'name' => 'required|string|max:150',
            'coupon_no' =>'required',
            'event_date' =>'required|date',
            'status' => 'required|string|max:20|in:active,inactive',
            'discount_percentage' => 'nullable|numeric',
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

        $coupon = new EventCouponList();
        $coupon->event_id = $request->event_id;
        $coupon->name = $request->name;
        $coupon->coupon_no = $request->coupon_no;
        $coupon->event_date = $request->event_date;
        $coupon->status = $request->status == 'active' ? 'active' : 'inactive';
        $coupon->discount_percentage = $request->discount_percentage;


        if ($coupon->save()) {
            if($request->ajax()){
                return response()->json(['message' => 'Coupon added successfully.'], 200);
            }
        } else {
            if($request->ajax()){
                return response()->json(['message' => 'Failed to add coupon.'], 500);
            }
        }

    }

     //*** FUNCTION TO EDIT A SPECIFIC  COUPON */
   public function coupon_edit($id)
   {

    //find a specific coupon details
    $couponDetails = EventCouponList::where('id', '=', $id)->with('event')->first();
    return view('Admin_events.coupons.edit',compact('couponDetails'));

   }

   //*** FUNCTI0N TO UPDATE A SPECIFIC COUPON */
   public function coupon_update(Request $request, $id)
   {
       // Validate the request data
       $request->validate([
           'event_id' => 'required|exists:events,eid',
           'coupon_name' => 'required|string|max:150',
           'coupon_no' => 'required',
           'event_date' => 'required|date',
           'status' => 'required|string|in:active,inactive',
           'discount_percentage' => 'nullable|numeric',
       ]);

       // Find the coupon by ID
       $coupon = EventCouponList::find($id);

       if (!$coupon) {
           if ($request->ajax()) {
               return response()->json(['message' => 'Coupon not found.'], 500);
           }
       }

       // Update the coupon details
       $updated = $coupon->update([
           'event_id' => $request->event_id,
           'name' => $request->coupon_name,
           'coupon_no' => $request->coupon_no,
           'event_date' => $request->event_date,
           'status' => $request->status == 'active' ? 'active' : 'inactive',
           'discount_percentage' => $request->discount_percentage
       ]);

       // Return the appropriate response based on the update result
       if ($updated) {
           if ($request->ajax()) {
               return response()->json(['message' => 'Event Coupon updated successfully.'], 200);
           }
       } else {
           if ($request->ajax()) {
               return response()->json(['message' => 'Failed to update Event Coupon.'], 500);
           }
       }
   }

   public function coupon_delete_view($id)
    {
       return view('Admin_events.coupons.delete', compact('id'));
    }

    //*** FUNCTION TO DELETE  A SPECIFIC COUPON ***/
    public function coupon_delete($id)
    {

       EventCouponList::where('id','=',$id)->delete();

       return redirect()->route('useradmin.events.ticket.coupon.list')->with('success', 'Coupon deleted successfully!');
     }


     //** FUNCTION TO GET EVENT DATE **/

    public function getEventDate(Request $request)
    {
        $eventId = $request->input('eid');
        $event = AdminEvent::where('eid','=', $eventId)->first();

        if ($event) {


            return response()->json([
                'event_date' => $event->event_date,

            ]);
        } else {
            return response()->json(['error' => 'Event not found'], 404);
        }
    }


    //*** FUNCTION TO APPLY COUPON */
    public function applyCoupon(Request $request,$eid)
    {
        //check coupon code
        $couponCode = $request->input('couponCode');
        //find coupon details
        $coupon = EventCouponList::where('coupon_no', $couponCode)->where('event_id', $eid)->first();



        //check coupon invalid or not
        if ($coupon) {

            if ($coupon->status == 'inactive') {
                return response()->json([
                    'success' => false,
                    'message' => 'Coupon is Expired.'
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Coupon applied successfully!',
                'discountPercentage' => $coupon->discount_percentage,
                'coupon_id' => $coupon->id,

            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Invalid coupon code.'
            ]);
        }

    }
}
