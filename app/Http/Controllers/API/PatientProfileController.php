<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\VerifyPatient;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerifyMail;
use Exception;
use Hash;
use Auth;

class PatientProfileController extends Controller
{
    //
    public function update_profile(Request $request)
    {
    
   // try{
      $pat=Auth::user();

    $patient = Patient::find($pat->id);
    $request->validate([
        'first_name' => '',
        'last_name' => '',
        'gender_id' => '',
        'cnic' => 'max:13|min:13',
        'phone' => 'max:11|min:11',
        'dob' => '',
        'photo'=>'',
    ]);
    if ($file = $request->file('photo')) 
    {              
        $name = time().$file->getClientOriginalName();
       
        if($patient->image_path != null)
        {
            if (file_exists(public_path().'/assets/images/patients/'.$patient->image_path)) {
                unlink(public_path().'/assets/images/patients/'.$patient->image_path);
            }
        }
        $file->move('assets/images/patients',$name);           
    $data['image_path']= $name;
    }
    // if($request->password)
    // {
    //     $request->validate([
          
    //         'password' => 'confirmed|min:8',
            
    //     ]);
    //     $data['password'] = Hash::make($request->password);
        
    // }
    $data['first_name'] = $request->first_name;
    $data['last_name'] = $request->last_name;
    $data['gender_id']  = $request->gender_id;
    $data['mobile'] = $request->phone;
    $data['cnic'] = $request->cnic;
    $data['dob'] =$request->dob;
  
    $patient->update($data);
    return response()->json([
        'status_code' => 200,
        'status' => 1,
        'img_base'=>asset('assets/images/patients/'),
        'message'=>'Profile is Updated',
        'patients' => $patient,
      ]);
    
    
    // } catch (Exception $error) {
    //   return response()->json([
    //       'status_code' => 500,
    //       'status' => 0,
    //       'message' => "Exception",
       
    //     ]);
    // }
  }
}
