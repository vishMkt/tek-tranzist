<?php
namespace App\Http\Controllers\Api;

use App\Models\RideEmployeeVehicle;
use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator; 
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Twilio\Rest\Client; 

class DriverAuthController extends BaseController
{
    public function signup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'country_code' => 'required',
            'mobile' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|unique:drivers,mobile',
            'email' => 'required|unique:drivers,email',
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'password' => 'required|string|min:8|confirmed', 
            'fcm_token' => 'required|string',
        ]);
        if ($validator->fails()) {
            $errors = collect($validator->errors())->map(function ($error) {
                return $error[0]; // Only return the first error
            });
            return $this->sendResponse(null,'Validation Error.', $errors ,200,false); 
        }

        $otp = rand(1000, 9999);

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $input['otp'] = $otp;
        $input['otp_expiry'] = Carbon::now()->addMinutes(10);

        $user = Driver::create($input);

        // Send OTP to user via SMS (implement your own method)
        $this->sendOtp($request->country_code.$user->mobile, $otp);

        return $this->sendResponse(['otp'=>$otp], 'Driver created successfully. Please verify OTP.', null ,200); 
    }

    public function verifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile' => 'required',
            'otp' => 'required',
        ]);
        if ($validator->fails()) {
            $errors = collect($validator->errors())->map(function ($error) {
                return $error[0]; // Only return the first error
            });
            return $this->sendResponse(null,'Validation Error.', $errors ,200,false); 
        }

        $user = Driver::where('mobile', $request->mobile)->where('otp', $request->otp)->first();

        if (!$user) {
            return $this->sendResponse(null,'Validation Error.',['otp'=>'Invalid OTP or mobile number.'] ,200,false); 
        }

        if (Carbon::now()->gt($user->otp_expiry)) {
            return $this->sendResponse(null,'Validation Error.',['otp'=>'OTP expired.'] ,200,false);
        }

        $user->otp = null;
        $user->otp_expiry = null;
        $user->save();

        $success['token'] =  $user->createToken('driver_token')->plainTextToken;
        $success['user'] =  $user;
        return $this->sendResponse($success,'Driver login successfully.',null ,200); 
    }


    public function resendOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'country_code' => 'required',
            'mobile' => 'required|exists:drivers,mobile',
        ]);

            if ($validator->fails()) {
            $errors = collect($validator->errors())->map(function ($error) {
                return $error[0]; // Only return the first error
            });
            return $this->sendResponse(null,'Validation Error.', $errors ,200,false); 
        }

        $user = Driver::where('mobile', $request->mobile)->first();
        $otp = rand(1000, 9999);

        $user->otp = $otp;
        $user->otp_expiry = Carbon::now()->addMinutes(10);
        $user->save();

        // Send OTP to user via SMS (implement your own method)
        $this->sendOtp($request->country_code.$user->mobile, $otp);
 
        return $this->sendResponse(['otp' => $otp],'OTP resent successfully.',null ,200);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'country_code' => 'required',
            'mobile' => 'required',
            'password' => 'required|string|min:6', 
            'fcm_token' => 'required|string',
        ]);

        if ($validator->fails()) {
            $errors = collect($validator->errors())->map(function ($error) {
                return $error[0]; // Only return the first error
            });
            return $this->sendResponse(null,'Validation Error.', $errors ,200,false); 
        }
  
        $user = Driver::where('mobile', $request->mobile)->where('country_code',$request->country_code)->first();
  
        if (!$user || !Hash::check($request->password, $user->password)) {
            return $this->sendResponse(null,'Validation Error.', ['error'=>'Invalid mobile or password.'] ,200,false);
        }

        $user->tokens()->delete();

        $success['token'] =  $user->createToken('driver_token')->plainTextToken;
        $success['driver'] =  $user;
        
             if($user){
            $user->update([
                'fcm_token' => $request->fcm_token,
            ]);
        }
        
        return $this->sendResponse($success,'User login successfully.', null ,200);
    }

    public function driverinfo(Request $request)
    { 
        $user = Auth::guard('driver_api')->user();
        if (!$user) {
            return $this->sendError('Driver not authenticated.', [], 401);
        }
 
        $success['user'] = $user;
        return $this->sendResponse($success,'Driver info show successfully.', null ,200); 
        
    }
    
    public function updateProfile(Request $request)
    { 
        $userA = $request->user();

        $validator = Validator::make($request->all(), [
            'firstname' => 'sometimes|string|max:255',
            'lastname' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:drivers,email,' . $userA->id,
            'country_code' => 'sometimes|string',
            'mobile' => 'sometimes|string|max:15|unique:drivers,mobile,' . $userA->id,
            'password' => 'sometimes|string|min:6|confirmed',
            'current_password' => 'required_with:password|string|min:6',
        ]);

        if ($validator->fails()) {
            $errors = collect($validator->errors())->map(function ($error) {
                return $error[0]; // Only return the first error
            });
            return $this->sendResponse(null,'Validation Error.', $errors ,200,false); 
        }

        $user = Driver::where('id', $userA->id)->first();

        if ($request->filled('current_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                throw ValidationException::withMessages([
                    'current_password' => ['The current password is incorrect.'],
                ]);
            }

            $user->password = Hash::make($request->password);
        }

        if ($request->filled('firstname')) {
            $user->firstname = $request->firstname;
        }
        
        if ($request->filled('lastname')) {
            $user->lastname = $request->lastname;
        }

        if ($request->filled('email')) {
            $user->email = $request->email;
        }

        if ($request->filled('country_code')) {
            $user->country_code = $request->country_code;
        }
        
        if ($request->filled('mobile')) {
            $user->mobile = $request->mobile;
        }

        $user->save();  
        return $this->sendResponse($user,'Profile updated successfully.', null ,200); 
    }

    private function sendOtp($mobileNumber, $otp)
    {
        // Implement your SMS sending logic here
        $twilio = new Client(env('TWILIO_SID'), env('TWILIO_TOKEN'));
        $twilio->messages->create($mobileNumber, [
            'from' => env('TWILIO_FROM'),
            'body' => "Dear Your OTP is $otp for login in Drop us. This OTP is valid for next 10 minutes.\nDropus Team"
        ]);
    }
        public function update_driver_lat_long(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'driver_id' => 'sometimes|exists:drivers,id',
            'latitude' => 'sometimes|string|max:255',
            'longitude' => 'sometimes|string|max:255', 
        ]);

        if ($validator->fails()) {
            $errors = collect($validator->errors())->map(function ($error) {
                return $error[0]; // Only return the first error
            });
            return $this->sendResponse(null,'Validation Error.', $errors ,200,false); 
        }

        $driver = Driver::where('id',$request->driver_id)->first();
        
        // var_dump($driver);die;
        
        if($driver){
            $driver->update([
                'latitude'=>$request->latitude,
                'longitude'=>$request->longitude,
            ]);
    
            return $this->sendResponse($driver,'Latitude and longitude updated successfully.', null ,200);   
        }
        return $this->sendResponse(null,'Validation Error.',['driver'=>'Driver not found.'] ,200,false); 
    }
    

    public function updateFcm(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fcm_token' => 'required',
        ]);
        
            if ($validator->fails()) {
            $errors = collect($validator->errors())->map(function ($error) {
                return $error[0]; // Only return the first error
            });
            return $this->sendResponse(null,'Validation Error.', $errors ,200,false); 
        }

        $user = $request->user();
        // echo "<pre>";print_R($user);die;
        if($user){
            $user->update([
                'fcm_token' => $request->fcm_token,
            ]);
        }
        $success['username'] = $user->firstname.' '.$user->lastname;
        $success['fcm_token'] = $user->fcm_token;
        return $this->sendResponse($success,'FCM token updated successfully.', null ,200);  
        
    }
   
    public function totalRides()
    { 
        $driverId = Auth::guard('driver_api')->user()->id;
         
        $rides = RideEmployeeVehicle::with('ride')  
            ->where('driver_id', $driverId)
            ->get();
     
        return $this->sendResponse($rides, 'Current Ride Show Successfully.', null, 200);
    }
    
    public function activeRides()
{
    $driverId = Auth::guard('driver_api')->user()->id;

    // Fetching rides where the driver is assigned and the ride is not completed
    $rides = RideEmployeeVehicle::with(['EmployeePersonelRide'])
        ->where('driver_id', $driverId)
        ->whereHas('EmployeePersonelRide', function ($query) {
            $query->where('is_ride_complete', 0);
        })
        ->get();

    return $this->sendResponse($rides, 'Current Ride fetched successfully.', null, 200);
}

public function totalRidesCount()
{ 
    $driverId = Auth::guard('driver_api')->user()->id;
     
    $rides = RideEmployeeVehicle::with('ride')  
        ->where('driver_id', $driverId)
        ->get()->count();
 
    return $this->sendResponse($rides, 'Current Ride Count Show Successfully.', null, 200);
}

public function activeRidesCount()
{
$driverId = Auth::guard('driver_api')->user()->id;

// Fetching rides where the driver is assigned and the ride is not completed
$rides = RideEmployeeVehicle::with(['EmployeePersonelRide'])
    ->where('driver_id', $driverId)
    ->whereHas('EmployeePersonelRide', function ($query) {
        $query->where('is_ride_complete', 0);
    })
    ->get()->count();

return $this->sendResponse($rides, 'Current Ride Count fetched successfully.', null, 200);
}

    
}
