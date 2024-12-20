<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Companie; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;  

class CompaniesController extends Controller
{
    public function index()
    {
      $data['nav']= "Companies";
      return view('companies.index',$data);
    }

    public function create()
{ 
    return  view('companies.create'); 
    
}

public function store(Request $request)
{ 
    
    // Validate request data
    $request->validate([
        'email' => 'required|email|unique:companies',
        'name' => 'required|string|max:255', 
        'mobile' => 'required|numeric', 
        'status' => 'required',  
        'password' => 'required|confirmed|min:8',
        'image_id' => 'required',
        'address' => 'required',
    ]);

    // Create a new Companies
    $companies = new Companie();
    $companies->name = $request->name; 
    $companies->email = $request->email;
    $companies->mobile = $request->mobile; 
    $companies->status = $request->status;  
    $companies->image_id = $request->image_id;  
    $companies->address = $request->address;  
    $companies->password = Hash::make($request->password); // Hash the password before storing it
    // Save the Companies to the database
    $companies->save();

    // Return success response
    return response()->json(['status' => 1, 'message' => 'Companies created successfully']);
 
}

public function update_data(Request $request)
{ 
    $id = $request->id ; 
    $request->validate([ 
        'name' => 'required|string|max:255', 
        'mobile' => 'required|numeric',
        'status' => 'required',  
        'password' => 'nullable|confirmed|min:8',
        'image_id' => 'required',
        'address' => 'required',
        
    ]);
 
    $companies = Companie::find($id);
 
    if (!$companies) {
        return response()->json(['status' => 0, 'message' => 'Companies not found'], 404);
    }
 
  
    $companies->name = $request->name;
    $companies->email = $request->email;
    $companies->mobile = $request->mobile; 
    $companies->status = $request->status;  
    $companies->address = $request->address;  
    $companies->image_id = $request->image_id;  

    if ($request->filled('password')) {
        $companies->password = Hash::make($request->password); 
    } 

    $companies->save();

    // Return success response
    return response()->json(['status' => 1, 'message' => 'Companies updated successfully']);
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

    $qry = Companie::select('*')->where('companies.name', 'LIKE', '%' . $searchValue . '%')
        ->orderBy('companies.created_at', 'DESC');

    if (isset($request->searchname)) {
        $qry->where('companies.name', 'LIKE', '%' . $request->searchname . '%');
    }

    $result = $qry->get();
    $totalRecordwithFilter = $result->count();
    $result = $qry->offset($row)->take($rowperpage)->get();

    $data = array();
    foreach ($result as $row) {

        $view = route('show.companies', $row->id);
        $edit = route('edit.companies', $row->id);
        $delete = route('delete.companies', $row->id);
        $editImage = asset('assets/icon/Report_icon.svg');
        $deleteImage = asset('assets/icon/Delete_icon.svg');
        $eyeImage = asset('assets/icon/eye.svg');

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
                        <input class="form-check-input shadow-none" type="checkbox" id="flexSwitchCheckDefault" onclick="statusRow(this,`'.route('companies.status',[$row->id]).'`)" '.$checked.'>
                    </div>';
        
        
        $i++;
        $data[] = array(
            "sno" => $i,
            "name" => $row->name,
            "email" => $row->email,
            "phone" => $row->mobile,
            "status" => $status,
            "action" => $action,
        );
    }

    ## Response
    $totalRecords = Companie::get()->count();
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
    $data['uinfo'] = Companie::where('id',$id)->first(); 
    return  view('companies.edit',$data);
}


public function delete($id)
{ 
    Companie::where('id',$id)->delete();  
    return response()->json(['success'=>1,'message' => 'Companies Delete successfully']);
}

public function updateStatus(Request $request)
{
    $row = Companie::find($request->id);

    if ($row) {
        $row->status = $request->status;
        $row->update();
        return response()->json(['message' => 'Status updated successfully.']);
    }

    return response()->json(['message' => 'Record not found.'], 404);
}

 
 

public function show($id)
{ 
    $data['uinfo'] = Companie::where('id',$id)->first(); 
    return view('companies.view',$data);

}


}
?>