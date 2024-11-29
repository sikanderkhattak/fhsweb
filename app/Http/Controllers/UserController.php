<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\VerifyUser;
use Auth;
use App\Models\Status;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Hash;
use DB;
use Carbon\Carbon;

class UserController extends Controller
{
    //
    public function index()
    {
     //will return true, if user has role
     //   dd($user->givePermissionsTo('create-tasks'));// will return permission, if not null

        $users=User::all();
  
        return view('admin.users.index',compact('users'));
    }
    public function change_password()
    {
       return view('admin.users.change-password');
    }
    public function change_password_store(Request $request)
    {
        $request->validate([
        'current' => 'required|min:8',
        'password' => 'required|string|confirmed|min:8',
        ]);
        $user = User::where('email', '=', Auth::user()->email)->first();

        if(Hash::check($request->current, $user->password))
        {
            $user->password=bcrypt($request->password);
            $user->save();
            return redirect('dashboard')->with('feedback','Password has changed successfully');
        }
        else
        {
            return back()->with('error','Current password is wrong');
        }
      
    }
    
      public function update_profile()
    {
        $user=Auth::user();
        return view('admin.users.update-profile',compact('user'));
    }
    public function update_profile_store(Request $request)
    {
        $user=User::find(Auth::user()->id);
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $user->name=$request->name;

        if ($file = $request->file('photo')) 
        {             
            $name = time().$file->getClientOriginalName();
           
            if($user->photo != null)
            {
                if (file_exists(public_path().'/assets/images/users/'.$user->photo)) {
                    unlink(public_path().'/assets/images/users/'.$user->photo);
                }
            }
            $file->move('assets/images/users',$name);           
        $user->photo= $name;
        }
        if($user->save())
        {
            return back()->with('feedback','Profile is updated');
        }
        else{
            return back()->with('error','There are some error to update your profile please try again later');
        }

    }

    public function create()
    {
        $statuses=Status::where('details','Record Status')->get();
        $roles = Role::pluck('name','name')->all();
        return view('admin.users.create',compact('statuses','roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
            'status_id'=>'required',
            'roles' => 'required',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'status_id' => $request->status_id,
            'password' => Hash::make($request->password),
        ]);
        $user->assignRole($request->input('roles'));

     return redirect('users')->with('feedback','New User is Created Successfully');
    }

    public function edit(Request $request)
    {
        $roles = Role::pluck('name','name')->all();
        $user=User::find($request->user_id);
        $userRole = $user->roles->pluck('name','name')->all();
        $statuses=Status::where('details','Record Status')->get();
        return view('admin.users.update',compact('statuses','user','userRole','roles'));
    }
    public function update(Request $request)
    {

          $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'confirmed',
            'role'=>'',
        ]);
        if($request->password)
        {
            $data['password'] = Hash::make($request->password);
            
        }
        $data['name'] = $request->name;
        $data['email'] =$request->email;
        $data['status_id']  = $request->status_id;
        $user = User::find($request->id);
        $user->update($data);
        DB::table('model_has_roles')->where('model_id',$request->id)->delete();
    
        $user->assignRole($request->input('roles'));
     return redirect('users')->with('feedback','User is Updated Successfully');
    }

    public function verifyUser($token)

{



    $verifyUser = VerifyUser::where('token', $token)->first();

    if(isset($verifyUser) ){
    
      $user = $verifyUser->user;
      if(!$user->email_verify_status) {

        $verifyUser->user->email_verify_status = 1;
        $verifyUser->user->email_verified_at = Carbon::now();

        $verifyUser->user->save();

        $status = "Your e-mail is verified. You can now login.";



      } else {

        $status = "Your e-mail is already verified. You can now login.";

      }

    } else {

      return redirect('/login')->with('error', "Sorry your email cannot be identified.");

    }

    return redirect('/login')->with('feedback', $status);

 

    }
    
}
