<?php
namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use App\Models\Image;
use App\Models\State;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Twilio\Rest\Client;

class EmployeeController extends Controller
{
    public function index()
    {
        $data['nav'] = "Employee";
        return view('company.employee.index', $data);
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

        $qry = User::select('*')->where('company_id',$request->user()->id)->where('users.firstname', 'LIKE', '%' . $searchValue . '%')
            ->orderBy('users.created_at', 'DESC');

        if (isset($request->searchname)) {
            $qry->where('users.firstname', 'LIKE', '%' . $request->searchname . '%');
        }

        $result = $qry->with(['image','countryName','cityName'])->get();
        // echo "<pre>"; print_r($result->toArray());die;
        $totalRecordwithFilter = $result->count();
        $result = $qry->offset($row)->take($rowperpage)->get();

        $data = array();
        foreach ($result as $row) {

            $edit = route('company.employee.edit', $row->id);
            $view = route('company.employee.view', $row->id);
            $delete = route('company.employee.delete', $row->id);
            $editImage = asset('assets/icon/Report_icon.svg');
            $eyeImage = asset('assets/icon/eye.svg');
            $deleteImage = asset('assets/icon/Delete_icon.svg');

            $action = '<div class=" custom_dropdown">
                        <div class="dropdown-toggle dropdown-toggle-nocaret cursor-pointer" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-ellipsis"></i>
                        </div>
                        <ul class="dropdown-menu text-dark  border" style="margin: 0px; border-radius: 5px;">
                        <li>
                            <a href="' . $edit . '"  class="dropdown-item font_14_semibold text_dark_opacity">
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

            // $checkbox = ' <div class="form-check">
            //         <input class="form-check-input shadow-none" type="checkbox" value="" id="flexCheckIndeterminate"> 
            //         </div>';

            $checked = '';
                if($row->status==1){
                  $checked = 'checked';
                }

                $status = '<div class="form-check form-switch">
                                <input class="form-check-input shadow-none" type="checkbox" id="flexSwitchCheckDefault" onclick="statusRow(this,`'.route('employees.status',[$row->id]).'`)" '.$checked.'>
                            </div>';

            $img = '';
            if (@$row->image->file_name) {
                $imagepath = $row->image->file_name;
                $img = '<img src="' . asset('uploads/' . $imagepath) . '" alt="Uploaded Image" id="uploadedImage" class="img-thumbnail"        style="max-width:unset; width:80px; height:80px;">';
            }
            $i++;
            $data[] = array(
                'sno' => $i,
                "profile" => $img,
                "name" => $row->firstname .' '. $row->lastname,
                "mobile" => $row->mobile,
                "email" => $row->email,
                "status" => $status,
                "action" => $action,
            );
        }

        ## Response
        $totalRecords = User::get()->count();
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
        $data['nav'] = "Create Employee";
        $data['countries'] = Country::get();
        return  view('company.employee.add', $data);
    }

    public function store(Request $request)
    {
        // echo "<prE>";print_r($request->all());die;

        // Validation rules
        $rules = [
            'firstname' => 'required',
            'lastname' => 'required',
            'mobile' => 'required',
            'age' => 'required|integer',
            'city' => 'required',
            'state' => 'required', 
            'country' => 'required', 
            'status' => 'required',
            'image_id' => 'required',
            'email' => 'required|email|unique:users,email,',
            'password' => 'required|confirmed|min:8',
        ];

        // Validate the request
        $request->validate($rules);

        // Check if the request is for updating or storing
        $user =  new User();

        // Fill in the fields
        $user->firstname = $request->input('firstname');
        $user->lastname = $request->input('lastname');
        $user->mobile = $request->input('mobile');
        $user->age = $request->input('age');
        $user->company_id = $request->user()->id;
        $user->city = $request->input('city');
        $user->state = $request->input('state');
        $user->country = $request->input('country'); 
        $user->country_code = $request->input('country_code'); 
        $user->status = $request->input('status');
        $user->image_id = $request->input('image_id');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        

        $user->save();

        // Return a success response as JSON
        return response()->json([
            'success' => true,
            'message' => 'Employee added successfully!',
            'user' => $user
        ]);
    }


    public function edit($id)
    {
        $data['nav'] = "Edit Employee";
        $data['countries'] = Country::get();
        $data['employee'] = $employee = User::where('id', $id)->first(); 



        return view('company.employee.edit', $data);

        // return response()->json(['success' => 1, 'view' => $view]);
    }
    
    public function view($id)
    {
        $data['nav'] = "View Employee";
        $data['countries'] = Country::get();
        $data['employee'] = User::where('id', $id)->first();
        return view('company.employee.view', $data);

        // return response()->json(['success' => 1, 'view' => $view]);
    }

    public function update(Request $request)
    {
        $id = $request->id ; 
        // Validation rules
        $rules = [
            'firstname' => 'required',
            'lastname' => 'required',
            'mobile' => 'required',
            'age' => 'required|integer',
            'city' => 'required',
            'state' => 'required',
            'country' => 'required',
            'status' => 'required',
            'image_id' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|confirmed|min:8',
        ];

        // Validate the request
        $request->validate($rules);

        $user = User::find($id);
 
        if (!$user) {
            return response()->json(['status' => 0, 'message' => 'Employee not found'], 404);
        }

        // Fill in the fields
        $user->firstname = $request->input('firstname');
        $user->lastname = $request->input('lastname');
        $user->mobile = $request->input('mobile');
        $user->company_id = $request->user()->id;
        $user->age = $request->input('age');
        $user->city = $request->input('city');
        $user->state = $request->input('state');
        $user->country = $request->input('country');
        $user->country_code = $request->input('country_code'); 
        $user->status = $request->input('status');
        $user->image_id = $request->input('image_id');
        $user->email = $request->input('email');

        // Update password only if provided (for updates)
        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }

        $user->save();

        // Return a success response as JSON
        return response()->json([
            'success' => true,
            'message' => 'Employee updated successfully!',
        ]);
    }

    public function delete($id)
    { 
        User::where('id',$id)->delete();  
        return response()->json(['success'=>1,'message' => 'Employee Delete successfully']);
    }

    public function getstates(Request $request)
    {
//  echo $request->country_id;die;
        $states = State::where('country_id',$request->country_id)->get();
        // echo "<pre>"; print_r($cities);
        $options= '<option selected disabled>Select State</option>';
        foreach ($states as $state){
            $selected = ''; 
            if($state->id == $request->state){
                $selected = 'selected';
            }
        $options .='<option value="'.$state->id.'" '.$selected.'>'. $state->name.'</option>';
        }
        return response()->json(['status' => 1, 'options' => $options]);
    }

    public function getcities(Request $request)
    { 
        $cities = City::where('state_id',$request->state_id)->get();
        // echo "<pre>"; print_r($cities);
        $options= '<option selected disabled>Select city</option>';
        foreach ($cities as $city){
            $selected = '';
            if($city->id == $request->city_id){
                $selected = 'selected';
            }
        $options .='<option value="'.$city->id.'" '.$selected.'>'. $city->name.'</option>';
        }
      
        return response()->json(['status' => 1, 'options' => $options]);
    }

    public function updateStatus(Request $request)
{
    $row = User::find($request->id);

    if ($row) {
        $row->status = $request->status;
        $row->save();
        return response()->json(['success'=> 1,'message' => 'Status updated successfully.']);
    }
    return response()->json(['message' => 'Record not found.'], 404);
}
}
