<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\VehicleOwner;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Twilio\Rest\Client;

class VehicleOwnerController extends Controller
{
    public function index()
    {
        $data['nav'] = "Vehicle Owner";
        return view('vehicle_owner.index', $data);
    }

    public function create()
    {
        $vendors = Vendor::where('status',1)->get();
        return  view('vehicle_owner.create',compact('vendors'));
 
    }

    public function store(Request $request)
    {

        // Validate request data
        $request->validate([
            'email' => 'required|email|unique:vehicle_owners,email,' . $request->user_id,
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'mobile' => 'required|numeric',
            'address' => 'required|string',
            'status' => 'required',
            'vendor' => 'required',
        ]);

        // Create a new Vehicle Owner
        $vehicle_owner = new VehicleOwner();
        $vehicle_owner->firstname = $request->firstname;
        $vehicle_owner->lastname = $request->lastname;
        $vehicle_owner->email = $request->email;
        $vehicle_owner->mobile = $request->mobile;
        $vehicle_owner->address = $request->address;
        $vehicle_owner->status = $request->status;
        $vehicle_owner->vendor_id = $request->vendor;

        // Save the Vehicle Owner to the database
        $vehicle_owner->save();

        // Return success response
        return response()->json(['status' => 1, 'message' => 'Vehicle Owner created successfully']);
    }

    public function update_data(Request $request)
    {
        $id = $request->id;
        $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'mobile' => 'required|numeric',
            'address' => 'required|string',
            'status' => 'required',
            'vendor' => 'required',
        ]);

        $vehicle_owner = VehicleOwner::find($id);

        if (!$vehicle_owner) {
            return response()->json(['status' => 0, 'message' => 'Vehicle Owner not found'], 404);
        }

        $vehicle_owner->firstname = $request->firstname;
        $vehicle_owner->lastname = $request->lastname;
        $vehicle_owner->email = $request->email;
        $vehicle_owner->mobile = $request->mobile;
        $vehicle_owner->address = $request->address;
        $vehicle_owner->status = $request->status;
        $vehicle_owner->vendor_id = $request->vendor;
        $vehicle_owner->save();

        // Return success response
        return response()->json(['status' => 1, 'message' => 'Vehicle Owner updated successfully']);
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

        $qry = VehicleOwner::select('*')->where('vehicle_owners.firstname', 'LIKE', '%' . $searchValue . '%')
            ->orderBy('vehicle_owners.created_at', 'DESC');

        if (isset($request->searchname)) {
            $qry->where('vehicle_owners.firstname', 'LIKE', '%' . $request->searchname . '%');
        }

        $result = $qry->get();
        $totalRecordwithFilter = $result->count();
        $result = $qry->offset($row)->take($rowperpage)->get();

        $data = array();
        foreach ($result as $row) {

            $view = route('show.vehicle.owner', $row->id);
            $edit = route('edit.vehicle.owner', $row->id);
            $delete = route('delete.vehicle.owner', $row->id);
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
            if ($row->status == 1) {
                $checked = 'checked';
            }

            $status = '<div class="form-check form-switch">
                        <input class="form-check-input shadow-none" type="checkbox" id="flexSwitchCheckDefault" onclick="statusRow(this,`' . route('vehicle.owner.status', [$row->id]) . '`)" ' . $checked . '>
                    </div>';


            $i++;
            $data[] = array(
                "sno" => $i,
                "vendor" => @$row->vendor->firstname,
                "name" => $row->firstname . ' ' . $row->lastname,
                "email" => $row->email,
                "phone" => $row->mobile,
                "status" => $status,
                "action" => $action,
            );
        }

        ## Response
        $totalRecords = VehicleOwner::get()->count();
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
        $data['uinfo'] = VehicleOwner::where('id', $id)->first();
        $data['vendors'] = Vendor::where('status',1)->get();
        return view('vehicle_owner.edit', $data);
 
    }

    public function show($id)
    {
        $data['uinfo'] = VehicleOwner::where('id', $id)->first();
        $data['vendors'] = Vendor::where('status',1)->get();

        return  view('vehicle_owner.view', $data);
 
    }


    public function delete($id)
    {
        VehicleOwner::where('id', $id)->delete();
        return response()->json(['success' => 1, 'message' => 'Vehicle Owner Delete successfully']);
    }

    public function updateStatus(Request $request)
    {
        $row = VehicleOwner::find($request->id);

        if ($row) {
            $row->status = $request->status;
            $row->save();

            return response()->json(['success'=> 1 ,'message' => 'Status updated successfully.']);
        }

        return response()->json(['message' => 'Record not found.'], 404);
    }
}
