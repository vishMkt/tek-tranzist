<?php
namespace App\Http\Controllers\Api;

use App\Models\Companie;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Twilio\Rest\Client;

class UserAuthController extends BaseController
{
    public function signup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'country_code' => 'required',
            'mobile' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|unique:users,mobile',
            'email' => 'required|unique:users,email',
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

        $user = User::create($input);
 
        $this->sendOtp($request->country_code.$user->mobile, $otp);

        return $this->sendResponse(['otp'=>$otp], 'User created successfully. Please verify OTP.', null ,200);
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

        $user = User::where('mobile', $request->mobile)->where('otp', $request->otp)->first();

        if (!$user) {
            return $this->sendResponse(null,'Validation Error.',['otp'=>'Invalid OTP or mobile number.'] ,200,false);
        }

        if (Carbon::now()->gt($user->otp_expiry)) {
            return $this->sendResponse(null,'Validation Error.',['otp'=>'OTP expired.'] ,200,false);
        }

        $user->otp = null;
        $user->otp_expiry = null;
        $user->save();

        $success['token'] =  $user->createToken('auth_token')->plainTextToken;
        $success['user'] =  $user;
        return $this->sendResponse($success,'User login successfully.',null ,200); 
    }

    public function resendOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'country_code' => 'required',
            'mobile' => 'required|exists:users,mobile',
        ]);

          if ($validator->fails()) {
            $errors = collect($validator->errors())->map(function ($error) {
                return $error[0]; // Only return the first error
            });
            return $this->sendResponse(null,'Validation Error.', $errors ,200,false); 
        }

        $user = User::where('mobile', $request->mobile)->first();
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

        // Attempt to find the user with the provided mobile number
        $user = User::with('image')->where('mobile', $request->mobile)->where('country_code',$request->country_code)->first();

        // Check if user exists and password matches
        if (!$user || !Hash::check($request->password, $user->password)) {
            return $this->sendResponse(null,'Validation Error.', ['error'=>'Invalid mobile or password.'] ,200,false);
        }

        $user->tokens()->delete();

        $success['token'] =  $user->createToken('auth_token')->plainTextToken;
        $success['user'] =  $user;
       
             if($user){
            $user->update([
                'fcm_token' => $request->fcm_token,
            ]);
        }
        
        return $this->sendResponse($success,'User login successfully.', null ,200);
    }

    public function userinfo(Request $request)
    {
        // print_r($request->user());die;
        // Retrieve the authenticated user
        $user = Auth::guard('user_api')->user();
        if (!$user) {
            return $this->sendResponse(null,'Validation Error.', ['error'=>'User not authenticated.'] ,200,false); 
        }

        // Prepare the response data
        $success['user'] = $user;
        return $this->sendResponse($success,'User info show successfully.', null ,200); 
        
    }
    
    public function updateProfile(Request $request)
    { 
        $userA = $request->user();

        $validator = Validator::make($request->all(), [
            'firstname' => 'sometimes|string|max:255',
            'lastname' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . $userA->id,
            'country_code' => 'sometimes|string',
            'mobile' => 'sometimes|string|max:15|unique:users,mobile,' . $userA->id,
            'password' => 'sometimes|string|min:6|confirmed',
            'current_password' => 'required_with:password|string|min:6',
        ]);

        if ($validator->fails()) {
            $errors = collect($validator->errors())->map(function ($error) {
                return $error[0]; // Only return the first error
            });
            return $this->sendResponse(null,'Validation Error.', $errors ,200,false); 
        }

        $user = User::where('id', $userA->id)->first();

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

        $twilio = new Client(env('TWILIO_SID'), env('TWILIO_TOKEN'));
        $twilio->messages->create($mobileNumber, [
            'from' => env('TWILIO_FROM'),
            'body' => "Dear Your OTP is $otp for login in Drop us. This OTP is valid for next 10 minutes.\nDropus Team"
        ]);
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
        if($user){
            $user->update([
                'fcm_token' => $request->fcm_token,
            ]);
        }
        $success['username'] = $user->firstname.' '.$user->lastname;
        $success['fcm_token'] = $user->fcm_token;
        
        return $this->sendResponse($success,'FCM token updated successfully.', null ,200);  
        
    }
    
    
        
    public function update_User_lat_long(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'user_id' => 'sometimes|exists:users,id',
            'latitude' => 'sometimes|string|max:255',
            'longitude' => 'sometimes|string|max:255', 
        ]);

        if ($validator->fails()) {
            $errors = collect($validator->errors())->map(function ($error) {
                return $error[0]; // Only return the first error
            });
            return $this->sendResponse(null,'Validation Error.', $errors ,200,false); 
        }
        

        $driver = User::where('id',$request->user_id)->first();
        $driver->update([
            'latitude'=>$request->latitude,
            'longitude'=>$request->longitude,
        ]);
 
        
        return $this->sendResponse($driver,'Latitude and longitude updated successfully.', null ,200);   
    }
    

    public function companies()
    {  
        $companies = Companie::where('status',1)->get(); 
        return $this->sendResponse($companies,'Company Info Show successfully.', null ,200);    
    }

}
