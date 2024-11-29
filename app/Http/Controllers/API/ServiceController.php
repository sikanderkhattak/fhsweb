<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Status;
use App\Models\Consultant;

class ServiceController extends Controller
{
    //
    public function index()
    {
        //
        
        try {
            $services=Service::where('status_id',1)->orderBy('name','asc')->get();
            
             if(!count($services))
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
              'message'=>'list of Services',
              'services'=>$services,
            
            ]);
          
          
          } catch (Exception $error) {
            return response()->json([
                'status_code' => 500,
                'status' => 0,
                'message' => "Exception",
             
              ]);
          }
    }

    public function details($id)
    {
        //
        
        try {
            $service=Service::find($id);
           
           $consultants=$service->consultants;
             if(!count($consultants))
             {
                 return response()->json([
                    'status_code' => 500,
                    'status' => 0,
                    'message'=>'No Data Found',
                  
                 ]);
             }

           foreach($service->consultants as $cons)
           {
            $co=Consultant::find($cons->id);
        
        
                 $i=0;

               foreach($co->services as $service1)
               {
                $ser[$i]=$service1->name;
                $i++;
               }
               $cons->services= implode(', ', $ser);

          }
           
           
            
              if(!$service||!count($consultants))
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
              'service'=>$service,
       
              
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
