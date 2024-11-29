<?php
namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\Patient;

use App\Models\VerifyPatient;

use Illuminate\Support\Facades\Mail;

use App\Mail\VerifyMail;


use App\Mail\PatientResetPassword1;
use App\Models\PatientResetPassword;
use App\Models\Banner;
use App\Models\Status;

use Exception;

use Hash;

use Auth;



class PatientController extends Controller

{

    //

    public function userlogin(Request $request)

{
    
 try {
  if($request->login_with==1)
  {
 
    $credentials = request(['mr_number', 'password']);
    $user = Patient::where('mr_number', $request->mr_number)->first();


  }
  elseif($request->login_with==2)
  {

    $credentials = request(['mobile', 'password']);
        $user = Patient::where('mobile', $request->mobile)->first();
  }
  else{

    $credentials = request(['email', 'password']);
    $user = Patient::where('email', $request->email)->first();
  }

    if (!Auth::guard('patient')->attempt($credentials)) {

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

      'message'=>'Welcome to IMC',
      'img_base'=>asset('assets/images/patients'),

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

 

    $validator=  $request->validate([

        'first_name' => 'required',

        'last_name' => 'required',  

        'email' => 'required|email|unique:patients', 

        'password' => 'required', 

        'c_password' => 'required|same:password',

      ]);



    // $validator = Validator::make($request->all(), [ 

        

    // ]);

     try {

$input = $request->all(); 

    $input['password'] = bcrypt($input['password']); 

    // do{

    //     $input['mr_number']= sprintf("%06d", mt_rand(1, 999999));

    //     $rand1=Patient::where('mr_number',$input['mr_number'])->first();

    //    } while($rand1);

       $input['reg_date']=date('Y-m-d');
       $input['mr_number']=1;

       $input['status_id']=1;

       unset($input['c_password']);

 

    $user = Patient::create($input); 
     $rand['mr_number']= 'IMC-'.$user->id;
        $patient=Patient::where('id',$user->id)->update($rand);

    $verifyUser = VerifyPatient::create([

      'patient_id' => $user->id,

      'token' => sha1(time())

    ]);

    \Mail::to($user->email)->send(new VerifyMail($user));

    //$user= User::create($request->getAttributes())->sendEmailVerificationNotification();

    if (!$user) {

        return response()->json([

            'status_code' => 500,

            'status' => 0,

            'message' => 'Fails due to server error',

            'user' => $user,

          ]);

     }

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



public function verifyPatient($token)

{

  try {

    $verifyUser = VerifyPatient::where('token', $token)->first();

    if(isset($verifyUser) ){

      $user = $verifyUser->patient;

      if(!$user->verified) {

        $verifyUser->patient->verified = 1;

        $verifyUser->patient->save();

        $status = "Your e-mail is verified. You can now login.";



      } else {

        $status = "Your e-mail is already verified. You can now login.";

      }

    } else {

      return redirect('/patient-login')->with('error', "Sorry your email cannot be identified.");

    }

    return redirect('/patient-login')->with('feedback', $status);

 

    }

    catch (Exception $error) {

    return response()->json([

        'status_code' => 500,

        'status' => 0,

        'message' => "Invalid Link",

    

      ]);

  }

 

  if(isset($verifyUser) ){

    $user = $verifyUser->patient;

    if(!$user->verified) {

      $verifyUser->user->verified = 1;

      $verifyUser->user->save();

      $status = "Your e-mail is verified. You can now login.";

    } else {

      $status = "Your e-mail is already verified. You can now login.";

    }

  } else {

    return redirect('/login')->with('warning', "Sorry your email cannot be identified.");

  }

  return redirect('/login')->with('status', $status);

}

/** 

 * details api 

 * 

 * @return \Illuminate\Http\Response 

 */ 

public function details() 

{ 

  $user = Auth::user();
 


    if (!$user) {

        return response()->json([

            'status_code' => 500,

            'message' => 'Unauthorized',

            'status' => 0,

            'user' => $user,

          ]);

     }

    return response()->json([

        'status_code' => 200,
        'base_path' => asset('assets/images/patients'),

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
    $user=Patient::where('email',$request->email)->first();
   if (!$user) {

        return response()->json([

            'status_code' => 500,

            'message' => 'Wrong Email Address',

            'status' => 0,


          ]);

     }
     
        $verifyUser = PatientResetPassword::create([

            'patient_id' => $user->id,
      
            'reset_token' => sha1(time())
      
          ]);
      

    if (\Mail::to($user->email)->send(new PatientResetPassword1($user))) {

        return response()->json([

            'status_code' => 500,

            'message' => 'Unauthorized',

            'status' => 0,

            'user' => $user,

          ]);

     }

    return response()->json([

        'status_code' => 200,

        'message' => 'Change password link sent on your email',

        'status' => 1,

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


      public function banners()
    {

        $banners = Banner::where('status_id',1)->get();
    
    
     if (!$banners) {

        return response()->json([

            'status_code' => 500,

            'message' => 'No data Found',

            'status' => 0,

          ]);

     }

    return response()->json([

        'status_code' => 200,

        'message' => 'Front Banners',
         'base_link' => asset("/assets/images/banners/"),

        'status' => 1,

        'banners' => $banners,

      ]); 
    }




}

