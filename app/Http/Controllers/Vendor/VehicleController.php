<?php
namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use App\Models\Driver;
use App\Models\Puc;
use App\Models\Insurance;
use App\Models\ModelVehicle;
use App\Models\VehicleOwner;
use App\Models\Make; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator; 
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Twilio\Rest\Client; 

class VehicleController extends Controller
{
    public function index()
    {
      $data['nav']= "Vehicle";
      return view('vendor.vehicle.index',$data);
    }

    public function create()
{ 
        $nav= "Vehicle";
        $drivers = Driver::all();
        $makes = Make::all();
        $vehicle_owners = VehicleOwner::where('status',1)->get();
      return  view('vendor.vehicle.create',compact('nav','drivers','vehicle_owners','makes'));
}

 public function store(Request $request)
{ 
    
    // Validate request data
    $request->validate([
        'year' => 'required',
        'license_plate' => 'required|string|max:255',
        'status' => 'required',
        'vehicle_owner' => 'required', 
        'puc_certificate_number' => 'required|max:255',
        'puc_issue_date' => 'required|max:255',
        'puc_expiry_date' => 'required|max:255', 
        'image_id' => 'required', 
        'image_id_back' => 'required', 
        'policy_number' => 'required',
        'provider' => 'required|max:255',
        'issue_date' => 'required|max:255',
        'expiry_date' => 'required|max:255',  
        'image_id_front_insurance' => 'required', 
        'image_id_back_insurance' => 'required', 
    ]);

    // Create a new vehicle
    $vehicle = new Vehicle(); 
    $vehicle->make = $request->make;
    $vehicle->model = $request->model;
    $vehicle->year = $request->year;
    $vehicle->vendor_id = $request->user()->id;
    $vehicle->license_plate = $request->license_plate; 
    $vehicle->status = $request->status;  
    $vehicle->vehicle_owner = $request->vehicle_owner;  
    $vehicle->save();


      // Create a new PUC
      $puc = new Puc(); 
      $puc->puc_certificate_number = $request->puc_certificate_number;
      $puc->puc_issue_date = $request->puc_issue_date;
      $puc->puc_expiry_date = $request->puc_expiry_date; 
      $puc->vehicle_id = $vehicle->id;   
      $puc->front_image = $request->image_id;  
      $puc->back_image = $request->image_id_back;  
      $puc->save();

      
        // Create a new insurance
    $insurance = new Insurance();
    $insurance->policy_number = $request->policy_number;
    $insurance->provider = $request->provider; 
    $insurance->issue_date = $request->issue_date;
    $insurance->expiry_date = $request->expiry_date;  
    $insurance->vehicle_id = $vehicle->id;   
    $insurance->front_image = $request->image_id_front_insurance;  
    $insurance->back_image = $request->image_id_back_insurance;  
    $insurance->save();

    // Return success response
    return response()->json(['status' => 1, 'message' => 'Vehicle created successfully']);
 
}

public function update_data(Request $request)
{ 
    $id = $request->id ; 
    $request->validate([  
        'year' => 'required',
        'license_plate' => 'required|string|max:255',
        'status' => 'required',
        'vehicle_owner' => 'required', 
        'puc_certificate_number' => 'required|max:255',
        'puc_issue_date' => 'required|max:255',
        'puc_expiry_date' => 'required|max:255', 
        'image_id' => 'required', 
        'image_id_back' => 'required',
        'policy_number' => 'required',
        'provider' => 'required|max:255',
        'issue_date' => 'required|max:255',
        'expiry_date' => 'required|max:255',  
        'image_id_front_insurance' => 'required', 
        'image_id_back_insurance' => 'required',  
    ]);
 
    $vehicle = Vehicle::find($id);
 
    if (!$vehicle) {
        return response()->json(['status' => 0, 'message' => 'Vehicle not found'], 404);
    }   
    $vehicle->make = $request->make;
    $vehicle->model = $request->model;
    $vehicle->license_plate = $request->license_plate; 
    $vehicle->status = $request->status;   
    $vehicle->vendor_id = $request->user()->id; 
    $vehicle->year = $request->year;
    $vehicle->vehicle_owner = $request->vehicle_owner;  
    $vehicle->save();


    // PUC Update 

    $puc = Puc::where('vehicle_id',$id)->first();  
    $puc->puc_certificate_number = $request->puc_certificate_number;
    $puc->puc_issue_date = $request->puc_issue_date;
    $puc->puc_expiry_date = $request->puc_expiry_date; 
    $puc->vehicle_id = $id;   
    $puc->front_image = $request->image_id;  
    $puc->back_image = $request->image_id_back;  
    $puc->save();
    
    // Insurance Update
    $insurance = Insurance::where('vehicle_id',$id)->first();  
    $insurance->policy_number = $request->policy_number;
    $insurance->provider = $request->provider; 
    $insurance->issue_date = $request->issue_date;
    $insurance->expiry_date = $request->expiry_date;  
    $insurance->front_image = $request->image_id_front_insurance;  
    $insurance->back_image = $request->image_id_back_insurance; 
    $insurance->save();
 
    return response()->json(['status' => 1, 'message' => 'Vehicle updated successfully']);
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

    ## Custom Field value
    $searchQuery = " ";

    $qry = Vehicle::select('*')->where('vendor_id',$request->user()->id)->orderBy('vehicles.created_at', 'DESC');

    if (isset($request->searchname)) {
        $qry->where('vehicles.make', 'LIKE', '%' . $request->searchname . '%');
        $qry->orWhere('vehicles.model', 'LIKE', '%' . $request->searchname . '%');
        $qry->orWhere('vehicles.license_plate', 'LIKE', '%' . $request->searchname . '%');
    }

    $result = $qry->get();
    $totalRecordwithFilter = $result->count();
    $result = $qry->offset($row)->take($rowperpage)->get();

    // echo "<pre>";print_r($result);die;
    $data = array();
    foreach ($result as $row) {

        $edit = route('vendor.edit.vehicle', $row->id);
        $view = route('vendor.view.vehicle', $row->id);
        $delete = route('vendor.delete.vehicle', $row->id);
        $editImage = asset('assets/icon/Report_icon.svg');
        $eyeImage = asset('assets/icon/eye.svg');
        $deleteImage = asset('assets/icon/Delete_icon.svg');

        $action = '<div class=" custom_dropdown">
                    <div class="dropdown-toggle dropdown-toggle-nocaret cursor-pointer" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-solid fa-ellipsis"></i>
                    </div>
                    <ul class="dropdown-menu text-dark  border" style="margin: 0px; border-radius: 5px;">
                       <li>
                        <a href="'.$edit.'"  class="dropdown-item font_14_semibold text_dark_opacity">
                        <img src="'.$editImage.'" alt="view invoice" class="me-3">
                        Edit
                        </a>
                    </li>
                    <li>
                     <a href="'.$view.'"  class="dropdown-item font_14_semibold text_dark_opacity">
                        <img src="'.$eyeImage.'" alt="view invoice" class="me-3">
                        View
                        </a> 
                        </li>
                    <li>
                        <a href="#"  class="dropdown-item font_14_semibold text_dark_opacity" onclick="delete_data(this,   `'. $delete .'`,'.$row->id.')">
                        <img src="'.$deleteImage.'" alt="view invoice" class="me-3">
                            Delete
                        </a>
                    </li>
                    </ul>
                </div>';
        

        $i++;
        $data[] = array(
            'sno'=> $i, 
            "make" => @$row->Make->name,
            "model" => @$row->ModelVehicle->name,
            "license_plate" => $row->license_plate,
            "action" => $action,
        );
    }

    ## Response
    $totalRecords = Vehicle::get()->count();
    $response = array(
        "draw" => intval($draw),
        "iTotalRecords" => $totalRecords,
        "iTotalDisplayRecords" => $totalRecordwithFilter,
        "aaData" => $data
    );

    echo json_encode($response);
}



public function edit($id)
{  
    
   
    $vehicle_owners = VehicleOwner::where('status',1)->get();
    $drivers = Driver::all();
    $makes = Make::all(); 
    $uinfo = Vehicle::where('id',$id)->first();
    $insurance = Insurance::where('vehicle_id',$id)->first();
    $puc = Puc::where('vehicle_id',$id)->first(); 
    $models = ModelVehicle::where('make_id',$uinfo->make)->get(); 
    return  view('vendor.vehicle.edit',compact('drivers','uinfo','vehicle_owners','makes','models','puc','insurance'));
}

public function view($id)
{ 
    $vehicle_owners = VehicleOwner::where('status',1)->get();
    $drivers = Driver::all();
    $uinfo = Vehicle::where('id',$id)->first(); 
    $insurance = Insurance::where('vehicle_id',$id)->first();
    $puc = Puc::where('vehicle_id',$id)->first();
    return view('vendor.vehicle.view',compact('drivers','uinfo','vehicle_owners','insurance','puc'));  
}

public function delete($id)
{ 
    Vehicle::where('id',$id)->delete();  
    return response()->json(['success'=>1,'message' => 'Vehicle Delete successfully']);
}

public function getmodel(Request $request)
{ 
    $models = ModelVehicle::where('make_id',$request->make_id)->get();
    // echo "<pre>"; print_r($cities);
    $options= '<option selected>Select Model</option>';
    foreach ($models as $model){ 
    $options .='<option value="'.$model->id.'">'. $model->name.'</option>';
    }
  
    return response()->json(['status' => 1, 'options' => $options]);
}

}
?>