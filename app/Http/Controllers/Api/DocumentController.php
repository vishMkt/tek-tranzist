<?php
namespace App\Http\Controllers\Api;

use App\Models\License;
use App\Models\Puc;
use App\Models\Image;
use App\Models\Insurance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator; 
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Twilio\Rest\Client; 
use DB;

class DocumentController extends BaseController
{
    public function addLicense(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'licence_number' => 'required|unique:licences',  
            'issue_date' => 'required|date',
            'valide_upto' => 'required|date',
            'front_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'back_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    
        if ($validator->fails()) {
            $errors = collect($validator->errors())->map(function ($error) {
                return $error[0]; 
            });
            return $this->sendResponse(null, 'Validation Error.', $errors, 200, false);
        } 
        $driverId = Auth::guard('driver_api')->user()->id; 
        $existingLicence = License::where('driver_id', $driverId)->first();
    
        if ($existingLicence) {
            return $this->sendResponse(null, 'Driver already has a licence.', null, 400, false);
        }
    
        try {
            DB::beginTransaction(); 
            $front_image = $this->uploadImage($request->file('front_image')); 
            $back_image = $this->uploadImage($request->file('back_image')); 
            $input = $request->all();
            $input['driver_id'] = $driverId;
            $input['front_image'] = $front_image->id;
            $input['back_image'] = $back_image->id;
     
            $licence = License::create($input); 
            DB::commit();  
            return $this->sendResponse($licence, 'Licence Created successfully', null, 200);
    
        } catch (\Exception $e) {
            DB::rollBack(); 
            return $this->sendResponse(null, 'An error occurred while creating the licence.', null, 500, false);
        }
    } 

    protected function uploadImage($file)
    {
        $fileName = Str::random(10) . '.' . $file->getClientOriginalExtension();
        $destinationPath = public_path('/uploads');
        $file->move($destinationPath, $fileName);
        $filePath = '/uploads/' . $fileName;
    
        return Image::create([
            'file_name' => $fileName,
            'file_path' => $filePath
        ]);
    }
    
    


public function addPUC(Request $request)
{
    $validator = Validator::make($request->all(), [
        'vehicle_number' => 'required|unique:pucs',
        'owner_name' => 'required',
        'puc_certificate_number' => 'required',
        'puc_issue_date' => 'required|date',
        'puc_expiry_date' => 'required|date',
    ]);

    if ($validator->fails()) {
        $errors = collect($validator->errors())->map(function ($error) {
            return $error[0];  
        });
        return $this->sendResponse(null, 'Validation Error.', $errors, 200, false);
    }

    $driverId = Auth::guard('driver_api')->user()->id;
 
    $existingPuc = Puc::where('driver_id', $driverId)->first(); 
    if ($existingPuc) {
        return $this->sendResponse(null, 'Driver already has a PUC.', null, 400, false);
    }

    try { 
        
        $front_image = $this->uploadImage($request->file('front_image')); 
        $back_image = $this->uploadImage($request->file('back_image')); 
        $input = $request->all();
        $input['driver_id'] = $driverId; 
        $input['front_image'] = $front_image->id;
        $input['back_image'] = $back_image->id;
        $puc = Puc::create($input); 
        return $this->sendResponse($puc, 'PUC Created successfully', null, 200); 
    } catch (\Exception $e) {
        return $this->sendResponse(null, 'An error occurred while creating the PUC.', null, 500, false);
    }
}






public function addInsurance(Request $request)
{
    $validator = Validator::make($request->all(), [
        'policy_number' => 'required|unique:insurances',
        'provider' => 'required',
        'issue_date' => 'required|date',
        'expiry_date' => 'required|date', 
    ]);

    if ($validator->fails()) {
        $errors = collect($validator->errors())->map(function ($error) {
            return $error[0];  
        });
        return $this->sendResponse(null, 'Validation Error.', $errors, 200, false);
    }

    $driverId = Auth::guard('driver_api')->user()->id;
 
    $existingInsurance = Insurance::where('driver_id', $driverId)->first();

    if ($existingInsurance) {
        return $this->sendResponse(null, 'Driver already has an insurance policy.', null, 400, false);
    }

    try { 
        
        $front_image = $this->uploadImage($request->file('front_image')); 
        $back_image = $this->uploadImage($request->file('back_image')); 
        $input = $request->all();
        $input['driver_id'] = $driverId; 
        $input['front_image'] = $front_image->id;
        $input['back_image'] = $back_image->id;
        $insurance = Insurance::create($input);

        return $this->sendResponse($insurance, 'Insurance Created successfully', null, 200);

    } catch (\Exception $e) {
        return $this->sendResponse(null, 'An error occurred while creating the insurance.', null, 500, false);
    }
}

 
   
    
 
      
}
