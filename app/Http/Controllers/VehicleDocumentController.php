<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use App\Models\Puc;
use App\Models\Driver;
use App\Models\License;
use App\Models\Insurance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator; 
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Twilio\Rest\Client; 

class VehicleDocumentController extends Controller
{

    public function index()
    {
      $data['nav']= "License";
      return view('license.index',$data);
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

    $qry = License::select('*')->orderBy('licenses.created_at', 'DESC');

    if (isset($request->searchname)) {
        $qry->where('licenses.licence_number', 'LIKE', '%' . $request->searchname . '%'); 
    }

    $result = $qry->get();
    $totalRecordwithFilter = $result->count();
    $result = $qry->offset($row)->take($rowperpage)->get();

    // echo "<pre>";print_r($result);die;
    $data = array();
    foreach ($result as $row) {

        $showdetails = route('show.license', $row->id);
        $edit = route('edit.license', $row->id);
        $delete = route('delete.license', $row->id);
        $viewImage = asset('assets/icon/eye.svg');
        $editImage = asset('assets/icon/Report_icon.svg');
        $deleteImage = asset('assets/icon/Delete_icon.svg');

        $action = '<div class=" custom_dropdown">
                    <div class="dropdown-toggle dropdown-toggle-nocaret cursor-pointer" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-solid fa-ellipsis"></i>
                    </div>
                    <ul class="dropdown-menu text-dark  border" style="margin: 0px; border-radius: 5px;">
                    <li>
                        <a href="javascript:void(0)" onclick="viewdetail(this,`' . $showdetails . '`)" class="dropdown-item font_14_semibold text_dark_opacity">
                        <img src="' . $viewImage . '" alt="view invoice" class="me-3">
                        View Details
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)" onclick="edit(this,`'.$edit.'`)"  class="dropdown-item font_14_semibold text_dark_opacity">
                        <img src="'.$editImage.'" alt="view invoice" class="me-3">
                        Edit
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

            $checked = '';
            if ($row->status == 1) {
                $checked = 'checked';
            }

            $status = '<div class="form-check form-switch">
                        <input class="form-check-input shadow-none" type="checkbox" id="flexSwitchCheckDefault" onclick="statusRow(this,`' . route('license.status', [$row->id]) . '`)" ' . $checked . '>
                    </div>';
        

        $i++;
        $data[] = array(
            'sno'=> $i,
            "driver" => $row->driver->firstname . ' ' . $row->driver->lastname,
            "number" => $row->license_number,
            "issue_date" => $row->issue_date,
            "valid_upto" => $row->valide_upto,
            "status" => $status,
            "action" => $action,
        );
    }

    ## Response
    $totalRecords = License::get()->count();
    $response = array(
        "draw" => intval($draw),
        "iTotalRecords" => $totalRecords,
        "iTotalDisplayRecords" => $totalRecordwithFilter,
        "aaData" => $data
    );

    echo json_encode($response);
}


    public function create()
{  
    
    $drivers = Driver::all();
    $view =  view('license.create',compact('drivers'))->render(); 
    
    return response()->json(['success'=>1,'view'=>$view]);
}

public function store(Request $request)
{ 
    // Validate request data
    $request->validate([
        'license_number' => 'required',
        'issue_date' => 'required|max:255',
        'valide_upto' => 'required|string|max:255',
        'driver_id' => 'required',  
        'image_id' => 'required', 
        'image_id_back' => 'required', 
    ]);

    // Create a new license
    $license = new License();
    $license->license_number = $request->license_number;
    $license->issue_date = $request->issue_date;
    $license->valide_upto = $request->valide_upto;
    $license->driver_id = $request->driver_id;   
    $license->front_image = $request->image_id;  
    $license->back_image = $request->image_id_back;  
    $license->save();

    // Return success response
    return response()->json(['status' => 1, 'message' => 'License created successfully']);
 
} 

public function edit($id)
{  
    $drivers = Driver::all();
    $uinfo = License::where('id',$id)->first(); 
    $view =  view('license.edit',compact('uinfo','drivers'))->render(); 
    
    return response()->json(['success'=>1,'view'=>$view]);
}
public function show($id)
{  
    $drivers = Driver::all();
    $uinfo = License::where('id',$id)->first(); 
    $view =  view('license.view',compact('uinfo','drivers'))->render(); 
    
    return response()->json(['success'=>1,'view'=>$view]);
}
 
