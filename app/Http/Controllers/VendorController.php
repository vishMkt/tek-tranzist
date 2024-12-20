<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator; 
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Twilio\Rest\Client; 

class VendorController extends Controller
{
    public function index()
    {
      $data['nav']= "Vendor";
      return view('vendor.index',$data);
    }

    public function create()
{ 
    return  view('vendor.create'); 
}

public function store(Request $request)
{ 
    
    // Validate request data
    $request->validate([
        'email' => 'required|email|unique:vendors,email,' . $request->user_id,
        'firstname' => 'required|string|max:255',
        'lastname' => 'required|string|max:255',
        'mobile' => 'required|string|max:15',
        'password' => 'required|confirmed|min:8',
        'image_id' => 'required',
    ]);

    // Create a new vendor
    $vendor = new vendor();
    $vendor->firstname = $request->firstname;
    $vendor->lastname = $request->lastname;
    $vendor->email = $request->email;
    $vendor->mobile = $request->mobile;
    $vendor->image_id = $request->image_id;
    $vendor->password = Hash::make($request->password); // Hash the password before storing it

    // Save the vendor to the database
    $vendor->save();

    // Return success response
    return response()->json(['status' => 1, 'message' => 'Vendor created successfully']);
 
}

public function update_data(Request $request)
{  
    $id = $request->id ; 
    $request->validate([ 
        'firstname' => 'required|string|max:255',
        'lastname' => 'required|string|max:255',
        'mobile' => 'required|string|max:15',
        'password' => 'nullable|confirmed|min:8', 
        'image_id' => 'required',

    ]);
 
    $vendor = Vendor::find($id);
 
    if (!$vendor) {
        return response()->json(['status' => 0, 'message' => 'Vendor not found'], 404);
    }
 
    $vendor->firstname = $request->firstname;
    $vendor->lastname = $request->lastname;
    $vendor->email = $request->email;
    $vendor->image_id = $request->image_id; 
    $vendor->mobile = $request->mobile;
 
    if ($request->filled('password')) {
        $vendor->password = Hash::make($request->password); 
    } 
    $vendor->save();

    // Return success response
    return response()->json(['status' => 1, 'message' => 'Vendor updated successfully']);
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

    $qry = Vendor::select('*')->where('vendors.firstname', 'LIKE', '%' . $searchValue . '%')
        ->orderBy('vendors.created_at', 'DESC');

    if (isset($request->searchname)) {
        $qry->where('vendors.firstname', 'LIKE', '%' . $request->searchname . '%');
    }

    $result = $qry->get();
    $totalRecordwithFilter = $result->count();
    $result = $qry->offset($row)->take($rowperpage)->get();

    $data = array();
    foreach ($result as $row) {

        $view = route('view.vendor', $row->id);
        $edit = route('edit.vendor', $row->id);
        $delete = route('delete.vendor', $row->id);
        $eyeImage = asset('assets/icon/eye.svg');
        $editImage = asset('assets/icon/Report_icon.svg');
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

                $checked = '';
                if($row->status==1){
                  $checked = 'checked';
                }

                $status = '<div class="form-check form-switch">
                                <input class="form-check-input shadow-none" type="checkbox" id="flexSwitchCheckDefault" onclick="statusRow(this,`'.route('vendors.status',[$row->id]).'`)" '.$checked.'>
                            </div>';
        

        $i++;
        $data[] = array(
            "sno" => $i,
            "name" => $row->firstname . ' ' . $row->lastname,
            "email" => $row->email,
            "phone" => $row->mobile,
            "status" => $status,
            "action" => $action,
        );
    }

    ## Response
    $totalRecords = Vendor::get()->count();
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
    $data['uinfo'] = Vendor::where('id',$id)->first();
    return  view('vendor.edit',$data); 
     
}

public function view($id)
{ 
    $data['uinfo'] = Vendor::where('id',$id)->first();
    return view('vendor.view',$data); 
     
}


public function delete($id)
{ 
    Vendor::where('id',$id)->delete();  
    return response()->json(['success'=>1,'message' => 'Vendor Delete successfully']);
}

public function updateStatus(Request $request)
{
    $row = Vendor::find($request->id);
    if ($row) {
        $row->status = $request->status;
        // echo  $row->status;die;
        $row->save();
        return response()->json(['success'=> 1,'message' => 'Status updated successfully.']);
    }
    return response()->json(['message' => 'Record not found.'], 404);
}

}
?>