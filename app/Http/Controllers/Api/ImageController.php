<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\Image;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class ImageController extends BaseController
{
    public function uploadImage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $file = $request->file('image');

        // Generate a unique file name
        $fileName = Str::random(10) . '.' . $file->getClientOriginalExtension();

        // Define the path where to store the file
        $destinationPath = public_path('/uploads');

        // Move the file to the specified directory
        $file->move($destinationPath, $fileName);

        // Construct the file path
        $filePath = '/uploads/' . $fileName;

        // Save file details to the database
        $image = Image::create([
            'file_name' => $fileName,
            'file_path' => $filePath
        ]);

        // You can also use a storage disk configuration
        // $filePath = Storage::disk('public')->putFileAs('images', $file, $fileName);

        return $this->sendResponse($image, 'Image uploaded successfully.');
    }
    
    public function updateProfileImage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $file = $request->file('image');

        // Generate a unique file name
        $fileName = Str::random(10) . '.' . $file->getClientOriginalExtension();

        // Define the path where to store the file
        $destinationPath = public_path('/uploads');

        // Move the file to the specified directory
        $file->move($destinationPath, $fileName);

        // Construct the file path
        $filePath = '/uploads/' . $fileName;

        // Save file details to the database
        $image = Image::create([
            'file_name' => $fileName,
            'file_path' => $filePath
        ]);
        // print_r($request->user()->id);die;
        $user = User::find($request->user()->id);
        $user->image_id = $image->id;
        $user->save();

        // You can also use a storage disk configuration
        // $filePath = Storage::disk('public')->putFileAs('images', $file, $fileName);

        return $this->sendResponse($image, 'Image uploaded successfully.');
    }
    
    public function updateDriverProfileImage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $file = $request->file('image');

        // Generate a unique file name
        $fileName = Str::random(10) . '.' . $file->getClientOriginalExtension();

        // Define the path where to store the file
        $destinationPath = public_path('/uploads');

        // Move the file to the specified directory
        $file->move($destinationPath, $fileName);

        // Construct the file path
        $filePath = '/uploads/' . $fileName;

        // Save file details to the database
        $image = Image::create([
            'file_name' => $fileName,
            'file_path' => $filePath
        ]);
        $driver = Driver::find($request->user()->id);
        $driver->image_id = $image->id;
        $driver->save();

        // You can also use a storage disk configuration
        // $filePath = Storage::disk('public')->putFileAs('images', $file, $fileName);

        return $this->sendResponse($image, 'Image uploaded successfully.');
    }
}
