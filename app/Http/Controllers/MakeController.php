<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;  
use App\Models\Make; 
use Illuminate\Http\Request;  

class MakeController extends Controller
{

    public function index()
    { 
      $data['nav']= "Make";
      return view('make.index',$data);
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

    $qry = Make::select('*')->orderBy('makes.created_at', 'DESC');

    if (isset($request->searchname)) {
        $qry->where('makes.name', 'LIKE', '%' . $request->searchname . '%'); 
    }

    $result = $qry->get();
    $totalRecordwithFilter = $result->count();
    $result = $qry->offset($row)->take($rowperpage)->get();

    // echo "<pre>";print_r($result);die;
    $data = array();
    foreach ($result as $row) {

        $showdetails = route('show.make', $row->id);
        $edit = route('edit.make', $row->id);
        $delete = route('delete.make', $row->id);
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
 
 
        

        $i++;
        $data[] = array(
            'sno'=> $i,
            "name" => $row->name, 
            "action" => $action, 
        );
    }

    ## Response
    $totalRecords = Make::get()->count();
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
     
    $view =  view('make.create')->render(); 
    
    return response()->json(['success'=>1,'view'=>$view]);
}

public function store(Request $request)
{ 
    // Validate request data
    $request->validate([
        'name' => 'required', 
    ]);

    // Create a new make
    $make = new make();
    $make->name = $request->name; 
    $make->save();

    // Return success response
    return response()->json(['status' => 1, 'message' => 'Make created successfully']);
 
} 

public function edit($id)
{   
    $uinfo = Make::where('id',$id)->first(); 
    $view =  view('make.edit',compact('uinfo'))->render(); 
    
    return response()->json(['success'=>1,'view'=>$view]);
}
public function show($id)
{  
    $uinfo = Make::where('id',$id)->first(); 
    $view =  view('make.view',compact('uinfo'))->render(); 
    
    return response()->json(['success'=>1,'view'=>$view]);
}
 
public function update_data(Request $request)
{ 

    $id = $request->id ; 
    $request->validate([  
        'name' => 'required',
    ]);
 
    $make = Make::find($id);
 
    if (!$make) {
        return response()->json(['status' => 0, 'message' => 'Make not found'], 404);
    }

    $make->name = $request->name; 
    $make->save();
 
    return response()->json(['status' => 1, 'message' => 'Make updated successfully']);
}
  
public function delete($id)
{ 
    Make::where('id',$id)->delete();  
    return response()->json(['success'=>1,'message' => 'Make Delete successfully']);
} 
}
?>