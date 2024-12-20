<?php
namespace App\Http\Controllers\Api;

use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator; 
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Twilio\Rest\Client; 

class VendorAuthController extends BaseController
{
    public function signup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'country_code' => 'required',
            'mobile' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|unique:vendors,mobile',
            'email' => 'required|unique:vendors,email',
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

        $user = Vendor::create($input);

        // Send OTP to user via SMS (implement your own method)
        $this->sendOtp($request->country_code.$user->mobile, $otp);

        return $this->sendResponse(['otp'=>$otp], 'Vendor created successfully. Please verify OTP.', null ,200); 
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

        $user = Vendor::where('mobile', $request->mobile)->where('otp', $request->otp)->first();

        if (!$user) {
            return $this->sendResponse(null,'Validation Error.',['otp'=>'Invalid OTP or mobile number.'] ,200,false); 
        }

        if (Carbon::now()->gt($user->otp_expiry)) {
            return $this->sendResponse(null,'Validation Error.',['otp'=>'OTP expired.'] ,200,false);
        }

        $user->otp = null;
        $user->otp_expiry = null;
        $user->save();

        $success['token'] =  $user->createToken('vendor_token')->plainTextToken;
        $success['user'] =  $user;
        return $this->sendResponse($success,'Vendor login successfully.',null ,200); 
    }


    public function resendOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'country_code' => 'required',
            'mobile' => 'required|exists:vendors,mobile',
        ]);

            if ($validator->fails()) {
            $errors = collect($validator->errors())->map(function ($error) {
                return $error[0]; // Only return the first error
            });
            return $this->sendResponse(null,'Validation Error.', $errors ,200,false); 
        }

        $user = Vendor::where('mobile', $request->mobile)->first();
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
  
        $user = Vendor::where('mobile', $request->mobile)->where('country_code',$request->country_code)->first();
  
        if (!$user || !Hash::check($request->password, $user->password)) {
            return $this->sendResponse(null,'Validation Error.', ['error'=>'Invalid mobile or password.'] ,200,false);
        }

        $user->tokens()->delete();

        $success['token'] =  $user->createToken('vendor_token')->plainTextToken;
        $success['vendor'] =  $user;
        
             if($user){
            $user->update([
                'fcm_token' => $request->fcm_token,
            ]);
        }
        
        return $this->sendResponse($success,'User login successfully.', null ,200);
    }
    
    public function updateProfile(Request $request)
    { 
        $userA = $request->user();

        $validator = Validator::make($request->all(), [
            'firstname' => 'sometimes|string|max:255',
            'lastname' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:vendors,email,' . $userA->id,
            'country_code' => 'sometimes|string',
            'image_id' => 'sometimes',
            'mobile' => 'sometimes|string|max:15|unique:vendors,mobile,' . $userA->id,
            'password' => 'sometimes|string|min:6|confirmed',
            'current_password' => 'required_with:password|string|min:6',
        ]);

        if ($validator->fails()) {
            $errors = collect($validator->errors())->map(function ($error) {
                return $error[0]; // Only return the first error
            });
            return $this->sendResponse(null,'Validation Error.', $errors ,200,false); 
        }

        $user = Vendor::where('id', $userA->id)->first();

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
        
        if ($request->filled('image_id')) {
            $user->image_id = $request->image_id;
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
        public function update_lat_long(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'latitude' => 'sometimes|string|max:255',
            'longitude' => 'sometimes|string|max:255', 
        ]);

        if ($validator->fails()) {
            $errors = collect($validator->errors())->map(function ($error) {
                return $error[0]; // Only return the first error
            });
            return $this->sendResponse(null,'Validation Error.', $errors ,200,false); 
        }

        $vendor = Vendor::where('id',$request->user()->id)->first();
        
        // var_dump($vendor);die;
        
        if($vendor){
            $vendor->update([
                'latitude'=>$request->latitude,
                'longitude'=>$request->longitude,
            ]);
    
            return $this->sendResponse($vendor,'Latitude and longitude updated successfully.', null ,200);   
        }
        return $this->sendResponse(null,'Validation Error.',['vendor'=>'vendor not found.'] ,200,false); 
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
   
    public function vendorinfo(Request $request)
    {
        $vendor = Vendor::with('image')->find($request->user()->id);
        $success['vendor'] = $vendor;
        // $success['vendor'] = Vendor::with('image')->find($vendor->id);
        return $this->sendResponse($success, 'vendor info show successfully.');
        
    }
 
      
}
