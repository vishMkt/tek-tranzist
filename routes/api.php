<?php

use App\Http\Controllers\Api\DriverAuthController; 
use App\Http\Controllers\Api\VehicleController;
use App\Http\Controllers\Api\VendorAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route; 
use App\Http\Controllers\Api\UserAuthController; 
use App\Http\Controllers\Api\ClientAuthController; 
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RideController;
use App\Http\Controllers\Api\DocumentController;
use App\Http\Controllers\Api\ImageController; 

/*
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user-info', function (Request $request) {
//     return $request->user();
// });


Route::controller(UserAuthController::class)->group(function(){
    Route::post('user/signup', 'signup');
    Route::post('user/verify-otp', 'verifyOtp');
    Route::post('user/resend-otp', 'resendOtp');
    Route::post('user/login', 'login');
    Route::post('user/update-lat-long', 'update_user_lat_long');
    
}); 

Route::controller(DriverAuthController::class)->group(function(){
    Route::post('driver/signup', 'signup');
    Route::post('driver/verify-otp', 'verifyOtp');
    Route::post('driver/resend-otp', 'resendOtp');
    Route::post('driver/login', 'login');
    Route::post('driver/update-driver-lat-long', 'update_driver_lat_long');
    Route::post('driver/fcm-update','updateFcm');

}); 

Route::controller(VendorAuthController::class)->group(function(){
    Route::post('vendor/signup', 'signup');
    Route::post('vendor/verify-otp', 'verifyOtp');
    Route::post('vendor/resend-otp', 'resendOtp');
    Route::post('vendor/login', 'login');
}); 


Route::controller(ClientAuthController::class)->group(function(){
    Route::post('client/signup', 'signup');
    Route::post('client/verify-otp', 'verifyOtp');
    Route::post('client/resend-otp', 'resendOtp');
    Route::post('client/login', 'login');
    Route::post('client/update-lat-long', 'update_user_lat_long');
    
}); 

// Route::post('user-login', [AuthController::class, 'userLogin']);
// Route::post('driver-login', [AuthController::class, 'driverLogin']);
Route::post('update-lat-long', [AuthController::class, 'update_lat_long']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/upload-image', [ImageController::class, 'uploadImage']); 
});

Route::middleware('auth:user_api')->group(function () { 
    Route::get('/user-info', [AuthController::class, 'userinfo'])->name('user-info');
    Route::get('/user-ride-info', [AuthController::class, 'userRides'])->name('user_ride_info');
    Route::post('/user-profile/update', [UserAuthController::class, 'updateProfile']);
    Route::post('/user-profile-image', [ImageController::class, 'updateProfileImage']);  
    Route::post('user/delete',[AuthController::class, 'userDelete'] );
    Route::post('user-fcm-update', [UserAuthController::class, 'updateFcm']); 
    Route::post('user-book-ride', [RideController::class, 'userBookRide']);
    Route::get('user-current-ride', [RideController::class, 'userCurrentRide']);
    Route::post('user-ride-complete', [RideController::class, 'completeRide']);
    Route::post('user-ride-cancel', [RideController::class, 'cancelRide']);
    Route::post('user-ride-time', [RideController::class, 'RideTime']);
    Route::get('/user-companies', [UserAuthController::class, 'companies']);

});
 

Route::middleware('auth:driver_api')->group(function () { 
    Route::get('/driver-info', [AuthController::class, 'driverinfo'])->name('driver-info'); 
    Route::get('/my-rides', [AuthController::class, 'myRides'])->name('my_rides'); 
    Route::post('/driver-profile/update', [DriverAuthController::class, 'updateProfile']);
    Route::post('/driver-profile-image', [ImageController::class, 'updateDriverProfileImage']);  
    Route::post('driver-fcm-update', [DriverAuthController::class, 'updateFcm']);
    Route::apiResource('vehicles', VehicleController::class);
    Route::post('add-licence', [DocumentController::class, 'addLicense']);
    Route::post('add-puc', [DocumentController::class, 'addPUC']);
    Route::post('add-insurance', [DocumentController::class, 'addInsurance']);
    Route::get('total-rides', [DriverAuthController::class, 'totalRides']);
    Route::get('active-rides', [DriverAuthController::class, 'activeRides']);
    Route::get('total-rides-count', [DriverAuthController::class, 'totalRidesCount']);
    Route::get('active-rides-count', [DriverAuthController::class, 'activeRidesCount']);
      
});

Route::middleware('auth:vendor-api')->group(function () { 
    Route::get('/vendor-info', [VendorAuthController::class, 'vendorinfo'])->name('vendor-info'); 
    Route::post('vendor/profile-update', [VendorAuthController::class, 'updateProfile']);
    Route::post('vendor/update-lat-long', [VendorAuthController::class, 'update_lat_long']); 
    Route::post('vendor/fcm-update', [VendorAuthController::class, 'updateFcm']); 
});

Route::middleware('auth:client_api')->group(function () {   
    Route::get('/client-info', [ClientAuthController::class, 'clientinfo'])->name('client-info');  
    Route::post('/client-profile/update', [ClientAuthController::class, 'clientProfile']);
    Route::post('client-fcm-update', [ClientAuthController::class, 'updateFcm']); 
    Route::post('book-ride', [RideController::class, 'bookRide']);
});
  
 
