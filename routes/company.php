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
use App\Http\Controllers\Company\Auth\LoginController;
use App\Http\Controllers\Company\CompanyController;
use App\Http\Controllers\Company\{UserController,EmployeeController,ImageController,VendorController,RidesController,SecurityGuardController,SiteSettingController};


Route::group(['middleware' => ['guest:company'],'namespace'=>'Auth'],function(){
    
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('company.login');
    Route::post('/login', [LoginController::class, 'adminLogin'])->name('company.submitlogin');
});

Route::group(['middleware'=>['auth:company']],function(){
    Route::get('/', [CompanyController::class, 'index'])->name('company');
    Route::post('/logout', [LoginController::class, 'logout'])->name('company.logout');
    Route::get('/user', [UserController::class, 'index'])->name('company.user');

    Route::post('/image-upload', [ImageController::class, 'imageUpload'])->name('company.image.upload');
    Route::post('/image-upload-back', [ImageController::class, 'imageUploadback'])->name('company.image.upload_back');


    // Employee start
    Route::get('/employee', [EmployeeController::class, 'index'])->name('company.employee');
    Route::post('/employee-list', [EmployeeController::class, 'list'])->name('company.employee.list');
    Route::get('/employee-add', [EmployeeController::class, 'create'])->name('company.employee.add');
    Route::post('/employee-store', [EmployeeController::class, 'store'])->name('company.employee.store');
    Route::get('/employee-edit/{id}', [EmployeeController::class, 'edit'])->name('company.employee.edit');
    Route::get('/employee-view/{id}', [EmployeeController::class, 'view'])->name('company.employee.view');
    Route::post('/update-employee', [EmployeeController::class, 'update'])->name('company.employee.update');
    Route::get('/employee-delete/{id}', [EmployeeController::class, 'delete'])->name('company.employee.delete');
    Route::post('/get-cities', [EmployeeController::class, 'getcities'])->name('company.cities.list');
    Route::post('/get-states', [EmployeeController::class, 'getstates'])->name('company.states.list');
    Route::post('/get-cities', [EmployeeController::class, 'getcities'])->name('company.cities.list');
    Route::put('/employees-status/{id}', [EmployeeController::class, 'updateStatus'])->name('company.employees.status');
    // Employee end

      // Vendor Start
      Route::get('vendor', [VendorController::class, 'index'])->name('company.vendor');
      Route::post('/list-vendor', [VendorController::class, 'list'])->name('company.list.vendor');
      Route::put('/vendors-status/{id}', [VendorController::class, 'updateStatus'])->name('company.vendors.status');
      // Vendor End

    // Security Guard Start

    Route::get('/security-guard', [SecurityGuardController::class, 'index'])->name('company.security.guard');
    Route::post('/add-security-guard', [SecurityGuardController::class, 'create'])->name('company.create.security.guard');
    Route::get('/show-security-guard/{id}', [SecurityGuardController::class, 'show'])->name('company.show.security.guard');
    Route::post('/save-security-guard', [SecurityGuardController::class, 'store'])->name('company.store.security.guard');
    Route::post('/list-security-guard', [SecurityGuardController::class, 'list'])->name('company.list.security.guard');
    Route::get('/edit/security-guard/{id}', [SecurityGuardController::class, 'edit'])->name('company.edit.security.guard');
    Route::get('/delete/security-guard/{id}', [SecurityGuardController::class, 'delete'])->name('company.delete.security.guard');
    Route::post('/update-security-guard', [SecurityGuardController::class, 'update_data'])->name('company.update.security.guard');
    Route::post('/update-status', [SecurityGuardController::class, 'updateStatus'])->name('company.udpate.security.status');
    Route::put('/security-guard/status/{id}', [SecurityGuardController::class, 'updateStatus'])->name('company.security.status');

    // Security Guard End

    //Site Setting Start
    Route::get('/site-setting', [SiteSettingController::class, 'index'])->name('company.site_setting');
    Route::post('/update-site-setting', [SiteSettingController::class, 'update_data'])->name('company.update.site_setting');
    //Site Setting End
     //Rides Start 

     Route::get('/rides', [RidesController::class, 'index'])->name('company.rides');
     Route::post('/list-rides', [RidesController::class, 'list'])->name('company.list.rides');  
     Route::get('/assign-employee/rides/{id}', [RidesController::class, 'assignEmployee'])->name('company.assign.employee.rides');
     Route::get('/check-employee/rides/{id}', [RidesController::class, 'checkEmployee'])->name('company.check.employee');
     Route::post('/list/emloyee-check', [RidesController::class, 'checkEmployeeList'])->name('company.check.employee.list');
     Route::post('/add-employee', [RidesController::class, 'add_employee'])->name('company.add.employee');
     Route::get('/employee/{employee_id}/ride/{ride_id}', [RidesController::class, 'ViewEmployeeRide'])->name('company.view.employee.ride');
     Route::post('/list/view-emloyee-ride', [RidesController::class, 'viewEmployeeRideList'])->name('company.view.employee.ride.list');
     Route::post('/update-employee-ride-time', [RidesController::class, 'update_employee_time_home_to_office'])->name('company.update.employee.time');  
     Route::post('/update-employee-ride-time-office-to-home', [RidesController::class, 'update_employee_time_office_to_home'])->name('company.update.employee.time.office.to.home');
     //Rides End

});
