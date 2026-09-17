<?php

namespace App\Http\Controllers\auth;

use Session;
use App\Models\Agent;
use App\Models\Cart;
use App\Models\User;
use App\Models\Admin;
use App\Models\Employe;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Manager;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;


class AuthenticatedSessonController extends Controller
{


    /**
     * Handle an incoming authentication request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */

    public function store(Request $request)
    {
        $email = $request->email;

        $user = Admin::where('email', $email)->first();

        if (!Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {
            // RateLimiter::hit($this->throttleKey());
            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        $request->session()->regenerate();

        $uri = \Request::route()->uri();

        if (Auth::guard('admin')->user()->register_type != 'email') {
            Auth::logout();
            return redirect()->back()->withErrors(['msg' => __('Customer not able to login.')]);
        }

        if ($uri == 'admin/login' && Auth::guard('admin')->user()->type == 'customer') {
            Auth::logout();
            return redirect()->back()->withErrors(['msg' => __('Customer not able to login.')]);
        } elseif ($uri == 'admin/login' && $user->type == 'superadmin') {
            return redirect('useradmin/dashboard');
        } elseif ($uri == 'admin/login' && $user->type == 'admin') {
            return redirect('useradmin/dashboard');
        } else {
            Auth::logout();
            return redirect()->back()->withErrors(['msg' => __('Whoops! Something went wrong.')]);
        }
    }

    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('admin/login');
    }

    //employee.............................................//

    /**
     * Handle an incoming authentication request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */

    public function loginemp(Request $request)
    {

        $email = $request->email;

        $user = Employe::where('email', $email)->first();

        if (!$user) {
            return redirect()->back()->withErrors(['msg' => __('User Not Found.')]);
        }

        // Check this user is active or not
        if ($user->active == 'Inactive') {
            return redirect()->back()->withErrors(['msg' => __('Your account is inactive.')]);
        }

        $admin = Admin::where('email', 'admin@example.com')->first();

        if (!Auth::guard('employee')->attempt(['email' => $request->email, 'password' => $request->password], false)) {

            if (Auth::guard('admin')->attempt(['email' => $admin->email, 'password' => $request->password], false)) {

                Auth::logout();
                Auth::login($user);

                Auth::guard('employee')->login($user);
            } else {
                return redirect()->back()->withErrors(['msg' => __('Login Failed.')]);
            }
        }

        $request->session()->regenerate();

        $uri = $request->route()->uri();

        if ($uri == 'emp/login') {
            // dd(Auth::guard('admin')->user());
            return redirect('employee/empdashboard');
        } else {
            Auth::logout();
            return redirect()->back()->withErrors(['msg' => __('Whoops! Something went wrong.')]);
        }
    }

    //manager.............................................//
    public function loginman(Request $request)
    {
        $email = $request->email;

        $user = Manager::where('email', $email)->first();

        if (!$user) {
            return redirect()->back()->withErrors(['msg' => __('User Not Found.')]);
        }

        if ($user->status == 'Inactive') {
            return redirect()->back()->withErrors(['msg' => __('Your account is inactive.')]);
        }

        // First, try to login the manager with the correct guard
        if (!Auth::guard('manager')->attempt(['email' => $request->email, 'password' => $request->password], false)) {
            return redirect()->back()->withErrors(['msg' => __('Login Failed.')]);
        }

        // Ensure other guards are logged out
        Auth::guard('admin')->logout(); // If needed
        Auth::logoutOtherDevices($request->password); 

        $request->session()->regenerate();

        if ($request->route()->uri() == 'man/login') {
            return redirect('manager/managerdashboard');
        } else {
            Auth::guard('manager')->logout();
            return redirect()->back()->withErrors(['msg' => __('Whoops! Something went wrong.')]);
        }
    }


    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroyemp(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('emp/login');
    }

    public function destroyman(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('manager/login');
    }

    //user......................................................//

    /**
     * Authenticate a user and manage session data for cart.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * This method attempts to authenticate a user using the provided email and password.
     * If successful and the request URI indicates a user login, it retrieves the user's
     * cart data from the database, stores it in the session, and redirects back with a
     * success message. If authentication fails or other conditions are not met, it logs
     * out the user and redirects back with an error message.
     */
    public function loginuser(Request $request)
    {
        $credentials = [
            'email' => $request['login_email'],
            'password' => $request['login_password'],
        ];

        //  Check user Credentials
        if (Auth::attempt($credentials)) {

            // Check user email verified or not
            if (!Auth::user()->hasVerifiedEmail()) {
                Auth::logout();
                return redirect()->back()->withErrors(['loginfailmsg' => __('Your email is not verified.Please verify your email.')])->withInput();
            }

            $uri = $request->route()->uri();

            // Check url
            if ($uri == 'user/login') {
                $userId = Auth::user()->id;

                $user = User::find($userId);

                Auth::guard('user')->login($user);

                // Get cart data from db
                $cartData = Cart::getCartAllData($userId);
                //  Check cart data
                if (!empty($cartData)) {
                    // Set cart data to session
                    Session::put('cart_' . $userId, $cartData);
                }

                return redirect()->back()->with('success', 'User Login Successfully');
            } else {
                Auth::logout();
                return redirect()->back()->with('loginfail', 'User Register Fail!');
            }
        }

        return redirect()->back()->withErrors(['loginfailmsg' => __('Login Failed.')])->withInput();
    }

    /**
     * Logout a user and clear session data.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * This method logs out a user using the Laravel's built-in logout method,
     * invalidates the session, regenerates the session token, and redirects
     * the user to the homepage.
     */
    public function destroyuser(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    //Agent......................................................//

    /**
     * Handle the agent login request.
     *
     * This method validates the agent's credentials and logs them in. It checks
     * if the agent exists, if their account is active, and verifies the password.
     * If the login is successful, the session is regenerated and the agent is
     * redirected to the dashboard. If any check fails, the agent is redirected
     * back with an appropriate error message.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */

    public function loginAgent(Request $request)
    {
        $email = $request->input('email');

        $agent = Agent::where('email', $email)->first();

        if (!$agent) {
            return redirect()->back()->withErrors(['msg' => __('Agent Not Found.')]);
        }

        // Check if the agent is active or not
        if ($agent->status == 'inactive') {
            return redirect()->back()->withErrors(['msg' => __('Your account is inactive.')]);
        }

        // Check password using hash
        if (!Hash::check($request->input('password'), $agent->password)) {
            return redirect()->back()->withErrors(['msg' => __('Login Failed.')]);
        }

        $request->session()->regenerate();

        $uri = $request->route()->uri();

        if ($uri == 'agent/login') {
            Auth::login($agent);
            Auth::guard('agent')->login($agent);
            return redirect()->route('agent.dashboard');
        } else {
            Auth::guard('agent')->logout();
            return redirect()->back()->withErrors(['msg' => __('Whoops! Something went wrong.')]);
        }
    }


    /**
     * Log the agent out and invalidate the session.
     *
     * This function logs the agent out using the 'agent' guard, invalidates
     * the current session, regenerates the session token, and redirects the
     * agent to the login page.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroyAgent(Request $request)
    {
        // Logout the agent
        Auth::guard('agent')->logout();

        // Invalidate the session
        $request->session()->invalidate();

        // Regenerate the session token
        $request->session()->regenerateToken();

        // Redirect to the agent login page
        return redirect('agent/login');
    }
}
