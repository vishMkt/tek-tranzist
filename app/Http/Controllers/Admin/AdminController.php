<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
      $data['nav']= "Dashboard";
      return view('admin.dashboard');
    }

    public function users()
    {
        $data['title']= "Users";
        $data['nav']= "users";
        return view('admin.users.index',$data);
    }

    public function create()
    { 
        $data['nav']= "Create Users";
        return view('admin.users.create',$data);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:admins,email',
            'status' => 'required|boolean',
            'password' => 'nullable|confirmed|min:8', 
        ]);

        Admin::create($data);

        return response()->json(['status' => 1, 'message' => 'User added successfully!']);
    }

    public function edit($id)
    { 
        $data['nav']= "Edit Users";
        $data['department'] = Admin::where('id',$id)->first();
        return view('admin.users.edit',$data);
    }
    
    public function view($id)
    { 
        $data['nav']= "View Users";
        $data['department'] = Admin::where('id',$id)->first();
        return  view('admin.users.view',$data);
    }

    public function update(Request $request)
    {
       
        $rules = [
            'name' => 'required|string|max:255',
            'email' => "nullable|email|unique:admins,email,{$request->id}",
            'status' => 'required|boolean',
            'password' => 'nullable|confirmed|min:8', 
        ];

        $request->validate( $rules );

        $department = Admin::find($request->id);
        if (!$department) {
            return response()->json(['status' => 0, 'message' => 'User not found'], 404);
        }

        $department->name = $request->input('name');
        $department->email = $request->input('email');
        $department->status = $request->input('status');

        if ($request->filled('password')) {
            $department->password = Hash::make($request->input('password'));
        }

        $department->save();

        return response()->json(['status' => 1, 'message' => 'User updated successfully!']);
    }

    public function destroy($id)
    {
      Admin::find($id)->delete();

        return response()->json(['success' => 'User deleted successfully!']);
    }

    public function getUsers(Request $request)
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

        $qry = Admin::select('*')->where('admins.name', 'LIKE', '%' . $searchValue . '%')
            ->orderBy('admins.created_at', 'DESC');

        if (isset($request->searchname)) {
            $qry->where('admins.name', 'LIKE', '%' . $request->searchname . '%');
        }

        $qry->whereNot('admins.id', 1);
        $result = $qry->get();
        $totalRecordwithFilter = $result->count();
        $result = $qry->offset($row)->take($rowperpage)->get();

        $data = array();
        $sno = 1;
        foreach ($result as $row) {
            
            $edit = route('users.edit', $row->id);
            $view = route('users.view', $row->id);
            $delete = route('users.delete', $row->id);
            $editImage = asset('assets/icon/Report_icon.svg');
            $eyeImage = asset('assets/icon/eye.svg');
            $deleteImage = asset('assets/icon/Delete_icon.svg');

            $action = '<div class=" custom_dropdown">
                        <div class="dropdown-toggle dropdown-toggle-nocaret cursor-pointer" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-ellipsis"></i>
                        </div>
                        <ul class="dropdown-menu text-dark  border" style="margin: 0px; border-radius: 5px;">
                        <li>
                            <a href="' . $edit . '" class="dropdown-item font_14_semibold text_dark_opacity">
                            <img src="'.$editImage.'" alt="view invoice" class="me-3">
                            Edit
                            </a>
                        </li>
                        <li>
                            <a href="' . $view . '"  class="dropdown-item font_14_semibold text_dark_opacity">
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
                                                <input class="form-check-input shadow-none" type="checkbox" id="flexSwitchCheckDefault" onclick="statusRow(this,`'.route('users.status',[$row->id]).'`)" '.$checked.'>
                                            </div>';
            

            $i++;
            $data[] = array(
                "sno" => $sno++,
                "name" => $row->name,
                "email" => $row->email,
                "status" => $status,
                "action" => $action,
            );
        }

        ## Response
        $totalRecords = Admin::get()->count();
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
        Admin::where('id',$id)->update(['status'=>$request->status]);
        return response()->json(['success'=>1,'message'=>'User status change successfully.']);
    }
}

?>