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
use App\Models\Department;

use Auth;

use Illuminate\Http\Request;

class SearchController extends Controller
{

	 public function searchConsultants(Request $request)
    {
        //
        $request->validate([
        	'name'=>'required',
        ]);
        
        try {
     //        $consultants=Consultant::query()
		   // ->whereLike('full_name', $request->name)
		   // ->get();
		   $consultants = Consultant::where('full_name','LIKE','%'.$request->name.'%')
               // ->orWhere('email','LIKE','%'.$email_or_name.'%')
                ->get();
            
             if(!count($consultants))
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
              'message'=>'list of searched consultants',
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


     public function dep_ser_search(Request $request)
    {
           //
           $request->validate([
            'department_id'=>'',
            'service_id'=>'',
          ]);
          
          try {

            $consultants = Consultant::query();
            $consultants=Consultant::where('status_id',1);
            $consultants=$consultants->get();

        $service=Service::find($request->service_id);
        if($service)
        {
          $consultants=$service->consultants;
         
          // $consultants->where('service_id',$service->id);
        }
        $department=Department::find($request->department_id);
        if($department)
        {
          //return $consultants;
          if($consultants && $request->service_id!==null)
          {
               foreach($consultants as $key => $value)
              {
                if(!($consultants[$key]->department_id==$request->department_id))
                {
                  unset($consultants[$key]);
                }
              }
          }
          else{
            $consultants = Consultant::query();
            $consultants=Consultant::where('status_id',1);
            $consultants->where('department_id',$department->id);
            $consultants=$consultants->get();
          }
      
        }

        
        if(!count($consultants))
        {
            return response()->json([
               'status_code' => 500,
               'status' => 0,
               'message'=>'No Data Found',
             
            ]);
        }

         foreach($consultants as $cons)
          {
               $cons->services=$cons->services;

                 $i=0;
               foreach($cons->services as $service)
               {
                $ser[$i]=$service->name;
                $i++;
               }
               $cons->service= implode(', ', $ser);
          }
       return response()->json([
         'status_code' => 200,
         'status' => 1,
         'img_base'=>asset('assets/images/consultants/'),
         'message'=>'list of searched consultants',
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

    public function departments(Request $request)
    {
        //

        $departments=Department::where('status_id',1)->latest()->get();
         if(!count($departments))
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
              'message'=>'list Of departments',
              'departments' => $departments,
            ]);
          
          
          } 
    

  




}