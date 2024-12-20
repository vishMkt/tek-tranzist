<?php
namespace App\Http\Controllers\Company;

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
      return view('company.vendor.index',$data);
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

                $checked = '';
                if($row->status==1){
                  $checked = 'checked';
                }

                $status = '<div class="form-check form-switch">
                                <input class="form-check-input shadow-none" type="checkbox" id="flexSwitchCheckDefault" onclick="statusRow(this,`'.route('company.vendors.status',[$row->id]).'`)" '.$checked.'>
                            </div>';
        

        $i++;
        $data[] = array(
            "sno" => $i,
            "name" => $row->firstname . ' ' . $row->lastname,
            "email" => $row->email,
            "phone" => $row->mobile,
            "status" => $status,
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


public function updateStatus(Request $request)
{
    // echo $request->id;die;
    $row = Vendor::find($request->id);

    if ($row) {
        $row->status = $request->status;
        $row->save();
        return response()->json(['success'=> 1,'message' => 'Status updated successfully.']);
    }
    return response()->json(['message' => 'Record not found.'], 404);
}

}
?>