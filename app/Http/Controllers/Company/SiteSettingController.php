<?php
namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\siteSetting; 
use Illuminate\Http\Request; 

class SiteSettingController extends Controller
{

    public function index()
    {
      $nav = "Site Setting"; 
      $uinfo = SiteSetting::where('id',1)->first(); 
      return view('company.site_setting.edit',compact('nav','uinfo'));
    } 
    
public function update_data(Request $request)
{  
  
    $request->validate([  
        'name' => 'required',
        'email' => 'required|max:255',
        'contact' => 'required|numeric', 
        'image_id' => 'required', 
        'image_id_back' => 'required', 
    ]);
 
    $license = SiteSetting::find(1); 
    $license->name = $request->name;
    $license->email = $request->email;
    $license->contact = $request->contact; 
    $license->logo = $request->image_id;  
    $license->fav_icon = $request->image_id_back;  
    $license->save();
 
    return response()->json(['status' => 1, 'message' => 'Site Setting updated successfully']);
}  
}
?>