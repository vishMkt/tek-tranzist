<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\RegisterController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\{UserController, DriverController, VehicleController, EmployeeController, VendorController, VehicleDocumentController, ImageController, SiteSettingController, RidesController, VehicleOwnerController, SecurityGuardController, CompaniesController, DepartmentController,MakeController,ModelController};


Route::group(['middleware' => ['guest:admin'], 'namespace' => 'Auth'], function () {

    Route::get('/login', [LoginController::class, 'showAdminLoginForm'])->name('admin.login');
    Route::get('/register', [RegisterController::class, 'showAdminRegisterForm'])->name('admin.register');
    Route::post('/login', [LoginController::class, 'adminLogin'])->name('admin.submitlogin');
    Route::post('/register', [RegisterController::class, 'createAdmin'])->name('admin.submitregister');
});

Route::group(['middleware' => ['auth:admin']], function () {

    Route::get('/', [AdminController::class, 'index'])->name('admin');
    Route::post('/logout', [LoginController::class, 'logout'])->name('admin.logout');
    // Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

    // Employee start
    Route::get('/employee', [EmployeeController::class, 'index'])->name('employee');
    Route::post('/employee-list', [EmployeeController::class, 'list'])->name('employee.list');
    Route::get('/employee-add', [EmployeeController::class, 'create'])->name('employee.add');
    Route::post('/employee-store', [EmployeeController::class, 'store'])->name('employee.store');
    Route::get('/employee-edit/{id}', [EmployeeController::class, 'edit'])->name('employee.edit');
    Route::get('/employee-view/{id}', [EmployeeController::class, 'view'])->name('employee.view');
    Route::post('/update-employee', [EmployeeController::class, 'update'])->name('employee.update');
    Route::get('/employee-delete/{id}', [EmployeeController::class, 'delete'])->name('employee.delete');
    Route::post('/get-states', [EmployeeController::class, 'getstates'])->name('states.list');
    Route::post('/get-cities', [EmployeeController::class, 'getcities'])->name('cities.list');
    Route::put('/employees-status/{id}', [EmployeeController::class, 'updateStatus'])->name('employees.status');
    // Employee end

    // Driver Start

    Route::get('/driver', [DriverController::class, 'index'])->name('driver');
    Route::get('/add-driver', [DriverController::class, 'create'])->name('create.driver');
    Route::post('/save-driver', [DriverController::class, 'store'])->name('store.driver');
    Route::post('/list-driver', [DriverController::class, 'list'])->name('list.driver');
    Route::get('/edit/driver/{id}', [DriverController::class, 'edit'])->name('edit.driver');
    Route::get('/view/driver/{id}', [DriverController::class, 'view'])->name('driver.view');
    Route::get('/delete/driver/{id}', [DriverController::class, 'delete'])->name('delete.driver');
    Route::post('/update-driver', [DriverController::class, 'update_data'])->name('update.driver');

    // Driver End
    // Vehicle Start

    Route::get('/vehicle', [VehicleController::class, 'index'])->name('vehicle');
    Route::get('/vehicle/create', [VehicleController::class, 'create'])->name('create.vehicle');
    Route::post('/save-vehicle', [VehicleController::class, 'store'])->name('store.vehicle');
    Route::post('/list-vehicle', [VehicleController::class, 'list'])->name('list.vehicle');
    Route::get('/vehicle/edit/{id}', [VehicleController::class, 'edit'])->name('vehicle.edit');
    Route::get('/view/vehicle/{id}', [VehicleController::class, 'view'])->name('view.vehicle');
    Route::get('/delete/vehicle/{id}', [VehicleController::class, 'delete'])->name('delete.vehicle');
    Route::post('/update-vehicle', [VehicleController::class, 'update_data'])->name('update.vehicle');
    Route::post('/get-models', [VehicleController::class, 'getmodel'])->name('modeldata.vehicle');

    // Vehicle End 
    // Vendor Start

    Route::get('vendor', [VendorController::class, 'index'])->name('admin.vendor');
    Route::get('/add-vendor', [VendorController::class, 'create'])->name('create.vendor');
    Route::post('/save-vendor', [VendorController::class, 'store'])->name('store.vendor');
    Route::post('/list-vendor', [VendorController::class, 'list'])->name('list.vendor');
    Route::get('/edit/vendor/{id}', [VendorController::class, 'edit'])->name('edit.vendor');
    Route::get('/show/vendor/{id}', [VendorController::class, 'view'])->name('view.vendor');
    Route::get('/delete/vendor/{id}', [VendorController::class, 'delete'])->name('delete.vendor');
    Route::post('/update-vendor', [VendorController::class, 'update_data'])->name('update.vendor');
    Route::put('/vendors-status/{id}', [VendorController::class, 'updateStatus'])->name('vendors.status');

    // Vendor End

    Route::post('/image-upload', [ImageController::class, 'imageUpload'])->name('image.upload');
    Route::post('/image-upload-back', [ImageController::class, 'imageUploadback'])->name('image.upload_back');
    Route::post('/image-upload-front-insurance', [ImageController::class, 'imageUploadbackInsurance'])->name('image.upload_back_insurance');
    Route::post('/image-upload-back-insurance', [ImageController::class, 'imageUploadFrontInsurance'])->name('image.upload_front_insurance');
    Route::post('/image-upload-attachment', [ImageController::class, 'imageUploadattachment'])->name('image.upload_attachment');


    //Site Setting Start


    Route::get('/site-setting', [SiteSettingController::class, 'index'])->name('site_setting');
    Route::post('/update-site-setting', [SiteSettingController::class, 'update_data'])->name('update.site_setting');

    //Site Setting End





    // Department start
    Route::get('/departments', [DepartmentController::class, 'index'])->name('departments');
    Route::get('/departments/create', [DepartmentController::class, 'create'])->name('departments.create');
    Route::post('/departments/store', [DepartmentController::class, 'store'])->name('departments.store');
    Route::post('/departments/update', [DepartmentController::class, 'update'])->name('departments.update');
    Route::get('/departments/edit/{id}', [DepartmentController::class, 'edit'])->name('departments.edit');
    Route::get('/departments/view/{id}', [DepartmentController::class, 'view'])->name('departments.view');
    Route::delete('/departments/delete/{id}', [DepartmentController::class, 'destroy'])->name('departments.delete');
    Route::post('/departments/list', [DepartmentController::class, 'getDepartments'])->name('departments.list');
    Route::put('/departments/status/{id}', [DepartmentController::class, 'status'])->name('departments.status');
    // Department end  

    // Vehicle Document Start 

    // license  Start
    Route::get('/license', [VehicleDocumentController::class, 'index'])->name('license');
    Route::post('/add-license', [VehicleDocumentController::class, 'create'])->name('create.license');
    Route::post('/save-license', [VehicleDocumentController::class, 'store'])->name('store.license');
    Route::post('/list-license', [VehicleDocumentController::class, 'list'])->name('list.license');
    Route::get('/edit/license/{id}', [VehicleDocumentController::class, 'edit'])->name('edit.license');
    Route::get('/show/license/{id}', [VehicleDocumentController::class, 'show'])->name('show.license');
    Route::get('/delete/license/{id}', [VehicleDocumentController::class, 'delete'])->name('delete.license');
    Route::post('/update-license', [VehicleDocumentController::class, 'update_data'])->name('update.license');
    Route::put('/license/status/{id}', [VehicleDocumentController::class, 'updateStatus'])->name('license.status');

    // license End
    // PUC Start 

    Route::get('/puc', [VehicleDocumentController::class, 'index_puc'])->name('puc');
    Route::post('/add-puc', [VehicleDocumentController::class, 'create_puc'])->name('create.puc');
    Route::post('/save-puc', [VehicleDocumentController::class, 'store_puc'])->name('store.puc');
    Route::post('/list-puc', [VehicleDocumentController::class, 'list_puc'])->name('list.puc');
    Route::get('/edit/puc/{id}', [VehicleDocumentController::class, 'edit_puc'])->name('edit.puc');
    Route::get('/show/puc/{id}', [VehicleDocumentController::class, 'show_puc'])->name('show.puc');
    Route::get('/delete/puc/{id}', [VehicleDocumentController::class, 'delete_puc'])->name('delete.puc');
    Route::post('/update-puc', [VehicleDocumentController::class, 'update_data_puc'])->name('update.puc');
    Route::put('/puc/status/{id}', [VehicleDocumentController::class, 'pucStatus'])->name('puc.status');
    // PUC End 

    // Insurance Start 

    Route::get('/insurance', [VehicleDocumentController::class, 'index_insurance'])->name('insurance');
    Route::post('/add-insurance', [VehicleDocumentController::class, 'create_insurance'])->name('create.insurance');
    Route::post('/save-insurance', [VehicleDocumentController::class, 'store_insurance'])->name('store.insurance');
    Route::post('/list-insurance', [VehicleDocumentController::class, 'list_insurance'])->name('list.insurance');
    Route::get('/edit/insurance/{id}', [VehicleDocumentController::class, 'edit_insurance'])->name('edit.insurance');
    Route::get('/show/insurance/{id}', [VehicleDocumentController::class, 'show_insurance'])->name('show.insurance');
    Route::get('/delete/insurance/{id}', [VehicleDocumentController::class, 'delete_insurance'])->name('delete.insurance');
    Route::post('/update-insurance', [VehicleDocumentController::class, 'update_data_insurance'])->name('update.insurance');
    Route::put('/insurance/status/{id}', [VehicleDocumentController::class, 'insuranceStatus'])->name('insurance.status');

    // Insurance End 



    
    // Make Start 

    Route::get('/make', [MakeController::class, 'index'])->name('make');
    Route::post('/add-make', [MakeController::class, 'create'])->name('create.make');
    Route::post('/save-make', [MakeController::class, 'store'])->name('store.make');
    Route::post('/list-make', [MakeController::class, 'list'])->name('list.make');
    Route::get('/edit/make/{id}', [MakeController::class, 'edit'])->name('edit.make');
    Route::get('/show/make/{id}', [MakeController::class, 'show'])->name('show.make');
    Route::get('/delete/make/{id}', [MakeController::class, 'delete'])->name('delete.make');
    Route::post('/update-make', [MakeController::class, 'update_data'])->name('update.make'); 

    // Make End 

        
    // Model Start 

    Route::get('/model', [ModelController::class, 'index'])->name('model');
    Route::post('/add-model', [ModelController::class, 'create'])->name('create.model');
    Route::post('/save-model', [ModelController::class, 'store'])->name('store.model');
    Route::post('/list-model', [ModelController::class, 'list'])->name('list.model');
    Route::get('/edit/model/{id}', [ModelController::class, 'edit'])->name('edit.model');
    Route::get('/show/model/{id}', [ModelController::class, 'show'])->name('show.model');
    Route::get('/delete/model/{id}', [ModelController::class, 'delete'])->name('delete.model');
    Route::post('/update-model', [ModelController::class, 'update_data'])->name('update.model'); 

    // Model End 

    
    // Vehicle Document End 

    //Rides Start 

    Route::get('/rides', [RidesController::class, 'index'])->name('rides');
    Route::post('/list-rides', [RidesController::class, 'list'])->name('list.rides');
    Route::get('/assign-driver/rides/{id}', [RidesController::class, 'assignDriver'])->name('assign.driver.rides');
    Route::post('/update-assign-ride', [RidesController::class, 'update_data'])->name('update.assign.rides');

    //Rides End
 
    // Admin start
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/users/create', [AdminController::class, 'create'])->name('users.create');
    Route::post('/users/store', [AdminController::class, 'store'])->name('users.store');
    Route::post('/users/update', [AdminController::class, 'update'])->name('users.update');
    Route::get('/users/edit/{id}', [AdminController::class, 'edit'])->name('users.edit');
    Route::get('/users/view/{id}', [AdminController::class, 'view'])->name('users.view');
    Route::delete('/users/delete/{id}', [AdminController::class, 'destroy'])->name('users.delete');
    Route::post('/users/list', [AdminController::class, 'getUsers'])->name('users.list');
    Route::put('/users/status/{id}', [AdminController::class, 'status'])->name('users.status');
    // Admin end

    // Security Guard Start

    Route::get('/security-guard', [SecurityGuardController::class, 'index'])->name('security.guard');
    Route::get('/add-security-guard', [SecurityGuardController::class, 'create'])->name('create.security.guard');
    Route::get('/show-security-guard/{id}', [SecurityGuardController::class, 'show'])->name('show.security.guard');
    Route::post('/save-security-guard', [SecurityGuardController::class, 'store'])->name('store.security.guard');
    Route::post('/list-security-guard', [SecurityGuardController::class, 'list'])->name('list.security.guard');
    Route::get('/edit/security-guard/{id}', [SecurityGuardController::class, 'edit'])->name('edit.security.guard');
    Route::get('/delete/security-guard/{id}', [SecurityGuardController::class, 'delete'])->name('delete.security.guard');
    Route::post('/update-security-guard', [SecurityGuardController::class, 'update_data'])->name('update.security.guard');
    Route::post('/update-status', [SecurityGuardController::class, 'updateStatus'])->name('udpate.security.status');
    Route::put('/security-guard/status/{id}', [SecurityGuardController::class, 'updateStatus'])->name('security.status');

    // Security Guard End

    // Companies Start

    Route::get('/companies', [CompaniesController::class, 'index'])->name('companies');
    Route::get('/add-companies', [CompaniesController::class, 'create'])->name('create.companies');
    Route::post('/save-companies', [CompaniesController::class, 'store'])->name('store.companies');
    Route::post('/list-companies', [CompaniesController::class, 'list'])->name('list.companies');
    Route::get('/edit/companies/{id}', [CompaniesController::class, 'edit'])->name('edit.companies');
    Route::get('/delete/companies/{id}', [CompaniesController::class, 'delete'])->name('delete.companies');
    Route::post('/update-companies', [CompaniesController::class, 'update_data'])->name('update.companies');
    Route::get('/show-companies/{id}', [CompaniesController::class, 'show'])->name('show.companies'); 
    Route::put('/companies/status/{id}', [CompaniesController::class, 'updateStatus'])->name('companies.status');

    // Companies End

    // vehicle Owner Start
    Route::get('/vehicle-owner', [VehicleOwnerController::class, 'index'])->name('vehicle.owner');
    Route::get('/add-vehicle-owner', [VehicleOwnerController::class, 'create'])->name('create.vehicle.owner');
    Route::post('/save-vehicle-owner', [VehicleOwnerController::class, 'store'])->name('store.vehicle.owner');
    Route::post('/list-vehicle-owner', [VehicleOwnerController::class, 'list'])->name('list.vehicle.owner');
    Route::get('/edit/vehicle-owner/{id}', [VehicleOwnerController::class, 'edit'])->name('edit.vehicle.owner');
    Route::get('/show/vehicle-owner/{id}', [VehicleOwnerController::class, 'show'])->name('show.vehicle.owner');
    Route::get('/delete/vehicle-owner/{id}', [VehicleOwnerController::class, 'delete'])->name('delete.vehicle.owner');
    Route::post('/update-vehicle-owner', [VehicleOwnerController::class, 'update_data'])->name('update.vehicle.owner');
    Route::put('/vehicle-owner/status/{id}', [VehicleOwnerController::class, 'updateStatus'])->name('vehicle.owner.status');
    // vehicle Owner End

});
