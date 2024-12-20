<?php

namespace App\Http\Controllers\Api;

use App\Models\Driver;
use App\Models\User;
use App\Models\MyRide;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends BaseController
{
    public function userLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile' => 'required',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(),400);       
        }

        // Attempt to find the user with the provided mobile number
        $user = User::with('image')->where('mobile', $request->mobile)->first();

        // Check if user exists and password matches
        if (!$user || !Hash::check($request->password, $user->password)) {
            return $this->sendError('Invalid mobile or password.', [], 401);
        }

        $user->tokens()->delete();

        $success['token'] =  $user->createToken('user_token')->plainTextToken;
        $success['user'] =  $user;
        //  $success['fcm_token'] =  $user->fcm_token;
        return $this->sendResponse($success, 'User login successfully.');
    }

    public function driverLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile' => 'required',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(),400);       
        }

        // Attempt to find the user with the provided mobile number
        $user = Driver::with('image')->where('mobile', $request->mobile)->first();

        // Check if user exists and password matches
        if (!$user || !Hash::check($request->password, $user->password)) {
            return $this->sendError('Invalid mobile or password.', [], 401);
        }

        $user->tokens()->delete();

        $success['token'] =  $user->createToken('driver_token')->plainTextToken;
        $success['driver'] =  $user;
        return $this->sendResponse($success, 'Driver login successfully.');
    }

    public function userinfo(Request $request)
    {
        // Retrieve the authenticated user
        // $user = Auth::guard('user_api')->user();
        // if (!$user) {
        //     return $this->sendError('User not authenticated.', [], 401);
        // }

        // Prepare the response data
        $user = $request->user();
        $success['user'] = User::with('image')->find($user->id);
        return $this->sendResponse($success, 'User info show successfully.');
        
    }

    public function driverinfo(Request $request)
    {
        // Retrieve the authenticated user
        // $user = Auth::guard('driver_api')->user();
        // if (!$user) {
        //     return $this->sendError('Driver not authenticated.', [], 401);
        // }

        // Prepare the response data
        $driver = $request->user();
        $success['driver'] = Driver::with('image')->find($driver->id);
        return $this->sendResponse($success, 'Driver info show successfully.');
        
    }
       public function update_lat_long(Request $request)
    {
        $request->validate([
            'user_id' => 'sometimes|exists:users,id',
            'latitude' => 'sometimes|string|max:255',
            'longitude' => 'sometimes|string|max:255', 
        ]);

        $user = User::where('id',$request->user_id)->first();
        $user->update([
            'latitude'=>$request->latitude,
            'longitude'=>$request->longitude,
        ]);

        return response()->json($user, 200);
    }
    
     
    public function myRides(Request $request)
    {
 
        $myRide['total_rides'] = MyRide::where('driver_id',$request->user()->id)->count();

        $myRide['total_earnings'] = 0;
        
        $myRide['my_rides'] = $my_rides = MyRide::with('Driver.vehicle.image', 'User', 'UserRating','Driver.vehicle.vehicleType')
        ->where('driver_id', $request->user()->id)
        ->get();
    
        // echo "<pre>";print_r($my_rides);die; 

        return $this->sendResponse($myRide, 'My Ride show successfully.');
        
    }    
    public function userRides(Request $request)
    {  

        $myRide['my_rides'] = MyRide::with('Driver.vehicle.image','Driver.vehicle.vehicleType','Driver.driver_image')->where('user_id',$request->user()->id)->get()->toArray();

  
        return $this->sendResponse($myRide, 'My Ride show successfully.');
        
    }
     private function calculateDistance($lat1, $lon1, $lat2, $lon2, $earthRadius)
        { 
            $lat1 = deg2rad((float) $lat1);
            $lon1 = deg2rad((float) $lon1);
            $lat2 = deg2rad((float) $lat2);
            $lon2 = deg2rad((float) $lon2);
        
            $dlat = $lat2 - $lat1;
            $dlon = $lon2 - $lon1;
        
            $a = sin($dlat / 2) * sin($dlat / 2) +
                 cos($lat1) * cos($lat2) *
                 sin($dlon / 2) * sin($dlon / 2);
        
            $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        
            $distance = $earthRadius * $c;
        
            return $distance;  // Distance in kilometers
        }
        
        public function userDelete(Request $request){ 
            $user = $request->user();  
            $user_id = $request->user()->id;   
            MyRide::where('user_id',$user_id)->delete();
            Rating::where('user_id',$user_id)->delete();
            User::where('id',$user_id)->delete(); 
            $user->tokens()->delete(); 
            return $this->sendResponse([], 'User Deleted Succesfully');  
        }
}
