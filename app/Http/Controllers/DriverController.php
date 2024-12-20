<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\Vendor;
use App\Models\License;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator; 
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Twilio\Rest\Client; 

class DriverController extends Controller
{
    public function index()
    {
      $data['nav']= "Driver";
      return view('driver.index',$data);
    }

    public function create()
{ 
  
    $vendors = Vendor::where('status',1)->get();
    return  view('driver.create',compact('vendors'));
}

public function store(Request $request)
{ 
    
    // echo "<pre>";print_r($request->all());die;

    // Validate request data
    $request->validate([
        'email' => 'required|email|unique:drivers',
        'vendor' => 'required',
        'firstname' => 'required|string|max:255',
        'lastname' => 'required|string|max:255',
        'mobile' => 'required|numeric|min:10',
        'password' => 'required|confirmed|min:8', 
        'license_number' => 'required', 
        'valide_upto' => 'required|string|max:255', 
        'image_id' => 'required', 
        'image_id_back' => 'required',  
        'adhar_card' => 'required',  
        'pan_card' => 'required',  
        'image_id_attachment' => 'required',  
    ]);

    // Create a new driver
    $driver = new Driver();
    $driver->firstname = $request->firstname;
    $driver->lastname = $request->lastname;
    $driver->email = $request->email;
    $driver->vendor_id = $request->vendor;
    $driver->mobile = $request->mobile;
    $driver->password = Hash::make($request->password); // Hash the password before storing it 
    $driver->adhar_card = $request->adhar_card;
    $driver->pan_card = $request->pan_card;
    $driver->emergency_contact_information = $request->emergency_contact_information;
    $driver->add_attachment = $request->image_id_attachment;

    // Save the driver to the database
    $driver->save();


    $license = new License();
    $license->license_number = $request->license_number; 
    $license->valide_upto = $request->valide_upto;
    $license->driver_id = $driver->id;   
    $license->front_image = $request->image_id;  
    $license->back_image = $request->image_id_back;  
    $license->save();

    // Return success response
    return response()->json(['status' => 1, 'message' => 'Driver created successfully']);
 
}

public function update_data(Request $request)
{ 
    $id = $request->id ; 
    $request->validate([ 
        'firstname' => 'required|string|max:255',
        'lastname' => 'required|string|max:255',
        'mobile' => 'required|string|min:10',
        'vendor' => 'required',
        'email' => 'required|email|unique:drivers,email,' . $id,
        'password' => 'nullable|confirmed|min:8', 
        'license_number' => 'required', 
        'valide_upto' => 'required|string|max:255', 
        'image_id' => 'required', 
        'image_id_back' => 'required',  
        'adhar_card' => 'required',  
        'pan_card' => 'required',  
        'image_id_attachment' => 'required',  
    ]);
 
    $driver = Driver::find($id);
 
    if (!$driver) {
        return response()->json(['status' => 0, 'message' => 'Driver not found'], 404);
    }
 
    $driver->firstname = $request->firstname;
    $driver->lastname = $request->lastname;
    $driver->email = $request->email;
    $driver->vendor_id = $request->vendor;
    $driver->mobile = $request->mobile;
    $driver->adhar_card = $request->adhar_card;
    $driver->pan_card = $request->pan_card;
    $driver->emergency_contact_information = $request->emergency_contact_information;
    $driver->add_attachment = $request->image_id_attachment;

 
    if ($request->filled('password')) {
        $driver->password = Hash::make($request->password); 
    } 
    $driver->save();



    $license = License::where('driver_id',$id)->first(); 
    $license->license_number = $request->license_number; 
    $license->valide_upto = $request->valide_upto;
    $license->driver_id = $id;  
    $license->front_image = $request->image_id;  
    $license->back_image = $request->image_id_back;  
    $license->save();


    // Return success response
    return response()->json(['status' => 1, 'message' => 'Driver updated successfully']);
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

    $qry = Driver::select('*')->where('drivers.firstname', 'LIKE', '%' . $searchValue . '%')
        ->orderBy('drivers.created_at', 'DESC');

    if (isset($request->searchname)) {
        $qry->where('drivers.firstname', 'LIKE', '%' . $request->searchname . '%');
    }

    $result = $qry->get();
    $totalRecordwithFilter = $result->count();
    $result = $qry->offset($row)->take($rowperpage)->get();

    $data = array();
    foreach ($result as $row) {
        
        $edit = route('edit.driver', $row->id);
        $view = route('driver.view', $row->id);
        $delete = route('delete.driver', $row->id);
        $editImage = asset('assets/icon/Report_icon.svg');
        $eyeImage = asset('assets/icon/eye.svg');
        $deleteImage = asset('assets/icon/Delete_icon.svg');

        $action = '<div class=" custom_dropdown">
                    <div class="dropdown-toggle dropdown-toggle-nocaret cursor-pointer" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-solid fa-ellipsis"></i>
                    </div>
                    <ul class="dropdown-menu text-dark  border" style="margin: 0px; border-radius: 5px;">
                    <li>
                        <a href="'.$edit.'" class="dropdown-item font_14_semibold text_dark_opacity">
                        <img src="'.$editImage.'" alt="view invoice" class="me-3">
                        Edit
                        </a>
                    </li>
                    <li>
                            <a href="'.$view.'" class="dropdown-item font_14_semibold text_dark_opacity">
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
            'sno' => $i,
            "vendor" => @$row->vendor->firstname,
            "name" => $row->firstname . ' ' . $row->lastname,
            "email" => $row->email,
            "phone" => $row->mobile,
            "action" => $action,
        );
    }

    ## Response
    $totalRecords = Driver::get()->count();
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
    $data['nav']= "Driver";
    $data['uinfo'] = Driver::where('id',$id)->first();
    $data['license'] = License::where('driver_id',$id)->first();
    $data['vendors'] = Vendor::where('status',1)->get();
    return  view('driver.edit',$data);
}

public function view($id)
{ 
    $data['uinfo'] = Driver::where('id',$id)->first();
    $data['license'] = License::where('id',$id)->first();
    $data['vendors'] = Vendor::where('status',1)->get();

    return  view('driver.view',$data);
}


public function delete($id)
{ 
    Driver::where('id',$id)->delete();  
    return response()->json(['success'=>1,'message' => 'Driver Delete successfully']);
}

}
?>