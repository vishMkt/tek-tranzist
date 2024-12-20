<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator; 
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Twilio\Rest\Client; 

class UserController extends Controller
{
    public function index()
    {
      $data['nav']= "User";
      return view('user.index',$data);
    }
}
?>