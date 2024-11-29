<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Models\Consultant;
use App\Models\Patient;
use App\Models\Gender;
use App\Models\Payment_mode;
use App\Models\Status;
use App\Models\Consultant_service_schedule;
use App\Models\Consultant_services;
use App\Models\Consultant_service_schedule_slot;

use App\Models\Slot_time;
use App\Models\days;
use App\Models\Invoice;
use App\Models\Service;
use App\Models\Appointment;
use Carbon\Carbon;
use Exception;
use Auth;

use Illuminate\Http\Request;

class AppointmentController extends Controller
{


 public function checkout(Request $request)
    {
        //
      $request->validate([
        'slot_id'=>'required',
        'date'=>'required',
      ]);
        $user=Auth::user();
        try {
          $slot=Consultant_service_schedule_slot::where('id',$request->slot_id)->first();
          $slot->time=date('h:i a',strtotime($slot->slot_time_from)).' to '.date('h:i a',strtotime($slot->slote_time_to));

          $consultant=Consultant::find($slot->consultant_id);

            $cfee=0;
            $discount=0;
            $payable=0;

       foreach($consultant->services as $fee)

       {

           if($cfee<$fee->fee)

           {

               $cfee=$fee->fee;
               $discount=$fee->discount;
               $payable=$fee->fee-$fee->discount;

           }

       }

        $date=$request->date;

        $patient=Patient::find($user->id);

        $paymentmodes=Payment_mode::all();

        $day=days::where('day',date('l',strtotime($date)))->first();
            
             if(!count($consultant->services))
             {
                 return response()->json([
                    'status_code' => 500,
                    'status' => 0,
                    'message'=>'No Data Found',
                  
                 ]);
             }
            return response()->json([
              'status_code' => 200,
              'status' => 1,
              'img_base'=>asset('assets/images/consultants/'),
              'message'=>'checkout',
               'date'=>$date,
               'day'=>$day,
              'fee'=>$cfee,
              'discount'=>$discount,
              'payable'=>$payable,
              'slot'=>$slot,
              'paymentmodes'=>$paymentmodes,
              'consultant' => $consultant,
              'patient'=>$user,
            ]);
          
          
          } catch (Exception $error) {
            return response()->json([
                'status_code' => 500,
                'status' => 0,
                'message' => "Not logedin",
             
              ]);
          }
    }

