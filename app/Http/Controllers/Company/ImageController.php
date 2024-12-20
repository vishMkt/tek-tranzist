<?php
namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Image;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    
    public function imageUpload(Request $request)
    {
        // echo "<pre>";print_r($request->all());die;
        // echo "RRRR";die;
        // Validate the image input
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Ensure that it's an image file with a max size of 2MB
        ]);
    
        // Check if the request contains a file with the key 'image_id'
        if ($request->hasFile('file')) {
            $image = $request->file('file');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            // Move the uploaded image to the public/uploads/employees directory
            $image->move(public_path('uploads/'), $imageName);
    
            // Store the image path in the `images` table
            $uploadimage = Image::create([
                'file_name' => $imageName,
                'file_path' => 'uploads/' . $imageName,
            ]);
    
            // echo "<pre>"; print_r($uploadimage->toArray());die;
            // Return a success response as JSON
            return response()->json([
                'success' => true,
                'message' => 'Image uploaded successfully!',
                'image_url' => asset('uploads/' . $imageName),
                'image_id' => $uploadimage->id
            ]);
        }
    
        // If the image was not uploaded successfully, return an error response
        return response()->json([
            'success' => false,
            'message' => 'No image file found or the upload failed.'
        ], 400);
    }
    

    public function imageUploadback(Request $request)
    {
 
        // echo "RRRR";die;
        // Validate the image input
        $request->validate([
            'file_back' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Ensure that it's an image file with a max size of 2MB
        ]);
        
        // echo "<pre>";print_r($request->hasFile('file_back'));die;
    
        // Check if the request contains a file with the key 'image_id'
        if ($request->hasFile('file_back')) { 
            $image = $request->file('file_back');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            // Move the uploaded image to the public/uploads/employees directory
            $image->move(public_path('uploads/'), $imageName);
    
            // Store the image path in the `images` table
            $uploadimage = Image::create([
                'file_name' => $imageName,
                'file_path' => 'uploads/' . $imageName,
            ]);
    
            // echo "<pre>"; print_r($uploadimage->toArray());die;
            // Return a success response as JSON
            return response()->json([
                'success' => true,
                'message' => 'Image uploaded successfully!',
                'image_url_back' => asset('uploads/' . $imageName),
                'image_id_back' => $uploadimage->id
            ]);
        }
    
        // If the image was not uploaded successfully, return an error response
        return response()->json([
            'success' => false,
            'message' => 'No image file found or the upload failed.'
        ], 400);
    }

}
?>