public function update_data(Request $request)
{ 

    $id = $request->id ; 
    $request->validate([  
        'license_number' => 'required',
        'issue_date' => 'required|max:255',
        'valide_upto' => 'required|string|max:255',
        'driver_id' => 'required', 
        'image_id' => 'required', 
        'image_id_back' => 'required', 
    ]);
 
    $license = License::find($id);
 
    if (!$license) {
        return response()->json(['status' => 0, 'message' => 'License not found'], 404);
    }

    $license->license_number = $request->license_number;
    $license->issue_date = $request->issue_date;
    $license->valide_upto = $request->valide_upto;
    $license->driver_id = $request->driver_id;  
    $license->front_image = $request->image_id;  
    $license->back_image = $request->image_id_back;  
    $license->save();
 
    return response()->json(['status' => 1, 'message' => 'License updated successfully']);
}
  
public function delete($id)
{ 
    License::where('id',$id)->delete();  
    return response()->json(['success'=>1,'message' => 'License Delete successfully']);
}

public function updateStatus(Request $request)
{
    $row = License::find($request->id);

    if ($row) {
        $row->status = $request->status;
        $row->save();
        return response()->json(['success'=> 1 ,'message' => 'Status updated successfully.']);
    }

    return response()->json(['message' => 'Record not found.'], 404);
}


// PUC



public function index_puc()
    {
      $data['nav']= "PUC";
      return view('puc.index',$data);
    } 
    
public function list_puc(Request $request)
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

    $qry = Puc::select('*')->orderBy('pucs.created_at', 'DESC');

    if (isset($request->searchname)) {
        $qry->where('pucs.vehicle_number', 'LIKE', '%' . $request->searchname . '%'); 
    }

    $result = $qry->get();
    $totalRecordwithFilter = $result->count();
    $result = $qry->offset($row)->take($rowperpage)->get();

    // echo "<pre>";print_r($result);die;
    $data = array();
    foreach ($result as $row) {

        $showdetails = route('show.puc', $row->id);
        $edit = route('edit.puc', $row->id);
        $delete = route('delete.puc', $row->id);
        $viewImage = asset('assets/icon/eye.svg');
        $editImage = asset('assets/icon/Report_icon.svg');
        $deleteImage = asset('assets/icon/Delete_icon.svg');

        $action = '<div class=" custom_dropdown">
                    <div class="dropdown-toggle dropdown-toggle-nocaret cursor-pointer" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-solid fa-ellipsis"></i>
                    </div>
                    <ul class="dropdown-menu text-dark  border" style="margin: 0px; border-radius: 5px;">
                     <li>
                        <a href="javascript:void(0)" onclick="viewdetail(this,`' . $showdetails . '`)" class="dropdown-item font_14_semibold text_dark_opacity">
                        <img src="' . $viewImage . '" alt="view invoice" class="me-3">
                        View Details
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)" onclick="edit(this,`'.$edit.'`)"  class="dropdown-item font_14_semibold text_dark_opacity">
                        <img src="'.$editImage.'" alt="view invoice" class="me-3">
                        Edit
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

                $checked = '';
                if ($row->status == 1) {
                    $checked = 'checked';
                }
    
                $status = '<div class="form-check form-switch">
                            <input class="form-check-input shadow-none" type="checkbox" id="flexSwitchCheckDefault" onclick="statusRow(this,`' . route('puc.status', [$row->id]) . '`)" ' . $checked . '>
                        </div>';
            
        $i++;
        $data[] = array(
            'sno'=> $i,
            "driver" => $row->driver->firstname . ' ' . $row->driver->lastname,
            "vehicle_number" => $row->vehicle_number,
            "owner_name" => $row->owner_name,
            "puc_certificate_number" => $row->puc_certificate_number,
            "status" => $status,
            "action" => $action,
        );
    }

    ## Response
    $totalRecords = Puc::get()->count();
    $response = array(
        "draw" => intval($draw),
        "iTotalRecords" => $totalRecords,
        "iTotalDisplayRecords" => $totalRecordwithFilter,
        "aaData" => $data
    );

    echo json_encode($response);
}


    public function create_puc()
{  
    
    $drivers = Driver::all();
    $view =  view('puc.create',compact('drivers'))->render(); 
    
    return response()->json(['success'=>1,'view'=>$view]);
}

public function store_puc(Request $request)
{ 

    
    // Validate request data
    $request->validate([
        'vehicle_number' => 'required',
        'owner_name' => 'required|max:255',
        'puc_certificate_number' => 'required|max:255',
        'puc_issue_date' => 'required|max:255',
        'puc_expiry_date' => 'required|max:255',
        'driver_id' => 'required',  
        'image_id' => 'required', 
        'image_id_back' => 'required', 
    ]);

    // Create a new PUC
    $puc = new Puc();
    $puc->vehicle_number = $request->vehicle_number;
    $puc->owner_name = $request->owner_name;
    $puc->puc_certificate_number = $request->puc_certificate_number;
    $puc->puc_issue_date = $request->puc_issue_date;
    $puc->puc_expiry_date = $request->puc_expiry_date; 
    $puc->driver_id = $request->driver_id;   
    $puc->front_image = $request->image_id;  
    $puc->back_image = $request->image_id_back;  
    $puc->save();

    // Return success response
    return response()->json(['status' => 1, 'message' => 'PUC created successfully']);
 
} 

