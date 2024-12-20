<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\SecurityGuard; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;  

class SecurityGuardController extends Controller
{
    public function index()
    {
      $data['nav']= "Security Guard";
      return view('security_guard.index',$data);
    }

    public function create()
{ 
    return  view('security_guard.create'); 
}

public function store(Request $request)
{ 
    
    // Validate request data
    $request->validate([
        'email' => 'required|email|unique:security_guards',
        'firstname' => 'required|string|max:255',
        'lastname' => 'required|string|max:255',
        'mobile' => 'required|numeric', 
        'address' => 'required|string|max:500', 
        'status' => 'required',  
        'assigned_location' => 'required|string|max:255',  
        'date_of_Joining' => 'required', 
        'image_id' => 'required', 
        'emergency_contact_information' => 'nullable|string|max:255', 
        'notes' => 'nullable|string|max:500',  
        'image_id_attachment' => 'required',  
    ]);

    // Create a new Security Guard
    $security_guard = new SecurityGuard();
    $security_guard->firstname = $request->firstname;
    $security_guard->lastname = $request->lastname;
    $security_guard->email = $request->email;
    $security_guard->mobile = $request->mobile; 
    $security_guard->address = $request->address; 
    $security_guard->status = $request->status;  
    $security_guard->assigned_location = $request->assigned_location;  
    $security_guard->date_of_Joining = $request->date_of_Joining; 
    $security_guard->image_id = $request->image_id; 
    $security_guard->emergency_contact_information = $request->emergency_contact_information; 
    $security_guard->notes = $request->notes; 
    $security_guard->add_attachment = $request->image_id_attachment;

    // Save the Security Guard to the database
    $security_guard->save();

    // Return success response
    return response()->json(['status' => 1, 'message' => 'Security Guard created successfully']);
 
}

public function update_data(Request $request)
{ 
    $id = $request->id ; 
    $request->validate([ 
        'email' => 'required|email|unique:security_guards,email,' . $id,
        'firstname' => 'required|string|max:255',
        'lastname' => 'required|string|max:255',
        'mobile' => 'required|numeric', 
        'address' => 'required|string|max:500', 
        'status' => 'required',  
        'assigned_location' => 'required|string|max:255',  
        'date_of_Joining' => 'required', 
        'image_id' => 'required', 
        'emergency_contact_information' => 'nullable|string|max:255', 
        'notes' => 'nullable|string|max:500',  
        'image_id_attachment' => 'required',  
    ]);
 
    $security_guard = SecurityGuard::find($id);
 
    if (!$security_guard) {
        return response()->json(['status' => 0, 'message' => 'Security Guard not found'], 404);
    }
 
  
    $security_guard->firstname = $request->firstname;
    $security_guard->lastname = $request->lastname;
    $security_guard->email = $request->email;
    $security_guard->mobile = $request->mobile; 
    $security_guard->address = $request->address; 
    $security_guard->status = $request->status;  
    $security_guard->assigned_location = $request->assigned_location; 
    $security_guard->shift_timing = $request->shift_timing; 
    $security_guard->date_of_Joining = $request->date_of_Joining; 
    $security_guard->image_id = $request->image_id; 
    $security_guard->emergency_contact_information = $request->emergency_contact_information; 
    $security_guard->notes = $request->notes;  
    $security_guard->add_attachment = $request->image_id_attachment;
    

    $security_guard->save();

    // Return success response
    return response()->json(['status' => 1, 'message' => 'Security Guard updated successfully']);
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

    $qry = SecurityGuard::select('*')->where('security_guards.firstname', 'LIKE', '%' . $searchValue . '%')
        ->orderBy('security_guards.created_at', 'DESC');

    if (isset($request->searchname)) {
        $qry->where('security_guards.firstname', 'LIKE', '%' . $request->searchname . '%');
    }

    $result = $qry->get();
    $totalRecordwithFilter = $result->count();
    $result = $qry->offset($row)->take($rowperpage)->get();

    $data = array();
    foreach ($result as $row) {

        $view = route('show.security.guard', $row->id);
        $edit = route('edit.security.guard', $row->id);
        $delete = route('delete.security.guard', $row->id);
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

                $checked = '';
                if($row->status==1){
                  $checked = 'checked';
                }

          $status = '<div class="form-check form-switch">
                        <input class="form-check-input shadow-none" type="checkbox" id="flexSwitchCheckDefault" onclick="statusRow(this,`'.route('security.status',[$row->id]).'`)" '.$checked.'>
                    </div>';
        

        $i++;
        $data[] = array(
            "sno"=> $i,
            "name" => $row->firstname . ' ' . $row->lastname,
            "email" => $row->email,
            "phone" => $row->mobile,
            "status" => $status,
            "action" => $action,
        );
    }

    ## Response
    $totalRecords = SecurityGuard::get()->count();
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
    $data['uinfo'] = SecurityGuard::where('id',$id)->first(); 
    return  view('security_guard.edit',$data);
}

public function show($id)
{ 
    $data['uinfo'] = SecurityGuard::where('id',$id)->first(); 
    return view('security_guard.view',$data);
}


public function delete($id)
{ 
    SecurityGuard::where('id',$id)->delete();  
    return response()->json(['success'=>1,'message' => 'Security Guard Delete successfully']);
}

public function updateStatus(Request $request)
{
    $row = SecurityGuard::find($request->id);

    if ($row) {
        $row->status = $request->status;
        $row->save();
        return response()->json(['success'=> 1,'message' => 'Status updated successfully.']);
    }
    return response()->json(['message' => 'Record not found.'], 404);
}
}
?>