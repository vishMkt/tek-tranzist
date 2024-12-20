<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BookRide; 
use App\Models\Vendor; 
use App\Models\AssignRide;
use App\Models\Days;
use App\Models\Vehicle;
use App\Models\RideEmployee;
use App\Models\User;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Auth;

class RidesController extends Controller
{

    public function index()
    { 
         
      $nav = "Rides";  
      return view('rides.index',compact('nav'));
    } 
    
    public function list(Request $request)
    {
        ## Read value
        $draw = $request->input('draw');
        $i = $row = $request->input('start');
        $rowperpage = $request->input('length'); // Rows display per page
        $columnIndex = $request->input('order.0.column'); // Column index
        $columnName = $request->input('columns.' . $columnIndex . '.data'); // Column name
        $columnSortOrder = $request->input('order.0.dir'); // asc or desc
        $searchValue = $request->input('search.value'); // Search value 
        $currentGuard = config('auth.defaults.guard'); 
    
        ## Custom Field value
        $qry = BookRide::select('book_rides.*')
            ->leftJoin('assign_rides', 'book_rides.id', '=', 'assign_rides.ride_id')
            ->where('book_rides.pickup_location', 'LIKE', '%' . $searchValue . '%')
            ->orderBy('book_rides.created_at', 'DESC');
    
        if (isset($request->searchname)) {
            $qry->where('book_rides.pickup_location', 'LIKE', '%' . $request->searchname . '%');
        }
    
        $result = $qry->get();
        $totalRecordwithFilter = $result->count();
        $result = $qry->offset($row)->take($rowperpage)->get();
      
        // echo "<pre>";print_r($result->toArray());die;
        $data = array();
        $vendors = Vendor::where('status',1)->get();
        foreach ($result as $row) { 
            $assignDriver = route('update.assign.rides');  
            $rideAssign = AssignRide::where('ride_id', $row->id)->first();
        
            // Determine the action based on conditions
            if ($row->ride_assigned == 1 && $row->is_accept == 1) {
                $action =  $rideAssign->Vendor->firstname .' '. $rideAssign->Vendor->lastname ;
            } else {
                $action = '<select onchange="assignVendor(this, `' . $assignDriver . '`, `' . $row->id . '`)" name="vendor" class="form-control">';
                $action .= '<option value="">--Choose--</option>';
        
                foreach ($vendors as $vendor) {
                    $selected = ($rideAssign && $rideAssign->vendor_id == $vendor->id) ? 'selected' : '';
                    $action .= '<option value="' . $vendor->id . '" ' . $selected . '>' . $vendor->firstname . ' ' . $vendor->lastname . '</option>';
                }
        
                $action .= '</select>';
            }

            // echo "<pre>";print_r($row->RideEmployeeVehicle->Driver);die;
         
            $assignedVehicle = isset($row->RideEmployeeVehicle->Vehicle->ModelVehicle->name) ? $row->RideEmployeeVehicle->Vehicle->ModelVehicle->name : 'N/A';    
            
            $assignedDriver = isset($row->RideEmployeeVehicle->Driver) && $row->RideEmployeeVehicle->Driver->firstname && $row->RideEmployeeVehicle->Driver->lastname
            ? $row->RideEmployeeVehicle->Driver->firstname . ' ' . $row->RideEmployeeVehicle->Driver->lastname
            : 'N/A';
        
        
            $i++;
            $data[] = array(
                "sno" => $i,
                "pickup_location" => $row->pickup_location,
                "dropoff_location" => $row->dropoff_location, 
                "assigned_vehicle" => $assignedVehicle,
                "assigned_driver" => $assignedDriver,
                "action" => $action,
            );
        }
        
    
        ## Response
        $totalRecords = BookRide::count();
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
    $data['ride_vendor'] = AssignRide::where('ride_id',$id)->first();
    $data['id'] = $id;
    $view =  view('rides.assignDriver',$data)->render(); 
    
    return response()->json(['success'=>1,'view'=>$view]);
}



public function update_data(Request $request)
{   
    // echo "<pre>";print_r($request->all());die;
    $request->validate([ 
        'value' => 'required|numeric', 
    ]);
   
    $assignRide = AssignRide::where('ride_id',$request->ride_id)->first();
    if(!empty($assignRide)){ 
        $assignRide->vendor_id = $request->value; 
        $assignRide->ride_id = $request->ride_id; 
        $assignRide->save(); 
    }else{
        $assign_rides = new AssignRide();
        $assign_rides->vendor_id = $request->value; 
        $assign_rides->ride_id = $request->ride_id; 
        $assign_rides->save(); 
    }

    $bookride = BookRide::find($request->ride_id); 
    $bookride->ride_assigned = 1; 
    $bookride->save();

    // Return success response
    return response()->json(['status' => 1, 'message' => 'Ride Assign successfully']);
}








}


?>