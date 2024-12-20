<?php
namespace App\Http\Controllers\Api;
 
use App\Models\BookRide; 
use App\Models\RideEmployee; 
use App\Models\EmployeePersonelRide;
use App\Models\RideEmployeeVehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;  
use Illuminate\Support\Facades\Auth;  
use DB;

class RideController extends BaseController
{
    public function bookRide(Request $request)
    { 
 
        $validator = Validator::make($request->all(), [
            'pickup_location' => 'required',  
            'pickup_latitude' => 'required',
            'pickup_longitude' => 'required',
            'dropoff_location' => 'required',
            'dropoff_latitude' => 'required',
            'dropoff_longitude' => 'required', 
        ]);
    
        if ($validator->fails()) {
            $errors = collect($validator->errors())->map(function ($error) {
                return $error[0]; 
            });
            return $this->sendResponse(null, 'Validation Error.', $errors, 200, false);
        } 
         $clientId = Auth::guard('client_api')->user()->id;    
    
            $ride = BookRide::create([
                'pickup_location'=>$request->pickup_location,
                'pickup_latitude'=>$request->pickup_latitude,
                'pickup_longitude'=>$request->pickup_longitude,
                'dropoff_location'=>$request->dropoff_location,
                'dropoff_latitude'=>$request->dropoff_latitude,
                'dropoff_longitude'=>$request->dropoff_longitude,
                'client_id'=>$clientId,
            ]);   
            return $this->sendResponse($ride, 'Ride Book successfully', null, 200);
     
    } 
 
  

    public function userBookRide(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pickup_location' => 'required',  
            'pickup_latitude' => 'required',
            'pickup_longitude' => 'required',
            'dropoff_location' => 'required',
            'dropoff_latitude' => 'required',
            'dropoff_longitude' => 'required',
            'start_ride' => 'required|date_format:m-d-Y',
            'end_ride' => 'required|date_format:m-d-Y',
            'booking_type' => 'required|integer',
            'days' => 'required|integer',
            'home_to_office_pick_time' => 'required|date_format:H:i',
            'office_to_home_pick_time' => 'required|date_format:H:i',
        ]);
    
        if ($validator->fails()) {
            $errors = collect($validator->errors())->map(function ($error) {
                return $error[0]; 
            });
            return $this->sendResponse(null, 'Validation Error.', $errors, 200, false);
        }
    
        $clientId = Auth::guard('user_api')->user()->company_id;       
        $userId = Auth::guard('user_api')->user()->id;       
    
        try {
            $startDate = \Carbon\Carbon::createFromFormat('m-d-Y', trim($request->start_ride));
            $endDate = \Carbon\Carbon::createFromFormat('m-d-Y', trim($request->end_ride));
        } catch (\Exception $e) {
            return $this->sendResponse(null, 'Invalid date format.', ['error' => $e->getMessage()], 400, false);
        }
    
        if ($startDate->gt($endDate)) {
            return $this->sendResponse(null, 'End date must be after the start date.', null, 400, false);
        }
    
        $ride = BookRide::create([
            'pickup_location' => $request->pickup_location,
            'pickup_latitude' => $request->pickup_latitude,
            'pickup_longitude' => $request->pickup_longitude,
            'dropoff_location' => $request->dropoff_location,
            'dropoff_latitude' => $request->dropoff_latitude,
            'dropoff_longitude' => $request->dropoff_longitude,
            'ride_assigned' => 1, 
            'is_employee_add' => 1, 
            'client_id' => $clientId,
        ]);   
    
        $ride_employee = new RideEmployee();
        $ride_employee->employee_id = $userId; 
        $ride_employee->booking_type = $request->booking_type;  
        $ride_employee->days = $request->days; 
        $ride_employee->ride_id = $ride->id; 
        $ride_employee->save();
    
        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
            $ride_employee_personel = new EmployeePersonelRide();
            $ride_employee_personel->employee_id = $userId; 
            $ride_employee_personel->home_to_office_pick_time = $request->home_to_office_pick_time;
            $ride_employee_personel->office_to_home_pick_time = $request->office_to_home_pick_time; 
            $ride_employee_personel->ride_id = $ride->id;
            $ride_employee_personel->ride_date = $date->format('Y-m-d');
            $ride_employee_personel->save();
        }
    
        return $this->sendResponse($ride, 'Ride booked successfully.', null, 200);
    }

    public function userCurrentRide(Request $request)
    {
        $ride = EmployeePersonelRide::where('employee_id',Auth::guard('user_api')->user()->id)->where('is_ride_complete',0)->get();
        return $this->sendResponse($ride, 'Current Ride Show Successfully.', null, 200);
    }



    public function completeRide(Request $request)
    {
        $employeePersonelRide =  EmployeePersonelRide::where('id',$request->ride_employee_id)->first();
        $employeePersonelRide->is_ride_complete = 1;
        $employeePersonelRide->save();
      
          return $this->sendResponse([], 'Ride Completed Successfully.', null, 200);
    }  
    
    public function cancelRide(Request $request)
    {

        $employeePersonelRide =  EmployeePersonelRide::where('id',$request->ride_employee_id)->first();

        if($employeePersonelRide->is_ride_complete == 1){
            return $this->sendResponse([], 'Ride Already Completed Successfully.', null, 200);
        }else{ 
        $employeePersonelRide->is_ride_complete = 2;
        $employeePersonelRide->save(); 
        return $this->sendResponse([], 'Ride Cancled Successfully.', null, 200);
        }
}

public function RideTime(Request $request)
{

    $employeePersonelRide =  EmployeePersonelRide::where('id',$request->ride_employee_id)->first(); 

    if(empty($employeePersonelRide)){ 
        return $this->sendError('Employee Ride Not Found', [], 401);  
    } 

    
    $employeePersonelRide->home_to_office_pick_time = $request->home_to_office_pick_time;
    $employeePersonelRide->office_to_home_pick_time = $request->office_to_home_pick_time;
    $employeePersonelRide->save(); 

    return $this->sendResponse($employeePersonelRide, 'Ride Time Update Successfully.', null, 200);




}



public function assign_ride(Request $request)
{    


    $validator = Validator::make($request->all(), [
        'vehicle_id' => 'required',  
        'driver_id' => 'required', 
    ]);

    if ($validator->fails()) {
        $errors = collect($validator->errors())->map(function ($error) {
            return $error[0]; 
        });
        return $this->sendResponse(null, 'Validation Error.', $errors, 200, false);
    }



    $driverData =  RideEmployeeVehicle::where('ride_id',$request->ride_id)->first();
    if(!empty($driverData)){  
        $driverData->ride_id = $request->ride_id; 
        $driverData->vehicle_id = $request->vehicle_id;
        $driverData->save();
    }else{
        $vehicles = new RideEmployeeVehicle();
        $vehicles->ride_id = $request->ride_id;
        $vehicles->vehicle_id = $request->vehicle_id; 
        $vehicles->save();  
    }
 
    return response()->json(['status' => 1, 'message' => 'Ride Assign successfully']);

}
      
}
