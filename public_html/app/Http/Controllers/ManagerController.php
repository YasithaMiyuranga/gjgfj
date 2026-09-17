<?php

namespace App\Http\Controllers;

use App\Http\Helper\Helper;
use App\Mail\ManagerEmail;
use App\Models\AdminEvent;
use App\Models\JobAmount;
use App\Models\Manager;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class ManagerController extends Controller
{
    public function viewman()
    {
        $viewmanagers = Manager::orderBy('created_at', 'desc')->get();
        return view('Admin_events.managers.viewman', compact('viewmanagers'));
    }


    public function create()
    {
        return view('Admin_events.managers.addmanager');
    }


    public function add()
    {
        return view('Events.addmanager');
    }



    public function check_man_name(Request $request)
    {
        $name = $request->name;
        $check = Manager::where('name', $name)
            ->first();

        if ($check) {
            return response()->json(['exists' => true]);
        } else {
            return response()->json(['exists' => false]);
        }
    }



    public function updates(Request $request, $id)
    {

        Log::info('Update request data:', $request->all());


        $data = $request->validate([
            'name' => 'string|required|max:255',
            'email' => 'email|required',
            'mobile' => 'required|regex:/^[0-9]{10}$/',
            'status' => 'required',
            'regdate' => 'required|date',
            'password' => 'string|nullable',
        ]);




        // Check Manager id check
        if (!Manager::where('manager_id', $id)->exists()) {
            return redirect()->back()->with('error', 'Manager id does not exist.');
        }
        // Check Manager email
        if (Manager::where('email', $request->email)->where('manager_id', '!=', $id)->exists()) {
            return redirect()->back()->with('error', 'Updated email already exists.');
        }
        // check Manager name
        if (Manager::where('name', $request->name)->where('manager_id', '!=', $id)->exists()) {
            return redirect()->back()->with('error', 'Updated name already exists.');
        }
        // Password had change
        if ($data['password'] != null && $data['password'] != '' && $data['email'] != '') {

            $orginalPassword = $data['password'];
            $email = $data['email'];

            // Send password and login email to the Managerr email
            Mail::to($email)->send(new ManagerEmail($data, $orginalPassword));
        }


        $manager = DB::table('managers')->where('manager_id', $id)->first();


        // Email Change but password field is managerty
        if ($data['password'] == null && $data['email'] != $manager->email) {

            $email = $data['email'];
            // Check email is Manager email or not
            if (Manager::where('manager_id', $id)->where('email', '!=', $data['email'])) {

                // Random password
                $randomPassword = Str::random(8);
                // Send password and login email to the Managerr email
                Mail::to($email)->send(new ManagerEmail($data, $randomPassword));

                $data['password'] = $randomPassword;
            }
        }

        $affected = DB::table('managers')
            ->where('manager_id', $id)
            ->update([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $data['password'] != null ? Hash::make($data['password']) : null,
                'mobile' => $data['mobile'],
                'status' => $data['status'],
                'regdate' => $data['regdate']
            ]);

        if ($affected > 0) {
            return back()->with('success', 'Data updated successfully');
        } else {
            return back()->with('error', 'Data not updated');
        }
    }

    public function managerlogin()
    {

        return view('manager.login');
    }
    public function destroy(Request $request, Manager $manager)
    {
        Auth::guard('manager')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/manager/login');
    }


    public function delete($id)
    {

        $manager = Manager::where('manager_id', $id)->first();
        if (!$manager) {
            return redirect()->route('useradmin.viewmanager')->with('error', 'Manager not found.');
        }
        $manager->delete();

        return redirect()->route('useradmin.viewmanager')->with('success', 'Manager deleted successfully.');
    }

    public function edit($id)
    {
        $managers = DB::table('managers')->where('manager_id', $id)->first();

        if ($managers) {
            return view('Admin_events.managers.editmanager', compact('managers'));
        } else {

            return redirect()->route('useradmin.viewmanager');
        }
    }

    public function check_man_email(Request $request)
    {
        $email = $request->email;
        $check = Manager::where('email', $email)
            ->first();

        if ($check) {
            return response()->json(['exists' => true]);
        } else {
            return response()->json(['exists' => false]);
        }
    }

    public function manstore(Request $request)
    {

        $data = $request->validate([
            'name' => 'string|required|max:255',
            'email' => 'email|required',
            'mobile' => 'required|regex:/^[0-9]{10}$/',
            'password' => 'string|required',
            'status' => 'nullable',
            'regdate' => 'nullable',
        ]);


        if (Manager::where('name', $request->name)->exists()) {
            return redirect()->back()->with('error', 'Name already exists.');
        }

        if (Manager::where('email', $request->email)->exists()) {
            return redirect()->back()->with('error', 'Email already exists.');
        }

        // Name capitalize
        $data['name'] = ucfirst($request->name);
        $orginalPassword = $data['password'];
        $data['password'] = Hash::make($request->password);


        if ($manager = Manager::create($data)) {

            Mail::to($data['email'])->send(new ManagerEmail($data, $orginalPassword));

            // Send email verification link
            // $Manager->sendEmailVerificationNotification();

            return redirect()->route('useradmin.viewmanager')->with('success', 'Manager created successfully!');
        } else {
            return redirect()->route('useradmin.viewmanager')->with('failed', 'manager created failed!');
        }
    }




    public function manadd(Request $request)
    {
        $data = $request->validate([
            'name' => 'string|required|max:255',
            'email' => 'email|required',
            'mobile' => 'required|regex:/^[0-9]{10}$/',
            'password' => 'string|required',
            'status' => 'nullable',
            'regdate' => 'nullable',
        ]);

        if (Manager::where('name', $request->name)->exists()) {
            return response()->json(['errors' => ['name' => ['Name already exists.']]], 422);
        }

        if (Manager::where('email', $request->email)->exists()) {
            return response()->json(['errors' => ['email' => ['Email already exists.']]], 422);
        }

        $data['name'] = ucfirst($request->name);
        $orginalPassword = $data['password'];
        $data['password'] = Hash::make($request->password);

        if ($manager = Manager::create($data)) {
            Mail::to($data['email'])->send(new ManagerEmail($data, $orginalPassword));
            return redirect()->route('useradmin.events.view')->with('success', 'Manager created successfully!');
        } else {
            return redirect()->route('useradmin.events.view')->with('failed', 'manager created failed!');
        }
    }



    public function profile(Request $request)
    {
        // Find managerr details
        if (Auth::guard('manager')->check()) {
            $manager_id = Auth::guard('manager')->user()->manager_id;
        }
        $manager = DB::table('managers')->where('manager_id', $manager_id)->first();
        return view('manager.profile', ['man' => $manager]);
    }


    function dashboard()
    {

        $manager = DB::table('managers')->where('manager_id', Auth::guard('manager')->user()->manager_id)->first();
        
        // Get today's date
        $today = Carbon::today()->toDateString();

        
        $todaysEvents = Manager::find($manager->manager_id)
        ->events() // uses the hasMany from Manager model
        ->with('customer') // eager load customer
        ->whereDate('event_date', Carbon::today())
        ->get();

        // Today events count
        $todayEventsCount = count($todaysEvents);

        $allEvents = Manager::find($manager->manager_id)
        ->events()->with('customer')->get(); 


        // Upcoming events count
        $allEventsCount = count($allEvents);

        return view('manager.dashboard', ['manager'=>$manager,'events'=>$allEvents,'allEventCount'=>$allEventsCount,'todayEvents'=>$todaysEvents,'todayEventCount'=>$todayEventsCount]);
    }


    //***MANAGER EVENTS DATE DISPLAY IN CALENDAR */
    public function viewcalender()
    {
        //  Login user details
        $manager_id = Auth::guard('manager')->user()->manager_id;
        //  Find manager details
        $manager = Manager::where('manager_id', $manager_id)->first();

        $managerEvents = Manager::find($manager->manager_id)
        ->events()->with('customer')->get(); 


        return view('manager.manager_events_calender', compact('manager', 'managerEvents'));
    }


    public function updateprofile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|exists:managers,email',
            'mobile' => 'nullable|regex:/^[0-9]{10}$/',
            'image' => 'nullable|image|max:2048|mimes:jpeg,png,jpg,gif,svg,jfif',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $manager = Auth::guard('manager')->user();

        DB::beginTransaction();

        try {
            // Handle image upload if a new image is provided
            if ($request->hasFile('image')) {
                if ($manager->profile_image) {
                    $image_path = public_path($manager->profile_image);

                    if (file_exists($image_path)) {
                        unlink($image_path); // Remove existing image
                    }
                }
                $image = $request->file('image');
                $name = time() . '.' . $image->getClientOriginalExtension();
                $path = Helper::getFileUrl($request->image, 'uploads/managers/');
                $manager->profile_image = $path;
            }


            $manager->update([
                'name' => $request->name,
                'email' => $request->email,
                'mobile' => $request->mobile,
            ]);


            DB::commit();

            return redirect()->back()->with('success', 'Profile Updated Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Profile not updated. Error: ' . $e->getMessage());
        }
    }
    public function updatepassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_password' => 'string|required',
            'new_password' => 'string|required|min:8|Max:255',
            'confirm_password' => 'string|required|min:8|same:new_password',
            'email' => 'email|required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        //check seasion through find manager
        if (Auth::guard('manager')->check()) {
            $manager_id = Auth::guard('manager')->user()->manager_id;
        }

        // Get the currently authenticated user
        $manager = Manager::find($manager_id);


        // Check if the provided old password matches the stored hashed password
        if (!Hash::check($request->old_password, $manager->password)) {

            // Redirect back with error message display in tab
            return redirect()->back()->with('error', 'The provided password does not match your current password.');
        }

        $data['new_password'] = Hash::make($request->new_password);
        //update employee password
        $manager->update([
            'password' => $data['new_password']
        ]);

        return redirect()->back()->with('success', 'Password Updated Successfully');
    }
}
