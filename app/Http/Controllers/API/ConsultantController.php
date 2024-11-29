<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Models\Consultant;
use App\Models\Gender;
use App\Models\Status;
use App\Models\Consultant_service_schedule;
use App\Models\Consultant_services;
use App\Models\Consultant_service_schedule_slot;

use App\Models\Slot_time;
use App\Models\days;
use App\Models\Service;
use App\Models\Appointment;
use Carbon\Carbon;
use App\Models\Invoice;
use App\Models\InvoiceDetails;

use Auth;

use Illuminate\Http\Request;

class ConsultantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        
        try {
            $consultants=Consultant::where('status_id',1)->get();
            
             if(!count($consultants))
             {
                 return response()->json([
                    'status_code' => 500,
                    'status' => 0,
                    'message'=>'No Data Found',
                  
                 ]);
             }
             foreach($consultants as $consultant)
             {
              $consultant->introduction=  strip_tags($consultant->introduction);
              $consultant->introduction= str_replace("\xc2\xa0",' ',$consultant->introduction);
              $i=0;
               foreach($consultant->services as $service)
               {
                $ser[$i]=$service->name;
                $i++;
               }
               $consultant->service= implode(', ', $ser);
             }
            return response()->json([
              'status_code' => 200,
              'status' => 1,
              'img_base'=>asset('assets/images/consultants/'),
              'message'=>'list of consultants',
              'consultants' => $consultants,
            ]);
          
          
          } catch (Exception $error) {
            return response()->json([
                'status_code' => 500,
                'status' => 0,
                'message' => "Not logedin",
             
              ]);
          }
    }

    public function details($id)
    {
        //

        
        try {
            $consultant=Consultant::find($id);
             $consultant->introduction=  strip_tags($consultant->introduction);
             $nbsp = html_entity_decode("&nbsp;");
              $s = html_entity_decode("[&nbsp;]");
              $consultant->introduction= str_replace($nbsp, " ",$consultant->introduction);
              //return $consultant->introduction;
        
             //$consultant->introduction=str_replace("\xc2\xa0",' ',$consultant->introduction);
            $consultant->services=$consultant->services;

            
             if(!$consultant)
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
              'message'=>'list of consultants',
              'consultant' => $consultant,
  
           
            ]);
          
          
          } catch (Exception $error) {
            return response()->json([
                'status_code' => 500,
                'status' => 0,
                'message' => "Exception",
             
              ]);
          }
    }

      public function consultant_schedule(Request $request)
    {
        //
        $request->validate([
            'consultant_id'=>'required'
        ]);

           
        
        try {
            $consultant=Consultant::find($request->consultant_id);
            //$consultantSchedules=Consultant_service_schedule::where('consultant_id',$consultant->id)->get();

            $days=days::all();
            $now=Carbon::now();
            //return date('Y-d-m H:i:s');

            $dates[0]=$now;
            $s=0;

            for($i=0; $i<7; $i++)
            {
                $day[$i]=days::where('day',date('l',strtotime(Carbon::now()->addDay($i))))->first();
                if($day[$i])
                {
                    $consultantSch=Consultant_service_schedule::where('consultant_id',$consultant->id)->where('day_id',$day[$i]->id)->first();
                    if($consultantSch) 
                    {
                        $consultantSch->day=date("l",strtotime(Carbon::now()->addDay($i)));
                        $consultantSch->date=date("Y-m-d",strtotime(Carbon::now()->addDay($i)));
                        $consultantSch->time=date('h:i a',strtotime($consultantSch->time_from)). " to " . date('h:i a',strtotime($consultantSch->time_to));
                        $consultantSchedules[$s++]=$consultantSch;
                    }
                }

              
             $dates[$i]=Carbon::now()->addDay($i);
             $days[$i]=date('l',strtotime($dates[$i]));
            }
       $object = (object) $consultantSchedules;
            $dayOfTheWeek = Carbon::now()->dayOfWeek;

      

            
             if(!$consultant)
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
              'message'=>'list of consultants',
              'consultant' => $consultant,
              'schedule'=>$object,
            ]);
          
          
          } catch (Exception $error) {
            return response()->json([
                'status_code' => 500,
                'status' => 0,
                'message' => "Exception",
             
              ]);
          }
    }

    public function consultant_schedule1(Request $request)
    {
        //
        $request->validate([
            'consultant_id'=>'required'
        ]);

          for($i=0; $i<7; $i++)
            {
          //  $day[$i]=days::where('day',date('l',strtotime(Carbon::now()->addDay($i))))->first();
                
             $dates[$i]=Carbon::now()->addDay($i);
            $daysOfTheWeek[$i] = Carbon::now()->addDay($i)->dayOfWeek+1;
             $days[$i]=date('l',strtotime($dates[$i]));
            }

           
        
        try {
            $consultant=Consultant::find($request->consultant_id);
            $consultant->introduction=strip_tags($consultant->introduction);
             $nbsp = html_entity_decode("&nbsp;");
              $s = html_entity_decode("[&nbsp;]");
              $consultant->introduction= str_replace($nbsp, " ",$consultant->introduction);
                $consultant->services=$consultant->services;

                 $i=0;
               foreach($consultant->services as $service)
               {
                $ser[$i]=$service->name;
                $i++;
               }
               $consultant->service= implode(', ', $ser);

        
             //$consultant->introduction=str_replace("\xc2\xa0",' ',$consultant->introduction);
            $consultantSchedules=Consultant_service_schedule::where('consultant_id',$consultant->id)->get();
            foreach($consultantSchedules as $schedule)
            {
                    if($schedule->day_id== $daysOfTheWeek[0])
                    {
                        $schedule->day=$days[0];
                        $schedule->date=date('l',strtotime($dates[0]));
                           $schedule->time=date('h:i a',strtotime($schedule->time_from)). " to " . date('h:i a',strtotime($schedule->time_to));
                    }
                      if($schedule->day_id== $daysOfTheWeek[1])
                    {
                        $schedule->day=$days[1];
                        $schedule->date=date('l',strtotime($dates[1]));
                         $schedule->time=date('h:i a',strtotime($schedule->time_from)). " to " . date('h:i a',strtotime($schedule->time_to));
                    }
                      if($schedule->day_id==$daysOfTheWeek[2])
                    {
                        $schedule->day=$days[2];
                        $schedule->date=date('l',strtotime($dates[2]));
                         $schedule->time=date('h:i a',strtotime($schedule->time_from)). " to " . date('h:i a',strtotime($schedule->time_to));
                    }
                      if($schedule->day_id== $daysOfTheWeek[3])
                    {
                        $schedule->day=$days[3];
                        $schedule->date=date('l',strtotime($dates[3]));
                         $schedule->time=date('h:i a',strtotime($schedule->time_from)). " to " . date('h:i a',strtotime($schedule->time_to));
                    }
                      if($schedule->day_id== $daysOfTheWeek[4])
                    {
                        $schedule->day=$days[4];
                        $schedule->date=date('l',strtotime($dates[4]));
                         $schedule->time=date('h:i a',strtotime($schedule->time_from)). " to " . date('h:i a',strtotime($schedule->time_to));
                    }
                      if($schedule->day_id== $daysOfTheWeek[5])
                    {
                        $schedule->day=$days[5];
                        $schedule->date=date('l',strtotime($dates[5]));
                         $schedule->time=date('h:i a',strtotime($schedule->time_from)). " to " . date('h:i a',strtotime($schedule->time_to));
                    }
                      if($schedule->day_id== $daysOfTheWeek[6])
                    {
                        $schedule->day=$days[6];
                        $schedule->date=date('l',strtotime($dates[6]));
                         $schedule->time=date('h:i a',strtotime($schedule->time_from)). " to " . date('h:i a',strtotime($schedule->time_to));
                    }
                 


            }

             if(!$consultant)
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
              'message'=>'list of consultants',
              'consultant' => $consultant,
              'schedule'=> $consultantSchedules,
            ]);
          
          
          } catch (Exception $error) {
            return response()->json([
                'status_code' => 500,
                'status' => 0,
                'message' => "Exception",
             
              ]);
          }
    }


        public function pick_slot(Request $request)
            {
                   $request->validate([
                        'consultant_id'=>'required',
                         'date'=>'required'
                    ]);

                   $dayId=date('w',strtotime($request->date))+1;
                   $day=date('l',strtotime($request->date));


                  

             
        try {
            $date=date("Y-m-d",strtotime($request->date));

        $consultant=Consultant::find($request->consultant_id);

        $statuses=Status::where('details','Appointment_status_id')->get();
        $booked=Appointment::where('consultant_id',$request->consultant_id)->where('appointment_date',$date)->whereIn('appointment_status_id',['100','101','102'])->pluck('service_schedule_slot_id');
        $booked = $booked->toArray();

        // $slots=Consultant_service_schedule_slot::whereNotIn('id',$booked)->where('consultant_id',$consultant->id)->where('day_id',$dayId)->where('status_id',1)->get();
          $slots=Consultant_service_schedule_slot::where('consultant_id',$consultant->id)->where('day_id',$dayId)->where('status_id',1)->get();
          if(!count($slots))
          {
              return response()->json([
                'status_code' => 500,
                'status' => 0,
                'message' => "No Data Found",
             
              ]);
          }

        foreach($slots as $slot)
        {
        	if(in_array($slot->id, $booked))
        	{
        		$slot->book_status='Booked';
        	}
        	else
        	{
        		$slot->book_status='Free';
        	}
         $slot->slot_time=date('h:i a',strtotime($slot->slot_time_from)).' to '.date('h:i a',strtotime($slot->slote_time_to));
        }

        
             if(!$consultant)
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
              'message'=>'list of consultants',
              'consultant' => $consultant,
              'statuses'=>$statuses,
              'day'=>$day,
              'booked'=>$booked,
              'slots'=>$slots,
            ]);
          
          
          } catch (Exception $error) {
            return response()->json([
                'status_code' => 500,
                'status' => 0,
                'message' => "Exception",
             
              ]);
          }


            }

            public function appointment_notification()
            {
              $user=Auth::user();

               $patientAppointments=Appointment::where('patient_id',$user->id)->whereIn('appointment_status_id',[100,101])->latest()->count();
                if(!$patientAppointments)
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
              'message'=>'Patient Appointments',
              'appointments' => $patientAppointments,

        
            ]);
            }



    public function my_appointments(Request $request)
    {
        //
        $request->validate([
            'appointment_status_id'=>'required',
        ]);

        
        try {
            $user=Auth::user();
            if($request->appointment_status_id==0)
            {
              $patientAppointments=Appointment::with('consultant')->where('patient_id',$user->id)->whereIn('appointment_status_id',[100,101])->latest()->get();
            }
            else
            {
               $patientAppointments=Appointment::with('consultant')->where('patient_id',$user->id)->whereIn('appointment_status_id',[102,103,104])->latest()->get();
            }
     
           
             if(!count($patientAppointments))
             {
                 return response()->json([
                    'status_code' => 500,
                    'status' => 0,
                    'message'=>'No Data Found',
                  
                 ]);
             }
             foreach($patientAppointments as $row)
             {
              $row->time_from=date("h:i a",strtotime($row->time_from));
               $row->time_to=date("h:i a",strtotime($row->time_to));

             }
            return response()->json([
              'status_code' => 200,
              'status' => 1,
              'img_base'=>asset('assets/images/consultants/'),
              'message'=>'list of Patient Appointments',
              'patient'=>$user,
              'appointments' => $patientAppointments,

        
            ]);
          
          
          } catch (Exception $error) {
            return response()->json([
                'status_code' => 500,
                'status' => 0,
                'message' => "Exception",
             
              ]);
          }
    }

    public function cancel_appointment(Request $request)
    {
      $user=Auth::user();
      if(!$user)
      {
          return response()->json([
                'status_code' => 500,
                'status' => 0,
                'message' => "Unauthorized",
             
              ]);
      }

        $request->validate([
            'appointment_id'=>'required',
        ]);

        $appointment=Appointment::find($request->appointment_id);
        if($appointment)
        {
          $invoice=Invoice::where('id',$appointment->invoice_id)->first();
          if($invoice)
          {
            if($invoice->payment_status_id==51||$appointment->appointment_status_id!=103)
            {


            $invoice->delete();
            $appointment->appointment_status_id=104;
            $appointment->save();
             return response()->json([
              'status_code' => 200,
              'status' => 1,
              'message'=>"Your Appointment has been cancelled",
              'appointments' => $appointment,

              
            ]);
             
          }
          else
          {
             return response()->json([
                'status_code' => 500,
                'status' => 0,
                'message' => "You have Paid  invoice of appoientment you cannot cancel the appointment Now",
             
              ]);

          }

          }
          else
          {
               return response()->json([
                'status_code' => 500,
                'status' => 0,
                'message' => "no Invoice Found",
             
              ]);

          }

        }
        else{
            return response()->json([
                'status_code' => 500,
                'status' => 0,
                'message' => "No Appointment Found",
             
              ]);

        }

    }

        

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


    

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Consultant  $consultant
     * @return \Illuminate\Http\Response
     */
    public function show(Consultant $consultant)
    {
        //

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Consultant  $consultant
     * @return \Illuminate\Http\Response
     */
 

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Consultant  $consultant
     * @return \Illuminate\Http\Response
     */
  

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Consultant  $consultant
     * @return \Illuminate\Http\Response
     */
    public function destroy(Consultant $consultant)
    {
        //
    }
}
