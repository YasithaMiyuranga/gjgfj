<?php

namespace App\Http\Controllers;

use App\Models\AdminEvent;
use Validator;
use App\Mail\Email;
use App\Models\User;
use App\Models\Employe;
use App\Models\UserTicket;
use App\Http\Helper\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;


class UserController extends Controller
{

    //** FUNCTION TO USER DASHBOARD*/
    function dashboard()
    {
        return view('User.dashboard');
    }

    //** FUNCTION TO USER REGISTER*/
    public function userregister()
    {
        $userTypes = DB::table('users')->get();
        return view('User.register', ['userTypes' => $userTypes]);

    }

    //** FUNCTION TO CREATE USER */
    public function store(Request $request)
    {
        // Validate the user registration request
        $validator = Validator::make($request->all(), [
            'name' => 'string|required',
            'email' => 'email|required|unique:users',
            'password' => 'string|required|min:8',
            'phone_number' => 'string|required|min:10|max:10',
            'confirmation_password' => 'string|required|min:8|same:password',

        ]);

        // Validate the user registration request and return errors if any
        if ($validator->fails()) {

            return redirect()->back()->withErrors(['registerfail' => $validator->errors()->first()])->withInput();
        }

        // Prepare data for user creation
        $data = $request->only('name', 'email', 'phone_number');
        $data['password'] = Hash::make($request->password);

        if ($user = User::create($data)) {

            // Send email verification link
            $user->sendEmailVerificationNotification();

            return redirect()->back()->with('success', 'Verification link has been sent to your email.');

        }


        // $userType = Auth::guard('admin');

        //    if($userType->check()){
        //     return redirect()->route('useradmin.dashboard')->with('success', 'User created successfully!');
        //    }else{
        //     return redirect()->route('user.userdashboard')->with('success', 'User created successfully.');
        //    }

    }

    /**
     * Verify the user email
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verify(Request $request)
    {
        // Find the user with the provided id
        $user = User::find($request->id);

        if ($user != null) {
            // Check if the user is already verified
            if ($user->hasVerifiedEmail()) {
                return redirect('/')->with('success', 'Your email has already been verified.');
            }

            // Mark the email as verified
            if ($user->markEmailAsVerified()) {
                // Log in the user
                Auth::login($user);

                return redirect('/')->with('success', 'Your email has been verified And You Are Now Logged In.');
            }
        } else if ($employee = Employe::find($request->id)) {
            // Check if the  is already verified
            if ($employee->hasVerifiedEmail()) {
                return redirect('/emp/login')->with('success', 'Your email has already been verified.');
            }

            // Mark the email as verified
            if ($employee->markEmailAsVerified()) {
                // Log in the user
                Auth::login($employee);

                return redirect('/emp/login')->with('success', 'Your email has been verified.');
            }
        }

        return redirect()->back()->with('error', 'Invalid verification link.');
    }

    //** FUNCTION TO USER LOGIN*/
    public function userlogin()
    {
        return view('User.login');
    }

    //** FUNCTION TO  DISPLAY USER PROFILE*/
    public function profile()
    {
        // Get the authenticated user
        $user = Auth::user();
        //  Get user buyed tickets tickets

        if ($user) {
            $userTickets = UserTicket::select('user_tickets.*', 'tickets.tickets_category', 'tickets.price', 'tickets.currency', 'ticket_order_lists.quantity', 'events.banner', 'events.event_date','events.start_datetime','events.end_datetime')
                ->join('tickets', 'tickets.id', '=', 'user_tickets.ticket_id')
                ->join('events', 'events.eid', '=', 'user_tickets.event_id')
                ->join('ticket_order_lists', 'ticket_order_lists.id', '=', 'user_tickets.ticket_order_list_id')
                ->where('user_id', $user->id)
                ->orderBy('ticket_order_lists.id', 'desc')
                ->get();
            return view('User.profile', compact('userTickets'));

        } else {
            $events = AdminEvent::where('is_public', '1')->where('event_date', '>=', date('Y-m-d'))->get();

            return view('User.events', compact('events'));

        }

    }

    //** FUNCTION TO UPDATE USER PROFILE  PERSONAL DETAILS*/
    public function updatePersionalDetails(Request $request)
    {
        //  Validate the request
        $data = $request->validate([
            'name' => 'string|required|max:255',
            'email' => 'email|required|regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
            'phone_number' => 'required|regex:/^[0-9]{10}$/',
            'address' => 'string|required',
            'postal_code' => 'string|required|max:255',
            'city' => 'string|required|max:255'
        ]);
        // Get the authenticated user
        $user = User::find(Auth::user()->id);
        // Check if the user is found
        if (!$user) {
            return redirect()->back()->with('error', 'User not found.');
        }
        //  Update user details
        if ($user->update($data)) {
            return redirect()->back()->with('success', 'User updated successfully.');
        } else {
            return redirect()->back()->with('error', 'User not updated.');
        }
    }

    //** FUNCTION TO UPDATE USER PROFILE PASSWORD */
    public function updatePassword(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'emailForm2' => 'required|email',
            'OldPassword' => 'required',
            'NewPassword' => 'required|min:8',
            'confirmePassword' => 'required|same:NewPassword',
        ]);
        // Get the currently authenticated user
        $user = Auth::user();
        // Check if the user is found
        if (!$user) {
            return redirect()->back()->with('error', 'User not found.');
        }
        // Check if the provided old password matches the stored hashed password
        if (!Hash::check($request->OldPassword, $user->password)) {

            // Redirect back with error message display in tab
            return redirect()->back()->with('error', 'The provided password does not match your current password.')->with('tab', 'nav-password');

        }
        //  Check new password and confirm password are same
        if ($validator->fails()) {
            // Redirect back with error message display in tab
            return redirect()->back()->with('error', $validator->errors()->first())->with('tab', 'nav-password');
        }
        // Update the password
        $user->password = Hash::make($request->NewPassword);
        //  Save the user
        if ($user->save()) {
            // Redirect back with a success message
            return redirect()->back()->with('success', 'Password changed successfully!');
        } else {
            return redirect()->back()->with('error', 'Password not changed.');
        }
    }

    //** FUNCTION TO UPDATE USER PROFILE */
    public function updateProfilePicture(Request $request, $id)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()]);
        }

        // Get the authenticated user
        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'User not found.']);
        }

        // Handle image upload if a new image is provided
        if ($request->hasFile('profile_picture')) {
            $image = $request->file('profile_picture');
            $name = time() . '.' . $image->getClientOriginalExtension();
            // Store the image in the 'public/uploads/users' directory
            $path = $image->storeAs('uploads/users', $name, 'public');
            $user->profile_picture = $path;
            $user->save();
        }

        return response()->json(['message' => 'Profile picture updated successfully.']);

    }

    //** FUNCTION TO USER LOGOUT*/
    public function destroy(Request $request, User $user)
    {
        Auth::guard('user')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function userLogout(Request $request, User $user)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }


}
