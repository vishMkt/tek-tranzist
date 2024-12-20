<?php
namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\BookRide; 
use App\Models\RideEmployee; 
use App\Models\Vendor; 
use App\Models\AssignRide;
use App\Models\Driver;
use App\Models\RideEmployeeVehicle;
use App\Models\Vehicle; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RidesController extends Controller
{

    public function index()
    {
      $nav = "Rides";  
      return view('vendor.rides.index',compact('nav'));
    } 
    
 
public function list(Request $request)
{ 
    ## Read value
    $draw = $_POST['draw'];
    $i = $row = $_POST['start'];
    $rowperpage = $_POST['length']; // Rows display per page
    $columnIndex = $_POST['order'][0]['column']; // Column index
    $columnName = $_POST['columns'][$columnIndex]['data']; // Column name
    $columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
    $searchValue = $_POST['search']['value']; // Search value
    $vendorId = Auth::id();
    ## Custom Field value
    $searchQuery = " ";

    $qry = BookRide::select('book_rides.*')
    ->join('assign_rides', 'assign_rides.ride_id', '=', 'book_rides.id')
    ->where('book_rides.pickup_location', 'LIKE', '%' . $searchValue . '%')
    ->where('assign_rides.vendor_id', $vendorId)
    ->orderBy('book_rides.created_at', 'DESC');


    if (isset($request->searchname)) {
        $qry->where('book_rides.pickup_location', 'LIKE', '%' . $request->searchname . '%');
    }

    $result = $qry->get();
    $totalRecordwithFilter = $result->count();
    $result = $qry->offset($row)->take($rowperpage)->get();

    $data = array();
    foreach ($result as $row) {  
        
        $assignDriverImage = asset('assets/icon/Report_icon.svg');  
        if(@$row->RideEmployeeVehicle->vehicle_id != 0 || @$row->RideEmployeeVehicle->vehicle_id != null && $row->RideEmployeeVehicle->driver_id != 0 || @$row->RideEmployeeVehicle->driver_id != null){
            $action = '<p class="text-success"> Vehicle Assigned </p>';
        }else{

            if ($row->is_accept == 0) {
                $action = '<div class="buttons d-flex gap-2">
                                <button class="btn btn-success accept_button" onclick="requestButton(this, `'.$row->id.'`,1)">
                                    Accept
                                </button>
                                <button class="btn btn-danger decline_button" onclick="requestButton(this, `'.$row->id.'`,2)">
                                    Decline
                                </button>
                           </div>';
            }  elseif ($row->is_accept == 2) {
                $action = '<div class="buttons d-flex gap-2">
                            <p class="text-danger">Declined</p>
                           </div>';
            } 
            else { 
                $action = '-';
            }
        }
        $vehicleDriver_data =  RideEmployeeVehicle::where('ride_id',$row->id)->first();
        $drivers = Driver::where('vendor_id',$vendorId)->get();
        $assignDriver = route('vendors.update.driver');  
        $driver = '<select onchange="assignDriver(this, `' . $assignDriver . '`, `' . $row->id . '`)" name="driver" class="form-control">';
        $driver .= '<option value="">--Choose--</option>';

        foreach ($drivers as $driversr) {
            $selected = ($vehicleDriver_data && $vehicleDriver_data->driver_id == $driversr->id) ? 'selected' : '';
            $driver .= '<option value="' . $driversr->id . '" ' . $selected . '>' . $driversr->firstname . ' ' . $driversr->lastname . '</option>';
        }
        $driver .= '</select>';


        $vehicles = Vehicle::where('vendor_id',$vendorId)->get();
        $assignDriver = route('vendors.update.vehicle');  
        $vehicle = '<select onchange="assignVehicle(this, `' . $assignDriver . '`, `' . $row->id . '`)" name="driver" class="form-control">';
        $vehicle .= '<option value="">--Choose--</option>';

        foreach ($vehicles as $vehicles_data) {
            $selected = ($vehicleDriver_data && $vehicleDriver_data->vehicle_id == $vehicles_data->id) ? 'selected' : '';
            $vehicle .= '<option value="' . $vehicles_data->id . '" ' . $selected . '>' . $vehicles_data->ModelVehicle->name . ' ' . $vehicles_data->lastname . '</option>';
        }
        $vehicle .= '</select>';


        $rideAssign = Vendor::where('id', $vendorId)->first();
 
 
        $vendor = isset($rideAssign) && $rideAssign->firstname && $rideAssign->lastname
        ? $rideAssign->firstname . ' ' .$rideAssign->lastname
        : 'N/A';
    

        $i++;
        $data[] = array(
            "sno" => $i,
            "pickup_location" => $row->pickup_location,
            "dropoff_location" => $row->dropoff_location, 
            "vendor" => $vendor, 
            "driver" => $driver, 
            "vehicle" => $vehicle, 
            "action" => $action,
        );
    }

    ## Response
    $totalRecords = BookRide::get()->count();
    $response = array(
        "draw" => intval($draw),
        "iTotalRecords" => $totalRecords,
        "iTotalDisplayRecords" => $totalRecordwithFilter,
        "aaData" => $data
    );

    echo json_encode($response);
}



public function assignDriver($id)
{  
    $data['nav']= "Rides";
    $data['vendors'] = Vendor::where('status',1)->get();
    $data['id'] = $id;
    $view =  view('rides.assignDriver',$data)->render(); 
    
    return response()->json(['success'=>1,'view'=>$view]);
}



public function update_data(Request $request)
{   
    $request->validate([ 
        'vendor' => 'required|numeric', 
    ]);
   
    $assign_rides = new AssignRide();
    $assign_rides->vendor_id = $request->vendor; 
    $assign_rides->ride_id = $request->ride_id; 
    $assign_rides->save();
 

    $bookride = BookRide::find($request->ride_id); 
    $bookride->ride_assigned = 1; 
    $bookride->save();

    // Return success response
    return response()->json(['status' => 1, 'message' => 'Ride Assign successfully']);
}




public function assignVehicle($id)
{   
    $data['nav']= "Rides";

    $data['vehicles'] = $vehicle = Vehicle::where('vendor_id',Auth::id())->get(); 
    $data['drivers'] = $Driver = Driver::where('vendor_id',Auth::id())->get(); 

    // echo "<prE>";print_r($vehicle[0]->Make->name);die;
    $data['id'] = $id;
    $view =  view('rides.assignVehicle',$data)->render(); 
    
    return response()->json(['success'=>1,'view'=>$view]);
}
 

public function update_driver(Request $request)
{    


    $request->validate([  
        'driver_id' => 'required',  
    ]);
     
    $vehicleData =  RideEmployeeVehicle::where('ride_id',$request->ride_id)->first();

    if(!empty($vehicleData)){  
        $vehicleData->ride_id = $request->ride_id; 
        $vehicleData->driver_id = $request->driver_id;
        $vehicleData->save();
    }else{
        $vehicles = new RideEmployeeVehicle();
        $vehicles->ride_id = $request->ride_id; 
        $vehicles->driver_id = $request->driver_id;
        $vehicles->save();    
    }

    return response()->json(['status' => 1, 'message' => 'Driver Assign successfully']);

}



public function update_vehicle(Request $request)
{    


    $request->validate([ 
        'vehicle_id' => 'required',   
    ]);
     
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
 
    return response()->json(['status' => 1, 'message' => 'Vehicle Assign successfully']);

}


public function acceptRequest(Request $request)
{    

    $ride = BookRide::find($request->id);
    $ride->is_accept = $request->value;
    $ride->save();
 
    if($request->value == 1){
        return response()->json(['status' => 1, 'message' => 'Ride Accepted successfully']);
    }else{
    return response()->json(['status' => 0, 'message' => 'Ride Declined successfully']);

    }

}


}
?>