public function edit_puc($id)
{  
    $drivers = Driver::all();
    $uinfo = Puc::where('id',$id)->first(); 
    $view =  view('puc.edit',compact('uinfo','drivers'))->render(); 
    
    return response()->json(['success'=>1,'view'=>$view]);
}
public function show_puc($id)
{  
    $drivers = Driver::all();
    $uinfo = Puc::where('id',$id)->first(); 
    $view =  view('puc.view',compact('uinfo','drivers'))->render(); 
    
    return response()->json(['success'=>1,'view'=>$view]);
}
 
public function update_data_puc(Request $request)
{ 

    $id = $request->id ; 
    $request->validate([  
        'vehicle_number' => 'required',
        'owner_name' => 'required|max:255',
        'puc_certificate_number' => 'required|max:255',
        'puc_issue_date' => 'required|max:255',
        'puc_expiry_date' => 'required|max:255',
        'driver_id' => 'required',  
        'image_id' => 'required', 
        'image_id_back' => 'required', 
    ]);
 
    $puc = Puc::find($id);
 
    if (!$puc) {
        return response()->json(['status' => 0, 'message' => 'PUC not found'], 404);
    }

    $puc->vehicle_number = $request->vehicle_number;
    $puc->owner_name = $request->owner_name;
    $puc->puc_certificate_number = $request->puc_certificate_number;
    $puc->puc_issue_date = $request->puc_issue_date;
    $puc->puc_expiry_date = $request->puc_expiry_date; 
    $puc->driver_id = $request->driver_id;   
    $puc->front_image = $request->image_id;  
    $puc->back_image = $request->image_id_back;  
    $puc->save();
 
    return response()->json(['status' => 1, 'message' => 'PUC updated successfully']);
}
  
public function delete_puc($id)
{ 
    Puc::where('id',$id)->delete();  
    return response()->json(['success'=>1,'message' => 'PUC Delete successfully']);
}

public function pucStatus(Request $request)
{
    $row = Puc::find($request->id);

    if ($row) {
        $row->status = $request->status;
        $row->save();
        return response()->json(['success'=> 1 ,'message' => 'Status updated successfully.']);
    }

    return response()->json(['message' => 'Record not found.'], 404);
}


// INSURANCE



public function index_insurance()
    {
      $data['nav']= "Insurance";
      return view('insurance.index',$data);
    } 
    
public function list_insurance(Request $request)
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

    $qry = Insurance::select('*')->orderBy('insurances.created_at', 'DESC');

    if (isset($request->searchname)) {
        $qry->where('insurances.policy_number', 'LIKE', '%' . $request->searchname . '%'); 
    }

    $result = $qry->get();
    $totalRecordwithFilter = $result->count();
    $result = $qry->offset($row)->take($rowperpage)->get();

    // echo "<pre>";print_r($result);die;
    $data = array();
    foreach ($result as $row) {

        $action = '<div class="btn-showcase">';

        $action .= '<button type="button" class="btn btn-success mx-1" onclick="edit(this, \'' . route('edit.insurance', $row->id) . '\')"><i class="fa fa-pencil" aria-hidden="true"></i></button>';
        
        $action .= '<button type="button"  class="btn btn-danger mx-1" onclick="delete_data(this, \'' . route('delete.insurance', $row->id) . '\')"><i class="fa fa-trash" aria-hidden="true"></i></button>';
        
        $action .= '</div>';

        $showdetails = route('show.insurance', $row->id);
        $edit = route('edit.insurance', $row->id);
        $delete = route('delete.insurance', $row->id);
        $viewImage = asset('assets/icon/eye.svg');
        $editImage = asset('assets/icon/Report_icon.svg');
        $deleteImage = asset('assets/icon/Delete_icon.svg');

        $action = '<div class=" custom_dropdown">
                    <div class="dropdown-toggle dropdown-toggle-nocaret cursor-pointer" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-solid fa-ellipsis"></i>
                    </div>
                    <ul class="dropdown-menu text-dark  border" style="margin: 0px; border-radius: 5px;">
                    <li>
                        <a href="javascript:void(0)" onclick="viewdetail(this,`' . $showdetails . '`)" class="dropdown-item font_14_semibold text_dark_opacity">
                        <img src="' . $viewImage . '" alt="view invoice" class="me-3">
                        View Details
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)" onclick="edit(this,`'.$edit.'`)"  class="dropdown-item font_14_semibold text_dark_opacity">
                        <img src="'.$editImage.'" alt="view invoice" class="me-3">
                        Edit
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
        
                $checked = '';
                if ($row->status == 1) {
                    $checked = 'checked';
                }
    
                $status = '<div class="form-check form-switch">
                            <input class="form-check-input shadow-none" type="checkbox" id="flexSwitchCheckDefault" onclick="statusRow(this,`' . route('insurance.status', [$row->id]) . '`)" ' . $checked . '>
                        </div>';

        $i++;
        $data[] = array(
            'sno'=> $i,
            "driver" => $row->driver->firstname . ' ' . $row->driver->lastname,
            "policy_number" => $row->policy_number,
            "provider" => $row->provider,
            "issue_date" => $row->issue_date,
            "expiry_date" => $row->expiry_date,
            "status" => $status,
            "action" => $action,
        );
    }

    ## Response
    $totalRecords = Insurance::get()->count();
    $response = array(
        "draw" => intval($draw),
        "iTotalRecords" => $totalRecords,
        "iTotalDisplayRecords" => $totalRecordwithFilter,
        "aaData" => $data
    );

    echo json_encode($response);
}


    public function create_insurance()
{  
    
    $drivers = Driver::all();
    $view =  view('insurance.create',compact('drivers'))->render(); 
    
    return response()->json(['success'=>1,'view'=>$view]);
}

