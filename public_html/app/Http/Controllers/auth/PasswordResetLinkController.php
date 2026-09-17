<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\ResetPasswordMail;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Employe;
use App\Models\Agent;
use App\Models\Manager;
use App\Models\User;



class PasswordResetLinkController extends Controller
{
    /**
     * Show the form for creating a new password reset link.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('auth.forgot-password');
    }
    /**
     * Send a password reset link to the specified email address.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the email
        $validatedData = $request->validate([
            'email' => 'required|email',
        ]);

        try {
            // Initialize variables to null
            $admin = null;
            $employee = null;
            $agent = null;
            $user = null;

            // Find the admin by email
            $admin = Admin::where('email', $validatedData['email'])->first();

            if (!$admin) {
                $employee = Employe::where('email', $validatedData['email'])->first();

                if (!$employee) {

                    $agent = Agent::where('email', $validatedData['email'])->first();

                    if (!$agent) {

                        $user = User::where('email', $validatedData['email'])->first();

                        if (!$user) {

                            $manager = Manager::where('email', $validatedData['email'])->first();

                            if (!$manager) {
                                return back()->withErrors(['email' => 'User not found.'])->withInput($validatedData);
                            }
                        }
                    }
                }
            }

            // Call  the GenerateToken function
            $token = $this->GenerateToken();

            DB::table('password_resets')->insert([

                'email' => $validatedData['email'],
                'token' => $token,
                'created_at' => Carbon::now()

            ]);

            if ($user) {
                $this->sendResetLinkEmail($validatedData['email'], $token, $user);
            } else {
                // Send the reset link using a custom Mailable
                $this->sendResetLinkEmail($validatedData['email'], $token);
            }


            return back()->with('message', 'Password reset link sent!');
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors());
        }
    }
    /**
     * Sends a password reset link to the given email address.
     *
     * @param string $email
     * @param string $token
     *
     * @return void
     */
    protected function sendResetLinkEmail($email, $token, $user = null)
    {
        // check user admin or employee ahgent or user
        if ($user instanceof Admin) {
            $userType = 'admin';
        } elseif ($user instanceof Employe) {
            $userType = 'employee';
        } elseif ($user instanceof Agent) {
            $userType = 'agent';
        } elseif ($user instanceof User) {
            $userType = 'user';
        }elseif($user instanceof Manager){
            $userType = 'manager'; 
        } else {
            $userType = 'unknown';
        }


        if ($userType == 'user') {
            // Create the reset link
            $resetLink = route('password.reset.user', ['token' => $token, 'email' => $email]);

            // Send the email using a custom Mailable
            Mail::to($email)->send(new ResetPasswordMail($resetLink));

            return back()->with('success', 'Password reset link sent!');
        } else {
            // Create the reset link
            $resetLink = url('reset-password/' . $token);

            // Send the email using a custom Mailable
            Mail::to($email)->send(new ResetPasswordMail($resetLink));
        }
    }

    /**
     * Generate a random token used for password reset
     *
     * @return string
     */
    public function GenerateToken()
    {
        return Str::random(64);
    }
}
