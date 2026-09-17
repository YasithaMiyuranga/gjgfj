<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class AgentController extends Controller
{
    /**
     * Display the agent dashboard view.
     *
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        return view('Agent.dashboard');
    }

    /**
     * Display the agent profile view.
     *
     * @return \Illuminate\View\View
     */
    public function profile()
    {
        return view('Agent.profile');
    }

    /**
     * Update the agent password.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatepassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_password' => 'string|required|exists:agents,',
            'new_password' => 'string|required|min:8|Max:255',
            'confirm_password' => 'string|required|min:8|same:new_password',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Check seasion through find agent
        if (Auth::guard('agent')->check()) {
            $agent = Agent::find(Auth::guard('agent')->user()->id);
            if (!Hash::check($request->old_password, $agent->password)) {
                // Redirect back with error message display in tab
               return redirect()->back()->with('error', 'The provided password does not match your current password.');
            } else {
                $agent->password = Hash::make($request->new_password);
                $agent->save();
                return redirect()->back()->with('success', 'Password updated successfully');
            }
        }
    }

    /**
     * Update the agent profile.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateprofile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|exists:agents,email',
            'phone_number' => 'required|regex:/^[0-9]{10}$/',
            'agent_type' => 'string|required|max:50',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $agent = Auth::guard('agent')->user();
        $agent->name = $request->name;
        $agent->email = $request->email;
        $agent->phone = $request->phone_number;
        $agent->type = $request->agent_type;

        if( $agent->save() ) {
            return redirect()->back()->with('success', 'Profile updated successfully');
        }
        else {
            return redirect()->back()->with('error', 'Profile update failed');
        }
    }

    /**
     * Display the agent events view.
     *
     * Only shows the events that belongs to the current agent.
     *
     * @return \Illuminate\View\View
     */
    public function events()
    {
       // Only get the agent's events
        $agent_events = Agent::where('id', Auth::guard('agent')->user()->id)->get();
        return view('Agent.events.index', compact('agent_events'));
    }

    /**
     * Display the agent tickets view.
     *
     * @return \Illuminate\View\View
     */

    public function tickets()
    {
        return view('Agent.ticket.index');
    }
    /**
     * Display the agent profit view.
     *
     * @return \Illuminate\View\View
     */
    public function profit()
    {
        return view('Agent.profit.index');
    }
    /**
     * Display the agent offers view.
     *
     * @return \Illuminate\View\View
     */
    public function offers()
    {
        return view('Agent.offers.index');
    }
    /**
     * Display the agent login view.
     *
     * @return \Illuminate\View\View
     */
    public function agentLogin()
    {
        return view('Agent.login');
    }

    /**
     * Logout the agent and invalidate the session.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Agent $agent
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, Agent $agent)
    {
        // Logout the agent
        Auth::guard('agent')->logout();

        // Invalidate the session
        $request->session()->invalidate();

        // Regenerate the session token
        $request->session()->regenerateToken();

        // Redirect to the agent login page
        return redirect('/agent/login');
    }
}