public function store_insurance(Request $request)
{ 

    
    // Validate request data
    $request->validate([
        'policy_number' => 'required',
        'provider' => 'required|max:255',
        'issue_date' => 'required|max:255',
        'expiry_date' => 'required|max:255', 
        'driver_id' => 'required',  
        'image_id' => 'required', 
        'image_id_back' => 'required', 
    ]);

    // Create a new insurance
    $insurance = new Insurance();
    $insurance->policy_number = $request->policy_number;
    $insurance->provider = $request->provider; 
    $insurance->issue_date = $request->issue_date;
    $insurance->expiry_date = $request->expiry_date; 
    $insurance->driver_id = $request->driver_id;   
    $insurance->front_image = $request->image_id;  
    $insurance->back_image = $request->image_id_back;  
    $insurance->save();

    // Return success response
    return response()->json(['status' => 1, 'message' => 'Insurance created successfully']);
 
} 

public function edit_insurance($id)
{  
    $drivers = Driver::all();
    $uinfo = Insurance::where('id',$id)->first(); 
    $view =  view('insurance.edit',compact('uinfo','drivers'))->render(); 
    
    return response()->json(['success'=>1,'view'=>$view]);
}
public function show_insurance($id)
{  
    $drivers = Driver::all();
    $uinfo = Insurance::where('id',$id)->first(); 
    $view =  view('insurance.view',compact('uinfo','drivers'))->render(); 
    
    return response()->json(['success'=>1,'view'=>$view]);
}
 
public function update_data_insurance(Request $request)
{ 

    $id = $request->id ; 
    $request->validate([  
        'policy_number' => 'required',
        'provider' => 'required|max:255',
        'issue_date' => 'required|max:255',
        'expiry_date' => 'required|max:255', 
        'driver_id' => 'required',  
        'image_id' => 'required', 
        'image_id_back' => 'required',
    ]);
 
    $insurance = Insurance::find($id);
 
    if (!$insurance) {
        return response()->json(['status' => 0, 'message' => 'Insurance not found'], 404);
    }

    $insurance->policy_number = $request->policy_number;
    $insurance->provider = $request->provider; 
    $insurance->issue_date = $request->issue_date;
    $insurance->expiry_date = $request->expiry_date; 
    $insurance->driver_id = $request->driver_id;   
    $insurance->front_image = $request->image_id;  
    $insurance->back_image = $request->image_id_back;  
    $insurance->save();
 
    return response()->json(['status' => 1, 'message' => 'Insurance updated successfully']);
}
  
public function delete_insurance($id)
{ 
    Insurance::where('id',$id)->delete();  
    return response()->json(['success'=>1,'message' => 'Insurance Delete successfully']);
}

public function insuranceStatus(Request $request)
{
    $row = Insurance::find($request->id);

    if ($row) {
        $row->status = $request->status;
        $row->save();
        return response()->json(['success'=> 1 ,'message' => 'Status updated successfully.']);
    }

    return response()->json(['message' => 'Record not found.'], 404);
}

}
?>