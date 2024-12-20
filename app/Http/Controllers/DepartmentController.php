<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;

class DepartmentController extends Controller
{
    public function index()
    {
        $data['title']= "Departments";
        $data['nav']= "Departments";
        return view('departments.index',$data);
    }

    public function create()
    { 
        return  view('departments.create');  
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'code' => 'required|string|unique:departments,code',
            'phone' => 'nullable|numeric',
            'email' => 'nullable|email|unique:departments,email',
            'status' => 'required|boolean',
        ]);

        Department::create($data);

        return response()->json(['status' => 1, 'message' => 'Department added successfully!']);
    }

    public function edit($id)
    { 
        $data['department'] = Department::where('id',$id)->first();
        return view('departments.edit',$data); 
        
    }
    
    public function view($id)
    { 
        $data['department'] = Department::where('id',$id)->first();
        return  view('departments.view',$data); 
    }

    public function update(Request $request)
    {
        $department = Department::find($request->id);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'code' => "required|string|unique:departments,code,{$request->id}",
            'phone' => 'nullable|numeric',
            'email' => "nullable|email|unique:departments,email,{$request->id}",
            'status' => 'required|boolean',
        ]);

        $department->update($data);

        return response()->json(['status' => 1, 'message' => 'Department updated successfully!']);
    }

    public function destroy($id)
    {
        Department::find($id)->delete();

        return response()->json(['success' => 'Department deleted successfully!']);
    }

    public function getDepartments(Request $request)
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

        $qry = Department::select('*')->where('departments.name', 'LIKE', '%' . $searchValue . '%')
            ->orderBy('departments.created_at', 'DESC');

        if (isset($request->searchname)) {
            $qry->where('departments.name', 'LIKE', '%' . $request->searchname . '%');
        }
        $result = $qry->get();
        $totalRecordwithFilter = $result->count();
        $result = $qry->offset($row)->take($rowperpage)->get();

        $data = array();
        $sno = 1;
        foreach ($result as $row) {
            
            $edit = route('departments.edit', $row->id);
            $view = route('departments.view', $row->id);
            $delete = route('departments.delete', $row->id);
            $editImage = asset('assets/icon/Report_icon.svg');
            $eyeImage = asset('assets/icon/eye.svg');
            $deleteImage = asset('assets/icon/Delete_icon.svg');

            $action = '<div class="dropdown custom_dropdown">
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

                    $checked = '';
                    if($row->status==1){
                      $checked = 'checked';
                    }

              $status = '<div class="form-check form-switch">
                                                <input class="form-check-input shadow-none" type="checkbox" id="flexSwitchCheckDefault" onclick="statusRow(this,`'.route('departments.status',[$row->id]).'`)" '.$checked.'>
                                            </div>';
            

            $i++;
            $data[] = array(
                "sno" => $sno++,
                "name" => $row->name,
                "description" => $row->description,
                "code" => $row->code,
                "email" => $row->email,
                "phone" => $row->phone,
                "status" => $status,
                "action" => $action,
            );
        }

        ## Response
        $totalRecords = Department::get()->count();
        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordwithFilter,
            "aaData" => $data
        );

        echo json_encode($response);
    }

    public function status(Request $request, $id) 
    {
        Department::where('id',$id)->update(['status'=>$request->status]);
        return response()->json(['success'=>1,'message'=>'Department status change successfully.']);
    }
}