    public function book_appointment(Request $request)
    {

        $request->validate([

            'slot_id'=>'required',

            'fee' => 'required',
            'discount'=>'required',
            'payable'=>'required',
            'payment_mode_id'=>'required',
            'appointment_type_id'=>'required',

            'date'=>'required',

        ]);
         $slot=Consultant_service_schedule_slot::where('id',$request->slot_id)->first();

        $consultant=Consultant::find($slot->consultant_id);
        $patient=Auth::user();
         $day=days::where('id',$slot->day_id)->first();
    
          $date=$request->date;
          $fee=$request->fee;
          $discount=$request->discount;
          $payable=$request->payable;



         $invoice=new Invoice;

        $invoice->consultant_id=$consultant->id;

        $invoice->patient_id=$patient->id;

        $invoice->invoice_date=date('Y-m-d');

        $invoice->invoice_of_id=200;

        $invoice->payable_amount=$request->payable;

        $invoice->total_payable_amount=$request->payable;
         $invoice->payment_status_id=51;




        $invoice->save();

        if($invoice->id<1000000)

        {

            $invoice->invoice_no='IMC'.sprintf("%06d", $invoice->id);

        }

       

        elseif($invoice->id<10000000)

        {

            $invoice->invoice_no='INV'.sprintf("%07d", $appointment->id);

        }

         $invoice->save();

        $appointment=new Appointment;

        $appointment->patient_id=$patient->id;

        $appointment->consultant_id=$consultant->id;
        $appointment->payment_mode_id=$request->payment_mode_id;

        $appointment->appointment_type_id=$request->appointment_type_id;

        $appointment->is_live=1;

        $appointment->appointment_date=$request->date;

        $appointment->day_id=$day->id;

        $appointment->service_id=1;

        $appointment->service_schedule_slot_id=$request->slot_id;

        $appointment->time_from=$slot->slot_time_from;

        $appointment->appointment_status_id=100;

        $appointment->time_to=$slot->slote_time_to;

        $appointment->service_fee=$request->fee;

        $appointment->discount=$request->discount;

        $appointment->payable_amount=$request->payable;

        $appointment->invoice_id=$invoice->id;

     

            $appointment->payment_status_id=51;

            $appointment->paid_amount=0;


        $appointment->remaining_amount=$request->payable;
        if($request->appointment_type_id==151)
        {
           $appointment->member_name=$request->member_name; 
           $appointment->member_relation=$request->member_relation; 
           $appointment->age=$request->member_age; 
           $appointment->gender_id=$request->gender_id;
           $appointment->cnic=$request->member_cnic;

           

        }

        $appointment->save();

        if($appointment->id<1000000)

        {

         $appointment->appointment_no='IMC'.sprintf("%06d", $appointment->id);

        }

       

        elseif($appointment->id<10000000)

        {

         $appointment->appointment_no='IMC'.sprintf("%07d", $appointment->id);

        }

         
         if(!$appointment->save())
             {
                 return response()->json([
                    'status_code' => 500,
                    'status' => 0,
                    'message'=>'No Data Found',
                  
                 ]);
             }
            return response()->json([
              'status_code' => 200,
              'status' => 1,
              'img_base'=>asset('assets/images/consultants/'),
              'message'=>'Appointment Booked Successfully',
               'date'=>$date,
               'day'=>$day,
              'fee'=>$fee,
              'discount'=>$discount,
              'payable'=>$payable,
              'slot'=>$slot,
              'consultant' => $consultant,
              'patient'=>$patient,
              'appointment'=>$appointment,
              'invoice'=>$invoice,
            ]);
          
    }

    public function my_tests(Request $request)
    {
        //
        $patient=Auth::user();
        if(!$patient)
        {
          return response()->json([
                    'status_code' => 500,
                    'status' => 0,
                    'message'=>'UnAuthorised',
                  
                 ]);
        }
        try {
          $invoices=Invoice::where('invoice_of_id',202)->where('patient_id',$patient->id)->latest()->get();

             if(!count($invoices))
             {
                 return response()->json([
                    'status_code' => 500,
                    'status' => 0,
                    'message'=>'No Data Found',
                  
                 ]);
             }
            return response()->json([
              'status_code' => 200,
              'status' => 1,
              'message'=>'checkout',
               'invoices'=>$invoices,
              'patient'=>$patient,
            ]);
          
          
          } catch (Exception $error) {
            return response()->json([
                'status_code' => 500,
                'status' => 0,
                'message' => "Not logedin",
             
              ]);
          }
    }

    public function my_medicines(Request $request)
    {
  
         $patient=Auth::user();
        if(!$patient)
        {
          return response()->json([
                    'status_code' => 500,
                    'status' => 0,
                    'message'=>'UnAuthorised',
                  
                 ]);
        }
        try {
          $invoices=Invoice::where('invoice_of_id',201)->where('patient_id',$patient->id)->latest()->get();
            
             if(!count($invoices))
             {
                 return response()->json([
                    'status_code' => 500,
                    'status' => 0,
                    'message'=>'No Data Found',
                  
                 ]);
             }
            return response()->json([
              'status_code' => 200,
              'status' => 1,
              'message'=>'checkout',
               'invoices'=>$invoices,
              'patient'=>$patient,
            ]);
          
          
          } catch (Exception $error) {
            return response()->json([
                'status_code' => 500,
                'status' => 0,
                'message' => "Exception",
             
              ]);
          
    }
  }





}