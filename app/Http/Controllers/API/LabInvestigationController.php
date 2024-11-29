<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Consultant;
use App\Models\Patient;
use App\Models\Gender;
use App\Models\Payment_mode;
use App\Models\Status;
use App\Models\Test;
use App\Models\Consultant_service_schedule;
use App\Models\Consultant_services;
use App\Models\Consultant_service_schedule_slot;

use App\Models\Slot_time;
use App\Models\days;
use App\Models\Invoice;
use App\Models\InvoiceDetails;
use App\Models\Lab_investigation;
use App\Models\Service;
use App\Models\Appointment;
use Carbon\Carbon;
use Exception;
use Auth;

class LabInvestigationController extends Controller
{
    //
    public function labinvestigations(Request $request)
    {   
        $request->validate([
            'status_id'=>'required',

        ]) ;

        $id=$request->status_id;
        $userid=Auth::user()->id;
            if(!$userid)
            {
                return response()->json([
                    'status_code' => 500,
                    'status' => 0,
                    'message'=>'Unauthorized',
               
                  ]);

            }
            if($id==0)
            {
            	  $labtests=Lab_investigation::where('patient_id',$userid)->whereIn('status_id',[350,351,352])->orderBy('invoice_id')->latest()->get();
            }
            else
            {
            	  $labtests=Lab_investigation::where('patient_id',$userid)->whereIn('status_id',[353,354])->orderBy('invoice_id')->latest()->get();
            }
          
          if(!count($labtests))
          {
            return response()->json([
                'status_code' => 500,
                'status' => 0,
                'message'=>'No Data Found',
           
              ]);
          }
          foreach($labtests as $row)
          {
          	 $row->test=$row->test;
           //  return 1;
             if($row->report_path)
             {
              $row->report=1;
              $row->report_path=asset('assets/images/tests/'.$row->report_path);
             }
             else
             {
              $row->report=0;
             }
              if($row->invoice_id==null)
              {
                  $row->status='pending';
                  $row->invoice_status=0;
              }
              else{
                  if($row->invoice->payment_status_id==50)
                  {
                      $row->status='paid';

                  }
                  else{
                    $row->status='unpaid';
                  }
                   $row->invoice_status=1;
              }
          }
            return response()->json([
                'status_code' => 200,
                'status' => 1,
                'message'=>'List of lab Investigations',
                'labinvestigations' => $labtests,
              ]);
    }

    public function labinvestigation_details(Request $request)
    {
    	  $request->validate([
            'labinvestigation_id'=>'required',

        ]) ;
        $id=$request->labinvestigation_id;
        $userid=Auth::user()->id;
            if(!$userid)
            {
                return response()->json([
                    'status_code' => 500,
                    'status' => 0,
                    'message'=>'Unauthorized',
               
                  ]);

            }
       
         
           $labtest=Lab_investigation::where('id',$id)->first();
            
          
          if(!$labtest)
          {
            return response()->json([
                'status_code' => 500,
                'status' => 0,
                'message'=>'No Data Found',
           
              ]);
          }
        $labtest->test=$labtest->test;
         
              if($labtest->invoice_id==null)
              {
                  $labtest->status='pending';
              }
              else{
                  if($labtest->invoice->payment_status_id==50)
                  {
                      $labtest->status='paid';
                  }
                  else{
                    $labtest->status='unpaid';
                  }
              }
          
            return response()->json([
                'status_code' => 200,
                'status' => 1,
                'message'=>'List of lab Investigations',
                'labinvestigations' => $labtest,
              ]);
    }



