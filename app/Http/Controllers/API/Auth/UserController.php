<?php
namespace App\Http\Controllers\API\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserResetPassword;
use Illuminate\Support\Facades\Mail;
use App\Models\VerifyUser;

use App\Mail\VerifyMail;


use App\Mail\UserResetPasswordEmail;
use Hash;
use Auth;

use Exception;


class UserController extends Controller
{
    //
    public function login(Request $request)
    {
    $request->validate([
        'name'=>'required',
        'email'=>'required|email',
        
    ]);
        
     try {
     
    
        $credentials = request(['email', 'password']);
        $user = User::where('email', $request->email)->first();
    
        if (!Auth::attempt($credentials)) {
    
          return response()->json([
    
            'status_code' => 500,
    
            'status' => 0,
    
            'message' => 'Wrong credentials'
    
          ]);
    
        }
    
        if ( ! Hash::check($request->password, $user->password, [])) {
    
           throw new \Exception('Error in Login');
    
        }
    
        $tokenResult = $user->createToken('authToken')->plainTextToken;
    
        return response()->json([
    
          'status_code' => 200,
    
          'status' => 1,
    
          'verified'=>$user->verified,
    
          'message'=>'Welcome user',
          'img_base'=>asset('assets/images/users'),
    
          'access_token' => $tokenResult,
    
          'token_type' => 'Bearer',
    
          'user' => $user,
    
        ]);
    
      } catch (Exception $error) {
    
        return response()->json([
    
            'status_code' => 500,
    
            'status' => 0,
    
            'message' => "",
    
          
    
          ]);
    
      }
    
    }
    
    
    
    public function register(Request $request) 
    
    { 

         try {
            $validator=  $request->validate([
    
                'name' => 'required',
        
                'email' => 'required|email|unique:users', 
        
                'password'=>'required|confirmed'
        
                // 'c_password' => 'required|same:password',
        
              ]);
             $user=new User;
    
            $user->password = bcrypt($request->password);
            $user->name=$request->name;
            $user->email=$request->email;
            $user->save(); 
    
         $verifyUser = new VerifyUser;
    
         $verifyUser->user_id=$user->id;
    
           $verifyUser->token= sha1(time());
    
         $verifyUser->save();
    
         \Mail::to($user->email)->send(new VerifyMail($user));
    
        // $user= User::create($request->getAttributes())->sendEmailVerificationNotification();
    
        if (!$user) {
    
            return response()->json([
    
                'status_code' => 500,
    
                'status' => 0,
    
                'message' => 'Fails due to server error',
    
              ]);
    
         }
         $user=User::find($user->id);
    
         $tokenResult = $user->createToken('authToken')->plainTextToken;
    
         return response()->json([
    
           'status_code' => 200,
    
           'status' => 1,
    
           'message' => 'Check your email for verification',
    
           'access_token' => $tokenResult,
    
           'token_type' => 'Bearer',
    
           'user' => $user,
    
         ]);
    
      }catch (Exception $error) {
    
        return response()->json([
    
            'status_code' => 500,
    
            'status' => 0,
    
            'message' => "Validation error",
    
      
    
          ]);
    
      }
    
    }

public function details() 

{ 

  $user = Auth::user();
 


    if (!$user) {

        return response()->json([

            'status_code' => 500,

            'message' => 'Unauthorized',

            'status' => 0,


          ]);

     }

    return response()->json([

        'status_code' => 200,
        'base_path' => asset('assets/images/users'),

        'message' => 'User Profile data',

        'status' => 1,

        'user' => $user,

      ]); 

   

}

public function forget_password(Request $request) 
{ 

  $request->validate([
    'email'=>'required|email',
  ]);
    $user=User::where('email',$request->email)->first();
   if (!$user) {

        return response()->json([

            'status_code' => 500,

            'message' => 'Wrong Email Address',

            'status' => 0,


          ]);

     }
     
        $verifyUser =new UserResetPassword;

        $verifyUser->user_id= $user->id;
      
        $verifyUser->reset_token = sha1(time());
      
        $verifyUser->save();
      

    if (\Mail::to($user->email)->send(new UserResetPasswordEmail($user))) {

        return response()->json([

            'status_code' => 500,

            'message' => 'Unauthorized',

            'status' => 0,

          ]);

     }

    return response()->json([

        'status_code' => 200,

        'message' => 'Change password link sent on your email',

        'status' => 1,
        'email'=>$user->email,

      ]); 

   

}


    public function updatePassword(Request $request)
    {

        if(!$user=Auth::user())

        {

           return response()->json([

            'status_code' => 500,

            'message' => 'UnAuthorization',

            'status' => 0,

          ]);

        }

        $data=$request->validate([

            'old_password'=>'required',

            'password'=>'required|confirmed',

        ]);


        if(!Hash::check($request->old_password,$user->password))

        {

          return response()->json([

            'status_code' => 500,

            'message' => 'You entered wrong Password',

            'status' => 0,

          ]);

        }

        $patient=Patient::find($user->id);

        $patient->password=bcrypt($request->password);

         $patient->save();

        return response()->json([

        'status_code' => 200,

        'message' => 'Your password is updated',

        'status' => 1,

        'user' => $patient,

      ]); 


    }

    public function change_password(Request $request)
    {
        $request->validate([
        'current_password' => 'required|min:8',
        'password' => 'required|string|confirmed|min:8',
        ]);
        $user = User::where('email', '=', Auth::user()->email)->first();
        if(!$user)
        {
            return response()->json([

                'status_code' => 500,
    
                'message' => 'UnAuthorized',
    
                'status' => 0,
    
              ]);
    
        }

        if(Hash::check($request->current_password, $user->password))
        {
            $user->password=bcrypt($request->password);
            $user->save();
            return response()->json([

                'status_code' => 200,
        
                'message' => 'Your password is updated Successfully',
        
                'status' => 1,
        
                'user' => $user,
        
              ]); 
        }
        else
        {
            return response()->json([

                'status_code' =>500,
        
                'message' => 'Old password is Incorrect',
        
                'status' => 0,
        
        
              ]); 
        }
      
    }
    
    public function update_profile(Request $request)
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
          
                if (file_exists(asset('/assets/images/users/'.$user->photo))) {
                    unlink(asset('/assets/images/users/'.$user->photo));
                }
            }
            $file->move('assets/images/users',$name);           
        $user->photo= $name;
        }
        if($user->save())
        {
            return response()->json([

                'status_code' => 200,
                'base_path'=>asset('/assets/images/users/'),
        
                'message' => 'Your profile is updated Successfully',
        
                'status' => 1,
        
                'user' => $user,
        
              ]); 
        }
        else{
            return response()->json([

                'status_code' => 500,
        
                'message' => 'There is some error to update your profile prlease try again',
        
                'status' => 0,
        
              ]); 
        }

    
}
}
