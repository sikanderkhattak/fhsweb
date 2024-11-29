<?php
namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Banner;
use App\Models\Status;

use App\Models\Consultant;
use App\Models\Patient;
use App\Models\Gender;
use App\Models\Payment_mode;
use App\Models\Test;
use App\Models\Consultant_service_schedule;
use App\Models\Consultant_services;
use App\Models\Consultant_service_schedule_slot;
use App\Models\Slot_time;
use App\Models\days;
use App\Models\Invoice;
use App\Models\Prescription;
use App\Models\InvoiceDetails;
use App\Models\Lab_investigation;
use App\Models\Service;
use App\Models\Appointment;
use Carbon\Carbon;
use Exception;
use Auth;
use DB;
class FrontController extends Controller
{
	  public function index()
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

        'status' => 1,

        'user' => $banners,

      ]); 
    }

    public function myimc()
    {
      $patient=Auth::user();


      if(!$patient)
      {
        return response()->json([
            'status_code' => 500,
            'status' => 0,
            'message'=>'UnAuthorized',
       
          ]);
      }
      // $medications = DB::table('invoice_details')->where('drug_id','!=',null)->where('patient_id',$patient->id)
      //           ->groupBy('invoice_id')
      //           // ->having('account_id', '>', 100)
      //           ->get();
      //           return $medications;

      $medications=InvoiceDetails::where('drug_id','!=',null)->where('patient_id',$patient->id)->orderBy('created_at','desc')->groupBy('drug_id')->get();
      foreach($medications as $row)
      {
        $row->drug=$row->drug;
        $row->invoice=$row->invoice;
      }

      $mylabinvestigations=Lab_investigation::where('patient_id',$patient->id)->orderBy('created_at','desc')->whereIn('status_id',[353])->get();
      foreach($mylabinvestigations as $row)
      {
        $row->test=$row->test;
      }

        return response()->json([
            'status_code' => 200,
            'status' => 1,
            'message'=>'My IMC',
            'profile_image_base'=>asset('assets/images/patients/'),
            'test_base_link'=>asset('assets/images/tests/'),
            'patient'=>$patient,
            'medications' => $medications,
            'labinvestigations'=>$mylabinvestigations,
          ]);


    }
    public function my_drugs()
    {
        $patient=Auth::user();
    
   

       if(!$patient)
      {
        return response()->json([
            'status_code' => 500,
            'status' => 0,
            'message'=>'UnAuthorized',
       
          ]);
      }

          $medications=InvoiceDetails::where('drug_id','!=',null)->where('patient_id',$patient->id)->orderBy('created_at','desc')->get();
      foreach($medications as $row)
      {
        $row->drug=$row->drug;
        $row->invoice=$row->invoice;
      }

           return response()->json([
            'status_code' => 200,
            'status' => 1,
            'message'=>'My Drugs',
            'profile_image_base'=>asset('assets/images/patients/'),
            'test_base_link'=>asset('assets/images/tests/'),
            'patient'=>$patient,
            'medications' => $medications,
    
          ]);
    }

     public function my_medical_history()
    {
        $patient=Auth::user();
    
   

       if(!$patient)
      {
        return response()->json([
            'status_code' => 500,
            'status' => 0,
            'message'=>'UnAuthorized',
       
          ]);
      }

          $my_medical_history= $medical_history=DB::table('patient_medical_history')->where('patient_id',$patient->id)->get();
      if(!count($my_medical_history))
      {
        return response()->json([
            'status_code' => 500,
            'status' => 0,
            'message'=>'NO history found',
       
          ]);
      }
    
           return response()->json([
            'status_code' => 200,
            'status' => 1,
            'message'=>'My Medical History',

            'history'=>$my_medical_history,
           
    
          ]);
    }
	
}