<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;
use DB;
use App\Models\Admin;
use App\Models\Employe;
use App\Models\Agent;
use App\Models\Manager;
use App\Models\User;

class NewPasswordController extends Controller
{
    /**
     * Handle an incoming new password request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => ['required', 'confirmed'],
        ]);

        // Find the admin by email
        $admin = Admin::where('email', $validatedData['email'])->first();

        if (!$admin) {
            $employee = Employe::where('email', $validatedData['email'])->first();

            if (!$employee) {

                $agent = Agent::where('email', $validatedData['email'])->first();

                if (!$agent) {

                    $user = User::where('email', $validatedData['email'])->first();

                    if (!$user) {

                      $manager=Manager::where('email', $validatedData['email'])->first();
                      if(!$manager){
                        return back()->withErrors(['email' => 'User not found.']);
                      }
                    }
                }
            }


        }

        $updatePassword = DB::table('password_resets')
                            ->where([
                            'email' => $request->email,
                            'token' => $request->token
                            ])->first();

          if(!$updatePassword){
              return back()->withInput()->with('error', 'Invalid token!');
          }

          if ( $admin )
          {
            $user = Admin::where('email', $validatedData['email'])
                        ->update(['password' => Hash::make($request->password)]);
            DB::table('password_resets')->where(['email'=> $request->email])->delete();

            return redirect('/admin/login')->with('message', 'Your password has been changed!');
          }
          if ( $employee )
          {
            $user = Employe::where('email', $validatedData['email'])
                        ->update(['password' => Hash::make($request->password)]);
            DB::table('password_resets')->where(['email'=> $request->email])->delete();

            return redirect('/emp/login')->with('message', 'Your password has been changed!');
          }
          if( $agent )
          {
            $user = Agent::where('email', $validatedData['email'])
                        ->update(['password' => Hash::make($request->password)]);
            DB::table('password_resets')->where(['email'=> $request->email])->delete();

            return redirect('/agent/login')->with('message', 'Your password has been changed!');
          }
          if( $user )
          {
            $user = User::where('email', $validatedData['email'])
                        ->update(['password' => Hash::make($request->password)]);
            DB::table('password_resets')->where(['email'=> $request->email])->delete();

              return redirect('/Home')->with('success', 'Your password has been changed!');
          }
          if( $manager )
          {
            $manager = Manager::where('email', $validatedData['email'])
                        ->update(['password' => Hash::make($request->password)]);
            DB::table('password_resets')->where(['email'=> $request->email])->delete();

              return redirect('/manager/login')->with('success', 'Your password has been changed!');
          }


    }
}
