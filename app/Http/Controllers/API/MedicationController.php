<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Consultant;
use App\Models\Patient;
use App\Models\Gender;
use App\Models\Payment_mode;
use App\Models\Status;
use App\Models\Prescription;
use App\Models\Test;
use App\Models\Consultant_service_schedule;
use App\Models\Consultant_services;
use App\Models\Consultant_service_schedule_slot;
use App\Models\InvoiceDetails;

use App\Models\Slot_time;
use App\Models\days;
use App\Models\Drug;
use App\Models\Invoice;
use App\Models\Medication;
use App\Models\Lab_investigation;
use App\Models\Service;
use App\Models\Appointment;
use Carbon\Carbon;
use Exception;
use Auth;

class MedicationController extends Controller
{
    //
    public function prescribed_medications(Request $request)
    {   
       
        $userid=Auth::user()->id;

            if(!$userid)
            {
                return response()->json([
                    'status_code' => 500,
                    'status' => 0,
                    'message'=>'Unauthorized',
               
                  ]);

            }
       $prescriptions=Prescription::query();
    
        $patient=Patient::where('id',$userid)->first();

        if($patient)
        {

         $prescriptions->where('patient_id',$patient->id);
        }
        $prescriptions=$prescriptions->where('status_id',1)->where('medication_count','>=',0)->latest()->get();

      
          
          if(!count($prescriptions))
          {
            return response()->json([
                'status_code' => 500,
                'status' => 0,
                'message'=>'No Data Found',
           
              ]);
          }
          foreach($prescriptions as $pre)
          {
            $pre->diagnosed_with= strip_tags($pre->diagnosed_with);
            $pre->appointment=  $pre->appointment;
            $pre->consultant=  $pre->consultant;
            $pre->consultant->introduction=  strip_tags($pre->consultant->introduction);
            

          }
         
          
            return response()->json([
                'status_code' => 200,
                'status' => 1,
                'message'=>'List of Prescribed Medications',
                'prescriptions' => $prescriptions,
              ]);
    }

      public function prescribed_medication_details(Request $request)
    {   
       
        $userid=Auth::user()->id;
        $request->validate([
          'prescription_id'=>'required',
        ]);
        $pre_id=$request->prescription_id;

            if(!$userid)
            {
                return response()->json([
                    'status_code' => 500,
                    'status' => 0,
                    'message'=>'Unauthorized',
               
                  ]);

            }

        $pre_medication=Medication::where('prescription_id',$pre_id)->get();

      
          
          if(!count($pre_medication))
          {
            return response()->json([
                'status_code' => 500,
                'status' => 0,
                'message'=>'No Data Found',
           
              ]);
          }
          foreach($pre_medication as $row)
          {
            $row->drug=$row->drug;
          }
          
            return response()->json([
                'status_code' => 200,
                'status' => 1,
                'message'=>'List of Prescribed Medications',
                'medications' => $pre_medication,
              ]);
    }


    public function pendings(Request $request)
    {
    	   $inprocess=Invoice::query();
         $userid=Auth::user()->id;
        $patient=Patient::where('id',$userid)->first();
        if($patient)
        {

         $inprocess->where('patient_id',$patient->id);
        }
        $inprocess=$inprocess->where('invoice_of_id',201)->whereIn('medication_status_id',[250,251])->latest()->get();
        
            if(!$userid)
            {
                return response()->json([
                    'status_code' => 500,
                    'status' => 0,
                    'message'=>'Unauthorized',
               
                  ]);

            }
            
          
          if(!count($inprocess))
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
                'message'=>'List of lab Investigations',
                'inprocess' =>   $inprocess,
              ]);
    }

      public function delivered(Request $request)
    {
         $delivered=Invoice::query();
         $userid=Auth::user()->id;
        $patient=Patient::where('id',$userid)->first();
        if($patient)
        {

         $delivered->where('patient_id',$patient->id);
        }
        $delivered=$delivered->where('invoice_of_id',201)->where('medication_status_id',252)->latest()->get();
        
            if(!$userid)
            {
                return response()->json([
                    'status_code' => 500,
                    'status' => 0,
                    'message'=>'Unauthorized',
               
                  ]);

            }
            
          
          if(!count($delivered))
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
                'message'=>'List of lab Investigations',
                'delivered' =>   $delivered,
              ]);
    }

      public function invoice_medication_details(Request $request)
    {   
       
        $userid=Auth::user()->id;
        $request->validate([
          'invoice_id'=>'required',
        ]);
        $inv_id=$request->invoice_id;
        $invoice=Invoice::find($inv_id);

            if(!$userid)
            {
                return response()->json([
                    'status_code' => 500,
                    'status' => 0,
                    'message'=>'Unauthorized',
               
                  ]);

            }

        $pre_medication=InvoiceDetails::where('invoice_id',$inv_id)->get();

      
          
          if(!count($pre_medication))
          {
            return response()->json([
                'status_code' => 500,
                'status' => 0,
                'message'=>'No Data Found',
           
              ]);
          }
           foreach($pre_medication as $row)
          {
            $row->drug=$row->drug;
          }
          
          
            return response()->json([
                'status_code' => 200,
                'status' => 1,
                'message'=>'List of Prescribed Medications',
                'invoice'=>$invoice,
                'medications' => $pre_medication,
              ]);
    }



    public function all_drugs()
    {
      $drugs=Drug::where('status_id',1)->get();
      if(!count($drugs))
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
            'message'=>'List of drugs',
            'drugs' => $drugs,
          ]);
    }

    public function create_medication_invoice(Request $request)
    {
      $patient=Auth::user();
  
        $invoice=new Invoice;
        $invoice->patient_id=$patient->id;


        $invoice->invoice_date=$request->date;

        $invoice->invoice_of_id=201;
        $invoice->medication_status_id=250;

        $invoice->payable_amount=$request->total_amt;

        $invoice->total_payable_amount=$request->total_amt+$request->delivery_charges;
        $invoice->delivery_type_id=$request->delivery_type;
        if($invoice->delivery_type_id==260)
        {
           $invoice->delivery_charges=0;
           $invoice->delivery_address='Nil';
        }
        else
        {
           $invoice->delivery_charges=$request->delivery_charges;
            $invoice->delivery_address=$request->address;
        }
       

        $invoice->paid_amt=0;
     


       $invoice->payment_status_id=51;
        $invoice->remaining=$invoice->total_payable_amount;
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

        if($request->drug!='')
        {

        for($i=0; $i<count($request->drug); $i++)

        { 
            
            $drug=Drug::find($request->drug[$i]);
            
           $invoice_details=new InvoiceDetails;

           $invoice_details->drug_id=$request->drug[$i];

           $invoice_details->patient_id=$invoice->patient_id;

           $invoice_details->invoice_id=$invoice->id;
  

           $invoice_details->price=$request->price[$i];
         
           $invoice_details->qty=$request->qty[$i];
           $invoice_details->pay_able=$request->total[$i]; 
           $invoice_details->total=$request->total[$i]; 

           $invoice_details->save();



        }

       if(!$invoice)
      {
        return response()->json([
            'status_code' => 500,
            'status' => 0,
            'message'=>'No Data Found',
       
          ]);
      }
      $invoice_detail=InvoiceDetails::where('invoice_id',$invoice->id)->get();

        return response()->json([
            'status_code' => 200,
            'status' => 1,
            'message'=>'List of drugs',
            'invoice' => $invoice,
            'invoice_detail'=>$invoice_detail,
          ]);
}

}
}
