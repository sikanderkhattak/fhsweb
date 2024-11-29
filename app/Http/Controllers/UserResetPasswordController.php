<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserResetPassword;
use App\Models\User;

class UserResetPasswordController extends Controller
{
    //
    public function index()
    {
        //
        return view('user.resetpassword');
    }
    public function sendlink(Request $request)
    {
        $request->validate([
            'email'=>'required|email|exists:users'

        ]);
        $user=Patient::where('email',$request->email)->first();
        $verifyUser = UserResetPassword::create([

            'patient_id' => $user->id,
      
            'reset_token' => sha1(time())
      
          ]);
      
          \Mail::to($user->email)->send(new UserResetPasswordEmail($user));
          return back()->with('status','We Have sent You reset Password Link please see your email to reset password.');
    }
    public function changePassword($_token)
    {
        $user=UserResetPassword::where('reset_token',$_token)->first();
        if($user)
        {
            return view('admin.users.updatepassword',compact('user'));
        }
        return redirect('login')->with('error','Your link is expired Please click reset Password again to reset password');


    }

    public function updatepassword(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|confirmed|min:8',
        ]);
        $user=User::where('id',$request->user_id)->first();
        $user->password=bcrypt($request->password);
        $user->save();

      return redirect('login')->with('feedback','Password has changed, Now You can login with new-password!');
    }
}
