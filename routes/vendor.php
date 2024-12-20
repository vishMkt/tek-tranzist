<?php

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "admin" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Vendor\Auth\LoginController;
use App\Http\Controllers\Vendor\VendorController;
// use App\Http\Controllers\{DepartmentController,CompaniesController,SecurityGuardController};
use App\Http\Controllers\Vendor\{DriverController,VehicleOwnerController,VehicleController,RidesController,ImageController};


Route::group(['middleware' => ['guest:vendor'],'namespace'=>'Auth'],function(){
    
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('vendor.login');
    Route::post('/login', [LoginController::class, 'adminLogin'])->name('vendor.submitlogin');
});

Route::group(['middleware'=>['auth:vendor']],function(){
    Route::get('/', [VendorController::class, 'index'])->name('vendor');
    Route::post('/logout', [LoginController::class, 'logout'])->name('vendor.logout');

    // Driver Start

    Route::get('/driver', [DriverController::class, 'index'])->name('vendor.driver');
    Route::get('/add-driver', [DriverController::class, 'create'])->name('vendor.create.driver');
    Route::post('/save-driver', [DriverController::class, 'store'])->name('vendor.store.driver');
    Route::post('/list-driver', [DriverController::class, 'list'])->name('vendor.list.driver');
    Route::get('/edit/driver/{id}', [DriverController::class, 'edit'])->name('vendor.edit.driver');
    Route::get('/view/driver/{id}', [DriverController::class, 'view'])->name('vendor.driver.view');
    Route::get('/delete/driver/{id}', [DriverController::class, 'delete'])->name('vendor.delete.driver');
    Route::post('/update-driver', [DriverController::class, 'update_data'])->name('vendor.update.driver');

    // Driver End

    // Vehicle Start
    Route::get('/vehicle', [VehicleController::class, 'index'])->name('vendor.vehicle');
    Route::get('/add-vehicle', [VehicleController::class, 'create'])->name('vendor.create.vehicle');
    Route::post('/save-vehicle', [VehicleController::class, 'store'])->name('vendor.store.vehicle');
    Route::post('/list-vehicle', [VehicleController::class, 'list'])->name('vendor.list.vehicle');
    Route::get('/edit/vehicle/{id}', [VehicleController::class, 'edit'])->name('vendor.edit.vehicle');
    Route::get('/view/vehicle/{id}', [VehicleController::class, 'view'])->name('vendor.view.vehicle');
    Route::get('/delete/vehicle/{id}', [VehicleController::class, 'delete'])->name('vendor.delete.vehicle');
    Route::post('/update-vehicle', [VehicleController::class, 'update_data'])->name('vendor.update.vehicle');
    Route::post('/get-models', [VehicleController::class, 'getmodel'])->name('vendor.modeldata.vehicle');

    // Vehicle End 

    // vehicle Owner Start
    Route::get('/vehicle-owner', [VehicleOwnerController::class, 'index'])->name('vendor.vehicle.owner');
    Route::get('/add-vehicle-owner', [VehicleOwnerController::class, 'create'])->name('vendor.create.vehicle.owner');
    Route::post('/save-vehicle-owner', [VehicleOwnerController::class, 'store'])->name('vendor.store.vehicle.owner');
    Route::post('/list-vehicle-owner', [VehicleOwnerController::class, 'list'])->name('vendor.list.vehicle.owner');
    Route::get('/edit/vehicle-owner/{id}', [VehicleOwnerController::class, 'edit'])->name('vendor.edit.vehicle.owner');
    Route::get('/show/vehicle-owner/{id}', [VehicleOwnerController::class, 'show'])->name('vendor.show.vehicle.owner');
    Route::get('/delete/vehicle-owner/{id}', [VehicleOwnerController::class, 'delete'])->name('vendor.delete.vehicle.owner');
    Route::post('/update-vehicle-owner', [VehicleOwnerController::class, 'update_data'])->name('vendor.update.vehicle.owner');
    Route::put('/vehicle-owner/status/{id}', [VehicleOwnerController::class, 'updateStatus'])->name('vendor.vehicle.owner.status');
    // vehicle Owner End



    //Rides Start 
    Route::get('/rides', [RidesController::class, 'index'])->name('vendor.rides');
    Route::post('/list-rides', [RidesController::class, 'list'])->name('vendor.list.rides');  
    Route::get('/assign-vehicle/rides/{id}', [RidesController::class, 'assignVehicle'])->name('vendor.assign.vehicle.rides');
    Route::post('/add-vehicle', [RidesController::class, 'add_vehicle'])->name('vendor.add.vehicle');
    Route::post('/request-accept', [RidesController::class, 'acceptRequest'])->name('vendors.accept.request');
    Route::post('/update-driver-ride', [RidesController::class, 'update_driver'])->name('vendors.update.driver');
    Route::post('/update-vehicle-ride', [RidesController::class, 'update_vehicle'])->name('vendors.update.vehicle');

    //Rides End


    Route::post('/image-upload', [ImageController::class, 'imageUpload'])->name('vendor.image.upload');
    Route::post('/image-upload-back', [ImageController::class, 'imageUploadback'])->name('vendor.image.upload_back');
    Route::post('/image-upload-front-insurance', [ImageController::class, 'imageUploadbackInsurance'])->name('vendor.image.upload_back_insurance');
    Route::post('/image-upload-back-insurance', [ImageController::class, 'imageUploadFrontInsurance'])->name('vendor.image.upload_front_insurance');
    Route::post('/image-upload-attachment', [ImageController::class, 'imageUploadattachment'])->name('vendor.image.upload_attachment');


});
