<?php

namespace App\Http\Controllers\Vendor\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    // protected $guard = 'company';
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::ADMIN;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function showLoginForm()
    {
        return view('vendor.auth.login');
    }

    public function adminLogin(Request $request)
    {
        $request->validate([
            'email'   => 'required|email',
            'password' => 'required|min:6'
        ]);
        if (auth()->guard('vendor')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {
            $response =array('status'=>1);
            return response()->json($response);
        }
        else {
            $m = json_encode(array('password'=>'Email Or Password Is Incorrect'));
			$response =array('status'=>0,'msg'=>$m);
			return response()->json($response);
        }
    }

    public function logout()
    {
        Auth::guard('vendor')->logout();
        return redirect()->route('vendor.login');
    }

}
