<?php

namespace App\Http\Controllers\Api;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class VehicleController extends BaseController
{
    public function index(Request $request)
    {
        $vehicles = Vehicle::where(['driver_id'=>Auth::guard('driver_api')->id(),'status'=>1])->get();
        return $this->sendResponse($vehicles, 'Vehicles retrieved successfully.');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'make' => 'required|string',
            'model' => 'required|string',
            'year' => 'required|integer',
            'license_plate' => 'required|string|unique:vehicles'
        ]);
        if($validator->fails()){ 
            return $this->sendResponse(null,'Validation Error.', $validator->errors() ,200,false);      
        }

        $vehicle = Vehicle::create([
            "make"=> $request->make,
            "model"=>$request->model,
            "year"=>$request->year,
            "license_plate"=>$request->license_plate,
            "driver_id"=>Auth::guard('driver_api')->id(),
            "status"=>1,
        ]);
        
        return $this->sendResponse($vehicle, 'Add Vehicle successfully.');
    }

    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'make' => 'sometimes|required|string',
            'model' => 'sometimes|required|string',
            'year' => 'sometimes|required|integer',
            'license_plate' => 'sometimes|required|string|unique:vehicles,license_plate,' . $id,
        ]);
        if($validator->fails()){ 
            return $this->sendResponse(null,'Validation Error.', $validator->errors() ,200,false);      
        }


        $vehicle = Vehicle::where('id',$id);
        $vehicle->where('driver_id',Auth::guard('driver_api')->id());
        $vehicle->update([
            "make"=> $request->make,
            "model"=>$request->model,
            "year"=>$request->year,
            "license_plate"=>$request->license_plate,
            "status"=>1,
        ]);
        
        return $this->sendResponse($vehicle->first(), 'Vehicle update successfully.');
    }

    public function show($id)
    {
        
        $vehicle = Vehicle::where('id',$id);
        $vehicle->where('driver_id',Auth::guard('driver_api')->id());
        return $this->sendResponse($vehicle->first(), 'Show Vehicle.');

    }

}