    public function all_tests()
    {
      $tests=Test::where('status_id',1)->get();
      if(!count($tests))
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
            'message'=>'List of tests',
            'tests' => $tests,
          ]);
    }


    public function test_invoice_create(Request $request)
    {
      $patient=Auth::user();
      $invoice=new Invoice;

      $invoice->patient_id=$patient->id;


      $invoice->invoice_date=$request->date;

      $invoice->invoice_of_id=202;

      $invoice->payable_amount=$request->total;

      $invoice->total_payable_amount=$request->total;
      $invoice->paid_amt=0;
    
        $invoice->payment_status_id=51;
      $invoice->remaining=$request->total;
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

      if($request->tests!='')
      {

      for($i=0; $i<count($request->tests); $i++)

      { 
         
          $testprice=Test::find($request->tests[$i]);
    
            $lab_investigation=new Lab_investigation;
         
         
            $lab_investigation->patient_id=$patient->id;
            $lab_investigation->invoice_id=$invoice->id;
            $lab_investigation->test_id=$testprice->id;
            $lab_investigation->price=$testprice->rate ;
            $lab_investigation->discount=$testprice->discount_amount;
            $lab_investigation->payable_amount=$testprice->total;
            $lab_investigation->description='test on lab';
            if($invoice->payment_status_id==51)
            {
              $lab_investigation->status_id=350;
            }
             $lab_investigation->consultant_id=null;
               
     
            $lab_investigation->save();
           

         $test=new InvoiceDetails;
    
         $test->test_id=$lab_investigation->test_id;

         $test->patient_id=$request->patient_id;

         $test->invoice_id=$invoice->id;
         $test->lab_investigation_id= $lab_investigation->id;

         $test->price= $testprice->rate;
         $test->discount= $testprice->discount_amount;
       
         $test->qty= 1 ;
         $test->pay_able= $testprice->total ;
         $test->total= $testprice->total;

         $test->save();

    }
}
$InvoiceDetails=InvoiceDetails::where('invoice_id',$invoice->id)->get();

   if(!count($InvoiceDetails))
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
            'message'=>'Test Booked successfully',
            'invoice' =>  $invoice,
            'invoice_details'=>$InvoiceDetails,
          ]);

}

public function labinvestigation_invoice_details(Request $request)
{
 $lab_investigation=Lab_investigation::find($request->labinvestigation_id);

 $invoice=Invoice::where('id',$lab_investigation->invoice_id)->first();
 
 $invoice_details=InvoiceDetails::where('invoice_id',$invoice->id)->get();

  if(!$lab_investigation)
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
            'message'=>'Lab test Invoice',
            'lab_investigation'=>$lab_investigation,
            'invoice' =>  $invoice,
            'invoice_details'=>$invoice_details,
          ]);
      }

      public function cancel_labinvestigation(Request $request)
      {
        $request->validate([
          'investigation_id'=>'required',
        ]);
        $lab_investigation=Lab_investigation::find($request->investigation_id);

        $invoice=Invoice::find($lab_investigation->invoice_id);    
      
        if($invoice)
        {
          if($invoice->payment_status_id==50)
          {
             return response()->json([
            'status_code' => 500,
            'status' => 0,
            'message'=>'You cannot cancel the test due to payment submitted',
       
          ]);

          }
          else
          {
             $invoice_details=InvoiceDetails::where('invoice_id',$invoice->id)->first();
             // return $invoice_details;
             $invoice->payable_amount= $invoice->payable_amount-$invoice_details->total;
             $invoice->total_payable_amount=$invoice->total_payable_amount-$invoice_details->total;
             $invoice->remaining=$invoice->remaining-$invoice_details->total;
             $invoice->save();
             $invoicedetail=InvoiceDetails::where('id',$invoice_details->id)->delete();
              $lab_investigation->invoice_id=null;
              $lab_investigation->status_id=354;
              $lab_investigation->save();

            return response()->json([
            'status_code' => 200,
            'status' => 1,
            'message'=>'Lab test Cancelled successfully',
            'lab_investigation'=>$lab_investigation,
          ]);


          }
        
        }
        else
        {
           return response()->json([
            'status_code' => 500,
            'status' => 0,
            'message'=>'No Invoice Found',
       
          ]);
        }

      }







}
