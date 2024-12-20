<?php
namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\BookRide; 
use App\Models\Vendor; 
use App\Models\AssignRide; 
use App\Models\User; 
use App\Models\EmployeePersonelRide; 
use App\Models\RideEmployee; 
use App\Models\Days; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RidesController extends Controller
{

    public function index()
    {
      $nav = "Rides";  
      return view('company.rides.index',compact('nav'));
    } 
    
 
    public function list(Request $request)
    {
        $companyid = Auth::id();
        // echo "<pre>";print_r($id);die;
        ## Read value
        $draw = $_POST['draw'];
        $i = $row = $_POST['start'];
        $rowperpage = $_POST['length']; // Rows display per page
        $columnIndex = $_POST['order'][0]['column']; // Column index
        $columnName = $_POST['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
        $searchValue = $_POST['search']['value']; // Search value
    
        ## Custom Field value
        $searchQuery = " ";
    
        $qry = BookRide::select('*')->where('book_rides.pickup_location', 'LIKE', '%' . $searchValue . '%')
            ->orderBy('book_rides.created_at', 'DESC')->where('ride_assigned',1)->where('client_id',$companyid);
    
        if (isset($request->searchname)) {
            $qry->where('book_rides.pickup_location', 'LIKE', '%' . $request->searchname . '%');
        }
    
        $result = $qry->get();
        $totalRecordwithFilter = $result->count();
        $result = $qry->offset($row)->take($rowperpage)->get();
    
        // echo "<pre>";print_r($result[0]->assignRide->Vendor);die;
        $data = array();
        foreach ($result as $row) { 
            $assignEmployeeImage = asset('assets/icon/verify_icon.svg'); 
    
          
            if($row->is_employee_add == 1){ 
                $assignedEmployee = route('company.check.employee', $row->id); 
                $action = '<div class="custom_dropdown">
                <div class="dropdown-toggle dropdown-toggle-nocaret cursor-pointer" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa-solid fa-ellipsis"></i>
                </div>
                <ul class="dropdown-menu text-dark border" style="margin: 0px; border-radius: 5px;">
                    <li>
                        <a href="'.$assignedEmployee.'" class="dropdown-item font_14_semibold text_dark_opacity confirm_button d-flex align-items-center gap-1" >
                        <img src="'.$assignEmployeeImage.'" alt="view invoice" class="me-3">
                       Check Employee
                        </a>
                    </li> 
                </ul>
            </div>';
            }else{
                
                $assignedEmployee = route('company.assign.employee.rides', $row->id); 
                $action = '<div class="custom_dropdown">
                <div class="dropdown-toggle dropdown-toggle-nocaret cursor-pointer" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa-solid fa-ellipsis"></i>
                </div>
                <ul class="dropdown-menu text-dark border" style="margin: 0px; border-radius: 5px;">
                    <li>
                        <a href="'.$assignedEmployee.'" class="dropdown-item font_14_semibold text_dark_opacity confirm_button d-flex align-items-center gap-1" >
                       <img src="'.$assignEmployeeImage.'" alt="view invoice" class="me-3">
                        Assign Employee
                        </a> 
                    </li> 
                </ul>
            </div>';
            }
          
    
            $i++;
            $data[] = array(
                "sno" => $i,
                "vendor" => $row->assignRide->Vendor->firstname .' '.$row->assignRide->Vendor->lastname,
                "pickup_location" => $row->pickup_location,
                "dropoff_location" => $row->dropoff_location, 
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
    $view =  view('company.rides.assignDriver',$data)->render(); 
    
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


public function assignEmployee($id)
{  
    $data['nav']= "Rides";
    $data['users'] = User::all();
    $data['days'] = Days::all();
    $data['id'] = $id;
    return  view('company.rides.assignEmployee',$data);
}



public function add_employee(Request $request)
{   
    


    $request->validate([ 
        'employee_id' => 'required', 
        'bookingType' => 'required',  
        'days' => 'required', 
    ]);
   
    $days = implode(',',$request->days);
    foreach($request->employee_id as $employee){ 
        $ride_employee = new RideEmployee();
        $ride_employee->employee_id = $employee; 
        $ride_employee->booking_type = $request->bookingType;  
        $ride_employee->days = $days; 
        $ride_employee->ride_id = $request->ride_id; 
        $ride_employee->save();
    } 




        // Split the date range and parse the start and end dates
        $dateEmployeeRide = explode('-', $request->daterange);
        $startDate = \Carbon\Carbon::createFromFormat('m/d/Y', trim($dateEmployeeRide[0]));
        $endDate = \Carbon\Carbon::createFromFormat('m/d/Y', trim($dateEmployeeRide[1]));
    
        // Combine the selected days into a string
        $days = implode(',', $request->days);
    
        // Loop through each employee
        foreach ($request->employee_id as $employee) {
            // Iterate through the date range
            for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
                $ride_employee_personel = new EmployeePersonelRide();
                $ride_employee_personel->employee_id = $employee; 
                $ride_employee_personel->home_to_office_pick_time = $request->home_to_office_pick;
                $ride_employee_personel->office_to_home_pick_time = $request->office_to_home_pick; 
                $ride_employee_personel->ride_id = $request->ride_id;
                $ride_employee_personel->ride_date = $date->format('Y-m-d'); // Add ride date
                $ride_employee_personel->save();
            }
        }
    



    BookRide::where('id',$request->ride_id)->update([
    'is_employee_add'=>1,
    ]);

    // Return success response
    return response()->json(['status' => 1, 'message' => 'Ride Assign successfully']);
}


 

 
public function checkEmployee($id)
{  
    $data['nav'] = 'Check Employee'; 
    $data['id'] = $id; 
    return view('company.rides.checkEmployee', $data);

    // return response()->json(['success' => 1, 'view' => $view]);
}



public function checkEmployeeList(Request $request)
{
    ## Read value
    $draw = $_POST['draw'];
    $i = $row = $_POST['start'];
    $rowperpage = $_POST['length']; // Rows display per page
    $columnIndex = $_POST['order'][0]['column']; // Column index
    $columnName = $_POST['columns'][$columnIndex]['data']; // Column name
    $columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
    $searchValue = $_POST['search']['value']; // Search value

    ## Custom Field value
    $searchQuery = " ";

    $qry = RideEmployee::select('*')->where('ride_employees.booking_type', 'LIKE', '%' . $searchValue . '%')
        ->orderBy('ride_employees.created_at', 'DESC')->where('ride_id',$request->ride_id);
 
    $result = $qry->get();
    $totalRecordwithFilter = $result->count();
    $result = $qry->offset($row)->take($rowperpage)->get();

    // echo "<pre>";print_r($result->toArray());die;
    $data = array(); 
    foreach ($result as $row) { 
          
        if($row->booking_type == 1){
            $bookingType = 'Shift';
        }else{
            $bookingType = 'Add Off Booking';

        }


        $assignEmployeeImage = asset('assets/icon/verify_icon.svg'); 
        $assignedEmployee = route('company.view.employee.ride', [
            'employee_id' => $row->Employee->id,
            'ride_id' => $row->ride_id
        ]);
        $action = '<div class="custom_dropdown">
        <div class="dropdown-toggle dropdown-toggle-nocaret cursor-pointer" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="fa-solid fa-ellipsis"></i>
        </div>
        <ul class="dropdown-menu text-dark border" style="margin: 0px; border-radius: 5px;">
            <li>
                <a href="'.$assignedEmployee.'" class="dropdown-item font_14_semibold text_dark_opacity confirm_button d-flex align-items-center gap-1" >
               <img src="'.$assignEmployeeImage.'" alt="view invoice" class="me-3">
             View Employee Ride
                </a> 
            </li> 
        </ul>
    </div>';



        $i++;
        $data[] = array(
            "sno" => $i,
            "employee" => $row->Employee->firstname .' '.$row->Employee->lastname,
            "booking_type" => $bookingType,
            "pickup_location" => $row->Ride->pickup_location,  
            "dropoff_location" => $row->Ride->dropoff_location,  
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



 
public function ViewEmployeeRide($id,$ride_id)
{   
    $data['nav'] = 'View Employee Ride';  
 
    $data['employee'] = User::where('id',$id)->first(); 
    $data['ride_id'] = $ride_id; 

    return view('company.rides.viewEmployeeRide', $data);

    // return response()->json(['success' => 1, 'view' => $view]);
}




public function viewEmployeeRideList(Request $request)
{
    ## Read value
    $draw = $_POST['draw'];
    $i = $row = $_POST['start'];
    $rowperpage = $_POST['length']; // Rows display per page
    $columnIndex = $_POST['order'][0]['column']; // Column index
    $columnName = $_POST['columns'][$columnIndex]['data']; // Column name
    $columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
    $searchValue = $_POST['search']['value']; // Search value

    ## Custom Field value
    $searchQuery = " ";

    $qry = EmployeePersonelRide::select('*')->where('employee_personel_rides.ride_date', 'LIKE', '%' . $searchValue . '%')
        ->orderBy('employee_personel_rides.created_at', 'DESC')->where('employee_id',$request->employee_id)->where('ride_id',$request->ride_id);
 
    $result = $qry->get();
    $totalRecordwithFilter = $result->count();
    $result = $qry->offset($row)->take($rowperpage)->get();
 
    $data = array(); 
    foreach ($result as $row) { 
       
        if($row->is_ride_complete == 0){
            $isRideComplete = '<p class="text-danger">In Complete</p>';
        }else{
            $isRideComplete = '<p class="text-success">Completed</p>';

        }

        $timeHomeToOffice = "<input type='time' class='form-control' 
        oninput=\"updateTimeHomeToOffice(this, '" . route('company.update.employee.time') . "', '$row->id')\"  value='" . e($row->home_to_office_pick_time) . "'>";
        $timeOfficeToHome = "<input type='time' class='form-control'  oninput=\"updateTimeOfficeToHome(this, '" . route('company.update.employee.time.office.to.home') . "', '$row->id')\"   value='" . e($row->office_to_home_pick_time) . "'>";

        $i++;
        $data[] = array(
            "sno" => $i, 
            "ride_date" => $row->ride_date,  
            "home_to_office_pick_time" => $timeHomeToOffice,  
            "office_to_home_pick_time" => $timeOfficeToHome,   
            "is_ride_complete" => $isRideComplete,   
        );
    }

    ## Response
    $totalRecords = EmployeePersonelRide::get()->count();
    $response = array(
        "draw" => intval($draw),
        "iTotalRecords" => $totalRecords,
        "iTotalDisplayRecords" => $totalRecordwithFilter,
        "aaData" => $data
    );

    echo json_encode($response);
}


public function update_employee_time_home_to_office(Request $request)
{   
    
    $rideEmployee = EmployeePersonelRide::where('id',$request->id)->first();
    $rideEmployee->home_to_office_pick_time = $request->time;
    $rideEmployee->save();


    return response()->json(['status' => 1, 'message' => 'Employee Ride Time Updated successfully']);
}

public function update_employee_time_office_to_home(Request $request)
{   
    
    $rideEmployee = EmployeePersonelRide::where('id',$request->id)->first();
    $rideEmployee->office_to_home_pick_time = $request->time;
    $rideEmployee->save();


    return response()->json(['status' => 1, 'message' => 'Employee Ride Time Updated successfully']);
}




}





?>